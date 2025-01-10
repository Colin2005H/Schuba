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
    protected $table = 'plo_seance';

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
            DB::insert("insert into plo_seance (li_id, form_niveau, sea_date_deb, sea_date_fin) values (?, ?, str_to_date(?, \"%Y-%m-%dT%H:%i\"), str_to_date(?, \"%Y-%m-%dT%H:%i\"))", [$place, $level, $beginTime, $endTime]);
            
        } catch (Exception $e){
            DB::rollBack();
            throw $e;
            
        }
        DB::commit();

        //$id = DB::select('select id from plo_seance where li_id = ? and form_niveau = ? and sea_date_deb = ? and sea_date_fin = ?;', [$place, $level, $beginTime, $endTime])[0];
        $id = DB::table('plo_seance')->select('SEA_ID')
        ->where('LI_ID', $place)
        ->where('FORM_NIVEAU', $level)
        ->where('sea_date_deb', $beginTime)
        ->where('sea_date_fin', $endTime)->get()->firstOrFail();

        return $id->SEA_ID;
    }

    
    /**
     * getEleves
     *
     * Get the array of all student of this session.
     * 
     * @return Array
     */
    public function getEleves() {
        $id = DB::table('PLO_SEANCE') 
            ->join('GROUPER', 'PLO_SEANCE.SEA_ID', '=', 'GROUPER.SEA_ID') 
            ->join('PLO_ELEVE', 'GROUPER.UTI_ID', '=', 'PLO_ELEVE.UTI_ID') 
            ->where('PLO_SEANCE.SEA_ID', '=', $this->SEA_ID)
            ->pluck('PLO_ELEVE.UTI_ID');

        $eleves = Eleve::whereIn('UTI_ID', $id)->get();

        return $eleves;
    }
    
    /**
     * getAptEleve
     * 
     * Get the array of the skills 
     * of the student given in this session
     *
     * @param  mixed $eleve_id the id of the student
     * @return Array
     */
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
    
    /**
     * getLieu
     * 
     * Get the location of this session.
     *
     * @return Array
     */
    public function getLieu() {
        $id = DB::table('PLO_LIEU') 
            ->join('PLO_SEANCE', 'PLO_LIEU.LI_ID', '=', 'PLO_SEANCE.LI_ID') 
            ->where('PLO_SEANCE.SEA_ID', '=', $this->SEA_ID)
            ->pluck('PLO_LIEU.LI_ID');

        $lieu = PloLieu::whereIn('LI_ID', $id)->get();

        return $lieu;
    }

    protected $fillable = [
		'LI_ID',
		'FORM_NIVEAU',
		'SEA_DATE_DEB',
		'SEA_DATE_FIN'
	];

	public function plo_formation()
	{
		return $this->belongsTo(PloFormation::class, 'FORM_NIVEAU');
	}

	public function plo_lieu()
	{
		return $this->belongsTo(PloLieu::class, 'LI_ID');
	}

	public function evaluers()
	{
		return $this->hasMany(Evaluer::class, 'SEA_ID');
	}

	public function groupers()
	{
		return $this->hasMany(Grouper::class, 'SEA_ID');
	}
    
    /**
     * getFormation
     * 
     * Get the training of this session.
     *
     * @return Array
     */
    public function getFormation() {
        $id = DB::table('PLO_FORMATION') 
            ->join('PLO_SEANCE', 'PLO_SEANCE.FORM_NIVEAU', '=', 'PLO_FORMATION.FORM_NIVEAU') 
            ->where('PLO_SEANCE.SEA_ID', '=', $this->SEA_ID)
            ->pluck('PLO_FORMATION.FORM_NIVEAU');

        $form = PloFormation::whereIn('FORM_NIVEAU', $id)->get();

        return $form;
    }

    /**
	 * @return bool true if this is the next session in chronological order, false otherwise
	 */
	public function isNext(){
		$currentDate = explode(' ', $this->SEA_DATE_DEB)[0]; //on ne récupère que la date
		$currentLevel = $this->FORM_NIVEAU;

        
		//jointure avec la table evaluer
		$querry = Evaluer::all()->toQuery();
        //dd($currentDate);
		$querry = $querry->join('PLO_SEANCE', 'PLO_SEANCE.SEA_ID', '=', 'EVALUER.SEA_ID')
		->where(DB::raw("SEA_DATE_DEB < str_to_date('".$currentDate."', '%Y-%m-%d')"), true )
		->where('FORM_NIVEAU', $currentLevel);
		//on cherche les séances de la meme formation qui ont lieux avant la notre

        


        //dd($querry->get());
		//on renvoie si il y en a

		return $querry->get()->isEmpty();
	}
}
