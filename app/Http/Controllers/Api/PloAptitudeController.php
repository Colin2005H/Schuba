<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloAptitude;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


class PloAptitudeController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/aptitude",
     *     summary="Retrieve a list of aptitudes",
     *     description="Fetches a list of aptitudes based on optional filters such as ID, competence ID, and name.",
     *     operationId="getAptitudes",
     *     tags={"Aptitudes"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="APT001"
     *         ),
     *         description="The ID of the aptitude to filter by"
     *     ),
     *     @OA\Parameter(
     *         name="SKILL_ID",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="CPT01"
     *         ),
     *         description="The skill ID to filter by"
     *     ),
     *     @OA\Parameter(
     *         name="NAME",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Technical Skill"
     *         ),
     *         description="The name or part of the name of the aptitude to filter by"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of aptitudes based on the filters provided",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="APT_CODE", type="string", example="APT001"),
     *                 @OA\Property(property="CPT_ID", type="string", example="CPT01"),
     *                 @OA\Property(property="APT_LIBELLE", type="string", example="Technical Skill")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid request parameters")
     *         )
     *     )
     * )
     */
    public function get(Request $request) {
        // Get data from the request
        $id = $request->input('ID');
        $cptId = $request->input('SKILL_ID');
        $libelle = $request->input('NAME');
        
        // Query to get the aptitudes
        $query = PloAptitude::query();
        
        // Filter the aptitudes
        if ($id) {
            $query->where('APT_CODE', $id);
        }
        if ($cptId) {
            $query->where('CPT_ID', $cptId);
        }
        if ($libelle) {
            $query->where('APT_LIBELLE', 'LIKE', '%' . $libelle . '%');
        }
        
        // Get the aptitudes
        $aptitudes = $query->get();
        
        // Return a JSON response with the list of aptitudes
        $aptitudeList = $aptitudes->map(function ($aptitude) {
            return [
                'APT_CODE' => $aptitude->APT_CODE,
                'CPT_ID' => $aptitude->CPT_ID,
                'APT_LIBELLE' => $aptitude->APT_LIBELLE,
            ];
        });
        
        return response()->json($aptitudeList);
    }

    /**
     * @OA\Post(
     *     path="/api/aptitude",
     *     summary="Create a new aptitude",
     *     description="Creates a new aptitude and returns the created aptitude details.",
     *     operationId="createAptitude",
     *     tags={"Aptitudes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"NAME", "SKILL_ID"},
     *             @OA\Property(property="NAME", type="string", example="Mathematics Aptitude"),
     *             @OA\Property(property="SKILL_ID", type="string", example="CPT123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Aptitude created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Aptitude successfully created!"),
     *             @OA\Property(property="aptitude", type="object",
     *                 @OA\Property(property="APT_CODE", type="string", example="APT001"),
     *                 @OA\Property(property="CPT_ID", type="string", example="CPT123"),
     *                 @OA\Property(property="APT_LIBELLE", type="string", example="Mathematics Aptitude")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid data format or missing fields.")
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        // Get data from the request
        $nom = $request->input('NAME');
        $competenceId = $request->input('SKILL_ID');

        // Validate the format of the data
        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'SKILL_ID' => 'required|string|exists:plo_competence,CPT_ID',
        ]);

        // Aptitude creation
        $aptitude = PloAptitude::create([
            'CPT_ID' => $competenceId,
            'APT_LIBELLE' => $nom,
        ]);

        // Return a JSON response with the details of the created aptitude
        return response()->json([
            'message' => 'Aptitude successfully created!',
            'aptitude' => [
                'APT_CODE' => $aptitude->APT_CODE,
                'CPT_ID' => $aptitude->CPT_ID,
                'APT_LIBELLE' => $aptitude->APT_LIBELLE,
            ]
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/aptitude/{id}",
     *     summary="Update an existing aptitude",
     *     description="Updates an existing aptitude by its ID and returns the updated aptitude details.",
     *     operationId="updateAptitude",
     *     tags={"Aptitudes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="APT001"
     *         ),
     *         description="The ID of the aptitude to update"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"NAME", "COMPETENCE_ID"},
     *             @OA\Property(property="NAME", type="string", example="Advanced Mathematics Aptitude"),
     *             @OA\Property(property="COMPETENCE_ID", type="string", example="CPT123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Aptitude updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Aptitude successfully updated!"),
     *             @OA\Property(property="aptitude", type="object",
     *                 @OA\Property(property="APT_CODE", type="string", example="APT001"),
     *                 @OA\Property(property="CPT_ID", type="string", example="CPT123"),
     *                 @OA\Property(property="APT_LIBELLE", type="string", example="Advanced Mathematics Aptitude")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aptitude not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Aptitude not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid data format or missing fields.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id) {
        // Get the aptitude by ID
        $aptitude = PloAptitude::find($id);

        // Check if the aptitude exists
        if (!$aptitude) {
            return response()->json([
                'message' => 'Aptitude not found.'
            ], 404);
        }

        // Get data from the request
        $nom = $request->input('NAME', $aptitude->APT_LIBELLE);
        $competenceId = $request->input('COMPETENCE_ID', $aptitude->CPT_ID);

        // Validate the format of the data
        $validated = $request->validate([
            'NAME' => 'nullable|string|max:255',
            'COMPETENCE_ID' => 'nullable|string|exists:plo_competence,CPT_ID',
        ]);

        // Update the aptitude
        $aptitude->APT_LIBELLE = $nom;
        $aptitude->CPT_ID = $competenceId;

        // Save modifications
        $aptitude->save();

        // Return a JSON response with the details of the updated aptitude
        return response()->json([
            'message' => 'Aptitude successfully updated!',
            'aptitude' => [
                'APT_CODE' => $aptitude->APT_CODE,
                'CPT_ID' => $aptitude->CPT_ID,
                'APT_LIBELLE' => $aptitude->APT_LIBELLE,
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/aptitude/{id}",
     *     summary="Delete an aptitude",
     *     description="Deletes an existing aptitude by its ID and returns a confirmation message.",
     *     operationId="deleteAptitude",
     *     tags={"Aptitudes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="APT001"
     *         ),
     *         description="The ID of the aptitude to delete"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Aptitude deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Aptitude successfully deleted!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aptitude not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cannot find the aptitude.")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        // Get aptitude by ID in URL
        $aptitude = PloAptitude::find($id);

        // Check if aptitude exists
        if (!$aptitude) {
            return response()->json([
                'message' => 'Cannot find the aptitude.'
            ], 404);
        }

        // Delete aptitude
        $aptitude->delete();

        // Return a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Aptitude successfully deleted!'
        ]);
    }
}
