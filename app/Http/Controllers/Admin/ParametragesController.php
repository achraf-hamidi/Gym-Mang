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
use App\Assurancep;
use App\Ismoney;
use App\Integration;
use App\Paiement;
use App\Promotion;
use App\Empeche;
use App\Categorie;
use App\Service;
use File;
use QrCode;
use DateTime; 
use DB;


class ParametragesController extends Controller
{

	public function Categories(Request $request){
		$categories = Categorie::orderBy('id', 'desc')->paginate(10);
		return response()->json($categories);
	}

    public function storeCategorie(Request $request){
		Categorie::create([
			'nom' => ($request->nom != '' && $request->nom != null) ? $request->nom : null ,
				'description' => ($request->description != '' && $request->description != null) ? $request->description : null , 
				'type_id' => $request->type_id
		]);
	    $categorie = Categorie::latest()->first();
		return response()->json($categorie);
    }

    public function updateCategorie(Request $request) {
    	$categorie = Categorie::where('id', $request['categorie_id'])->first(); 
    	if ($categorie) { 
    		$categorie->update([
    			'nom' => ($request->nom != '' && $request->nom != null) ? $request->nom : null ,
				'description' => ($request->description != '' && $request->description != null) ? $request->description : null , 
				'type_id' => $request->type_id
			]); 
    		$categorie = Categorie::where('id', $request['categorie_id'])->first();	
			return response()->json($categorie);

    	}

		return response()->json(false);
		
    }
    public function destroyCategorie(Request $request) {
    	$categorie = Categorie::find($request['categorie_id']);
    	if ($categorie) {
    		//$ifRelationShip = DB::table('services')->where('categorie_id', $request['categorie_id'])->exists();
 
    		if (count($categorie->services) > 0 ) {
    			return response()->json('relationship');
    		}else{
    			$categorie->delete();
				return response()->json(true);
    		} 
    		
    	}
		return response()->json(false);
    }



    /*** services ****/

    public function Services(Request $request){
		$services = Service::with('categorie')->orderBy('id', 'desc')->get();
		return response()->json($services);
	}

	public function storeService(Request $request){

		$service = Service::create([
			'nom' => ($request->nom != '' && $request->nom != null) ? $request->nom : null ,
				'description' => ($request->description != '' && $request->description != null) ? $request->description : null ,
				'prix' => ($request->prix != '' && $request->prix != null) ? $request->prix : null ,
				'categorie_id' => $request->categorie_id,
		]); 
        $service_create = Service::with('categorie')->latest()->first();
		return response()->json($service_create);
    }

    public function updateService(Request $request){
    	$service = Service::where('id', $request['service_id'])->first(); 
    	if ($service) {
    		$service->update([
				'nom' => ($request->nom != '' && $request->nom != null) ? $request->nom : null ,
				'description' => ($request->description != '' && $request->description != null) ? $request->description : null ,
				'prix' => ($request->prix != '' && $request->prix != null) ? $request->prix : null ,
				'categorie_id' => $request->categorie_id,
			]); 
 	       	$service_ = Service::with('categorie')->where('id', $request['service_id'])->first();
			return response()->json($service_);
    	}
    }

    public function destroyService(Request $request) {
    	$service = Service::find($request['service_id']);
    	if ($service) { 
    		 	

    		//printf($service->depences);
    		//echo count($service->depences) ;  
    		//echo count($service->recettes) ; 
    		//echo count($service->depences) ;
    		//return response()->json('relationship');

			if ( count($service->recettes) > 0 ||count($service->depences) > 0 ) {
    			return response()->json('relationship');
    		}else{
    			$service->delete();
				return response()->json(true);
    		} 
    	}
		return response()->json(false);
    }

    /*** end services **/

    
    public function Activities(Request $request){
		$activities = Activitie::orderBy('id', 'desc')->paginate(10);
		return response()->json($activities);
	}

    public function storeActivitie(Request $request){
    	$imgName = 'default.jpg' ;

    	if ($request->has('image')) { 
	    	$imgName = str_replace(array(" ","'",":",",",";",".", "?", "!"), '_', $request->name ) . '_' . time() . '.'. $request->image->extension();  
	        $request->image->move(public_path('admin/activities'), $imgName);
	    }

		Activitie::create([
			'name' => $request->name,
			'image' => $imgName
		]);
	    $activitie = Activitie::latest()->first();
		return response()->json($activitie);
    }

    public function updateActivitie(Request $request) {
    	$activitie = Activitie::where('id', $request['activitie_id'])->first(); 
    	if ($activitie) {
    		$imgName = $activitie->image ;
    		/*if ($activitie->image != "default.jpg" && $activitie->image != '') 
	        	$imgName = $activitie->image ;
	        else*/
	         if($request->has('image'))
	        	$imgName = str_replace(array("/"," ","'",":",",",";",".", "?", "!"), '_', $request->name ) . '_' . time() . '.'. $request->image->extension();  
	        
	        if ($request->image && $request->image != null && $request->image != '') 
	        	$request->image->move(public_path('admin/activities'), $imgName );
        	
    		$activitie->update([
				'name' => $request->name,
				'image' => $imgName
			]); 
    		$activitie = Activitie::where('id', $request['activitie_id'])->first();	
			return response()->json($activitie);

    	}

		return response()->json(false);
		
    }
    public function destroyActivitie(Request $request) {
    	$activitie = Activitie::find($request['activitie_id']);
    	if ($activitie) {
    		$ifRelationShip = DB::table('activitie_pack')->where('activitie_id', $request['activitie_id'])->exists();
    		if ($ifRelationShip) 
    			return response()->json('relationship');

    		if ($activitie->image != "default.jpg" && $activitie->image != "" && $activitie->image != null) {
    			$output_file = 'admin/activities/'. $activitie->image;
	       		File::delete($output_file);
    		}
    		$activitie->delete();
			return response()->json(true);
    	}
		return response()->json(false);
    }

   	public function isPackActivities(Request $request){ // check pack activities if exist
    	if(!isset($request['pack_id'])) {
    		$packs = Pack::with('activities')
						  ->where('id_abonnement', $request['id_abonnement'])
						  ->get();
			$arr = array() ;
	    	foreach ($packs as $pack) {
		        foreach ($pack->activities as $key => $activitie) {
					$arr[$pack->id][$key] =  $activitie->pivot->activitie_id;
		        }
	        }
	        $b = $request['value_activities'];
	        foreach ($arr as $key => $a) {
				sort($a); sort($b);
				if( $a == $b && count($b) == count($a))
				    return response()->json(true);	 // exist
	        }
			return response()->json(false); // not exist
    	}else {
    		return response()->json(false);
    	}
    	
    }

	public function Packs(Request $request){
		$packs = Pack::with(['activities', 'abonnement'])->orderBy('id', 'desc')->get();
		return response()->json($packs);
	}

	public function storePack(Request $request){
 
		$pack = Pack::create([
			'description' => ($request->description != '' && $request->description != null) ? $request->description : null , 
			'prix' => $request->prix,
			'id_abonnement' => $request->id_abonnement,
		]);

        foreach ($request['value_activities'] as $activitie) {
            $pack->activities()->attach([
                //'pack_id' => $pack->id,
                'activitie_id' => $activitie
            ]);
        }
        $vpack = Pack::with(['activities', 'abonnement'])->latest()->first();
		return response()->json($vpack);
    }

    public function updatePack(Request $request){
    	$pack = Pack::where('id', $request['pack_id'])->first(); 
    	if ($pack) {
    		$pack->update([
				'description' => ($request->description != '' && $request->description != null) ? $request->description : null , 
				'prix' 		  => $request->prix,
				'id_abonnement' => $request->id_abonnement,
			]);

    		$pack->activities()->detach(); // remove all activities
	        foreach ($request['value_activities'] as $activitie) {
	            $pack->activities()->attach([
	                'activitie_id' => $activitie
	            ]);
	        }
	        $pack->load('activities');
	       	$pack_ = Pack::with(['activities', 'abonnement'])->where('id', $request['pack_id'])->latest()->first();
			return response()->json($pack_);
    	}
		
    }

    public function destroyPack(Request $request) {
    	$pack = Pack::find($request['pack_id']);
    	if ($pack) {
    		$ifRelationShip = DB::table('abonner_pack')->where('pack_id', $request['pack_id'])->exists();
    		if ($ifRelationShip) 
    			return response()->json('relationship');

    		DB::table('activitie_pack')->where('pack_id', $request['pack_id'])->delete();
    		
    		$pack->delete();
			return response()->json(true);
    	}
		return response()->json(false);
    }



    public function Promotions(Request $request){
		$promotions = Promotion::with('pack')->orderBy('id', 'desc')->paginate(10);
		return response()->json($promotions);
	}

	public function storePromotion(Request $request){
		$imgName = 'default.jpg' ;
    	if ($request->has('image')) { 
			$imgName = str_replace(array("/"," ","'",":",",",";",".", "?", "!"), '_', $request->description ) . '_' . time() . '.'. $request->image->extension();  
	        $request->image->move(public_path('admin/promotions'), $imgName);
	    }

	     $date_debut = date_create( $request['date_debut']);
	     $date_fin = date_create( $request['date_fin']);
	     
		$promo = Promotion::create([
			'description' => ($request->description != '' && $request->description != null) ? $request->description : null , 
			'date_debut' =>  date_format($date_debut, 'Y-m-d H:i:s')  , 
			'date_fin' =>  date_format($date_fin, 'Y-m-d H:i:s')  , 
			'remise' => $request->remise,
			'id_pack' => $request->id_pack,
			'image' => $imgName,
			'id_user' => 1
		]);
		$promotion = Promotion::with('pack')->where('id',  $promo->id )->first();
 
 		return response()->json($promotion);
    }

    public function updatePromotion(Request $request) {
    	$promotion = Promotion::where('id', $request['promotion_id'])->first(); 
    	if ($promotion) {
    		if ($promotion->image != "default.jpg" && $promotion->image != '')
	        	$imgName = $promotion->image ;
	        else 
	        	$imgName = str_replace(array("/"," ","'",":",",",";",".", "?", "!"), '_', $request->description ) . '_' . time() . '.'. $request->image->extension();  
	        
	        if ($request->image && $request->image != null && $request->image != '') 
	        	$request->image->move(public_path('admin/promotions'), $imgName );



	        $date_debut = date_create( $request['date_debut']);
	        $date_fin = date_create( $request['date_fin']);


    		$promotion = $promotion->update([
				'description' => ($request->description != '' && $request->description != null) ? $request->description : null , 
				'date_debut' =>  date_format($date_debut, 'Y-m-d H:i:s') , 
				'date_fin' =>  date_format($date_fin, 'Y-m-d H:i:s') , 
				'remise' => $request->remise,
				'id_pack' => $request->id_pack,
				'image' => $imgName
			]);
			$promotion = Promotion::with('pack')->where('id',  $request['promotion_id'] )->first();
			return response()->json($promotion);
    	}

		return response()->json(false);
		
    }

    public function destroyPromotion(Request $request) {
    	$promotion = Promotion::find($request['promotion_id']);
    	if ($promotion) {

    		//if (!isset($promotion->pack)) { 
	    		if ($promotion->image != "default.jpg" && $promotion->image != "" && $promotion->image != null) {
	    			$output_file = 'admin/promotions/'. $promotion->image;
		       		File::delete($output_file);
	    		}
	    		$promotion->delete();
				return response()->json(true);
	    	//}else{
	    	//	return response()->json('relationship');
	    	//}
	    }
		return response()->json(false);
    }

    /*#### Abonnements #######*/

    public function Abonnements(Request $request){

    	/*$abonner = Abonner::create([
			'date_debut' => now(),
			'date_fin' => now(),
			'id_adherent' => 2,
			'remise' => 35,
			'id_user' => 1,
		]);

	    $abonner->abonnements()->attach([
	        'abonnement_id' => 3,
	        //'abonner_id' => $abonner->id
	    ]);

	    $abonner->packs()->attach([
	        'pack_id' => 3,
	        //'abonner_id' => $abonner->id
	    ]);*/



		$abonnements = Abonnement::with(['abonners'=> function ($query) {
								   $query->where('date_fin' , '<', now())
								   		 ->wherePivot('is_active', 1)->get();
								}]) 
								->orderBy('id', 'desc')->get();
        /*$filter = 0; // All filter Abonners 
		$abonner = Abonner::with(['abonnements', 'packs'])
							->whereHas('abonnements', function ($q) use ($filter)  {
					            if ($filter == 0) 
						          	$q->where('abonnements.id', '=' , 1);
						        if ($filter == 0)
						         	$q->where('is_active', 0);
							})
							->whereHas('packs', function ($q) use ($filter)  {
						        if ($filter == 0) 
							        $q->where('packs.id', '=' , 2);
						        if ($filter == 0)
						          	$q->where('is_active', 0);
							})
							//->where('date_fin' , '>=', now())
							->orderBy('id', 'desc')->get();

		dd($abonner);*/
		// By Adherent
		/*$abonner = Abonner::with(['abonnements' => function($q) {
						  		$q->where('is_active', 1);
						  }, 'packs' => function($q) {
						  		$q->where('is_active', 1);
						  }])
						  ->whereHas('abonnements', function($q) {
						  		$q->where('is_active', 1);
						  })
						  ->whereHas('packs', function($q) {
						  		$q->where('is_active', 1);
						  })
						  ->where('id_adherent', 6)
						  //->where('date_fin' , '>=', now())
						  ->orderBy('id', 'desc')->first();

			

	if($abonner){ 

		$abonner->abonnements()->updateExistingPivot( 
                $abonner->abonnements[0]->id ,[
                'is_active' => 0,
                ]
            );
            $abonner->packs()->updateExistingPivot( 
                $abonner->packs[0]->id ,[
                'is_active' => 0,
                ]
            );

			$abonner->abonnements()->attach( 2,  //'abonnement_id' => 3,
			    [ 'is_active' => 1, 'date' => now() ]
			);

		    $abonner->packs()->attach(2, //'pack_id' => 2,
		       [ 'is_active' => 1 , 'date' => now()   ]
			);*/



       /*$paiements = DB::table('paiements')
	                ->select('id_abonner', DB::raw('SUM(prix) as total_paiements'))
	                ->where('id_abonner' , $abonner->id )
	                ->groupBy('id_abonner')
	                ->first();

	    $Ismoney = DB::table('ismoneys')
	                ->select('id_abonner', DB::raw('SUM(prix) as total_moneys'))
	                ->where('id_abonner' , $abonner->id )
	                ->groupBy('id_abonner')
	                ->first();

	    $ismoneys = ($Ismoney != null) ? $Ismoney->total_moneys : 0 ;

		echo "<span style='font-weight : bold;' >Type d'abonnement : </span>" . $abonner->abonnements[0]->libelle  . "<br> <br>" ;

		echo "<span style='font-weight : bold;' >Prix total de pack par mois : </span>" . $abonner->packs[0]->prix   . " Dh <br> <br>";

		echo "<span style='font-weight : bold;' >Remise pour le client : </span>" . $abonner->remise   . " Dh <br> <br>";

		echo "<span style='font-weight : bold;' >Prix total d'engagement : </span> (" . $abonner->abonnements[0]->nb_mois .'*'. $abonner->packs[0]->prix .') - ' . $abonner->remise . ' = '   . (($abonner->abonnements[0]->nb_mois * $abonner->packs[0]->prix ) - $abonner->remise ) ."  Dh avec  type d'abonnement " . $abonner->abonnements[0]->libelle . " <br> <br>";

		echo "<span style='font-weight : bold;' >Total de paiements de cette abonnement est : </span>" . $paiements->total_paiements  . " Dh <br> <br>";

		echo "<span style='font-weight : bold;' >Les prix retourner (cas de changement le type d'abonnement ou Pack) : </span>" . $ismoneys  . " Dh <br> <br>";

		echo "<span style='font-weight : bold;' >Total de paiements - prix retourner : </span>" . $paiements->total_paiements .'Dh - ' . $ismoneys  .'Dh = ' .($paiements->total_paiements - $ismoneys  ) . " Dh c'est le montant dans la caisse <br> <br>";

		$calc = ( (($abonner->abonnements[0]->nb_mois * $abonner->packs[0]->prix ) - $abonner->remise ) - ( $paiements->total_paiements - $ismoneys) ) ;

		echo (($calc >= 0 ) ? "<span style='font-weight : bold;' >Montant restant à payer : </span>" : "<span style='font-weight : bold;' >Le montant restant est retourné au client : </span>"  ) .  '(('.$abonner->abonnements[0]->nb_mois .'*'. $abonner->packs[0]->prix .')'. '-'. $abonner->remise .') - ('. $paiements->total_paiements .'-'. $ismoneys.') = '  .  $calc . " Dh";


		$backMoney = Ismoney::create([
			'id_abonner' => $abonner->id,
			'prix' => abs($calc),
			'date' => now()
		]);

	/*}else {
		echo "Votre abonnements est bloquee";
	}*/

		return response()->json($abonnements);
	}

	public function storeAbonnement(Request $request){
		Abonnement::create([
			'libelle' => ($request->libelle != '' && $request->libelle != null) ? $request->libelle : null , 
			'nb_mois' => ($request->nb_mois != '' && $request->nb_mois != null) ? $request->nb_mois : null 
		]); 
        $abonnement = Abonnement::with('abonners')->latest()->first();
		return response()->json($abonnement);
    }

    public function updateAbonnement(Request $request){
    	$abonnement = Abonnement::where('id', $request['abonnement_id'])->first();
    	if ($abonnement) {
    		$abonnement->update([
				'libelle' => ($request->libelle != '' && $request->libelle != null) ? $request->libelle : null , 
				'nb_mois' => ($request->nb_mois != '' && $request->nb_mois != null) ? $request->nb_mois : null 
			]); 
			return response()->json($abonnement);
    	}
		return response()->json(false);
		
    }

    public function destroyAbonnement(Request $request) {
    	$abonnement = Abonnement::find($request['abonnement_id']);
    	if ($abonnement) {
    		$ifRelationShip = DB::table('abonnement_abonner')->where('abonnement_id', $request['abonnement_id'])->exists();
    		if ($ifRelationShip) 
    			return response()->json('relationship');

    		$abonnement->delete();
			return response()->json(true);
    	}
		return response()->json(false);
    }



    ############# Assurances ############


    public function TousLesFrais(Request $request){
		$tous_les_frais = Assurancep::with(['typefrais' => function($query) {
											//$query->where('id', '<>', 1);
									}])
									->whereHas('typefrais', function($query) {
											$query->where('id', '<>', 1);
									})
									->orderBy('id', 'desc')->get();

		return response()->json([ 'tous_les_frais' => $tous_les_frais]);
	}


	public function Typefrais(Request $request){
		$typefrais = DB::table('typefrais')->orderBy('id', 'desc')->get();
		return response()->json(['typefrais' => $typefrais]);
	}


    public function Assurances(Request $request){
		$tous_les_frais = Assurancep::with(['typefrais']);
		$assurances = null;
		if (isset($_GET['type_frais'])) { // type assurance
    		$assurances = $tous_les_frais->where('id_typefrais', $_GET['type_frais'])
    								     ->orderBy('id', 'desc')->get();
    	}
    	
    	$autres_frais = null;
    	if (isset($_GET['autres_type_frais'])) {
    		$autres_frais = $tous_les_frais->where('id_typefrais', '<>', $_GET['type_frais'])
    									   ->orderBy('id', 'desc')->get();
    	}

    	$tous_les_frais = $tous_les_frais->orderBy('id', 'desc')->get();

		return response()->json(['assurances' => $assurances, 'autres_frais' => $autres_frais, 'tous_les_frais' => $tous_les_frais]);
	}

	public function storeAssurance(Request $request){
		Assurancep::create([
			'id_typefrais' => $request->id_typefrais,
			'libelle' => $request->libelle,
			'nb_mois' => (isset($request->nb_mois) && $request->nb_mois > 0 ) ? $request->nb_mois : 0 ,
			'prix' => $request->prix
		]); 
        $assurance = Assurancep::with(['typefrais'])->latest()->first();
		return response()->json($assurance);
    }

    public function updateAssurance(Request $request){
    	$assurance = Assurancep::with(['typefrais'])->where('id', $request['assurance_id'])->first();
    	if ($assurance) {
    		$assurance->update([
    			'id_typefrais' => $request->id_typefrais,
				'libelle' => $request->libelle,
				'nb_mois' => (isset($request->nb_mois) && $request->nb_mois > 0 ) ? $request->nb_mois : 0 ,
				'prix' => $request->prix
			]); 
			return response()->json($assurance);
    	}
		return response()->json(false);
		
    }

    public function destroyAssurance(Request $request) {
    	$assurance = Assurancep::find($request['assurance_id']);
    	if ($assurance) {
    		//$ifRelationShip = DB::table('assurance_abonner')->where('assurance_id', $request['//assurance_id'])->exists();//
    		//if ($ifRelationShip) 
    		//	return response()->json('relationship');

    		//$assurance->delete();
			//return response()->json(true);


			if (count($assurance->fraisabonner) > 0 ) {
    			return response()->json('relationship');
    		}else{
    			$assurance->delete();
				return response()->json(true);
    		} 


    	}

		return response()->json(false);
    }

}
