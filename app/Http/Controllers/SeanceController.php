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

class SeanceController extends Controller
{
    /**
     * fonction appelée par le Routeur
     *
     * @return void
     */
    public function createSession(){
        return view('creer-seance', [
            'lieux' => Lieu::all(),

            'aptitudes'=>Aptitude::all(),

            'initiateurs'=>Initiator::all()->map(function(Initiator $initiator){
                    return $initiator->user()->getResults();
                })->filter(function ($user, $key) {
                    return $user != null;
                }), 

            'eleves'=>Eleve::all()->map(function(Eleve $student){
                    return $student->user()->getResults();
                })->filter(function ($user, $key) {
                    return $user != null;
                })
        ]);
    }

    /**
     * stock une nouvelle séance dans la BDD
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request){
        
        
        try{
            $startTime = $request->input('date')."T".$request->input('beginHour').":".$request->input('beginMin');
            $endTime = $request->input('date')."T".$request->input('endHour').":".$request->input('endMin');

            $sessionId = Seance::insert($startTime, $endTime, $request->input('lieu'), $request->input('niv'));
            
            $group = Groupe::create([
                "SEA_ID" => $sessionId,
                "UTI_ID_INITIATEUR" => $request->input('initiateur'),
                "UTI_ID"=>$request->input('eleve1'),
                "GRP_PRESENCE"=>NULL
            ]);


            if($request->input('eleve2') !=="null"){
                $group = Groupe::create([
                    "SEA_ID" => $sessionId,
                    "UTI_ID_INITIATEUR" => $request->input('initiateur'),
                    "UTI_ID"=>$request->input('eleve2'),
                    "GRP_PRESENCE"=> NULL
                ]);
            }

        }catch(Exception $e){
            return redirect()->route('createSession.show')->with('success', $e->getMessage());
        }
        
        $request->input('aptitude');

        return redirect()->route('createSession.show')->with('success', "La séance a été créée");
    }
}
