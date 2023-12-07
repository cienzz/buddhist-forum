<?php

namespace App\Casts;

use App\ValueObjects\Event;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ObjectCollection implements CastsAttributes
{
    protected $argument;

    public function __construct(string $argument)
    {
        $this->argument = $argument;
    }

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (isset($this->argument)) {
            $objectClass = $this->argument;

            return (new Collection($value))->map(function ($val) use ($objectClass, $attributes) {
                return new $objectClass($val);
            });
        } else {
            return new Collection($value);
        }
        
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof ObjectCollection) {
            if (isset($this->argument)) {
                $objectClass = $this->argument;
    
                $value = (new Collection($value))->map(function ($val) use ($objectClass) {
                    if (! $val instanceof $objectClass) {
                        $val = new $objectClass($val);
                    }

                    return $val->toArray();
                    
                });
            } else {
                $value = new Collection($value);
            }
        }
        
        return [$key => $value->toArray()];
    }
}
