<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//listUserController is a controller class that handles the display of the list of aptitudes
class ManageAptitudesController extends Controller
{
    //showListAptitudes function that displays the list of aptitudes
    public function showListAptitudes(){
        $aptitudesList = DB::table('PLO_APTITUDE') //fetch all aptitudes
        ->get(); //get the result
        return view('manageAptitudes')->with(compact('aptitudesList')); //return the view with the list of aptitudes
    }
    //modifyAptitudes function that modifies an aptitude
    public function modifyAptitudes(Request $request){
        $id = $request->aptitudeId; //get the id of the aptitudes to modify
        $newDescription = $request->description;
        DB::table('PLO_APTITUDE')//modify the aptitude
                ->where('APT_CODE', $id)
                ->update([
                    'APT_LIBELLE' => $newDescription,//set the aptitude with the new description
        ]);
        return redirect()->back()->with('success', "L'aptitude a bien été modifiée.");
    }
}