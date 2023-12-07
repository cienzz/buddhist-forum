<?php

namespace App\Enums;

enum EventStatus: string
{
    case PLANNED    = 'planned';
    case ONGOING    = 'ongoing';
    case CANCELED   = 'canceled';
    case ENDED      = 'ended';
}