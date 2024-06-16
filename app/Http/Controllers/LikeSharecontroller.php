<?php

namespace App\Http\Controllers;

use App\Models\LikeShare;
use Illuminate\Http\Request;

class LikeSharecontroller extends Controller
{
    //============like and unlike share post===========
    public function UnLikeshare(Request $request){
        $like = LikeShare::where('user_id', $request->user()->id) ->where('share_id', $request->share_id) ->first();
        if ($like) {
            $like->delete();
            $message = 'Unliked share post ';
        } else {
            LikeShare::create([
                'user_id' => $request->user()->id,
                'share_id' => $request->share_id,
            ]);
            $message = 'Liked share post ';
        }

        return response()->json(['success' => true, 'message' => $message], 200);
}
}
