<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShowPostCommentResource;
use App\Http\Resources\ShowPostResource;
use App\Http\Resources\ShowPostResourceCollection;
use App\Http\Resources\ShowSharePostResource;
use App\Models\SharePosts;
use Illuminate\Http\Request;

class SharePostController extends Controller
{
    //========Create share posts============
    public function sharePost(Request $request)
    {
        $sharePost = new SharePosts();
        $sharePost->user_id = $request->user()->id;
        $sharePost->post_id = $request->post_id;
        $sharePost->content = $request->content;
       
        $sharePost->save();
        
        return response()->json(['success' => true, 'message'=>'Create successfully '], 200);
    }

    //======show all share of each users=========
    function showAllShare(Request $request){
        $user = $request->user();
        $posts = SharePosts::with('user')->where('user_id', $user->id)->get();
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'You have not post yet! '], 404);
        }
        // $posts=new ShowPostResource($posts);
        return new ShowPostResourceCollection($posts);
    }

    //========show each share of each user=========
    public function showSharePost(Request $request, $id)
    {
        $user = $request->user();
        $sharePost = SharePosts::with('user')->find($id);
        if (!$sharePost) {
            return response()->json([
               'message' => 'Share post not found'
            ], 404);
        }

        if ($sharePost->user_id !== $user->id) {
            return response()->json([
               'message' => 'You can not view this Post!'
            ], 403);
        }
        return response()->json(['success' => true, 'data' => $sharePost], 200);
    }
}
