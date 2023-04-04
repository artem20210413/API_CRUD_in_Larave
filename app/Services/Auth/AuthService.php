<?php


namespace App\Services\Auth;


use App\Http\Requests\AuthRequest;
use App\Jobs\ProcessPodcast;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct()
    {
    }

    public function createToken(AuthRequest $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken($request->device_name)->plainTextToken;

        Queue::connection('database')->push(ProcessPodcast::class, $email, $token);

        return $token;
//        return 'success';
    }

}
