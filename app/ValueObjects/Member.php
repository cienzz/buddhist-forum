<?php
 
namespace App\ValueObjects;
 
use Illuminate\Contracts\Database\Eloquent\Castable;
use App\Casts\Member as MemberCast;
use Carbon\Carbon;
use JsonSerializable;
use MongoDB\BSON\UTCDateTime;

class Member implements Castable, JsonSerializable
{
    public $_id;
    public $username;
    public $phone_number;
    public $email;
    public $url;
    public $image_url;
    public $roles;
    public $joined_at;

    public function __construct(array $attributes)
    {
        $this->_id = isset($attributes['_id']) ? (string) $attributes['_id'] : null;
        $this->username = $attributes['username'] ?? null;
        $this->phone_number = $attributes['phone_number'] ?? null;
        $this->email = $attributes['email'] ?? null;
        $this->url = $attributes['url'] ?? null;
        $this->image_url = $attributes['image_url'] ?? null;
        $this->roles = $attributes['roles'] ?? null;
        $this->joined_at = isset($attributes['joined_at']) ? Carbon::parse($attributes['joined_at']->toDateTime()) : null;
    }

    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return class-string<CastsAttributes|CastsInboundAttributes>|CastsAttributes|CastsInboundAttributes
     */
    public static function castUsing(array $arguments) 
    {
        return MemberCast::class;
    }

    /**
     * Convert the batch to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            '_id' => $this->_id,
            'username' => $this->username,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'roles' => $this->roles,
            'joined_at' => $this->joined_at ? new UTCDateTime($this->joined_at) : null,
        ];
    }

    /**
     * Get the JSON serializable representation of the object.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $data = $this->toArray();
        $data['joined_at'] = $this->joined_at;
        return $data;
    }
}