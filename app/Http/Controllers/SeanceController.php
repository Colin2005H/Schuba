<?php

namespace App\Http\Controllers;

use App\Models\Lieu;
use App\Models\PloSeance;
use App\Models\Seance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeanceController extends Controller
{
    public function index(){
        $this->insert('10:00 07/01/2025', '10:01 07/01/2025', 1, 1);

        return view('creer-seance', ['lieux' => Lieu::all()]);
    }

}
