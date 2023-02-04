<?php

namespace App\Listeners;

use App\Events\AppHelperEvent;
use App\Helpers\AppHelperService;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SaveActivityListener implements ShouldQueue
{
    /**
     * @var AppHelperService
     */
    private $_helperService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AppHelperService $helperService)
    {
        $this->_helperService = $helperService;
    }

    /**
     * Handle the event.
     *
     * @param  AppHelperEvent  $event
     * @return void
     */
    public function handle(AppHelperEvent $event)
    {
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
}
