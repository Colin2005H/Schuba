<?php

namespace App\Http\Controllers\Api;

use App\Models\Valider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValiderController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/validate",
     *     summary="Get Validate records",
     *     description="Retrieve Validate records based on the optional filters: User ID, Competence ID, and Validation Status.",
     *     tags={"Validates"},
     *     @OA\Parameter(
     *         name="UTI_ID",
     *         in="query",
     *         description="User ID to filter the records",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="CPT_ID",
     *         in="query",
     *         description="Competence ID to filter the records",
     *         required=false,
     *         @OA\Schema(type="string", example="CPT123")
     *     ),
     *     @OA\Parameter(
     *         name="VALIDER",
     *         in="query",
     *         description="Validation status (true/false) to filter the records",
     *         required=false,
     *         @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved Valider records",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="CPT_ID", type="string", example="CPT123"),
     *                 @OA\Property(property="VALIDER", type="boolean", example=true)
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
        $cptId = $request->input('CPT_ID');
        $valider = $request->input('VALIDER');

        $query = Valider::query();

        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }
        if ($cptId) {
            $query->where('CPT_ID', $cptId);
        }
        if (isset($valider)) {
            $valider = filter_var($valider, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $query->where('VALIDER', $valider);
        }

        $validators = $query->get();

        return response()->json($validators);
    }

    /**
     * @OA\Post(
     *     path="/api/validate",
     *     summary="Create a new Validate record",
     *     description="This API allows you to create a new Validate record by providing the User ID, Competence ID, and Validation Status.",
     *     tags={"Validates"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="The necessary data to create a new Validate record",
     *         @OA\JsonContent(
     *             required={"UTI_ID", "CPT_ID", "VALIDER"},
     *             @OA\Property(
     *                 property="UTI_ID",
     *                 type="integer",
     *                 description="ID of the user associated with the Validate record",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="CPT_ID",
     *                 type="string",
     *                 description="Competence ID associated with the Validate record",
     *                 example="CPT123"
     *             ),
     *             @OA\Property(
     *                 property="VALIDER",
     *                 type="boolean",
     *                 description="Validation status",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valider record created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation successfully created!"),
     *             @OA\Property(
     *                 property="valider",
     *                 type="object",
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="CPT_ID", type="string", example="CPT123"),
     *                 @OA\Property(property="VALIDER", type="boolean", example=true)
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
            'CPT_ID' => 'required|string|exists:plo_competence,CPT_ID',
            'VALIDER' => 'required|boolean',
        ]);

        $valider = Valider::create([
            'UTI_ID' => $request->input('UTI_ID'),
            'CPT_ID' => $request->input('CPT_ID'),
            'VALIDER' => $request->input('VALIDER'),
        ]);

        return response()->json([
            'message' => 'Valider successfully created!',
            'valider' => [
                'UTI_ID' => $valider->UTI_ID,
                'CPT_ID' => $valider->CPT_ID,
                'VALIDER' => $valider->VALIDER,
            ],
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/validate/{id}",
     *     summary="Update an existing Validate record",
     *     description="This API allows you to update an existing Validate record by providing the User ID, Competence ID, and Validation Status.",
     *     tags={"Validates"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Validate record to be updated",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="The updated data for the Validate record",
     *         @OA\JsonContent(
     *             required={"VALIDER"},
     *             @OA\Property(
     *                 property="VALIDER",
     *                 type="boolean",
     *                 description="Validation status",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valider record updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Valider successfully updated!"),
     *             @OA\Property(
     *                 property="valider",
     *                 type="object",
     *                 @OA\Property(property="UTI_ID", type="integer", example=1),
     *                 @OA\Property(property="CPT_ID", type="string", example="CPT123"),
     *                 @OA\Property(property="VALIDER", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error in the provided data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The provided data is invalid")
     *         )
     *     )
     * )
     */
    public function update($id, Request $request) {
        $validated = $request->validate([
            'VALIDER' => 'required|boolean',
        ]);

        $valider = Valider::find($id);
        if (!$valider) {
            return response()->json([
                'message' => 'Valider record not found.'
            ], 404);
        }

        $valider->VALIDER = $request->input('VALIDER');
        $valider->save();

        return response()->json([
            'message' => 'Valider successfully updated!',
            'valider' => [
                'UTI_ID' => $valider->UTI_ID,
                'CPT_ID' => $valider->CPT_ID,
                'VALIDER' => $valider->VALIDER,
            ],
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/validate/{id}",
     *     summary="Delete a Validate record",
     *     description="This API allows you to delete an existing Validate record by providing its ID.",
     *     tags={"Validates"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Validate record to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validate record deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validate successfully deleted!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Validate record not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validate record not found.")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        $valider = Valider::find($id);

        if (!$valider) {
            return response()->json([
                'message' => 'Validate record not found.'
            ], 404);
        }

        $valider->delete();

        return response()->json([
            'message' => 'Validate successfully deleted!'
        ]);
    }
}