<?php

namespace App;

use App\Models\User;

class SessionSetter
{

    public static function DestroySession(): void
    {
        session_destroy();
    }

    public static function SetUser(User $user): void
    {
        $_SESSION['id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['password'] = $user->getPassword();
        $_SESSION['access'] = $user->getAccess();
    }

}