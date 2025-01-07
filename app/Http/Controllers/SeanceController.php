<?php

namespace App\Http\Controllers;

use App\Models\Lieu;
use App\Models\Seance;
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
        return view('creer-seance', ['lieux' => Lieu::all()]);
    }

    /**
     * stock une nouvelle séance dans la BDD
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request){
        try{
            Seance::insert($request->input('dateD'), $request->input('dateF'), $request->input('lieu'), $request->input('niv'));
        }catch(Exception $e){
            return redirect()->route('createSession.show')->with('success', $e->getMessage());
        }
        return redirect()->route('createSession.show')->with('success', "La séance a été créée");
    }
}
