<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PloFormation
 * 
 * @property int $FORM_NIVEAU
 * @property string|null $FORM_LIBELLE
 * @property string|null $FORM_DESCRIPTION
 * @property int|null $FORM_PROF_MAX
 * 
 * @property Collection|Appartient[] $appartients
 * @property Collection|Enseigner[] $enseigners
 * @property Collection|GererLaFormation[] $gerer_la_formations
 * @property Collection|PloCompetence[] $plo_competences
 * @property Collection|PloSeance[] $plo_seances
 *
 * @package App\Models
 */
class PloFormation extends Model
{
	protected $table = 'PLO_FORMATION';
	protected $primaryKey = 'FORM_NIVEAU';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'FORM_NIVEAU' => 'int',
		'FORM_PROF_MAX' => 'int'
	];

	protected $fillable = [
		'FORM_LIBELLE',
		'FORM_DESCRIPTION',
		'FORM_PROF_MAX'
	];

	public function appartients()
	{
		return $this->hasMany(Appartient::class, 'FORM_NIVEAU');
	}

	public function enseigners()
	{
		return $this->hasMany(Enseigner::class, 'FORM_NIVEAU');
	}

	public function gerer_la_formations()
	{
		return $this->hasMany(GererLaFormation::class, 'FORM_NIVEAU');
	}

	public function plo_competences()
	{
		return $this->hasMany(PloCompetence::class, 'FORM_NIVEAU');
	}

	public function plo_seances()
	{
		return $this->hasMany(PloSeance::class, 'FORM_NIVEAU');
	}
}
