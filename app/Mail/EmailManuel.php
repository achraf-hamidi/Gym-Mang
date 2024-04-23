<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailManuel extends Mailable
{
    use Queueable, SerializesModels;
    public $description;
    public $titre;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($description, $titre) {
        $this->description = $description;
        $this->titre = $titre;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->titre)
                    ->view('emails.email_manuel');
    }
}
