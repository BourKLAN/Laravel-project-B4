<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharePosts extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'post_id',
        'content'
    ];

    function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    function post(){
        return $this->belongsTo(Post::class,'post_id');
    }

    function commentShare(){
        return $this->hasMany(CommentShare::class);
    }

    function likeShare(){
        return $this->hasMany(LikeShare::class);
    }
}
