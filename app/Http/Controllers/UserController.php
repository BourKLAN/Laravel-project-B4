<?php

namespace App\Http\Controllers;


use App\Http\Resources\ImageResource;
use App\Http\Resources\ViewProfileResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;




class UserController extends Controller
{

    // ===========display profile for user after login===========
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message'       => 'Login success',
            'data'  => $request->user(),
        ]);
    }

    //===========view profile for user after login===========
    public function myProfile(Request $request)
{
    $userInformation = $request->user();
    $userInformation = new ViewProfileResource($userInformation);
    return response()->json([
        'data' => $userInformation,
    ]);
}

//===========update profile picture for user after login===========
public function uploadProfilePicture(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validateUser->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 422);
        }
        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path() . '/uploads/', $imageName);

        try {
            $user = $request->user()->id;
            $user->update([
                'image' => $imageName
            ]);
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Profile updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }



//===========update profile  for user after login===========
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
