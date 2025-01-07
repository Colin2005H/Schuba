<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class Seance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plo_seance';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $primaryKey = "SEA_ID";

    
    /**
     * Insert 
     *
     * @param String $beginTime debut de la séance au format 'heure:minute j/m/a'
     * @param String $endTime fin de la séance au format 'heure:minute j/m/a'
     * @param int $place id du lieu de la séance
     * @param int $level niveau de la séance (1 à 3)
     * @return void
     */
    public static function insert($beginTime, $endTime, $place, $level){
        DB::beginTransaction();
        try{ //
            DB::insert("insert into plo_seance (li_id, form_niveau, sea_date_deb, sea_date_fin) values (?, ?, str_to_date(?, \"%Y-%m-%dT%H:%i\"), str_to_date(?, \"%Y-%m-%dT%H:%i\"))", [$place, $level, $beginTime, $endTime]);
            
        } catch (Exception $e){
            DB::rollBack();
            throw $e;
            
        }
        DB::commit();
        
        
    }
}
