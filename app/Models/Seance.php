<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class Seance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'PLO_SEANCE';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $primaryKey = "SEA_ID";

    
    /**
     * Insert 
     *
     * @param String $beginTime debut de la séance au format '[année]-[mois]-[jour]T[heure]:[minute]'
     * @param String $endTime fin de la séance au format '[année]-[mois]-[jour]T[heure]:[minute]'
     * @param int $place id du lieu de la séance
     * @param int $level niveau de la séance (1 à 3)
     * @return String id de la séance créée
     */
    public static function insert($beginTime, $endTime, $place, $level){
        DB::beginTransaction();
        try{ //
            DB::insert("insert into PLO_SEANCE (li_id, form_niveau, sea_date_deb, sea_date_fin) values (?, ?, str_to_date(?, \"%Y-%m-%dT%H:%i\"), str_to_date(?, \"%Y-%m-%dT%H:%i\"))", [$place, $level, $beginTime, $endTime]);
            
        } catch (Exception $e){
            DB::rollBack();
            throw $e;
            
        }
        DB::commit();

        //$id = DB::select('select id from plo_seance where li_id = ? and form_niveau = ? and sea_date_deb = ? and sea_date_fin = ?;', [$place, $level, $beginTime, $endTime])[0];
        $id = DB::table('PLO_SEANCE')->select('SEA_ID')
        ->where('LI_ID', $place)
        ->where('FORM_NIVEAU', $level)
        ->where('sea_date_deb', $beginTime)
        ->where('sea_date_fin', $endTime)->get()->firstOrFail();

        return $id->SEA_ID;
    }


    public function getEleves() {
        $id = DB::table('PLO_SEANCE') 
            ->join('GROUPER', 'PLO_SEANCE.SEA_ID', '=', 'GROUPER.SEA_ID') 
            ->join('PLO_ELEVE', 'GROUPER.UTI_ID', '=', 'PLO_ELEVE.UTI_ID') 
            ->where('PLO_SEANCE.SEA_ID', '=', $this->SEA_ID)
            ->pluck('PLO_ELEVE.UTI_ID');

        $eleves = Eleve::whereIn('UTI_ID', $id)->get();

        return $eleves;
    }

    public function getAptEleve(int $eleve_id) {
 
        $codes = DB::table('PLO_APTITUDE') 
            ->join('EVALUER', 'PLO_APTITUDE.APT_CODE', '=', 'EVALUER.APT_CODE')
            ->join('PLO_SEANCE', 'EVALUER.SEA_ID', '=', 'PLO_SEANCE.SEA_ID') 
            ->join('GROUPER', 'PLO_SEANCE.SEA_ID', '=', 'GROUPER.SEA_ID') 
            ->join('PLO_ELEVE', 'GROUPER.UTI_ID', '=', 'PLO_ELEVE.UTI_ID') 
            ->where('EVALUER.UTI_ID', '=', $eleve_id)
            ->where('PLO_SEANCE.SEA_ID', '=', $this->SEA_ID)
            ->pluck('PLO_APTITUDE.APT_CODE');

    

        if ($codes->isEmpty()) {
            return collect(); 
        }
    
        $aptitudes = Aptitude::whereIn('APT_CODE', $codes)->get();
    
        return $aptitudes;
    }

    public function getLieu() {
        $id = DB::table('PLO_LIEU') 
            ->join('PLO_SEANCE', 'PLO_LIEU.LI_ID', '=', 'PLO_SEANCE.LI_ID') 
            ->where('PLO_SEANCE.SEA_ID', '=', $this->SEA_ID)
            ->pluck('PLO_LIEU.LI_ID');

        $lieu = PloLieu::whereIn('LI_ID', $id)->get();

        //dd($lieu);

        return $lieu;
    }

    public function getFormation() {
        $id = DB::table('PLO_FORMATION') 
            ->join('PLO_SEANCE', 'PLO_SEANCE.FORM_NIVEAU', '=', 'PLO_FORMATION.FORM_NIVEAU') 
            ->where('PLO_SEANCE.SEA_ID', '=', $this->SEA_ID)
            ->pluck('PLO_FORMATION.FORM_NIVEAU');

        $form = PloFormation::whereIn('FORM_NIVEAU', $id)->get();

        return $form;
    }
}
