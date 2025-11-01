<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\GererLaFormation;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="Manager",
 *     type="object",
 *     required={"UTI_ID", "FORM_NIVEAU"},
 *     @OA\Property(
 *         property="INIT_ID",
 *         type="integer",
 *         description="The user ID of the initiator/teacher (PloInitiateur)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="LEVEL",
 *         type="integer",
 *         description="The formation level (PloFormation)",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="START",
 *         type="string",
 *         format="date-time",
 *         description="The start date of the formation",
 *         example="2025-01-01T09:00:00"
 *     ),
 *     @OA\Property(
 *         property="Formation",
 *         type="object",
 *         description="The formation (PloFormation) associated with the management",
 *         ref="#/components/schemas/Formation"
 *     ),
 *     @OA\Property(
 *         property="Initiator",
 *         type="object",
 *         description="The initiator (PloInitiateur) associated with the formation",
 *         ref="#/components/schemas/Initiator"
 *     )
 * )
 */

class GererLaFormationController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/manager",
     *     summary="Retrieve Managers based on optional filters",
     *     description="Retrieve records of managers filtered by INIT_ID, LEVEL, and START date.",
     *     operationId="getManagerRecords",
     *     tags={"Managers"},
     *
     *     @OA\Parameter(
     *         name="INIT_ID",
     *         in="query",
     *         description="Filter by the ID of the initiator (INIT_ID)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="LEVEL",
     *         in="query",
     *         description="Filter by formation level (LEVEL)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="START",
     *         in="query",
     *         description="Filter by start date of the formation (START)",
     *         required=false,
     *         @OA\Schema(type="string", format="date", example="2025-01-01")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of Manager records matching the filters",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Manager"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, invalid parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid input data")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Something went wrong")
     *         )
     *     )
     * )
     */
    public function get(Request $request) {
        $utiId = $request->input('INIT_ID');
        $formNiveau = $request->input('LEVEL');
        $gerDateDebut = $request->input('START');

        $query = GererLaFormation::query();

        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }
        if ($formNiveau) {
            $query->where('FORM_NIVEAU', $formNiveau);
        }
        if ($gerDateDebut) {
            $gerDateDebut = Carbon::parse($gerDateDebut);
            $query->whereDate('GER_DATE_DEBUT', $gerDateDebut);
        }

        $formations = $query->get();

        $events = $formations->map(function ($formation) {
            return [
                'INIT_ID' => $formation->UTI_ID,
                'LEVEL' => $formation->FORM_NIVEAU,
                'START' =>$formation->GER_DATE_DEBUT,
            ];
        });

        return response()->json($formations);
    }

    /**
     * @OA\Post(
     *     path="/api/manager",
     *     summary="Create a new Manager record",
     *     description="Creates a new manager record with the provided INIT_ID, LEVEL, and START date.",
     *     operationId="createManager",
     *     tags={"Managers"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"INIT_ID", "LEVEL", "START"},
     *                 @OA\Property(property="INIT_ID", type="integer", description="The ID of the initiator", example=123),
     *                 @OA\Property(property="LEVEL", type="integer", description="The level of the formation", example=1),
     *                 @OA\Property(property="START", type="string", format="date", description="The start date of the formation", example="2025-01-01")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Manager record successfully created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Manager successfully created!"),
     *             @OA\Property(
     *                 property="Manager",
     *                 type="object",
     *                 @OA\Property(property="INIT_ID", type="integer", example=123),
     *                 @OA\Property(property="LEVEL", type="integer", example=1),
     *                 @OA\Property(property="START", type="string", format="date", example="2025-01-01")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid input data")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Something went wrong")
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        $validated = $request->validate([
            'INIT_ID' => 'required|integer|exists:plo_utilisateur,UTI_ID',
            'LEVEL' => 'required|integer|exists:plo_formation,FORM_NIVEAU',
            'START' => 'required|date',
        ]);

        $gererLaFormation = GererLaFormation::create([
            'UTI_ID' => $request->input('INIT_ID'),
            'FORM_NIVEAU' => $request->input('LEVEL'),
            'GER_DATE_DEBUT' => $request->input('START'),
        ]);

        return response()->json([
            'message' => 'Manager successfully created!',
            'gerer_la_formation' => [
                'UTI_ID' => $gererLaFormation->UTI_ID,
                'FORM_NIVEAU' => $gererLaFormation->FORM_NIVEAU,
                'GER_DATE_DEBUT' => $gererLaFormation->GER_DATE_DEBUT,
            ],
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/manager/{id}",
     *     summary="Delete a Manager record",
     *     description="Deletes a manager record by the provided ID.",
     *     operationId="deleteManager",
     *     tags={"Managers"},
     *     
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the Manager record to delete",
     *         @OA\Schema(type="integer", example=123)
     *     ),
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Manager record successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Manager successfully deleted!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Manager record not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Manager record not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Something went wrong")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        $gererLaFormation = GererLaFormation::find($id);

        if (!$gererLaFormation) {
            return response()->json([
                'message' => 'Manager record not found.'
            ], 404);
        }

        $gererLaFormation->delete();

        return response()->json([
            'message' => 'Manager successfully deleted!'
        ]);
    }
}
