<?php
namespace App\Http\Controllers;

use App\Http\Resources\ShowPostCommentResource;
use App\Models\Media;
use App\Models\Post;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $posts = Post::with('user')->where('user_id', $user->id)->get();
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'You have not post yet! '], 404);
        }
        return response()->json($posts);
    }
    
    

    public function store(Request $request)
    {   
       
        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->title = $request->title;
        $post->content = $request->content;
        if ($request->has('media_id') && $request->media_id !== null) {
            $post->media_id = $request->media_id;
        }
        $post->save();
        
        return response()->json(['success' => true, 'message'=>'Create successfully!'], 200);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $post = Post::with('user')->find($id);
        if (!$post) {
            return response()->json([
               'message' => 'Post not found'
            ], 404);
        }

        if ($post->user_id !== $user->id) {
            return response()->json([
               'message' => 'You can not view this Post!'
            ], 403);
        }
    
        $postResource = new ShowPostCommentResource($post);

        return response()->json(['success' => true, 'data' => $postResource], 200);
    }
    

    public function update(Request $request, $id)
{
    $post = Post::find($id);
    if (!$post) {
        return response()->json([
           'message' => 'Post not found'
        ], 404);
    }
    if ($request->user()->id !== $post->user_id) {
        return response()->json([
           'message' => 'You are not authorized to update this post'
        ], 403);
    }
    if ($request->has('title')) {
        $post->title = $request->title;
    }
    if ($request->has('content')) {
        $post->content = $request->content;
    }
    $post->save();
    return response()->json(['success' => true, 'message' => 'Post updated successfully'], 200);
}


public function destroy(Request $request, $id)
{

    $post = Post::find($id);
    if (!$post) {
        return response()->json([
            'message' => 'Post not found'
        ], 404);
    }
    $user = $request->user();
    if ($post->user_id !== $user->id) {
        return response()->json([
            'message' => 'You can not delete this post'
        ], 403);
    }

    $post->delete();
    return response()->json(['message' => 'Post deleted successfully'], 200);
}

}
