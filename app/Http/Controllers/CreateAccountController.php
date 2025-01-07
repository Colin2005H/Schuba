<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Initiateur;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateAccountController extends Controller
{

    public function createAccount() {
        $clubs = DB::table('plo_club')->select('clu_id', 'clu_nom')->get();
        return view('createAccount')->with(compact('clubs'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'uti_mail' => 'bail|required|unique:plo_utilisateur|email',
            'uti_nom' => 'bail|required',
            'uti_prenom' => 'bail|required',
            'uti_niveau' => 'bail|required',
            'uti_date_naissance' => 'bail|required',
        ], [
            'uti_mail.email' => "Le texte doit correspondre à une adresse email valide",
            'uti_mail.unique' => "Cette adresse mail est déjà prise",
            'uti_mail.required' => "Le champ doit être rempli",
            'uti_nom.required' => "Le champ doit être rempli",
            'uti_prenom.required' => "Le champ doit être rempli",
            'uti_niveau.required' => "Le champ doit être rempli",
            'uti_date_naissance.required' => "Le champ doit être rempli"
        ]);

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $passwd = substr(str_shuffle($chars),0, 8);

        $user = Utilisateur::create([
            'clu_id' => $request->input("clu_id"),
            'uti_nom' => $request->input('uti_nom'),
            'uti_prenom' => $request->input('uti_prenom'),
            'uti_mail' => $request->input('uti_mail'),
            'uti_mdp' => $passwd,
            'uti_niveau' => $request->input('uti_niveau'),
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
