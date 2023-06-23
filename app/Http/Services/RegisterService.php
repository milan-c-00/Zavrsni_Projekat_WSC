<?php

namespace App\Http\Services;

use App\Models\User;

class RegisterService
{

    // Return user created with validated request data
    public function register($request) {

        return User::query()->create($request);

    }

}
