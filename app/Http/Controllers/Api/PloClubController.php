<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloClub;
use Illuminate\Http\Request;

class PloClubController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/club",
     *     summary="Get a list of clubs",
     *     description="Fetches clubs based on the provided filters (ID or Name).",
     *     operationId="getClubs",
     *     tags={"Clubs"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         description="The ID of the club",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="NAME",
     *         in="query",
     *         description="Partial name of the club to search for",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Sports Club"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of clubs successfully fetched",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="CLU_ID", type="integer", example=1),
     *                 @OA\Property(property="CLU_NOM", type="string", example="Sports Club")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request, invalid parameters",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Invalid request parameters"
     *             )
     *         )
     *     )
     * )
     */
    public function get(Request $request) {
        // Get data from the request
        $id = $request->input('ID');
        $nom = $request->input('NAME');
    
        // Query to get the clubs
        $query = PloClub::query();
    
        // Filter the clubs
        if ($id) {
            $query->where('CLU_ID', $id);
        }
        if ($nom) {
            $query->where('CLU_NOM', 'LIKE', '%' . $nom . '%');
        }
    
        // Get the clubs
        $clubs = $query->get();
    
        // Return a JSON response with the list of clubs
        $clubList = $clubs->map(function ($club) {
            return [
                'CLU_ID' => $club->CLU_ID,
                'CLU_NOM' => $club->CLU_NOM,
            ];
        });
    
        return response()->json($clubList);
    }

    /**
     * @OA\Post(
     *     path="/api/club",
     *     summary="Create a new club",
     *     description="Creates a new club with the specified name.",
     *     operationId="createClub",
     *     tags={"Clubs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"NAME"},
     *             @OA\Property(
     *                 property="NAME",
     *                 type="string",
     *                 description="The name of the club",
     *                 example="New Club"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Club successfully created",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Club successfully created!"
     *             ),
     *             @OA\Property(
     *                 property="club",
     *                 type="object",
     *                 @OA\Property(property="CLU_ID", type="integer", example=1),
     *                 @OA\Property(property="CLU_NOM", type="string", example="New Club")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             )
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        // Get data from the request
        $nom = $request->input('NAME');
        
        // Validate the format of the data
        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
        ]);
    
        // Club creation
        $club = PloClub::create([
            'CLU_NOM' => $nom,
        ]);
    
        // Return a JSON response with the details of the created club
        return response()->json([
            'message' => 'Club successfully created!',
            'club' => [
                'CLU_ID' => $club->CLU_ID,
                'CLU_NOM' => $club->CLU_NOM,
            ]
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/club/{id}",
     *     summary="Update an existing club",
     *     description="Updates a club's name by its ID.",
     *     operationId="updateClub",
     *     tags={"Clubs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the club to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"NAME"},
     *             @OA\Property(
     *                 property="NAME",
     *                 type="string",
     *                 description="The name of the club",
     *                 example="New Club Name"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Club successfully updated",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Club successfully updated!"
     *             ),
     *             @OA\Property(
     *                 property="club",
     *                 type="object",
     *                 @OA\Property(property="CLU_ID", type="integer", example=1),
     *                 @OA\Property(property="CLU_NOM", type="string", example="New Club Name")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Club not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Club not found."
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id) {
        // Get the club by ID
        $club = PloClub::find($id);
    
        // Check if the club exists
        if (!$club) {
            return response()->json([
                'message' => 'Club not found.'
            ], 404);
        }
    
        // Get data from the request
        $nom = $request->input('NAME', $club->CLU_NOM);
        
        // Validate format of the data
        $validated = $request->validate([
            'NAME' => 'nullable|string|max:255',
        ]);
    
        // Update club
        $club->CLU_NOM = $nom;
        
        // Save modifications
        $club->save();
    
        // Return a JSON response with the details of the updated club
        return response()->json([
            'message' => 'Club successfully updated!',
            'club' => [
                'CLU_ID' => $club->CLU_ID,
                'CLU_NOM' => $club->CLU_NOM,
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/club/{id}",
     *     summary="Delete a club",
     *     description="Deletes a club by its ID.",
     *     operationId="deleteClub",
     *     tags={"Clubs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the club to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Club successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Club successfully deleted!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Club not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Club not found."
     *             )
     *         )
     *     )
     * )
     */
    public function delete($id) {
        // Get club by ID
        $club = PloClub::find($id);
    
        // Check if the club exists
        if (!$club) {
            return response()->json([
                'message' => 'Club not found.'
            ], 404);
        }
    
        // Delete the club
        $club->delete();
    
        // Return a JSON response confirming the deletion
        return response()->json([
            'message' => 'Club successfully deleted!'
        ]);
    }
}
