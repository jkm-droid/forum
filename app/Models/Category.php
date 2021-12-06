<?php

namespace App\Models;

use App\HelperFunctions\GetRepetitiveItems;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use GetRepetitiveItems;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'forum_list_id'
    ];

    /**
     * get the Forum List that owns the category
     */

    public function forumlist(){
        return $this->belongsTo(ForumList::class);
    }

    /**
     * get the topics that belongs to the category
     */
    public function topics(){
        return $this->hasMany(Topic::class);
    }

    /**
     * get all the messages for the category
     */
    public function messages(){
        return $this->hasManyThrough('App\Models\Message','App\Models\Topic');
    }

    /**
     * count all the views, likes, replies, messages in a single category
     */

    public function getMessagesCountAttribute(){
        $categories = $this->get_all_categories();

        $messageCount = 0;
        foreach ($categories as $category){
            foreach ($category->topics as $cat_topic){
                $messageCount += $cat_topic->messages->count();
            }
        }

        return $messageCount;
    }

    protected $appends = ['messages_count'];
}
