<?php

namespace App\Http\Controllers;

use App\Models\Aptitude;
use App\Models\Eleve;
use App\Models\Groupe;
use App\Models\Initiator;
use App\Models\Lieu;
use App\Models\Seance;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeanceController extends Controller
{
    /**
     * fonction appelée par le Routeur
     *
     * @return void
     */
    public function createSession()
    {
        DB::beginTransaction();

        $niveau = NULL;

        try {
            $niveau = DB::table('gerer_la_formation')->select('FORM_NIVEAU')->where('UTI_ID', session('user')->UTI_ID)->get()->firstOrFail();
            
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        DB::commit();

        return view('creer-seance', [
            'lieux' => Lieu::all(),

            'aptitudes' => Aptitude::all(),

            'initiateurs' => Initiator::all()->map(function (Initiator $initiator) { //prends tous les Initiator
                return $initiator->user()->getResults();
            })->filter(function ($user, $key) {
                return $user != null;
            }), //TODO filtrer seulement ceux de la formation concernée ($niveau)

            'eleves' => Eleve::all()->map(function (Eleve $student) { //prends tous les eleves
                return $student->user()->getResults();
            })->filter(function ($user, $key) {
                return $user != null;
            }), //TODO filtrer seulement ceux de la formation concernée ($niveau)
            
            'niveau' => $niveau->FORM_NIVEAU

            
        ]);
    }

    /**
     * stock une nouvelle séance dans la BDD
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {


        try {
            $startTime = $request->input('date') . "T" . $request->input('beginHour') . ":" . $request->input('beginMin');
            $endTime = $request->input('date') . "T" . $request->input('endHour') . ":" . $request->input('endMin');

            $sessionId = Seance::insert($startTime, $endTime, $request->input('lieu'), $request->input('niv'));

            foreach ($request->input('group') as $group) {
                $this->createGroup($group, $sessionId);
            }

            
        } catch (Exception $e) {
            return redirect()->route('createSession.show')->with('success', $e->getMessage());
        }

        $request->input('aptitude');

        return redirect()->route('createSession.show')->with('success', "La séance a été créée");
    }

    /**
     * Créé un groupe avec le tableau en parametre
     *
     * @param array<string, string> $group tableau avec des clés "initiateur", "eleve1" et "eleve2"
     * @param int $sessionId id de la session dont le groupe fait parti
     * @return void
     */
    public function createGroup($group, $sessionId)
    {
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
