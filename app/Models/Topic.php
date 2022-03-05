<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'author',
        'slug',
        'category_id'
    ];

    /**
     * get the user that owns the topic
     */

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * get the category that owns the topic
     */

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * get the messages owned by topic
     */

    public function messages(){
        return $this->hasMany(Message::class);//->where('status',1);
    }

    /**
     * get the bookmarks owned by the user
     */
    public function bookmarks(){
        return $this->hasMany(BookMark::class);
    }

    /**
     * get the tags that belongs to the topic
     */

    public function tags(){
        return $this->belongsToMany(Tag::class, 'topic_tags', 'topic_id', 'tag_id')
            ->withTimestamps();
    }

    /**
     * get the topic views
     */

    public function views(){
        return $this->hasMany(View::class);
    }

    /**
     * register topic views
     */
    public function incrementViewCount() {
        $this->views++;
        return $this->save();
    }

    /**
     * format the topic time to get minutes only
     */
    public function getFormattedTopicTimeAttribute(){
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

    protected $appends = ['formatted_topic_time'];
}
