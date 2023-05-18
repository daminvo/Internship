<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ManagerPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $user;


    public function __construct($password,$user)
    {
        $this->password = $password;
        $this->user = $user;
    }

    public function build()
    {
        return $this->markdown('emails.manager_password')
                    ->subject('Your New Password');
    }
}


