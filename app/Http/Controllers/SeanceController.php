<?php

namespace App\Http\Controllers;

use App\Models\Aptitude;
use App\Models\Groupe;
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
    public function createSession(){
        return view('creer-seance', [
            'lieux' => Lieu::all(),
            'aptitudes'=>Aptitude::all(),
            'initiateurs'=>User::all(),
            'eleves'=>User::all()
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
            $sessionId = Seance::insert($request->input('dateD'), $request->input('dateF'), $request->input('lieu'), $request->input('niv'));
            
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
