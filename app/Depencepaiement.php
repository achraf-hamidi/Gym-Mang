<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depencepaiement extends Model
{
    protected $fillable = [
        'depence_id', 'montant_paye', 'date_paiement', 'updated_at', 'created_at'
    ];

    public function depence() {
        return $this->belongsTo('App\Depence','depence_id')  ;
    }
}
