<?php

namespace App\Http\Controllers;

use App\Events\AdminEvent;
use App\Events\HelperEvent;
use App\Events\MemberEvent;
use App\HelperFunctions\GetRepetitiveItems;
use App\HelperFunctions\MyHelperClass;
use App\Jobs\AdminJob;
use App\Jobs\NewMessageJob;
use App\Models\Activity;
use App\Models\Admin;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\TopicTag;
use App\Models\User;
use App\Models\View;
use App\Notifications\AdminNotification;
use App\Notifications\MessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PortalController extends Controller
{
    use GetRepetitiveItems;
    private $userDetails, $activity, $idGenerator;

    public function __construct(MyHelperClass $myHelperClass){
        $this->middleware('auth');
        $this->special_character = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", ",", "/", "{", "}", "[", "]", "?");
        $this->userDetails = $myHelperClass;
        $this->activity = $myHelperClass;
        $this->idGenerator = $myHelperClass;
    }

}
