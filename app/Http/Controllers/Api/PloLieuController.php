<?php

namespace App\Http\Controllers\Api;

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
}
