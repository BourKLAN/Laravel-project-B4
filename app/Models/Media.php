<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'img',
        'video'
    ];
    public static function store($request, $id = null){
        $data = $request->only('img', 'video');
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = $file->storeAs('uploads/images', $filename, 'public');
            $data['img'] = Storage::url($path);
        }
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = $file->storeAs('uploads/videos', $filename, 'public');
            $data['video'] = Storage::url($path);
        }
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
        
    }

}
