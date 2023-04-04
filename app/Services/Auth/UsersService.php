<?php


namespace App\Services\Auth;


use App\Http\Requests\UsersRequest;
use App\Jobs\ProcessPodcast;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;

class UsersService
{
    public function __construct()
    {
    }

    public function createToken(UsersRequest $requests)
    {
        $this->checkUnique($requests);
//        dd('success');
        foreach ($requests->all() as $request) {
            $email = $request['email'];
            $user = User::where('email', $email)->first();
            $token = $user->createToken($request['device_name'])->plainTextToken;
            Queue::connection('database')->push(ProcessPodcast::class, $email, $token);
        }

        return 'success';
    }

    public function checkUnique(UsersRequest $requests)
    {
        foreach ($requests->all() as $kay1 => $request1) {

            if (!User::where('email', $request1['email'])->first()) {
                throw ValidationException::withMessages([
                    'email' => ['Not found'],
                ]);
            }

            foreach ($requests->all() as $kay2 => $request2) {
                if ($kay1 !== $kay2 && $request1['email'] === $request2['email']) {
                    throw ValidationException::withMessages([
                        'email' => ['Duplication detected'],
                    ]);
                }
            }
        }


    }

}
