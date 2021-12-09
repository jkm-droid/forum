<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id'
    ];

    /**
     * get the user that owns the view
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * get the topic that owns the view
     */
    public function topic(){
        return $this->belongsTo(Topic::class);
    }
}
