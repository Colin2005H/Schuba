<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DirigerLeClub
 * 
 * @property int $UTI_ID
 * @property int $CLU_ID
 * @property Carbon|null $DIR_DATE_DEBUT
 * 
 * @property PloClub $plo_club
 * @property PloInitiateur $plo_initiateur
 *
 * @package App\Models
 */
class DirigerLeClub extends Model
{
	protected $table = 'diriger_le_club';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UTI_ID' => 'int',
		'CLU_ID' => 'int',
		'DIR_DATE_DEBUT' => 'datetime'
	];

	protected $fillable = [
		'DIR_DATE_DEBUT'
	];

	public function plo_club()
	{
		return $this->belongsTo(PloClub::class, 'CLU_ID');
	}

	public function plo_initiateur()
	{
		return $this->belongsTo(PloInitiateur::class, 'UTI_ID');
	}
}
