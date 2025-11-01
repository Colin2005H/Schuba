<?php

namespace App\Http\Controllers\Api;

use App\Models\Evaluer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="Assessment",
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
 *         property="COMMENT",
 *         type="string",
 *         description="Comments regarding the evaluation",
 *         example="Excellent performance!"
 *     ),
 *     @OA\Property(
 *         property="RESULT",
 *         type="string",
 *         description="The result of the evaluation",
 *         example="'Acquis' / 'Non acquis'"
 *     ),
 *     @OA\Property(
 *         property="Aptitude",
 *         type="object",
 *         description="The aptitude (PloAptitude) associated with the evaluation",
 *         ref="#/components/schemas/Aptitude"
 *     ),
 *     @OA\Property(
 *         property="Student",
 *         type="object",
 *         description="The student (PloEleve) being evaluated",
 *         ref="#/components/schemas/Student"
 *     ),
 *     @OA\Property(
 *         property="Session",
 *         type="object",
 *         description="The session (PloSeance) associated with the evaluation",
 *         ref="#/components/schemas/Session"
 *     )
 * )
 */

class EvaluerController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/assessment",
     *     summary="Get Assessment records based on filters",
     *     description="Retrieve Assessment records filtered by session ID (SESS_ID), appointment code (APT_CODE), student ID (STUD_ID), comment (COMMENT), and result (RESULT).",
     *     operationId="getAssessmentRecords",
     *     tags={"Assessments"},
     *
     *     @OA\Parameter(
     *         name="SESS_ID",
     *         in="query",
     *         description="Filter by session ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="APT_CODE",
     *         in="query",
     *         description="Filter by appointment code",
     *         required=false,
     *         @OA\Schema(type="string", example="APT123")
     *     ),
     *     @OA\Parameter(
     *         name="STUD_ID",
     *         in="query",
     *         description="Filter by student ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=456)
     *     ),
     *     @OA\Parameter(
     *         name="COMMENT",
     *         in="query",
     *         description="Filter by comment text (partial match)",
     *         required=false,
     *         @OA\Schema(type="string", example="Good performance")
     *     ),
     *     @OA\Parameter(
     *         name="RESULT",
     *         in="query",
     *         description="Filter by result text (partial match)",
     *         required=false,
     *         @OA\Schema(type="string", example="Pass")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved assessment records",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Assessment"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, invalid parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid parameter")
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
        $seaId = $request->input('SESS_ID');
        $aptCode = $request->input('APT_CODE');
        $utiId = $request->input('STUD_ID');
        $com = $request->input('COMMENT');
        $res = $request->input('RESULT');

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
        if ($com) {
            $query->where('EVA_COMMENTAIRE', 'like', '%' . $com . '%');
        }
        if ($res) {
            $query->where('EVA_RESULTAT', 'like', '%' . $res . '%');
        }

        $evaluations = $query->get();

        $events = $evaluations->map(function ($evaluation) {
            return [
                'SESS_ID' => $evaluation->SEA_ID,
                'APT_CODE' => $evaluation->APT_CODE,
                'STUD_ID' =>$evaluation->UTI_ID,
                'COMMENT' => $evaluation->EVA_COMMENTAIRE,
                'RESULT' =>$evaluation->EVA_RESULTAT,
            ];
        });

        return response()->json($events);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'SEA_ID' => 'required|integer|exists:plo_seance,SEA_ID',
            'APT_CODE' => 'required|string|exists:plo_aptitude,APT_CODE',
            'UTI_ID' => 'required|integer|exists:plo_eleve,UTI_ID',
            'EVA_COMMENTAIRE' => 'nullable|string',
            'EVA_RESULTAT' => 'nullable|string',
        ]);

        $evaluation = Evaluer::create([
            'SEA_ID' => $request->input('SESS_ID'),
            'APT_CODE' => $request->input('APT_CODE'),
            'UTI_ID' => $request->input('STUD_ID'),
            'EVA_COMMENTAIRE' => $request->input('COMMENT'),
            'EVA_RESULTAT' => $request->input('RESULT'),
        ]);

        return response()->json([
            'message' => 'Assessment successfully created!',
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
     * @OA\Post(
     *     path="/api/assessment",
     *     summary="Create a new Assessment record",
     *     description="Create a new Assessment record by providing session ID (SEA_ID), appointment code (APT_CODE), student ID (UTI_ID), comment (EVA_COMMENTAIRE), and result (EVA_RESULTAT).",
     *     operationId="createAssessmentRecord",
     *     tags={"Assessments"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Assessment data to be created",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Assessment")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created the assessment record",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Assessment"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, invalid input data",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation failed for input parameters")
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
                'message' => 'Assessment record not found'
            ], 404);
        }

        $evaluation->update([
            'SEA_ID' => $request->input('SESS_ID'),
            'APT_CODE' => $request->input('APT_CODE'),
            'UTI_ID' => $request->input('STUD_ID'),
            'EVA_COMMENTAIRE' => $request->input('COMMENT'),
            'EVA_RESULTAT' => $request->input('RESULT'),
        ]);

        return response()->json([
            'message' => 'Assessment successfully updated!',
            'evaluer' => $evaluation,
        ]);
    }

    public function delete($id) {
        $evaluation = Evaluer::find($id);

        if (!$evaluation) {
            return response()->json([
                'message' => 'Assessment record not found'
            ], 404);
        }

        $evaluation->delete();

        return response()->json([
            'message' => 'Assessment record deleted successfully!'
        ]);
    }
}
