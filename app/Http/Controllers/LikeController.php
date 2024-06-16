<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    //=======like and unlike for each post===========
    public function toggleLike(Request $request)
    {
        $userId = $request->user()->id;
        $postId = $request->post_id;

        $like = Like::where('user_id', $userId)->where('post_id', $postId)->first();

        if ($like) {
            $like->delete();
            $message = 'Like removed successfully';
        } else {
            $like = new Like();
            $like->user_id = $userId;
            $like->post_id = $postId;
            $like->save();
            $message = 'Post liked successfully';
        }

        return response()->json(['message' => $message], 200);
    }
}
