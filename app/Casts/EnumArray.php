<?php

namespace App\Casts;

use BackedEnum;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;

class EnumArray implements CastsAttributes
{
    protected $argument;

    public function __construct(string $argument)
    {
        $this->argument = $argument;
    }

    public function get($model, $key, $value, $attributes)
    {
        if (! isset($attributes[$key]) || is_null($attributes[$key])) {
            return;
        }

        if (! is_array($value)) {
            return;
        }

        $enumClass = $this->argument;

        return (new Collection($value))->map(function ($val) use ($enumClass) {
            return is_subclass_of($enumClass, BackedEnum::class)
                ? $enumClass::from($val)
                : constant($enumClass.'::'.$val);
        })->toArray();
    }

    public function set($model, $key, $value, $attributes)
    {
        if ($value === null) {
            return [$key => null];
        }

        $storable = [];

        foreach ($value as $enum) {
            $storable[] = $this->getStorableEnumValue($enum);
        }

        return [$key => $storable];
    }

    public function serialize($model, string $key, $value, array $attributes)
    {
        return (new Collection($value))->map(function ($enum) {
            return $this->getStorableEnumValue($enum);
        })->toArray();
    }

    protected function getStorableEnumValue($enum)
    {
        if (is_string($enum) || is_int($enum)) {
            return $enum;
        }

        return $enum instanceof BackedEnum ? $enum->value : $enum->name;
    }
}
