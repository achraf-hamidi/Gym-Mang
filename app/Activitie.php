<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activitie extends Model
{
    	
     protected $fillable = [
        'code', 'name', 'image'
    ];

    public function packs()
    {
        return $this->belongsToMany('App\Pack')->withPivot('id');
    }

}
