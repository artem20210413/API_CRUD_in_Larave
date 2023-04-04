<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    public function sanctumToken(AuthRequest $request, AuthService $authService)
    {
        return $authService->createToken($request);


    }

}