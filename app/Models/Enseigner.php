<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Enseigner
 * 
 * @property int $UTI_ID
 * @property int $FORM_NIVEAU
 * 
 * @property PloFormation $plo_formation
 * @property PloInitiateur $plo_initiateur
 *
 * @package App\Models
 */
class Enseigner extends Model
{
	protected $table = 'ENSEIGNER';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UTI_ID' => 'int',
		'FORM_NIVEAU' => 'int'
	];

	public function plo_formation()
	{
		return $this->belongsTo(PloFormation::class, 'FORM_NIVEAU');
	}

	public function plo_initiateur()
	{
		return $this->belongsTo(PloInitiateur::class, 'UTI_ID');
	}

	public function getTeachingLevel($userId){

        $level = DB::table('ENSEIGNER')
            ->where('UTI_ID', '=', $userId)
			->select('FORM_NIVEAU')
			->first();

			return $level->FORM_NIVEAU;

		}
}
