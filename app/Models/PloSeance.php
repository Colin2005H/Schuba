<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PloSeance extends Model
{
    use HasFactory;

    
    /**
     * Undocumented function
     *
     * @param String $beginTime debut de la séance au format 'heure:minute j/m/a'
     * @param String $endTime fin de la séance au format 'heure:minute j/m/a'
     * @param int $place id du lieu de la séance
     * @param int $level niveau de la séance (1 à 3)
     * @return void
     */
    public function insert($beginTime, $endTime, $place, $level){
        DB::beginTransaction();
        try{
            DB::insert("insert plo_seances (li_id, form_niveau, sea_date_deb, sea_date_fin) values (?, ?, str_to_date(?, \"%H:%i %d/%m/%Y\"), str_to_date(?, \"%H:%i %d/%m/%Y\"))", [$place, $level, $beginTime, $endTime]);
        } catch (Exception $e){
            echo "problème" . $e->getMessage();
            DB::rollBack();
        }
        DB::commit();
        
        
    }
}
