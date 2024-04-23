<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    
    protected $fillable = ['code_client', 'recharge', 'type'];
    protected $appends = ['ToAdherent'];


   	public function adherent()
    {
        return $this->belongsTo('App\Adherent','code_client');
    }


   	public function getToAdherentAttribute()
    {
       // return $this->belongsTo('App\Adherent','code_client');
        return Adherent::where('code_client', $this->code_client)->first();
    }


   
}
