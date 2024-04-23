<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
       'categorie_id', 'nom', 'description', 'prix', 'etat'
    ];

    public function categorie() {
        return $this->belongsTo('App\Categorie','categorie_id')  ;
    }


    public function recettes() {
        return $this->hasMany('App\Recette','service_id')  ;
    }

    public function depences() {
        return $this->hasMany('App\Depence','service_id')  ;
    }

}
