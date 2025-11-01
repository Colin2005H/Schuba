<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Aptitude;
use App\Models\Seance;
use App\Models\Evaluation;
use App\Models\Evaluer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//modifSeanceController is a controller class that handles the modification of a session 
class ModifSeanceController extends Controller
{

    /**
     * showForm
     * 
     * function of the controller for redirect 
     * to the form with all data of the session.
     * 
     * @param  int $session The id of the session
     * @return void
     */
    public function showForm(int $session)
    {
        $session = Seance::find($session);
        $eleves = $session->getEleves();

        $currentUser = session('user');


        return view('modif-seance', ['eleves' => $eleves, 'seance' => $session, 'currentUser' => $currentUser/*,'default' => $default*/]);
    }

    /**
     * delete
     *
     * function to delete the current session from the database.
     * 
     * @param  mixed $request the results of the form
     * @return void
     */
    public function delete(Request $request)
    {

        DB::table('EVALUER')
            ->where('SEA_ID', $request->input('SEA_ID'))
            ->delete();

        DB::table('GROUPER')
            ->where('SEA_ID', $request->input('SEA_ID'))
            ->delete();

        Seance::destroy($request->input('SEA_ID'));

        return view('calendar');
    }

    /**
     * update
     *
     * function to update the current session 
     * with all data changes from the form
     * on the database.
     * 
     * @param  mixed $request the results of the form
     * @return void
     */
    public function update(Request $request)
    {

        $action = $request->input('action');

        if ($action === 'update') {
            Seance::destroy($request->input('SEA_ID'));

            DB::table('GROUPER')
                ->where('SEA_ID', $request->input('SEA_ID'))
                ->delete();

            DB::table('EVALUER')
                ->where('SEA_ID', $request->input('SEA_ID'))
                ->delete();

            return view('calendar');
        } elseif ($action === 'delete') {
            $this->delete($request);
        }

    }

}