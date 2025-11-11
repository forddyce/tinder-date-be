<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Like;
use App\Models\Dislike;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class LikeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/v1/people/{person}/like",
     *     summary="Like a person",
     *     tags={"Interactions"},
     *     @OA\Parameter(
     *         name="person",
     *         in="path",
     *         description="Person ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="X-Device-ID",
     *         in="header",
     *         description="Device ID",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Person liked successfully"
     *     )
     * )
     */
    public function like(Request $request, Person $person)
    {
        $deviceId = $request->header('X-Device-ID', 'default');

        $like = Like::firstOrCreate([
            'person_id' => $person->id,
            'liker_device_id' => $deviceId,
        ]);

        return response()->json([
            'message' => 'Person liked successfully',
            'like' => $like
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/v1/people/{person}/dislike",
     *     summary="Dislike a person",
     *     tags={"Interactions"},
     *     @OA\Parameter(
     *         name="person",
     *         in="path",
     *         description="Person ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="X-Device-ID",
     *         in="header",
     *         description="Device ID",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Person disliked successfully"
     *     )
     * )
     */
    public function dislike(Request $request, Person $person)
    {
        $deviceId = $request->header('X-Device-ID', 'default');

        $dislike = Dislike::firstOrCreate([
            'person_id' => $person->id,
            'disliker_device_id' => $deviceId,
        ]);

        return response()->json([
            'message' => 'Person disliked successfully',
            'dislike' => $dislike
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/v1/people/liked",
     *     summary="Get list of liked people",
     *     tags={"Interactions"},
     *     @OA\Parameter(
     *         name="X-Device-ID",
     *         in="header",
     *         description="Device ID",
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
     *         description="List of liked people"
     *     )
     * )
     */
    public function likedPeople(Request $request)
    {
        $deviceId = $request->header('X-Device-ID', 'default');

        $likedPeople = Person::whereHas('likes', function ($query) use ($deviceId) {
            $query->where('liker_device_id', $deviceId);
        })->with('likes')->paginate(10);

        return response()->json($likedPeople);
    }
}
