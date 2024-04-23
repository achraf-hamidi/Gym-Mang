<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon ;

class Assurance extends Model
{
   
    protected $fillable = ['id_adherent', 'date_assuree', 'date_fin' , 'id_assureur', 'prix'];
    protected $appends = ['RestDays'];

    public function adherent()
    {
        return $this->belongsTo('App\Adherent','id_adherent');
    }


    public function getRestDaysAttribute(){  
        $assurance = Assurance::where('id', $this->id )->first();
        if ($assurance->date_fin == null) 
        	return 0 ;
        else 
        	$end_date = $assurance->date_fin ;


        $start_date = date_create( now());
        $start_date = Carbon::parse( date_format($start_date, 'Y-m-d H:i:s') ) ;

        $end_date = date_create( $end_date );
        $end_date = Carbon::parse( date_format($end_date, 'Y-m-d H:i:s') )->addDays(1);

        $days     = $start_date->diffInDays($end_date, false);

       //  $start_date = \Carbon\Carbon::createFromFormat("Y-m-d H:s:i", now());
       //  $end_date = \Carbon\Carbon::createFromFormat("Y-m-d H:s:i", $end_date);
       //  $days = $start_date->diffInDays($end_date, false);
        //echo $days;
        return $days;


    }


}	
