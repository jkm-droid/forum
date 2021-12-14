<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminNotificationsController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
    }

    //show all notifications to admins only
    public function show_all_notifications(){
//        dd(Auth::guard('admin')->user()->username);
        $notifications = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\Admin ')
            ->where('read_at', NULL)
            ->get();

        $notificationData = '';
        $dataArray = array();

        foreach ($notifications as $notification){
            $notificationData = json_decode($notification->data, true);

            $nId = $notification->id;
            $nCreation =  $notification->created_at;
            $notificationData['id'] = $nId;
            $notificationData['created_at'] = $nCreation;

            array_push($dataArray, $notificationData);
        }

//        dd($dataArray);
        return view('dashboard.notifications.index', compact('dataArray'));
    }

    /**
     * mark a single notification as read
     */
    public function mark_as_read(Request $request){
        $notification_id = $request->notification_id;
        $marked =  DB::table('notifications')
            ->where('id', $notification_id)
            ->where('read_at', NULL)
            ->update(['read_at'=>now()]);

        if ($marked)
            $status = 200;
        else
            $status = 204;

        $data = array(
            'status'=>$status,
            'message'=>'Marked as read',
        );

        return response()->json($data);
    }
}
