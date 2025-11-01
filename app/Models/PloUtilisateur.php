<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PloUtilisateur
 * 
 * @property int $UTI_ID
 * @property int|null $CLU_ID
 * @property string|null $UTI_NOM
 * @property string|null $UTI_PRENOM
 * @property string $UTI_MAIL
 * @property string $UTI_MDP
 * @property Carbon $UTI_DATE_CREATION
 * @property string|null $UTI_NIVEAU
 * @property Carbon|null $UTI_DATE_NAISSANCE
 * 
 * @property PloClub|null $plo_club
 * @property PloEleve $plo_eleve
 * @property PloInitiateur $plo_initiateur
 * @property Collection|Valider[] $validers
 *
 * @package App\Models
 */
class PloUtilisateur extends Model
{
	protected $table = 'PLO_UTILISATEUR';
	protected $primaryKey = 'UTI_ID';
	public $timestamps = false;

	protected $casts = [
		'CLU_ID' => 'int',
		'UTI_DATE_CREATION' => 'datetime',
		'UTI_DATE_NAISSANCE' => 'datetime'
	];

	protected $fillable = [
		'CLU_ID',
		'UTI_NOM',
		'UTI_PRENOM',
		'UTI_MAIL',
		'UTI_MDP',
		'UTI_DATE_CREATION',
		'UTI_NIVEAU',
		'UTI_DATE_NAISSANCE'
	];

	public function plo_club()
	{
		return $this->belongsTo(PloClub::class, 'CLU_ID');
	}

	public function plo_eleve()
	{
		return $this->hasOne(PloEleve::class, 'UTI_ID');
	}

	public function plo_initiateur()
	{
		return $this->hasOne(PloInitiateur::class, 'UTI_ID');
	}

	public function validers()
	{
		return $this->hasMany(Valider::class, 'UTI_ID');
	}
}
