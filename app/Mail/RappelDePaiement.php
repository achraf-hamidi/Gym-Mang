<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RappelDePaiement extends Mailable
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
        return $this->subject('Reppel de paiement')
                    ->view('emails.rappel_de_paiement');
    }
}
