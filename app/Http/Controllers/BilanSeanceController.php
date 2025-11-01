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
        $evaluations = Evaluer::where('SEA_ID', $session_id)
            ->get();

        $default = [];

        foreach ($evaluations as $evaluation) {
            $eleve_id = $evaluation->UTI_ID;
            $apt_code = (string) $evaluation->APT_CODE;
            $evaluation_result = $evaluation->EVA_RESULTAT;
            $evaluation_commentaire = $evaluation->EVA_COMMENTAIRE;

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
    public function showForm(int $session_id)
    {
        $seance = Seance::find($session_id);
        $eleves = $seance->getEleves();

        $currentUser = session('user');

        $default = $this->getInfo($session_id);

        return view('recapitulatif', ['eleves' => $eleves, 'seance' => $seance, 'currentUser' => $currentUser, 'default' => $default]);
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
    public function store(Request $request)
    {


        $sea_id = $request->input('SEA_ID');

        if (!$sea_id) {
            return redirect()->back()->with('error', 'L\'ID de la séance est manquant.');
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


        return redirect('/');
    }


}