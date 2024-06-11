<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MedaiController extends Controller
{
    public function index(){
        $photo = Media::all();
        return response()->json($photo);
    }
    public function store(Request $request)
    {
        $photo=Media::store($request);
        return ["success" => true,"data"=>$photo, "Message" =>" created successfully"];
    }
}
