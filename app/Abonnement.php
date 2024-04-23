<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    
	protected $fillable = [
        'libelle', 'nb_mois'
    ];
    /*public function abonners()
    {
        return $this->hasMany('App\Abonner','id_abonnement');
    }*/

    public function abonners()
    {
        return $this->belongsToMany('App\Abonner')->withPivot('is_active', 'abonnement_id');
    }

    public function pack()
    {
        return $this->hasMany('App\Pack', 'id_abonnement' ) ;
    }

    



}
