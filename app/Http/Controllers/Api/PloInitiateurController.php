<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloInitiateur;
use Illuminate\Http\Request;

class PloInitiateurController extends Controller {
    function liste(){
        return response()->json(PloInitiateur::all());
    }

    function detail($id){
        return response()->json(PloInitiateur::find($id));
    }
}
