<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

//controller for the table of aptitudes of students
class AptitudesTableStudentController extends Controller
{
    
    /**
     * showListAptitudes
     * Return a view with all the aptitudes
     * @param  mixed $userId
     * @return void
     */
    public function showListAptitudes($userId)
    {
        $student = DB::table('PLO_ELEVE')
        ->join('PLO_UTILISATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_ELEVE.UTI_ID')
        ->where('PLO_ELEVE.UTI_ID', '=', $userId)
        ->select('PLO_ELEVE.UTI_ID', 'UTI_NOM', 'UTI_PRENOM', 'UTI_NIVEAU')
        ->first();

        $userLvl = $student->UTI_NIVEAU + 1;

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


        
        return view('aptitudesTableStudent')->with(compact('student', 'sessionsList', 'evaluationsList', 'aptitudesList', 'skillsList'));
    }
}
?>