<?php

namespace App\Http\Controllers\Api;

use App\Models\Evaluer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="Evaluer",
 *     type="object",
 *     required={"SEA_ID", "APT_CODE", "UTI_ID"},
 *     @OA\Property(
 *         property="SEA_ID",
 *         type="integer",
 *         description="The session ID associated with the evaluation (PloSeance)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="APT_CODE",
 *         type="string",
 *         description="The aptitude code associated with the evaluation (PloAptitude)",
 *         example="DIVE_1"
 *     ),
 *     @OA\Property(
 *         property="UTI_ID",
 *         type="integer",
 *         description="The user ID of the student being evaluated (PloEleve)",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="EVA_COMMENTAIRE",
 *         type="string",
 *         description="Comments regarding the evaluation",
 *         example="Excellent performance!"
 *     ),
 *     @OA\Property(
 *         property="EVA_RESULTAT",
 *         type="string",
 *         description="The result of the evaluation",
 *         example="Pass"
 *     ),
 *     @OA\Property(
 *         property="plo_aptitude",
 *         type="object",
 *         description="The aptitude (PloAptitude) associated with the evaluation",
 *         ref="#/components/schemas/PloAptitude"
 *     ),
 *     @OA\Property(
 *         property="plo_eleve",
 *         type="object",
 *         description="The student (PloEleve) being evaluated",
 *         ref="#/components/schemas/PloEleve"
 *     ),
 *     @OA\Property(
 *         property="plo_seance",
 *         type="object",
 *         description="The session (PloSeance) associated with the evaluation",
 *         ref="#/components/schemas/PloSeance"
 *     )
 * )
 */

class EvaluerController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/assessment",
     *     summary="Get Assessment records",
     *     description="Retrieve Assessment records based on optional filters: SEA_ID, APT_CODE, UTI_ID.",
     *     tags={"Assessment"},
     *     @OA\Parameter(
     *         name="SEA_ID",
     *         in="query",
     *         description="Session ID to filter the records",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="APT_CODE",
     *         in="query",
     *         description="Aptitude code to filter the records",
     *         required=false,
     *         @OA\Schema(type="string", example="A1")
     *     ),
     *     @OA\Parameter(
     *         name="UTI_ID",
     *         in="query",
     *         description="User ID to filter the records",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved Assessment records",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="SEA_ID", type="integer", example=1),
     *                 @OA\Property(property="APT_CODE", type="string", example="A1"),
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="EVA_COMMENTAIRE", type="string", example="Great performance."),
     *                 @OA\Property(property="EVA_RESULTAT", type="string", example="Passed")
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
        $seaId = $request->input('SEA_ID');
        $aptCode = $request->input('APT_CODE');
        $utiId = $request->input('UTI_ID');

        $query = Evaluer::query();

        if ($seaId) {
            $query->where('SEA_ID', $seaId);
        }
        if ($aptCode) {
            $query->where('APT_CODE', $aptCode);
        }
        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }

        $evaluations = $query->get();

        return response()->json($evaluations);
    }

    /**
     * @OA\Post(
     *     path="/api/assessment",
     *     summary="Create a new Assessment record",
     *     description="This API allows you to create a new Assessment record by providing the SEA_ID, APT_CODE, UTI_ID, EVA_COMMENTAIRE, and EVA_RESULTAT.",
     *     tags={"Assessment"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="The necessary data to create a new Assessment record",
     *         @OA\JsonContent(
     *             required={"SEA_ID", "APT_CODE", "UTI_ID", "EVA_COMMENTAIRE", "EVA_RESULTAT"},
     *             @OA\Property(
     *                 property="SEA_ID",
     *                 type="integer",
     *                 description="ID of the session being evaluated",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="APT_CODE",
     *                 type="string",
     *                 description="Aptitude code for the assessment",
     *                 example="A1"
     *             ),
     *             @OA\Property(
     *                 property="UTI_ID",
     *                 type="integer",
     *                 description="User ID being rated",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="EVA_COMMENTAIRE",
     *                 type="string",
     *                 description="Comment on the assessment",
     *                 example="Great performance."
     *             ),
     *             @OA\Property(
     *                 property="EVA_RESULTAT",
     *                 type="string",
     *                 description="Result of the assessment",
     *                 example="Passed"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assessment record created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Assessment successfully created!"),
     *             @OA\Property(
     *                 property="assessment",
     *                 type="object",
     *                 @OA\Property(property="SEA_ID", type="integer", example=1),
     *                 @OA\Property(property="APT_CODE", type="string", example="A1"),
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="EVA_COMMENTAIRE", type="string", example="Great performance."),
     *                 @OA\Property(property="EVA_RESULTAT", type="string", example="Passed")
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
            'SEA_ID' => 'required|integer|exists:plo_seance,SEA_ID',
            'APT_CODE' => 'required|string|exists:plo_aptitude,APT_CODE',
            'UTI_ID' => 'required|integer|exists:plo_eleve,UTI_ID',
            'EVA_COMMENTAIRE' => 'nullable|string',
            'EVA_RESULTAT' => 'nullable|string',
        ]);

        $evaluation = Evaluer::create([
            'SEA_ID' => $request->input('SEA_ID'),
            'APT_CODE' => $request->input('APT_CODE'),
            'UTI_ID' => $request->input('UTI_ID'),
            'EVA_COMMENTAIRE' => $request->input('EVA_COMMENTAIRE'),
            'EVA_RESULTAT' => $request->input('EVA_RESULTAT'),
        ]);

        return response()->json([
            'message' => 'Evaluer successfully created!',
            'evaluer' => [
                'SEA_ID' => $evaluation->SEA_ID,
                'APT_CODE' => $evaluation->APT_CODE,
                'UTI_ID' => $evaluation->UTI_ID,
                'EVA_COMMENTAIRE' => $evaluation->EVA_COMMENTAIRE,
                'EVA_RESULTAT' => $evaluation->EVA_RESULTAT,
            ],
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/assessment/{id}",
     *     summary="Update an Assessment record",
     *     description="This API allows you to update an Assessment record by providing the SEA_ID, APT_CODE, UTI_ID, EVA_COMMENTAIRE, and EVA_RESULTAT.",
     *     tags={"Assessment"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Assessment record to be updated",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="The data to update the Assessment record",
     *         @OA\JsonContent(
     *             required={"SEA_ID", "APT_CODE", "UTI_ID", "EVA_COMMENTAIRE", "EVA_RESULTAT"},
     *             @OA\Property(property="SEA_ID", type="integer", example=1),
     *             @OA\Property(property="APT_CODE", type="string", example="A1"),
     *             @OA\Property(property="UTI_ID", type="integer", example=1),
     *             @OA\Property(property="EVA_COMMENTAIRE", type="string", example="Improvement needed."),
     *             @OA\Property(property="EVA_RESULTAT", type="string", example="Failed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assessment record updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Assessment successfully updated!"),
     *             @OA\Property(
     *                 property="assessment",
     *                 type="object",
     *                 @OA\Property(property="SEA_ID", type="integer", example=1),
     *                 @OA\Property(property="APT_CODE", type="string", example="A1"),
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="EVA_COMMENTAIRE", type="string", example="Improvement needed."),
     *                 @OA\Property(property="EVA_RESULTAT", type="string", example="Failed")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Assessment record not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Assessment record not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id) {
        $validated = $request->validate([
            'SEA_ID' => 'required|integer|exists:plo_seance,SEA_ID',
            'APT_CODE' => 'required|string|exists:plo_aptitude,APT_CODE',
            'UTI_ID' => 'required|integer|exists:plo_eleve,UTI_ID',
            'EVA_COMMENTAIRE' => 'nullable|string',
            'EVA_RESULTAT' => 'nullable|string',
        ]);

        $evaluation = Evaluer::find($id);

        if (!$evaluation) {
            return response()->json([
                'message' => 'Evaluer record not found'
            ], 404);
        }

        $evaluation->update([
            'SEA_ID' => $request->input('SEA_ID'),
            'APT_CODE' => $request->input('APT_CODE'),
            'UTI_ID' => $request->input('UTI_ID'),
            'EVA_COMMENTAIRE' => $request->input('EVA_COMMENTAIRE'),
            'EVA_RESULTAT' => $request->input('EVA_RESULTAT'),
        ]);

        return response()->json([
            'message' => 'Assessment successfully updated!',
            'evaluer' => $evaluation,
        ]);
    }

/**
 * @OA\Delete(
 *     path="/api/assessment/{id}",
 *     summary="Delete an Assessment record",
 *     description="This API allows you to delete an existing Assessment record by providing its ID.",
 *     tags={"Assessment"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the Assessment record to be deleted",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Assessment record deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Assessment record deleted successfully!")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Assessment record not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Assessment record not found")
 *         )
 *     )
 * )
 */
public function delete($id) {
    $evaluation = Evaluer::find($id);

    if (!$evaluation) {
        return response()->json([
            'message' => 'Evaluer record not found'
        ], 404);
    }

    $evaluation->delete();

    return response()->json([
        'message' => 'Evaluer record deleted successfully!'
    ]);
}



}
