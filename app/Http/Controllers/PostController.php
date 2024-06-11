<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $post->save();

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::with('user')->find($id);
    
        if (!$post) {
            return response()->json([
               'message' => 'Post not found'
            ], 404);
        }
    
        return response()->json($post);
    }
    

    public function update(Request $request, $id)
    {

        $post = Post::find($id);
        if(!$post){
            return response()->json([
               'message' => 'Post not found'
            ], 404);
        }
        $post->title = $request->title;
        $post->content = $request->content;

        $post->save();

        return response()->json($post);
    }

    public function destroy($id)
    {
        
        $post = Post::find($id);
        if(!$post){
            return response()->json([
               'message' => 'Post not found'
            ], 404);
        }
        // Delete the image
        if ($post->img) {
            Storage::disk('public')->delete($post->img);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
