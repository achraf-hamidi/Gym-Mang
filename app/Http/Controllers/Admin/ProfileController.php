<?php

namespace App\Http\Controllers\Admin;

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
use App\Assurance;
use File;
use QrCode;
use DateTime; 
use DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProfileController extends Controller
{
        

    function __construct(){

        
    }


    public function DetailsAdherent(Request $request, $code){
        /*if (!auth()->user()->hasPermissionTo('profile adherent'))
            return response()->json(false);*/ 
    	$adherent = Adherent::where('code_client', $code)
                            //->orWhere('nom', $code)
                            ->orWhere('cin', $code)
                            ->orWhere('id_empreinte', $code)
                            ->with([ 'integrations', 'parent', 'children'])->first();

    	if ($adherent) {
            $montant_paye = 0;
            $reste =  0;
            $total =  0;
            $isMoneys  = 0 ;
            $abonner = [] ; // $abonner,
            $abonnement = [] ; // $abonnement ,
            $pack = [] ; // $pack,
            $abonner  = Abonner::where('id_adherent', $adherent->id)->has('abonnements')->with(['abonnements' , 'packs', 'frais', 'empeches' => function($query) {
                $query->where( [
                                    ['date_retour' , '>=', now() ],
                                    ['date_absence' , '<', now() ],
                                ]) ;

            } ])->orderBy('id', 'desc')->first();

            if ($abonner) { 
                $isMoneys    = (isset($abonner->isMoneys)) ? $abonner->isMoneys->sum('prix') : 0;
                $pack        = $abonner->packs()
                                    ////ayb->where('is_active', 1)
                                    ->orderBy('id', 'desc')->first(); // this
                $prix        = ($pack) ? $pack->prix : 0 ;
                $abonnement  = $abonner->abonnements()
                                       ////ayb ->where('is_active', 1)
                                        ->orderBy('id', 'desc')->first(); // this
                $nb_mois     = ($abonnement) ? $abonnement->nb_mois : 0;
                //$promotions  = $pack->promotions()->orderBy('id', 'desc')->first();  // this
                $promotions_remise = ($pack) ? $pack->pivot->promo : 0 ;  //($promotions) ? $promotions->remise : 0 ;

                //$total        = number_format(floatval( ($prix * $nb_mois ) - ( $promotions_remise + $abonner->remise ) ) , 2 , '.' , '');

                $total        = number_format(floatval($abonner->prix_ttc) , 2 , '.' , '');

                $montant_paye = number_format(floatval($abonner->paiements->sum('prix')) , 2 , '.' , '');
                $reste        = number_format(floatval($total - ($montant_paye - $isMoneys  )) , 2 , '.' , '');
                
            }
            $recharges = array();// Recharge::where('code_client', $adherent->code_client)->take(6)->get() ;
            $soldeAdherent     =  array(); //Solde::where('code_client', $adherent->code_client)->first() ; 
            $solde = ($soldeAdherent) ? $soldeAdherent->solde : 0 ;

            $assurance = Assurance::where([
                                        ["id_adherent", $adherent->id ],
                                        ['date_fin' , '>' , now() ]
                                    ])->orderBy('id', 'desc')
                                    ->first();


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
                ],
                'assurance' => $assurance
                
            ]) ;
        }else
            return response()->json(false) ;
             
    }
 

    public function HistoriquesAbonners(Request $request, $code){
    	$adherent = Adherent::where('code_client', $code)->first();
    	if ($adherent) {
        $abonner  = Abonner::where('id_adherent', $adherent->id)
    					   ->with(['abonnements', 'packs', 'paiements'])
    					   ->orderBy('id', 'desc')
                           ->take(6)
                           ->get(); 
   		return response()->json($abonner) ;
        }else
            return response()->json(false) ;
    } 

    public function  PresencesByAdherent (Request $request, $code){
    	//$date = Helper::getDate($request);
    	$adherent   = Adherent::where('code_client', $code)->first();
    	if ($adherent) {
        $presences  = Presence::where('id_adherent', $adherent->id) 
    					   //->whereBetween('date_entrer', [ $date ])
    					   ->orderBy('id', 'desc')
                           ->take($request['filtrer.take'])
                           ->get(); 
   		return response()->json($presences) ;
        }else
            return response()->json(false) ;
    }


}
