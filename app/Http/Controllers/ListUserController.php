<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//listUserController is a controller class that handles the display of the list of users
class listUserController extends Controller
{
    //showListUser function that displays the list of users
    public function showListUser(){
        $liste_eleve = DB::table('PLO_UTILISATEUR') //fetch all users
        ->where('UTI_SUPPRIME',0) //filter users that are not deleted
        ->get(); //get the result
        
        return view('listUser')->with(compact('liste_eleve')); //return the view with the list of users
    }
    //deleteUser function that deletes a user
    public function deleteUser(Request $request){
        $id = $request->input('action'); //get the id of the user to delete
        DB::table('PLO_UTILISATEUR')//delete the user
                ->where('UTI_ID', $id)
                ->update([
                    'UTI_SUPPRIME' => 1,//set the user as deleted
        ]);
        return redirect()->back()->with('success', "L'utilisateur a bien été supprimé");
    }
}
