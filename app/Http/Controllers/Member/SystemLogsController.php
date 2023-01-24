<?php

namespace App\Http\Controllers;

use App\Helpers\GetRepetitiveItems;
use App\Helpers\HelperService;
use App\Models\Activity;
use Illuminate\Http\Request;

class SystemLogsController extends Controller
{
    use GetRepetitiveItems;
    private $userDetails, $activity;

    public function __construct(HelperService $myHelperClass){
        $this->middleware('auth');
        $this->userDetails = $myHelperClass;
        $this->activity = $myHelperClass;
    }
    /**
     * view the various activities within the system
     */
    public function view_system_activities(){
        $user = $this->userDetails->get_logged_user_details();
        $activities = Activity::where('user_id',$user->id)->orderBy('created_at', 'desc')->get();

        return view('member.profile.activity_logs', compact('activities'))
            ->with('forum_list',$this->get_forum_list())
            ->with('user', $user);
    }
}
