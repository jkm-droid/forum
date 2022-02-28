<?php

namespace App\Http\Controllers;

use App\Events\HelperEvent;
use App\Events\MemberEvent;
use App\HelperFunctions\GetRepetitiveItems;
use App\HelperFunctions\MyHelperClass;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Topic;
use App\Models\View;
use App\Notifications\MemberNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class MemberMessageController extends Controller
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

    /**
     * create a new message
     */

    public function save_new_message(Request $request){
        $validator = Validator::make($request->all(),[
            'body'=>'required',
        ]);

        if ($validator->passes()){
            $message_body = $request->body;
            $topic_id = $request->topic_id;
            $user = $this->userDetails->get_logged_user_details();

            $topic = Topic::find($topic_id);

            $message = new Message();
            $message->body = $message_body;
            $message->user_id = $user->id;
            $message->author = $user->username;

            $details = array();
            if($topic->messages()->save($message)) {
                $status = 200;

                //save user activity to logs
                $activityDetails = [
                    'activity_id'=> $this->idGenerator->generateUniqueId($user->username,'activities','activity_id'),
                    'activity_body'=>'<strong>'.$user->username.'</strong>'." reacted to ".'<strong>'.$topic->author.'</strong>'." post ".'<strong>'.$topic->title.'</strong>',
                ];
                HelperEvent::dispatch($activityDetails);

                $details = [
                    'receiver'=>$topic->user->email,
                    'topic_author'=>$topic->author,
                    'post_title'=> $topic->title,
                    'message_author'=>$user->username,
                    'time'=>$message->created_at,
                    'subject'=>"New post reaction: ".$topic->title,
                ];
                Log::channel('daily')->info("controller");
                Log::channel('daily')->info($topic->user);
                //send email notification to the topic's author
                MemberEvent::dispatch($details);

                //send in-app notification
                Notification::send($topic->user, new MemberNotification($details));

            }else
                $status = $topic->user;

            $data = array(
                'status' => $status,
                'message' => 'success'
            );

            return response()->json($data);
        }

        $data = array(
            'status' => 202,
            'message' => $validator->errors()
        );

        return response()->json($data);
    }

    /**
     * create a new reply/comment
     */

    public function save_new_message_reply(Request $request){
        $validator = Validator::make($request->all(),[
            'body'=>'required',
        ]);

        if ($validator->passes()){
            $reply_body = $request->body;
            $message_id = $request->message_id;
            $user = $this->userDetails->get_logged_user_details();

            $message = Message::find($message_id);
            $comment = new Comment();
            $comment->body = $reply_body;
            $comment->author = $user->username;

            if($message->comments()->save($comment)) {
                $status = 200;
                //save user activity to logs
                $activityDetails = [
                    'activity_id'=> $this->idGenerator->generateUniqueId($user->username,'activities','activity_id'),
                    'activity_body'=>'<strong>'.$user->username.'</strong>'." reacted to ".'<strong>'.$message->author.'</strong>'."post",
                ];
                HelperEvent::dispatch($activityDetails);
            }else
                $status = 201;

            $data = array(
                'status' => $status,
                'message' => 'success'
            );

            return response()->json($data);
        }

        $data = array(
            'status' => 202,
            'message' => $validator->errors()
        );

        return response()->json($data);
    }

    /**
     * delete a particular reply
     */
    public function delete_message_reply(Request $request){
        if ($request->ajax()){
            $reply_id = $request->reply_id;
            $message = Message::find($reply_id);
            $user = $this->userDetails->get_logged_user_details();

            if ($message->delete()) {
                $status = 200;
                //save user activity to logs
                $activityDetails = [
                    'activity_id'=> $this->idGenerator->generateUniqueId($user->username,'activities','activity_id'),
                    'activity_body'=>'<strong>'.$user->username.'</strong>'." deleted the reaction ".'<strong>'.$message->body.'</strong>',
                ];
                HelperEvent::dispatch($activityDetails);

            }else
                $status = 201;

            $data = array(
                'status'=>$status,
                'message'=>'success'
            );

            return response()->json($data);
        }

        $data = array(
            'status'=>202,
            'message'=>'An error occurred'
        );
        return response()->json($data);
    }

}
