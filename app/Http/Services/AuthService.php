<?php

namespace App\Http\Services;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    // If validation is passed, service gets array with validated data
    public function login($validated) {

        $email = $validated['email'];
        $password = $validated['password'];
        $user = $this->getUser($email, $password);
        if (!$user)
            return false;

        return $user->createToken('access_token')->plainTextToken;

    }

    // Check if user with given email exists in database and retrieve it if it does
    public function getUser($email, $password) {

        $user = User::query()->where('email', $email)->first();

        if ($user && Hash::check($password, $user->password))
            return $user;
        else
            return null;

    }

    // Delete all tokens for currently authenticated user
    public function logout() {

        auth()->user()->tokens()->delete();

    }

}
