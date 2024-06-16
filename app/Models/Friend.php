<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Friend extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id1',
        'user_id2',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id1');
    }
    public function user2(){
        return $this->belongsTo(User::class,'user_id2');
    }
}
