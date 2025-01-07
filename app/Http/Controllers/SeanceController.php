<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeanceController extends Controller
{
    public function index(){
        echo "ça marche tkt";
        return view('creer-seance');
    } 
}
