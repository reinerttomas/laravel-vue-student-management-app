<?php

declare(strict_types=1);

use App\Models\User;

if (! function_exists('user')) {
    function user(?string $guard = null): User
    {
        $user = auth($guard)->user();

        if (! $user instanceof User) {
            throw new RuntimeException('User not authenticated.');
        }

        return $user;
    }
}
