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

        return response()->json($comment, 201);
    }
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
        $comment->text = $request->text;
        $comment->save();

        return response()->json($comment, 201);
    }
    public function destroy(string $id)
    {
        $comment = comment::find($id);
        $comment->delete();
        return ["success" => true, "Message" =>"comment deleted successfully"];
    }
}
