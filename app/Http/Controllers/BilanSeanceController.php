<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Aptitude;
use App\Models\Seance;
use App\Models\Evaluation;
use App\Models\Evaluer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BilanSeanceController extends Controller
{

    public function getInfo(int $seance_id)
{
    // Récupérer toutes les évaluations pour cette séance
    $evaluations = Evaluer::where('SEA_ID', $seance_id)
        ->get();

    $default = [];

    foreach ($evaluations as $evaluation) {
        $eleve_id = $evaluation->UTI_ID; // L'ID de l'élève
        $apt_code = (string)$evaluation->APT_CODE; // Le code de l'aptitude
        $evaluation_result = $evaluation->EVA_RESULTAT; // Le résultat de l'évaluation
        $evaluation_commentaire = $evaluation->EVA_COMMENTAIRE; // Le commentaire de l'évaluation

        $default[$eleve_id][$apt_code] = [
            'evaluation' => $evaluation_result,
            'commentaire' => $evaluation_commentaire,
        ];
    }
    //dd($default);
    return $default;
}


        public function showForm(int $seance_id)
    {
        $seance = Seance::find($seance_id);
        $eleves = $seance->getEleves();

        $currentUser = session('user');

        $default = $this->getInfo($seance_id);

        return view('recapitulatif', ['eleves' => $eleves,'seance' => $seance,'currentUser' => $currentUser,'default' => $default]);
    }

    
        public function store(Request $request) {

            
            $sea_id = $request->input('SEA_ID');
            
            //dd($request->presence); // Check structure
            //dd($request->evaluation); // Check structure
            //dd($request->commentaire); // Check structure

            if (!$sea_id) {
                return redirect()->back()->with('error', 'L\'ID de la séance est manquant.');
            }
        
            
            foreach ($request->presence as $eleve => $presence) {
                
                foreach ($request->evaluation[$eleve] as $apt_code => $evaluation) {
                    //dd($sea_id,$eleve,$apt_code);
                    /*$evaluationModel = Evaluer::where('SEA_ID', $sea_id)
                        ->where('APT_CODE', $apt_code)
                        ->where('UTI_ID', $eleve)
                        ->first();*/

                        DB::table('EVALUER')
                        ->where('UTI_ID', $eleve)
                        ->where('APT_CODE', $apt_code)
                        ->where('SEA_ID', $sea_id)
                        ->update([
                            'EVA_COMMENTAIRE' => $request->commentaire[$eleve][$apt_code],
                            'EVA_RESULTAT' => $request->evaluation[$eleve][$apt_code],
                    ]);
                }
            }
        
            
            return redirect('/');
        }
        
        
}