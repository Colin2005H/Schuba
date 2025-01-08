<?php

namespace App\Http\Controllers\Api;

use App\Models\PloFormation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PloFormationController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/formation",
     *     summary="List filtered formations",
     *     description="Retrieve a list of formations filtered by criteria such as formation level, name, description, and maximum number of professors.",
     *     operationId="listFormations",
     *     tags={"Formations"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         description="Formation level ID to filter the results",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=2
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="NAME",
     *         in="query",
     *         description="Formation name (uses LIKE 'name%')",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Niveau 1 Plongée"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="DESCRIPTION",
     *         in="query",
     *         description="Formation description (uses LIKE 'description%')",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Formation de plongée pour débutants"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="MAX_TEACHERS",
     *         in="query",
     *         description="Maximum number of professors for the formation",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=3
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully fetched the formations matching the criteria",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="FORM_NIVEAU", type="integer", description="Formation level", example=2),
     *                 @OA\Property(property="FORM_LIBELLE", type="string", description="Formation name", example="Niveau 1 Plongée"),
     *                 @OA\Property(property="FORM_DESCRIPTION", type="string", description="Formation description", example="Formation de plongée pour débutants"),
     *                 @OA\Property(property="FORM_PROF_MAX", type="integer", description="Maximum number of professors", example=3)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Incorrect parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid parameters")
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
