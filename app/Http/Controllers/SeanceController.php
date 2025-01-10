<?php

namespace App\Http\Controllers;

use App\Models\Aptitude;
use App\Models\Groupe;
use App\Models\Initiator;
use App\Models\Lieu;
use App\Models\PloEleve;
use App\Models\PloInitiateur;
use App\Models\Seance;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SeanceController extends Controller
{
    
    public function createSession()
    {
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

        //dd($niveau);

        return view('creer-seance', [
            'lieux' => Lieu::all(),

            'aptitudes' => Aptitude::all(),

            'initiateurs' => PloInitiateur::all()->filter(function (PloInitiateur $initiator) use ($niveau){
                return $initiator->isInFormation($niveau); //only those in the right formation

            })->map(function (PloInitiateur $initiator) { //fetch all the initiators
                return $initiator->plo_utilisateur()->getResults();

            })->filter(function ($user, $key) {
                return $user != null;

            }), //TODO filtrer seulement ceux de la formation concernée ($niveau)


            'eleves' => PloEleve::all()->filter(function (PloEleve $student) use ($niveau){
                return $student->getCurrentFormation() == $niveau; 

            })->map(function (PloEleve $student) { //cast the students into users
                return $student->plo_utilisateur()->getResults();

            })->filter(function ($user, $key) {
                return $user != null; //security check

            }),

            
            'niveau' => $niveau
        ]);
    }

    //store the session in the database
    public function store(Request $request)
    {
        $sessionId = NULL;

        try {
            $startTime = $request->input('date') . "T" . $request->input('beginHour') . ":" . $request->input('beginMin');
            $endTime = $request->input('date') . "T" . $request->input('endHour') . ":" . $request->input('endMin');

            $sessionId = Seance::insert($startTime, $endTime, $request->input('lieu'), $request->input('niv'));

            foreach ($request->input('group') as $group) {
                $this->createGroup($group, $sessionId);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('createSession.show')->with('success', $e->getMessage());
        }

        if(isset($sessionId)){
            return Redirect::route('setWorkedSkills', $sessionId)->with('success', "La séance a été créée");
        }
        return redirect()->route("createSession.show")->with('success', "Un problème inattendu est survenu (sessionId NULL)");
    }

    //create a group of user for the session
    public function createGroup($group, $sessionId)
    {
        echo "<script>console.log(\"création de groupe\");</script>";
        print_r($group);
        Groupe::create([
            "SEA_ID" => $sessionId,
            "UTI_ID_INITIATEUR" => $group["initiateur"],
            "UTI_ID" => $group["eleve1"],
            "GRP_PRESENCE" => NULL
        ]);


        if ($group["eleve2"] !== "null") {
            Groupe::create([
                "SEA_ID" => $sessionId,
                "UTI_ID_INITIATEUR" => $group["initiateur"],
                "UTI_ID" => $group["eleve2"],
                "GRP_PRESENCE" => NULL
            ]);
        }
    }
}
