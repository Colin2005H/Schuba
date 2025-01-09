<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PloCompetence
 * 
 * @property string $CPT_ID
 * @property int $FORM_NIVEAU
 * @property string|null $CPT_LIBELLE
 * 
 * @property PloFormation $plo_formation
 * @property Collection|PloAptitude[] $plo_aptitudes
 * @property Collection|Valider[] $validers
 *
 * @package App\Models
 */
class PloCompetence extends Model
{
	protected $table = 'PLO_COMPETENCE';
	protected $primaryKey = 'CPT_ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'FORM_NIVEAU' => 'int'
	];

	protected $fillable = [
		'FORM_NIVEAU',
		'CPT_LIBELLE'
	];

	public function plo_formation()
	{
		return $this->belongsTo(PloFormation::class, 'FORM_NIVEAU');
	}

	public function plo_aptitudes()
	{
		return $this->hasMany(PloAptitude::class, 'CPT_ID');
	}

	public function validers()
	{
		return $this->hasMany(Valider::class, 'CPT_ID');
	}
}
