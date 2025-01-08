<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public static function getGroupByIdSession($id){
        $result = [];
        $listIDInitiator = [];
        $groups = DB::table(('grouper'))->select('uti_id_initiateur', 'uti_id')->where('sea_id', '=', $id)->get();

        foreach($groups as $group){
            if(!(in_array($group->uti_id_initiateur, $listIDInitiator))){
                array_push($listIDInitiator, $group->uti_id_initiateur);
            }
        }
        
        foreach($listIDInitiator as $idInit){
            $team = [];
            $students = [];
            foreach($groups as $group){
                if($idInit == $group->uti_id_initiateur && !(in_array($group->uti_id, $students))){
                    array_push($students, $group->uti_id);
                }
            }
            array_push($team, $idInit, $students);
            array_push($result, $team);
        }

        $names = [];
        foreach($result as $group){
            $tableLine = [];

            $sqlInitiator = DB::table(('plo_utilisateur'))->select('uti_nom', 'uti_prenom')->where('uti_id', '=', $group[0])->get();
            $nameInitiator = $sqlInitiator[0]->uti_nom . " " . $sqlInitiator[0]->uti_prenom;

            $namesStudents = "";
            foreach($group[1] as $student){
                $nameStudent = DB::table(('plo_utilisateur'))->select('uti_nom', 'uti_prenom')->where('uti_id', '=', $student)->get();
                $namesStudents .= $nameStudent[0]->uti_nom . " " . $nameStudent[0]->uti_prenom . "; ";
            }

            array_push($tableLine, $nameInitiator, $namesStudents);
            array_push($names, $tableLine);
        }
        return $names;
    }
}
