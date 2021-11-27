<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug'
    ];

    /**
     * get the topics that belongs to the category
     */
    public function topics(){
        return $this->hasMany(Topic::class);
    }
}
