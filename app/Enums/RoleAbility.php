<?php

namespace App\Enums;

enum RoleAbility: string
{
    case ALL            = '*';

    case USER_VIEW      = 'user:view';
    case USER_UPDATE    = 'user:update';

    case TEMPLE_VIEW    = 'temple:view';
    case TEMPLE_CREATE  = 'temple:create';
    case TEMPLE_UPDATE  = 'temple:update';
    case TEMPLE_DELETE  = 'temple:delete';

    case ROLE_VIEW      = 'role:view';
    case ROLE_CREATE    = 'role:create';
    case ROLE_UPDATE    = 'role:update';
    case ROLE_DELETE    = 'role:delete';

    case EVENT_VIEW      = 'event:view';
    case EVENT_CREATE    = 'event:create';
    case EVENT_UPDATE    = 'event:update';
    case EVENT_DELETE    = 'event:delete';

    public static function menus(): array
    {
        return [
            ['group' => 'temple', 'ability' => self::TEMPLE_VIEW->value, 'description' => trans('roles.temple.view')],
            ['group' => 'temple', 'ability' => self::TEMPLE_CREATE->value, 'description' => trans('roles.temple.create')],
            ['group' => 'temple', 'ability' => self::TEMPLE_UPDATE->value, 'description' => trans('roles.temple.update')],
            ['group' => 'temple', 'ability' => self::TEMPLE_DELETE->value, 'description' => trans('roles.temple.delete')],

            ['group' => 'role', 'ability' => self::ROLE_VIEW->value, 'description' => trans('roles.role.view')],
            ['group' => 'role', 'ability' => self::ROLE_CREATE->value, 'description' => trans('roles.role.create')],
            ['group' => 'role', 'ability' => self::ROLE_UPDATE->value, 'description' => trans('roles.role.update')],
            ['group' => 'role', 'ability' => self::ROLE_DELETE->value, 'description' => trans('roles.role.delete')],

            ['group' => 'event', 'ability' => self::EVENT_VIEW->value, 'description' => trans('roles.event.view')],
            ['group' => 'event', 'ability' => self::EVENT_CREATE->value, 'description' => trans('roles.event.create')],
            ['group' => 'event', 'ability' => self::EVENT_UPDATE->value, 'description' => trans('roles.event.update')],
            ['group' => 'event', 'ability' => self::EVENT_DELETE->value, 'description' => trans('roles.event.delete')],
        ];
    }

    public static function privateMenus(): array
    {
        return collect(self::menus())->whereIn('ability', self::private())->values()->toArray();
    }

    public static function private(): array
    {
        return [
            self::TEMPLE_VIEW->value,
            self::TEMPLE_UPDATE->value,
            self::ROLE_VIEW->value,
            self::ROLE_CREATE->value,
            self::ROLE_UPDATE->value,
            self::ROLE_DELETE->value,
            self::EVENT_VIEW->value,
            self::EVENT_CREATE->value,
            self::EVENT_UPDATE->value,
            self::EVENT_DELETE->value,
        ];
    }
}