<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Dating App API",
 *     version="1.0.0",
 *     description="API for a Tinder-like dating application"
 * )
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local API Server"
 * )
 * @OA\Server(
 *     url="https://be-nine-flame.vercel.app/",
 *     description="Production API Server"
 * )
 */
class SwaggerController extends Controller
{
}
