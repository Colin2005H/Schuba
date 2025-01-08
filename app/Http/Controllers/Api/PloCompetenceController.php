<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloCompetence;
use Illuminate\Http\Request;

class PloCompetenceController extends Controller {
    function liste(){
        return response()->json(PloCompetence::all());
    }

    function detail($id){
        return response()->json(PloCompetence::find($id));
    }
}
