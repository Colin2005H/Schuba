<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PloUtilisateur;
use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="PloUtilisateur",
 *     type="object",
 *     required={"UTI_ID", "UTI_MAIL", "UTI_MDP", "UTI_DATE_CREATION"},
 *     @OA\Property(
 *         property="UTI_ID",
 *         type="integer",
 *         description="The unique identifier for the user",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="CLU_ID",
 *         type="integer",
 *         nullable=true,
 *         description="The ID of the club the user belongs to",
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="UTI_NOM",
 *         type="string",
 *         description="The last name of the user",
 *         example="Doe"
 *     ),
 *     @OA\Property(
 *         property="UTI_PRENOM",
 *         type="string",
 *         description="The first name of the user",
 *         example="John"
 *     ),
 *     @OA\Property(
 *         property="UTI_MAIL",
 *         type="string",
 *         description="The email address of the user",
 *         example="john.doe@example.com"
 *     ),
 *     @OA\Property(
 *         property="UTI_MDP",
 *         type="string",
 *         description="The password of the user",
 *         example="password123"
 *     ),
 *     @OA\Property(
 *         property="UTI_DATE_CREATION",
 *         type="string",
 *         format="date-time",
 *         description="The creation date of the user account",
 *         example="2025-01-08T10:00:00"
 *     ),
 *     @OA\Property(
 *         property="UTI_NIVEAU",
 *         type="string",
 *         nullable=true,
 *         description="The level of the user",
 *         example="admin"
 *     ),
 *     @OA\Property(
 *         property="UTI_DATE_NAISSANCE",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="The birth date of the user",
 *         example="1990-01-01T00:00:00"
 *     ),
 *     @OA\Property(
 *         property="plo_club",
 *         ref="#/components/schemas/PloClub",
 *         nullable=true,
 *         description="The club the user belongs to"
 *     ),
 *     @OA\Property(
 *         property="plo_eleve",
 *         ref="#/components/schemas/PloEleve",
 *         description="The student associated with the user"
 *     ),
 *     @OA\Property(
 *         property="plo_initiateur",
 *         ref="#/components/schemas/PloInitiateur",
 *         description="The initiator associated with the user"
 *     ),
 *     @OA\Property(
 *         property="validers",
 *         type="array",
 *         description="The validations associated with the user",
 *         @OA\Items(ref="#/components/schemas/Valider")
 *     )
 * )
 */

class PloUtilisateurController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="List filtered users",
     *     description="Retrieve a list of users filtered by various criteria such as user ID, last name, first name, email, creation date, etc.",
     *     operationId="listUsers",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="u_id",
     *         in="query",
     *         description="User ID to filter the results",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="c_id",
     *         in="query",
     *         description="Club ID to filter the users",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's last name (uses LIKE 'name%')",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Doe"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="firstname",
     *         in="query",
     *         description="User's first name (uses LIKE 'firstname%')",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="John"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email address (uses LIKE 'email%')",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="john.doe@example.com"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="creation_date",
     *         in="query",
     *         description="Filter users by creation date (format: yyyy-mm-dd)",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="2023-01-01"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="birth_date",
     *         in="query",
     *         description="Filter users by date of birth (format: yyyy-mm-dd)",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="1990-01-01"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="level",
     *         in="query",
     *         description="User's level",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=2
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully fetched the users matching the criteria",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="ID", type="integer", description="User ID", example=1),
     *                 @OA\Property(property="CLUB_ID", type="integer", description="Club ID", example=1),
     *                 @OA\Property(property="NAME", type="string", description="User's last name", example="Doe"),
     *                 @OA\Property(property="FIRSTNAME", type="string", description="User's first name", example="John"),
     *                 @OA\Property(property="EMAIL", type="string", description="User's email address", example="john.doe@example.com"),
     *                 @OA\Property(property="LEVEL", type="integer", description="User's level", example=2),
     *                 @OA\Property(property="BIRTH_DATE", type="string", format="date-time", description="User's date of birth", example="1990-01-01T00:00:00"),
     *                 @OA\Property(property="CREATION_DATE", type="string", format="date-time", description="User's account creation date", example="2023-01-01T12:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Incorrect or invalid parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid parameters")
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
    function get(Request $request) {
        // Get data in the request
        $uid = $request->input('ID');
        $cid = $request->input('CLUB_ID');
        $nom = $request->input('NAME');
        $prenom = $request->input('FIRSTNAME');
        $mail = $request->input('EMAIL');
        $niveau = $request->input('LEVEL');
        $creation = $request->input('CREATION_DATE');
        $naissance = $request->input('BIRTH_DATE');

        // Query to get the users
        $query = PloUtilisateur::query();

        // Filter the users
        if ($uid) {
            $query->where('UTI_ID', $uid);
        }
        if ($cid) {
            $query->where('CLU_ID', $cid);
        }
        if ($nom) {
            $query->where('UTI_NOM', 'like', $nom . '%');
        }
        if ($prenom) {
            $query->where('UTI_PRENOM', 'like', $prenom . '%');
        }
        if ($mail) {
            $query->where('UTI_MAIL', 'like', $mail . '%');
        }
        if ($niveau) {
            $query->where('UTI_NIVEAU', $niveau);
        }
        if ($creation) {
            $query->whereDate('UTI_DATE_CREATION', '=', Carbon::parse($creation)->toDateString());
        }
        if ($naissance) {
            $query->whereDate('UTI_DATE_NAISSANCE', '=', Carbon::parse($naissance)->toDateString());
        }

        // Get the list of users
        $user = $query->get();

        // Return a JSON response with the list of users
        $events = $user->map(function ($user) {
            return [
                'ID' => $user->UTI_ID,
                'CLUB_ID' => $user->CLU_ID,
                'NAME' => $user->UTI_NOM,
                'FIRSTNAME' => $user->UTI_PRENOM,
                'EMAIL' =>$user->UTI_MAIL,
                'LEVEL' =>$user->UTI_NIVEAU,
                'BIRTH_DATE' => $user->UTI_DATE_NAISSANCE->toIso8601String(),
                'CREATION_DATE' => $user->UTI_DATE_CREATION->toIso8601String()
            ];
        });

        return response()->json($events);
    }

    /**
     * @OA\Post(
     *     path="/api/user",
     *     summary="Create a new user",
     *     description="Create a new user in the system by providing user details.",
     *     operationId="createUser",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object that needs to be created",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="CLUB_ID", type="integer", description="The ID of the club the user belongs to", example=1),
     *                         @OA\Property(property="NAME", type="string", description="The last name of the user", example="Doe"),
     *                         @OA\Property(property="FIRSTNAME", type="string", description="The first name of the user", example="John"),
     *                         @OA\Property(property="EMAIL", type="string", description="The email of the user", example="johndoe@example.com"),
     *                         @OA\Property(property="PASSWORD", type="string", description="The password of the user", example="password123"),
     *                         @OA\Property(property="LEVEL", type="string", description="The level of the user", example="Beginner"),
     *                         @OA\Property(property="BIRTH_DATE", type="string", format="date", description="The birth date of the user", example="1990-01-01")
     *                     },
     *                     required={"NAME", "FIRSTNAME", "EMAIL", "PASSWORD"}
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User successfully created",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="User successfully created!"),
     *                         @OA\Property(
     *                             property="session",
     *                             type="object",
     *                             properties={
     *                                 @OA\Property(property="ID", type="integer", example=123),
     *                                 @OA\Property(property="CLUB_ID", type="integer", example=1),
     *                                 @OA\Property(property="NAME", type="string", example="Doe"),
     *                                 @OA\Property(property="FIRSTNAME", type="string", example="John"),
     *                                 @OA\Property(property="EMAIL", type="string", example="johndoe@example.com"),
     *                                 @OA\Property(property="PASSWORD", type="string", example="hashed_password"),
     *                                 @OA\Property(property="LEVEL", type="string", example="Beginner"),
     *                                 @OA\Property(property="BIRTH_DATE", type="string", format="date", example="1990-01-01"),
     *                                 @OA\Property(property="CREATION_DATE", type="string", format="date-time", example="2022-01-01T12:00:00Z")
     *                             }
     *                         )
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, if the provided data is invalid",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Validation error: Email is required.")
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict, if the email already exists",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Email already exists.")
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
        $cid = $request->input('CLUB_ID');
        $nom = $request->input('NAME');
        $prenom = $request->input('FIRSTNAME');
        $mail = $request->input('EMAIL');
        $pass = $request->input('PASSWORD');
        $niveau = $request->input('LEVEL');
        $naissance = $request->input('BIRTH_DATE');
    
        // Validate format of the data
        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'FIRSTNAME' => 'required|string|max:255',
            'EMAIL' => 'required|email|unique:plo_utilisateur,UTI_MAIL',
            'PASSWORD' => 'required|string|min:8',
            'UTI_NIVEAU' => 'nullable|string|max:255',
            'BIRTH_DATE' => 'nullable|date|before:today',
            'CLUB_ID' => 'nullable|exists:plo_club,CLU_ID'
        ]);

        date_default_timezone_set('Europe/Paris');
        $date = date('m/d/Y h:i:s a', time());
    
        // User creation
        $user = PloUtilisateur::create([
            'CLU_ID' => $cid,
            'UTI_NOM' => $nom,
            'UTI_PRENOM' => $prenom,
            'UTI_MAIL' => $mail,
            'UTI_MDP' => $pass,
            'UTI_NIVEAU' => $niveau,
            'UTI_DATE_NAISSANCE' => Carbon::parse($naissance),
            'UTI_DATE_CREATION' => Carbon::parse($date)
        ]);
    
        // Return a JSON response with the details of the created user
        return response()->json([
            'message' => 'User succesfully created !',
            'session' => [
                'ID' => $user->UTI_ID,
                'CLUB_ID' => $user->CLU_ID,
                'NAME' => $user->UTI_NOM,
                'FIRSTNAME' => $user->UTI_PRENOM,
                'EMAIL' => $user->UTI_MAIL,
                'PASSWORD' => $user->UTI_MDP,
                'UTI_NIVEAU' => $user->UTI_NIVEAU,
                'BIRTH_DATE' => $user->UTI_DATE_NAISSANCE->toIso8601String(),
                'CREATION_DATE' => $user->UTI_DATE_CREATION->toIso8601String()
            ]
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/user/{id}",
     *     summary="Update an existing user",
     *     description="Update the details of an existing user by providing their ID and the required fields.",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the user to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object that needs to be updated",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="CLUB_ID", type="integer", description="The ID of the club the user belongs to", example=1),
     *                         @OA\Property(property="NAME", type="string", description="The last name of the user", example="Doe"),
     *                         @OA\Property(property="FIRSTNAME", type="string", description="The first name of the user", example="John"),
     *                         @OA\Property(property="EMAIL", type="string", description="The email of the user", example="johndoe@example.com"),
     *                         @OA\Property(property="PASSWORD", type="string", description="The password of the user (only required if updating)", example="newpassword123"),
     *                         @OA\Property(property="LEVEL", type="string", description="The level of the user", example="Beginner"),
     *                         @OA\Property(property="BIRTH_DATE", type="string", format="date", description="The birth date of the user", example="2000-01-01")
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User successfully updated",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="User successfully updated!"),
     *                         @OA\Property(
     *                             property="user",
     *                             type="object",
     *                             properties={
     *                                 @OA\Property(property="ID", type="integer", example=123),
     *                                 @OA\Property(property="CLUB_ID", type="integer", example=1),
     *                                 @OA\Property(property="NAME", type="string", example="Doe"),
     *                                 @OA\Property(property="FIRSTNAME", type="string", example="John"),
     *                                 @OA\Property(property="EMAIL", type="string", example="johndoe@example.com"),
     *                                 @OA\Property(property="PASSWORD", type="string", example="hashed_password"),
     *                                 @OA\Property(property="LEVEL", type="string", example="Beginner"),
     *                                 @OA\Property(property="BIRTH_DATE", type="string", format="date", example="2000-01-01"),
     *                                 @OA\Property(property="CREATION_DATE", type="string", format="date-time", example="2022-01-01T12:00:00Z")
     *                             }
     *                         )
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request, if the provided data is invalid",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="Validation error: Email is required.")
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
    public function update(Request $request, $id) {
        // Get the user by ID from the URL
        $user = PloUtilisateur::find($id);
        
        // Check if the user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        // Get data from the request, with fallback to current user values if not provided
        $cid = $request->input('CLUB_ID', $user->CLU_ID);
        $nom = $request->input('NAME', $user->UTI_NOM);
        $prenom = $request->input('FIRSTNAME', $user->UTI_PRENOM);
        $mail = $request->input('EMAIL', $user->UTI_MAIL);
        $pass = $request->input('PASSWORD', $user->UTI_MDP); // Don't update password if not provided
        $niveau = $request->input('LEVEL', $user->UTI_NIVEAU);
        $naissance = $request->input('BIRTH_DATE', $user->UTI_DATE_NAISSANCE);

        // Validate format of the data
        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'FIRSTNAME' => 'required|string|max:255',
            'EMAIL' => 'required|email|unique:plo_utilisateur,UTI_MAIL,' . $user->UTI_ID, // Unique, except for this user
            'PASSWORD' => 'nullable|string|min:8', // Password is optional, only update if provided
            'UTI_NIVEAU' => 'nullable|string|max:255',
            'BIRTH_DATE' => 'nullable|date|before:today',
            'CLUB_ID' => 'nullable|exists:plo_club,CLU_ID' // Optional, if provided should be a valid club ID
        ]);

        // Update user fields
        $user->CLU_ID = $cid;
        $user->UTI_NOM = $nom;
        $user->UTI_PRENOM = $prenom;
        $user->UTI_MAIL = $mail;

        // Only update the password if a new one is provided
        if ($pass) {
            $user->UTI_MDP = bcrypt($pass); // Hash the password before saving
        }

        $user->UTI_NIVEAU = $niveau;
        $user->UTI_DATE_NAISSANCE = $naissance ? Carbon::parse($naissance) : $user->UTI_DATE_NAISSANCE;
        
        // Save the updated user
        $user->save();

        // Return a JSON response with the details of the updated user
        return response()->json([
            'message' => 'User successfully updated!',
            'user' => [
                'ID' => $user->UTI_ID,
                'CLUB_ID' => $user->CLU_ID,
                'NAME' => $user->UTI_NOM,
                'FIRSTNAME' => $user->UTI_PRENOM,
                'EMAIL' => $user->UTI_MAIL,
                'PASSWORD' => $user->UTI_MDP, // You may choose to exclude the password from the response
                'LEVEL' => $user->UTI_NIVEAU,
                'BIRTH_DATE' => $user->UTI_DATE_NAISSANCE ? $user->UTI_DATE_NAISSANCE->toIso8601String() : null,
                'CREATION_DATE' => $user->UTI_DATE_CREATION->toIso8601String()
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     summary="Delete a user",
     *     description="Delete a user from the system by providing their ID.",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the user to delete",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User successfully deleted",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="message", type="string", example="User successfully deleted!")
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
    public function delete($id){
        // Get the user by ID from the URL
        $user = PloUtilisateur::find($id);
        
        // Check if the user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }
        
        // Delete the user
        $user->delete();
        
        // Return a JSON response to confirm the deletion
        return response()->json([
            'message' => 'User successfully deleted!'
        ]);
    }
}
