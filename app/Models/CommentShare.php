<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentShare extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'share_id',
        'user_id',
        'text',
    ];
    function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    function share(){
        return $this->belongsTo(SharePosts::class,'share_id');
    }

}
