<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloCompetence;
use Illuminate\Http\Request;

class PloCompetenceController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/skill",
     *     summary="Get a list of skills",
     *     description="Retrieves a list of skills based on the provided filters.",
     *     operationId="getSkills",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         description="The ID of the skill to search for",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="C1"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="LEVEL",
     *         in="query",
     *         description="The level of the skill to filter by",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=2
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="NAME",
     *         in="query",
     *         description="The name or part of the name of the skill to search for",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Scuba Diving"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of skills",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="CPT_ID", type="string", example="123"),
     *                 @OA\Property(property="LEVEL", type="integer", example=2),
     *                 @OA\Property(property="NAME", type="string", example="Basic Scuba Diving")
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
    public function get(Request $request) {
        // Get data from the request
        $id = $request->input('ID');
        $niveau = $request->input('LEVEL');
        $libelle = $request->input('NAME');
        
        // Query to get the competences
        $query = PloCompetence::query();
    
        // Filter the competences
        if ($id) {
            $query->where('CPT_ID', 'LIKE', $id, '%');
        }
        if ($niveau) {
            $query->where('FORM_NIVEAU', $niveau);
        }
        if ($libelle) {
            $query->where('CPT_LIBELLE', 'LIKE', $libelle, '%');
        }
    
        // Get the competences
        $competences = $query->get();
    
        // Return a JSON response with the list of competences
        $competenceList = $competences->map(function ($competence) {
            return [
                'CPT_ID' => $competence->CPT_ID,
                'FORM_NIVEAU' => $competence->FORM_NIVEAU,
                'CPT_LIBELLE' => $competence->CPT_LIBELLE,
            ];
        });
    
        return response()->json($competenceList);
    }

    /**
     * @OA\Post(
     *     path="/api/skill",
     *     summary="Create a new skill",
     *     description="Creates a new skill with the specified level and name.",
     *     operationId="createSkill",
     *     tags={"Skills"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"LEVEL", "NAME"},
     *             @OA\Property(property="LEVEL", type="integer", description="The level associated with the skill", example=2),
     *             @OA\Property(property="NAME", type="string", description="The name of the skill", example="Basic Scuba Diving")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Skill successfully created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Skill successfully created!"),
     *             @OA\Property(property="skill", type="object",
     *                 @OA\Property(property="CPT_ID", type="string", example="123"),
     *                 @OA\Property(property="LEVEL", type="integer", example=2),
     *                 @OA\Property(property="NAME", type="string", example="Basic Scuba Diving")
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
        // Get data from the request
        $niveauFormation = $request->input('LEVEL');
        $libelle = $request->input('NAME');
        
        // Validate format of the data
        $validated = $request->validate([
            'LEVEL' => 'required|integer|exists:plo_formation,FORM_NIVEAU',  // Ensure the formation level exists in PloFormation
            'NAME' => 'required|string|max:255',
        ]);
    
        // Competence creation
        $competence = PloCompetence::create([
            'FORM_NIVEAU' => $niveauFormation,
            'CPT_LIBELLE' => $libelle
        ]);
    
        // Return a JSON response with the details of the created competence
        return response()->json([
            'message' => 'Competence successfully created!',
            'competence' => [
                'CPT_ID' => $competence->CPT_ID,
                'LEVEL' => $competence->FORM_NIVEAU,
                'NAME' => $competence->CPT_LIBELLE,
            ]
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/skill/{id}",
     *     summary="Update a skill",
     *     description="Updates the details of an existing skill by its ID.",
     *     operationId="updateSkill",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the skill to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="C1"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"LEVEL", "NAME"},
     *             @OA\Property(property="LEVEL", type="integer", description="The level associated with the skill", example=3),
     *             @OA\Property(property="NAME", type="string", description="The name of the skill", example="Advanced Scuba Diving")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skill successfully updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Skill successfully updated!"),
     *             @OA\Property(property="skill", type="object",
     *                 @OA\Property(property="CPT_ID", type="string", example="123"),
     *                 @OA\Property(property="LEVEL", type="integer", example=3),
     *                 @OA\Property(property="NAME", type="string", example="Advanced Scuba Diving")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Skill not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Skill not found.")
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
        // Get the competence by ID
        $competence = PloCompetence::find($id);
    
        // Check if competence exists
        if (!$competence) {
            return response()->json([
                'message' => 'Competence not found.'
            ], 404);
        }
    
        // Get data from the request
        $niveauFormation = $request->input('LEVEL', $competence->FORM_NIVEAU);
        $libelle = $request->input('NAME', $competence->CPT_LIBELLE);
        
        // Validate format of the data
        $validated = $request->validate([
            'LEVEL' => 'nullable|integer|exists:plo_formation,FORM_NIVEAU',
            'NAME' => 'nullable|string|max:255',
        ]);
    
        // Update competence
        $competence->FORM_NIVEAU = $niveauFormation;
        $competence->CPT_LIBELLE = $libelle;
    
        // Save the updates
        $competence->save();
    
        // Return a JSON response with the details of the updated competence
        return response()->json([
            'message' => 'Competence successfully updated!',
            'competence' => [
                'CPT_ID' => $competence->CPT_ID,
                'LEVEL' => $competence->FORM_NIVEAU,
                'NAME' => $competence->CPT_LIBELLE,
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/skill/{id}",
     *     summary="Delete a competence",
     *     description="Deletes a competence by its ID.",
     *     operationId="deleteCompetence",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the competence to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="C1"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Competence successfully deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Competence successfully deleted!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Competence not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Competence not found.")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        // Get competence by ID
        $competence = PloCompetence::find($id);
    
        // Check if competence exists
        if (!$competence) {
            return response()->json([
                'message' => 'Competence not found.'
            ], 404);
        }
    
        // Delete competence
        $competence->delete();
    
        // Return a JSON response confirming the deletion
        return response()->json([
            'message' => 'Competence successfully deleted!'
        ]);
    }
}
