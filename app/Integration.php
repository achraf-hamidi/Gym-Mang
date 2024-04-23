<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    
     protected $fillable = [
     	'id_adherent', 'date_debut', 'date_fin'
    ];

    public function adherent()
    {
        return $this->belongsTo('App\Adherent','id_adherent');
    }

}
