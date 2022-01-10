<?php

namespace App\Http\Controllers;

use App\HelperFunctions\MyHelperClass;
use App\Models\Activity;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $userDetails, $activity;

    public function __construct(MyHelperClass $myHelperClass){
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

        return view('user.activity_index', compact('activities'))
            ->with('user', $user);
    }
}
