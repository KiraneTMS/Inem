<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $password;
     public $email;

    public function __construct($password, $email)
    {
        $this->transaction = $password;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = '65wg4izw34cg6aw3vb9w74356aw49876ch549695v4besb,vytsn78485vawbn89c73bt4cv87tv5baw4785vbt3a874nctsi6syehvnt7s8346tbs34785vyw34o758nby...'.$this->email;
        $this->view('mails.verification', compact('data'));

        return $this;
    }
}
