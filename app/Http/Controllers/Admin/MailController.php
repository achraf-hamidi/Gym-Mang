<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\FicheInscription ;
use App\Mail\RappelDePaiement ;
use App\Mail\EmailManuel;
use App\Adherent;
use App\Abonner;
use App\Paiement;
use App\User;
use App\Helper\Helper;
use DB;
use Mail;


class MailController extends Controller
{
    public function FicheInscription(Request $request, $abonner){

        $details_abonnement = Abonner::with(['adherent', 'abonnements', 'packs'])->where('id', $abonner)->first();

        $paiements = Paiement::where('id_abonner', $abonner)->sum('prix');

        //dd($paiements);   
        $email_adherent = $details_abonnement->adherent->email;
        //die();
        $abonner = $details_abonnement ;

        Mail::to($email_adherent)->send(new FicheInscription($details_abonnement, $paiements));

        return redirect()->back();
        //return view('emails.fiche_inscription', compact('abonner', 'paiements') );
        //dd("Email is Sent.");
    }

    public function RappelDePaiement(Request $request, $abonner){

        $details_abonnement = Abonner::with(['adherent', 'abonnements', 'packs'])->where('id', $abonner)->first();

        $paiements = Paiement::where('id_abonner', $abonner)->sum('prix');

        //dd($paiements);   

        //echo $details_abonnement->adherent->email;
        //die();
        $email_adherent = $details_abonnement->adherent->email;
        
        Mail::to($email_adherent)->send(new RappelDePaiement($details_abonnement, $paiements));
        return redirect()->back();
        //return view('emails.fiche_inscription', compact('abonner', 'paiements') );
        //dd("Email is Sent.");
    }

    public function EmailManuel(Request $request, $adherent = null){

       // if ($adherent != null) {
       //     $adherents_mails = Adherent::whereIn('id', [$adherent])->pluck('email')->toArray();
       // }else {
       //     $adherents_mails = Adherent::pluck('email')->toArray();
       // }

        $adherents_mails = array(); 

        foreach ($request['list_mails_adherents'] as $key => $email) {
             array_push($adherents_mails, $email );
        }
     
        $titre = $request['titre'];
        $description = $request['description'];

        try {
            Mail::to($adherents_mails)->send(new EmailManuel($description, $titre));
            return response()->json(['email' => true]); 
        } catch (Exception $e) {
            return response()->json(['email' => false]); 

        }
        
    }



    public function getMailsAdherents(Request $request){ // La liste des emails adhérents
        //if ( $request->has('filtrer.date_echeance') )
        //    $date_echeance = Helper::getDateEcheance($request); 

        $date = null ;
        if ( $request->has('filtrer.date') )
            $date = Helper::getDate($request); 

        $list_mails_adherents = DB::table('abonners')
                    ->join('paiements', 'paiements.id_abonner', '=', 'abonners.id')
                    ->join('adherents', 'abonners.id_adherent', '=', 'adherents.id')
                    ->join('abonnement_abonner', 'abonners.id', '=', 'abonnement_abonner.abonner_id')
                    ->join('abonner_pack', 'abonners.id', '=', 'abonner_pack.abonner_id')
                    ->join('packs', 'abonner_pack.pack_id', '=', 'packs.id')
                     ->join('abonnements', 'abonnement_abonner.abonnement_id', '=', 'abonnements.id')
                    ->select(
                        'adherents.email as email',
                        'adherents.code_client as code_client',
                        'adherents.id_empreinte as id_empreinte',
                         
                    ) ;
                     

        if (isset($request['filtrer.abonnement_id'])) {
             $list_mails_adherents = $list_mails_adherents->where('abonnement_abonner.abonnement_id', $request['filtrer.abonnement_id']);
        }

        if (isset($request['filtrer.pack_id'])) {
             $list_mails_adherents = $list_mails_adherents->where('abonner_pack.pack_id', $request['filtrer.pack_id']);
        }

        if (isset($request['filtrer.matricule'])) { 
            $list_mails_adherents = $list_mails_adherents
                                    ->where('adherents.code_client', $request['filtrer.matricule'] )
                                    ->orWhere('adherents.cin', $request['filtrer.matricule'] )
                                    ->orWhere('adherents.id_empreinte', $request['filtrer.matricule'] );
         }

        if (isset($request['filtrer.genre'])) { 
            $list_mails_adherents = $list_mails_adherents
                                    ->where('adherents.gender', $request['filtrer.genre'] ) ;
         }
         if (isset($request['filtrer.id_empreinte'])) { 
            $list_mails_adherents = $list_mails_adherents
                                    ->where('adherents.id_empreinte', $request['filtrer.id_empreinte'] ) ;
         }

        if (isset($request['filtrer.nom'])) { 
            $list_mails_adherents = $list_mails_adherents
                                    ->where('adherents.nom', 'like', '%'.$request['filtrer.nom'].'%');
         }

        if ($date != null) {
             $list_mails_adherents = $list_mails_adherents->whereBetween('abonners.paiament_date_echeance', [$date] );
        }

        if (isset($request['filtrer.completed_paiement']) && $request['filtrer.completed_paiement'] != 'tous') {  // 0 not complete, 1 completed
            $list_mails_adherents = $list_mails_adherents
                                    ->where('abonners.completed_paiement'  ,'=', $request['filtrer.completed_paiement'] );
        }

        if (isset($request['filtrer.is_actif']) && $request['filtrer.is_actif'] != 'tous' ) {  // 0 not complete, 1 completed
            $list_mails_adherents = $list_mails_adherents
                                    ->where('abonners.date_fin', $request['filtrer.is_actif'], now() ); 
        }

        $list_mails_adherents = $list_mails_adherents->where('abonners.prix_ttc'  ,'<>', null)
                                ->where('adherents.email'  ,'<>', '')
                    
                     
                    ->orderBy("abonners.id_adherent", 'DESC')
                    ->distinct()
                    ->get();   

               //dd($list_mails_adherents);
        return response()->json([ 'list_mails_adherents' => $list_mails_adherents]); 
    }


}
