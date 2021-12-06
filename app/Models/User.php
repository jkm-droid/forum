<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * get the topics owned by the user
     */
    public function topics(){
        return $this->hasMany(Topic::class);
    }

    /**
     * get the messages owned by the user
     */
    public function messages(){
        return $this->hasMany(Message::class);
    }

    /**
     * customize the created_at timestamp
     */

    public function getJoinedDateAttribute(){
        return Carbon::parse($this->created_at)->format('j M, Y');
    }

    /**
     * get the total messages for a logged users
     */

    public function getTotalMessagesAttribute(){
        $user = Auth::user()->username;

        return Message::where('author', $user)->count();
    }

    /**
     * get all notifications belonging to a user
     */
    public function getAllNotificationsAttribute(){
        return count(Auth::user()->unreadNotifications);
    }

    protected $appends = ['joined_date','total_messages','all_notifications'];
}
