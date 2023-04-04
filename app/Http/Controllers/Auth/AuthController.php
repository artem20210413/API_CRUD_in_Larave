<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Services\Auth\UsersService;

class AuthController extends Controller
{
    public function sanctumToken(UsersRequest $request, UsersService $authService)
    {
        return $authService->createToken($request);


    }

}
