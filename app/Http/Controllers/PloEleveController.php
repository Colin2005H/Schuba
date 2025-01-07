<?php

namespace App\Http\Controllers;

use App\Models\PloEleve;
use Illuminate\Http\Request;

class PloEleveController extends Controller
{
    function liste(){
        return response()->json(PloEleve::all());
    }
}
