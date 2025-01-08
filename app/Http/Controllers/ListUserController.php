<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class listUserController extends Controller
{
    public function showListUser(){
        $liste_eleve = DB::table('PLO_UTILISATEUR')
        ->get();
        
        return view('listUser')->with(compact('liste_eleve'));
    }
}
