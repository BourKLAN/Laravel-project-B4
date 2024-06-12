<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function addfriend(Request $request)
    {
        $existingFriend = Friend::where('sender_id', $request->user()->id)
            ->where('recipients_id', $request->recipients_id)
            ->first();

        if ($existingFriend) {
            $existingFriend->delete();
            return response()->json(['message' => 'Friend removed successfully.'], 200);
        }

        $friend = new Friend();
        $friend->sender_id = $request->user()->id;
        $friend->recipients_id = $request->recipients_id;
        $friend->save();

        return response()->json(['message' => 'Friend added successfully.'], 201);
    }

    public function acceptFriend(Request $request, $id)
    {
        $friend = Friend::where('id', $id)
            ->where('recipients_id', $request->user()->id)
            ->first();

        if (!$friend) {
            return response()->json(['message' => 'Friend request not found.'], 404);
        }

        if ($friend->status === 'pending') {
            $friend->status = 'accepted';
            $friend->save();
            return response()->json(['message' => 'Friend request accepted.'], 200);
        }

        return response()->json(['message' => 'Friend request already processed.'], 400);
    }

}
