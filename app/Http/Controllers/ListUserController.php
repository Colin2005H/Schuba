<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class listUserController extends Controller
{
    public function showListUser(){
        $liste_eleve = DB::table('PLO_UTILISATEUR')
        ->where('UTI_SUPPRIME',0)
        ->get();
        
        return view('listUser')->with(compact('liste_eleve'));
    }

    public function deleteUser(Request $request){
        $id = $request->input('action');
        DB::table('PLO_UTILISATEUR')
                ->where('UTI_ID', $id)
                ->update([
                    'UTI_SUPPRIME' => 1,
        ]);
        return redirect()->back()->with('success', "L'utilisateur a bien été supprimé");
    }
}
