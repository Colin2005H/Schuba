<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PloAptitude
 * 
 * @property string $APT_CODE
 * @property string $CPT_ID
 * @property string $APT_LIBELLE
 * 
 * @property PloCompetence $plo_competence
 * @property Collection|Evaluer[] $evaluers
 *
 * @package App\Models
 */
class PloAptitude extends Model
{
	protected $table = 'PLO_APTITUDE';
	protected $primaryKey = 'APT_CODE';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'CPT_ID',
		'APT_LIBELLE'
	];

	public function plo_competence()
	{
		return $this->belongsTo(PloCompetence::class, 'CPT_ID');
	}

	public function evaluers()
	{
		return $this->hasMany(Evaluer::class, 'APT_CODE');
	}
}
