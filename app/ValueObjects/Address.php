<?php
 
namespace App\ValueObjects;
 
use Illuminate\Contracts\Database\Eloquent\Castable;
use App\Casts\Address as AddressCast;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class Address implements Castable, JsonSerializable
{
    public $url;
    public $street;
    public $city;
    public $province;
    public $country;
    public $note;

    public function __construct(array $attributes)
    {
        $this->url = $attributes['url'] ?? null;
        $this->street = $attributes['street'] ?? null;
        $this->city = $attributes['city'] ?? null;
        $this->province = $attributes['province'] ?? null;
        $this->country = $attributes['country'] ?? null;
        $this->note = $attributes['note'] ?? null;
    }

    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return class-string<CastsAttributes|CastsInboundAttributes>|CastsAttributes|CastsInboundAttributes
     */
    public static function castUsing(array $arguments) 
    {
        return AddressCast::class;
    }

    /**
     * Convert the batch to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'url' => $this->url,
            'street' => $this->street,
            'city' => $this->city,
            'province' => $this->province,
            'country' => $this->country,
            'note' => $this->note,
        ];
    }

    /**
     * Get the JSON serializable representation of the object.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}