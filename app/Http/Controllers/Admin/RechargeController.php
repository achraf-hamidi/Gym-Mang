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
use App\Recharge;
use App\Solde;
use File;
use QrCode;
use DateTime; 
use DB;

class RechargeController extends Controller
{
   

     public function index(Request $request) {
		$date = Helper::getDate($request); 
    	$recharges = Recharge::whereBetween('created_at', [ $date ]) ;

    	if (isset($request['filtrer.code_client'])) 
    		$recharges = $recharges->where("code_client", $request['filtrer.code_client']);

	    $recharges = $recharges->orderBy('id', 'desc')->paginate(150); 
		return response()->json(['recharges' => $recharges ]);
    }

     public function store(Request $request) {
     	$adherent = Adherent::where('code_client', $request['code_client'] )->first();
		if ($adherent) {
			$type = (isset($request['type']) ) ? $request['type'] : "Recharge" ;
			if ($type == "Parrinage"){
				$type .= ", " . $request['child_code_client'];
			}
			$recharge = Recharge::create([  
				'code_client' =>  $request['code_client'] ,
				'recharge' =>  $request['recharge'] ,
				'type' =>   $type
			]); 

			$rt = Solde::UpdateSolde($request['recharge']  , $request['code_client'] );

			$recharge = Recharge::orderBy('id', 'desc')->first() ;
			return response()->json($recharge);
		}else
			return response()->json("adhérent n'existe pas");
    }


    public function destroy(Request $request) {
    	$recharge = Recharge::find($request['id_recharge']);
    	if ($recharge) {
    		$recharge->delete();
    		$solde = Solde::where('code_client', $recharge->code_client)->first();
    		if ($solde)
				$solde->update([
					'solde' => $solde->solde - $recharge->recharge
				]);

			return response()->json(true);
    	}
		return response()->json(false);
    }

}
