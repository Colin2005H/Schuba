<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\GererLaFormation;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="GererLaFormation",
 *     type="object",
 *     required={"UTI_ID", "FORM_NIVEAU"},
 *     @OA\Property(
 *         property="UTI_ID",
 *         type="integer",
 *         description="The user ID of the initiator/teacher (PloInitiateur)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="FORM_NIVEAU",
 *         type="integer",
 *         description="The formation level (PloFormation)",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="GER_DATE_DEBUT",
 *         type="string",
 *         format="date-time",
 *         description="The start date of the formation",
 *         example="2025-01-01T09:00:00"
 *     ),
 *     @OA\Property(
 *         property="plo_formation",
 *         type="object",
 *         description="The formation (PloFormation) associated with the management",
 *         ref="#/components/schemas/PloFormation"
 *     ),
 *     @OA\Property(
 *         property="plo_initiateur",
 *         type="object",
 *         description="The initiator (PloInitiateur) associated with the formation",
 *         ref="#/components/schemas/PloInitiateur"
 *     )
 * )
 */

class GererLaFormationController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/manager",
     *     summary="Get formation manager records",
     *     description="Retrieve manager based on optional filters: User ID, Formation Level, and Start Date.",
     *     tags={"Managers"},
     *     @OA\Parameter(
     *         name="UTI_ID",
     *         in="query",
     *         description="User ID to filter the records",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="FORM_NIVEAU",
     *         in="query",
     *         description="Formation Level to filter the records",
     *         required=false,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Parameter(
     *         name="GER_DATE_DEBUT",
     *         in="query",
     *         description="Start Date of the formation",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time", example="2025-01-01T09:00:00")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved GererLaFormation records",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="FORM_NIVEAU", type="integer", example=2),
     *                 @OA\Property(property="GER_DATE_DEBUT", type="string", format="date-time", example="2025-01-01T09:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid parameters")
     *         )
     *     )
     * )
     */
    public function get(Request $request) {
        $utiId = $request->input('UTI_ID');
        $formNiveau = $request->input('FORM_NIVEAU');
        $gerDateDebut = $request->input('GER_DATE_DEBUT');

        $query = GererLaFormation::query();

        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }
        if ($formNiveau) {
            $query->where('FORM_NIVEAU', $formNiveau);
        }
        if ($gerDateDebut) {
            $gerDateDebut = Carbon::parse($gerDateDebut);
            $query->whereDate('GER_DATE_DEBUT', '>=', $gerDateDebut);
        }

        $formations = $query->get();

        return response()->json($formations);
    }

    /**
     * @OA\Post(
     *     path="/api/gerer-la-formation",
     *     summary="Create a new formation manager",
     *     description="This API allows you to create a new manager by providing the User ID, Formation Level, and Start Date.",
     *     tags={"Managers"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="The necessary data to create a new GererLaFormation record",
     *         @OA\JsonContent(
     *             required={"UTI_ID", "FORM_NIVEAU", "GER_DATE_DEBUT"},
     *             @OA\Property(
     *                 property="UTI_ID",
     *                 type="integer",
     *                 description="ID of the user associated with the formation record",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="FORM_NIVEAU",
     *                 type="integer",
     *                 description="Formation level associated with the GererLaFormation record",
     *                 example=2
     *             ),
     *             @OA\Property(
     *                 property="GER_DATE_DEBUT",
     *                 type="string",
     *                 format="date-time",
     *                 description="Start date and time of the formation",
     *                 example="2025-01-01T09:00:00"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="GererLaFormation record created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="GererLaFormation successfully created!"),
     *             @OA\Property(
     *                 property="gerer_la_formation",
     *                 type="object",
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="FORM_NIVEAU", type="integer", example=2),
     *                 @OA\Property(property="GER_DATE_DEBUT", type="string", format="date-time", example="2025-01-01T09:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error in the provided data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The provided data is invalid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred while creating the record")
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        $validated = $request->validate([
            'UTI_ID' => 'required|integer|exists:plo_utilisateur,UTI_ID',
            'FORM_NIVEAU' => 'required|integer|exists:plo_formation,FORM_NIVEAU',
            'GER_DATE_DEBUT' => 'required|date',
        ]);

        $gererLaFormation = GererLaFormation::create([
            'UTI_ID' => $request->input('UTI_ID'),
            'FORM_NIVEAU' => $request->input('FORM_NIVEAU'),
            'GER_DATE_DEBUT' => $request->input('GER_DATE_DEBUT'),
        ]);

        return response()->json([
            'message' => 'GererLaFormation successfully created!',
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
     *     summary="Delete a formation manager record",
     *     description="This API allows you to delete an existing manager by providing its ID.",
     *     tags={"Managers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the GererLaFormation record to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="GererLaFormation record deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="GererLaFormation successfully deleted!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="GererLaFormation record not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="GererLaFormation record not found.")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        $gererLaFormation = GererLaFormation::find($id);

        if (!$gererLaFormation) {
            return response()->json([
                'message' => 'GererLaFormation record not found.'
            ], 404);
        }

        $gererLaFormation->delete();

        return response()->json([
            'message' => 'GererLaFormation successfully deleted!'
        ]);
    }


}
