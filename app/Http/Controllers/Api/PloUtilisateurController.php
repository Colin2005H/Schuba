<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PloUtilisateur;
use App\Http\Controllers\Controller;

class PloUtilisateurController extends Controller {
    function liste(){
        return response()->json(PloUtilisateur::all());
    }

    function detail($id){
        return response()->json(PloUtilisateur::find($id));
    }
}
