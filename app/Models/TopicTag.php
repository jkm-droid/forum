<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicTag extends Model
{
    use HasFactory;

    protected $table = "topic_tags";

    protected $fillable = [
        'topic_id',
        'tag_id'
    ];

    /**
     * get the topics belonging to the topic_tag
     */
    public function topics(){
        return $this->belongsToMany(Topic::class);
    }

    /**
     * get the tags belonging to the topic_tag
     */
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
