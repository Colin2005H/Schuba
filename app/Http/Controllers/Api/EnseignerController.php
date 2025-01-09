<?php

namespace App\Http\Controllers\Api;

use App\Models\Enseigner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnseignerController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/teaching",
     *     summary="Get Teaching records",
     *     description="Retrieve a list of Teaching records based on the provided filter criteria.",
     *     tags={"Teachings"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         description="User ID to filter by",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="LEVEL",
     *         in="query",
     *         description="Teaching level to filter by",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the list of Teaching records",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="ID",
     *                     type="integer",
     *                     description="User ID"
     *                 ),
     *                 @OA\Property(
     *                     property="LEVEL",
     *                     type="integer",
     *                     description="Teaching level"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input parameters"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function get(Request $request) {
        // Get data from the request
        $utiId = $request->input('ID');
        $formNiveau = $request->input('LEVEL');
    
        // Query to get the Teaching records
        $query = Enseigner::query();
    
        // Filter based on provided parameters
        if ($utiId) {
            $query->where('UTI_ID', $utiId);
        }
        if ($formNiveau) {
            $query->where('FORM_NIVEAU', $formNiveau);
        }
    
        // Get the filtered Teaching records
        $teach = $query->get();
    
        // Return a JSON response with the list of Teaching records
        $result = $teach->map(function ($teach) {
            return [
                'ID' => $teach->UTI_ID,
                'LEVEL' => $teach->FORM_NIVEAU
            ];
        });
    
        // Return the JSON response
        return response()->json($result);
    }

    /**
     * @OA\Post(
     *     path="/api/teaching",
     *     summary="Create a new Teaching record",
     *     description="This API allows you to create a new Teaching record by providing the necessary details such as the User ID and Training Level. The record will be validated and stored in the database, and the created record details will be returned in the response.",
     *     tags={"Teachings"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="The necessary data to create a new Teaching record",
     *         @OA\JsonContent(
     *             required={"ID", "LEVEL"},
     *             @OA\Property(
     *                 property="ID",
     *                 type="integer",
     *                 description="ID of the user associated with the teaching record",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="LEVEL",
     *                 type="integer",
     *                 description="ID of the training level associated with the teaching record",
     *                 example=2
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Teaching record created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Enseigner successfully created!"),
     *             @OA\Property(
     *                 property="enseigner",
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", example=1),
     *                 @OA\Property(property="LEVEL", type="integer", example=2)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error in the provided data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The provided data is invalid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred while creating the record")
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        // Get data from the request
        $utiId = $request->input('ID');
        $formNiveau = $request->input('LEVEL');
        
        // Validate format of the data
        $validated = $request->validate([
            'ID' => 'required|integer|exists:plo_utilisateur,UTI_ID',
            'LEVEL' => 'required|integer|exists:plo_formation,FORM_NIVEAU',
        ]);
        
        // Create a new Teaching record
        $teach = Enseigner::create([
            'UTI_ID' => $utiId,
            'FORM_NIVEAU' => $formNiveau,
        ]);
        
        // Return a JSON response with the details of the created Teaching record
        return response()->json([
            'message' => 'Enseigner successfully created!',
            'enseigner' => [
                'ID' => $teach->UTI_ID,
                'LEVEL' => $teach->FORM_NIVEAU,
            ],
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/teaching/{id}",
     *     summary="Delete a Teaching record",
     *     description="Deletes a specific Teaching record based on the provided ID.",
     *     tags={"Teachings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Teaching record to delete",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully deleted the Teaching record",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Enseigner record successfully deleted!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Teaching record not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Enseigner record not found."
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
        // Get the Enseigner record by ID
        $teach = Enseigner::find($id);
        
        // Check if the record exists
        if (!$teach) {
            return response()->json([
                'message' => 'Enseigner record not found.'
            ], 404);
        }
        
        // Delete the record
        $teach->delete();
        
        // Return a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Enseigner record successfully deleted!'
        ]);
    }
}