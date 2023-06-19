<?php

namespace App\Http\Services;

use App\Models\User;

class RegisterService
{

    public function register($request) {

        return User::query()->create($request);

    }

}
