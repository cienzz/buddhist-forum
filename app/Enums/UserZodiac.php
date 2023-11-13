<?php

namespace App\Enums;

use Carbon\Carbon;

enum UserZodiac: string
{
    case ARIES          = 'aries';
    case TAURUS         = 'taurus';
    case GEMINI         = 'gemini';
    case CANCER         = 'cancer';
    case LEO            = 'leo';
    case VIRGO          = 'virgo';
    case LIBRA          = 'libra';
    case SCORPIO        = 'scorpio';
    case SAGITTARIUS    = 'sagittarius';
    case CAPRICORN      = 'capricorn';
    case AQUARIUS       = 'aquarius';
    case PISCES         = 'pisces';

    public static function getZodiacByDate($date)
    {
        $date = Carbon::parse($date);
        $month = $date->month;
        $day = $date->day;

        if (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) { 
            return self::CAPRICORN; 
        } else if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) { 
            return self::AQUARIUS; 
        } else if (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) { 
            return self::PISCES; 
        } else if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) { 
            return self::ARIES; 
        } else if (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) { 
            return self::TAURUS; 
        } else if (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) { 
            return self::GEMINI; 
        } else if (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) { 
            return self::CANCER; 
        } else if (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) { 
            return self::LEO; 
        } else if (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) { 
            return self::VIRGO; 
        } else if (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) { 
            return self::LIBRA; 
        } else if (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) { 
            return self::SCORPIO; 
        } else if (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) { 
            return self::SAGITTARIUS; 
        }
    }
}