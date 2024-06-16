<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //============create comment============
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->text = $request->text;
        $comment->post_id = $request->post_id;
        $comment->save();
        
        return response()->json(['success' => true, 'message'=>'Create successfully '], 200);
    }

    //==============update comment==============
    public function update(Request $request, string $id)
{

    $comment = Comment::find($id);
    if (!$comment) {
        return response()->json([
            'message' => 'Comment not found'
        ], 404);
    }
    $user = $request->user();
    if ($comment->user_id !== $user->id) {
        return response()->json([
            'message' => 'You can not update this comment'
        ], 403);
    }

    $comment->text = $request->text;
    $comment->save();

    // Return a success response
    return response()->json(['success' => true, 'message' => 'Comment updated successfully'], 200);
}
//===========destroy comment================
public function destroy(Request $request, string $id)
{
    $comment = Comment::find($id);
    if (!$comment) {
        return response()->json([
            'message' => 'Comment not found'
        ], 404);
    }
    $user = $request->user();
    if ($comment->user_id !== $user->id) {
        return response()->json([
            'message' => 'You can not delete this comment'
        ], 403);
    }
    $comment->delete();
    return response()->json(['success' => true, 'message' => 'Comment deleted successfully'], 200);
}

}
