<?php
namespace App\Http\Controllers\Admin;

use App\Abonner;
use App\Adherent;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Paiement;
use App\Presence;
use App\Promotion;
use App\Recette;
use App\Recettepaiement;
use App\Depencepaiement;
use DB;
use File;
use Illuminate\Http\Request;
use QrCode;
use Auth;
use App\User;
use App\Message;
use App\Integration;
use Carbon\Carbon;

class DashboardController extends Controller
{

    /*public function getQrCode(Request $request, $code) {
      	$adherent = Adherent::where('code_client', $code)->first();
      	return response()->json($adherent);
    */

    public function GenerateQrCode(Request $request)
    {
        /*$adherent = Adherent::latest()->first();
        $image =  QrCode::format('png')
                  ->size(500)->errorCorrection('H')
                  ->generate('10');
        
           $output_file = 'admin/adherents/qr_code/'. $adherent->cin .'_'. time().'.png';
           File::put($output_file, $image);
        //return response()->json($qr);
           echo '<img src="'.$output_file.'" >';
        */
        $adherents = Adherent::all();
        foreach ($adherents as $key => $adherent)
        {
            //$integration = Integration::create([
            //	'id_adherent' =>  $adherent->id ,
            //	'date_debut'  => now()
            //]);
            $image = QrCode::format('png')->size(500)
                ->errorCorrection('H')
                ->generate($adherent->qr_code);

            $output_file = 'admin/adherents/qr_code/' . $adherent->qr_code . '.png';
            File::put($output_file, $image);
            //return response()->json($qr);
            
        }

        echo "done";
        die();

    }

    /***############### PROFILE ##################*/

    /*########## PAIEMENTS ###############*/

    public function ListAdherentsHasPaiements(Request $request) 
    {
        $adherents = Adherent::has('abonners')->with('latestAbonner')->whereHas('latestAbonner', function ($q)
        {
            $q->where('date_fin', '>=', now());
        })
            ->get();

        return response()
            ->json($adherents);
    }

    public function adherents(Request $request)
    {
        $abonners = Abonner::with('adherent')->where('date_fin', ">=", now())
            ->where('has_new_abonnement', 0)
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();
        return response()
            ->json($abonners);
    }

    public function abonnementsRenouveler(Request $request)
    {
        $date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request);         
		$adherents = Adherent::withCount('abonners')->with(['abonners'=> function ($abonners) use ($request, $date) {
            $abonners->with(['abonnements', 'packs']) 
            
        //    ->when( $date , function ($query, $date ) {
        //         $query->whereBetween('date_fin', [ $date ] ) ;
        //    })
           ->where('suspend', 0)
          ->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
        ->orderBy('id', 'desc');
    }])
->whereHas('abonners', function ($abonners) use ($request, $date)  {
           $abonners 
        //    ->when( $date , function ($query, $date ) {
        //         $query->whereBetween('date_fin', [ $date ] ) ;
        //    })
           ->where('suspend', 0)
           ->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
            ->orderBy('id', 'desc');
})
->has('abonners' ,'>', 1)
->latest()
->take(8)
->get();

        return response()->json($adherents);
    }
    

    public function terminer(Request $request)
    {
        $abonners = Abonner::with('adherent')->where([['date_fin', '<', now() ], ['has_new_abonnement', 0]])
            ->orderBy('date_fin', 'desc')
            ->take(8)
            ->get();

        return response()
            ->json($abonners);
    }

    public function AvantFinDate(Request $request)
    {
        if ($request->has('filtrer.date')) $date = Helper::getDate($request);

        $abonners = Abonner::with('adherent')->where('date_fin', '>=', now())
            ->where('has_new_abonnement', 0);

        if ($request->has('filtrer.date'))
        {
            $abonners = $abonners->whereBetween('date_fin', [$date]);
        }

        if (isset($_GET['take']) && is_numeric($_GET['take']))
        {
            $abonners = $abonners->orderBy('date_fin', 'asc')
                ->take($_GET['take'])->get();
        }
        else
        {
            $abonners = $abonners->orderBy('date_fin', 'asc')
                ->get();
        }

        return response()
            ->json($abonners);
    }

    public function Promotions(Request $request)
    {
        $date = Helper::getDate($request);
        $promotions = Promotion::with('pack')->whereBetween('date_fin', [$date])->where('date_fin', '>=', now())
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();
        return response()
            ->json($promotions);
    }

    public function StatistiquesActuel(Request $request)
    {

        /*$arr_years = (isset($request['arr_years'])) ? $request['arr_years'] : [date('Y')];
        $arr_months = (isset($request['arr_months'])) ? $request['arr_months'] : [date('m')-1, date('m')-2, date('m')];
        
        $paiements = Paiement::select(
        DB::raw('sum(prix) as sums'),
        DB::raw("DATE_FORMAT(date_paiement,'%m / %Y') as months"),
        DB::raw("DATE_FORMAT(date_paiement,'%m') as monthKey"),
        DB::raw("DATE_FORMAT(date_paiement,'%Y') as year")
        );
        
        if (isset($request['filtrer.code_client'])) {
        $adherent = Adherent::where('code_client', $request['filtrer.code_client'])->first();
        $paiements = $paiements->where('id_adherent', $adherent->id);
        }
        
        $paiements = $paiements->whereIn(DB::raw("DATE_FORMAT(date_paiement,'%m')"), $arr_months)
        ->whereIn(DB::raw("DATE_FORMAT(date_paiement,'%Y')"), $arr_years)
        ->groupBy('months', 'monthKey', "year")
        ->orderBy("year", 'ASC')
        ->orderBy("monthKey", 'ASC')
        ->get();
        
        return response()->json($paiements);*/

        $specific_months = [date('m') , date('m') - 1, date('m') - 2];
        $arr_years = (isset($request['arr_years'])) ? $request['arr_years'] : [date('Y') ];
        $arr_months = (isset($request['arr_months'])) ? $request['arr_months'] : $specific_months;

        $paiements = DB::table('abonners');
        /// ->join('abonnement_abonner', 'abonners.id', '=', 'abonnement_abonner.abonner_id')
        ///->join('abonner_pack', 'abonners.id', '=', 'abonner_pack.abonner_id')
        ///->join('packs', 'abonner_pack.pack_id', '=', 'packs.id')
        ///->join('activitie_pack', 'packs.id', '=', 'activitie_pack.pack_id');
        

        $paiements = $paiements->select(DB::raw('sum(abonners.prix_ttc) as sums') , DB::raw("DATE_FORMAT(abonners.date_debut,'%m / %Y') as months") , DB::raw("DATE_FORMAT(abonners.date_debut,'%m') as monthKey") , DB::raw("DATE_FORMAT(abonners.date_debut,'%Y') as year"));

        $paiements = $paiements->whereIn(DB::raw("DATE_FORMAT(abonners.date_debut,'%m')") , $arr_months)->whereIn(DB::raw("DATE_FORMAT(abonners.date_debut,'%Y')") , $arr_years)->groupBy('months', 'monthKey', "year")
            ->orderBy("year", 'ASC')
            ->orderBy("monthKey", 'ASC')
            ->get();

        return response()
            ->json($paiements);
    }

    public function StatistiquesReglementsSoldeCaisse(Request $request)
    {
        $specific_months = [date('m') , date('m') - 1, date('m') - 2]; //[1,2,3,4,5,6,7,8,9,10,11,12];
        $arr_years = (isset($request['arr_years'])) ? $request['arr_years'] : [date('Y') ];
        $arr_months = (isset($request['arr_months'])) ? $request['arr_months'] : $specific_months;

        $paiements = DB::table('paiements');

        $paiements = $paiements->select(DB::raw('sum(paiements.prix) as sums') , DB::raw("DATE_FORMAT(date_paiement,'%m / %Y') as months") , DB::raw("DATE_FORMAT(date_paiement,'%m') as monthKey") , DB::raw("DATE_FORMAT(date_paiement,'%Y') as year"));

        $paiements = $paiements->whereIn(DB::raw("DATE_FORMAT(date_paiement,'%m')") , $arr_months)
        // ->whereIn(DB::raw("DATE_FORMAT(date_paiement,'%M')"), $arr_months )
        ->whereIn(DB::raw("DATE_FORMAT(date_paiement,'%Y')") , $arr_years)->groupBy('months', 'monthKey', "year")
            ->orderBy("year", 'ASC')
            ->orderBy("monthKey", 'ASC')
            ->get();

        return response()
            ->json($paiements);

    }

    public function StatistiquesRecettes(Request $request)
    {
        //$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', '//September', 'October', 'November', 'December',
        //);
        $date = null;
        if ($request->has('filtrer.date')) $date = Helper::getDate($request);

        /* old **/
        /*if (!isset($request['all_months'])) {
        $specific_months = [date('m')];
        }else{
        $specific_months = [1,2,3,4,5,6,7,8,9,10,11,12];
        }
        $arr_years = (isset($request['arr_years'])) ? $request['arr_years'] : [date('Y')];
        $arr_months = (isset($request['arr_months'])) ? $request['arr_months'] : $specific_months ;
        */

        $paiements_recettes = DB::table('recettepaiements')->join('recettes', 'recettes.id', '=', 'recettepaiements.recette_id')
            ->join('services', 'services.id', '=', 'recettes.service_id')
            ->join('categories', 'categories.id', '=', 'services.categorie_id')
            ->select('services.id', 'services.nom as nom_service', DB::raw('count(services.id) as qte') , DB::raw('sum(montant_paye) as sums') , DB::raw("DATE_FORMAT(recettepaiements.date_paiement,'%m / %Y') as months") , DB::raw("DATE_FORMAT(recettepaiements.date_paiement,'%m') as monthKey") , DB::raw("DATE_FORMAT(recettepaiements.date_paiement,'%Y') as year"));

        if (isset($request['filtrer.addSelectDay']) && $request['filtrer.addSelectDay'] == 'true')
        {
            $paiements_recettes = $paiements_recettes->addSelect(DB::raw("DATE_FORMAT(recettepaiements.date_paiement,'%d') as dayKey") );
        }

        if (isset($request['filtrer.recette_id']))
        {
            $paiements_recettes = $paiements_recettes->where('recette_id', $request['filtrer.recette_id']);
        }

        if (isset($request['filtrer.service_id']))
        {
            $paiements_recettes = $paiements_recettes->where('recettes.service_id', $request['filtrer.service_id']);
        }

        if (isset($request['filtrer.categorie_id']))
        {
            $paiements_recettes = $paiements_recettes->where('categories.id', $request['filtrer.categorie_id']);
        }

        if (isset($request['today']))
        {
            $paiements_recettes = $paiements_recettes->whereDate('recettepaiements.date_paiement', DB::raw('CURDATE()'));
        }

        /* old */
        /*
        if (isset($request['arr_months'])) {
        $paiements_recettes = $paiements_recettes->whereIn(DB::raw("DATE_FORMAT(recettepaiements.date_paiement,'%m')"), $arr_months)
        					 ->whereIn(DB::raw("DATE_FORMAT(recettepaiements.date_paiement,'%Y')"), $arr_years);
        }*/

        if (isset($request['filtrer.year']) && isset($request['filtrer.month']))
        {
            $month = intval($request['filtrer.month']);
            $year = intval($request['filtrer.year']);
            $paiements_recettes = $paiements_recettes->where(DB::raw("DATE_FORMAT(recettepaiements.date_paiement,'%m')") , $month)->where(DB::raw("DATE_FORMAT(recettepaiements.date_paiement,'%Y')") , $year)->whereBetween('recettepaiements.date_paiement', [$date])->groupBy('months', 'monthKey', "year", "dayKey", 'services.id', 'services.nom');
        }
        else
        {
            $paiements_recettes = $paiements_recettes->whereBetween('recettepaiements.date_paiement', [$date])->groupBy('months', 'monthKey', "year", 'services.id', 'services.nom');
        }

        $paiements_recettes = $paiements_recettes->orderBy("year", 'ASC')
            ->orderBy("monthKey", 'ASC')
            ->get();

        /** Old ***/
        /*
        $paiements_recettes = $paiements_recettes->groupBy(
        'months', 'monthKey', "year",
        //'categories.id', 'categories.nom',
        'services.id', 'services.nom'
        )
        ->orderBy("year", 'ASC')
        ->orderBy("monthKey", 'ASC')
        ->get();
        */

        return response()
            ->json($paiements_recettes);
    }

    public function StatistiquesDepences(Request $request)
    {
        //$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
        //);
        

        $date = null;
        if ($request->has('filtrer.date')) $date = Helper::getDate($request);

        /*if (!isset($request['all_months'])) {
        $specific_months = [date('m')];
        }else{
        $specific_months = [1,2,3,4,5,6,7,8,9,10,11,12];
        }
        $arr_years = (isset($request['arr_years'])) ? $request['arr_years'] : [date('Y')];
        $arr_months = (isset($request['arr_months'])) ? $request['arr_months'] : $specific_months;
        */
        $paiements_depences = DB::table('depencepaiements')->join('depences', 'depences.id', '=', 'depencepaiements.depence_id')
            ->join('services', 'services.id', '=', 'depences.service_id')
            ->join('categories', 'categories.id', '=', 'services.categorie_id')
            ->select('services.id', 'services.nom as nom_service', DB::raw('count(services.id) as qte') , DB::raw('sum(montant_paye) as sums') , DB::raw("DATE_FORMAT(depencepaiements.date_paiement,'%m / %Y') as months") , DB::raw("DATE_FORMAT(depencepaiements.date_paiement,'%m') as monthKey") , DB::raw("DATE_FORMAT(depencepaiements.date_paiement,'%Y') as year"));

        if (isset($request['filtrer.addSelectDay']) && $request['filtrer.addSelectDay'] == 'true')
        {
            $paiements_depences = $paiements_depences->addSelect(DB::raw("DATE_FORMAT(depencepaiements.date_paiement,'%d') as dayKey") );
        }

        if (isset($request['filtrer.depence_id']))
        {
            $paiements_depences = $paiements_depences->where('depence_id', $request['filtrer.depence_id']);
        }

        if (isset($request['filtrer.service_id']))
        {
            $paiements_depences = $paiements_depences->where('depences.service_id', $request['filtrer.service_id']);
        }

        if (isset($request['filtrer.categorie_id']))
        {
            $paiements_depences = $paiements_depences->where('categories.id', $request['filtrer.categorie_id']);
        }

        if (isset($request['today']))
        {
            $paiements_depences = $paiements_depences->whereDate('depencepaiements.date_paiement', DB::raw('CURDATE()'));
        }

        if (isset($request['arr_months']))
        {
            $paiements_depences = $paiements_depences->whereIn(DB::raw("DATE_FORMAT(depencepaiements.date_paiement,'%m')") , $arr_months);
        }

        if (isset($request['arr_years']))
        {
            $paiements_depences = $paiements_depences->whereIn(DB::raw("DATE_FORMAT(depencepaiements.date_paiement,'%Y')") , $arr_years);
        }

        if (isset($request['filtrer.year']) && isset($request['filtrer.month']))
        {
            $month = intval($request['filtrer.month']);
            $year = intval($request['filtrer.year']);
            $paiements_depences = $paiements_depences->where(DB::raw("DATE_FORMAT(depencepaiements.date_paiement,'%m')") , $month)->where(DB::raw("DATE_FORMAT(depencepaiements.date_paiement,'%Y')") , $year)->whereBetween('depencepaiements.date_paiement', [$date])->groupBy('months', 'monthKey', "year", "dayKey", 'services.id', 'services.nom');
        }
        else
        {
            $paiements_depences = $paiements_depences->whereBetween('depencepaiements.date_paiement', [$date])->groupBy('months', 'monthKey', "year", 'services.id', 'services.nom');
        }

        $paiements_depences = $paiements_depences->orderBy("year", 'ASC')
            ->orderBy("monthKey", 'ASC')
            ->get();

        /** old ***/
        /*
        $paiements_depences = $paiements_depences->groupBy(
        'months', 'monthKey', "year",
        //'categories.id', 'categories.nom',
        'services.id', 'services.nom'
        )
        ->orderBy("year", 'ASC')
        ->orderBy("monthKey", 'ASC')
        ->get();
        
        */

        return response()
            ->json($paiements_depences);
    }

    public function count(Request $request)
    {

        $date = null;
        if ($request->has('filtrer.date')) $date = Helper::getDate($request);

        //$adherents = Adherent::all();
        $adherents = Adherent::whereHas('abonners')->count();

        $adherents_actif = Adherent::whereHas('abonners', function ($abonners) use ($request, $date)
        {
            $abonners->where('suspend', 0)
                ->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
            
                ->where('date_fin', '>=', now());
        })
            ->count();

        $adherents_inactif = Adherent::whereHas('abonners', function ($abonners) use ($request, $date)
        {
            $abonners->where('suspend', 0)
                ->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
            
                ->where('date_fin', '<', now());
        })
        //->orWhereDoesntHave('abonners')
        
            ->count();

        //$adherents_actif = $adherents->where('is_valide', 1)->count();
        //$adherents_inactif = $adherents->where('is_valide', 0)->count();
        //$adherents = $adherents->count();
        $presences = Presence::when($date, function ($query, $date)
        {
            //$query->whereBetween('date_entrer', [ $date ] ) ;
            $query->where('date_entrer', '>=', now());
        })
            ->count();
        $abonners_encours = Abonner::where('date_fin', '>=', now())->count();

        $abonners_termines = Abonner::where('date_fin', '<', now())->count();

        $impayes = 10;

        return response()->json(['count' => ['impayes' => $impayes, 'adherents' => $adherents, 'adherents_inactif' => $adherents_inactif, 'adherents_actif' => $adherents_actif, 'presences' => $presences, 'abonners_encours' => $abonners_encours, 'abonners_termines' => $abonners_termines], ]);

    }

    public function MessagesUnread(Request $request)
    {
        $messages_unread = Message::with(['users' => function ($users) use ($request)
        {
            $users->where('is_valide', 1)
                ->where('to_user_id', Auth::user()
                ->id)
                ->where('seen_it', 0);
        }
        ])->whereHas('users', function ($users) use ($request)
        {
            $users->where('is_valide', 1)
                ->where('to_user_id', Auth::user()
                ->id)
                ->where('seen_it', 0);
        })
            ->count();
        return response()
            ->json($messages_unread);
    }

    public function abonnementsNonPaye(Request $request)
    {

        //if ( $request->has('filtrer.date_echeance') )
        //    $date_echeance = Helper::getDateEcheance($request);
        $date = null;
        if ($request->has('filtrer.date')) $date = Helper::getDate($request);

        $abonnements_non_paye = DB::table('abonners')->join('paiements', 'paiements.id_abonner', '=', 'abonners.id')
            ->join('adherents', 'abonners.id_adherent', '=', 'adherents.id')
            ->join('abonnement_abonner', 'abonners.id', '=', 'abonnement_abonner.abonner_id')
            ->join('abonner_pack', 'abonners.id', '=', 'abonner_pack.abonner_id')
            ->join('packs', 'abonner_pack.pack_id', '=', 'packs.id')
            ->select('adherents.image', 'adherents.nom', 'adherents.code_client', 'abonners.id_adherent', 'abonners.prix_ttc', 'paiements.id_abonner as id_abonner', 'abonners.paiament_date_echeance', DB::raw('sum(paiements.prix) as sums'));

        if ($date != null)
        {
            $abonnements_non_paye = $abonnements_non_paye->whereBetween('abonners.paiament_date_echeance', [$date]);
            //->orWhere('abonners.paiament_date_echeance',  '<=' ,$date[0] );
            
        }

        $abonnements_non_paye = $abonnements_non_paye->where('abonners.prix_ttc', '<>', null)
            ->where('abonners.completed_paiement', '=', 0)
            ->groupBy('adherents.image', 'adherents.nom', 'adherents.code_client', 'abonners.id_adherent', 'abonners.prix_ttc', 'paiements.id_abonner', 'abonners.paiament_date_echeance')
            ->orderBy("abonners.id_adherent", 'DESC')
            ->take(8)
            ->get();
        return response()
            ->json(['abonnements_non_paye' => $abonnements_non_paye]);
    }


    /*** TEST API ***/

     public function ApiAdherentActifAndInactif(Request $request){ //Abonnement En Cours Ou Termines
 // 

        $adherents = Adherent::whereHas('abonners', function ($abonners) use ($request)  {
                                $abonners->whereHas('abonnements', function ($abonnements) use ($request)  {
                                    $abonnements->where('is_active' , 1);
                                })
                                ->whereHas('packs', function ($packs) use ($request)  {
                                    $packs->where('is_active' , 1);
                                }) 
                                ->where('suspend', 0)
                                ->where('has_new_abonnement', 0) // if 0 no abonnement else 1 new abonnement existe
                               // ->where('date_fin', $request['filtrer.symbole'] , now())
                                ->orderBy('id', 'desc');
            });
           
           // ->whereIn('gender' , $genre );
            

 

      //  $count_adherents = $adherents->count();
        $adherent = $adherents->orderBy('id', 'desc')->get(['id', 'code_client', 'id_empreinte','nom'])  ;


        return response()->json(['adherent' => $adherent ]);
        
    }

//     public function ApiAdherentActifAndInactifFUlll(Request $request)
// {
//     $adherents = Adherent::with(['abonners' => function ($query) {
//         $query->select('id_adherent', 'date_debut', 'date_fin'); // Ensure these are the correct columns
//     }])
//     ->whereHas('abonners', function ($abonners) {
//     $abonners->whereHas('abonnements', function ($abonnements) {
//             $abonnements->where('is_active', 1);
//         })
//         ->whereHas('packs', function ($packs) {
//             $packs->where('is_active', 1);
//         })
//         ->where('suspend', 0)
//         ->where('has_new_abonnement', 0);
//     })
//     ->orderBy('id', 'desc')
//     ->get(['id', 'code_client', 'id_empreinte', 'nom','image',]);
    
//     $adherentData = [];
//     foreach ($adherents as $adherent) {
//         $abonner = $adherent->abonners->first(); // Assuming there might be multiple abonners, retrieving the first one
//         $date_fin = $abonner ? $abonner->date_fin : null; // Check if abonner exists and retrieve date_fin
//         $date_debut = $abonner ? $abonner->date_debut : null;
//         $is_active = $date_fin && $date_debut ? now()->between($date_debut, $date_fin) : false;
//         $is_active  = $is_active ? 1:0;

//         $adherentData[] = [
//             // 'id' => $adherent->id,
//             //'code_client' => $adherent->code_client,

//             'id_empreinte' => $adherent->id_empreinte,
//             'nom' => $adherent->nom,
//             'image' =>request()-> getHttpHost(). '/clubi/public/admin/adherents/photos/' . $adherent->image, 
//             'date_debut' => $date_debut,
//             'date_fin' => $date_fin,
//             'statut' => $is_active,

//         ];
//     }
//     $jsonResponse = json_encode(['adherent' => $adherentData], JSON_UNESCAPED_SLASHES);


//     return response($jsonResponse, 200, ['Content-Type' => 'application/json']);

// }
public function ApiAdherentActifAndInactifFUll(Request $request)
{
    $adherents = DB::select("SELECT a.*, b.* FROM adherents a 
                             JOIN abonners b ON a.id = b.id_adherent 
                             JOIN (SELECT id_adherent, MAX(date_debut) as date_debut, MAX(date_fin) AS max_abonner_date 
                                   FROM abonners GROUP BY id_adherent) AS latest_abonner 
                             ON b.id_adherent = latest_abonner.id_adherent AND b.date_debut = latest_abonner.date_debut");
    
    $adherentData = [];
    foreach ($adherents as $adherent) {
        $date_debut = $adherent->date_debut;
        $date_fin = $adherent->date_fin;
        $is_active = $date_fin && $date_debut ? now()->between($date_debut, $date_fin) : false;
        $is_active = $is_active ? 1 : 0;

        $adherentData[] = [
           // 'id' => $adherent->id,
           // 'code_client' => $adherent->code_client,
            'id_empreinte' => $adherent->id_empreinte,
            'nom' => $adherent->nom,
            'image' => request()->getHttpHost() . '/clubi/public/admin/adherents/photos/' . $adherent->image, 
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'statut' => $is_active,
        ];
    }
    $jsonResponse = json_encode(['adherent' => $adherentData], JSON_UNESCAPED_SLASHES);

    return response($jsonResponse, 200, ['Content-Type' => 'application/json']);
}






}

