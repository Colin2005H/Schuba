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
        //permets de récupérer le niveau du responsable de formation
        DB::beginTransaction();

        $niveau = NULL;

        try {
            //TODO peut-être déplacer ça dans le model
            $niveau = DB::table('gerer_la_formation')->select('FORM_NIVEAU')->where('UTI_ID', session('user')->UTI_ID)->get()->firstOrFail();
            $niveau = $niveau->FORM_NIVEAU;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        DB::commit();
        // fin du code dupliqué
        $seance = PloSeance::find($id);

        if ($seance != NULL && $niveau!= NULL) {

            //Ne prends que les eleves de la séance
            $eleves = PloEleve::all()->filter(function (PloEleve $eleve) use ($seance) {
                //début du filtre

                $groupes = $eleve->groupers->filter(function (Grouper $groupe) use ($seance) {
                    return $groupe->SEA_ID == $seance->SEA_ID; //renvoie les groupes dans lequel est l'élève et qui sont dans la séance
                });

                //si aucun groupe restant alors l'élève n'est pas dans la séance
                return $groupes->isNotEmpty();
            }) //fin du filtre
                ->map(function (PloEleve $eleve) {

                    //on ne prends que les utilisateurs
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
        
        // apt est un tableau avec en clé l'id de lut'ilisateur et en valeur un tableau des compétences selectionnées
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
        
        return redirect()->route('createSession.show')->with('success', "La séance et les aptitudes travaillées ont été enregistrée");
    }
}
