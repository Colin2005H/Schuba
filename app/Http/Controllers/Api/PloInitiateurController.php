<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PloInitiateur;
use App\Http\Controllers\Controller;

class PloInitiateurController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/initiator",
     *     summary="Get Initiator information",
     *     description="Retrieve information about one or more initiators. Optionally filter by ID.",
     *     operationId="getInitiateur",
     *     tags={"Initiators"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         required=false,
     *         description="The ID of the initiator to filter by",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of initiators or specific initiator if ID is provided",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         properties={
     *                             @OA\Property(property="ID", type="integer", example=1)
     *                         }
     *                     )
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Invalid parameter")
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Something went wrong, please try again.")
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * )
     */
    public function get(Request $request) {
        // Get data in the request
        $id = $request->input('ID');

        // Query to get the Initiator
        $query = PloInitiateur::query();

        // Filter the Initiator
        if ($id) {
            $query->where('UTI_ID', $id);
        }

        // Get the sessions
        $initiateur = $query->get();

        // Return a JSON response with the list of sessions
        $events = $initiateur->map(function ($initiateur) {
            return [
                'ID' => $initiateur->UTI_ID,
            ];
        });

        return response()->json($events);
    }

    /**
     * @OA\Post(
     *     path="/api/initiator",
     *     summary="Create a new initiator",
     *     description="Create an initiator by associating an existing user with the initiator role using their ID.",
     *     operationId="createInitiateur",
     *     tags={"Initiators"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Initiator data to be created",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"ID"},
     *                 @OA\Property(
     *                     property="ID",
     *                     type="integer",
     *                     description="The ID of the existing user (PloUtilisateur) to associate as the initiator",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully created the initiator",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Initiator successfully created!"),
     *                         @OA\Property(
     *                             property="session",
     *                             type="object",
     *                             properties={
     *                                 @OA\Property(property="ID", type="integer", example=1)
     *                             }
     *                         )
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Validation error")
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="User not found.")
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Something went wrong, please try again.")
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * )
     */
    public function create(Request $request) {
        // Get data in the request
        $id = $request->input('ID');
    
        // Validate format of the data
        $validated = $request->validate([
            'ID' => 'required|integer|exists:plo_utilisateur,UTI_ID',
        ]);
    
        // Initiator creation
        $initiateur = PloInitiateur::create([
            'UTI_ID' => $id
        ]);
    
        // Return a JSON response with the details of the created session
        return response()->json([
            'message' => 'Initiator succesfully created !',
            'session' => [
                'ID' => $initiateur->SEA_ID,
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/initiator/{id}",
     *     summary="Delete an initiator",
     *     description="Delete an initiator by their ID.",
     *     operationId="deleteInitiateur",
     *     tags={"Initiators"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the initiator to delete",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully deleted the initiator",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Initiator successfully deleted!")
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Initiator not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Cannot find the initiator.")
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Something went wrong, please try again.")
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * )
     */
    public function delete($id) {
        // Get session by id in URL
        $initiateur = PloInitiateur::find($id);
    
        // Check if session exist
        if (!$initiateur) {
            return response()->json([
                'message' => 'Cannot find the initiator.'
            ], 404);
        }
    
        // Delete session
        $initiateur->delete();
    
        // ReReturn a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Initiator successfully deleted !'
        ]);
    }
}
