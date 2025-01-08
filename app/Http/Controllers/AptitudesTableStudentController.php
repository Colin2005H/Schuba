<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 


class AptitudesTableStudentController extends Controller
{
    public function showListAptitudes()
    {
        $userId = session('user')->UTI_ID;

        $sessionsList = DB::table('PLO_SEANCE')
        ->join('EVALUER', 'PLO_SEANCE.SEA_ID', '=', 'EVALUER.SEA_ID')
        ->select('SEA_DATE_DEB', 'APT_CODE', 'EVA_RESULTAT')
        ->where('UTI_ID', '=', $userId)
        ->get();

        $aptitudesList = DB::table('PLO_APTITUDE')
        ->join('PLO_COMPETENCE', 'PLO_APTITUDE.CPT_ID', '=', 'PLO_COMPETENCE.CPT_ID')
        ->select('PLO_APTITUDE.APT_CODE', 'PLO_COMPETENCE.CPT_ID')
        ->get();


        
        return view('aptitudesTableStudent')->with(compact('sessionsList', 'aptitudesList'));
    }
}
?>