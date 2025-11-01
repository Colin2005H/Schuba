<?php

namespace App\Http\Controllers\Api;

use App\Models\Appartient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="Signed",
 *     type="object",
 *     required={"FORM_NIVEAU", "UTI_ID"},
 *     @OA\Property(
 *         property="FORM_NIVEAU",
 *         type="integer",
 *         description="The training level ID associated with the formation (PloFormation) ",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="STUD_ID",
 *         type="integer",
 *         description="The user ID of the student (PloEleve)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="SIGN_DATE",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the student was enrolled in the formation",
 *         example="2025-01-01T10:00:00"
 *     ),
 *     @OA\Property(
 *         property="Student",
 *         type="object",
 *         description="The student (PloEleve) associated with the formation",
 *         ref="#/components/schemas/Student"
 *     ),
 *     @OA\Property(
 *         property="Formation",
 *         type="object",
 *         description="The formation (PloFormation) associated with the training level",
 *         ref="#/components/schemas/Formation"
 *     )
 * )
 */

class AppartientController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/signed",
     *     summary="Get Signed records",
     *     description="Retrieve Signed records based on optional filters: User ID, Formation Level, and Registration Date.",
     *     tags={"Signeds"},
     *     @OA\Parameter(
     *         name="STUD_ID",
     *         in="query",
     *         description="User ID to filter the records",
     *         required=false,
     *         @OA\Schema(type="integer", example=123)
     *     ),
     *     @OA\Parameter(
     *         name="LEVEL",
     *         in="query",
     *         description="Formation Level to filter the records",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
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
     *                 ref="#/components/schemas/Signed"
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
        $utiId = $request->input('STUD_ID');
        $formNiveau = $request->input('LEVEL');
        $dateInscription = $request->input('SIGN_DATE');

        $query = Appartient::query();

        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }
        if ($formNiveau) {
            $query->where('LEVEL', $formNiveau);
        }
        if ($dateInscription) {
            $query->whereDate('SIGN_DATE', $dateInscription);
        }

        $appartients = $query->get();

        $events = $appartients->map(function ($appartient) {
            return [
                'ID' => $appartient->UTI_ID,
                'LEVEL' => $appartient->FORM_NIVEAU,
                'SIGN_DATE' => $appartient->DATE_INSCRIPTION->toIso8601String(),
            ];
        });

        return response()->json($events);
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
     *             required={"STUD_ID", "FORM_NIVEAU", "DATE_INSCRIPTION"},
     *             @OA\Property(
     *                 property="STUD_ID",
     *                 type="integer",
     *                 description="ID of the user who belongs to the formation",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="LEVEL",
     *                 type="integer",
     *                 description="Formation level that the user belongs to",
     *                 example=2
     *             ),
     *             @OA\Property(
     *                 property="SIGN_DATE",
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
            'STUD_ID' => 'required|integer|exists:plo_utilisateur,UTI_ID',
            'LEVEL' => 'required|integer|exists:plo_formation,FORM_NIVEAU',
            'SIGN_DATE' => 'required|date',
        ]);

        $appartient = Appartient::create([
            'UTI_ID' => $request->input('STUD_ID'),
            'FORM_NIVEAU' => $request->input('FORM_NIVEAU'),
            'DATE_INSCRIPTION' => $request->input('DATE_INSCRIPTION'),
        ]);

        return response()->json([
            'message' => 'Signed successfully created!',
            'appartient' => [
                'STUD_ID' => $appartient->UTI_ID,
                'LEVEL' => $appartient->FORM_NIVEAU,
                'SIGN_DATE' => $appartient->DATE_INSCRIPTION,
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
