<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DirigerLeClub;
use App\Http\Controllers\Controller;


class DirigerLeClubController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/leader",
     *     summary="Get Leader records based on filters",
     *     description="Retrieve the Leader records filtered by USER_ID, CLUB_ID, and START_DATE.",
     *     operationId="getDirigerLeClubRecords",
     *     tags={"Leaders"},
     *
     *     @OA\Parameter(
     *         name="USER_ID",
     *         in="query",
     *         description="Filter by USER_ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="CLUB_ID",
     *         in="query",
     *         description="Filter by CLUB_ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="START_DATE",
     *         in="query",
     *         description="Filter by START_DATE (format: YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of DirigerLeClub records matching the filters",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="USER_ID", type="integer"),
     *                 @OA\Property(property="CLUB_ID", type="integer"),
     *                 @OA\Property(property="START_DATE", type="string", format="date")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, invalid parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid date format")
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
        // Get data from the request
        $utiId = $request->input('USER_ID');
        $cluId = $request->input('CLUB_ID');
        $dirDateDebut = $request->input('START_DATE');
        
        // Query to get the "DirigerLeClub" records
        $query = DirigerLeClub::query();
        
        // Filter based on provided parameters
        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }
        if ($cluId) {
            $query->where('CLU_ID', $cluId);
        }
        if ($dirDateDebut) {
            $date = Carbon::parse($dirDateDebut);
            $query->whereDate('DIR_DATE_DEBUT', '>=', $date);
        }
        
        // Get the filtered records
        $dirigerLeClub = $query->get();
        
        // Return a JSON response with the list of records
        $result = $dirigerLeClub->map(function ($ligne) {
            return [
                'USER_ID' => $ligne->UTI_ID,
                'CLUB_ID' => $ligne->CLU_ID,
                'START_DATE' => $ligne->DIR_DATE_DEBUT ? $ligne->DIR_DATE_DEBUT->toDateString() : null
            ];
        });
        
        // Return the JSON response
        return response()->json($result);
    }
}
