<?php

namespace App\Http\Controllers;


use App\Http\Resources\ImageResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use User;


class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message'       => 'Login success',
            'data'  => $request->user(),
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
        return response()->json(['success' => true, 'data' => $user], 200);
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
        return response()->json(['success' => true, 'data' =>$user],200);
    }
    
    


    
}
