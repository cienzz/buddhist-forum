<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserElement;
use App\Enums\UserGender;
use App\Enums\UserRole;
use App\Enums\UserShio;
use App\Enums\UserStatus;
use App\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\Casts\ObjectId;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => UserStatus::ACTIVE,
        'role' => UserRole::USER
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'phone_number_verified_at' => 'datetime',
        'login_at' => 'datetime',
        'password' => 'hashed',
        'status' => UserStatus::class,
        'role' => UserRole::class,
        'gender' => UserGender::class,
        'shio' => UserShio::class,
        'element' => UserElement::class,
        'temples.*._id' => ObjectId::class
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'status',
        'role',
        'gender',
        'birth_at',
        'address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    // username
    // password
    // status
    // role
    // email
    // email_verified_at
    // phone_number
    // phone_number_verified_at
    // gender
    // zodiac
    // shio
    // element
    // birth_at
    // address [
    //     city
    //     province
    //     country
    // ]
    // login_at
    // ips
    // count_temples
    // temples [
    //     {
    //         _id
    //         name
    //     }
    // ]
    // count_events
    // events [
    //     {
    //         _id
    //         name
    //         start_at
    //         end_at
    //     }
    // ]
}
