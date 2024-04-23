<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
        
    protected $fillable = [
       'nom', 'description', 'type_id'
    ];

    public function services() {
        return $this->hasMany('App\Service','categorie_id')  ;
    }


}
