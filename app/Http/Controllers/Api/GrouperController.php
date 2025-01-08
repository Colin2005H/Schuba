<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Grouper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GrouperController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/group",
     *     summary="Get group records",
     *     description="Retrieves group records based on optional filters for user, initiator, session, and presence status.",
     *     tags={"Groups"},
     *     @OA\Parameter(
     *         name="USER_ID",
     *         in="query",
     *         description="User ID to filter group by user",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="INIT_ID",
     *         in="query",
     *         description="Initiator ID to filter group by initiator",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="SESS_ID",
     *         in="query",
     *         description="Session ID to filter group by session",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="PRESENT",
     *         in="query",
     *         description="Presence status of the user in the session",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean",
     *             example=true
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved group records",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="USER_ID", type="integer", example=1),
     *                 @OA\Property(property="INIT_ID", type="integer", example=1),
     *                 @OA\Property(property="SESS_ID", type="integer", example=1),
     *                 @OA\Property(property="PRESENT", type="boolean", example=true)
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
        if (isset($pres)) {
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
}
