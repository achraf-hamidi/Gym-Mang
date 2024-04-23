<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{

     protected $fillable = [
        'description', 'prix', 'id_abonnement'
    ];
    
    protected $with      = ['activities', 'promotions'];
    

   /* public function abonners()
    {
        return $this->hasMany('App\Abonner','id_pack');
    }*/

    public function promotions()
    {
        return $this->hasMany('App\Promotion','id_pack')
                    ->where('date_debut' , '<=', now() )
                    ->where('date_fin' , '>=', now() );
    }

    public function activities()
    {
        return $this->belongsToMany('App\Activitie')->withPivot('id');
    }


    public function abonners()
    {
        return $this->belongsToMany('App\Abonner')->withPivot('is_active', 'pack_id', 'promo');
    }

    public function abonnement()
    {
        return $this->belongsTo('App\Abonnement', 'id_abonnement' ) ;
    }

}
