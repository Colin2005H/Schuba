<?php

namespace App\Http\Controllers\Api;

use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\Models\PloFormation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PloFormationController extends Controller {
    function liste(){
        return response()->json(PloFormation::all());
    }

    function detail($id){
        return response()->json(PloFormation::find($id));
    }
}
