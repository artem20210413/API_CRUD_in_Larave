<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\UsersCreatedRequest;
use App\Services\Auth\UsersService;
use Illuminate\Http\Client\Request;

class AuthController extends Controller
{
    public function sanctumToken(Request $request, UsersService $authService)
    {
        return $authService->createToken($request);
    }

    public function usersCreated(UsersCreatedRequest $request, UsersService $authService)
    {
        return $authService->usersCreated($request);
    }
    public function usersVerified(Request $request, UsersService $authService)
    {
        return $authService->usersVerified($request->guid);
    }

}
