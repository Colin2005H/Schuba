<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PloEleve;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Student",
 *     type="object",
 *     required={"UTI_ID"},
 *     @OA\Property(
 *         property="UTI_ID",
 *         type="integer",
 *         description="The unique identifier for the student",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="plo_utilisateur",
 *         description="The user associated with this student",
 *         ref="#/components/schemas/User"
 *     ),
 *     @OA\Property(
 *         property="appartients",
 *         type="array",
 *         description="The formations the student is associated with",
 *         @OA\Items(
 *             ref="#/components/schemas/Signed"
 *         )
 *     ),
 *     @OA\Property(
 *         property="evaluers",
 *         type="array",
 *         description="The evaluations associated with this student",
 *         @OA\Items(
 *             ref="#/components/schemas/Assessment"
 *         )
 *     ),
 *     @OA\Property(
 *         property="groupers",
 *         type="array",
 *         description="The sessions this student is grouped in",
 *         @OA\Items(
 *             ref="#/components/schemas/Group"
 *         )
 *     )
 * )
 */

class PloEleveController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/student",
     *     summary="Get a list of students",
     *     description="Fetch a list of students based on optional filters (ID). If no filters are provided, it returns all students.",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="ID",
     *         in="query",
     *         description="User ID to filter the students",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully fetched the list of students",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="ID",
     *                     type="integer",
     *                     description="User ID of the student",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, invalid input parameters",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Invalid parameters"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No students found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="No students found matching the criteria."
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
     *                 example="Something went wrong, please try again."
     *             )
     *         )
     *     )
     * )
     */
    public function get(Request $request) {
        // Get data in the request
        $id = $request->input('ID');

        // Query to get the Student
        $query = PloEleve::query();

        // Filter the Stuent
        if ($id) {
            $query->where('UTI_ID', $id);
        }

        // Get the Student
        $student = $query->get();

        // Return a JSON response with the list of students
        $events = $student->map(function ($student) {
            return [
                'ID' => $student->UTI_ID,
            ];
        });

        return response()->json($events);
    }

    /**
     * @OA\Post(
     *     path="/api/student",
     *     summary="Create a new student",
     *     description="Creates a new student by providing the user ID and returns the details of the created student.",
     *     tags={"Students"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Student data",
     *         @OA\JsonContent(
     *             required={"ID"},
     *             @OA\Property(
     *                 property="ID",
     *                 type="integer",
     *                 description="User ID associated with the student",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created the student",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Student successfully created!"
     *             ),
     *             @OA\Property(
     *                 property="session",
     *                 type="object",
     *                 @OA\Property(
     *                     property="ID",
     *                     type="integer",
     *                     example=1
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
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="User ID does not exist in the database."
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
        $id = $request->input('ID');
    
        // Validate format of the data
        $validated = $request->validate([
            'ID' => 'required|integer|exists:plo_utilisateur,UTI_ID',
        ]);
    
        // Student creation
        $student = PloEleve::create([
            'UTI_ID' => $id
        ]);
    
        // Return a JSON response with the details of the created Student
        return response()->json([
            'message' => 'Student succesfully created !',
            'session' => [
                'ID' => $student->SEA_ID,
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/student/{id}",
     *     summary="Delete a student",
     *     description="Deletes a student by the given ID and returns a confirmation message.",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the student to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully deleted the student",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Student successfully deleted!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Student not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Cannot find the student."
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
        // Get Student by id in URL
        $student = PloEleve::find($id);
    
        // Check if Student exist
        if (!$student) {
            return response()->json([
                'message' => 'Cannot find the student.'
            ], 404);
        }
    
        // Delete Student
        $student->delete();
    
        // ReReturn a JSON response to confirm the deletion
        return response()->json([
            'message' => 'Student successfully deleted !'
        ]);
    }
}
