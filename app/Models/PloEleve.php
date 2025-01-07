<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}