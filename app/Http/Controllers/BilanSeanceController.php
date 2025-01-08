<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Aptitude;
use App\Models\Seance;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class BilanSeanceController extends Controller
{
        public function showForm(/*Seance $seance*/)
    {
        $seance = Seance::all();
        $seance = $seance->first();
        $eleves = $seance->getEleves();

        $currentUser = session('user');

        return view('recapitulatif', ['eleves' => $eleves,'seance' => $seance,'currentUser' => $currentUser]);
    }

        public function store(Request $request) {
            // Validation des données (optionnel)
            $validatedData = $request->validate([
                'presence.*' => 'boolean', // Validation de la présence (vrai ou faux)
                'evaluation.*.*' => 'required|string', // Evaluation pour chaque aptitude (doit être une chaîne)
                'commentaire.*.*' => 'nullable|string', // Commentaire pour chaque aptitude (peut être vide)
            ]);
        
            
            $sea_id = $request->input('SEA_ID');
            
            
            if (!$sea_id) {
                return redirect()->back()->with('error', 'L\'ID de la séance est manquant.');
            }
        
            
            foreach ($request->presence as $eleve) {
                
                foreach ($request->evaluation[$eleve] as $apt_code => $evaluation) {
                    
                    $evaluationModel = Evaluation::where('SEA_ID', $sea_id)
                        ->where('APT_CODE', $apt_code)
                        ->where('UTI_ID', $eleve)
                        ->first();
                    
                    
                    if ($evaluationModel) {
                        $evaluationModel->EVA_RESULTAT = $evaluation; 
                        $evaluationModel->EVA_COMMENTAIRE = $request->commentaire[$eleve][$apt_code] ?? null;
                        
                        
                        $evaluationModel->save();
                    }
                }
            }
        
            
            return redirect('/');
        }
        
        
}