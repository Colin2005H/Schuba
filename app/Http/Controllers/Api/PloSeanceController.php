<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\PloSeance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="PloSeance",
 *     type="object",
 *     required={"SEA_ID", "LI_ID", "FORM_NIVEAU"},
 *     @OA\Property(
 *         property="SEA_ID",
 *         type="integer",
 *         description="The unique identifier for the session",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="LI_ID",
 *         type="integer",
 *         description="The location ID where the session takes place",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="FORM_NIVEAU",
 *         type="integer",
 *         description="The formation level associated with the session",
 *         example=101
 *     ),
 *     @OA\Property(
 *         property="SEA_DATE_DEB",
 *         type="string",
 *         format="date-time",
 *         description="The start date and time of the session",
 *         example="2025-01-10T09:00:00"
 *     ),
 *     @OA\Property(
 *         property="SEA_DATE_FIN",
 *         type="string",
 *         format="date-time",
 *         description="The end date and time of the session",
 *         example="2025-01-10T12:00:00"
 *     ),
 *     @OA\Property(
 *         property="plo_formation",
 *         ref="#/components/schemas/PloFormation",
 *         description="The formation associated with the session"
 *     ),
 *     @OA\Property(
 *         property="plo_lieu",
 *         ref="#/components/schemas/PloLieu",
 *         description="The location where the session is held"
 *     ),
 *     @OA\Property(
 *         property="evaluers",
 *         type="array",
 *         description="The evaluations for the session",
 *         @OA\Items(ref="#/components/schemas/Evaluer")
 *     ),
 *     @OA\Property(
 *         property="groupers",
 *         type="array",
 *         description="The groupings for the session",
 *         @OA\Items(ref="#/components/schemas/Grouper")
 *     )
 * )
 */

class PloSeanceController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/session",
     *     summary="Get sessions based on filters",
     *     description="Fetch a list of sessions by filtering on session ID, location ID, and start and end dates.",
     *     tags={"Sessions"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         description="Session ID to filter the results",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="LOCATION_ID",
     *         in="query",
     *         description="Location ID to filter the sessions",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="START",
     *         in="query",
     *         description="Start date to filter the sessions (format: yyyy-mm-dd or yyyy-mm-ddThh:mm:ss)",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date-time",
     *             example="2025-01-01T09:00:00"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="END",
     *         in="query",
     *         description="End date to filter the sessions (format: yyyy-mm-dd or yyyy-mm-ddThh:mm:ss)",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date-time",
     *             example="2025-01-10T11:00:00"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully fetched the sessions",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", description="Session ID", example=1),
     *                 @OA\Property(property="LOCATION_ID", type="integer", description="Location ID", example=1),
     *                 @OA\Property(property="LEVEL", type="integer", description="Training level ID", example=1),
     *                 @OA\Property(property="START", type="string", format="date-time", description="Session start date", example="2025-01-07T11:43:52+00:00"),
     *                 @OA\Property(property="END", type="string", format="date-time", description="Session end date", example="2025-02-01T12:43:52+00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, invalid input parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid parameters")
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
        $id = $request->input('ID');
        $loc = $request->input('LOCATION_ID');
        $dateDebut = $request->input('START');
        $dateFin = $request->input('END');

        // Query to get the sessions
        $query = PloSeance::query();

        // Filter the sessions
        if ($id) {
            $query->where('SEA_ID', $id);
        }
        if ($id) {
            $query->where('LI_ID', $loc);
        }
        if ($dateDebut) {
            $dateDebut = Carbon::parse($dateDebut);
            $query->where('SEA_DATE_DEB', '>=', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = Carbon::parse($dateFin);
            $query->where('SEA_DATE_FIN', '<=', $dateFin);
        }

        // Get the sessions
        $seances = $query->get();

        // Return a JSON response with the list of sessions
        $events = $seances->map(function ($seance) {
            return [
                'ID' => $seance->SEA_ID,
                'LOCATION_ID' => $seance->LI_ID,
                'LEVEL' =>$seance->FORM_NIVEAU,
                'START' => $seance->SEA_DATE_DEB->toIso8601String(),
                'END' => $seance->SEA_DATE_FIN->toIso8601String()
            ];
        });

        return response()->json($events);
    }

    /**
     * @OA\Post(
     *     path="/api/session",
     *     summary="Create a new session",
     *     description="This API allows you to create a new session by providing the necessary details such as the location, training level, and start and end dates. The session will be validated and stored in the database, and the created session details will be returned in the response.",
     *     tags={"Sessions"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="The necessary data to create a new session",
     *         @OA\JsonContent(
     *             required={"LOCATION_ID", "LEVEL", "START", "END"},
     *             @OA\Property(
     *                 property="LOCATION_ID",
     *                 type="integer",
     *                 description="ID of the location where the session is held",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="LEVEL",
     *                 type="integer",
     *                 description="ID of the training level",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="START",
     *                 type="string",
     *                 format="date-time",
     *                 description="Start date and time of the session",
     *                 example="2025-01-01T09:00:00"
     *             ),
     *             @OA\Property(
     *                 property="END",
     *                 type="string",
     *                 format="date-time",
     *                 description="End date and time of the session",
     *                 example="2025-02-01T11:00:00"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Session created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Session created successfully!"),
     *             @OA\Property(
     *                 property="session",
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", example=123),
     *                 @OA\Property(property="LOCATION_ID", type="integer", example=1),
     *                 @OA\Property(property="LEVEL", type="integer", example=2),
     *                 @OA\Property(property="START", type="string", format="date-time", example="2025-02-10T09:00:00"),
     *                 @OA\Property(property="END", type="string", format="date-time", example="2025-02-10T11:00:00")
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
        $lieuId = $request->input('LOCATION_ID');
        $niveauFormation = $request->input('LEVEL');
        $dateDebut = $request->input('START');
        $dateFin = $request->input('END');
    
        // Validate format of the data
        $validated = $request->validate([
            'LOCATION_ID' => 'required|integer|exists:plo_lieu,LI_ID',
            'LEVEL' => 'required|integer', //|exists:plo_formation,FORM_NIVEAU
            'START' => 'required|date',
            'END' => 'required|date|after_or_equal:SEA_DATE_DEB'
        ]);
    
        // Session creation
        $seance = PloSeance::create([
            'LI_ID' => $lieuId,
            'FORM_NIVEAU' => $niveauFormation,
            'SEA_DATE_DEB' => Carbon::parse($dateDebut),
            'SEA_DATE_FIN' => Carbon::parse($dateFin)
        ]);
    
        // Return a JSON response with the details of the created session
        return response()->json([
            'message' => 'Session succesfully created !',
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
     * @OA\Put(
     *     path="/api/session/{id}",
     *     summary="Update an existing session",
     *     description="This API allows you to update an existing session by providing the session ID and the details you want to modify (location, training level, start date, and end date). If no data is provided for a particular field, it will remain unchanged.",
     *     tags={"Sessions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the session to update",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         description="The data to update the session. You can provide any of the following fields. If not provided, they will remain unchanged.",
     *         @OA\JsonContent(
     *             required={},
     *             @OA\Property(
     *                 property="LOCATION_ID",
     *                 type="integer",
     *                 description="ID of the location where the session is held",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="LEVEL",
     *                 type="integer",
     *                 description="ID of the training level",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="START",
     *                 type="string",
     *                 format="date-time",
     *                 description="Start date and time of the session",
     *                 example="2025-01-01T09:00:00"
     *             ),
     *             @OA\Property(
     *                 property="END",
     *                 type="string",
     *                 format="date-time",
     *                 description="End date and time of the session",
     *                 example="2025-01-01T11:00:00"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Session updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Session updated successfully!"),
     *             @OA\Property(
     *                 property="session",
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", example=123),
     *                 @OA\Property(property="LOCATION_ID", type="integer", example=1),
     *                 @OA\Property(property="LEVEL", type="integer", example=2),
     *                 @OA\Property(property="START", type="string", format="date-time", example="2025-02-10T09:00:00"),
     *                 @OA\Property(property="END", type="string", format="date-time", example="2025-02-10T11:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Session not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cannot find the session.")
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
        // Get the id in the URL
        $seance = PloSeance::find($id);
    
        // Check if session exist
        if (!$seance) {
            return response()->json([
                'message' => 'Session not found.'
            ], 404);
        }
    
        // Get data in the request
        $lieuId = $request->input('LOCATION_ID', $seance->LI_ID);
        $niveauFormation = $request->input('LEVEL', $seance->FORM_NIVEAU);
        $dateDebut = $request->input('START', $seance->SEA_DATE_DEB);
        $dateFin = $request->input('END', $seance->SEA_DATE_FIN);
    
        // Validate format of the data
        $validated = $request->validate([
            'LI_ID' => 'nullable|integer|exists:plo_lieu,LI_ID',
            'FORM_NIVEAU' => 'nullable|integer',
            'SEA_DATE_DEB' => 'nullable|date',
            'SEA_DATE_FIN' => 'nullable|date|after_or_equal:SEA_DATE_DEB'
        ]);
    
        // Update session
        $seance->LI_ID = $lieuId;
        $seance->FORM_NIVEAU = $niveauFormation;
        $seance->SEA_DATE_DEB = $dateDebut ? Carbon::parse($dateDebut) : $seance->SEA_DATE_DEB;
        $seance->SEA_DATE_FIN = $dateFin ? Carbon::parse($dateFin) : $seance->SEA_DATE_FIN;
    
        // Save modifications
        $seance->save();
    
        // Return a JSON response with the details of the updated session
        return response()->json([
            'message' => 'Séance mise à jour avec succès!',
            'seance' => [
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
     *     path="/api/session/{id}",
     *     summary="Delete an existing session",
     *     description="This API allows you to delete an existing session by providing the session ID. If the session with the specified ID does not exist, a 404 error is returned.",
     *     tags={"Sessions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the session to delete",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Session deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Session successfully deleted!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Session not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cannot find the session.")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        // Get session by id in URL
        $seance = PloSeance::find($id);
    
        // Check if session exist
        if (!$seance) {
            return response()->json([
                'message' => 'Cannot find the session.'
            ], 404);
        }
    
        // Delete session
        $seance->delete();
    
        // ReReturn a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Session successfully deleted !'
        ]);
    }
}
