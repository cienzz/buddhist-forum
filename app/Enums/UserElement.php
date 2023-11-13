<?php

namespace App\Enums;

use Carbon\Carbon;

enum UserElement: string
{
    case METAL  = 'metal';
    case WATER  = 'water';
    case WOOD   = 'wood';
    case FIRE   = 'fire';
    case EARTH  = 'earth';

    public static function getElementByDate($date)
    {
        $date = Carbon::parse($date);
        $lastDigitOfYear = substr($date->year, -1, 1);

        if (in_array($lastDigitOfYear, ['0', '1'])) {
            return self::METAL;
        } else if (in_array($lastDigitOfYear, ['2', '3'])) {
            return self::WATER;
        } else if (in_array($lastDigitOfYear, ['4', '5'])) {
            return self::WOOD;
        } else if (in_array($lastDigitOfYear, ['6', '7'])) {
            return self::FIRE;
        } else if (in_array($lastDigitOfYear, ['8', '9'])) {
            return self::EARTH;
        }
    }
}