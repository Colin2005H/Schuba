<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloSeance;
use Illuminate\Http\Request;

class PloSeanceController extends Controller {
    function liste(){
        return response()->json(PloSeance::all());
    }

    function detail($id){
        return response()->json(PloSeance::find($id));
    }
}
