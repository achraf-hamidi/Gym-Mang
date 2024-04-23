<?php
namespace App\Helper;

use Illuminate\Http\Request;
use Carbon\Carbon; 
use DateTime ;
class Helper
{

	static function getDate(Request $request) {
        if ( $request->has('filtrer.date') ) { 
           
            //$dates = explode(",",$request['filtrer.date']);
            ///$to = explode(",",$request['filtrer.date']);     
        
            $from =date_create($request['filtrer.date.from']);
            $from = ( Carbon::parse( date_format($from, 'Y-m-d H:i:s') ) ) ; //->subDays(10);

            $to = date_create($request['filtrer.date.to']);
            $to = ( Carbon::parse( date_format($to, 'Y-m-d H:i:s') ) )->addDays(1);

            $from = date_format($from, 'Y-m-d H:i:s');
            $to = date_format($to, 'Y-m-d H:i:s');
            $date = [$from, $to];

        }else{

            $from = date_create(now());
            $from = ( Carbon::parse( date_format($from, 'Y-m-d H:i:s') ) )->subDays(10);

            $to = date_create(now());
            $to = ( Carbon::parse( date_format($to, 'Y-m-d H:i:s') ) )->addDays(120);

            $from = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s',strtotime('-10 days')))) ;
            $to   = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s',strtotime('+120 days'))));
            $date = [$from, $to];
        } 
        //print_r($date);
        return $date;
    }

    static function getDateEcheance(Request $request) {
        if ( $request->has('filtrer.date_echeance') ) { 
            $date_echeance =date_create($request['filtrer.date_echeance']);
            $date_echeance = ( Carbon::parse( date_format($date_echeance, 'Y-m-d H:i:s') ) ) ; 
            return $date_echeance ;
        }
        return null;
    }

}

