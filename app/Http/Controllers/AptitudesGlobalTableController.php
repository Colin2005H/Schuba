<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 


class AptitudesGlobalTableController extends Controller
{

    public function showListAptitudes($level)
    {
        $validationsList = DB::table('APT_VALIDE')
        ->join('PLO_UTILISATEUR', 'APT_VALIDE.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('UTI_NIVEAU', '=', $level - 1)
        ->select('APT_VALIDE.UTI_ID', 'APT_CODE', 'VALIDE')
        ->get();

        $studentsList = DB::table('PLO_ELEVE')
        ->join('PLO_UTILISATEUR', 'PLO_ELEVE.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('UTI_NIVEAU', '=', $level - 1)
        ->select('PLO_ELEVE.UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        $skillsList = DB::table('PLO_COMPETENCE')
        ->join('PLO_APTITUDE', 'PLO_COMPETENCE.CPT_ID', '=', 'PLO_APTITUDE.CPT_ID')
        ->select('PLO_COMPETENCE.CPT_ID', DB::raw('count(*) as TOTAL'))
        ->groupBy('CPT_ID')
        ->get();

        $aptitudesList = DB::table('PLO_APTITUDE')
        ->join('PLO_COMPETENCE', 'PLO_APTITUDE.CPT_ID', '=', 'PLO_COMPETENCE.CPT_ID')
        ->orderBy('PLO_APTITUDE.APT_CODE')
        ->select('PLO_APTITUDE.APT_CODE', 'PLO_COMPETENCE.CPT_ID')
        ->get();
        
        return view('aptitudesGlobalTable')->with(compact('validationsList', 'studentsList', 'aptitudesList', 'skillsList', 'level'));
    }
}
?>