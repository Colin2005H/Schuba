<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\PloSeance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Schuba API",
 *     description="API pour la gestion des séances de formation",
 *     version="1.0.0"
 * )
 */
class PloSeanceController extends Controller {

    /**
     * List of sessions
     *
     * @OA\Get(
     *     path="/api/session",
     *     summary="List of sessions",
     *     description="Retrieve the list of sessions.",
     *     operationId="getSessions",
     *     tags={"Sessions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Session ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="SEA_DATE_DEB",
     *         in="query",
     *         description="Start date",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time")
     *     ),
     *     @OA\Parameter(
     *         name="SEA_DATE_FIN",
     *         in="query",
     *         description="End date",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of sessions",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="niveau", type="integer"),
     *                 @OA\Property(property="start", type="string", format="date-time"),
     *                 @OA\Property(property="end", type="string", format="date-time"),
     *                 @OA\Property(property="lieu", type="string"),
     *                 @OA\Property(property="type", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function liste(Request $request) {
        $id = $request->input('id');
        $dateDebut = $request->input('SEA_DATE_DEB');
        $dateFin = $request->input('SEA_DATE_FIN');

        $query = PloSeance::query();

        if ($id) {
            $query->where('SEA_ID', $id);
        }
        if ($dateDebut) {
            $dateDebut = Carbon::parse($dateDebut);
            $query->where('SEA_DATE_DEB', '>=', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = Carbon::parse($dateFin);
            $query->where('SEA_DATE_FIN', '<=', $dateFin);
        }

        $seances = $query->get();

        // format personnalisé
        $events = $seances->map(function ($seance) {
            return [
                'id' => $seance->SEA_ID,
                'niveau' =>$seance->FORM_NIVEAU,
                'start' => $seance->SEA_DATE_DEB->toIso8601String(),
                'end' => $seance->SEA_DATE_FIN->toIso8601String(),
                'lieu' => $seance->plo_lieu->LI_NOM,
                'type' => $seance->plo_lieu->LI_TYPE
            ];
        });

        return response()->json($events);
    }
}
