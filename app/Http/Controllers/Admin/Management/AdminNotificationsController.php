<?php

namespace App\Http\Controllers;

use App\Helpers\HelperService;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminNotificationsController extends Controller
{
    private $adminDetails, $activity, $idGenerator;

    public function __construct(HelperService $myHelperClass){
        $this->middleware('auth:admin');
        $this->adminDetails = $myHelperClass;
        $this->activity = $myHelperClass;
        $this->idGenerator = $myHelperClass;
    }

    //show all notifications to admins only
    public function show_all_notifications(){
        $admin = $this->adminDetails->get_logged_admin_details();

        $notifications = $admin->unreadNotifications;

        return view('dashboard.notifications.index', compact('notifications'))
            ->with('admin',$admin);
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
