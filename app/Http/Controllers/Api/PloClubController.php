<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloClub;
use Illuminate\Http\Request;

class PloClubController extends Controller {
    function liste(){
        return response()->json(PloClub::all());
    }

    function detail($id){
        return response()->json(PloClub::find($id));
    }
}
