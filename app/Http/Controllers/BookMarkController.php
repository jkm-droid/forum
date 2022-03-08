<?php

namespace App\Http\Controllers;

use App\Events\HelperEvent;
use App\HelperFunctions\GetRepetitiveItems;
use App\HelperFunctions\MyHelperClass;
use App\Models\BookMark;
use App\Models\User;
use Illuminate\Http\Request;

class BookMarkController extends Controller
{
    use GetRepetitiveItems;

    private $userDetails, $idGenerator, $messages;

    public function __construct(MyHelperClass $myHelperClass){
        $this->middleware('auth');
        $this->userDetails = $myHelperClass;
        $this->messages = $myHelperClass;
        $this->idGenerator = $myHelperClass;
    }

    /**
     * bookmark topic and messages
     */
    public function bookmark_topic_message(Request $request){
        if ($request->ajax()){
            $user = $this->userDetails->get_logged_user_details();
            $bookmark = new BookMark();
            $bookmark->bookmark_id = $this->idGenerator->generateUniqueId('forum','book_marks','bookmark_id');
            $role = $request->role;

            if ($role== "topic"){
                $topic_id = $request->topic_id;
                $bookmark->user_id = $user->id;
                $bookmark->topic_id = $topic_id;
            }

            if ($role== "message"){
                $message_id = $request->message_id;
                $bookmark->user_id = $user->id;
                $bookmark->message_id = $message_id;
            }
            $bookmark->status = 1;
            if ($bookmark->save()) {
                $status = 200;
                //save user activity to logs
                $activityDetails = [
                    'activity_body'=>'<strong>'.$user->username.'</strong>'." bookmarked a <strong>".$role."</strong> successfully",
                ];

                HelperEvent::dispatch($activityDetails);

            }else
                $status = 201;

            $data = array(
                'status'=>$status,
                'message'=> $role.' bookmarked!'
            );

            return response()->json($data);
        }

        $data = array(
            'status'=>202,
            'message'=>'An error occurred'
        );
        return response()->json($data);
    }

    /**
     * get bookmark status
     */
    public function get_bookmark_status(Request $request){
        $user = $this->get_logged_user_details();
        $role = $request->role;
        $bookmark = '';

        if ($role == "message"){
            $message_id = $request->message_id;
            $bookmark = BookMark::where('user_id',$user->id)->where('message_id',$message_id)->first();
        }
        if ($role == "topic"){
            $topic_id = $request->topic_id;
            $bookmark = BookMark::where('user_id',$user->id)->where('topic_id',$topic_id)->first();
        }

        $message = '';
        if ($bookmark){
            $message = "bookmarked";
        }

        $data = array(
            'status'=>200,
            'message'=>$message
        );

        return response()->json($data);
    }

    /**
     * get user bookmarked messages and topics
     */
    public function get_user_bookmarks($user_id){
        $user = User::where('user_id', $user_id)->first();
        $topic_bookmarks = BookMark::where('user_id',$user->id)->whereNotNull('topic_id')->paginate(10);
        $message_bookmarks = BookMark::where('user_id',$user->id)->whereNotNull('message_id')->paginate(10);

        return view('member.bookmark.bookmarks',compact('topic_bookmarks','message_bookmarks'))
            ->with('forum_list', $this->get_forum_list())
            ->with('user', $user);
    }
}
