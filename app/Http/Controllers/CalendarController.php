<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CalendarController extends Controller
{
    public function show() {
        return view('calendar');
    }

    public function tableSession($sessionId){
        $personTable = $this->getGroupByIdSession($sessionId);
        $innerHTML = "";  // Variable pour stocker le HTML généré
    
        foreach($personTable as $line) {
            $innerHTML .= "<tr>";
            $innerHTML .= "<td rowspan=\"2\" scope=\"row\" class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[0]) . "</td>";
            $innerHTML .= "<td class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[1][0]) . "</td>";
            $innerHTML .= "<td class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[2][0]) . "</td>";
            $innerHTML .= "</tr>";

            // Vérifiez si le second élément existe et ajoutez une deuxième ligne
            if(count($line[1]) > 1) {
                $innerHTML .= "<tr>";
                $innerHTML .= "<td class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[1][1]) . "</td>";
                $innerHTML .= "<td class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[2][1]) . "</td>";
                $innerHTML .= "</tr>";
            }
        }

        return $innerHTML;
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

    public function store(Request $request){
        if(session('user')->getRole() == 'responsable') {
            return Redirect::route('bilan.modif',$request->identifier);
        }
        else {
            return Redirect::route('bilan.showForm',$request->identifier);
        }
        
    }
}
