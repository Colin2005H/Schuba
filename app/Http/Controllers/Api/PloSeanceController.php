<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\PloSeance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PloSeanceController extends Controller {
    public function liste(Request $request){
        $dateDebut = $request->input('start');
        $dateFin = $request->input('end');

        $query = PloSeance::query();

        if ($dateDebut) {
            $dateDebut = Carbon::parse($dateDebut);
            $query->where('SEA_DATE_DEB', '>=', $dateDebut);
        }

        if ($dateFin) {
            $dateFin = Carbon::parse($dateFin);
            $query->where('SEA_DATE_FIN', '<=', $dateFin);
        }

        $seances = $query->get();

        // Transformer les séances pour le format FullCalendar
        $events = $seances->map(function ($seance) {
            return [
                'id' => $seance->SEA_ID,
                'niveau' =>$seance->FORM_NIVEAU,
                'start' => $seance->SEA_DATE_DEB->toIso8601String(),
                'end' => $seance->SEA_DATE_FIN->toIso8601String()
            ];
        });

        return response()->json($events);
    }

    function detail($id){
        return response()->json(PloSeance::find($id));
    }
}
