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


    
}
