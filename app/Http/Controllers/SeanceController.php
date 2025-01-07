<?php

namespace App\Http\Controllers;

use App\Models\Lieu;
use App\Models\PloSeance;
use App\Models\Seance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeanceController extends Controller
{
    public function index(){
        $this->insert('10:00 07/01/2025', '10:01 07/01/2025', 1, 1);

        return view('creer-seance', ['lieux' => Lieu::all()]);
    }

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
            echo "problème <br>" . $e->getMessage();
            DB::rollBack();
        }
        DB::commit();
        
        
    }
}
