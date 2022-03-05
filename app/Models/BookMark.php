<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'user_id',
        'message_id',
    ];

    /**
     * get the user who owns bookmarks
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * get the topic who owns bookmarks
     */
    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    /**
     * get the message who owns bookmarks
     */
    public function message(){
        return $this->belongsTo(Message::class);
    }

}
