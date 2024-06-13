<?php

namespace App\Http\Controllers;


use App\Http\Resources\ImageResource;
use App\Http\Resources\ViewProfileResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message'       => 'Login success',
            'data'  => $request->user(),
        ]);
    }
    public function myProfile(Request $request)
{
    $userInformation = $request->user();
    $userInformation = new ViewProfileResource($userInformation);
    return response()->json([
        'data' => $userInformation,
    ]);
}

    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();  // Get the authenticated user
    
        $validatedData = $request->validate([
            'media_id' => 'required|integer',
        ]);
    
        // Update the user's media_id
        $user->media_id = $validatedData['media_id'];
        $user->save();
        $user=new ImageResource($user);
        return response()->json(['success' => true,'message'=>'Update Profile Picture Successfully!'], 200);
    }

    public function updateProfile(Request $request){
        $user = Auth::user();         
        if($request->has('name')) {
            $user->name=$request->name;
        }
    
        if($request->has('email')) {
            $user->email=$request->email;
        }
        $user->save();
        return response()->json(['success' => true, 'message'=>"Update User Successfully"],200);
    }
    
    
}
