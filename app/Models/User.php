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
use MongoDB\Laravel\Eloquent\Builder;

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
        'roles' => [UserRole::USER]
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
        'gender' => UserGender::class,
        'shio' => UserShio::class,
        'element' => UserElement::class,
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
        'roles',
        'gender',
        'birth_at',
        'address'
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array<int, string>
     */
    protected $filterable = [
        'username',
        'status',
        'roles',
        'email',
        'email_verified_at',
        'phone_number',
        'phone_number_verified_at',
        'gender',
        'zodiac',
        'shio',
        'element',
        'birth_at',
        'address',
        'login_at',
        'ips',
        'temples',
        'events'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 25;

    public function abilities(): array
    {
        //  get abilities from general role
        $abilities = collect(
            Role::whereNull('temple_id')
                ->whereIn('role', $this->roles)
                ->value('abilities'));

        //  get abilities from user temple's roles
        foreach (collect($this->temples) as $temple) {
            $roles = Role::where('temple_id', $temple['_id'])
                         ->where('role', $temple['role'] ?? 'member')
                         ->value('abilities');

            if ($roles) {
                $abilities->merge(
                    collect($roles)->map(function($ability) use ($temple) {
                        return $ability.':'.$temple['_id'];
                    }));
            }
        }

        return $abilities->toArray();
    }

    /**
     * It takes a request object, and filters the query based on the request parameters
     * 
     * @param Builder query The query builder instance
     * @param mixed data
     * 
     * @return Builder A query builder object
     */
    public function scopeFilter(Builder $query, $data) 
    {
        $params = collect($data)->only($this->getFilterable());

        foreach($params as $field => $param) {
            $operator = isset($param['operator']) ? $param['operator'] : '=';
            
            if (isset($param['value'])) {
                if (is_array($param['value'])) {
                    $value = [];
                    foreach($param['value'] as $temp) {
                        $value[] = $this->transformModelValue($field, $temp);
                    }
                } else {
                    $value = $this->transformModelValue($field, $param['value']);
                }
            } else {
                $value = $this->transformModelValue($field, $param);
            }

            if ($operator == 'in') {
                $query->whereIn($field, collect($value)->toArray());
            } else if ($operator == 'between') {
                $query->whereBetween($field, collect($value)->toArray());
            } else {
                $query->where($field, $operator, $value);
            }
        }
    }

    protected function getFilterable(): array
    {
        return array_merge([$this->getKeyName()], $this->getDates(), $this->filterable);
    }

    // username
    // password
    // status
    // roles
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
