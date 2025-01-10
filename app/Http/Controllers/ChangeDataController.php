<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

// Controller for the edit page to change the user's email address and password.
class ChangeDataController extends Controller
{
    //show the edit page with email form
    public function showEmail(){
        $user = session('user');
        $changeDataValue = "email";
        return view('change-data')->with(compact('user', 'changeDataValue'));
    }

    //show the edit page with password form
    public function showPassword(){
        $user = session('user');
        $changeDataValue = "password";
        return view('change-data')->with(compact('user', 'changeDataValue'));
    }

    //update the user's email value, with as parameter the request 
    public function editEmail(Request $request){
        $this->validate($request, [
            'uti_mail' => 'bail|required|unique:PLO_UTILISATEUR|email'
        ], [
            'uti_mail.email' => "Le texte doit correspondre à une adresse email valide",
            'uti_mail.unique' => "Cette adresse mail est déjà prise",
            'uti_mail.required' => "Le champ doit être rempli",
        ]);

        DB::table('PLO_UTILISATEUR')->where('UTI_ID', session('user')->UTI_ID)->update(['UTI_MAIL' => $request->input('uti_mail')]);

        session('user')->UTI_MAIL = $request->input('uti_mail');

        return redirect()->route('profile.show')->with('success', "L'adresse email a bien été modifié");
    }

    //update the user's password value, with as parameter the request, and redirect to the profile page
    //if failure, redirect to the edit password page withe an error message
    public function editPassword(Request $request){
        $this->validate($request, [
            'uti_mdp' => 'bail|required',
            'uti_old_mdp' => 'bail|required'
        ], [
            'uti_mdp.required' => "Le champ doit être rempli",
            'uti_old_mdp.required' => "Le champ doit être rempli"
        ]);

        //check if the current password correspond to the input of the user
        //if true, update the user's password
        if (Hash::check($request->input('uti_old_mdp'), session('user')->UTI_MDP)) {
            $passwd = Hash::make($request->input('uti_mdp'));
            DB::table('PLO_UTILISATEUR')->where('UTI_ID', session('user')->UTI_ID)->update(['UTI_MDP' => $passwd]);
            session('user')->UTI_MDP = $passwd;
            return redirect()->route('profile.show')->with('success', "Le mot de passe a bien été modifié");
        }
        else{
            return redirect()->route('changeData.showPassword')->with('failure', "Vous vous êtes trompé de mot de passe");
        }

    }
}
