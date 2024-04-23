<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $fillable = [
       'adherent_id', 'nom', 'service_id', 'montant', 'date_commande', 'is_payed', 'note', 'updated_at', 'created_at'
    ];

    public function service() {
        return $this->belongsTo('App\Service','service_id')  ;
    }

    public function adherent() {
        return $this->belongsTo('App\Adherent','adherent_id')  ;
    }

    public function recettepaiements() {
        return $this->hasMany('App\Recettepaiement','recette_id')  ;
    }
}
