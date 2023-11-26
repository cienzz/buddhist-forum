<?php

namespace App\Models;

use App\Casts\ObjectCollection;
use App\Enums\EventParticipationConditionType;
use App\Enums\EventStatus;
use App\ValueObjects\Address;
use App\ValueObjects\Member;
use App\ValueObjects\Temple;

class Event extends BaseModel
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => EventStatus::class,
        'temple' => Temple::class,
        'address' => Address::class,
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'participate_start_at' => 'datetime',
        'participate_end_at' => 'datetime',
        'participants' => ObjectCollection::class.':'.Member::class,
        'min_participant' => 'integer',
        'max_participant' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'cover_image_url',
        'cover_image_path',
        'tags',
        'start_at',
        'end_at',
        'temple',
        'address',
        'streaming_urls',
        'guests',
        'hosts',
        'participate_start_at',
        'participate_end_at',
        'participate_conditions',
        'bundles',
        'contacts',
        'created_by'
    ];

    /**
     * Check if participant elligible to join an event
     */
    public function isParticipantEligible(User $user): bool
    {
        $status = [true];

        foreach ($this->participate_conditions as $condition) {
            switch ($condition->type) {
                case EventParticipationConditionType::MEMBER_ONLY :
                    $status[] = Temple::where('_id', $this->temple->_id)->where('members.username', $user->username)->exists();
                    break;
                case EventParticipationConditionType::USER_AGE :
                    $status[] = $this->evaluate($user->birth_at->age, $condition->type, $condition->value);
                    break;
                case EventParticipationConditionType::USER_GENDER :
                    $status[] = $this->evaluate($user->gender, $condition->type, $condition->value);
                    break;
                case EventParticipationConditionType::USER_TAGS :
                    $status[] = array_intersect(collect($condition->value)->toArray(), $user->tags);
                    break;
                default:
                    break;
            }
        }

        return ! in_array(false, $status);
    }

    private function evaluate($value, $operator, $goal): bool
    {
        return (boolean) eval("return ({$value} {$operator} {$goal});");
    }

    // name
    // description
    // cover_image_url
    // cover_image_path
    // status
    // tags
    // start_at
    // end_at
    // temple {
    //     _id
    //     name
    //     address {
    //         url
    //         coordinate
    //         street
    //         city
    //         province
    //         country
    //         note 
    //     }
    // }
    // address {
    //     url
    //     coordinate
    //     street
    //     city
    //     province
    //     country
    //     note
    // }
    // streaming_urls
    // guests
    // hosts
    // participate_start_at
    // participate_end_at
    // participants
    // participate_conditions [
    //     {
    //         type
    //         operator
    //         value
    //     }
    // ]
    // min_participant
    // max_participant
    // bundles [
    //     [
    //         code
    //         name
    //         description
    //         price
    //         cancelable
    //     ]
    // ]
    // contacts [
    //     {
    //         username
    //         phone_number
    //         email
    //     }
    // ]
    // partners [
    //     name
    //     url
    //     image_url
    //     phone_number
    //     email
    // ]
    // sponsors [
    //     name
    //     url
    //     image_url
    //     phone_number
    //     email
    // ]
    // created_by
    // gallery_path
}