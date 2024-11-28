<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailSender
{
    public function handle(User $user, array $data, $type = null)
    {
        if ($type == 'reschedule') {
            Mail::to($user->email)->send(new \App\Mail\RescheduleEmail($user, $data));
        } else {
            Mail::to($user->email)->send(new \App\Mail\MailSender($user, $data));
        }
    }
}
