<?php

namespace App\Http\Controllers\Adherent;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Adherent;
use App\Abonner;
use App\Presence;
use App\Activitie;
use App\Pack;
use App\Abonnement;
use App\Ismoney;
use App\Integration;
use App\Paiement;
use App\Promotion;
use App\Empeche;
use App\Recharge;
use App\Solde;
use File;
use QrCode;
use DateTime; 
use DB;
 


class AdherentController extends Controller
{
    //



	public function ProfileAdherent(Request $request , $code){ 
        $montant_paye = 0;
        $reste =  0;
        $total =  0;
        $isMoneys  = 0 ;
        $abonner = [] ; // $abonner,
        $abonnement = [] ; // $abonnement ,
        $pack = [] ; // $pack,
 
    	$adherent = Adherent::where('code_client', $code)->with([ 'integrations', 'parent', 'children'])->first();
    	$abonner  = Abonner::where('id_adherent', $adherent->id)->has('abonnements')->with(['empeches', 'abonnements' , 'packs' ])->orderBy('id', 'desc')->first();

        if ($abonner) { 
        	$isMoneys    = (isset($abonner->isMoneys)) ? $abonner->isMoneys->sum('prix') : 0;
        	$pack 	     = $abonner->packs()->where('is_active', 1)->orderBy('id', 'desc')->first(); // this
        	$prix 	     = ($pack) ? $pack->prix : 0 ;
        	$abonnement  = $abonner->abonnements()->where('is_active', 1)->orderBy('id', 'desc')->first(); // this
        	$nb_mois     = ($abonnement) ? $abonnement->nb_mois : 0;
        	//$promotions  = $pack->promotions()->orderBy('id', 'desc')->first();  // this
        	$promotions_remise = ($pack) ? $pack->pivot->promo : 0 ;  //($promotions) ? $promotions->remise : 0 ;

        	//$total 	      = number_format(floatval( ($prix * $nb_mois ) - ( $promotions_remise + $abonner->remise ) ) , 2 , '.' , '');
        	$total 	      = number_format(floatval( ($prix  ) - ( $promotions_remise + $abonner->remise ) ) , 2 , '.' , '');
        	$montant_paye = number_format(floatval($abonner->paiements->sum('prix')) , 2 , '.' , '');
        	$reste 		  = number_format(floatval($total - ($montant_paye - $isMoneys  )) , 2 , '.' , '');
            
        }
        $recharges = Recharge::where('code_client', $code)->get() ;
        $soldeAdherent     = Solde::where('code_client', $code)->first() ; 
        $solde = ($soldeAdherent) ? $soldeAdherent->solde : 0 ;

   		return response()->json([
			'details_adherent' => $adherent,
			'details_abonner' => [
				'abonner' => $abonner,
				'abonnement' => $abonnement ,
				'pack' => $pack,
				//'promotions' => $promotions,
			],
			'revenu' => [
				'montant_paye' => $montant_paye,
				'reste' => $reste,
                'total' => $total ,
				'is_money' => $isMoneys ,
			], 
            'wallet' => [
                'recharges' => $recharges,
                'solde' => $solde
            ]
            
   		]) ;
             
    }
 

    public function HistoriquesAbonners(Request $request, $code){
    	$adherent = Adherent::where('code_client', $code)->first();
    	$abonner  = Abonner::where('id_adherent', $adherent->id)
    					   ->with(['abonnements', 'packs', 'paiements'])
    					   ->orderBy('id', 'desc')->get(); 
   		return response()->json($abonner) ;
    } 

    public function  PresencesByAdherent (Request $request, $code){
    	$date = Helper::getDate($request);
    	$adherent   = Adherent::where('code_client', $code)->first();
    	$presences  = Presence::where('id_adherent', $adherent->id) 
    					   ->whereBetween('date_entrer', [ $date ])
    					   ->orderBy('id', 'desc')->get(); 
   		return response()->json($presences) ;
    }


}
