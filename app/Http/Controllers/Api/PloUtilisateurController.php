<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PloUtilisateur;
use App\Http\Controllers\Controller;

class PloUtilisateurController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="List filtered users",
     *     description="Retrieve a list of users filtered by criteria such as user ID, last name, first name, email, creation date, etc.",
     *     operationId="listUsers",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="u_id",
     *         in="query",
     *         description="User ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="c_id",
     *         in="query",
     *         description="Club ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's last name (uses LIKE 'name%')",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="firstname",
     *         in="query",
     *         description="User's first name (uses LIKE 'firstname%')",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email address (uses LIKE 'email%')",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="creation_date",
     *         in="query",
     *         description="User's creation date",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="birth_date",
     *         in="query",
     *         description="User's date of birth",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="level",
     *         in="query",
     *         description="User's level",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of users matching the criteria",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="u_id", type="integer"),
     *                 @OA\Property(property="c_id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="firstname", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="level", type="integer"),
     *                 @OA\Property(property="creation_date", type="string", format="date-time"),
     *                 @OA\Property(property="birth_date", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Incorrect parameters",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    function liste(Request $request) {
        $uid = $request->input('u_id');
        $cid = $request->input('c_id');
        $nom = $request->input('name');
        $prenom = $request->input('firstname');
        $mail = $request->input('email');
        $creation = $request->input('creation_date');
        $niveau = $request->input('level');
        $naissance = $request->input('birth_date');

        $query = PloUtilisateur::query();

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
        if ($creation) {
            $query->whereDate('UTI_DATE_CREATION', '=', Carbon::parse($creation)->toDateString());
        }
        if ($niveau) {
            $query->where('UTI_NIVEAU', $niveau);
        }
        if ($naissance) {
            $query->whereDate('UTI_DATE_NAISSANCE', '=', Carbon::parse($naissance)->toDateString());
        }

        $seances = $query->get();

        // format personnalisé
        $events = $seances->map(function ($seance) {
            return [
                'u_id' => $seance->UTI_ID,
                'c_id' => $seance->CLU_ID,
                'name' => $seance->UTI_NOM,
                'firstname' => $seance->UTI_PRENOM,
                'email' =>$seance->UTI_MAIL,
                'level' =>$seance->UTI_NIVEAU,
                'creation_date' => $seance->UTI_DATE_CREATION->toIso8601String(),
                'birth_date' => $seance->UTI_DATE_NAISSANCE->toIso8601String()
            ];
        });

        return response()->json($events);
    }
}
