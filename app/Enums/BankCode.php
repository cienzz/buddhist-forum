<?php

namespace App\Enums;

enum BankCode: string
{
    case BCA        = 'bca';
    case BNI        = 'bni';
    case BRI        = 'bri';
    case MANDIRI    = 'mandiri';
    case PERMATA    = 'permata';
}