<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Http\Requests\ParticipateEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Temple;
use App\Models\User;
use App\ValueObjects\Event as EventValueObject;
use App\ValueObjects\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\BSON\UTCDateTime;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return $this->simplePaginate(Event::filter($request->all()), EventResource::class);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        if ($request->validated('temple_id')) {
            $temple = Temple::find($request->validated('temple_id'), ['_id', 'name', 'addresses', 'social_medias']);
            $data['temple'] = [
                '_id' => $temple->_id,
                'name' => $temple->name,
                'address' => collect($temple->addresses)->first(),
                'social_medias' => $temple->social_medias,
            ];
        }

        $event = Event::create($data);

        if ($event->temple) {
            $temple->push('events', (new EventValueObject($event->toArray()))->toArray());
            $temple->increment('count_events');
        }

        return ['data' => new EventResource($event)];
    }

    public function show(Event $event)
    {
        return ['data' => new EventResource($event)];
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        return ['data' => new EventResource(tap($event)->update($request->validated()))];
    }

    public function destroy(Event $event)
    {
        //  remove event from users
        if ($event->participants) {
            foreach ($event->participants->whereNotNull('_id') as $participant) {
                $user = User::find($participant->_id);
                if ($user) {
                    $user->pull('events', ['_id' => (string) $event->_id]);
                    $user->decrement('count_events');
                }
            }
        }

        //  remove event from temple
        if ($event->temple) {
            $temple = Temple::find($event->temple->_id);
            $temple->pull('events', ['_id' => (string) $event->_id]);
            $temple->decrement('count_events');
        }
        
        return ['data' => ['success' => $event->delete()]];
    }

    /**
     * Join the event
     */
    public function participate(ParticipateEventRequest $request, Event $event)
    {
        $user = Auth::user();

        if (collect($event->participants)->where('username', Auth::user()->username)->count()) {
            return $this->error(trans('errors.events.participants.exists'));
        }

        //  check if participation has ended
        if (Carbon::now()->lte($event->participation_end_at) || $event->status != EventStatus::PLANNED) {
            return $this->error(trans('errors.events.status.ended'));
        }

        //  check if participation is not started yet
        if (Carbon::now()->lte($event->participation_start_at)) {
            return $this->error(trans('errors.events.status.not_started'));
        }

        //  check the participate condition
        if ($event->participation_conditions && ! $event->isParticipantEligible($user)) {
            return $this->error(trans('errors.events.participants.not_eligible'));
        }

        //  check the bundle condition
        if ($request->bundle_code) {
            $bundlePrice = $event->bundles->where('code', $request->bundle_code)->min('price');

            if ($user->balance < $bundlePrice) {
                return $this->error(trans('errors.users.balance.insufficient'));
            }
        }
        
        //  push to user's event
        $user->push('events', [(new EventValueObject($event->toArray()))->toArray()]);
        $user->increment('count_events');

        //  push to event's participant
        $user->roles = [];
        $user->joined_at = new UTCDateTIme();
        $event->push('participants', (new Member($user->toArray()))->toArray());
        $event->increment('count_participants');

        return ['data' => ['success' => true]];
    }

    /**
     * Leave the event
     */
    public function leave(Event $event)
    {
        $user = Auth::user();

        if (! collect($event->participants)->where('username', Auth::user()->username)->count()) {
            return $this->error(trans('errors.events.participants.not_exists'));
        }
        
        //  pull from user's event
        $user->decrement('count_events');
        $user->pull('events', ['_id' => $event->_id]);

        //  pull from event's participant
        $event->decrement('count_participants');
        $event->pull('participants', ['username' => $user->username]);

        return ['data' => ['success' => true]];
    }

    public function addGallery()
    {

    }

    public function dropGallery()
    {
        
    }
}
