<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendRequestResource;
use App\Http\Resources\ShowFriendResource;
use App\Http\Resources\ShowSenderResource;
use App\Models\Friend;
use App\Models\FriendRequests;
use App\Models\User;
use App\Models\friendRequest;
use Illuminate\Http\Request;


class FriendRequestController extends Controller
{
    //==============List all people that I have request to============
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $friendRequests = FriendRequests::with(['user'])->where('sender_id', $userId)->get();
        
        if ($friendRequests->isEmpty()) {
            return response()->json([
                'message' => 'You do not request friend yet'
            ]);
        }
        $friendRequests=FriendRequestResource::collection($friendRequests);
        return $friendRequests;
        // return response()->json(['success' => true,'message'=>'All friends that I have request...', 'data' => $friendRequests], 200);
    }
//============= Add friend or send request===========
    public function addFriend(Request $request)
{
    $userId = $request->user()->id;
    $receiverId = $request->reciever_id;

    // ==========find who have been friend no need to request again=========
    $existingFriend = Friend::where(function($query) use ($userId, $receiverId) {
        $query->where('user_id1', $userId)->where('user_id2', $receiverId);
    })->orWhere(function($query) use ($userId, $receiverId) {
        $query->where('user_id1', $receiverId)->where('user_id2', $userId);
    })->first();

    if ($existingFriend) {
        return response()->json(['success' => false, 'message' => 'You are already friends'], 200);
    }
    //=======Find who have request friend======
    $friendRequest = FriendRequests::where('sender_id', $userId)->where('reciever_id', $receiverId)->first();
    if ($friendRequest) {
        return response()->json(['success' => true, 'message' => 'Friend request already sent'], 200);
    }
    //=====request friend======
    $friendRequest = new FriendRequests();
    $friendRequest->sender_id = $userId;
    $friendRequest->reciever_id = $receiverId;
    $friendRequest->status = "pending";
    $friendRequest->save();

    return response()->json(['success' => true, 'message' => 'Friend request sent successfully'], 200);
}


    //==============List all people that have request friend to me=============
    public function displayRequestFriend(Request $request)
    {
        $userId = $request->user()->id;
        $friendRequests = FriendRequests::with(['receiver'])->where('reciever_id', $userId)->get();
        if ($friendRequests->isEmpty()) {
            return response()->json([
                'message' => 'No friend requests'
            ]);
        }
        $friendRequests=ShowSenderResource::collection($friendRequests);
        return response()->json(['success' => true,'message'=>'Friend that have request...', 'data' => $friendRequests], 200);
    }

    //=====Handel request friend it mean that I can accept or decline a friend request that I want======
    public function handleRequestFriend(Request $request)
    {
        $request_id=$request->request_id;
        
        $friendRequest = FriendRequests::find($request_id);
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
//===========Unfriend for each user=========
public function unfriend(Request $request)
{
    $userId = $request->user()->id;
    //($friendId) request friend that you want to unfriend==========
    $friendId = $request->user_id;

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


//=============Get all friend that I have================================
public function getFriends(Request $request)
{
    $userId = $request->user()->id;

    $friendships = Friend::where('user_id1', $userId)
        ->orWhere('user_id2', $userId)
        ->get();

    $friendIds = []; // Initialize the $friendIds array

    foreach ($friendships as $friendship) {
        if ($friendship->user_id1 == $userId) {
            $friendIds[] = $friendship->user_id2;
        } else {
            $friendIds[] = $friendship->user_id1;
        }
    }

    $countFriends = count($friendIds);

    // Check if $friendIds is empty
    if ($countFriends == 0) {
        return response()->json([
            'message' => 'No friends yet.',
            'count_friend' => 0
        ], 401);
    }

    $friends = User::whereIn('id', $friendIds)->get();
    $friends = ShowFriendResource::collection($friends);

    return response()->json([
        'success' => true,
        'message' => 'Here are your friends.',
        'Data' => $friends,
        'count_friend' => $countFriends
    ], 200);
}



}