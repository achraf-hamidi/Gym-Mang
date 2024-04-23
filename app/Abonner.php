<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon ;
use DB;
class Abonner extends Model
{

    protected $fillable = [
        'date_debut', 'date_fin', 'id_adherent', 'id_user', 'remise', 'promo', 'has_new_abonnement', 'suspend', 'suspended_at', 'prix_ttc', 'total_frais', 'completed_paiement', 'paiament_date_echeance', 'id_pack', 'id_abonnement'
    ];

    protected $appends = ['RestDays'];

    protected $with      = ['adherent'];
    
	public function adherent()
    {
        return $this->belongsTo('App\Adherent','id_adherent');
    }

   /* public function abonnement()
    {
        return $this->belongsTo('App\Adherent','id_adherent');
    }

    public function pack()
    {
        return $this->belongsTo('App\Pack','id_pack');
    }*/

    public function paiements()
    {
        return $this->hasMany('App\Paiement','id_abonner') ; //->sum('prix');
    }


    public function packs()
    {
        return $this->belongsToMany('App\Pack')->withPivot('is_active', 'pack_id','promo')->wherePivot('is_active', 1);
    }

    public function abonnements()
    {
        return $this->belongsToMany('App\Abonnement' )->orderBy('id','desc')->withPivot('is_active', 'abonnement_id')->wherePivot('is_active', 1);
    }

    /*public function promotion()
    {
        return $this->belongsTo('App\Promotion', 'id_promo');
    }*/

     public function isMoneys()
    {
        return $this->hasMany('App\Ismoney','id_abonner');
    }

    public function empeches()
    {
        return $this->hasMany('App\Empeche','id_abonner');
    }


    public function frais()
    {
        return $this->hasMany('App\Fraisabonner','id_abonner');
    }


    public function getRestDaysAttribute($day){  
        $empeche = Empeche::where('id_abonner', $this->id )->latest()->first();
        $abonner = Abonner::where('id', $this->id )->latest()->first();
        if ($empeche)
            $end_date = $empeche->date_fin ;
        else {
            $end_date = $abonner->date_fin ;
        }
        $start_date = date_create( now());
        $start_date = Carbon::parse( date_format($start_date, 'Y-m-d H:i:s') ) ;

        $end_date = date_create( $end_date );
        $end_date = Carbon::parse( date_format($end_date, 'Y-m-d H:i:s') )->addDays(1);

        $days     = $start_date->diffInDays($end_date, false); 
        /*if ($days <= 7 && $abonner->adherent->is_valide == 1 ) { 
            $abonner->adherent->update(['is_valide' => 0 ]);  // when the abonnement is expired
        }  
        if ($days > 0 ) { 
            $abonner->adherent->update(['is_valide' => 1 ]);
        } */
        return $days ;
    }

    

}
