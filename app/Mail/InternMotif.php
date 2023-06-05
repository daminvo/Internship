<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class InternMotif extends Mailable
{
    use Queueable, SerializesModels;

    public $motif;
    public $user;


    public function __construct($motif,$user)
    {
        $this->motif = $motif;
        $this->user = $user;
    }

    public function build()
    {
        return $this->markdown('emails.motif')
                    ->subject('motif');
    }
}
