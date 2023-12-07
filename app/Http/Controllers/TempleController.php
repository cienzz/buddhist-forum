<?php

namespace App\Http\Controllers;

use App\Enums\RoleAbility;
use App\Http\Requests\PatchTempleMemberRolesRequest;
use App\Http\Requests\StoreTempleRequest;
use App\Http\Requests\UpdateTempleRequest;
use App\Http\Resources\TempleResource;
use App\Models\Temple;
use App\ValueObjects\Member;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\BSON\UTCDateTime;

class TempleController extends Controller
{
    public function index(Request $request)
    {
        return $this->simplePaginate(Temple::filter($request->all()), TempleResource::class);
    }

    public function store(StoreTempleRequest $request)
    {
        return ['data' => new TempleResource(Temple::create($request->validated()))];
    }

    public function show(Temple $temple)
    {
        return ['data' => new TempleResource($temple)];
    }

    public function update(UpdateTempleRequest $request, Temple $temple)
    {
        return ['data' => new TempleResource(tap($temple)->update($request->validated()))];
    }

    public function destroy(Temple $temple)
    {
        if (! Auth::user()->currentAccessToken()->canAny(RoleAbility::TEMPLE_DELETE->value, RoleAbility::TEMPLE_DELETE->value.':'.$temple->_id)) {
            throw new AuthorizationException();
        }

        return ['data' => ['success' => $temple->delete()]];
    }

    /**
     * Join the temple as a member
     */
    public function follow(Temple $temple)
    {
        $user = Auth::user();

        if (collect($temple->members)->where('username', $user->username)->first()) {
            return $this->error(trans('errors.temples.members.exists'));
        }
        
        //  push to user's temple
        $user->increment('count_temples');
        $user->push('temples', [
            '_id' => $temple->id,
            'name' => $temple->name
        ], true);

        //  push to temple's member
        $user->roles = [];
        $user->joined_at = new UTCDateTime();
        $temple->push('members', (new Member($user->toArray()))->toArray());
        $temple->increment('count_members');

        return ['data' => ['success' => true]];
    }

    /**
     * Leave the temple
     */
    public function unfollow(Temple $temple)
    {
        $user = Auth::user();

        if (! collect($temple->members)->where('username', $user->username)->count()) {
            return $this->error(trans('errors.temples.members.not_exists'));
        }
        
        //  pull from user's temple
        $user->decrement('count_temples');
        $user->pull('temples', ['_id' => $temple->id]);

        //  pull from temple's member
        $temple->decrement('count_members');
        $temple->pull('members', ['username' => $user->username]);

        return ['data' => ['success' => true]];
    }

    public function patchMemberRoles(PatchTempleMemberRolesRequest $request, Temple $temple, $member)
    {
        if (! collect($temple->members)->where('username', $member)->count()) {
            return $this->error(trans('errors.temples.members.not_exists'));
        }

        return ['data' => [
            'success' => (boolean) $temple->where('members.username', 'mokilo')->update(['members.$.roles' => $request->roles])
        ]];
    }
}
