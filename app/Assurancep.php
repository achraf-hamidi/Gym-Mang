<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assurancep extends Model
{
    protected $fillable = [
        'libelle','nb_mois' , 'prix', 'id_typefrais'
    ];


    public function typefrais()
    {
        return $this->belongsTo('App\Typefrais','id_typefrais');
    }

    public function fraisabonner()
    {
        return $this->hasMany('App\Fraisabonner','id_assuranceps');
    }



}
