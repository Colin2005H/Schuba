<?php

namespace App\Http\Controllers\Api;

use App\Models\PloEleve;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PloEleveController extends Controller
{
    function liste(){
        return response()->json(PloEleve::all());
    }
}
