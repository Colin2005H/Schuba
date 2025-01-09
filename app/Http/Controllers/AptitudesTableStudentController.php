<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 


class AptitudesTableStudentController extends Controller
{

    public function showListAptitudes()
    {
        $userId = session('user')->UTI_ID;
        $userLvl = session('user')->UTI_NIVEAU + 1;

        $skillsList = DB::table('PLO_COMPETENCE')
        ->join('PLO_APTITUDE', 'PLO_COMPETENCE.CPT_ID', '=', 'PLO_APTITUDE.CPT_ID')
        ->select('PLO_COMPETENCE.CPT_ID', DB::raw('count(*) as TOTAL'))
        ->groupBy('CPT_ID')
        ->get();

        $sessionsList = DB::table('PLO_SEANCE')
        ->where('FORM_NIVEAU', '=', $userLvl)
        ->select('SEA_ID', 'SEA_DATE_DEB')
        ->get();

        $evaluationsList = DB::table('PLO_SEANCE')
        ->join('EVALUER', 'PLO_SEANCE.SEA_ID', '=', 'EVALUER.SEA_ID')
        ->where('UTI_ID', '=', $userId)
        ->select('EVALUER.SEA_ID', 'SEA_DATE_DEB', 'APT_CODE', 'EVA_RESULTAT')
        ->get();


        $aptitudesList = DB::table('PLO_APTITUDE')
        ->join('PLO_COMPETENCE', 'PLO_APTITUDE.CPT_ID', '=', 'PLO_COMPETENCE.CPT_ID')
        ->orderBy('PLO_APTITUDE.APT_CODE')
        ->select('PLO_APTITUDE.APT_CODE', 'PLO_COMPETENCE.CPT_ID')
        ->get();


        
        return view('aptitudesTableStudent')->with(compact('sessionsList', 'evaluationsList', 'aptitudesList', 'skillsList'));
    }
}
?>