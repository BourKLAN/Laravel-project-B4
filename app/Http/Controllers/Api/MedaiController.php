<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *  path="/api/me",
 *  summary="Me data",
 *  description="",
 *  tags={"Me"},
 *  @OA\Parameter(
 *      name="name",
 *      in="query",
 *      description="Provide your name",
 *      required=true,
 *  ),
 *  @OA\Response(
 *      response=200,
 *      description="OK",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *      )
 *   ),
 * )
 */

class MedaiController extends Controller
{
    public function index(){
        $photo = Media::all();
        return response()->json($photo);
    }
    public function store(Request $request)
    {
        $photo=Media::store($request);
        return ["success" => true, "Message" =>" created successfully"];
    }
}
