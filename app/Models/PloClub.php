<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PloClub
 * 
 * @property int $CLU_ID
 * @property string|null $CLU_NOM
 * 
 * @property Collection|DirigerLeClub[] $diriger_le_clubs
 * @property Collection|PloUtilisateur[] $plo_utilisateurs
 *
 * @package App\Models
 */
class PloClub extends Model
{
	protected $table = 'PLO_CLUB';
	protected $primaryKey = 'CLU_ID';
	public $timestamps = false;

	protected $fillable = [
		'CLU_NOM'
	];

	public function diriger_le_clubs()
	{
		return $this->hasMany(DirigerLeClub::class, 'CLU_ID');
	}

	public function plo_utilisateurs()
	{
		return $this->hasMany(PloUtilisateur::class, 'CLU_ID');
	}
}
