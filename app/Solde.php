<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solde extends Model
{
   	protected $fillable = ['code_client', 'solde'];

   	public function adherent()
    {
        return $this->belongsTo('App\Adherent','code_client');
    }


     static function UpdateSolde($recharge, $code_client){
    	$solde = Solde::where('code_client', $code_client )->first();
    	if ($solde) 
			$solde->update([  
				'solde' =>  ($solde->solde + $recharge ) 
			]) ;
		else 
			Solde::create([  
				'code_client' =>  $code_client ,
				'solde' =>  $recharge 
			]) ;

		return true ;
    }

}
