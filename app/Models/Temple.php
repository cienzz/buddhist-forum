<?php

namespace App\Models;

use App\Casts\TempleMember;
use App\Enums\TempleStatus;
use Carbon\Carbon;

class Temple extends BaseModel
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => TempleStatus::ACTIVE,
        'phone_numbers' => [],
        'emails' => [],
        'tags' => [],
        'open_times' => [],
        'addresses' => [],
        'social_medias' => [],
        'banks' => [],
        'members' => [],
        'events' => [],
        'galleries' => [],
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => TempleStatus::class,
        'members' => TempleMember::class
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'phone_numbers',
        'emails',
        'website_url',
        'tags',
        'open_times',
        'addresses',
        'members',
        'social_medias',
        'banks'
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array<int, string>
     */
    protected $filterable = [
        'name',
        'status',
        'tags'
    ];

    public function isOpen(): bool
    {
        $currentDate = Carbon::now();
        $day = $currentDate->englishDayOfWeek;
        $openTime = collect($this->open_times)->where('day', $day)->first();
        if ($openTime) {
            $startDate = Carbon::parse($openTime['hours'][0]);
            $endDate = Carbon::parse($openTime['hours'][1]);

            if ($currentDate->gte($startDate) && $currentDate->lt($endDate)) {
                return true;
            }
        }

        return false;
    }

    // name
    // description
    // status
    // phone_numbers
    // emails
    // website_url
    // tags
    // open_times [
    //     {
    //         day
    //         hours
    //     }
    // ]
    // addresses [
    //     {
    //         url
    //         coordinate
    //         street
    //         city
    //         province
    //         country
    //         note
    //     }
    // ]
    // social_medias
    // banks [
    //     {
    //         code
    //         account_name
    //         account_number
    //         active
    //     }
    // ]
    // count_members
    // members [
    //     {
    //         name
    //         phone_number
    //         email
    //         role
    //         role_order
    //     }
    // ]
    // count_events
    // events [
    //     {
    //         _id
    //         name
    //         start_at
    //         end_at
    //         contacts [
    //             {
    //                 name
    //                 phone_number
    //                 email
    //             }
    //         ]
    //     }
    // ]
    // count_galleries
    // galleries [
    //     {
    //         type
    //         url
    //     }
    // ]
}
