<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ValidationCompetencesController extends Controller
{

    public function showCompetences($user)
    {
        // Récupérer les informations de l'élève
        $student = DB::table('PLO_ELEVE')
            ->join('PLO_UTILISATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_ELEVE.UTI_ID')
            ->where('PLO_ELEVE.UTI_ID', '=', $user)
            ->select('PLO_ELEVE.UTI_ID', 'UTI_NOM', 'UTI_PRENOM', 'UTI_NIVEAU')
            ->first();
    
        // Récupérer les compétences validables pour le prochain niveau
        $validableCompetences = DB::table('COMPETENCES_VALIDABLES')
            ->join('PLO_COMPETENCE', 'PLO_COMPETENCE.CPT_ID', '=', 'COMPETENCES_VALIDABLES.CPT_ID')
            ->where('UTI_ID', '=', $user)
            ->where('FORM_NIVEAU', $student->UTI_NIVEAU + 1)
            ->select('PLO_COMPETENCE.CPT_ID', 'CPT_LIBELLE')
            ->get();
    
        // Nombre total de compétences nécessaires pour le niveau supérieur
        $nbComp = DB::table('PLO_COMPETENCE')
            ->where('FORM_NIVEAU', $student->UTI_NIVEAU + 1)
            ->count();
    
        // Nombre de compétences validées (équivalent au nombre de validableCompetences)
        $nbCompValidated = count($validableCompetences);
    
        // Passez les données nécessaires à la vue
        return view('validationCompetences', compact('validableCompetences', 'student', 'nbComp', 'nbCompValidated'));
    }
    


    public function valideCompetences(Request $request)
{
    // Insérer les données dans la table 'VALIDER'
    DB::table('PLO_UTILISATEUR')
    ->where('UTI_ID', '=', $request->UTI_ID)
    ->update(array('UTI_NIVEAU' => $request->UTI_NIVEAU + 1));

    // Redirection après insertion
    return redirect()->back()->with('success', 'Compétence validée avec succès !');
}

}
?>