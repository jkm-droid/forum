<?php

namespace App\Models;

use App\HelperFunctions\GetRepetitiveItems;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, GetRepetitiveItems;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'username',
        'email',
        'profile_url',
        'password',
        'is_email_verified'
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
     * get the user likes
     */
    public function likes(){
        return $this->hasMany(Like::class);
    }

    /**
     * get the user views
     */
    public function views(){
        return $this->hasMany(View::class);
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
     * get viewed topics attribute
     */

    public function getViewsAttribute(){
        $user = $this->get_logged_user_details();
        return View::where('user_id', $user->id)->where('isViewed', 1)->get();
    }

    protected $appends = ['joined_date','total_messages','views'];
}
