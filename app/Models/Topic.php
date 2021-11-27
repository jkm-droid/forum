<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'author',
        'slug'
    ];

    /**
     * get the category that owns the topic
     */

    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * get the messages owned by topic
     */

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
