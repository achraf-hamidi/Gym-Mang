<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserAuth extends Mailable
{
    use Queueable, SerializesModels;
    public $titre;
    public $text;
    public $name;
    public $email;
    public $password;
    public $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titre, $text, $name , $email, $password, $link) {
        $this->titre = $titre;
        $this->text = $text;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->link = $link;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->titre)
                    ->view('emails.user_auth');
    }
}
