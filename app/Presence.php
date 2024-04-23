<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    
      protected $fillable = [
        'id_adherent', 'date_entrer', 'date_sortier'
    ];

    public function adherent()
    {
        return $this->belongsTo('App\Adherent','id_adherent');
    }

}
