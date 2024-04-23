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

class PresencesController extends Controller
{


	public function GetInformationAdherent(Request $request){
		$adherent = Adherent::where(function ($query) use ($request) {
								 $query->where('code_client', $request->code_client)
								    ->orWhere('id_empreinte', $request->id_empreinte)
									->orWhere('qr_code', $request->code_client )
									->orWhere('email', $request->code_client)
									->orWhere('cin',  $request->code_client );
							})
 							->first();
 		if ($adherent) {
 			return response()->json([ 'adherent' => $adherent ]);
 		}
 		return response()->json([ 'adherent' => null ]);

	}


   	public function PresenceManualOrbyQR(Request $request ){
		$adherent = Adherent::where(function ($query) use ($request) {
							    // $query->where('code_client', $request->code_client)
								$query->where('id_empreinte', $request->id_empreinte)
									->orWhere('qr_code', $request->code_client )
									->orWhere('email', $request->code_client)
									->orWhere('cin',  $request->code_client );
							})
							//->where('is_valide', 1)
							->first();

	  	if ($adherent) {

	  		$empeche = Empeche::where('id_adherent', $adherent->id )
							    ->where( [
							    	['date_retour' , '>=', now() ],
							    	['date_absence' , '<', now() ],
							    ])
							    ->orderBy('id', 'desc')
							    ->first();

			if ($empeche)
				//if((now() <= $empeche->date_retour && now() >= $empeche->date_absence))
	                return response()->json(['check' => "adherent en empeche"]);

	  		$days = null;

	  		$date_fin = date_create(now());
            //$date_fin = ( Carbon::parse( date_format($date_fin, 'Y-m-d H:i:s') ) )->subDays(8);

			$abonner = Abonner::where('id_adherent', $adherent->id)
							  //->where('date_fin', '>=', $date_fin )
							  ->orderBy('id', 'desc')
							  ->first();

		    //if ( $abonner == null )  //check if abonnement expiré
		    //	return response()->json(['check' => 'expiré', 'adherent' => $adherent->nom ]);

	  		//$start_date = \Carbon\Carbon::createFromFormat("Y-m-d H:s:i", now());
			//$end_date   = \Carbon\Carbon::createFromFormat("Y-m-d H:s:i", $abonner->date_fin);
			//$days       = $start_date->diffInDays($end_date);

			$start_date = date_create( now());
			$start_date = Carbon::parse( date_format($start_date, 'Y-m-d H:i:s') ) ;

			$end_date = date_create( $abonner->date_fin );
			$end_date = Carbon::parse( date_format($end_date, 'Y-m-d H:i:s') ) ;
			$days     = $start_date->diffInDays($end_date);



	    	$check_presence = Presence::where('id_adherent', $adherent->id)
	    						      //->where('date_sortier', null)
	    						      ->whereDate('date_entrer', now())
	    						      ->orderBy('id', 'desc')->first();
	    	if ($check_presence) {
	    		/*$check_presence->update([
	    			'date_sortier' => now()
	    		]);
	    		$presence = Presence::with(['adherent' => function($query) {
										$query->with(['abonners' => function ($abonners)    {
											$abonners->with(['abonnements', 'packs']) ;
										        //$abonners->where('date_fin' ,'>=', now());
 									}]);
								}])->where('id_adherent', $adherent->id)->orderBy('id', 'desc')->first();*/
	    		//return response()->json(['check' => "logged" ,'type'=> 'sortier' , 'presence' => $presence, 'days' => $days ]);
	    		return response()->json(['check' => "logged"  ]);
	    	}else {
		    	$presence = Presence::create([
		    		'id_adherent' => $adherent->id ,
		    		'date_entrer' => now(), // date('Y-m-d H:i:s', strtotime('1 hour')), //,
		    		'date_sortier' => now()
		    	]);
		    	$check_presence = Presence::with(['adherent' => function($query) {
										$query->with(['abonners' => function ($abonners)    {
											$abonners->with(['abonnements', 'packs'])
													->orderBy('id', 'desc');
										        //$abonners->where('date_fin' ,'>=', now());
 									}]);
								}])
		    					->where('id_adherent', $adherent->id)
		    					//->where('date_sortier', null)
		    					->orderBy('id', 'desc')->first();
		    	return response()->json(['check' => "create", 'type'=>  'entrer', 'presence' => $check_presence, 'days' => $days ]);
		    }
	    }
	    return response()->json(['check' => "adherent n'exist pas"]);

	   // echo $request->code_client;
    }

    public function PresencesAujourdhui(Request $request){
    	$from = date_create(now());
 		$from = ( Carbon::parse( date_format($from, 'Y-m-d') ) ) ;//->subDay(0);

 		$to = date_create(now());
 		$to = ( Carbon::parse( date_format($to, 'Y-m-d') ) )->addDays(1);


    	//$from = date('Y/m/d', strtotime(date('Y/m/d', strtotime('-0 days') ))) ;
		//$to   = date('Y/m/d', strtotime(date('Y/m/d',strtotime('+1 days'))));
		$date = [$from, $to];
		//Possibilité de pointer aussi les adherent ayant abonnement términés avec l affichage des jours dépassé (-5j) for ex
		$date_fin = date_create(now());
        $date_fin = ( Carbon::parse( date_format($date_fin, 'Y-m-d') ) )->subDays(8);


		$list_presences = Presence::with(['adherent' => function($query) use ($date_fin) {
										$query->with(['abonners' => function ($abonners) use ($date_fin)    {
											$abonners->with(['abonnements', 'packs'])
											->orderBy('id', 'desc');
										        //$abonners->where('date_fin' ,'>=',$date_fin);
												//->whereBetween('date_fin', [ $date ]);
												// edit this condition
									}]);
								}])
								//->where('date_entrer', now() )
								->whereBetween('date_entrer', [ $date ])
								//->whereIn(DB::raw("DATE_FORMAT(date_entrer,'%m')"), [date('m')])
								//->whereIn(DB::raw("DATE_FORMAT(date_entrer,'%Y')"), [date('Y')])
								//->whereIn(DB::raw("DATE_FORMAT(date_entrer,'%d')"), [date('d')])
								->orderBy('id', 'desc')->paginate(50);



		return response()->json($list_presences);
    }
    public function HistoriquesPresences(Request $request){
    	//echo $request['filtrer.date.from'];
    	//echo '<br>';
    	////echo $request['filtrer.date'][1];
    	//die();
		$date = Helper::getDate($request);
		$historiques_presences = Presence::with(['adherent' => function($query) use ($request) {
										$query->with(['abonners' => function ($abonners) use ($request)    {
												$abonners->with(['abonnements', 'packs'])
														->whereHas('abonnements', function ($abonnements)  {
														        $abonnements->where('is_active' , 1);
														})
														->whereHas('packs', function ($packs)   {
														    $packs->where('is_active' , 1);
													    })
													    //->where('date_fin', '>=', now())
													    ->orderBy('id', 'desc');
 										}])
 										->whereHas('abonners', function ($abonners)   {
										    $abonners->orderBy('id', 'desc');
										    //->where('date_fin', '>=', now())
 									    });
 									    /*if (isset($request['filtrer.matricule']) && $request['filtrer.matricule'] != '' ) {
											$query->where('code_client', $request['filtrer.matricule'] );
										}*/
								}])
								->whereHas('adherent', function($query) use ($request)  {
										$query->whereHas('abonners', function ($abonners) use ($request)    {
										    $abonners->orderBy('id', 'desc');
										    //->where('date_fin', '>=', now())

 									    });
 									    if (isset($request['filtrer.matricule']) && $request['filtrer.matricule'] != '') {
											//$query->where('code_client', $request['filtrer.matricule'] );
											$query->where('id_empreinte', $request['filtrer.matricule'] );
										}
								})
								->whereBetween('date_entrer', [ $date ])
								->orderBy('id', 'desc')->paginate(50);
		return response()->json($historiques_presences);
    }


}
