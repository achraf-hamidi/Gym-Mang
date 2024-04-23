<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typefrais extends Model
{

    protected $fillable = [
        'libelle'
    ];

    public function frais()
    {
        return $this->hasMany('App\Assurancep','id_typefrais');
    }



}
