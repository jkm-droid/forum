<?php

namespace App\Services\Forum;

use App\Constants\AppConstants;
use App\Events\AppHelperEvent;
use App\Helpers\GetRepetitiveItems;
use App\Helpers\AppHelperService;
use App\Models\BookMark;
use App\Models\User;
use Illuminate\Http\Request;

class BookmarkService
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

    public function bookmarkTopicMessage($request)
    {
        if ($request->ajax()){
            $user = $this->_helperService->get_logged_user_details();
            $bookmark = new BookMark();
            $bookmark->bookmark_id = $this->_helperService->generateUniqueId('forum','book_marks','bookmark_id');
            $role = $request->role;

            if ($role== "topic"){
                $topic_id = $request->topic_id;
                $checkBookmark = BookMark::where('user_id',$user->id)->where('topic_id',$topic_id)->first();
                if (!$checkBookmark) {
                    $bookmark->user_id = $user->id;
                    $bookmark->topic_id = $topic_id;
                }
            }

            if ($role== "message"){
                $message_id = $request->message_id;
                $checkBookmark = BookMark::where('user_id',$user->id)->where('message_id',$message_id)->first();
                if (!$checkBookmark) {
                    $bookmark->user_id = $user->id;
                    $bookmark->message_id = $message_id;
                }
            }
            $bookmark->status = 1;
            if ($bookmark->save()) {
                $status = 200;
                //save user activity to logs
                $activityDetails = [
                    'event' => AppConstants::$events['systems_logs'],
                    'activity_body'=>'<strong>'.$user->username.'</strong>'." bookmarked a <strong>".$role."</strong> successfully",
                ];

                AppHelperEvent::dispatch($activityDetails);

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

    public function getBookmarkStatus($request){
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

    public function getUserBookmarks($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        $topic_bookmarks = BookMark::where('user_id',$user->id)->whereNotNull('topic_id')->paginate(10);
        $message_bookmarks = BookMark::where('user_id',$user->id)->whereNotNull('message_id')->paginate(10);

        return view('member.bookmark.bookmarks',compact('topic_bookmarks','message_bookmarks'))
            ->with('forum_list', $this->get_forum_list())
            ->with('user', $user);
    }
}
