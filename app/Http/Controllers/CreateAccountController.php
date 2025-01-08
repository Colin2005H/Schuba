<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Initiateur;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAccountController extends Controller
{

    public function createAccount() {
        $clubs = DB::table('plo_club')->select('clu_id', 'clu_nom')->get();
        return view('create-account')->with(compact('clubs'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'uti_mail' => 'bail|required|unique:plo_utilisateur|email',
            'uti_nom' => 'bail|required',
            'uti_prenom' => 'bail|required',
            'uti_code_postal' => 'bail|required|numeric|integer|min:10000|max:99999',
            'uti_adresse' => 'bail|required',
            'uti_ville' => 'bail|required',
            'uti_niveau' => 'bail|required',
            'uti_date_naissance' => 'bail|required',
            'uti_date_certificat' => 'bail|required'
        ], [
            'uti_mail.email' => "Le texte doit correspondre à une adresse email valide",
            'uti_mail.unique' => "Cette adresse mail est déjà prise",
            'uti_mail.required' => "Le champ doit être rempli",

            'uti_nom.required' => "Le champ doit être rempli",
            'uti_prenom.required' => "Le champ doit être rempli",

            'uti_code_postal.required' => "Le champ doit être rempli",
            'uti_code_postal.numeric' => "Le champ doit être un nombre",
            'uti_code_postal.integer' => "Le champ doit être un nombre entier",
            'uti_code_postal.min' => "Le code postal doit contenir 5 chiffres minimun",
            'uti_code_postal.max' => "Le code postal doit contenir 5 chiffres maximun",

            'uti_adresse.required' => "Le champ doit être rempli",
            'uti_ville.required' => "Le champ doit être rempli",
            'uti_niveau.required' => "Le champ doit être rempli",
            'uti_date_certificat.required' => "Le champ doit être rempli",
            'uti_date_naissance.required' => "Le champ doit être rempli"
        ]);

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $passwd = substr(str_shuffle($chars),0, 8);

        $user = Utilisateur::create([
            'clu_id' => $request->input("clu_id"),
            'uti_nom' => $request->input('uti_nom'),
            'uti_prenom' => $request->input('uti_prenom'),
            'uti_mail' => $request->input('uti_mail'),
            'uti_code_postal' => $request->input('uti_code_postal'),
            'uti_adresse' => $request->input('uti_adresse'),
            'uti_ville' => $request->input('uti_ville'),
            'uti_mdp' => $passwd,
            'uti_niveau' => $request->input('uti_niveau'),
            'uti_date_certificat' => $request->input('uti_date_certificat'),
            'uti_date_naissance' => $request->input('uti_date_naissance'),
            'uti_date_creation' => today()
        ]);

        switch($request->input('userType')){
            case 'eleve':
                $sql = DB::table('plo_utilisateur')->select('uti_id')->where('uti_mail','=',$request->input('uti_mail'))->get();
                $eleve = Eleve::create([
                    'uti_id' => $sql[0]->uti_id
                ]);
                break;
            case 'initiateur':
                $sql = DB::table('plo_utilisateur')->select('uti_id')->where('uti_mail','=',$request->input('uti_mail'))->get();
                $initiateur = Initiateur::create([
                    'uti_id' => $sql[0]->uti_id
                ]);
                break;
        }

        return redirect()->route('createAccount.show')->with('success', "L'utilisateur a bien été ajouté");
    }
}
