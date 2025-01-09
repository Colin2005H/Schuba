<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormationController extends Controller
{
    public function showFormation(){

        //verify if sessions exist for the formation N1
        $n1NbSessions = DB::table('PLO_SEANCE')
        ->join('PLO_FORMATION', 'PLO_SEANCE.FORM_NIVEAU', '=', 'PLO_FORMATION.FORM_NIVEAU')
        ->where('PLO_SEANCE.FORM_NIVEAU', 1)
        ->count();

        //verify if sessions exist for the formation N2
        $n2NbSessions = DB::table('PLO_SEANCE')
        ->join('PLO_FORMATION', 'PLO_SEANCE.FORM_NIVEAU', '=', 'PLO_FORMATION.FORM_NIVEAU')
        ->where('PLO_SEANCE.FORM_NIVEAU', 2)
        ->count();

        //verify if sessions exist for the formation N3
        $n3NbSessions = DB::table('PLO_SEANCE')
        ->join('PLO_FORMATION', 'PLO_SEANCE.FORM_NIVEAU', '=', 'PLO_FORMATION.FORM_NIVEAU')
        ->where('PLO_SEANCE.FORM_NIVEAU', 3)
        ->count();

        //verify if formation level 1 exist and get data
        $n1Exist = DB::table('GERER_LA_FORMATION')
        ->where('FORM_NIVEAU', 1)
        ->count();

        $n1ExistManager = DB::table('GERER_LA_FORMATION')
        ->join('PLO_INITIATEUR', 'GERER_LA_FORMATION.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
        ->join('PLO_UTILISATEUR', 'GERER_LA_FORMATION.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('GERER_LA_FORMATION.FORM_NIVEAU', 1)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        $n1ExistInitiators = DB::table('ENSEIGNER')
        ->join('PLO_INITIATEUR', 'ENSEIGNER.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
        ->join('PLO_UTILISATEUR', 'ENSEIGNER.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('ENSEIGNER.FORM_NIVEAU', 1)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        $n1ExistStudents = DB::table('PLO_FORMATION')
        ->join('APPARTIENT', 'PLO_FORMATION.FORM_NIVEAU', '=', 'APPARTIENT.FORM_NIVEAU')
        ->join('PLO_ELEVE', 'APPARTIENT.UTI_ID', '=', 'PLO_ELEVE.UTI_ID')
        ->join('PLO_UTILISATEUR', 'PLO_ELEVE.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('PLO_FORMATION.FORM_NIVEAU', 1)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        //verify if formation level 2 exist and get data
        $n2Exist = DB::table('GERER_LA_FORMATION')
        ->where('FORM_NIVEAU', 2)
        ->count();

        $n2ExistManager = DB::table('GERER_LA_FORMATION')
        ->join('PLO_INITIATEUR', 'GERER_LA_FORMATION.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
        ->join('PLO_UTILISATEUR', 'GERER_LA_FORMATION.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('GERER_LA_FORMATION.FORM_NIVEAU', 2)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        $n2ExistInitiators = DB::table('ENSEIGNER')
        ->join('PLO_INITIATEUR', 'ENSEIGNER.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
        ->join('PLO_UTILISATEUR', 'ENSEIGNER.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('ENSEIGNER.FORM_NIVEAU', 2)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        $n2ExistStudents = DB::table('PLO_FORMATION')
        ->join('APPARTIENT', 'PLO_FORMATION.FORM_NIVEAU', '=', 'APPARTIENT.FORM_NIVEAU')
        ->join('PLO_ELEVE', 'APPARTIENT.UTI_ID', '=', 'PLO_ELEVE.UTI_ID')
        ->join('PLO_UTILISATEUR', 'PLO_ELEVE.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('PLO_FORMATION.FORM_NIVEAU', 2)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        //verify if formation level 3 exist and get data
        $n3Exist = DB::table('GERER_LA_FORMATION')
        ->where('FORM_NIVEAU', 3)
        ->count();

        $n3ExistManager = DB::table('GERER_LA_FORMATION')
        ->join('PLO_INITIATEUR', 'GERER_LA_FORMATION.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
        ->join('PLO_UTILISATEUR', 'GERER_LA_FORMATION.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('GERER_LA_FORMATION.FORM_NIVEAU', 3)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        $n3ExistInitiators = DB::table('ENSEIGNER')
        ->join('PLO_INITIATEUR', 'ENSEIGNER.UTI_ID', '=', 'PLO_INITIATEUR.UTI_ID')
        ->join('PLO_UTILISATEUR', 'ENSEIGNER.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('ENSEIGNER.FORM_NIVEAU', 3)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        $n3ExistStudents = DB::table('PLO_FORMATION')
        ->join('APPARTIENT', 'PLO_FORMATION.FORM_NIVEAU', '=', 'APPARTIENT.FORM_NIVEAU')
        ->join('PLO_ELEVE', 'APPARTIENT.UTI_ID', '=', 'PLO_ELEVE.UTI_ID')
        ->join('PLO_UTILISATEUR', 'PLO_ELEVE.UTI_ID', '=', 'PLO_UTILISATEUR.UTI_ID')
        ->where('PLO_FORMATION.FORM_NIVEAU', 3)
        ->select('PLO_UTILISATEUR.UTI_ID', 'PLO_UTILISATEUR.UTI_NOM', 'PLO_UTILISATEUR.UTI_PRENOM')
        ->get();

        //possible managers
        $optionsManager = DB::table('PLO_UTILISATEUR')
        ->whereNotIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('DIRIGER_LE_CLUB');
        })
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_INITIATEUR');
        })
        ->where('UTI_NIVEAU', '>=', 5)
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        //possible N1 & N2 initiators
        $optionsInitiatorsN1N2 =  DB::table('PLO_UTILISATEUR')
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_INITIATEUR');
        })
        ->where('UTI_NIVEAU', '>=', 2)
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        //possible N3 initiators
        $optionsInitiatorsN3 =  DB::table('PLO_UTILISATEUR')
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_INITIATEUR');
        })
        ->where('UTI_NIVEAU', '>=', 5)
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        //possible N1 students
        $optionsStudentN1 =  DB::table('PLO_UTILISATEUR')
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_ELEVE');
        })
        ->where('UTI_NIVEAU',0)
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        //possible N2 students
        $optionsStudentN2 =  DB::table('PLO_UTILISATEUR')
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_ELEVE');
        })
        ->where('UTI_NIVEAU',1)
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        //possible N3 students
        $optionsStudentN3 =  DB::table('PLO_UTILISATEUR')
        ->whereIn('UTI_ID', function ($query) {
            $query->select('UTI_ID')->from('PLO_ELEVE');
        })
        ->where('UTI_NIVEAU',2)
        ->select('UTI_ID', 'UTI_NOM', 'UTI_PRENOM')
        ->get();

        return view('manageFormation', compact('optionsManager','optionsInitiatorsN1N2','optionsInitiatorsN3','optionsStudentN1','optionsStudentN2','optionsStudentN3',
        'n1Exist','n1ExistManager','n1ExistInitiators','n1ExistStudents',
        'n2Exist','n2ExistManager','n2ExistInitiators','n2ExistStudents',
        'n3Exist','n3ExistManager','n3ExistInitiators','n3ExistStudents',
        'n1NbSessions','n2NbSessions','n3NbSessions'));
    }

    public function createFormation(Request $request){

        // verify and validate data
        $validated = $request->validate([
            'category' => 'required',
            'manager' => 'required',
            'initiator' => 'required|array',
            'student' => 'required|array',
        ]);

        if ($request->input('action') == 'Supprimer' ){
            $deleted = DB::table('GERER_LA_FORMATION')->where('FORM_NIVEAU',$validated['category'])->delete();
            $deleted = DB::table('ENSEIGNER')->where('FORM_NIVEAU',$validated['category'])->delete();
            $deleted = DB::table('APPARTIENT')->where('FORM_NIVEAU',$validated['category'])->delete();
            return redirect()->back()->with('success'.$validated['category'], 'Formation supprimée.');
        }
        else{

            $nExist = DB::table('GERER_LA_FORMATION')
            ->where('FORM_NIVEAU', $validated['category'])
            ->count();

            $nManagerExist = DB::table('GERER_LA_FORMATION')
            ->where('UTI_ID', $validated['manager'])
            ->where('FORM_NIVEAU','!=', $validated['category'])
            ->count();

            $initiatorSize = count($validated['initiator']);
            $studentSize = count($validated['student']);

            if($nManagerExist==1){
                return redirect()->back()->with('success'.$validated['category'], 'Le responsable ne peut pas être responsable de deux formations!');
            }
            else if ($studentSize/2 > $initiatorSize){
                return redirect()->back()->with('success'.$validated['category'], 'Il n\'y a pas assez d\'initiateurs pour le nombre d\'élèves!');
            }
            else if ($nExist == 0){

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

                return redirect()->back()->with('success'.$validated['category'], 'Formation créée avec succès !');
            }
            else{

                // updating Manager
                $deleted = DB::table('GERER_LA_FORMATION')->where('FORM_NIVEAU',$validated['category'])->delete();

                DB::table('GERER_LA_FORMATION')->insert([
                    'UTI_ID' => $validated['manager'],
                    'FORM_NIVEAU' => $validated['category'],
                    'GER_DATE_DEBUT' => now(),
                ]);


                // updating Initiators
                $deleted = DB::table('ENSEIGNER')->where('FORM_NIVEAU',$validated['category'])->delete();
                foreach ($validated['initiator'] as $idInitiator) {

                    DB::table('ENSEIGNER')->insert([
                        'UTI_ID' => $idInitiator,
                        'FORM_NIVEAU' => $validated['category']
                    ]);

                }

                // updating Students
                $deleted = DB::table('APPARTIENT')->where('FORM_NIVEAU',$validated['category'])->delete();
                foreach ($validated['student'] as $idStudent) {

                    DB::table('APPARTIENT')->insert([
                        'FORM_NIVEAU' => $validated['category'],
                        'UTI_ID' => $idStudent,
                        'DATE_INSCRIPTION' => now()
                    ]);

                }

                return redirect()->back()->with('success'.$validated['category'], 'Formation modifiée avec succès !');

            }


        }
    }

}
