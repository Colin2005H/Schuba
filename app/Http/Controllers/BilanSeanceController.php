<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Aptitude;
use App\Models\Seance;

class BilanSeanceController extends Controller
{
        public function showForm(/*Seance $seance*/)
    {
        $seance = Seance::all();
        $seance = $seance->first();
        $eleves = $seance->getEleves();
        return view('recapitulatif', ['eleves' => $eleves,'seance' => $seance]);
    }

    public function showFormTest(/*Seance $seance*/)
        {
            $seance = Seance::all();
            $seance = $seance->first();
            $eleves = Eleve::all();
            return view('recapitulatif', ['eleves' => $eleves,'seance' => $seance]);
        }
}