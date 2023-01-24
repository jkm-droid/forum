<?php

namespace App\Http\Controllers\Member;

use App\Helpers\GetRepetitiveItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    use GetRepetitiveItems;

    public function __construct(){
        $this->middleware('auth');
    }

    //show all notifications to admins only
    public function show_all_notifications(){
        $notifications = auth()->user()->unreadNotifications;

        return view('member.notifications.index', compact('notifications'))
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list());
    }

    //mark a single notification as read
    public function mark_as_read(Request $request){
        $notification_id = $request->notification_id;
        $unread = auth()->user()->unreadNotifications->where('id', $notification_id)->first();

        if ($unread){
            $unread->markAsRead();
        }

        $data = array(
            'status'=>200,
            'message'=>'Marked as read',
        );

        return response()->json($data);
    }

}
