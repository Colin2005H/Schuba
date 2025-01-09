<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Aptitude;
use App\Models\Seance;
use App\Models\Evaluation;
use App\Models\Evaluer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModifSeanceController extends Controller
{

    public function showForm(int $seance_id)
    {
        $seance = Seance::find($seance_id);
        $eleves = $seance->getEleves();

        $currentUser = session('user');


        return view('modif-seance', ['eleves' => $eleves,'seance' => $seance,'currentUser' => $currentUser/*,'default' => $default*/]);
    }

    public function delete(Request $request)
    {
        Seance::destroy($request->input('SEA_ID'));

            DB::table('GROUPER')
        ->where('SEA_ID', $request->input('SEA_ID'))
        ->delete();

        DB::table('EVALUER')
        ->where('SEA_ID', $request->input('SEA_ID'))
        ->delete();

        return redirect('/');
    }

    public function update(Request $request)
    {
        Seance::destroy($request->input('SEA_ID'));

            DB::table('GROUPER')
        ->where('SEA_ID', $request->input('SEA_ID'))
        ->delete();

        DB::table('EVALUER')
        ->where('SEA_ID', $request->input('SEA_ID'))
        ->delete();
        
        return redirect('/');
    }

}