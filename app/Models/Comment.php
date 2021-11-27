<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'author',
        'likes',
        'message_id'
    ];

    /**
     * get the message owning the comment
     */

    public function message(){
        return $this->belongsTo(Message::class);
    }
}
