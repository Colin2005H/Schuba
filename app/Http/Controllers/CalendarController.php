<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function show() {
        $roleController = new RoleController();
        $role = $roleController->getRole(session('user'));
        return view('calendar')->with(compact($role));
    }

    public function tableSession(){
        
    }

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

        $valuesTable = [];
        foreach($result as $group){
            $tableLine = [];

            $sqlInitiator = DB::table(('plo_utilisateur'))->select('uti_nom', 'uti_prenom')->where('uti_id', '=', $group[0])->get();
            $nameInitiator = $sqlInitiator[0]->uti_nom . " " . $sqlInitiator[0]->uti_prenom;

            $namesStudents = [];
            $skillsStudent = [];
            foreach($group[1] as $student){
                $nameStudent = DB::table(('plo_utilisateur'))->select('uti_nom', 'uti_prenom')->where('uti_id', '=', $student)->get();
                array_push($namesStudents, $nameStudent[0]->uti_nom . " " . $nameStudent[0]->uti_prenom);

                $sqlSkills = DB::table(('evaluer'))->select('apt_code')->where('sea_id', '=', $id)->where('uti_id', '=', $student)->get();
                $textSkills = "";
                foreach($sqlSkills as $skill){
                    $textSkills .= $skill->apt_code .", ";
                }
                array_push($skillsStudent, $textSkills);
            }

            array_push($tableLine, $nameInitiator, $namesStudents, $skillsStudent);
            array_push($valuesTable, $tableLine);
        }
        return $valuesTable;
    }
}
