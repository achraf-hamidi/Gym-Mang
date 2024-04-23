<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Adherent extends Authenticatable
{   
use Notifiable;

            protected $guard = 'adherent';
    
     protected $fillable = [ 'id_empreinte',
        'code_client','qr_code', 'nom', 'email', 'password', 'tele', 'tele_urgence', 'date_naiss','cin', 'gender', 'adresse', 'image', 'is_valide', 'id_user', 'id_adherent'
    ];

	protected $table = 'adherents';
    protected $appends = ['AbonnementActif'];

    
	public function abonners()
    {
        return $this->hasMany('App\Abonner','id_adherent');
    }

    public function integrations()
    {
        return $this->hasMany('App\Integration','id_adherent');
    }

    public function presences()
    {
        return $this->hasMany('App\Presence','id_adherent');
    }


    public function empeches()
    {
        return $this->hasMany('App\Empeche','id_adherent');
    }


    public function latestAbonner() {
        return $this->hasOne('App\Abonner','id_adherent')
                    ->where('date_fin' , '>=' , now())
                    ->orderBy('id','desc')
                    ->latest();
    }

    public function getAbonnementActifAttribute() {
        $abonnement = $this->hasOne('App\Abonner','id_adherent')
                    ->where('date_fin' , '>=' , now())
                    ->where('has_new_abonnement', 0)
                    ->orderBy('id','desc')
                    ->first();           
        if ($abonnement) {
            $this->update(['is_valide' => 1 ]);
            return 1;
        }else{
            $this->update(['is_valide' => 0 ]);
            return 0 ;
        }
        
    }


    public function parent() {
        return $this->belongsTo('App\Adherent','id_adherent');
    }

    public function children() {
        return $this->hasMany('App\Adherent','id_adherent');
    }

    public function solde() // total recharge 
    {
        return $this->hasOne('App\Solde','code_client');
    }

    public function recharges() // array recharges
    {
        return $this->hasMany('App\Recharge','code_client');
    }

    public function assurances() // array recharges
    {
        return $this->hasMany('App\Assurance','id_adherent');
    }

    public function recettes() {
        return $this->hasMany('App\Recette','adherent_id')  ;
    }

    public function latestAssurance(){
        return $this->hasOne('App\Assurance', 'id_adherent')->orderBy('id','desc')->latest();
    }

}
