<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FicheInscription extends Mailable
{
    use Queueable, SerializesModels;
public $abonner;
public $paiements;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($abonner, $paiements) {
        $this->abonner = $abonner;
        $this->paiements = $paiements;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Fiche d\'inscription')
                    ->view('emails.fiche_inscription');
    }
}
