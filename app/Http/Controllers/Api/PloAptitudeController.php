<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloAptitude;
use Illuminate\Http\Request;

class PloAptitudeController extends Controller {
    function liste(){
        return response()->json(PloAptitude::all());
    }

    function detail($id){
        return response()->json(PloAptitude::find($id));
    }
}
