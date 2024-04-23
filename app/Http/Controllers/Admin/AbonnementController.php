<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use Carbon\Carbon; 
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
use App\Fraisabonner;
use App\Assurance;
use File;
use QrCode;
use DateTime; 
use DB;

  use Illuminate\Support\Facades\Validator;

class AbonnementController extends Controller
{
    
	public function departements(Request $request){ 
        $departements = DB::table('departements')->get();
        return response()->json($departements);
    }


    public function index(Request $request){ //Abonnement En Cours Ou Termines
 //

    	              // 'Carbon\Carbon'
		//$carbon1 = new Carbon::parse(new DateTime('first day of January 2008'), new DateTimeZone('America/Vancouver')); // equivalent to previous instance

		//echo $carbon1;
		// You can create Carbon or CarbonImmutable instance from:


		$date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request); 

		$type_date = ($request['filtrer.symbole'] == '>=') ? 'date_fin' : 'date_fin';


		$genre = (isset($request['filtrer.genre']) && $request['filtrer.genre'] != '') ? [ $request['filtrer.genre'] ] : ['Homme','Femme'] ;


		$adherents = Adherent::with(['abonners'=> function ($abonners) use ($request, $date, $type_date) {
								 $abonners->with(['abonnements', 'packs']) 
								->whereHas('abonnements', function ($abonnements) use ($request, $date, $type_date)  {
						            if ( isset($request['filtrer.abonnement_id']) && $request['filtrer.abonnement_id'] != '') 
							          	$abonnements->where('abonnements.id', '=' , $request['filtrer.abonnement_id']); 

							        $abonnements->where('is_active' , 1);
								})
								->whereHas('packs', function ($packs) use ($request, $date, $type_date)  {
							        if (   isset($request['filtrer.pack_id']) && $request['filtrer.pack_id'] != '' ) 
								        $packs->where('packs.id', '=' , $request['filtrer.pack_id']);
								    $packs->where('is_active' , 1);
							    })
							    ->when( $date , function ($query, $date ) {
								     $query->whereBetween($type_date, [ $date ] ) ;
								})
							    ->where('suspend', 0)
							   ->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
								->where($type_date, $request['filtrer.symbole'] , now())
								->orderBy('id', 'desc');
					}])
		->whereHas('abonners', function ($abonners) use ($request, $date, $type_date)  {
						        $abonners->whereHas('abonnements', function ($abonnements) use ($request, $date, $type_date)  {
						            if ( isset($request['filtrer.abonnement_id']) && $request['filtrer.abonnement_id'] != '') 
							          	$abonnements->where('abonnements.id', '=' , $request['filtrer.abonnement_id']); 

							        $abonnements->where('is_active' , 1);

								})
								->whereHas('packs', function ($packs) use ($request, $date, $type_date)  {
							        if (   isset($request['filtrer.pack_id']) && $request['filtrer.pack_id'] != '' ) 
								        $packs->where('packs.id', '=' , $request['filtrer.pack_id']); 

							        $packs->where('is_active' , 1);

								})
								->when( $date , function ($query, $date ) {
								     $query->whereBetween($type_date, [ $date ] ) ;
								})
								->where('suspend', 0)
								->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
								->where($type_date, $request['filtrer.symbole'] , now())
								->orderBy('id', 'desc');
			})
			->whereIn('gender' , $genre );
			 


		if(isset($request['filtrer.nom']) && $request['filtrer.nom'] != ''){
			$adherents = $adherents->where('nom', 'like', '%'.$request['filtrer.nom'].'%');
		}
		if(isset($request['filtrer.matricule']) && $request['filtrer.matricule'] != ''){
			$adherents = $adherents->where('code_client', $request['filtrer.matricule']);
		}
		if(isset($request['filtrer.id_empreinte']) && $request['filtrer.id_empreinte'] != ''){
			$adherents = $adherents->where('id_empreinte', $request['filtrer.id_empreinte']);
		}
		if(isset($request['filtrer.cin']) && $request['filtrer.cin'] != ''){
			$adherents = $adherents->where('cin', $request['filtrer.cin']);
		}

		$count_adherents = $adherents->count();
		$adherent = $adherents->orderBy('id', 'desc')->paginate(50);


		return response()->json(['adherent' => $adherent, 'count_adherents' => $count_adherents ]);
		
	}


	public function abonnementsRenouveler(Request $request){ //Abonnement En Cours Ou Termines

	   
			   $date = null ;
			   if ( $request->has('filtrer.date') )
				   $date = Helper::getDate($request); 
	   
	   
			   $genre = (isset($request['filtrer.genre']) && $request['filtrer.genre'] != '') ? [ $request['filtrer.genre'] ] : ['Homme','Femme'] ;
				  
			   
		$adherents = Adherent::withCount('abonners')->with(['abonners'=> function ($abonners) use ($request, $date) {
            $abonners->with(['abonnements', 'packs']) 
           ->whereHas('abonnements', function ($abonnements) use ($request, $date)  {
               if ( isset($request['filtrer.abonnement_id']) && $request['filtrer.abonnement_id'] != '') 
                     $abonnements->where('abonnements.id', '=' , $request['filtrer.abonnement_id']); 
               $abonnements->where('is_active' , 1);
           })
           ->whereHas('packs', function ($packs) use ($request, $date)  {
               if (   isset($request['filtrer.pack_id']) && $request['filtrer.pack_id'] != '' ) 
                   $packs->where('packs.id', '=' , $request['filtrer.pack_id']);
               $packs->where('is_active' , 1);
           })
           ->when( $date , function ($query, $date ) {
                $query->whereBetween('date_debut', [ $date ] ) ;
           })
           ->where('suspend', 0)
          ->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
          //->where('date_fin', $request['filtrer.symbole'] , now())
           ->orderBy('id', 'desc');
}])
->whereHas('abonners', function ($abonners) use ($request, $date)  {
           $abonners->whereHas('abonnements', function ($abonnements) use ($request, $date)  {
               if ( isset($request['filtrer.abonnement_id']) && $request['filtrer.abonnement_id'] != '') 
                     $abonnements->where('abonnements.id', '=' , $request['filtrer.abonnement_id']); 

               $abonnements->where('is_active' , 1);

           })
           ->whereHas('packs', function ($packs) use ($request, $date)  {
               if (   isset($request['filtrer.pack_id']) && $request['filtrer.pack_id'] != '' ) 
                   $packs->where('packs.id', '=' , $request['filtrer.pack_id']); 

               $packs->where('is_active' , 1);

           })
           ->when( $date , function ($query, $date ) {
                $query->whereBetween('date_debut', [ $date ] ) ;
           })
           ->where('suspend', 0)
           ->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
          //->where('date_fin', $request['filtrer.symbole'] , now())
           ->orderBy('id', 'desc');
})
->has('abonners' ,'>', 1)
->whereIn('gender' , $genre );



			   if(isset($request['filtrer.nom']) && $request['filtrer.nom'] != ''){
				   $adherents = $adherents->where('nom', 'like', '%'.$request['filtrer.nom'].'%');
			   }
			   if(isset($request['filtrer.matricule']) && $request['filtrer.matricule'] != ''){
				   $adherents = $adherents->where('code_client', $request['filtrer.matricule']);
			   }
			   if(isset($request['filtrer.cin']) && $request['filtrer.cin'] != ''){
				   $adherents = $adherents->where('cin', $request['filtrer.cin']);
			   }
	   
			   $count_adherents = $adherents->count();
			   $adherent = $adherents->orderBy('id', 'desc')->paginate(50);
	   
	   
			   return response()->json(['adherent' => $adherent, 'count_adherents' => $count_adherents ]);
			   
		   }





	public function store(Request $request){ // Nouvelle abonner par adherent


		if (isset($request['adherent.email']) && $request['adherent.email'] != '') {	
			$rules = [
	 		    'email' => [
	 		        'string',
			        'email',
			        'max:255',
	 		        'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
			    ]
			]; 

			$data = array('email' => $request['adherent.email']);
			$validator = Validator::make($data , $rules);

			if ($validator->fails()) {
				 return response()->json(['validator' => false]);
			}

		}


		$check_if_adherent_existe = Adherent::all();
		$is_email = null;
		$is_cin = null;
		$is_tele = null;
		$is_empreinte = null;
		if (isset($request['adherent.email']) && $request['adherent.email'] != '' ) {
				$is_email = $check_if_adherent_existe ;
				$is_email = $is_email->where('email', $request['adherent.email'])
														->first();
		}
		if (isset($request['adherent.cin']) && $request['adherent.cin'] != '' ) {
			 $is_cin = $check_if_adherent_existe;
				$is_cin = $is_cin->where('cin', $request['adherent.cin'])
										->first();
			}
		if (isset($request['adherent.tele']) && $request['adherent.tele'] != '' ) {
			 $is_tele = $check_if_adherent_existe;
				$is_tele = $is_tele->where('tele', $request['adherent.tele'])
										->first();
			}

		// if (isset($request['adherent.id_empreinte']) && $request['adherent.id_empreinte'] != '' ) {
		// 	$is_empreinte = $check_if_adherent_existe;
		// 	$is_empreinte = $is_empreinte->where('id_empreinte', $request['adherent.id_empreinte'])
		// 							->first();
		// }
						
		$response = array();
    if ($is_email) {
  		 array_push($response, 'email' );
		}
		if ($is_cin) {
  		 array_push($response, 'cin');
		}
		if ($is_tele) {
  		 array_push($response, 'tele');
		}

		// if ($is_empreinte) {
		// 	array_push($response, 'empreinte');
		//  }
 
		if ($response) {
			return response()->json(['unique_validation' => $response]);
		}


		$imgName = '';
		if (isset($request['adherent'])) {
			if (isset($request['adherent.image'])) {
				$imgName = str_replace(array(" ","'",":",",",";",".", "?", "!"), '_', $request['adherent.nom'] ) . '_' . time() . '.'. $request['adherent.image']->extension();  
		        $request['adherent.image']->move(public_path('admin/adherents/photos'), $imgName);        
			}

			if($imgName == '')
				$imgName = ($request['adherent.gender'] == "Homme") ? 'homme.png' : 'femme.png' ;

			$qr_code = 'x'; //$request['adherent.cin'] .'_'. time() ;
			//$generate_email = str_replace(' ', '_', $request['adherent.nom']) .'@gmail.com';
	        

	        //$code_client = strtoupper(substr($request['adherent.nom'], 0, 2 ) ) . rand(1111, 9999) ;

	        $parrain = null;
	        /*if ( isset($request['adherent.parrain'])) {
	        	$parrain = Adherent::where('code_client', $request['adherent.parrain'])->first();
	        }*/


 			$date_naiss = (isset($request['adherent.date_naiss']) ) ? date_create( $request['adherent.date_naiss']) : null ;

			$adherent = Adherent::create([
				'code_client' => '' ,
				'qr_code' 	  => ($qr_code) ? $qr_code : '' ,
				'id_empreinte' 		  => (isset($request['adherent.id_empreinte']) ) ? $request['adherent.id_empreinte'] : null,
				'nom' 		  => (isset($request['adherent.nom']) ) ? $request['adherent.nom'] : null,
				'email'		  => (isset($request['adherent.email']) && $request['adherent.email'] != null ) ? $request['adherent.email'] : '', //$generate_email ,
				'password'    => bcrypt('secret'), 
				'tele'		  => 	 (isset($request['adherent.tele']) ) ? $request['adherent.tele'] : null,
				'tele_urgence'=> (isset($request['adherent.tele_urgence']) ) ? $request['adherent.tele_urgence'] : null,
				'date_naiss'  => date_format($date_naiss, 'Y-m-d H:i:s'), 
				'cin' 		  => (isset($request['adherent.cin'])) ? $request['adherent.cin'] : null ,
				'gender' 	  => (isset($request['adherent.gender'])) ? $request['adherent.gender'] : null ,
				'adresse' 	  => (isset($request['adherent.adresse'])) ? $request['adherent.adresse'] : null ,
				'image' 	  => $imgName,
				'is_valide'	  => 1,
				'id_adherent' => 1, 
				'id_user' 	  => 1
			]);

			$_code_client = strtoupper(substr($request['adherent.nom'], 0, 1 ) ) .  $adherent->id ;
			$adherent->update([
				'code_client' => $_code_client ,
				'qr_code' =>  $_code_client
			]);

		//$image   =  QrCode::format('png')->size(500)->errorCorrection('H')->generate($_code_client);
	    //$output_file = 'admin/adherents/qr_code/'. $_code_client .'.png';
	    //File::put($output_file, $image);


			$integration = Integration::create([  
				'id_adherent' =>  $adherent->id ,
				'date_debut'  => now() , 
			]);
     	}else {
       		$adherent = Adherent::where('code_client', $request['code_client'])
       							->orWhere('cin', $request['code_client'])
       							->first();
       		if (!$adherent) return response()->json(['adherent' => 'not_found',  'validator' => true]); // not exist

       		$adherent->update([
					'is_valide' => 1  
			]);
     	}

        if (isset($request['abonner'])) {

        	$abonner = Abonner::where('id_adherent', $adherent->id )
     					->where('has_new_abonnement', 0 ); 
			$is_abonner = $abonner;
			if($is_abonner->first()){ /// new code 12/03/2023
				DB::table('abonner_pack')
							->where('abonner_id', $abonner->first()->id)
							->update([
								'is_active' 	  	 => 0
							]);
				DB::table('abonner_pack')
							->where('abonner_id', $abonner->first()->id)
							->update([
								'is_active' 	  	 => 0
							]);
			}
     		$abonner->update(['has_new_abonnement' => 1 ]);			

        	/*$date_debut =   Carbon::parse(  new DateTime($request['abonner.date_debut'] ) ) ; //strtotime("+".$request['abonner.months']." months",strtotime($request['abonner.date_debut']));
        	//$date_fin = date('Y/m/d', $add_months ); 

        	$date_fin = ( Carbon::parse(  new DateTime($request['abonner.date_debut'] ) ))->addMonths($request['abonner.months']);*/
 

 			$date_debut = date_create( $request['abonner.date_debut']);
 			$date_fin = ( Carbon::parse( date_format($date_debut, 'Y-m-d H:i:s') ) )->addMonths( $request['abonner.months'] );
 
 			$promo = $request['abonner.promo'] ;
        	//$remise = ($request['abonner.nb_mois_abonnement'] * ( $request['abonner.prix_pack'] - $promo )) * ( $request['abonner.remise'] / 100 )  ;
        	$remise = ( ( $request['abonner.prix_pack'] - $promo )) * ( $request['abonner.remise'] / 100 )  ;

        	//$prix_ttc = ($request['abonner.nb_mois_abonnement'] * ( $request['abonner.prix_pack'] - $promo )) - $request['abonner.remise'] ;
        	$prix_ttc = (  ( $request['abonner.prix_pack'] - $promo )) - $request['abonner.remise'] ;


        	if (isset($request['paiements.date_echeance'])) {
        		$date_echeance = date_create( $request['paiements.date_echeance']); 
        		$date_echeance = date_format($date_echeance, 'Y-m-d H:i:s');
        	}else{
        		$date_echeance = null ; //date_create( $date_fin ); 
        	}
        	
        	

        	$abonner = Abonner::create([
				'id_adherent' 	 => $adherent->id ,
				'date_debut'  	 => date_format($date_debut, 'Y-m-d H:i:s') , 
				'date_fin' 		 => $date_fin ,
				'remise' =>  $request['abonner.remise'],
				'id_user' 	  	 => 1,
				'prix_ttc' => $prix_ttc,
				'paiament_date_echeance' => $date_echeance,
				'total_frais' => 0, 
				'id_pack' => $request['abonner.id_pack'],
				'id_abonnement' => $request['abonner.id_abonnement'],
				'completed_paiement' => 0
			]);

		    $abonner->abonnements()->attach($request['abonner.id_abonnement'] , [
		        'is_active' 	  	 => 1,
		        'date' => date_format($date_debut, 'Y-m-d H:i:s') 
		    ]);
		    $abonner->packs()->attach($request['abonner.id_pack'],[
		        'is_active' 	  	 => 1,
		        'promo' =>  (isset($request['abonner.promo'])) ? $request['abonner.promo'] : 0.00,
		        'date' => date_format($date_debut, 'Y-m-d H:i:s') 
		    ]);

		    /*** ajouter prix = 0 just pour sauvgarder id abonnement dans la table paiement **/ 
		    //$date_paiement = date_create( now());
		    $date_paiement = date_create( $request['paiements.date_paiement']);

	    	$paiements = Paiement::create([
					'date_paiement' =>  date_format($date_paiement, 'Y-m-d H:i:s'),
					'prix' 			=> 0,
					'id_abonner'	=> $abonner->id,
					'id_user' 		=> 1, 
					'id_pack' => $request['abonner.id_pack'],
					'id_abonnement' => $request['abonner.id_abonnement'],
					'id_adherent'   => $adherent->id
				]);
				/*** end ***/

		    if (isset($request['paiements']) && $request['paiements.prix'] > 0) {

					$paiements = Paiement::create([
						'date_paiement' =>  date_format($date_paiement, 'Y-m-d H:i:s')  , //date('Y/m/d', strtotime($request['paiements.date_paiement'])) , //now(),
						'prix' 			=> $request['paiements.prix'],
						'id_abonner'	=> $abonner->id,
						'id_user' 		=> 1, 
						'id_pack' => $request['abonner.id_pack'],
						'id_abonnement' => $request['abonner.id_abonnement'],
						'id_adherent'   => $adherent->id,
						'completed_paiement' => ($request['paiements.prix'] >= $prix_ttc) ? 1 : 0
 					]);
		    }

		    if (isset($request['arr_frais'])) {
		    	$prix_total_frais = 0;
		    	foreach( $request['arr_frais'] as $key => $frais){
		    		$object_to_array = explode(",", $frais);
 		    		//echo $object_to_array[0] . ' ,';
		    		//echo $object_to_array[1] . ' ,';
		    		$prix_total_frais = $prix_total_frais + $object_to_array[2] ;
		    		//echo '<br>';
		    		$fraisabonner = Fraisabonner::create([
		    			'id_abonner' => $abonner->id ,
		    			'id_assuranceps' =>  $object_to_array[0] ,
		    			'prix' => $object_to_array[2]
		    		]);
		    	}

				$new_prix_ttc = $prix_ttc + $prix_total_frais  ;
				$completed_paiement = 0 ;
				if (isset($request['paiements']) && $request['paiements.prix'] > 0){
					$completed_paiement = ($request['paiements.prix'] >= $new_prix_ttc) ? 1 : 0 ; 
				}

		    	$abonner->update([
		    		'total_frais' => $prix_total_frais,
		    		'prix_ttc' => ( $prix_ttc + $prix_total_frais ),
					'completed_paiement' => $completed_paiement
		    	]);

		    }		    

		    if (isset($request['assurance'])) {

        		//$add_months = strtotime("+".$request['assurance.duree_assurance']." days",strtotime( $request['assurance.date_assuree']));

        		//$date_fin = date('Y/m/d', $add_months ) ;

        		/*$assurance_date_debut = Carbon::parse(  new DateTime($request['assurance.date_assuree'] ) ) ;  
        		$assurance_date_fin =  Carbon::parse(  new DateTime($request['assurance.date_assuree'] ) )->addDays( $request['assurance.duree_assurance']); */

        		$assurance_date_debut = date_create( $request['assurance.date_assuree']);
 				$assurance_date_fin = ( Carbon::parse( date_format($assurance_date_debut, 'Y-m-d H:i:s') ) )->addMonths( $request['assurance.duree_assurance'] );

		    	$assurance = Assurance::create([
					'date_assuree'  => date_format($assurance_date_debut, 'Y-m-d H:i:s') ,// date('Y/m/d', strtotime($request['assurance.date_assuree'])) , //now(),
					'date_fin'      => $assurance_date_fin , //$date_fin , //now(),
					'prix' 			=> $request['assurance.prix_assurance'],
					'id_adherent'	=> $adherent->id,
					'id_assureur' 		=> 1
				]);
		    }

        }
	    $abonner = Abonner::with('adherent')->where('id', $abonner->id )->first();
			
		return response()->json(['adherent' => $abonner, 'validator' => true]);
    }


    public function suspend(Request $request) {
    	$date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request); 
		
    	$abonners = Abonner::where('suspend', 1)
    						 ->when( $date , function ($query, $date ) {
								     $query->whereBetween('suspended_at', [ $date ] ) ;
								})
     						->paginate(50);

    	return response()->json($abonners);
    }

    public function storeSuspend(Request $request) {
    	$abonner = Abonner::find($request['id_abonner']);
    	if ($abonner) {
    		$abonner->update([
    			'suspend' => 1,
    			'suspended_at' => now()
    		]);
    		Adherent::where('id', $request['id_adherent'])->update([
    			'is_valide' => 0
    		]);
    		return response()->json(true);
    	}	
    	return response()->json(false);
    }





    public function update(Request $request){ // Nouvelle abonner par adherent
     
        $abonner = Abonner::find($request['abonner.id']);

        if ($abonner) {
        	$date_debut = date_create( $abonner->date_debut );
 			$date_fin = ( Carbon::parse( date_format($date_debut, 'Y-m-d H:i:s') ) )->addMonths( $request['abonner.months'] );

        	//$add_months = strtotime("+".$request['abonner.months']." months",strtotime($abonner->date_debut));

        	//$date_fin = date('Y/m/d', $add_months ); 

        	$abonner->update([
				//'id_adherent' 	 => $adherent->id ,
				//'date_debut'  	 => date_format($date_debut, 'Y-m-d H:i:s'), // date('Y/m/d', strtotime($request['abonner.date_debut'])) ,
				'date_fin' 		 => $date_fin ,
				'remise' =>  $request['abonner.remise'],
			]);


        	$abonner->abonnements()->updateExistingPivot($request['abonner.old_id_abonnement'], [
			    'is_active' => 0,
			]);
		    $abonner->abonnements()->attach($request['abonner.new_id_abonnement'] , [
		        'is_active' 	  	 => 1,
		        'date' => now()
		    ]);

		    $abonner->packs()->updateExistingPivot($request['abonner.old_id_pack'], [
			    'is_active' => 0,
			]);
		    $abonner->packs()->attach($request['abonner.new_id_pack'] , [
		        'is_active' 	  	 => 1,
		        'promo' =>  (isset($request['abonner.promo'])) ? $request['abonner.promo'] : 0.00,
		        'date' => now()
		    ]);

		    if (isset($request['abonner.is_money'])) {
		    	$ismoney = Ismoney::create([
		    		'id_abonner' =>  $request['abonner.id'] ,
		    		'prix' => $request['abonner.is_money'],
		    		'date' => now()
		    	]);
		    }

		     $adherent = Adherent::with(['abonners'=> function ($abonners)  {
								$abonners->with('abonnements')->with('packs'); } ])->where('id', $abonner->id_adherent)->first();
			return response()->json($adherent);
        }
		return response()->json(false);
    }

    public function TotalPaiements (Request $request) {
    	$abonner = Abonner::where('id' , $request['id_abonner'])->first();
    	if ($abonner) {
    		$t_paiements = 0;
    		$t_ismoney = 0;
    		$paiements  = Paiement::where('id_abonner' , $request['id_abonner'])->get();
    		if ($paiements) 
    			$t_paiements = $paiements->sum('prix');
    		$ismoney 	= Ismoney::where('id_abonner' , $request['id_abonner'])->get();
    		if ($ismoney) 
    			$t_ismoney = $ismoney->sum('prix');  

    		return response()->json(['t_paiements' => $t_paiements, 't_ismoney' => $t_ismoney]);	
    	}
    	return response()->json(false);
    }


    public function StatistiquesAbonners(Request $request){
    


       $date = null ;
				if ( $request->has('filtrer.date') )
					$date = Helper::getDate($request); 

    	$packs    = DB::table('abonner_pack')
    					->join('packs', 'abonner_pack.pack_id', '=', 'packs.id')	
    					->select(
    						'packs.description', 'pack_id',  
    						DB::raw('count(pack_id) as counts'),
    						DB::raw("DATE_FORMAT(abonner_pack.date,'%Y') as year"),
    						DB::raw("DATE_FORMAT(abonner_pack.date,'%m') as month")
                        )
						//->where('is_active', 1)
    					->whereBetween('abonner_pack.date', [$date])
    					//->whereIn(DB::raw("DATE_FORMAT(abonner_pack.date,'%Y')"), $arr_years )
    					//->whereIn(DB::raw("DATE_FORMAT(abonner_pack.date,'%m')"), $arr_months )
				        ->groupBy('pack_id', 'packs.description', 'year', 'month' )
                       	->orderBy("counts", 'ASC')
                       	->get();

        $abonnements    = DB::table('abonnement_abonner')
    					->join('abonnements', 'abonnement_abonner.abonnement_id', '=', 'abonnements.id')	
    					->select(
    						'abonnements.libelle', 'abonnement_id',  
    						DB::raw('count(abonnement_id) as counts'),
    						DB::raw("DATE_FORMAT(abonnement_abonner.date,'%Y') as year"),
    						DB::raw("DATE_FORMAT(abonnement_abonner.date,'%m') as month")
                        )
						//->where('is_active', 1)
    					->whereBetween('abonnement_abonner.date', [$date])
    					//->whereIn(DB::raw("DATE_FORMAT(abonnement_abonner.date,'%Y')"), $arr_years )
    					//->whereIn(DB::raw("DATE_FORMAT(abonnement_abonner.date,'%m')"), $arr_months )
				        ->groupBy('abonnement_id', 'abonnements.libelle', 'year', 'month')
                       	->orderBy("counts", 'ASC')
                       	->get();


   		return response()->json([ 'packs' => $packs , 'abonnements' => $abonnements ]) ;
    } 


   public function dernierEnregistrement(){

   		if (isset($_GET['matricule'])) { 
	   		$adherent = Adherent::where('code_client', $_GET['matricule'])
	       							->orWhere('cin', $_GET['matricule'])
	       							->first();
	       	if (isset($adherent->id)) { 
		   		$abonners = Abonner::with(['abonnements', 'packs'])
		   							->where('id_adherent', $adherent->id)->orderBy('id', 'desc')
		   							->first();
		   		return response()->json([ 'abonners' =>$abonners ]) ;
		   	}
	   	}
	   	return response()->json([ 'abonners' => null ]) ;
   }





   public function historiquesAbonnementsByAdherent(Request $request){ 


		$date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request);  


		$adherents = Adherent::with(['abonners'=> function ($abonners) use ($request, $date) {
								 $abonners->with(['abonnements', 'packs', 'paiements']) 
								->whereHas('abonnements', function ($abonnements) use ($request, $date)  {
						            if ( isset($request['filtrer.abonnement_id']) && $request['filtrer.abonnement_id'] != '') 
							          	$abonnements->where('abonnements.id', '=' , $request['filtrer.abonnement_id']); 

							        //$abonnements->where('is_active' , 1);
								})
								->whereHas('packs', function ($packs) use ($request, $date)  {
							        if (   isset($request['filtrer.pack_id']) && $request['filtrer.pack_id'] != '' ) 
								        $packs->where('packs.id', '=' , $request['filtrer.pack_id']);
								    //$packs->where('is_active' , 1);
							    })
							    ->when( $date , function ($query, $date ) {
								     $query->whereBetween('date_fin', [ $date ] ) ;
								});
							    //->where('suspend', 0)
							    //->where('has_new_abonnement', 0);  
								if (isset($request['filtrer.symbole'] )) {
									$abonners->where('date_fin', $request['filtrer.symbole'] , now());
								}
							}])
							->whereHas('abonners', function ($abonners) use ($request, $date)  {
						        $abonners->whereHas('abonnements', function ($abonnements) use ($request, $date)  {
						            if ( isset($request['filtrer.abonnement_id']) && $request['filtrer.abonnement_id'] != '') 
							          	$abonnements->where('abonnements.id', '=' , $request['filtrer.abonnement_id']); 

							        //$abonnements->where('is_active' , 1);

								})
								->whereHas('packs', function ($packs) use ($request, $date)  {
							        if (   isset($request['filtrer.pack_id']) && $request['filtrer.pack_id'] != '' ) 
								        $packs->where('packs.id', '=' , $request['filtrer.pack_id']); 

							        //$packs->where('is_active' , 1);

								})
								->when( $date , function ($query, $date ) {
								     $query->whereBetween('date_fin', [ $date ] ) ;
								});
								//->where('suspend', 0)
								//->where('has_new_abonnement', 0) ;
								if (isset($request['filtrer.symbole'] )) {
									$abonners->where('date_fin', $request['filtrer.symbole'] , now());
								}
			})
			->where('code_client', $request['filtrer.matricule']);
 			
		$count_adherents = $adherents->count();
		$adherent = $adherents->orderBy('id', 'desc')->paginate(50);


		return response()->json(['adherent' => $adherent, 'count_adherents' => $count_adherents ]);
		
	}



	public function statistiauesAbonnementsVendus(Request $request) { 
				$date = null ;
				$date_debut =null;
				$date_fin=  null;
				if ($request->has('filtrer.date')){
					$date_debut = date_create( $request['filtrer.date.from']);
					$date_fin= date_create( $request['filtrer.date.to']);
					$date = Helper::getDate($request); 
				} 
				
					
				//$all_months = [1,2,3,4,5,6,7,8,9,10,11,12];
        //$arr_years = (isset($request['arr_years'])) ? $request['arr_years'] : [date('Y')] ;
        //$arr_months = (isset($request['arr_months'])) ? $request['arr_months'] : $all_months ; 

        $abonners_vendus = DB::table('abonners'); 
                    
        if (isset($request['filtrer.abonnement_id'])) {
             $abonners_vendus = $abonners_vendus->where('id_abonnement', $request['filtrer.abonnement_id']);
        }

        if (isset($request['filtrer.pack_id'])) {
             $abonners_vendus = $abonners_vendus->where('id_pack', $request['filtrer.pack_id']);
        } 

        $abonners_vendus = $abonners_vendus->select(
                        DB::raw('sum(abonners.prix_ttc) as sums'), 
                        DB::raw("DATE_FORMAT(abonners.date_debut,'%m / %Y') as months"),
                        DB::raw("DATE_FORMAT(abonners.date_debut,'%m') as monthKey"),
                         DB::raw("DATE_FORMAT(abonners.date_debut,'%Y') as year")
                    );


        if (isset($request['filtrer.addSelectDay']) && $request['filtrer.addSelectDay'] == 'true') {
        	$abonners_vendus = $abonners_vendus->addSelect( 
	                       DB::raw("DATE_FORMAT(abonners.date_debut,'%d') as dayKey")
	                     ); 
        }
		if (isset($request['filtrer.id_empreinte']) && $request['filtrer.id_empreinte'] != '') {
            $adherent = Adherent::where('id_empreinte', $request['filtrer.id_empreinte'] ) ;}
                             //   ->orWhere('cin', $request['filtrer.code_client'] )
                             

        if (isset($request['filtrer.code_client']) && $request['filtrer.code_client'] != '') {
            $adherent = Adherent::where('code_client', $request['filtrer.code_client'] )
                                ->orWhere('cin', $request['filtrer.code_client'] )
                                ->first();
            if (!$adherent) {
            	  return response()->json( ['adherent' => 'not_found']);
				 // return response()->json(['date' => date('Y-m-d', strtotime($date[0]))]);
            }

            $abonners_vendus = $abonners_vendus->where('abonners.id_adherent', $adherent->id );
        }
        
        if(isset($request['filtrer.year']) && isset($request['filtrer.month'])){
        		$month = $request['filtrer.month'] ;
		        $year = $request['filtrer.year'] ; 
        		$abonners_vendus = $abonners_vendus
        											//	->where(DB::raw("DATE_FORMAT(abonners.date_debut,'%m')"),  $month )
                               // ->where(DB::raw("DATE_FORMAT(abonners.date_debut,'%Y')"), $year )
                                ->whereBetween('abonners.date_debut', [$date_debut,$date_fin])
                                ->groupBy('months', 'monthKey', "year", "dayKey")
								->orderBy("dayKey", 'ASC');
        }else{
        	$abonners_vendus = $abonners_vendus
                               ->whereBetween('abonners.date_debut', [$date_debut,$date_fin])
                               ->groupBy('months', 'monthKey', "year")
							   ->orderBy("monthKey", 'ASC');
        }
	
        
		$abonners_vendus = $abonners_vendus->orderBy("year", 'ASC')->get();
	
	
	return response()->json( ['abonners_vendus' => $abonners_vendus, 'abns' => [], 'date' => strftime("%A %d %B") ]);
    }


    public function SupprimerAbonnement(Request $request)
    {
    		if (isset($request['id_abonner'])) {
    				$abonner = Abonner::find($request['id_abonner']);
     				if ($abonner) {
     							$abonner->abonnements()->detach();
    							$abonner->packs()->detach();
    							$abonner->paiements()->delete();
    							$abonner->isMoneys()->delete();
    							$abonner->empeches()->delete();
    							$abonner->delete();

    							$back_has_new_abonnement = Abonner::where('id_adherent', $abonner->id_adherent)
    																					->where('has_new_abonnement', 1)->latest()->first();

    							if ($back_has_new_abonnement) {
    								$back_has_new_abonnement->update([
    										'has_new_abonnement' => 0
    								]);
    							}
    							
    						  return response()->json(['etat' => true ]);

    				}
    		}
    		return response()->json(['etat' => false ]);
    }

    
}
