<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
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
            'uti_mail' => 'required|email',
            'uti_nom' => 'required',
            'uti_prenom' => 'required',
            'uti_niveau' => 'required',
            'uti_date_naissance' => 'required',
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
        return redirect()->route('createAccount.show')->with('success', "L'utilisateur a bien été ajouté : ".$request->input("clu_id"));
    }
}
