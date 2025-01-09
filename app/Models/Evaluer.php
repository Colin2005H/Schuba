<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Evaluer
 * 
 * @property int $SEA_ID
 * @property string $APT_CODE
 * @property int $UTI_ID
 * @property string|null $EVA_COMMENTAIRE
 * @property string|null $EVA_RESULTAT
 * 
 * @property PloAptitude $plo_aptitude
 * @property PloEleve $plo_eleve
 * @property PloSeance $plo_seance
 *
 * @package App\Models
 */
class Evaluer extends Model
{
	protected $table = 'EVALUER';
	public $incrementing = false;
	public $timestamps = false;

	protected $primaryKey = 'SEA_ID';

	protected $casts = [
		'SEA_ID' => 'int',
		'UTI_ID' => 'int'
	];

	protected $fillable = [
		'EVA_COMMENTAIRE',
		'EVA_RESULTAT',
		'SEA_ID',
		'UTI_ID',
		'APT_CODE'
	];

	public function plo_aptitude()
	{
		return $this->belongsTo(PloAptitude::class, 'APT_CODE');
	}

	public function plo_eleve()
	{
		return $this->belongsTo(PloEleve::class, 'UTI_ID');
	}

	public function plo_seance()
	{
		return $this->belongsTo(PloSeance::class, 'SEA_ID');
	}

	/**
	 * @return bool true if this is the next assessment in chronological order, false otherwise
	 */
	public function isNext(){
		$currentDate = $this->plo_seance->SEA_DATE_DEB;
		$currentLevel = $this->plo_seance->FORM_NIVEAU;

		//jointure avec la table evaluer
		$querry = Evaluer::whereIn('SEA_ID')
		->join('PLO_SEANCE', 'PLO_SEANCE.SEA_ID', '=', 'EVALUER.SEA_ID')
		->where('SEA_DATE_DEB', '<', $currentDate)
		->where('FORM_NIVEAU', $currentLevel)
		->order('SEA_DATE', 'DESC');
		//on cherche les evaluations de la meme formation pour une séance qui a lieu avant la notre

		//on renvoie si il y en a
		return $querry->get()->isEmpty();
	}

}
