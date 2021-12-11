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
        return $this->belongsTo(ForumList::class, 'forum_list_id');
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

    /**
     * get category topic count
     */
    public function getTopicCountAttribute(){
        $categories = $this->get_all_categories();
        $topic_count = 0;
        foreach ($categories as $category){
            $topic_count = $this->thousandsCurrencyFormat($category->topics->count());
        }

        return $topic_count;
    }

    protected $appends = ['messages_count','topic_count'];

    /**
     * @param $num
     * @return string
     * format large number (thousands) to k,m,b format
     */
    public static function thousandsCurrencyFormat($num) {

        if($num>1000) {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;

        }

        return $num;
    }

}
