<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateAccountController extends Controller
{
    public function createAccount() {
        return view('createAccount');
    }

    public function store(Request $request){
        $user = Utilisateur::create([
            'uti_id' => 4,
            'uti_nom' => $request->input('uti_nom'),
            'uti_prenom' => $request->input('uti_prenom'),
            'uti_mail' => $request->input('uti_mail'),
            'uti_mdp' => 'Test',
            'uti_niveau' => $request->input('uti_niveau'),
            'uti_date_naissance' => $request->input('uti_date_naissance'),
            'uti_date_creation' => today()
        ]);
        return redirect()->route('createAccount.show')->with('success', "L'utilisateur a bien été ajouté");
    }
}
