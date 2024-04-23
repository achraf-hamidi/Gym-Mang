<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    
	protected $fillable = [
       'description',  'date_debut', 'date_fin', 'id_pack', 'remise', 'image', 'id_user'
    ];

    public function pack()
    {
        return $this->belongsTo('App\Pack','id_pack') ; //->where('date_fin' , '>', now() );
    }

    /* public function abonner()
    {
        return $this->hasOne('App\Abonner','id_promo');
    }*/

}
