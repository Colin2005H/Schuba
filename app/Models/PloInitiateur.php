<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PloInitiateur
 * 
 * @property int $UTI_ID
 * 
 * @property PloUtilisateur $plo_utilisateur
 * @property Collection|DirigerLeClub[] $diriger_le_clubs
 * @property Collection|Enseigner[] $enseigners
 * @property Collection|GererLaFormation[] $gerer_la_formations
 * @property Collection|Grouper[] $groupers
 *
 * @package App\Models
 */
class PloInitiateur extends Model
{
	protected $table = 'PLO_INITIATEUR';
	protected $primaryKey = 'UTI_ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UTI_ID' => 'int'
	];

	public function plo_utilisateur()
	{
		return $this->belongsTo(PloUtilisateur::class, 'UTI_ID');
	}

	public function diriger_le_clubs()
	{
		return $this->hasMany(DirigerLeClub::class, 'UTI_ID');
	}

	public function enseigners()
	{
		return $this->hasMany(Enseigner::class, 'UTI_ID');
	}

	public function gerer_la_formations()
	{
		return $this->hasMany(GererLaFormation::class, 'UTI_ID');
	}

	public function groupers()
	{
		return $this->hasMany(Grouper::class, 'UTI_ID_INITIATEUR');
	}
}
