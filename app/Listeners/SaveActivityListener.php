<?php

namespace App\Listeners;

use App\Events\HelperEvent;
use App\Helpers\HelperService;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SaveActivityListener
{
    private $idGenerator;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(HelperService $myHelperClass)
    {
        $this->idGenerator = $myHelperClass;
    }

    /**
     * Handle the event.
     *
     * @param  HelperEvent  $event
     * @return void
     */
    public function handle(HelperEvent $event)
    {

        /**
         * save user activities in the system
         */
        $eventDetails = $event->details;
        $user = User::where('id',Auth::user()->id)->first();
        $activity = new Activity();
        $activity->user_id = $user->id;
        $activity->activity_id =  $this->idGenerator->generateUniqueId($user->username,'activities','activity_id');
        $activity->activity_body = $eventDetails['activity_body'];

        $activity->save();

    }
}
