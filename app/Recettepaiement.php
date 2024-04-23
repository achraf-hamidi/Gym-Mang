<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recettepaiement extends Model
{
    protected $fillable = [
        'recette_id', 'montant_paye', 'date_paiement', 'updated_at', 'created_at'
    ];

    public function recette() {
        return $this->belongsTo('App\Recette','recette_id')  ;
    }
 
}
