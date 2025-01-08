<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DirigerLeClub;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="Leader",
 *     type="object",
 *     required={"STUD_ID", "CLUB_ID"},
 *     @OA\Property(
 *         property="STUD_ID",
 *         type="integer",
 *         description="The user ID of the initiator managing the club (PloInitiateur)",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="CLUB_ID",
 *         type="integer",
 *         description="The club ID (PloClub)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="START_DATE",
 *         type="string",
 *         format="date-time",
 *         description="The start date of the management of the club",
 *         example="2025-01-01T10:00:00"
 *     ),
 *     @OA\Property(
 *         property="Club",
 *         type="object",
 *         description="The club (PloClub) associated with the management",
 *         ref="#/components/schemas/Club"
 *     ),
 *     @OA\Property(
 *         property="Initiator",
 *         type="object",
 *         description="The initiator (PloInitiateur) managing the club",
 *         ref="#/components/schemas/Initiator"
 *     )
 * )
 */

class DirigerLeClubController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/leader",
     *     summary="Get Leader records based on filters",
     *     description="Retrieve the Leader records filtered by INIT_ID, CLUB_ID, and START_DATE.",
     *     operationId="getDirigerLeClubRecords",
     *     tags={"Leaders"},
     *
     *     @OA\Parameter(
     *         name="INIT_ID",
     *         in="query",
     *         description="Filter by INIT_ID",
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
     *                 ref="#/components/schemas/Leader"
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
        $utiId = $request->input('INIT_ID');
        $cluId = $request->input('CLUB_ID');
        $dirDateDebut = $request->input('START_DATE');
        
        // Query to get the "DirigerLeClub" records
        $query = DirigerLeClub::query();
        
        // Filter based on provided parameters
        if ($utiId) {
            $query->where('INIT_ID', $utiId);
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
                'INIT_ID' => $ligne->UTI_ID,
                'CLUB_ID' => $ligne->CLU_ID,
                'START_DATE' => $ligne->DIR_DATE_DEBUT ? $ligne->DIR_DATE_DEBUT->toDateString() : null
            ];
        });
        
        // Return the JSON response
        return response()->json($result);
    }

    /**
     * @OA\Post(
     *     path="/api/leader",
     *     summary="Create a new Leader record",
     *     description="Creates a new Leader record by providing user ID, club ID, and start date.",
     *     tags={"Leaders"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Leader data",
     *         @OA\JsonContent(
     *             required={"INIT_ID", "CLUB_ID", "START_DATE"},
     *             @OA\Property(
     *                 property="INIT_ID",
     *                 type="integer",
     *                 description="User ID (initiator)",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="CLUB_ID",
     *                 type="integer",
     *                 description="Club ID",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="START_DATE",
     *                 type="string",
     *                 format="date",
     *                 description="Start date of the membership",
     *                 example="2025-01-01"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created the DirigerLeClub record",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="DirigerLeClub record successfully created!"
     *             ),
     *             @OA\Property(
     *                 property="diriger_le_club",
     *                 type="object",
     *                 @OA\Property(
     *                     property="INIT_ID",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="CLUB_ID",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="START_DATE",
     *                     type="string",
     *                     format="date",
     *                     example="2025-01-01"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, validation error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="An error occurred, please try again."
     *             )
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        // Get data in the request
        $utiId = $request->input('INIT_ID');
        $cluId = $request->input('CLUB_ID');
        $dateDebut = $request->input('START_DATE');
        
        // Validate format of the data
        $validated = $request->validate([
            'INIT_ID' => 'required|integer|exists:plo_utilisateur,UTI_ID',
            'CLUB_ID' => 'required|integer|exists:plo_club,CLU_ID',
            'START_DATE' => 'required|date',
        ]);

        // DirigerLeClub creation
        $dirigerLeClub = DirigerLeClub::create([
            'UTI_ID' => $utiId,
            'CLU_ID' => $cluId,
            'DIR_DATE_DEBUT' => Carbon::parse($dateDebut)
        ]);

        // Return a JSON response with the details of the created DirigerLeClub record
        return response()->json([
            'message' => 'Leader successfully created !',
            'diriger_le_club' => [
                'STUD_ID' => $dirigerLeClub->UTI_ID,
                'CLUB_ID' => $dirigerLeClub->CLU_ID,
                'START_DATE' => $dirigerLeClub->DIR_DATE_DEBUT->toDateString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/leader/{id}",
     *     summary="Delete a Leader record",
     *     description="Deletes a Leader record by the provided user ID and club ID.",
     *     tags={"Leaders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Leader record to delete (USER_ID and CLUB_ID)",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully deleted the Leader record",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Leader record successfully deleted!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Record not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Cannot find the DirigerLeClub record."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="An error occurred, please try again."
     *             )
     *         )
     *     )
     * )
     */
    public function delete($id) {
        // Get DirigerLeClub record by ID (both USER_ID and CLUB_ID)
        $dirigerLeClub = DirigerLeClub::find($id);

        // Check if record exists
        if (!$dirigerLeClub) {
            return response()->json([
                'message' => 'Cannot find the Leader record.'
            ], 404);
        }

        // Delete the record
        $dirigerLeClub->delete();

        // Return a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Leader record successfully deleted!'
        ]);
    }
}
