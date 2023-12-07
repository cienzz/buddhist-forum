<?php
 
namespace App\ValueObjects;
 
use Illuminate\Contracts\Database\Eloquent\Castable;
use App\Casts\Temple as TempleCast;
use JsonSerializable;

class Temple implements Castable, JsonSerializable
{
    public $_id;
    public $name;
    public $address;
    public $social_medias;

    public function __construct($attributes)
    {
        $this->_id = isset($attributes['_id']) ? (string) $attributes['_id'] : null;
        $this->name = $attributes['name'] ?? null;
        $this->address = isset($attributes['address']) 
            ? ((! $attributes['address'] instanceof Address) ? new Address($attributes['address']) : $attributes['address']) 
            : null;
        $this->social_medias = $attributes['social_medias'] ?? null;
    }

    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return class-string<CastsAttributes|CastsInboundAttributes>|CastsAttributes|CastsInboundAttributes
     */
    public static function castUsing(array $arguments) 
    {
        return TempleCast::class;
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
            'name' => $this->name,
            'address' => $this->address ? $this->address->toArray() : null,
            'social_medias' => $this->social_medias,
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