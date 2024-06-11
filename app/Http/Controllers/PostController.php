<?php
namespace App\Http\Controllers;

use App\Http\Resources\ShowPostCommentResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->title = $request->title;
        $post->content = $request->content;
        if($request->has('media_id')) {
            $post->media_id = $request->media_id;
        }
        $post->save();
        
        return response()->json(['success' => true, 'message'=>'Create successfully!'], 200);
    }

    public function show($id)
    {
        $post = Post::with('user')->find($id);
        
        if (!$post) {
            return response()->json([
               'message' => 'Post not found'
            ], 404);
        }
        $post=new ShowPostCommentResource($post);
        return response()->json(['success' => true, 'data' => $post], 200);
    }
    

    public function update(Request $request, $id)
    {

        $post = Post::find($id);
        
        if(!$post){
            return response()->json([
               'message' => 'Post not found'
            ], 404);
        }
        if($request->has('title')) {
            $post->title = $request->title;
        }
    
        if($request->has('content')) {
            $post->content = $request->content;
        }
        $post->save();
        return response()->json(['success' => true, 'message'=>'update successfully '], 200);
    }

    public function destroy($id)
    {
        
        $post = Post::find($id);
        if(!$post){
            return response()->json([
               'message' => 'Post not found'
            ], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully 1']);
    }
}
