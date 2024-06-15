<?php

namespace App\Http\Controllers;

use App\Models\LikeShare;
use Illuminate\Http\Request;

class LikeSharecontroller extends Controller
{
    public function Likeshare(Request $request){
        $like = new LikeShare();
        $like->user_id = $request->user()->id;
        $like->share_id = $request->share_id;
        $like->save();
        return response()->json(['success' => true, 'message'=>' Create successfully '], 200);
    }
    public function UnLikeshare(Request $request){
        $like = LikeShare::where('user_id', $request->user()->id) ->where('share_id', $request->share_id) ->first();
        if ($like) {
            $like->delete();
            $message = 'Share post  unliked';
        } else {
            LikeShare::create([
                'user_id' => $request->user()->id,
                'share_id' => $request->share_id,
            ]);
            $message = 'Share post liked';
        }

        return response()->json(['success' => true, 'message' => $message], 200);
}
}
