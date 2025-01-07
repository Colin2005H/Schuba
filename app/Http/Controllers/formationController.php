<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormationController extends Controller
{
    public function showFormation(){

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
            'initiator' => 'required|array',
            'student' => 'required|array',
        ]);


        // inserting Manager
        DB::table('GERER_LA_FORMATION')->insert([
            'UTI_ID' => $validated['manager'] ,
            'FORM_NIVEAU' => $validated['category'],
            'GER_DATE_DEBUT' => now(),
        ]);

        // inserting Initiators
        foreach ($validated['initiator'] as $idInitiator) {

            DB::table('ENSEIGNER')->insert([
                'UTI_ID' => $idInitiator ,
                'FORM_NIVEAU' => $validated['category'],
            ]);
        }

        // inserting Students
        foreach ($validated['student'] as $idStudent) {

            DB::table('APPARTIENT')->insert([
                'UTI_ID' => $idStudent ,
                'FORM_NIVEAU' => $validated['category'],
                'DATE_INSCRIPTION' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Formation créée avec succès !');

    }

}
