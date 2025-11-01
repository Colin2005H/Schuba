<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

// Controller for the calendar page
class CalendarController extends Controller
{  
    /**
     * show
     * show the calendar page
     * @return void
     */
    public function show() {
        return view('calendar');
    }
   
    /**
     * tableSession
     * Show the calendar page with the session id 
     * @param  mixed $sessionId
     * @return void
     */
    public function tableSession($sessionId){
        $personTable = $this->getGroupByIdSession($sessionId);
        $innerHTML = "";  // HTML code to be inserted into the table
    
        foreach($personTable as $line) {
            $innerHTML .= "<tr>";
            $innerHTML .= "<td rowspan=\"2\" scope=\"row\" class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[0]) . "</td>";
            $innerHTML .= "<td class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[1][0]) . "</td>";
            $innerHTML .= "<td class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[2][0]) . "</td>";
            $innerHTML .= "</tr>";

            //if there are more than one student in the group display them in the table as
            if(count($line[1]) > 1) {
                $innerHTML .= "<tr>";
                $innerHTML .= "<td class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[1][1]) . "</td>";
                $innerHTML .= "<td class=\"px-4 py-2 border-b border-gray-200 text-center\">" . htmlspecialchars($line[2][1]) . "</td>";
                $innerHTML .= "</tr>";
            }
        }

        return $innerHTML;
    }
  
    /**
     * getGroupByIdSession
     * get the group by the session id 
     * @param  mixed $id
     * @return void
     */
    public static function getGroupByIdSession($id){
        $result = [];
        $listIDInitiator = [];
        $groups = DB::table(('GROUPER'))->select('uti_id_initiateur', 'uti_id')->where('sea_id', '=', $id)->get();

        // get the list of the initiators
        foreach($groups as $group){
            if(!(in_array($group->uti_id_initiateur, $listIDInitiator))){
                array_push($listIDInitiator, $group->uti_id_initiateur);
            }
        }
        // get the list of the students
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

            // get the name of the initiator
            $sqlInitiator = DB::table(('PLO_UTILISATEUR'))->select('uti_nom', 'uti_prenom')->where('uti_id', '=', $group[0])->get();
            $nameInitiator = $sqlInitiator[0]->uti_nom . " " . $sqlInitiator[0]->uti_prenom;

            $namesStudents = [];
            $skillsStudent = [];
            foreach($group[1] as $student){
                $nameStudent = DB::table(('PLO_UTILISATEUR'))->select('uti_nom', 'uti_prenom')->where('uti_id', '=', $student)->get();
                array_push($namesStudents, $nameStudent[0]->uti_nom . " " . $nameStudent[0]->uti_prenom);

                $sqlSkills = DB::table(('EVALUER'))->select('apt_code')->where('sea_id', '=', $id)->where('uti_id', '=', $student)->get();
                $textSkills = "";
                foreach($sqlSkills as $skill){
                    $textSkills .= $skill->apt_code .", ";
                }
                array_push($skillsStudent, $textSkills);
            }
            // add the initiator name,the students names and the skills
            array_push($tableLine, $nameInitiator, $namesStudents, $skillsStudent);
            array_push($valuesTable, $tableLine);
        }
        return $valuesTable;
    }

        
    /**
     * store
     * store the data in the database
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request){
        $userid = session('user')->UTI_ID;
        if(session('user')->getRole() == 'responsable') {
            return Redirect::route('bilan.modif',$request->identifier);
        }
        if(session('user')->getRole() == 'eleve') {
            return Redirect::route('aptitudes.show',$userid);
        }
        else {
            return Redirect::route('bilan.showForm',$request->identifier);
        }
        
        return Redirect::route('bilan.showForm',$request->identifier);
    }
}
