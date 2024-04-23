<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Adherent;
use App\Assurance;
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
use Carbon\Carbon; 

class AdherentsController extends Controller
{
   

    public function index(Request $request){ // La liste des adhérents
		$date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request); 
	
		//	echo $request['filtrer.is_valide'] ;
		$is_valide = (isset($request['filtrer.is_valide'])) ? [ $request['filtrer.is_valide'] ] : [1,0] ;

		$genre = (isset($request['filtrer.genre']) && $request['filtrer.genre'] != '') ? [ $request['filtrer.genre'] ] : ['Homme','Femme'] ;


		$adherents = Adherent::with(['parent'])
									 ->whereIn('is_valide' , $is_valide )
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

		$adherents = $adherents->when( $date , function ($query, $date ) {
							     $query->whereBetween('created_at', [ $date ] ) ;
							})						    
						    ->orderBy('id', 'desc');

		$count_adherents = $adherents->count();
		$adherent = $adherents->paginate(50);

		return response()->json(['adherent' => $adherent, 'count_adherents' => $count_adherents ]);
	}
	public function store(Request $request){

		$latestAdherent = Adherent::latest('id_empreint')->first();
		$newIdEmpreint = ($latestAdherent) ? $latestAdherent->id_empreint + 1 : 1;


		$imgName = (isset($request['adherent.gender']) && $request['adherent.gender'] == "Homme") ? 'homme.png' : 'femme.png' ;

		if (isset($request['adherent.image'])) {
			$imgName = str_replace(array(" ","'",":",",",";",".", "?", "!"), '_', $request['adherent.nom'] ) . '_' . time() . '.'. $request['adherent.image']->extension();  
	        $request['adherent.image']->move(public_path('admin/adherents/photos'), $imgName);
		}

		$qr_code = $request['adherent.cin'] .'_'. time() ;
        $image   =  QrCode::format('png')->size(500)->errorCorrection('H')->generate($qr_code);
        $output_file = 'admin/adherents/qr_code/'. $qr_code .'.png';
        File::put($output_file, $image);

        $code_client = strtoupper(substr($request['adherent.nom'], 0, 2 ) ) . rand(1111, 9999) ;
        $parrain = null;
        if ( isset($request['adherent.parrain'])) {
        	$parrain = Adherent::where('code_client', $request['adherent.parrain'])->first();
        }


         $date_naiss =date_create($request['adherent.date_naiss']);
            $date_naiss = ( Carbon::parse( date_format($date_naiss, 'Y-m-d H:i:s') ) ) ; //->subDays(10);
		$adherent = Adherent::create([
			'code_client' => $code_client ,
			'qr_code' 	  => ($qr_code) ? $qr_code : '' ,
			'nom' 		  => $request['adherent.nom'],
			'email'		  => $request['adherent.email'],
			'password'    => bcrypt($code_client), 
			'tele'		  => $request['adherent.tele'],
			'tele_urgence'=> $request['adherent.tele_urgence'],
			'date_naiss'  =>  $date_naiss ,
			'cin' 		  => ($request['adherent.cin']) ? $request['adherent.cin'] : '' ,
			'gender' 	  => ($request['adherent.gender']) ? $request['adherent.gender'] : 'Homme' ,
			'adresse' 	  => ($request['adherent.adresse']) ? $request['adherent.adresse'] : '' ,
			'image' 	  => $imgName,
			'is_valide'	  => 1,
			'id_adherent' => (isset($parrain)) ? $parrain->id : 1, 
			'id_empreinte' => $newIdEmpreint, 
			'id_user' 	  => 1
		]);

		$integration = Integration::create([  
			'id_adherent' =>  $adherent->id ,
			'date_debut'  => now()
		]); 
		$solde = Solde::create([  
			'code_client' =>  $code_client ,
			'solde'  => 0
		]); 
	    //$adherent = Adherent::latest()->first();
		return response()->json($adherent);
    }

    public function update(Request $request){

		$adherent = Adherent::where('code_client', $request['adherent.code_client'] )
					->orwhere('id_empreinte', $request['adherent.id_empreinte'])
					->first();
		$email_adherent = Adherent::whereNotNull('email')
											->where('email', $request['adherent.email'] )
											->where('code_client', '<>', $request['adherent.code_client']  )
											->where('id_empreinte', '<>', $request['adherent.id_empreinte']  )
											->first();
		$is_empriente_existe = Adherent::whereNotNull('id_empreinte')
											->where('id_empreinte', $request['adherent.id_empreinte'] )
											->where('code_client', '<>', $request['adherent.code_client']  )
											->first();


		if ($email_adherent) {
			return response()->json(['email_adherent' => 'exists']);
		}
		// if ($is_empriente_existe) {
		// 	return response()->json(['empriente_existe' => 'exists']);
		// }
 
		if (isset($request['adherent.image'])) {
			$gender = array("femme.png", "homme.png");
			if ( in_array($adherent->image, $gender) || $adherent->image == '' || $adherent->image == null ) {
			  	$imgName = str_replace(array("/"," ","'",":",",",";",".", "?", "!"), '_', $request['adherent.nom'] ) . '_' . time() . '.'. $request['adherent.image']->extension();
			}else
				$imgName = $adherent->image ; 

	        $request['adherent.image']->move(public_path('admin/adherents/photos'), $imgName);        
		}

		$date_naiss = (isset($request['adherent.date_naiss'])) ? date_create( $request['adherent.date_naiss']) : null;
 		
		if ($adherent) {
			$adherent->update([ 
				//'id_empreinte' 		  => (isset($request['adherent.id_empreinte']) ) ? $request['adherent.id_empreinte'] : null,
				'nom' 		  => (isset($request['adherent.nom']) ) ? $request['adherent.nom'] : null,
				'email'		  => (isset($request['adherent.email']) ) ? $request['adherent.email'] : null,
				'tele'		  => (isset($request['adherent.tele']) ) ? $request['adherent.tele'] : null,
				'tele_urgence'=> (isset($request['adherent.tele_urgence']) ) ? $request['adherent.tele_urgence'] : null,
				'date_naiss'  => date_format($date_naiss, 'Y-m-d H:i:s') ,
				'cin' 		  => (isset($request['adherent.cin'])) ? $request['adherent.cin'] : null ,
				'gender' 	  => (isset($request['adherent.gender'])) ? $request['adherent.gender'] : null ,
				'adresse' 	  => (isset($request['adherent.adresse'])) ? $request['adherent.adresse'] : null ,
				'image' 	  => (isset($imgName)) ? $imgName : $adherent->image
			]); 
			return response()->json(true);
		}
		return response()->json(false);
    }

    public function Badge(Request $request) {
		$date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request); 


		$genre = (isset($request['filtrer.genre']) && $request['filtrer.genre'] != '') ? [ $request['filtrer.genre'] ] : ['Homme','Femme'] ;


    	$adherents = Adherent::when( $date , function ($query, $date ) {
							     $query->whereBetween('created_at', [ $date ] ) ;
							})
    					  ->whereIn('gender' , $genre );

    	//if (isset($request['filtrer.code_client'])) 
    	//	$adherents = $adherents->where("code_client", $request['filtrer.code_client']);


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


	    $adherents = $adherents->orderBy('id', 'desc')->paginate(50); 
		return response()->json(['adherents' => $adherents ]);
    }


    public function Assurances(Request $request) {   		
		$date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request); 
		

		$genre = (isset($request['filtrer.genre']) && $request['filtrer.genre'] != '') ? [ $request['filtrer.genre'] ] : ['Homme','Femme'] ;


    	 $adherents = Adherent::with(['latestAssurance'=> function ($latestAssurance) use ($request, $date) {
									$latestAssurance->when( $date , function ($query, $date ) {
									     $query->whereBetween('date_assuree', [ $date ] ) ;
									});
									//->whereBetween('date_assuree', [ $date ]);
							   }])
    	 ->whereHas('latestAssurance', function ($latestAssurance) use ($request, $date)  {
									$latestAssurance->when( $date , function ($query, $date ) {
									     $query->whereBetween('date_assuree', [ $date ] ) ;
									});
									//->whereBetween('date_assuree', [ $date ]);
					})->whereIn('gender', $genre);

    	//if (isset($request['filtrer.code_client'])) {
    	//	$adherents = $adherents->where('code_client', $request['filtrer.code_client'] ) ; 
    	//}

    	if(isset($request['filtrer.nom']) && $request['filtrer.nom'] != ''){
			$adherents =$adherents->where('nom', 'like', '%'.$request['filtrer.nom'].'%'); 
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

    	 $adherents = $adherents->orderBy('id', 'desc')->paginate(50); 
    	 return response()->json(['adherents' => $adherents ]); 
    }

    public function AssurancesAdherent(Request $request, $code ) {
    	
    	$adherent = Adherent::where('code_client', $code )->first(); 
    	if ($adherent) {

    		$date = null ;
			if ( $request->has('filtrer.date') )
    			$date = Helper::getDate($request); 

	    	$assurances = Assurance::with('adherent');
	    	
	    	if ($date != null) {
	    		$assurances = $assurances->whereBetween('date_assuree', [ $date ]);
	    	}
	    	$assurances = $assurances->where("id_adherent", $adherent->id )
											 ->orderBy('id', 'desc');

			if (isset($request['filtrer.take']) && $request['filtrer.take'] != '') {
				$assurances = $assurances->take($request['filtrer.take'])->get();
			}else {
				$assurances = $assurances->paginate(12); 
			}

			return response()->json(['adherent' => $adherent  , 'assurances' => $assurances ]);
    	}else
    		return response()->json(false); 

    }


    public function CheckAdherentIsExiste(Request $request) {
    	$adherent = Adherent::where('code_client', $request->code_client )
						->orwhere('id_empreinte', $request->code_client )
						->first();
    	$response = array();
    	if ($adherent) {
    		$dernier_enregistrement = $adherent->abonners()
    													  ->with(['abonnements', 'packs'])
    													  ->orderBy('id', 'desc')
		   											  ->first();
    		$is_assuree = Assurance::where([
				    							["id_adherent", $adherent->id ],
				    							['date_fin' , '>' , now() ]
				    						])->orderBy('id', 'desc')
				    						->first();
    						
    		array_push($response, ['adherent' => $adherent]);
    		array_push($response, ['is_assuree' => $is_assuree]);
    		array_push($response, ['dernier_enregistrement' => $dernier_enregistrement]); 
    		
    		return response()->json($response); 
    	}
    	array_push($response, ['adherent' => null]);
    		array_push($response, ['is_assuree' => null]);
    		array_push($response, ['dernier_enregistrement' => null]); 


    	return response()->json($response); 
    }


    public function SupprimerAdherent(Request $request)
    {
    		if (isset($request['id_adherent'])) {
    				$adherent = Adherent::find($request['id_adherent']);
     				if ($adherent) {
    						foreach($adherent->abonners as $key => $abonner){
    							$abonner->abonnements()->detach();
    							$abonner->packs()->detach();
    							$abonner->paiements()->delete();
    							$abonner->isMoneys()->delete();
    							$abonner->empeches()->delete();
    							$abonner->delete();
    						}
    						foreach ($adherent->recettes as $key => $recette) {
    							 $recette->recettepaiements()->delete();
    							 $recette->delete();
    						}
    						$adherent->presences()->delete();
    						$adherent->assurances()->delete();
    						$adherent->delete();
    						return response()->json(['etat' => true ]);
    				}
    		}
    		return response()->json(['etat' => false ]);
    }


    public function SupprimerAssuranceAdherent(Request $request)
    {
    		if (isset($request['id_assurance'])) {
    				$assurance = Assurance::find($request['id_assurance']);
     				if ($assurance) {
    						$assurance->delete();
     						  return response()->json(['etat' => true ]);
    				}
    		}
    		return response()->json(['etat' => false ]);
    }

    public function AjouterAssuranceAdherent(Request $request){

    		$adherent = Adherent::find($request['assurance.id_adherent']);
  			if ($adherent) {
  				$is_assuree = Assurance::where([
    							["id_adherent", $adherent->id ],
    							['date_fin' , '>' , now() ]
    						])->orderBy('id', 'desc')
    						->first();
    			if ($is_assuree) {
    				 return response()->json(['etat' => 'has_assurance' ]);
    			}

		    	$assurance_date_debut = date_create( $request['assurance.date_assuree']);
 				$assurance_date_fin = ( Carbon::parse( date_format($assurance_date_debut, 'Y-m-d H:i:s') ) )->addMonths( $request['assurance.duree_assurance'] );

		    	$assurance = Assurance::create([
					'date_assuree'  => date_format($assurance_date_debut, 'Y-m-d H:i:s') ,// date('Y/m/d', strtotime($request['assurance.date_assuree'])) , //now(),
					'date_fin'      => $assurance_date_fin , //$date_fin , //now(),
					'prix' 			=> $request['assurance.prix_assurance'],
					'id_adherent'	=> $adherent->id,
					'id_assureur' 		=> 1
				]);


				$assurance_adherent = Adherent::with(['latestAssurance'])->where('id', $adherent->id)->first();


				return response()->json(['etat' => $assurance_adherent ]);
			}
			return response()->json(['etat' => 'adherent_not_found' ]);


    }


   public function ModifierAssuranceAdherent(Request $request){

    		$adherent = Adherent::find($request['assurance.id_adherent']);
  			if ($adherent) {
  				$assurance = Assurance::find($request['assurance.assurance_id']);
    			if ($assurance) {
			    	$assurance_date_debut = date_create( $request['assurance.date_assuree']);
	 				$assurance_date_fin = ( Carbon::parse( date_format($assurance_date_debut, 'Y-m-d H:i:s') ) )->addMonths( $request['assurance.duree_assurance'] );

			    	$assurance->update([
						'date_assuree'  => date_format($assurance_date_debut, 'Y-m-d H:i:s') ,// date('Y/m/d', strtotime($request['assurance.date_assuree'])) , //now(),
						'date_fin'      => $assurance_date_fin , //$date_fin , //now(),
						'prix' 			=> $request['assurance.prix_assurance'],
						//'id_adherent'	=> $adherent->id,
						//'id_assureur' 		=> 1
					]);


					$assurance_adherent = Adherent::with(['latestAssurance'])->where('id', $adherent->id)->first();

					return response()->json(['etat' => $assurance_adherent ]);
				}
				return response()->json(['etat' => 'assurance_not_found' ]);
			}
			return response()->json(['etat' => 'adherent_not_found' ]);


    }

	public function LatestIdEmprinte(Request $request)
    {
        $latestIdEmpreinte = Adherent::max('id_empreinte') + 1;

        return response()->json(['latestIdEmpreinte' => $latestIdEmpreinte]);
    }


}
 