<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailSender
{
    public function handle(User $user, array $data)
    {
        Mail::to($user->email)->send(new \App\Mail\MailSender($user, $data));
    }
}
