<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Valider
 * 
 * @property int $UTI_ID
 * @property string $CPT_ID
 * @property bool $VALIDER
 * 
 * @property PloCompetence $plo_competence
 * @property PloUtilisateur $plo_utilisateur
 *
 * @package App\Models
 */
class Valider extends Model
{
	protected $table = 'VALIDER';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UTI_ID' => 'int',
		'VALIDER' => 'bool'
	];

	protected $fillable = [
		'VALIDER'
	];

	public function plo_competence()
	{
		return $this->belongsTo(PloCompetence::class, 'CPT_ID');
	}

	public function plo_utilisateur()
	{
		return $this->belongsTo(PloUtilisateur::class, 'UTI_ID');
	}
}
