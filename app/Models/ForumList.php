<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumList extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * get the categories that belongs to the Forum List
     */
    public function categories(){
        return $this->hasMany(Category::class)->where('status', 1);
    }

    /**
     * get all the topics for the Forum
     */
    public function topics(){
        return $this->hasManyThrough('App\Models\Topic','App\Models\Category');
    }
}
