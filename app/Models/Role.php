<?php

namespace App\Models;

use App\Enums\RoleStatus;

class Role extends BaseModel
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => RoleStatus::ACTIVE,
        'abilities' => [],
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => RoleStatus::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'temple',
        'status',
        'role',
        'abilities',
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array<int, string>
     */
    protected $filterable = [
        'temple',
        'role',
        'status',
        'abilities'
    ];

    // temple {
    //     _id
    //     name
    // }
    // status
    // role
    // abilities
}
