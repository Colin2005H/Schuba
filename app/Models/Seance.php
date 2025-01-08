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
     * @param String $beginTime debut de la séance au format '[année]-[mois]-[jour]T[heure]:[minute]'
     * @param String $endTime fin de la séance au format '[année]-[mois]-[jour]T[heure]:[minute]'
     * @param int $place id du lieu de la séance
     * @param int $level niveau de la séance (1 à 3)
     * @return String id de la séance créée
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

        //$id = DB::select('select id from plo_seance where li_id = ? and form_niveau = ? and sea_date_deb = ? and sea_date_fin = ?;', [$place, $level, $beginTime, $endTime])[0];
        $id = DB::table('plo_seance')->select('SEA_ID')
        ->where('LI_ID', $place)
        ->where('FORM_NIVEAU', $level)
        ->where('sea_date_deb', $beginTime)
        ->where('sea_date_fin', $endTime)->get()->firstOrFail();

        return $id->SEA_ID;
    }
}
