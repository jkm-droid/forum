<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    /**
     * get the user that owns the like
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * get the message that owns the like
     */
    public function message(){
        return $this->belongsTo(Message::class);
    }
}
