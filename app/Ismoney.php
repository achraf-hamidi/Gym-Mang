<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ismoney extends Model
{
    
    protected $fillable = [
        'id_abonner', 'prix', 'date'
    ];

     public function abonner()
    {
        return $this->belongsTo('App\Abonner','id_abonner');
    }


}
