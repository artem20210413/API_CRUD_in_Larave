<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\UsersCreatedRequest;
use App\Services\Auth\UsersService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function usersCreated(UsersCreatedRequest $request, UsersService $authService)
    {
        return $authService->usersCreated($request);
    }

    public function usersVerified($guid, UsersService $authService)
    {
        return $authService->usersVerified($guid);
    }

    public function userDelete(UsersService $authService)
    {
        $user = $authService->getUser();
        return $authService->userDelete($user);
    }

    public function all(Request $request, UsersService $usersService)
    {
        return $usersService->all($request);
    }


}
