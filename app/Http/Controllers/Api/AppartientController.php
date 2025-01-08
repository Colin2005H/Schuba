<?php

namespace App\Http\Controllers\Api;

use App\Models\Appartient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppartientController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/signed",
     *     summary="Get Signed records",
     *     description="Retrieve Signed records based on optional filters: User ID, Formation Level, and Registration Date.",
     *     tags={"Signeds"},
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
     *         name="DATE_INSCRIPTION",
     *         in="query",
     *         description="Registration Date of the formation",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time", example="2025-01-01T09:00:00")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved Appartient records",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="FORM_NIVEAU", type="integer", example=2),
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="DATE_INSCRIPTION", type="string", format="date-time", example="2025-01-01T09:00:00")
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
        $dateInscription = $request->input('DATE_INSCRIPTION');

        $query = Appartient::query();

        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }
        if ($formNiveau) {
            $query->where('FORM_NIVEAU', $formNiveau);
        }
        if ($dateInscription) {
            $query->whereDate('DATE_INSCRIPTION', $dateInscription);
        }

        $appartients = $query->get();

        return response()->json($appartients);
    }

    /**
     * @OA\Post(
     *     path="/api/signed",
     *     summary="Create a new Signed record",
     *     description="This API allows you to create a new Signed record by providing the User ID, Formation Level, and Registration Date.",
     *     tags={"Signeds"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="The necessary data to create a new Signed record",
     *         @OA\JsonContent(
     *             required={"UTI_ID", "FORM_NIVEAU", "DATE_INSCRIPTION"},
     *             @OA\Property(
     *                 property="UTI_ID",
     *                 type="integer",
     *                 description="ID of the user who belongs to the formation",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="FORM_NIVEAU",
     *                 type="integer",
     *                 description="Formation level that the user belongs to",
     *                 example=2
     *             ),
     *             @OA\Property(
     *                 property="DATE_INSCRIPTION",
     *                 type="string",
     *                 format="date-time",
     *                 description="The registration date of the formation",
     *                 example="2025-01-01T09:00:00"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Signed record created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Appartient successfully created!"),
     *             @OA\Property(
     *                 property="appartient",
     *                 type="object",
     *                 @OA\Property(property="FORM_NIVEAU", type="integer", example=2),
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="DATE_INSCRIPTION", type="string", format="date-time", example="2025-01-01T09:00:00")
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
            'DATE_INSCRIPTION' => 'required|date',
        ]);

        $appartient = Appartient::create([
            'UTI_ID' => $request->input('UTI_ID'),
            'FORM_NIVEAU' => $request->input('FORM_NIVEAU'),
            'DATE_INSCRIPTION' => $request->input('DATE_INSCRIPTION'),
        ]);

        return response()->json([
            'message' => 'Signed successfully created!',
            'appartient' => [
                'FORM_NIVEAU' => $appartient->FORM_NIVEAU,
                'UTI_ID' => $appartient->UTI_ID,
                'DATE_INSCRIPTION' => $appartient->DATE_INSCRIPTION,
            ],
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/signed/{id}",
     *     summary="Delete an Signed record",
     *     description="This API allows you to delete an existing Signed record by providing its ID.",
     *     tags={"Signeds"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Signed record to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Signed record deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Signed successfully deleted!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Signed record not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Signed record not found.")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        $appartient = Appartient::find($id);

        if (!$appartient) {
            return response()->json([
                'message' => 'Signed record not found.'
            ], 404);
        }

        $appartient->delete();

        return response()->json([
            'message' => 'Signed record successfully deleted!'
        ]);
    }



}
