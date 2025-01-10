<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// ModifierCompteController is a controller class that handles the modification of a user account
class ModifierCompteController extends Controller
{
    // function that displays the modification form
    public function edit($id)
    {
        $info_compte = DB::table('PLO_UTILISATEUR')//fetch the user information
        ->where('UTI_Id',$id)//filter the user by id
        ->get();
        $club = DB::table('PLO_CLUB')->where('CLU_ID', '=', $info_compte[0]->CLU_ID)->get();
        /*
        $director = DB::table('diriger_le_club')->select('clu_id')->where('uti_id', '=', session('user')->UTI_ID)->get();
        $clubDirector = DB::table('plo_club')->select('clu_id', 'clu_nom')->where('clu_id', '=', $director[0]->clu_id)->get();*/
        return view('modifierCompte', compact('info_compte','club')); //return the view with the user information and the club 
    }
    // function that updates the user information
    public function update(Request $request, $id){

        if ($request->input('action') == 'Annuler'){   //if the user clicks on the cancel button
            return redirect()->route('listUser'); //redirect to the list of users
        }
        else{

            $info_compte = DB::table('PLO_UTILISATEUR') 
            ->where('UTI_Id',$id)
            ->get();

            $club = DB::table('PLO_CLUB')->where('CLU_ID', '=', $info_compte[0]->CLU_ID)->get(); //fetch the club information of the user

            if($request->input('uti_mail') != $info_compte[0]->UTI_MAIL){ //if the user changes his email
                $this->validate($request, [ 
                    'uti_mail' => 'bail|required|unique:PLO_UTILISATEUR|email',
                ], [
                    'uti_mail.email' => "Le texte doit correspondre à une adresse email valide",
                    'uti_mail.unique' => "Cette adresse mail est déjà prise",
                    'uti_mail.required' => "Le champ doit être rempli",
                ]);
            }
            $this->validate($request, [ //validate the user information
                'uti_mail' => 'bail|required|email',
                'uti_nom' => 'bail|required',
                'uti_prenom' => 'bail|required',
                'uti_code_postal' => 'bail|required|numeric|integer|min:10000|max:99999',
                'uti_adresse' => 'bail|required',
                'uti_ville' => 'bail|required',
                'uti_niveau' => 'bail|required',
                'uti_date_naissance' => 'bail|required',
                'uti_date_certificat' => 'bail|required'
            ], [  //error messages
                'uti_mail.email' => "Le texte doit correspondre à une adresse email valide",
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

            DB::table('PLO_UTILISATEUR') //update the user information
                ->where('UTI_ID', $id)
                ->update([ 
                    'CLU_ID' => $club[0]->CLU_ID,
                    'UTI_NOM' => $request->input('uti_nom'),
                    'UTI_PRENOM' => $request->input('uti_prenom'),
                    'UTI_MAIL' => $request->input('uti_mail'),
                    'UTI_CODE_POSTAL' => $request->input('uti_code_postal'),
                    'UTI_ADRESSE' => $request->input('uti_adresse'),
                    'UTI_VILLE' => $request->input('uti_ville'),
                    'UTI_NIVEAU' => $request->input('uti_niveau'),
                    'UTI_DATE_CERTIFICAT' => $request->input('uti_date_certificat'),
                    'UTI_DATE_NAISSANCE' => $request->input('uti_date_naissance'), 
            ]);

            switch($request->input('userType')){ //update the user type
                case 'eleve':
                    $sql = DB::table('PLO_INITIATEUR')->where('UTI_ID',$id)->count();
                    if($sql==1){
                        DB::table('PLO_ENSEIGNER')->where('UTI_ID',$id)->delete();
                        DB::table('PLO_INITIATEUR')->where('UTI_ID',$id)->delete();
                        DB::table('PLO_ELEVE')->insert([
                            'UTI_ID'=>$id,
                        ]);
                    }
                
                    break;
                case 'initiateur':
                    $sql = DB::table('PLO_ELEVE')->where('UTI_ID',$id)->count();
                    if($sql==1){
                        DB::table('APPARTIENT')->where('UTI_ID',$id)->delete();
                        DB::table('PLO_ELEVE')->where('UTI_ID',$id)->delete();
                        DB::table('PLO_INITIATEUR')->insert([
                            'UTI_ID'=>$id,
                        ]);
                    }
                    
                    break;
            }

            return redirect()->route('listUser')->with('success', "L'utilisateur a bien été modifié"); //redirect to the list of users with a success message 

        }
    }
        
        
}
