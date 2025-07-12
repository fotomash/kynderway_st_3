<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     title="Kynderway API",
 *     version="1.0.0",
 *     description="API documentation for Kynderway",
 *     @OA\License(name="MIT", url="https://opensource.org/licenses/MIT")
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="JWT based authentication"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="Operations related to authentication"
 * )
 * @OA\Tag(
 *     name="Users",
 *     description="Operations about users"
 * )
 * @OA\Tag(
 *     name="Bookings",
 *     description="Manage bookings"
 * )
 * @OA\Tag(
 *     name="Credits",
 *     description="Credit related endpoints"
 * )
 */
class ApiDocs
{
    // This class is used for OpenAPI annotations only.
}
