<?php

namespace App\Http\Controllers\Api;

use App\Models\PloFormation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="Formation",
 *     type="object",
 *     required={"FORM_NIVEAU"},
 *     @OA\Property(
 *         property="ID",
 *         type="integer",
 *         description="The unique identifier for the formation level",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="NAME",
 *         type="string",
 *         description="The label/name of the formation",
 *         example="Advanced Scuba Training"
 *     ),
 *     @OA\Property(
 *         property="DESCRIPTION",
 *         type="string",
 *         description="The description of the formation",
 *         example="A complete training program for advanced scuba divers."
 *     ),
 *     @OA\Property(
 *         property="MAX_TEACHERS",
 *         type="integer",
 *         description="The maximum number of instructors allowed for the formation",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="appartients",
 *         type="array",
 *         description="The students associated with this formation",
 *         @OA\Items(
 *             ref="#/components/schemas/Signed"
 *         )
 *     ),
 *     @OA\Property(
 *         property="enseigners",
 *         type="array",
 *         description="The instructors for this formation",
 *         @OA\Items(
 *             ref="#/components/schemas/Assessment"
 *         )
 *     ),
 *     @OA\Property(
 *         property="gerer_la_formations",
 *         type="array",
 *         description="The management of this formation",
 *         @OA\Items(
 *             ref="#/components/schemas/Manager"
 *         )
 *     ),
 *     @OA\Property(
 *         property="plo_competences",
 *         type="array",
 *         description="The competencies associated with this formation",
 *         @OA\Items(
 *             ref="#/components/schemas/Skill"
 *         )
 *     ),
 *     @OA\Property(
 *         property="plo_seances",
 *         type="array",
 *         description="The sessions scheduled for this formation",
 *         @OA\Items(
 *             ref="#/components/schemas/Session"
 *         )
 *     )
 * )
 */

class PloFormationController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/formation",
     *     summary="Retrieve formations based on optional filters",
     *     description="Retrieve formations based on filters such as ID, NAME, DESCRIPTION, and MAX_TEACHERS.",
     *     operationId="getFormationRecords",
     *     tags={"Formations"},
     *
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         description="Filter by formation level (FORM_NIVEAU)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="NAME",
     *         in="query",
     *         description="Filter by formation name (FORM_LIBELLE)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="DESCRIPTION",
     *         in="query",
     *         description="Filter by formation description (FORM_DESCRIPTION)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="MAX_TEACHERS",
     *         in="query",
     *         description="Filter by maximum number of teachers (FORM_PROF_MAX)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of formations matching the filters",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Formation"
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
        // Get data in the request
        $niveau = $request->input('ID');
        $libelle = $request->input('NAME');
        $description = $request->input('DESCRIPTION');
        $profMax = $request->input('MAX_TEACHERS');

        // Query to get the formations
        $query = PloFormation::query();

        // Filter the formations
        if ($niveau) {
            $query->where('FORM_NIVEAU', $niveau);
        }
        if ($libelle) {
            $query->where('FORM_LIBELLE', 'like', $libelle . '%');
        }
        if ($description) {
            $query->where('FORM_DESCRIPTION', 'like', $description . '%');
        }
        if ($profMax) {
            $query->where('FORM_PROF_MAX', $profMax);
        }

        // Get the formations
        $formations = $query->get();

        // Return a JSON response with the list of formations
        $response = $formations->map(function ($formation) {
            return [
                'ID' => $formation->FORM_NIVEAU,
                'NAME' => $formation->FORM_LIBELLE,
                'DESCRIPTION' => $formation->FORM_DESCRIPTION,
                'MAX_TEACHERS' => $formation->FORM_PROF_MAX
            ];
        });

        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/api/formation",
     *     summary="Create a new formation",
     *     description="Creates a new formation with the provided name, description, and maximum number of professors.",
     *     operationId="createFormation",
     *     tags={"Formations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"NAME", "MAX_TEACHERS"},
     *             @OA\Property(property="NAME", type="string", description="The name of the formation", example="Niveau 1 Plongée"),
     *             @OA\Property(property="DESCRIPTION", type="string", description="The description of the formation", example="Formation de plongée pour débutants"),
     *             @OA\Property(property="MAX_TEACHERS", type="integer", description="The maximum number of professors for the formation", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Formation successfully created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Formation successfully created!"),
     *             @OA\Property(property="formation", type="object",
     *                 @OA\Property(property="ID", type="integer", example=1),
     *                 @OA\Property(property="NAME", type="string", example="Niveau 1 Plongée"),
     *                 @OA\Property(property="DESCRIPTION", type="string", example="Formation de plongée pour débutants"),
     *                 @OA\Property(property="MAX_TEACHERS", type="integer", example=3)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation errors")
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        // Get data in the request
        $libelle = $request->input('NAME');
        $description = $request->input('DESCRIPTION');
        $profMax = $request->input('MAX_TEACHERS');
        
        // Validate format of the data
        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string|max:500',
            'MAX_TEACHERS' => 'required|integer|min:1',
        ]);
    
        // Formation creation
        $formation = PloFormation::create([
            'FORM_LIBELLE' => $libelle,
            'FORM_DESCRIPTION' => $description,
            'FORM_PROF_MAX' => $profMax
        ]);
        
        // Return a JSON response with the details of the created formation
        return response()->json([
            'message' => 'Formation successfully created!',
            'formation' => [
                'ID' => $formation->FORM_NIVEAU,
                'NAME' => $formation->FORM_LIBELLE,
                'DESCRIPTION' => $formation->FORM_DESCRIPTION,
                'MAX_TEACHERS' => $formation->FORM_PROF_MAX
            ]
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/formation/{id}",
     *     summary="Update a formation",
     *     description="Updates the details of an existing formation by its level ID (FORM_NIVEAU).",
     *     operationId="updateFormation",
     *     tags={"Formations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the formation to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"NAME", "DESCRIPTION", "MAX_TEACHERS"},
     *             @OA\Property(property="NAME", type="string", description="The name of the formation", example="Niveau 1 Plongée"),
     *             @OA\Property(property="DESCRIPTION", type="string", description="The description of the formation", example="Formation de plongée pour débutants"),
     *             @OA\Property(property="MAX_TEACHERS", type="integer", description="The maximum number of professors for the formation", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formation successfully updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Formation successfully updated!"),
     *             @OA\Property(property="formation", type="object",
     *                 @OA\Property(property="ID", type="integer", example=1),
     *                 @OA\Property(property="NAME", type="string", example="Niveau 1 Plongée"),
     *                 @OA\Property(property="DESCRIPTION", type="string", example="Formation de plongée pour débutants"),
     *                 @OA\Property(property="MAX_TEACHERS", type="integer", example=3)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formation not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Formation not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation errors")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id) {
        // Get the formation by ID (FORM_NIVEAU)
        $formation = PloFormation::find($id);
    
        // Check if the formation exists
        if (!$formation) {
            return response()->json([
                'message' => 'Formation not found.'
            ], 404);
        }
    
        // Get data from the request
        $libelle = $request->input('NAME', $formation->FORM_LIBELLE);
        $description = $request->input('DESCRIPTION', $formation->FORM_DESCRIPTION);
        $profMax = $request->input('MAX_TEACHERS', $formation->FORM_PROF_MAX);
    
        // Validate format of the data
        $validated = $request->validate([
            'LIBELLE' => 'nullable|string|max:255',
            'DESCRIPTION' => 'nullable|string|max:500',
            'MAX_TEACHERS' => 'nullable|integer|min:1',
        ]);
    
        // Update formation details
        $formation->FORM_LIBELLE = $libelle;
        $formation->FORM_DESCRIPTION = $description;
        $formation->FORM_PROF_MAX = $profMax;
    
        // Save the updated formation
        $formation->save();
    
        // Return a JSON response with the updated formation details
        return response()->json([
            'message' => 'Formation successfully updated!',
            'formation' => [
                'ID' => $formation->FORM_NIVEAU,
                'NAME' => $formation->FORM_LIBELLE,
                'DESCRIPTION' => $formation->FORM_DESCRIPTION,
                'MAX_TEACHERS' => $formation->FORM_PROF_MAX
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/formation/{id}",
     *     summary="Delete a formation",
     *     description="Deletes a formation by its level ID (FORM_NIVEAU).",
     *     operationId="deleteFormation",
     *     tags={"Formations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the formation to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formation successfully deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Formation successfully deleted!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formation not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Formation not found.")
     *         )
     *     )
     * )
     */
    public function destroy($id) {
        // Get the formation by its level ID (FORM_NIVEAU)
        $formation = PloFormation::find($id);
    
        // Check if the formation exists
        if (!$formation) {
            return response()->json([
                'message' => 'Formation not found.'
            ], 404);
        }
    
        // Delete the formation
        $formation->delete();
    
        // Return a JSON response confirming the deletion
        return response()->json([
            'message' => 'Formation successfully deleted!'
        ]);
    }
}
