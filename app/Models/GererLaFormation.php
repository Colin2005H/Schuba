<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GererLaFormation
 * 
 * @property int $UTI_ID
 * @property int $FORM_NIVEAU
 * @property Carbon|null $GER_DATE_DEBUT
 * 
 * @property PloFormation $plo_formation
 * @property PloInitiateur $plo_initiateur
 *
 * @package App\Models
 */
class GererLaFormation extends Model
{
	protected $table = 'gerer_la_formation';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UTI_ID' => 'int',
		'FORM_NIVEAU' => 'int',
		'GER_DATE_DEBUT' => 'datetime'
	];

	protected $fillable = [
		'GER_DATE_DEBUT'
	];

	public function plo_formation()
	{
		return $this->belongsTo(PloFormation::class, 'FORM_NIVEAU');
	}

	public function plo_initiateur()
	{
		return $this->belongsTo(PloInitiateur::class, 'UTI_ID');
	}
}
