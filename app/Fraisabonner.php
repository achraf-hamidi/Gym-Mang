<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fraisabonner extends Model
{
    protected $fillable = [
        'id_abonner', 'id_assuranceps', 'prix', 'updated_at', 'created_at'
    ];

   // protected $with      = ['NomFrais'];
    protected $appends = ['NomFrais'];

    public function abonner()
    {
        return $this->belongsTo('App\Abonner','id_abonner');
    }

    public function getNomFraisAttribute() // from table assurance
    {
        //return $this->belongsTo('App\Assurancep','id_assuranceps');
        $nomFrais = Assurancep::where('id', $this->id_assuranceps )->first();
        if($nomFrais){
            return $nomFrais->libelle . " : " . $nomFrais->prix ." Dh";
        }
        return null;
    }



}
