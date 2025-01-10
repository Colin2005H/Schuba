<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Evaluer;
use App\Models\Grouper;
use App\Models\PloAptitude;
use App\Models\PloEleve;
use App\Models\PloSeance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class workedSkillsController extends Controller
{
    public function index($id)
    {
        //code dupliqué de SeanceController : il faudrait le déplacer dans le modèle
        //enable to fetch the level of the training manager
        DB::beginTransaction();

        $niveau = NULL;

        try {
            //TODO peut-être déplacer ça dans le model
            $niveau = DB::table('GERER_LA_FORMATION')->select('FORM_NIVEAU')->where('UTI_ID', session('user')->UTI_ID)->get()->firstOrFail();
            $niveau = $niveau->FORM_NIVEAU;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        DB::commit();
        // fin du code dupliqué
        $seance = PloSeance::find($id);

        if ($seance != NULL && $niveau!= NULL) {

            //fetch only students of the session
            $eleves = PloEleve::all()->filter(function (PloEleve $eleve) use ($seance) {
                //début du filtre

                $groupes = $eleve->groupers->filter(function (Grouper $groupe) use ($seance) {
                    return $groupe->SEA_ID == $seance->SEA_ID; //return the groups in which the student is and which are in the session
                });

                //if no group left then the student is not in the session
                return $groupes->isNotEmpty();
            }) //fin du filtre
                ->map(function (PloEleve $eleve) {

                    //fetch only the users
                    return $eleve->plo_utilisateur()->get()[0];
                });

            $aptitudes = PloAptitude::all()->filter(
                function (PloAptitude $apt) use ($niveau) {
                    return $apt->plo_competence->FORM_NIVEAU == $niveau;
                }
            ); //TODO ne prendre que les aptitudes non validées par l'utilisateur

            //dd($eleves);
            return view('set-worked-skills', [
                "eleves" => $eleves,
                "seance" => $seance,
                "aptitudes" => $aptitudes
            ]);
        }

        return redirect()->route('createSession.show')->with('success', "Aucune séance avec cet ID trouvée");
    }

    public function store($id, Request $request){
        
        //apt is a table with the user's id as key and an array of selected skills as value
        $array = $request->input('apt');
        if(isset($array)){
            foreach($array as $userId => $skillsArray){
                foreach($skillsArray as $skill){
                    Evaluer::create([
                        "SEA_ID" => $id,
                        "UTI_ID" => $userId,
                        "APT_CODE" =>$skill,
                        "EVA_COMMENTAIRE" => NULL,
                        "EVA_RESULTAT" => NULL
                    ]);
                }
            }
        }
        //return to the session creation page
        return redirect()->route('createSession.show')->with('success', "La séance et les aptitudes travaillées ont été enregistrée");
    }
}
