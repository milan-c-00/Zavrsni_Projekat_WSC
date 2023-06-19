<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\RegisterService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RegisterController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService) {

        $this->registerService = $registerService;

    }

    public function register(RegisterRequest $request) {

        $user = $this->registerService->register($request->validated());

        if (!$user)
            return response(['message' => 'Invalid request'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response($user, ResponseAlias::HTTP_CREATED);

    }


}
