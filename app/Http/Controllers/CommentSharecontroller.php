<?php

namespace App\Http\Controllers;

use App\Models\CommentShare;
use Illuminate\Http\Request;

class CommentSharecontroller extends Controller
{
    public function CommentShare(Request $request){
        $comment = new CommentShare();
        $comment->user_id = $request->user()->id;
        $comment->share_id= $request->share_id;
        $comment->text = $request->text;
        $comment->save();
        return response()->json(['success' => true, 'message'=>'Create successfully '], 200);
    }
    public function updateComment(Request $request, string $id){
        $comment = CommentShare::find($id);
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
    public function destroyComment(Request $request, string $id){
        $comment = CommentShare::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        $user = $request->user();
        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'You cannot delete this comment'], 403);
        }
        $comment->delete();
        return response()->json(['success' => true, 'message' => 'Comment deleted successfully'], 200);

    }
}
