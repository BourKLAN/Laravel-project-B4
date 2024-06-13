<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class friendRequest extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'sender_id',
        'reciever_id',
    ];
    public function reciever(){
        return $this->belongsTo(User::class,'reciever_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'sender_id');
    }



}
