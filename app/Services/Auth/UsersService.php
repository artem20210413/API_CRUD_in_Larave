<?php


namespace App\Services\Auth;


use App\Http\Requests\UsersCreatedRequest;
use App\Http\Resources\UsersResource;
use App\Jobs\ProcessPodcast;
use App\Models\User;
use App\Models\UserVerifiedUrl;
use App\Services\Email\EmailService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;

class UsersService
{
    public function __construct()
    {
    }

    public function all(\Illuminate\Http\Request $requests)
    {
        $name = $requests->name ? $requests->name : "";
        $email = $requests->email ? $requests->email : "";
        $iso = $requests->iso;
        $verified = $requests->verified;

        $users = User::where('name', 'LIKE', "%$name%")
            ->where('email', 'LIKE', "%$email%");

        if ($iso) {
            $users->where('iso_code_country', $iso);
        }

        if ($verified === 'false') {
            $users->whereNull('verified');
        } else if ($verified === 'true') {
            $users->whereNotNull('verified');
        }

        return UsersResource::collection($users->get());
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
            (new EmailService())->createdGuidAndSendEmailUser($user);

            Queue::connection('database')->push(ProcessPodcast::class, $user);
        }

        return 'Verification emails added to the queue';
    }

    public function usersVerified(string $guid)
    {
        $userVerifiedUrl = $this->checkGuid($guid);
        $user = User::find($userVerifiedUrl->user_id);
        $token = $user->createToken('not found')->plainTextToken;
        $user->verified = new \DateTime();
        $user->save();

        return $token;
    }

    public function checkGuid(string $guid): UserVerifiedUrl
    {
        $userVerifiedUrl = UserVerifiedUrl::where('guid', $guid)->first();
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


    public function getUser()
    {
        return Auth::user();
    }

    public function userDelete($user)
    {
        User::destroy($user->id);
        return response()->json('successful removal');
    }
}
