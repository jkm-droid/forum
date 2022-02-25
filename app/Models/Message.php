<?php

namespace App\Models;

use Carbon\Carbon;
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

    /**
     * get the message likes
     */

    public function likes(){
        return $this->hasMany(Like::class);
    }

    /**
     * format the message time to get minutes only
     */
    public function getFormattedMessageTimeAttribute(){
        $created_time = Carbon::parse($this->created_at);
        $current_time = Carbon::now();
        $diff_time = $created_time->diffInMinutes($current_time);

        if ($diff_time < 50){
            $min = " minutes ago";
            $my_time = $diff_time .''. $min;
        }else{
            $my_time = Carbon::parse($this->created_at)->format('j M, `y');
        }

        return $my_time;
    }

    protected $appends = ['formatted_message_time'];
}
