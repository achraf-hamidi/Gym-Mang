<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Adherent;   
use App\Depence;   
use App\Depencepaiement;
use App\Service;   
use App\Categorie;   
use File;
use QrCode;
use DateTime; 
use DB;


class DepencesController extends Controller
{
 
     public function Depences(Request $request){
        $depences = DB::table('services')
                    ->join('categories', 'categories.id', '=', 'services.categorie_id')
                    ->select(
                        'services.id as id_service',
                        'services.nom as nom_service',
                        'services.prix as prix_service',
                        'categories.nom as nom_categorie',
                        'categories.type_id as type_id',
                        'categories.id as id_categorie'
                    )
                    ->where('categories.type_id', 2) // ID 2 c est le depences
                    ->get();

        $categories = DB::table('categories')
                    ->where('type_id', 2) // ID 1 c est la recettes
                    ->get();
        return response()->json(['depences' => $depences ,  'categories' =>  $categories]);
    }


    public function index(Request $request) {
        $date = null ;
        if ( $request->has('filtrer.date') )
            $date = Helper::getDate($request); 

        $depences = Depence::with(['service', 'depencepaiements']);

        if(isset($request['filtrer.categorie_id'])    ) {
            $depences = $depences ->whereHas('service' , function($query) use ($request) {
                                        $query->where('categorie_id' , $request['filtrer.categorie_id']);
                                    });
        }

        if(isset($request['filtrer.nom']) && $request['filtrer.nom'] != null   ) {
            $depences = $depences->where('nom', 'like', '%' .  $request['filtrer.nom'] . '%'  ) ;
        }

        if(isset($request['filtrer.service_id'])  ) {
            $depences = $depences->where('service_id',  $request['filtrer.service_id'] ) ;
        }



        if(isset($request['filtrer.is_payed']) && $request['filtrer.is_payed'] != 'tous'   ) {
            $depences = $depences->where('is_payed',  $request['filtrer.is_payed'] ) ;
        }         

        $depences = $depences->when( $date , function ($query, $date ) {
                                 $query->whereBetween('date_commande', [ $date ] ) ;
                            })->orderBy('id', 'desc') ;
        if (isset($_GET['take']) && $_GET['take'] != null) {
            $depences = $depences->take(10)->get();
        }else                            
            $depences = $depences->paginate(50) ;

        return response()->json(['depences' => $depences ]);
    }

     public function store(Request $request) { 
         
        $nom = (isset($request['depence.nom']) && $request['depence.nom'] !='') ? $request['depence.nom']  : null ;

        $date_paiement = str_replace('/', '-', $request['depence.date_paiement']);
        $time_paiement = $request['depence.time_paiement'];
        $datetime_paiement = date('Y-m-d H:i:s',strtotime($date_paiement .' ' . $time_paiement ));


        $depence_added = Depence::create([  
             'service_id' =>  $request['depence.id_service'] ,
             'nom' =>  $nom ,
            'montant' =>    $request['depence.montant'] , // prix de service (Depence) 
            'date_commande' => now(),
            'is_payed' => (isset($request['depence.montant_paye']) && $request['depence.montant_paye'] == $request['depence.montant'] ) ? 1 : 0, 
            'note' =>    $request['depence.note'] ,
            'updated_at' => now(),
            'created_at' => now()
        ]); 

        if (isset($request['depence.montant_paye'] )) {
            $paiement = Depencepaiement::create([  
                'depence_id' => $depence_added->id,
                'montant_paye' =>    $request['depence.montant_paye'] , // Montant payé par adhérent
                'date_paiement' =>    (isset($request['depence.date_paiement'])) ? $datetime_paiement : now() ,
                'updated_at' => now(),
                'created_at' => now()
            ]); 
        }

        $depence = Depence::with(['service', 'depencepaiements'])
                            ->where('id', $depence_added->id)
                            ->first();

        return response()->json(['depence' => $depence]);
    }


    public function destroy(Request $request) {
        $depence = Depence::find($request['id_depence']);
        if ($depence) {
            
            $depence->depencepaiements()->delete();
            $depence->delete(); 

            return response()->json(true);
        }
        return response()->json(false);
    }

    public function regler(Request $request) {
        if (isset($request['id_depence'])) {
            $depence = Depence::with(['service', 'depencepaiements'])
                               ->where('id', $request['id_depence'] )
                               ->first();
            if ($depence) { 

                $date_paiement = str_replace('/', '-', $request['depence.date_paiement']);
                $time_paiement = $request['depence.time_paiement'];
                $datetime_paiement = date('Y-m-d H:i:s',strtotime($date_paiement .' ' . $time_paiement ));


                $paiement = Depencepaiement::create([  
                    'depence_id' => $depence->id,
                    'montant_paye' =>    $request['montant_paye'] , // Montant payé par adhérent
                    'date_paiement' =>    (isset($request['depence.date_paiement'])) ? $datetime_paiement : now() ,
                    'updated_at' => now(),
                    'created_at' => now()
                ]); 

                $depencepaiement = Depencepaiement::where('depence_id', $depence->id)->sum('montant_paye');

                if ($depence->montant == $depencepaiement ) {
                    $depence->update([
                        'is_payed' => 1
                    ]);
                }

                return response()->json(['depence' => $depence, 'montant_paye' => $request['montant_paye']  ] );

            }
        }  

         return response()->json(['depence' => 'none']);
        
    }


    public function EditNote(Request $request) {
        if (isset($request['id_depence'])) {
            $depence = Depence::with(['service', 'depencepaiements'])
                               ->where('id', $request['id_depence'] )
                               ->first();
            if ($depence) { 

                 $depence->update([
                    'note' => $request['note']
                ]);
            
                return response()->json(['depence' => $depence ] );

            }
        }  

        return response()->json(['depence' => false]);
        
    }

}
