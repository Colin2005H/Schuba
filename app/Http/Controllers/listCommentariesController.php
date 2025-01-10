<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class listCommentariesController extends Controller
{   
    /**
     * showListCommentaries
     *show the list of commentaries
     * @return void
     */
    public function showListCommentaries(){
        $liste_eleve = DB::table('EVALUER')
        ->join('PLO_UTILISATEUR', 'EVALUER.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->select('UTI_NOM','UTI_PRENOM', 'EVA_COMMENTAIRE')
        ->get();
        
        return view('listCommentaries')->with(compact('liste_eleve'));
    }
}
