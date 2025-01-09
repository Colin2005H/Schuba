<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberListController extends Controller
{
    function showList(){

        $idManager = session('user')->UTI_ID;

        $nivForm = DB::table('PLO_UTILISATEUR')
        ->join('PLO_INITIATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
        ->join('GERER_LA_FORMATION', 'PLO_INITIATEUR.UTI_ID', '=', 'GERER_LA_FORMATION.UTI_ID')
        ->where('GERER_LA_FORMATION.UTI_ID',$idManager)
        ->select('GERER_LA_FORMATION.FORM_NIVEAU')
        ->get();

        $studentList = DB::table('PLO_UTILISATEUR')
        ->join('PLO_ELEVE', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_ELEVE.UTI_ID')
        ->join('APPARTIENT', 'PLO_ELEVE.UTI_ID', '=', 'APPARTIENT.UTI_ID')
        ->where('UTI_SUPPRIME',0)
        ->where('APPARTIENT.FORM_NIVEAU',$nivForm)
        ->get();

        $initiatorList = DB::table('PLO_UTILISATEUR')
        ->join('PLO_INITIATEUR', 'PLO_UTILISATEUR.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
        ->join('ENSEIGNER', 'PLO_INITIATEUR.UTI_ID', '=', 'ENSEIGNER.UTI_ID')
        ->where('UTI_SUPPRIME',0)
        ->where('ENSEIGNER.FORM_NIVEAU',$nivForm)
        ->get();

        return view('memberList',compact('studentList','initiatorList'));
    }
}
