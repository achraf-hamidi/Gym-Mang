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
 

class PaiementsController extends Controller
{
    
      public function AbonnementImpayes(Request $request) {
    	$abonner = [];
    	if ($request['filtrer.matricule_cin'] !="" && isset($request['filtrer.matricule_cin'])) {

            $adherent = Adherent::where('code_client', $request['filtrer.matricule_cin'])
                                ->orWhere('cin', $request['filtrer.matricule_cin'])
                                ->orWhere('id_empreinte', $request['filtrer.matricule_cin'])
                                ->first();

            if (isset($adherent->id)) {
                $abonner = Abonner::with('paiements')
                            ->has('packs')->has('abonnements')
                            ->with(['adherent', 'abonnements', 'packs' => function($pack) {
                                    //ayb$pack->where('is_active', 1) ;//->with('promotions');
                            }])
                            ->where('id_adherent' , $adherent->id )
                            ->where('completed_paiement', 0);
                            
                if ($request['filtrer.id_abonnement'] !="" && isset($request['filtrer.id_abonnement'])) {
                    $abonner = $abonner->where('id', $request['filtrer.id_abonnement'] );
                }
                $abonner = $abonner->orderBy('id', 'desc')
                                    ->take(1)
                                    ->get();
                                   
                $is_money = Ismoney::where('id_abonner', $abonner[0]->id )->get();
                if ($is_money) 
                    $t_is_money = $is_money->sum('prix') ;
                return response()->json(['abonner' => $abonner , 't_is_money' => $t_is_money]);
            }
            return response()->json(['adherent' => 'not found' ]);    		
    	} 
    	return response()->json($abonner);

    }

    public function store(Request $request) {
    	$abonners = [];
    	if ($request['matricule_cin'] !="" && isset($request['matricule_cin'])) {

           // $date_paiement = date_create( $request['empeche.date_absence']);
           // $date_retour = ( Carbon::parse( date_format($date_paiement, 'Y-m-d H:i:s') ) )->addDays(  $request['empeche.nb_jours']);

            $adherent = Adherent::where('code_client', $request['matricule_cin'])
                                ->orWhere('cin', $request['matricule_cin'])
                                ->orWhere('id_empreinte', $request['matricule_cin'])
                                ->first();

            if(isset($adherent->id)){
                Paiement::create([
                    'date_paiement' => now() , // date('Y/m/d', strtotime(now())) , //now(),
                    'prix'          => $request['prixapayer'],
                    'id_abonner'    => $request['id_abonner'],
                    'id_adherent'   => $adherent->id,
                    'id_user'       => 1,
                    'id_pack' => $request['id_type_pack'],
                    'id_abonnement' => $request['id_type_abonnement']
                ]);

                $abonners = Abonner::with('paiements')
                                ->has('packs')->has('abonnements') 
                                ->with(['adherent', 'abonnements', 'packs'])
                                //->where('id_adherent' , $adherent->id)
                                ->where('id' , $request['id_abonner'] )
                                //->orderBy('id', 'desc')
                                //->take(1)
                                ->get();
                                
                $total_paiement = Paiement::where('id_abonner', $request['id_abonner'])->sum('prix');
                if ($total_paiement >= $abonners[0]->prix_ttc  )  {
                    $abonners[0]->update([
                        'completed_paiement' => 1
                    ]); 
                }

                return response()->json($abonners);
            }
    		
    	} 
    	return response()->json(false);
    }


    public function HistoriquesReglementAbonnement(Request $request) { // La liste de toutes le paiements
        $date = null ;
        $date_debut =null;
        $date_fin=  null;
        if ( $request->has('filtrer.date') )
            $date = Helper::getDate($request); 
        //  if ($request->has('filtrer.date')){
        //         $date_debut = date('Y-m-d' ,strtotime($request['filtrer.date.from']));
        //         $date_fin= date('Y-m-d' ,strtotime($request['filtrer.date.to']));
        //         $date = Helper::getDate($request); 
        //        // $date_debut = date($date_debut) ;
        //         //$date_fin   =  date($date_fin) ;
    
        //  } 

        if (isset($request['filtrer.matricule_cin']) && $request['filtrer.matricule_cin'] != '') {
            $adherent = Adherent::where('code_client', $request['filtrer.matricule_cin'])
                                    ->orWhere('cin', $request['filtrer.matricule_cin'])
                                    ->orWhere('id_empreinte', $request['filtrer.matricule_cin'])
                                    ->first();
            if (!isset($adherent->id)) {
                return response()->json(['adherent' =>  'not found' ]); 
            }
        }

        	/*$paiements = Paiement::has('abonner')->with(['abonner' => function($abonner) use ($request) { 
	    						if ($request['filtrer.id_adherent'] !="" && isset($request['filtrer.id_adherent']))
	    							$abonner->has('packs')->has('abonnements')->with(['adherent', 'packs', 'abonnements'])->where('id_adherent' , $request['filtrer.id_adherent']);
	    						else
	    							$abonner->has('packs')->has('abonnements')->with(['adherent', 'packs', 'abonnements']);
    						}])
    						->whereHas('abonner', function ($abonner) use ($request, $date)  {
	    						if ($request['filtrer.id_adherent'] !="" && isset($request['filtrer.id_adherent']))
	    							$abonner->has('packs')->has('abonnements')->with(['adherent', 'packs', 'abonnements'])->where('id_adherent' , $request['filtrer.id_adherent']);
	    						else
	    							$abonner->has('packs')->has('abonnements')->with(['adherent', 'packs', 'abonnements']);
    						})
    						->whereBetween('date_paiement', [ $date ])
    					   ->orderBy('id', 'desc')->get(); */
        
    	$abonners = Abonner::has('paiements')->with(['paiements' => function($paiements) use ($request, $date) { 
	    						$paiements->when( $date , function ($query, $date ) {
                                     $query->whereBetween('date_paiement', [ $date ] ) ;
                                });
    						}])
    						->whereHas('paiements', function ($paiements) use ($request, $date)  {
    							$paiements->when( $date , function ($query, $date ) {
                                     $query->whereBetween('date_paiement', [ $date ] ) ;
                                });
    						})
    						->has('packs')->has('abonnements')
    						->with(['isMoneys', 'adherent', 'abonnements', 'packs' => function($pack) {
    								//ayb$pack->where('is_active', 1); //->with('promotions');
    						}]);
    						
        if (isset($request['filtrer.id_abonnement'])) {	
             $abonners = $abonners->where('id' , $request['filtrer.id_abonnement'] ); 
        }

        if (isset($adherent->id)) { 
             $abonners = $abonners->where('id_adherent' , $adherent->id )->orderBy('id', 'desc'); 
        }
        //else {
    	//	$abonners = $abonners->orderBy('id', 'desc'); 
        //}


    	if ($request['filtrer.order'] == "desc-first" && isset($request['filtrer.order'])) {
    		$abonners = $abonners->take(1)->get();
    	}else
    		$abonners = $abonners->get(); 


            /*if ($request['filtrer.id_adherent'] !="" && isset($request['filtrer.id_adherent']))
	    							$abonner->has('packs')->has('abonnements')->with(['adherent', 'packs', 'abonnements'])->where('id_adherent' , $request['filtrer.id_adherent']);
	    						else
	    							$abonner->has('packs')->has('abonnements')->with(['adherent', 'packs', 'abonnements']);*/



    	return response()->json($abonners);
    }
   


 
    public function statistiauesReglements(Request $request) {

        $date = null ;
        $date_debut =null;
        $date_fin=  null;
        if ($request->has('filtrer.date')){
            $date_debut = date('Y-m-d' ,strtotime($request['filtrer.date.from']));
            $date_fin= date('Y-m-d' ,strtotime($request['filtrer.date.to']));
            $date = Helper::getDate($request); 
           // $date_debut = date($date_debut) ;
            //$date_fin   =  date($date_fin) ;

        } 
        // $date = null ;
        // if ( $request->has('filtrer.date') )
        //     $date = Helper::getDate($request); 


        //$all_months = [1,2,3,4,5,6,7,8,9,10,11,12];
        //$arr_years = (isset($request['arr_years'])) ? $request['arr_years'] : [date('Y')] ;
        //$arr_months = (isset($request['arr_months'])) ? $request['arr_months'] : $all_months ;


       // $arr_years = (isset($request['arr_years'])) ? $request['arr_years'] : [date('Y')] ;
       // $arr_months = (isset($request['arr_months'])) ? $request['arr_months'] : $months ;

        $paiements = DB::table('paiements');
                    //->join('abonners', 'paiements.id_abonner', '=', 'abonners.id')
                    //->join('abonnement_abonner', 'abonners.id', '=', 'abonnement_abonner.abonner_id')
                    //->join('abonner_pack', 'abonners.id', '=', 'abonner_pack.abonner_id')
                    //->join('packs', 'abonner_pack.pack_id', '=', 'packs.id')
                    //->join('activitie_pack', 'packs.id', '=', 'activitie_pack.pack_id');
                    
        if (isset($request['filtrer.abonnement_id'])) {
             $paiements = $paiements->where('id_abonnement', $request['filtrer.abonnement_id']);
        }

        if (isset($request['filtrer.pack_id'])) {
             $paiements = $paiements->where('id_pack', $request['filtrer.pack_id']);
        }

        //if (isset($request['filtrer.activitie_id'])) {
        //     $paiements = $paiements->where('activitie_pack.activitie_id', $request['filtrer.activitie_id']);
        //}

        $paiements = $paiements->select(
                        DB::raw('sum(paiements.prix) as sums'), 
                        DB::raw("DATE_FORMAT(date_paiement,'%m / %Y') as months"),
                        DB::raw("DATE_FORMAT(date_paiement,'%m') as monthKey"),
                        DB::raw("DATE_FORMAT(date_paiement,'%Y') as year")
                    ); 

        if (isset($request['filtrer.addSelectDay']) && $request['filtrer.addSelectDay'] == 'true') {
            $paiements = $paiements->addSelect( 
                           DB::raw("DATE_FORMAT(date_paiement,'%d') as dayKey")
                         ); 
        }

        if (isset($request['filtrer.code_client']) && $request['filtrer.code_client'] != '') {
            $adherent = Adherent::where('code_client', $request['filtrer.code_client'] )
                                ->orWhere('cin', $request['filtrer.code_client'] )
                                ->orWhere('id_empreinte', $request['filtrer.code_client'] )
                                ->first();

            if (!$adherent) {
                  return response()->json( ['adherent' => 'not_found']);
            }

            $paiements = $paiements->where('paiements.id_adherent', $adherent->id );
        }

        $paiements = $paiements->where("paiements.prix", "<>", 0 );

        if(isset($request['filtrer.year']) && isset($request['filtrer.month'])){
                $month = intval($request['filtrer.month']) ;
                $year = intval($request['filtrer.year']) ; 
                $paiements = $paiements
                                  //  ->where(DB::raw("DATE_FORMAT(date_paiement,'%m')"), $month )
                                //->where(DB::raw("DATE_FORMAT(date_paiement,'%Y')"), $year )
                                ->whereBetween('date_paiement', [$date_debut,$date_fin])
                                ->groupBy('months', 'monthKey', "year", "dayKey")
                                ->orderBy("dayKey", 'ASC');
        }else{
            $paiements = $paiements
                               ->whereBetween('date_paiement', [$date_debut,$date_fin])
                               ->groupBy('months', 'monthKey', "year")
                               ->orderBy("monthKey", 'ASC');
        }


        $paiements = $paiements->orderBy("year", 'ASC')
                              // ->orderBy("monthKey", 'ASC')
                               ->get();      

        /*$paiements = $paiements->whereIn(DB::raw("DATE_FORMAT(date_paiement,'%m')"), $arr_months )
                               // ->whereIn(DB::raw("DATE_FORMAT(date_paiement,'%M')"), $arr_months )
                               ->whereIn(DB::raw("DATE_FORMAT(date_paiement,'%Y')"), $arr_years )
                               ->groupBy('months', 'monthKey', "year")
                               ->orderBy("year", 'ASC')
                               ->orderBy("monthKey", 'ASC')
                               ->get();   */     


        
        //echo (strftime("%A %d %B")); 
        return response()->json( ['paiements' => $paiements, 'abns' => [], 'date' => strftime("%A %d %B") ]);
    }


    public function abonnementsNonPaye(Request $request) { // Crédits

        //if ( $request->has('filtrer.date_echeance') )
        //    $date_echeance = Helper::getDateEcheance($request); 

        $date = null ;
        if ( $request->has('filtrer.date') )
            $date = Helper::getDate($request); 

        $abonnements_non_paye = DB::table('abonners')
                    ->join('paiements', 'paiements.id_abonner', '=', 'abonners.id')
                    ->join('adherents', 'abonners.id_adherent', '=', 'adherents.id')
                    ->join('abonnement_abonner', 'abonners.id', '=', 'abonnement_abonner.abonner_id')
                    ->join('abonner_pack', 'abonners.id', '=', 'abonner_pack.abonner_id')
                    ->join('packs', 'abonner_pack.pack_id', '=', 'packs.id')
                     ->join('abonnements', 'abonnement_abonner.abonnement_id', '=', 'abonnements.id')
                    ->select(
                        'adherents.nom',
                        'adherents.email',
                        'adherents.code_client',
                        'adherents.id_empreinte',
                        'abonners.id',
                        'abonners.id_adherent',
                        'abonners.prix_ttc',
                        'abonners.total_frais',
                        'paiements.id_abonner',
                        'abonners.paiament_date_echeance',
                        'abonners.date_fin',
                        'packs.description as description',
                        'abonnements.libelle as libelle',
                        DB::raw('sum(paiements.prix) as sums')
                    ) ;
                     

        if (isset($request['filtrer.abonnement_id'])) {
             $abonnements_non_paye = $abonnements_non_paye->where('abonnement_abonner.abonnement_id', $request['filtrer.abonnement_id']);
        }

        if (isset($request['filtrer.pack_id'])) {
             $abonnements_non_paye = $abonnements_non_paye->where('abonner_pack.pack_id', $request['filtrer.pack_id']);
        }

        if (isset($request['filtrer.matricule'])) { 
            $adherent = Adherent::where('code_client', $request['filtrer.matricule'] )
                                ->orWhere('cin', $request['filtrer.matricule'] )
                                ->orWhere('id_empreinte', $request['filtrer.matricule'] )
                                ->first();
            $matricule = null;
            if ($adherent) {
                $matricule = $adherent->code_client;
            }
            $abonnements_non_paye = $abonnements_non_paye
                                    ->where('adherents.code_client', $matricule );
                                   // ->orWhere('adherents.cin', $matricule );
         }

        if (isset($request['filtrer.nom'])) { 

            $abonnements_non_paye = $abonnements_non_paye
                                    ->where('adherents.nom', 'like', '%'.$request['filtrer.nom'].'%');
         }

        if ($date != null) {
            //oldd 
             $abonnements_non_paye = $abonnements_non_paye->whereBetween('abonners.paiament_date_echeance', [$date] )
                    ->orWhere('abonners.paiament_date_echeance',  '<=' ,$date[0] );
        }

        $abonnements_non_paye = $abonnements_non_paye->where('abonners.prix_ttc'  ,'<>', null)
                    ->where('completed_paiement'  ,'=', 0)
                    ->groupBy(
                        'adherents.nom',
                        'adherents.id_empreinte',
                        'adherents.code_client',
                        'adherents.email',
                        'abonners.id',
                        'abonners.id_adherent',
                        'abonners.prix_ttc',
                        'abonners.total_frais',
                        'paiements.id_abonner',
                        'abonners.paiament_date_echeance',
                        'abonners.date_fin',
                        'packs.description',
                        'abonnements.libelle'
                    ) 
                    ->orderBy("abonners.id_adherent", 'DESC');
        $abonnements_non_paye_dash = $abonnements_non_paye;
        $abonnements_non_paye_dash = $abonnements_non_paye_dash->get();
            
        $abonnements_non_paye = $abonnements_non_paye->paginate(50);
                   // ->get();   

               //dd($abonnements_non_paye);
        return response()->json([ 'abonnements_non_paye' => $abonnements_non_paye, 'abonnements_non_paye_dash' => $abonnements_non_paye_dash]); 

    }


     public function SupprimerPaiement(Request $request)
    {
            if (isset($request['id_paiement'])) {
                    $paiement = Paiement::find($request['id_paiement']);
                    if ($paiement) {
                        
                            $paiement->delete();
                            return response()->json(['etat' => true ]);
                    }
            }
            return response()->json(['etat' => false ]);
    }


}
