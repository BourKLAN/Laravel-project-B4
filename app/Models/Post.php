<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];
    //=============One user can post many posts ===============
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

      //=============One post has many comments ===============
    public function comments(){
        return $this->hasMany(Comment::class);
    }
     //=============One post has many likes ===============
    public function likes(){
        return $this->hasMany(Like::class);
    }
    //=============One post has many shares ===============
    public function shares(){
        return $this->hasMany(SharePosts::class);
    }
}
