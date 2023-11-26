<?php
 
namespace App\ValueObjects;
 
use Illuminate\Contracts\Database\Eloquent\Castable;
use App\Casts\Event as EventCast;
use App\Casts\ObjectCollection;
use App\Models\User;
use Carbon\Carbon;
use JsonSerializable;
use MongoDB\BSON\UTCDateTime;

class Event implements Castable, JsonSerializable
{
    public $_id;
    public $name;
    public $start_at;
    public $end_at;
    public $contacts;

    public function __construct(array $attributes)
    {
        $this->_id = isset($attributes['_id']) ? (string) $attributes['_id'] : null;
        $this->name = $attributes['name'] ?? null;
        $this->start_at = isset($attributes['start_at']) ? $this->parseDate($attributes['start_at']) : null;
        $this->end_at = isset($attributes['end_at']) ? $this->parseDate($attributes['end_at']) : null;
        $this->contacts = isset($attributes['contacts']) 
            ? (new ObjectCollection(Member::class))->get(new User(), 'contacts', $attributes['contacts'], $attributes)
            : null;
    }

    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return class-string<CastsAttributes|CastsInboundAttributes>|CastsAttributes|CastsInboundAttributes
     */
    public static function castUsing(array $arguments) 
    {
        return Event::class;
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
            'start_at' => new UTCDateTime($this->start_at),
            'end_at' => new UTCDateTime($this->end_at),
            'contacts' => isset($this->contacts) 
                ? (new ObjectCollection(Member::class))->set(new User(), 'contacts', $this->contacts, [])['contacts']
                : null,
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
        $data['start_at'] = $this->start_at;
        $data['end_at'] = $this->end_at;
        return $data;
    }

    protected function parseDate($date)
    {
        if ($date instanceof UTCDateTime) {
            return Carbon::parse($date->toDateTime());
        } else if ($date instanceof Carbon) {
            return $date;
        }

        return Carbon::parse($date);
    }
}