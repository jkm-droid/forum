<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'author',
        'likes',
        'topic_id'
    ];

    /**
     * get the user owning the message
     */

    public function user(){
        return $this->belongsTo(User::class);
    }

   /**
     * get the topic owning the message
     */

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    /**
     * get the comments / replies owned by messages
     */

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
