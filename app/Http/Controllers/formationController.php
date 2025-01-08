<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormationController extends Controller
{
    public function showFormation(){
        /*
        $optionsManager = DB::table('GERER_LA_FORMATION')
            ->join('PLO_INITIATEUR', 'PLO_INITIATEUR.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
            ->join('PLO_UTILISATEUR', 'PLO_INITIATEUR.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
            ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
            ->get();
        */

        $optionsManager = DB::table('PLO_UTILISATEUR')
        ->whereNotIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('GERER_LA_FORMATION');
        })
        ->whereNotIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('DIRIGER_LE_CLUB');
        })
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_INITIATEUR');
        })
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        $optionsInitiateur =  DB::table('PLO_UTILISATEUR')
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_INITIATEUR');
        })
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        $optionsStudent =  DB::table('PLO_UTILISATEUR')
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_ELEVE');
        })
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        return view('manageFormation', compact('optionsManager','optionsInitiateur','optionsStudent'));
    }

    public function createFormation(Request $request){

        // verify and validate data
        $validated = $request->validate([
            'category' => 'required',
            'manager' => 'required',
            'initiator' => 'required',
            'student' => 'required',
        ]);

        echo $validated['initiator'];

    /*    // inserting Formation
        DB::table('PLO_FORMATION')->insert([
            'FORM_NIVEAU' => $validated['category'],
            'FORM_LIBELLE' => 'Niveau'.$validated['category'],
            'FORM_DESCRIPTION' => 'Formation du niveau '.$validated['category'].' dont le responsable est '.$validated['manager'].'.',
            'FORM_PROF_MAX' => 0,
        ]);

        // inserting Manager
        /*$idManager = DB::table('PLO_UTILISATEUR')
            ->whereRaw("CONCAT(UTI_NOM, ' ', UTI_PRENOM) LIKE ?", ["%{$validated['manager']}%"])
            ->pluck('UTI_ID');
        DB::table('GERER_LA_FORMATION')->insert([
            'UTI_ID' => $validated['manager'] ,
            'FORM_NIVEAU' => $validated['category'],
            'GER_DATE_DEBUT' => now(),
        ]);

        // inserting Initiators
        foreach ($validated['initiator'] as $idInitiator) {
            /*$idInitiator = DB::table('PLO_UTILISATEUR')
                ->whereRaw("CONCAT(UTI_NOM, ' ', UTI_PRENOM) LIKE ?", ["%{$IdInitiator}%"])
                ->pluck('UTI_ID');

            DB::table('ENSEIGNER')->insert([
                'UTI_ID' => $idInitiator ,
                'FORM_NIVEAU' => $validated['category'],
            ]);
        }

        // inserting Students
        foreach ($validated['student'] as $idStudent) {
            /*$idStudent = DB::table('PLO_UTILISATEUR')
            ->whereRaw("CONCAT(UTI_NOM, ' ', UTI_PRENOM) LIKE ?", ["%{$nameStudent}%"])
            ->pluck('UTI_ID');

            DB::table('APPARTIENT')->insert([
                'UTI_ID' => $idStudent ,
                'FORM_NIVEAU' => $validated['category'],
                'DATE_INSCRIPTION' => now(),
            ]);
        }*/

        return redirect()->back()->with('success', 'Formation créée avec succès !');

    }

}
