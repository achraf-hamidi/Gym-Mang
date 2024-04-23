<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Adherent;   
use App\Recette;   
use App\Recettepaiement;
use App\Service;   
use App\Categorie;   
use File;
use QrCode;
use DateTime; 
use DB;


class RecettesController extends Controller
{


  

    public function Recettes(Request $request){
        $recettes = DB::table('services')
                    ->join('categories', 'categories.id', '=', 'services.categorie_id')
                    ->select(
                        'services.id as id_service',
                        'services.nom as nom_service',
                        'services.prix as prix_service',
                        'categories.nom as nom_categorie',
                        'categories.type_id as type_id',
                        'categories.id as id_categorie'
                    )
                    ->where('categories.type_id', 1) // ID 1 c est la recettes
                    ->get();

        $categories = DB::table('categories')
                    ->where('type_id', 1) // ID 1 c est la recettes
                    ->get();

        return response()->json(['recettes' => $recettes ,  'categories' =>  $categories]);
    }


    public function index(Request $request) {
        $date = null ;
        if ( $request->has('filtrer.date') )
            $date = Helper::getDate($request); 

        $recettes = Recette::with(['service', 'adherent', 'recettepaiements']);

        if(isset($request['filtrer.categorie_id']) && $request['filtrer.categorie_id'] != null   ) {
            $recettes = $recettes ->whereHas('service' , function($query) use ($request) {
                                        $query->where('categorie_id' , $request['filtrer.categorie_id']);
                                    });
        }

        if(isset($request['filtrer.nom']) && $request['filtrer.nom'] != null   ) {
            $recettes = $recettes->where('nom', 'like', '%' .  $request['filtrer.nom'] . '%' ) ;
        }

        if(isset($request['filtrer.service_id']) && $request['filtrer.service_id'] != null   ) {
            $recettes = $recettes->where('service_id',  $request['filtrer.service_id'] ) ;
        }

        if(isset($request['filtrer.is_payed']) && $request['filtrer.is_payed'] != 'tous'   ) {
            $recettes = $recettes->where('is_payed',  $request['filtrer.is_payed'] ) ;
        }

        if(isset($request['filtrer.type_client']) && $request['filtrer.type_client'] != 'tous'   ) {
            $type = ($request['filtrer.type_client'] == 'outside') ? '=' : '<>' ;
            $recettes = $recettes->where('adherent_id', $type ,   null ) ;
        }

        if (isset($request['filtrer.matricule']) && $request['filtrer.matricule'] != null ) {
            $adherent = Adherent::where('code_client', $request['filtrer.matricule'] )
                                ->orWhere('cin', $request['filtrer.matricule'] )
                                ->orWhere('id_empreinte', $request['filtrer.matricule'] )
                                ->first();
            if(isset($adherent) && $adherent != null){
                $recettes = $recettes->where('adherent_id',  $adherent->id ) ;
            }  else {
                $recettes = $recettes->where('adherent_id',  'none') ;
            }   
        }

        if ($date != null) {
            $recettes = $recettes->when( $date , function ($query, $date ) {
                                 $query->whereBetween('date_commande', [ $date ] ) ;
                            })->orderBy('id', 'desc') ;
        }
        

        if (isset($_GET['take']) && $_GET['take'] != null) {
            $recettes = $recettes->take(10)->get();
        }else                            
            $recettes = $recettes->paginate(50) ;

        return response()->json(['recettes' => $recettes ]);
    }

     public function store(Request $request) {

        $nom = (isset($request['recette.nom']) && $request['recette.nom'] !='') ? $request['recette.nom']  : null;
        if (isset($request['recette.matricule'])) {
            $adherent = Adherent::where('code_client', $request['recette.matricule'] )
                                ->orWhere('cin', $request['recette.matricule'] )
                                ->orWhere('id_empreinte', $request['filtrer.matricule'] )
                                ->first();
            if ($adherent) 
                $nom = $adherent->nom;
                                 
        }
        

        $date_paiement = str_replace('/', '-', $request['recette.date_paiement']);
        $time_paiement = $request['recette.time_paiement'];
        $datetime_paiement = date('Y-m-d H:i:s',strtotime($date_paiement .' ' . $time_paiement ));

        $recette_added = Recette::create([  
            'adherent_id' =>  (isset($adherent)) ? $adherent->id : null ,
            'nom' =>  $nom ,
            'service_id' =>  $request['recette.id_service'] ,
            'montant' =>    $request['recette.montant'] , // prix de service (Recette) 
            'date_commande' => now(),
            'is_payed' => (isset($request['recette.montant_paye']) && $request['recette.montant_paye'] == $request['recette.montant'] ) ? 1 : 0, 
            'note' =>    $request['recette.note'] ,
            'updated_at' => now(),
            'created_at' => now()
        ]); 

        if (isset($request['recette.montant_paye'] )) {
            $paiement = Recettepaiement::create([  
                'recette_id' => $recette_added->id,
                'montant_paye' =>    $request['recette.montant_paye'] , // Montant payé par adhérent
                'date_paiement' =>    (isset($request['recette.date_paiement'])) ? $datetime_paiement : now() ,
                'updated_at' => now(),
                'created_at' => now()
            ]); 
        }

        $recette = Recette::with(['service', 'adherent', 'recettepaiements'])
                            ->where('id', $recette_added->id)
                            ->first();

        return response()->json(['recette' => $recette]);
    }


    public function destroy(Request $request) {
        $recette = Recette::find($request['id_recette']);
        if ($recette) {
            
            $recette->recettepaiements()->delete();
            $recette->delete();

            return response()->json(true);
        }
        return response()->json(false);
    }

    public function regler(Request $request) {
        if (isset($request['id_recette'])) {
            $recette = Recette::with(['service', 'adherent', 'recettepaiements'])
                               ->where('id', $request['id_recette'] )
                               ->first();
            if ($recette) { 

                $date_paiement = str_replace('/', '-', $request['recette.date_paiement']);
                $time_paiement = $request['recette.time_paiement'];
                $datetime_paiement = date('Y-m-d H:i:s',strtotime($date_paiement .' ' . $time_paiement ));
                
                $paiement = Recettepaiement::create([  
                    'recette_id' => $recette->id,
                    'montant_paye' =>    $request['montant_paye'] , // Montant payé par adhérent
                    'date_paiement' =>      (isset($request['recette.date_paiement'])) ? $datetime_paiement : now() ,
                    'updated_at' => now(),
                    'created_at' => now()
                ]); 

                $Recettepaiement = Recettepaiement::where('recette_id', $recette->id)->sum('montant_paye');

                if ($recette->montant == $Recettepaiement ) {
                    $recette->update([
                        'is_payed' => 1
                    ]);
                }

                return response()->json(['recette' => $recette, 'montant_paye' => $request['montant_paye']  ] );

            }
        }  

         return response()->json(['recette' => 'none']);
        
    }

    public function EditNote(Request $request) {
        if (isset($request['id_recette'])) {
            $recette = Recette::with(['service', 'adherent', 'recettepaiements'])
                               ->where('id', $request['id_recette'] )
                               ->first();
            if ($recette) { 

                 $recette->update([
                    'note' => $request['note']
                ]);
            
                return response()->json(['recette' => $recette ] );

            }
        }  

        return response()->json(['recette' => false]);
        
    }

}
