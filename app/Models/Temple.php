<?php

namespace App\Models;

use App\Casts\ObjectCollection;
use App\Enums\TempleStatus;
use App\ValueObjects\Address;
use App\ValueObjects\Event;
use App\ValueObjects\Member;
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
        'addresses' => ObjectCollection::class.':'.Address::class,
        'members' => ObjectCollection::class.':'.Member::class,
        'count_members' => 'integer',
        'events' => ObjectCollection::class.':'.Event::class,
        'count_events' => 'integer',
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
    // profile_image_url
    // profile_image_path
    // cover_image_url
    // cover_image_path
    // open_times [
    //     {
    //         day
    //         hours
    //     }
    // ]
    // addresses
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
    // members
    // count_events
    // events
    // count_galleries
    // gallery_path
}
