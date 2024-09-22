<?php

namespace App\Services;

use App\Models\User;

class AuthServices
{
    public function generateUsername()
    {
        $basedUsername = preg_replace('/[\s_]+/', '', strtolower(request()->input('first_name') . request()->input('last_name')));
        $username = $basedUsername;
        $characters = 'abcdefghijklmnopqrstuvwxyz';

        $pin = mt_rand(1, 9)
            . mt_rand(1, 9)
            . $characters[rand(0, strlen($characters) - 1)]
            . $characters[rand(0, strlen($characters) - 1)];
        $string = str_shuffle($pin);
        while (User::where('username', $username)->exists()) {
            $username = $basedUsername . $string;
        }
        return $username;
    }
}
