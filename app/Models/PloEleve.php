<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\PloUtilisateur;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PloEleve
 * 
 * @property int $UTI_ID
 * 
 * @property PloUtilisateur $plo_utilisateur
 * @property Collection|Appartient[] $appartients
 * @property Collection|Evaluer[] $evaluers
 * @property Collection|Grouper[] $groupers
 *
 * @package App\Models
 */
class PloEleve extends Model
{
	use HasApiTokens, HasFactory, Notifiable;
	protected $table = 'plo_eleve';
	protected $primaryKey = 'UTI_ID';
	public $incrementing = false;
	public $timestamps = false;
	public $with = ['plo_utilisateur', 'appartients', 'evaluers'];

	protected $casts = [
		'UTI_ID' => 'int'
	];

	public function plo_utilisateur()
	{
		return $this->belongsTo(PloUtilisateur::class, 'UTI_ID');
	}

	public function appartients()
	{
		return $this->hasMany(Appartient::class, 'UTI_ID');
	}

	public function evaluers()
	{
		return $this->hasMany(Evaluer::class, 'UTI_ID');
	}

	public function groupers()
	{
		return $this->hasMany(Grouper::class, 'UTI_ID');
	}

	/**
	 * Renvoie le niveau de la formation actuelle de l'élève
	 *
	 * @return int niveau de la formation actuelle
	 */
	public function getCurrentFormation(){
		$appartiens = $this->appartients();

		$level = $appartiens->select('FORM_NIVEAU')->orderBy('DATE_INSCRIPTION')->first();
		
		if($level == NULL){
			echo("<script>console.log('rien')</script>");
			return NULL;
		}
		echo("<script>console.log(".$level->FORM_NIVEAU.")</script>");

		
		return $level->FORM_NIVEAU;
	}

	/**
	 * vérifie si l'élève valide l'aptitude en parametre
	 *
	 * @param string $skill code de l'aptitude
	 * @return void
	 */
	public function validate($skill){

		//on prends les évaluations de l'aptitude pour l'utilisateur concerné de la plus récente à la plus ancienne
		$querry = $this->evaluers()
		->join('plo_seance', 'evaluer.sea_id', '=', 'plo_seance.sea_id') 
		->where('APT_CODE', $skill)
		->orderBy('sea_date_deb', 'DESC')->get(); 

		
		if(sizeof($querry) < 3){
			//inutile de tester puisqu'il n'y a pas assez d'évaluations de l'aptitude
			return false; 
		}

		for($i = 0; $i < sizeof($querry) && $i < 3; $i++){
			//on prends les 3 dernières évaluations de l'aptitude

			if(strtolower(trim($querry[$i])) != "acquis"){
				return false;
			}
		}

		return true;
	}
}
