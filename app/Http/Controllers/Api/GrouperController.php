<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Grouper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="Group",
 *     type="object",
 *     required={"SESS_ID", "INIT_ID", "USER_ID"},
 *     @OA\Property(
 *         property="SESS_ID",
 *         type="integer",
 *         description="The session ID (PloSeance)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="INIT_ID",
 *         type="integer",
 *         description="The initiator (teacher) user ID (PloInitiateur)",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="USER_ID",
 *         type="integer",
 *         description="The student user ID (PloEleve)",
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="PRESENT",
 *         type="boolean",
 *         description="Indicates if the student was present for the session",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="Student",
 *         type="object",
 *         description="The student (PloEleve) associated with the session",
 *         ref="#/components/schemas/Student"
 *     ),
 *     @OA\Property(
 *         property="Initiator",
 *         type="object",
 *         description="The initiator (PloInitiateur) associated with the session",
 *         ref="#/components/schemas/Initiator"
 *     ),
 *     @OA\Property(
 *         property="Session",
 *         type="object",
 *         description="The session (PloSeance) associated with the grouping",
 *         ref="#/components/schemas/Session"
 *     )
 * )
 */

class GrouperController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/group",
     *     summary="Retrieve Group records based on optional filters",
     *     description="Retrieve Group records filtered by USER_ID, INIT_ID, SESS_ID, and PRESENT status.",
     *     operationId="getGroupRecords",
     *     tags={"Groups"},
     *
     *     @OA\Parameter(
     *         name="USER_ID",
     *         in="query",
     *         description="Filter by user ID (UTI_ID)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="INIT_ID",
     *         in="query",
     *         description="Filter by initiator ID (UTI_ID_INITIATEUR)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="SESS_ID",
     *         in="query",
     *         description="Filter by session ID (SEA_ID)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="PRESENT",
     *         in="query",
     *         description="Filter by presence status (GRP_PRESENCE)",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of Group records matching the filters",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Group"
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
        $utiId = $request->input('USER_ID');
        $iniId = $request->input('INIT_ID');
        $seaId = $request->input('SESS_ID');
        $pres = $request->input('PRESENT');
    
        // Query to get the Grouper records
        $query = Grouper::query();
    
        // Filter based on provided parameters
        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }
        if ($iniId) {
            $query->where('UTI_ID_INITIATEUR', $iniId);
        }
        if ($iniId) {
            $query->where('SEA_ID', $seaId);
        }
        if ($pres !== null) {
            $pres = filter_var($pres, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $query->where('GRP_PRESENCE', $pres);
        }
    
        // Get the filtered Grouper records
        $groupers = $query->get();
    
        // Return a JSON response with the list of Grouper records
        $result = $groupers->map(function ($grouper) {
            return [
                'USER_ID' => $grouper->UTI_ID,
                'INIT_ID' => $grouper->UTI_ID_INITIATEUR,
                'SESS_ID' => $grouper->SEA_ID,
                'PRESENT' => $grouper->GRP_PRESENCE
            ];
        });
    
        // Return the JSON response
        return response()->json($result);
    }

    /**
     * @OA\Post(
     *     path="/api/group",
     *     summary="Create a group for a session",
     *     description="Creates a group for a given session, associating a user with a session and a club. Presence is also recorded.",
     *     tags={"Groups"},
     *     @OA\Parameter(
     *         name="SESS_ID",
     *         in="query",
     *         description="Session ID associated with the group",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="USER_ID",
     *         in="query",
     *         description="User ID to associate with the group",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="INIT_ID",
     *         in="query",
     *         description="Club ID of the initiator for the session",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="PRESENCE",
     *         in="query",
     *         description="Presence status of the user in the session",
     *         required=true,
     *         @OA\Schema(
     *             type="boolean",
     *             example=true
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Group successfully created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Group successfully created!"),
     *             @OA\Property(
     *                 property="session",
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", example=1),
     *                 @OA\Property(property="LOCATION_ID", type="integer", example=2),
     *                 @OA\Property(property="LEVEL", type="integer", example=3),
     *                 @OA\Property(property="START", type="string", format="date-time", example="2025-01-01T09:00:00"),
     *                 @OA\Property(property="END", type="string", format="date-time", example="2025-01-01T11:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request, validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Something went wrong, please try again.")
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        // Get data in the request
        $utiId = $request->input('USER_ID');
        $iniId = $request->input('INIT_ID');
        $seaId = $request->input('SESS_ID');
        $pres = $request->input('PRESENT');
    
        // Validate format of the data
        $validated = $request->validate([
            'SESS_ID' => 'required|integer|exists:plo_seance,SEA_ID',
            'USER_ID' => 'required|integer|exists:plo_utilisateur,UTI_ID',
            'INIT_ID' => 'required|integer|exists:plo_club,CLU_ID',
            'PRESENCE' => 'required|boolean',
        ]);
    
        // Group creation
        $seance = Grouper::create([
            'SEA_ID' => $seaId,
            'UTI_ID_INITIATEUR' => $iniId,
            'UTI_ID' => $utiId,
            'GRP_PRESENCE' => $pres
        ]);
    
        // Return a JSON response with the details of the created group
        return response()->json([
            'message' => 'Group succesfully created !',
            'session' => [
                'ID' => $seance->SEA_ID,
                'LOCATION_ID' => $seance->LI_ID,
                'LEVEL' => $seance->FORM_NIVEAU,
                'START' => $seance->SEA_DATE_DEB->toIso8601String(),
                'END' => $seance->SEA_DATE_FIN->toIso8601String()
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/group/{id}",
     *     summary="Delete a Group",
     *     description="Deletes a specific Group based on the provided ID.",
     *     tags={"Groups"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Group to delete",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully deleted the Group",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Group successfully deleted!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Group record not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Group not found."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function delete($id) {
        // Get the Group record by ID
        $teach = Grouper::find($id);
        
        // Check if the record exists
        if (!$teach) {
            return response()->json([
                'message' => 'Group not found.'
            ], 404);
        }
        
        // Delete the record
        $teach->delete();
        
        // Return a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Group successfully deleted!'
        ]);
    }
}
