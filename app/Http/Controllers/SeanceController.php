<?php

namespace App\Http\Controllers;

use App\Models\PloSeance;
use App\Models\Seance;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    public function index(){
        echo "ça marche tkt";
        return view('creer-seance', ['seance' => PloSeance::all()]);
    } 
}
