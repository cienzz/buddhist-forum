<?php

namespace App\Observers;

use App\Enums\UserElement;
use App\Enums\UserShio;
use App\Enums\UserZodiac;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        //  check zodiac and shio if birth date changed
        if ($user->birth_at) {
            $user->zodiac = UserZodiac::getZodiacByDate($user->birth_at);
            $user->shio = UserShio::getShioByDate($user->birth_at);
            $user->element = UserElement::getElementByDate($user->birth_at);
        }
    }
}
