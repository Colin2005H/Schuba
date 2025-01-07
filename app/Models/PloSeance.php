<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PloSeance
 * 
 * @property int $SEA_ID
 * @property int $LI_ID
 * @property int $FORM_NIVEAU
 * @property Carbon|null $SEA_DATE_DEB
 * @property Carbon|null $SEA_DATE_FIN
 * 
 * @property PloFormation $plo_formation
 * @property PloLieu $plo_lieu
 * @property Collection|Evaluer[] $evaluers
 * @property Collection|Grouper[] $groupers
 *
 * @package App\Models
 */
class PloSeance extends Model
{
	protected $table = 'plo_seance';
	protected $primaryKey = 'SEA_ID';
	public $timestamps = false;

	protected $casts = [
		'LI_ID' => 'int',
		'FORM_NIVEAU' => 'int',
		'SEA_DATE_DEB' => 'datetime',
		'SEA_DATE_FIN' => 'datetime'
	];

	protected $fillable = [
		'LI_ID',
		'FORM_NIVEAU',
		'SEA_DATE_DEB',
		'SEA_DATE_FIN'
	];

	public function plo_formation()
	{
		return $this->belongsTo(PloFormation::class, 'FORM_NIVEAU');
	}

	public function plo_lieu()
	{
		return $this->belongsTo(PloLieu::class, 'LI_ID');
	}

	public function evaluers()
	{
		return $this->hasMany(Evaluer::class, 'SEA_ID');
	}

	public function groupers()
	{
		return $this->hasMany(Grouper::class, 'SEA_ID');
	}
}
