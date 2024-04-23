<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    
     protected $fillable = [
     	'date_paiement', 'prix', 'id_abonner', 'id_user', 'id_adherent', 'id_pack', 'id_abonnement'
    ];

    public function abonner()
    {
        return $this->belongsTo('App\Abonner','id_abonner');
    }

}
