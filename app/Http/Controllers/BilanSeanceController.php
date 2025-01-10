<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Aptitude;
use App\Models\Seance;
use App\Models\Evaluation;
use App\Models\Evaluer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BilanSeanceController extends Controller
{
    
    /**
     * getInfo
     *
     * Get all uefull information of the evaluations of this session
     * to set them as default in the form.
     * 
     * @param  mixed $session_id the id of the session
     * @return void
     */
    public function getInfo(int $session_id)
{
    // Fetch all evaluations for this session
    $evaluations = Evaluer::where('SEA_ID', $seance_id)
        ->get();

    $default = [];

    foreach ($evaluations as $evaluation) {
        $eleve_id = $evaluation->UTI_ID; // student ID
        $apt_code = (string)$evaluation->APT_CODE; // aptitude code
        $evaluation_result = $evaluation->EVA_RESULTAT; // evaluation result
        $evaluation_commentaire = $evaluation->EVA_COMMENTAIRE; // evaluation comment

        $default[$eleve_id][$apt_code] = [
            'evaluation' => $evaluation_result, // evaluation result
            'commentaire' => $evaluation_commentaire, // evaluation comment
        ];
    }
    //dd($default);
    return $default;
}

        
        /**
         * showForm
         *
         * Redirect 
         * to the form with all data of the session.
         *
         * @param  mixed $session_id the id of the session
         * @return void
         */
        public function showForm(int $session_id){
        
        $seance = Seance::find($session_id);
        $eleves = $seance->getEleves();

        

        if($seance->isNext()){
            $currentUser = session('user');

            $default = $this->getInfo($session_id);

            return view('recapitulatif', ['eleves' => $eleves,'seance' => $seance,'currentUser' => $currentUser,'default' => $default]);
        }

        return Redirect::route("calendar.show")->with('failure', "d'autres évaluations doivent être faites avant");
    }

            
        /**
         * store
         *
         * Update the evaluation from the databse
         * with change from the form
         * 
         * @param  mixed $request the results of the form
         * @return void
         */
        public function store(Request $request) {

            
            $sea_id = $request->input('SEA_ID');

            if (!$sea_id) {
                return Redirect::route('calendar.show')->with('failure', 'L\'ID de la séance est manquant.');
            }
        
            // Update the evaluation of the students 
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
        
            dd("fin de store");
            return redirect('calendar.show');
        }
        
        
}