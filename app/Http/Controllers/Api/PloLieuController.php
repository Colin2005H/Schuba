<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\PloLieu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PloLieuController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/location",
     *     summary="Get locations based on filters",
     *     description="This API allows you to retrieve a list of locations based on optional filters like ID, name, and type.",
     *     tags={"Locations"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         required=false,
     *         description="ID of the location",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="NAME",
     *         in="query",
     *         required=false,
     *         description="Name of the location. Use partial matching with '%' for wildcards.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="TYPE",
     *         in="query",
     *         required=false,
     *         description="Type of the location. Use partial matching with '%' for wildcards.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of locations retrieved successfully.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", example=1),
     *                 @OA\Property(property="NAME", type="string", example="Location Name"),
     *                 @OA\Property(property="TYPE", type="string", example="Location Type")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No locations found matching the criteria",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No locations found")
     *         )
     *     )
     * )
     */
    public function get(Request $request) {
        // Get data in the request
        $id = $request->input('ID');
        $name = $request->input('NAME');
        $type = $request->input('TYPE');

        // Query to get the sessions
        $query = PloLieu::query();

        // Filter the sessions
        if ($id) {
            $query->where('SEA_ID', $id);
        }
        if ($name) {
            $query->where('LI_NOM', 'LIKE', $name, '%');
        }
        if ($type) {
            $query->where('LI_TYPE', 'LIKE', $type, '%');
        }

        // Get the sessions
        $lieu = $query->get();

        // Return a JSON response with the list of sessions
        $events = $lieu->map(function ($loc) {
            return [
                'ID' => $loc->LI_ID,
                'NAME' => $loc->LI_NOM,
                'TYPE' =>$loc->LI_TYPE,
            ];
        });

        return response()->json($events);
    }

    /**
     * @OA\Post(
     *     path="/api/location",
     *     summary="Create a new location",
     *     description="This API allows you to create a new location by providing the necessary details such as the name and type of the location.",
     *     tags={"Locations"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="The necessary data to create a new location",
     *         @OA\JsonContent(
     *             required={"NAME", "TYPE"},
     *             @OA\Property(
     *                 property="NAME",
     *                 type="string",
     *                 description="The name of the location",
     *                 example="Room 101"
     *             ),
     *             @OA\Property(
     *                 property="TYPE",
     *                 type="string",
     *                 description="The type of the location",
     *                 example="Classroom"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Location created successfully!"),
     *             @OA\Property(
     *                 property="location",
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", example=1),
     *                 @OA\Property(property="NAME", type="string", example="Room 101"),
     *                 @OA\Property(property="TYPE", type="string", example="Classroom")
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
    public function create(Request $request) {
        // Get data in the request
        $nom = $request->input('NAME');
        $type = $request->input('TYPE');
    
        // Validate format of the data
        $validated = $request->validate([
            'NAME' => 'required|string',
            'TYPE' => 'required|string'
        ]);
    
        // Locaion creation
        $location = PloLieu::create([
            'LI_NOM' => $nom,
            'LI_TYPE' => $type
        ]);
    
        // Return a JSON response with the details of the created location
        return response()->json([
            'message' => 'Séance créée avec succès!',
            'location' => [
                'ID' => $location->LI_ID,
                'NAME' => $location->LI_NOM,
                'TYPE' => $location->LI_TYPE
            ]
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/location/{id}",
     *     summary="Update an existing location",
     *     description="This API allows you to update an existing location's details (name and type) by providing the location's ID.",
     *     tags={"Locations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the location to be updated",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="The new data to update the location",
     *         @OA\JsonContent(
     *             required={"NAME", "TYPE"},
     *             @OA\Property(
     *                 property="NAME",
     *                 type="string",
     *                 description="The new name of the location",
     *                 example="Room 202"
     *             ),
     *             @OA\Property(
     *                 property="TYPE",
     *                 type="string",
     *                 description="The new type of the location",
     *                 example="Lecture Hall"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Location successfully updated!"),
     *             @OA\Property(
     *                 property="location",
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", example=1),
     *                 @OA\Property(property="NAME", type="string", example="Room 202"),
     *                 @OA\Property(property="TYPE", type="string", example="Lecture Hall")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cannot find the location.")
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
    public function update(Request $request, $id) {
        // Get location by id in URL
        $location = PloLieu::find($id);
    
        // Check if session exist
        if (!$location) {
            return response()->json([
                'message' => 'Cannot find the location.'
            ], 404);
        }
    
        // Get data in the request
        $nom = $request->input('NAME', $location->LI_NOM);
        $type = $request->input('TYPE', $location->LI_TYPE);
    
        // Validate format of the data
        $validated = $request->validate([
            'NAME' => 'required|string',
            'TYPE' => 'required|string'
        ]);
    
        // Update session
        $location->LI_NOM = $nom;
        $location->LI_TYPE = $type;
    
        // Save modifications
        $location->save();
    
        // Return a JSON response with the details of the updated session
        return response()->json([
            'message' => 'Location updated successfully',
            'seance' => [
                'ID' => $location->LI_ID,
                'NAME' => $location->LI_NOM,
                'TYPE' => $location->LI_TYPE
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/location/{id}",
     *     summary="Delete a location",
     *     description="This API allows you to delete an existing location by providing the location's ID.",
     *     tags={"Locations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the location to be deleted",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Location deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cannot find the location.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request or validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The provided data is invalid")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        // Get location by id in URL
        $location = PloLieu::find($id);
    
        // Check if location exist
        if (!$location) {
            return response()->json([
                'message' => 'Cannot find the location.'
            ], 404);
        }
    
        // Delete location
        $location->delete();
    
        // ReReturn a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Location deleted successfully'
        ]);
    }
}
