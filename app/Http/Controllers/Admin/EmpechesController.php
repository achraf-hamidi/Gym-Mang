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
use File;
use QrCode;
use DateTime; 
use DB;
use Carbon\Carbon; 

class EmpechesController extends Controller
{
    

    public function index(Request $request){ // La liste des empechements
		$date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request); 

		$empeches = Empeche::with(['abonner' => function($abonner) {
									$abonner->with(['adherent' => function ($adherent) {
										$adherent->with('latestAbonner');
									}]);
								}])
								->when( $date , function ($query, $date ) {
								     $query->whereBetween('created_at', [ $date ] ) ;
								})
								->orderBy('id', 'desc')->paginate(50);
		return response()->json($empeches);
    }


    public function FindAdherentByMatricule(Request $request){ // La liste des empechements
		$adherent = Adherent::has('abonners')
					->with('latestAbonner')
					->whereHas('latestAbonner', function ($q) {
						$q->where('date_fin', '>=', now());
					})
					// ->where('code_client', $request['matricule'])
					->where('id_empreinte', $request['id_empreinte'])
					->first();

			if ($adherent) {
				return response()->json( ['adherent' => $adherent]);
			}else{
				return response()->json( ['adherent' => null]);
			}
    }


    public function store(Request $request){
    	//echo $request['empeche.id_adherent'] ;

    	$date_absence = date_create( $request['empeche.date_absence']);

 		$date_retour = ( Carbon::parse( date_format($date_absence, 'Y-m-d H:i:s') ) )->addDays(  $request['empeche.nb_jours']);


    	/*$empeche = Empeche::where([ 
  						  	['id_adherent', $request['empeche.id_adherent']  ],
  						  	['date_absence' , '>=' , now()], 
  						  	['date_retour' , '<' , now()] 
  						  ])
  						  ->orWhere([ 
  						  	['id_adherent', $request['empeche.id_adherent']  ] ,
  						  	['date_absence' , '<' , now()], 
  						  	['date_retour' , '>' , now()] 
  						  ])
  						  ->orderBy('id', 'desc')
						  ->first();*/ 

		$empeche = Empeche::where('id_adherent', $request['empeche.id_adherent'] )
  						  //->whereBetween( 'date_absence' , [$date_absence,  $date_retour] )
  						  //->whereBetween( 'date_retour' , [$date_absence,  $date_retour] )
							->where('date_retour' , '>', now() ) //$date_absence
  						  ->orderBy('id', 'desc')
						  ->first();


		if ($empeche) {
			return response()->json("empeche existe");		  
		}else{
			$abonner = Abonner::where('id_adherent', $request['empeche.id_adherent'])
	    					  ->where('date_fin' ,'>=', now())
	    					  ->where('suspend' ,0) // no suspend, whene account suspended equals 1
	    					  ->where('has_new_abonnement', 0) // if 0 adherent has abonnement actif 
	    					  ->orderBy('id', 'desc')
	    					  ->first();
	        if ($abonner) { 
				/*$date_retour =date('Y-m-d', strtotime($request['empeche.date_absence']. ' + '. $request['empeche.nb_jours'] .' days'));
				$date_fin =date('Y-m-d', strtotime($abonner->date_fin. ' + '. $request['empeche.nb_jours'] .' days'));*/


				

 				$date_fin = date_create( $abonner->date_fin ); 			
 				$date_fin = ( Carbon::parse( date_format($date_fin, 'Y-m-d H:i:s') ) )->addDays(  $request['empeche.nb_jours']);


				$empeche = Empeche::create([
					'date_absence'  => date_format($date_absence, 'Y-m-d H:i:s') ,
					'date_retour' => $date_retour , 
					'date_fin'    => $date_fin ,
					'old_date_fin_abonnement'    => $abonner->date_fin ,
					'nb_jours'    => $request['empeche.nb_jours'],
					'empeche'     => $request['empeche.empeche'],
					'id_adherent' => $request['empeche.id_adherent'],
					'id_abonner'  => $abonner->id ,
				]); 

				$abonner->update([
					'date_fin' => $date_fin
				]);
				$empeche = Empeche::with(['abonner' => function($abonner) {
									$abonner->with(['adherent' => function ($adherent) {
										$adherent->with('latestAbonner');
									}]);
								}])
								->where('id', $empeche->id )
								->first();



				return response()->json($empeche);
			}else {
				return response()->json("abonner n'existe pas");
			}
		}
    }


     public function update(Request $request){
    	//echo $request['empeche.id_adherent'] ;
    	$empeche = Empeche::where('id', $request['empeche_id']  )->first();
		if ($empeche) {
			//$date_retour =date('Y-m-d', strtotime($request['empeche.date_absence']. ' + '. $request['empeche.nb_jours'] .' days'));
			//$date_fin =date('Y-m-d', strtotime($abonner->date_fin. ' + '. $request['empeche.nb_jours'] .' days'));




				$abonner = Abonner::where('id', $request['id_abonner'])
	    					  ->where('date_fin' ,'>=', now())
	    					  ->where('has_new_abonnement', 0) // if 0 adherent has abonnement actif 
 	    					  ->first();

if ($abonner) { 

				$date_absence = date_create( $request['empeche.date_absence']);

 				$date_retour = ( Carbon::parse( date_format($date_absence, 'Y-m-d H:i:s') ) )->addDays(  $request['empeche.nb_jours']);
 

 				$date_fin_abonner = date_create( $empeche->old_date_fin_abonnement ); 			
 				$date_fin = ( Carbon::parse( date_format($date_fin_abonner, 'Y-m-d H:i:s') ) )->addDays(  $request['empeche.nb_jours']);

				$empeche->update([
					'date_absence'  => date_format($date_absence, 'Y-m-d H:i:s') ,
					'date_retour' => $date_retour , 
					'date_fin'    => $date_fin ,
					//'old_date_fin_abonnement'    => $abonner->date_fin , // we save the old date end
					'nb_jours'    => $request['empeche.nb_jours'],
					'empeche'     => $request['empeche.empeche'],
					//'id_adherent' => $request['empeche.id_adherent'],
					//'id_abonner'  => $request['empeche.id_abonner'] ,
				]); 

				$abonner->update([
					'date_fin' => $date_fin
				]);

			$empeche = Empeche::with(['abonner' => function($abonner) {
									$abonner->with(['adherent' => function ($adherent) {
										$adherent->with('latestAbonner');
									}]);
								}])
								->where('id', $empeche->id )
								->first();
			return response()->json($empeche);

		}
			return response()->json(false);

		}
    }


    public function destroy(Request $request) {
        $empeche = Empeche::find($request['id_empeche']);
        if ($empeche) {
            
            $abonner = Abonner::where('id', $empeche->id_abonner)
            					->first();
            $abonner->update([
					'date_fin' => $empeche->old_date_fin_abonnement
			]);
            $empeche->delete();

            return response()->json(true);
        }
        return response()->json(false);
    }


}
