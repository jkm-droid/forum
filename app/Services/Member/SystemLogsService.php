<?php

namespace App\Services\Member;

use App\Helpers\GetRepetitiveItems;
use App\Helpers\AppHelperService;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SystemLogsService
{
    use GetRepetitiveItems;
    /**
     * @var AppHelperService
     */
    private $_helperService;

    public function __construct(AppHelperService $helperService)
    {
        $this->_helperService = $helperService;
    }

    public function saveSystemActivities($event){
        /**
         * save user activities in the system
         */
        $eventDetails = $event->eventDetails;
        $user = User::where('id',Auth::user()->getAuthIdentifier())->first();
        $activity = new Activity();
        $activity->user_id = $user->id;
        $activity->activity_id =  $this->_helperService->generateUniqueId($user->username,'activities','activity_id');
        $activity->activity_body = $eventDetails['activity_body'];

        $activity->save();
    }

    public function systemActivities()
    {
        $user = $this->_helperService->get_logged_user_details();
        $activities = Activity::where('user_id',$user->id)->orderBy('created_at', 'desc')->get();

        return view('member.profile.activity_logs', compact('activities'))
            ->with('forum_list',$this->get_forum_list())
            ->with('user', $user);
    }
}
