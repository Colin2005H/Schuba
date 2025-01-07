<?php

namespace App\Http\Controllers\Api;

use App\Models\PloLieu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PloLieuController extends Controller {
    function liste(){
        return response()->json(PloLieu::all());
    }

    function detail($id){
        return response()->json(PloLieu::find($id));
    }
}
