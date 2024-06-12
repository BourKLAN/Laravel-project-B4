<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'recipients_id',
        'status',
    ];
    public function user(){
        return $this->belongs(User::class,'user_id','id');
    }
    
}
