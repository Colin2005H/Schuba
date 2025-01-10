<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ValidationCompetencesController extends Controller
{

    public function showCompetences($user)
    {
        // Fetch student information
        $student = DB::table('PLO_ELEVE')
            ->join('PLO_UTILISATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_ELEVE.UTI_ID')
            ->where('PLO_ELEVE.UTI_ID', '=', $user)
            ->select('PLO_ELEVE.UTI_ID', 'UTI_NOM', 'UTI_PRENOM', 'UTI_NIVEAU')
            ->first();
    
        // fetch validable competences for the next level
        $validableCompetences = DB::table('COMPETENCES_VALIDABLES')
            ->join('PLO_COMPETENCE', 'PLO_COMPETENCE.CPT_ID', '=', 'COMPETENCES_VALIDABLES.CPT_ID')
            ->where('UTI_ID', '=', $user)
            ->where('FORM_NIVEAU', $student->UTI_NIVEAU + 1)
            ->select('PLO_COMPETENCE.CPT_ID', 'CPT_LIBELLE')
            ->get();
    
        //Total number of competences needed for the next level
        $nbComp = DB::table('PLO_COMPETENCE')
            ->where('FORM_NIVEAU', $student->UTI_NIVEAU + 1)
            ->count();
    
        // number of validated competences (equivalent to the number of validableCompetences)
        $nbCompValidated = count($validableCompetences);
    
        // Transfer data to the view 
        return view('validationCompetences', compact('validableCompetences', 'student', 'nbComp', 'nbCompValidated'));
    }
    


    public function valideCompetences(Request $request)
{
    //insert data into the 'VALIDER' table
    DB::table('PLO_UTILISATEUR')
    ->where('UTI_ID', '=', $request->UTI_ID)
    ->update(array('UTI_NIVEAU' => $request->UTI_NIVEAU + 1));

    // rederiction after insertion
    return redirect()->back()->with('success', 'Compétence validée avec succès !');
}

}
?>