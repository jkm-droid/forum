<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'activity_body'
    ];

    /**
     * get the user that owns the activity
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
