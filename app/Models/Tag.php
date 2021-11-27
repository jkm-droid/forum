<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug'
    ];

    /**
     * get the topics that belongs to the tag
     */

    public function topics(){
        return $this->belongsToMany(Topic::class, 'topic_tags', 'tag_id', 'topic_id')
            ->withTimestamps();
    }
}
