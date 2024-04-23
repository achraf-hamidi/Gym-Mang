<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depence extends Model
{
    protected $fillable = [
        'nom','service_id', 'montant', 'date_commande', 'is_payed','note', 'updated_at', 'created_at'
    ];

    public function service() {
        return $this->belongsTo('App\Service','service_id')  ;
    }
 
    public function depencepaiements() {
        return $this->hasMany('App\Depencepaiement','depence_id')  ;
    }
}
