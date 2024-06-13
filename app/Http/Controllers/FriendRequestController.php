<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendRequestResource;
use App\Http\Resources\ShowFriendResource;
use App\Http\Resources\ShowSenderResource;
use App\Models\Friend;
use App\Models\User;
use App\Models\friendRequest;
use Illuminate\Http\Request;


class FriendRequestController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $friendRequests = FriendRequest::with(['user'])->where('sender_id', $userId)->get();

        if ($friendRequests->isEmpty()) {
            return response()->json([
                'message' => 'You do not request friend yet'
            ]);
        }
        $friendRequests=FriendRequestResource::collection($friendRequests);
        return response()->json(['success' => true,'message'=>'All friends that I have request...', 'data' => $friendRequests], 200);
    }
    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $receiverId = $request->reciever_id;
        $friendRequest = FriendRequest::where('sender_id', $userId)->where('reciever_id', $receiverId)->first();
        if ($friendRequest) {
            $friendRequest->delete();
            return response()->json(['success' => true, 'message' => "Friend request canceled"], 200);
        }
        $friendRequest = new FriendRequest();
        $friendRequest->sender_id = $userId;
        $friendRequest->reciever_id = $receiverId;
        $friendRequest->status = "pending";
        $friendRequest->save();

        return response()->json(['success' => true, 'message' => "Friend request sent successfully"], 200);
    }

    public function DisplayRequestFriend(Request $request)
    {
        $userId = $request->user()->id;
        $friendRequests = FriendRequest::with(['reciever'])->where('reciever_id', $userId)->get();

        if ($friendRequests->isEmpty()) {
            return response()->json([
                'message' => 'No friend requests'
            ]);
        }
        $friendRequests=ShowSenderResource::collection($friendRequests);
        return response()->json(['success' => true,'message'=>'Friend that have request...', 'data' => $friendRequests], 200);
    }

    public function handleRequestFriend(Request $request)
    {
        $request_id=$request->request_id;
        
        $friendRequest = FriendRequest::find($request_id);
        // return $friendRequest;
        if (!$friendRequest) {
            return response()->json(['error' => 'Friend request not found'], 404);
        }

        if ($request->status== 'accept') {
            Friend::create([
                'user_id1' => $friendRequest->sender_id,
                'user_id2' => $friendRequest->reciever_id,
            ]);
            $friendRequest->delete();

            return response()->json(['message' => 'Friend request accepted and friendship created successfully'], 200);
        } elseif ($request->status== 'decline') {

            $friendRequest->delete();

            return response()->json(['message' => 'Friend request declined'], 200);
        }
}

public function unfriend(Request $request)
{
    $userId = $request->user()->id;
    //($friendId) request friend that you want to unfriend==========
    $friendId = $request->friend_id;

    $friendship = Friend::where(function($query) use ($userId, $friendId) {
        $query->where('user_id1', $userId)->where('user_id2', $friendId);
    })->orWhere(function($query) use ($userId, $friendId) {
        $query->where('user_id1', $friendId)->where('user_id2', $userId);
    })->first();
    
    if ($friendship) {
        $friendship->delete(); 
        return response()->json([
            'success' => true,
            'message' => 'Unfriend successfully! '
        ], 200);
    } else {
        return response()->json([
            'error' => 'This account is not your friend.'
        ], 404);
    }
}


//Get Friend of each User================================
public function getFriends(Request $request)
    {
        $userId = $request->user()->id;

        $friendships = Friend::where('user_id1', $userId) ->orWhere('user_id2', $userId)->get();
        

        foreach ($friendships as $friendship) {
            if ($friendship->user_id1 == $userId) {
                $friendIds[] = $friendship->user_id2;
            } else {
                $friendIds[] = $friendship->user_id1;
            }
        }
       $countFriends = count($friendIds);
        $friends = User::whereIn('id', $friendIds)->get();
        $friends=ShowFriendResource::collection($friends);
        return response()->json(['success' => true, 'message'=>'Here is your friends.','Data' => $friends,'count_friend'=>$countFriends], 200);
    }


}