<?php
namespace App\Http\Controllers;

use App\Http\Resources\ShowPostCommentResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    //=====show all post =========
    public function index(Request $request)
    {
        $user = $request->user();
        $posts = Post::with('user')->where('user_id', $user->id)->get();
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'You have not post yet! '], 404);
        }
        return response()->json($posts);
    }
    
    /**
 * @OA\Post(
 *     path="/api/post/create",
 *     summary="Create a new post",
 *     description="Create a new post for the authenticated user.",
 *     operationId="createPost",
 *     tags={"Posts"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             required={"title", "content"},
 *             @OA\Property(property="title", type="string", example="New Post Title"),
 *             @OA\Property(property="content", type="string", example="This is the content of the new post.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Create successfully!")
 *         )
 *     )
 * )
 */
//=====create a new post===========
    public function store(Request $request)
    {
        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        
        return response()->json(['success' => true, 'message'=>'Create successfully!'], 200);
    }

    //======show a single post=========
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
    
//=================update post==============
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

//===========destroy post =============================
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
