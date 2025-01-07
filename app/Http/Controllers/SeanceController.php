<?php

namespace App\Http\Controllers;

use App\Models\Lieu;
use App\Models\Seance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeanceController extends Controller
{
    public function createSession(){
        return view('creer-seance', ['lieux' => Lieu::all()]);
    }

    public function store(Request $request){
        try{
            Seance::insert($request->input('dateD'), $request->input('dateF'), $request->input('lieu'), $request->input('niv'));
        }catch(Exception $e){
            return redirect()->route('createSession.show')->with('success', $e->getMessage());
        }
        return redirect()->route('createSession.show')->with('success', "La séance a été créée");
    }
}
