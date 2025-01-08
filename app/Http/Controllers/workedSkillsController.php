<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use Illuminate\Http\Request;

class workedSkillsController extends Controller
{
    public function index(){
        return view('set-worked-skills', ["eleves" => Eleve::all()]);
    }
}
