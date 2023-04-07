<?php


namespace App\Services\Email;


use App\Models\User;
use App\Models\UserVerifiedUrl;

class EmailService
{

    public function createdGuidAndSendEmailUser(User $user)
    {
        $url = 'http://hillel18.loc/api/users/verified/';
        $guid = $this->createUniqueGuid($user);
        $to = $user->email;
        $subject = 'Verified';
        $message = 'Get a token: ' . $url . $guid;
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    public function createUniqueGuid(User $user): string
    {
        do {
            $guid = uniqid() . uniqid() . uniqid();
        } while (!UserVerifiedUrl::where('guid', $guid)->get());

        $userV = new UserVerifiedUrl();
        $userV->user_id = $user->id;
        $userV->guid = $guid;
        $userV->save();

        return $guid;
    }

}
