<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Schuba API",
 *     description="API for managing diving club activities",
 *     version="0.9.0",
 *     @OA\Contact(
 *         name="Groupe 1"
 *     )
 * )
 * 
 * @OA\Tag(
 *     name="Aptitudes",
 *     description="Manage aptitudes"
 * )
 * @OA\Tag(
 *     name="Assessment",
 *     description="Manage student assessment"
 * )
 * @OA\Tag(
 *     name="Clubs",
 *     description="Manage clubs"
 * )
 * @OA\Tag(
 *     name="Formations",
 *     description="Manage formations"
 * )
 * 
 * @OA\Tag(
 *     name="Groups",
 *     description="Manage group (initiator with student in location)"
 * )
 * 
 * @OA\Tag(
 *     name="Initiators",
 *     description="Manage initiators/teachers"
 * )
 * 
 * @OA\Tag(
 *     name="Leaders",
 *     description="Manage club leaders"
 * )
 * 
 * @OA\Tag(
 *     name="Locations",
 *     description="Manage diving locations"
 * )
 * 
 * @OA\Tag(
 *     name="Managers",
 *     description="Manage formation managers"
 * )
 * 
 * @OA\Tag(
 *     name="Sessions",
 *     description="Manage training sessions"
 * )
 * 
 * @OA\Tag(
 *     name="Signeds",
 *     description="Manage signeds student in formation"
 * )
 * 
 * @OA\Tag(
 *     name="Skills",
 *     description="Manage skills (group of aptitudes)"
 * )
 * 
 * @OA\Tag(
 *     name="Students",
 *     description="Manage students"
 * )
 * 
 * @OA\Tag(
 *     name="Teachings",
 *     description="Manage teachings (initiator formation afectation)"
 * )
 * 
 * @OA\Tag(
 *     name="Users",
 *     description="Manage users"
 * )
 * 
 * @OA\Tag(
 *     name="Validates",
 *     description="Manage student validation of skills"
 * )
 * 
 */

class SwaggerController extends Controller {
    //
}
