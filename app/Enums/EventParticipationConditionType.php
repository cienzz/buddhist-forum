<?php

namespace App\Enums;

enum EventParticipationConditionType: string
{
    case MEMBER_ONLY    = 'member_only';
    case USER_AGE       = 'user_age';
    case USER_GENDER    = 'user_gender';
    case USER_TAGS      = 'user_tags';
}