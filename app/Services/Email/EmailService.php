<?php


namespace App\Services\Email;


use App\Models\User;
use App\Models\UserVerifiedUrl;

class EmailService
{

    public function createdGuidAndSendEmailUser(User $user)
    {
        $guid = $this->createUniqueGuid($user);
        $url = 'http://hillel18.loc/api/users/verified/';
// Адрес email получателя
        $to = $user->email;

// Тема сообщения
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
            $guid = uniqid();
        } while (UserVerifiedUrl::where('', $guid)->get());

        $userV = new UserVerifiedUrl();
        $userV->user_id = $user->id;
        $userV->guid = $guid;
        $userV->save();

        return $guid;
    }

}
