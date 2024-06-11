<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message'       => 'Login success',
            'data'  => $request->user(),
        ]);
    }

    public function updateProfilePicture(Request $request): JsonResponse
    {
        $user = $request->user();
    
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Update name and email if provided
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }
    
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
    
        // Update profile picture
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/profile_pictures', $filename, 'public');
    
            // Delete the old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
    
            // Save the full image path to the user's record
            $user->profile_picture = $path;
        }
    
        // Save the user
        $user->save();
    
        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $user,
        ]);
    }
    
}
