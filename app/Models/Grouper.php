<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Grouper
 * 
 * @property int $SEA_ID
 * @property int $UTI_ID_INITIATEUR
 * @property int $UTI_ID
 * @property bool|null $GRP_PRESENCE
 * 
 * @property PloEleve $plo_eleve
 * @property PloInitiateur $plo_initiateur
 * @property PloSeance $plo_seance
 *
 * @package App\Models
 */
class Grouper extends Model {
	protected $table = 'GROUPER';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'SEA_ID' => 'int',
		'UTI_ID_INITIATEUR' => 'int',
		'UTI_ID' => 'int',
		'GRP_PRESENCE' => 'bool'
	];

	protected $fillable = [
		'GRP_PRESENCE'
	];

	public function plo_eleve()
	{
		return $this->belongsTo(PloEleve::class, 'UTI_ID');
	}

	public function plo_initiateur()
	{
		return $this->belongsTo(PloInitiateur::class, 'UTI_ID_INITIATEUR');
	}

	public function plo_seance()
	{
		return $this->belongsTo(PloSeance::class, 'SEA_ID');
	}
}
