<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class ChangeDataController extends Controller
{
    public function show(){
        $info_compte = DB::table('PLO_UTILISATEUR')->where('UTI_Id',session('user')->UTI_ID)->get();
        return view('change-data', compact('info_compte'));
    }

    public function edit(Request $request){
        $this->validate($request, [
            'uti_new_mail' => 'bail|required|unique:plo_utilisateur|email',
            'uti_mdp' => 'bail|required',
            'uti_new_mdp' => 'bail|required'
        ], [
            'uti_mail.email' => "Le texte doit correspondre à une adresse email valide",
            'uti_mail.unique' => "Cette adresse mail est déjà prise",
            'uti_mail.required' => "Le champ doit être rempli",
            'uti_mdp.required' => "Le champ doit être rempli",
            'uti_new_mdp.required' => "Le champ doit être rempli"
        ]);

        if ($request->input('action') == 'editEmail' ){

            $user = Utilisateur::find(session('user')->UTI_ID);
            $user->UTI_MAIL = $request->input('uti_new_mail');
            $user->save();

            return redirect()->route('profile.show');
        }
        if ($request->input('action') == 'editPassword' ){

            if (Hash::check(session('user')->UTI_MDP, $request->input('uti_mdp'))) {
                $user = Utilisateur::find(session('user')->UTI_ID);
    
                $user->UTI_MDP = $request->input('uti_new_mdp');
                $user->save();
            }

            return redirect()->route('profile.show');
        }
    }
}
