<?php


namespace App\Http\Controllers\Entities;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\UsersService;
use App\Services\Entities\ContinentsService;
use Illuminate\Support\Facades\Auth;

class ContinentsController extends Controller
{

    public function all(ContinentsService $continentsService, UsersService $usersService)
    {
        $user = $usersService->getUser();
        return $continentsService->all();
    }
}
