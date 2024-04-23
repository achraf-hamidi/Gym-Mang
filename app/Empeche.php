<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empeche extends Model
{
    

	protected $fillable = [
        'id_adherent', 'id_abonner', 'nb_jours', 'date_absence', 'date_retour', 'date_fin', 'empeche', 'old_date_fin_abonnement'
    ];


    public function abonner()
    {
        return $this->belongsTo('App\Abonner','id_abonner');
    }

    public function adherent()
    {
        return $this->belongsTo('App\Adherent','id_adherent');
    }

}
