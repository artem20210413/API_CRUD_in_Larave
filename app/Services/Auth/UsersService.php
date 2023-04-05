<?php


namespace App\Services\Auth;


use App\Http\Requests\UsersCreatedRequest;
use App\Jobs\ProcessPodcast;
use App\Models\User;
use App\Models\UserVerifiedUrl;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;

class UsersService
{
    public function __construct()
    {
    }


    public function usersCreated(UsersCreatedRequest $requests)
    {
        $users = $requests->users;
        $this->checkUnique($users);
        foreach ($users as $request) {

            $email = $request['email'];
            $name = $request['name'];
            $iso_code_country = $request['iso_code_country'];
            $user = $this->createdUser($email, $name, $iso_code_country);

            Queue::connection('database')->push(ProcessPodcast::class, $user);
        }

        return 'Verification emails added to the queue';
    }

    public function usersVerified(string $guid)
    {
        $userVerifiedUrl = $this->checkGuid($guid);
        $user = User::find($userVerifiedUrl->id);

        $token = $user->createToken('not found')->plainTextToken;
        $user->verified = 1;
        $user->save();

        return $token;
    }


    public function checkGuid(string $guid): UserVerifiedUrl
    {
        $userVerifiedUrl = UserVerifiedUrl::where('guid', $guid)->get();

        if (!$userVerifiedUrl || $userVerifiedUrl->action === 0) {
            throw ValidationException::withMessages([
                'guid' => ['Not valid'],
            ]);
        }
        $userVerifiedUrl->action = 0;
        $userVerifiedUrl->save();

        return $userVerifiedUrl;
    }

    public function checkUnique($requests, $isDB = false)
    {
        foreach ($requests as $kay1 => $request1) {

            if ($isDB) {
                $this->checkUniqueDB($request1);
            }

            foreach ($requests as $kay2 => $request2) {
                if ($kay1 !== $kay2 && $request1['email'] === $request2['email']) {
                    throw ValidationException::withMessages([
                        'email' => ['Duplication detected'],
                    ]);
                }
            }
        }
    }

    public function checkUniqueDB($request1)
    {
        if (!User::where('email', $request1['email'])->first()) {
            throw ValidationException::withMessages([
                'email' => ['Not found'],
            ]);
        }
    }

    public function createdUser($email, $name, $iso_code_country): User
    {
        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->iso_code_country = $iso_code_country;
        $user->save();
        return $user;
    }

}
