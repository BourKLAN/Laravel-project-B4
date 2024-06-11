<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->text = $request->text;
        $comment->post_id = $request->post_id;
        $comment->save();

        return response()->json(['success' => true, 'message'=>'Create successfully '], 200);
    }
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
        if(!$comment){
            return response()->json([
               'message' => 'Comment not found'
            ], 404);
        }
        $comment->text = $request->text;
        $comment->save();

        return response()->json(['success' => true, 'message'=>'update successfully '], 200);
    }
    public function destroy(string $id)
    {
        $comment = comment::find($id);
        $comment->delete();
        return ["success" => true, "Message" =>"comment deleted successfully"];
    }
}
