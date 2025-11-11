<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Like;
use App\Models\Dislike;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class PersonController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/people/recommended",
     *     summary="Get recommended people",
     *     tags={"People"},
     *     @OA\Parameter(
     *         name="X-Device-ID",
     *         in="header",
     *         description="Device ID for tracking likes/dislikes",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of recommended people"
     *     )
     * )
     */
    public function recommended(Request $request)
    {
        $deviceId = $request->header('X-Device-ID', 'default');
        
        $likedIds = Like::where('liker_device_id', $deviceId)->pluck('person_id');
        $dislikedIds = Dislike::where('disliker_device_id', $deviceId)->pluck('person_id');
        $excludedIds = $likedIds->merge($dislikedIds);

        $people = Person::whereNotIn('id', $excludedIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($people);
    }
}
