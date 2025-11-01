<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PloLieu
 * 
 * @property int $LI_ID
 * @property string|null $LI_NOM
 * @property string|null $LI_TYPE
 * 
 * @property Collection|PloSeance[] $plo_seances
 *
 * @package App\Models
 */
class PloLieu extends Model
{
	protected $table = 'PLO_LIEU';
	protected $primaryKey = 'LI_ID';
	public $timestamps = false;

	protected $fillable = [
		'LI_NOM',
		'LI_TYPE'
	];

	public function plo_seances()
	{
		return $this->hasMany(PloSeance::class, 'LI_ID');
	}
}
