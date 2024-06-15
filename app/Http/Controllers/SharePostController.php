<?php

namespace App\Http\Controllers;

use App\Models\SharePosts;
use Illuminate\Http\Request;

class SharePostController extends Controller
{
    public function sharePost(Request $request)
    {
        $sharePost = new SharePosts();
        $sharePost->user_id = $request->user()->id;
        $sharePost->post_id = $request->post_id;
        $sharePost->content = $request->content;
       
        $sharePost->save();
        
        return response()->json(['success' => true, 'message'=>'Create successfully '], 200);
    }
}
