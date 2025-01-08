<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appartient
 * 
 * @property int $FORM_NIVEAU
 * @property int $UTI_ID
 * @property Carbon|null $DATE_INSCRIPTION
 * 
 * @property PloEleve $plo_eleve
 * @property PloFormation $plo_formation
 *
 * @package App\Models
 */
class Appartient extends Model
{
	protected $table = 'appartient';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'FORM_NIVEAU' => 'int',
		'UTI_ID' => 'int',
		'DATE_INSCRIPTION' => 'datetime'
	];

	protected $fillable = [
		'DATE_INSCRIPTION'
	];

	public function plo_eleve()
	{
		return $this->belongsTo(PloEleve::class, 'UTI_ID');
	}

	public function plo_formation()
	{
		return $this->belongsTo(PloFormation::class, 'FORM_NIVEAU');
	}
}
