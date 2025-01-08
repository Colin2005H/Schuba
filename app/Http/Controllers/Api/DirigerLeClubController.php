<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DirigerLeClub;
use Illuminate\Http\Request;

use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class DirigerLeClubController extends Controller {
    
    /**
     * dirigeants
     *
     * Liste les dirigeants de club
     */
    #[OpenApi\Operation]
    function liste(){
        return response()->json(DirigerLeClub::all());
    }

    /**
     * dirigeants
     *
     * Liste les dirigeants de club
     * 
     * @param Int $id identifiant du dirigeant
     */
    #[OpenApi\Operation]
    function detail($id){
        return response()->json(DirigerLeClub::find($id));
    }
}
