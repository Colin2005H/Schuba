<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DirigerLeClub;
use Illuminate\Http\Request;


class DirigerLeClubController extends Controller {
    
    /**
     * dirigeants
     *
     * Liste les dirigeants de club
     */
    function liste(){
        return response()->json(DirigerLeClub::all());
    }
}
