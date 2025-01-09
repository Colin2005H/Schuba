<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PloInitiateur;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="Initiator",
 *     type="object",
 *     required={"ID"},
 *     @OA\Property(
 *         property="ID",
 *         type="integer",
 *         description="The unique identifier for the initiator",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="Leader",
 *         type="array",
 *         description="The clubs directed by this initiator",
 *         @OA\Items(
 *             ref="#/components/schemas/Leader"
 *         )
 *     ),
 *     @OA\Property(
 *         property="Teaching",
 *         type="array",
 *         description="The formations taught by this initiator",
 *         @OA\Items(
 *             ref="#/components/schemas/Teaching"
 *         )
 *     ),
 *     @OA\Property(
 *         property="Manager",
 *         type="array",
 *         description="The formations managed by this initiator",
 *         @OA\Items(
 *             ref="#/components/schemas/Manager"
 *         )
 *     ),
 *     @OA\Property(
 *         property="Group",
 *         type="array",
 *         description="The groups that this initiator is part of",
 *         @OA\Items(
 *             ref="#/components/schemas/Group"
 *         )
 *     ),
 *     @OA\Property(
 *         property="User",
 *         ref="#/components/schemas/User",
 *         description="The associated user for the initiator"
 *     )
 * )
 */

class PloInitiateurController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/initiator",
     *     summary="Retrieve Initiators based on optional filters",
     *     description="Retrieve Initiator records filtered by ID (UTI_ID).",
     *     operationId="getInitiatorRecords",
     *     tags={"Initiators"},
     *
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         description="Filter by initiator ID (UTI_ID)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of Initiator records matching the filters",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Initiator"
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
        $id = $request->input('ID');

        // Query to get the Initiator
        $query = PloInitiateur::query();

        // Filter the Initiator
        if ($id) {
            $query->where('UTI_ID', $id);
        }

        // Get the Initiator
        $initiator = $query->get();

        // Return a JSON response with the list of initiators
        $events = $initiator->map(function ($initiator) {
            return [
                'ID' => $initiator->UTI_ID,
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
        $initiator = PloInitiateur::create([
            'UTI_ID' => $id
        ]);
    
        // Return a JSON response with the details of the created initiator
        return response()->json([
            'message' => 'Initiator succesfully created !',
            'session' => [
                'ID' => $initiator->SEA_ID,
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
        // Get Initiator by id in URL
        $initiator = PloInitiateur::find($id);
    
        // Check if Initiator exist
        if (!$initiator) {
            return response()->json([
                'message' => 'Cannot find the initiator.'
            ], 404);
        }
    
        // Delete Initiator
        $initiator->delete();
    
        // ReReturn a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Initiator successfully deleted !'
        ]);
    }
}
