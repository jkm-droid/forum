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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
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
     * save a message belonging to a certain topic
     */

    public function save_message(Request $request){
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
            $message->message_id = $this->idGenerator->generateUniqueId('forum','messages','message_id');
            $message->author = $user->username;

            $details = array();
            if($topic->messages()->save($message)) {
                $status = 200;

                //save user activity to logs
                $activityDetails = [
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
     * show form to edit message
     */
    public function show_message_edit_form($message_id){
        $message = Message::where('message_id',$message_id)->first();
        $topic = $message->topic;

        return view('member.message.edit_message', compact('message','topic'))
            ->with('categories',$this->get_all_categories())
            ->with('user', $this->userDetails->get_logged_user_details());
    }

    /**
     * update message
     */
    public function update_message(Request $request, $message_id){
        $request->validate([
            'body' => 'required'
        ]);
        $messageInfo = $request->all();
        $message = Message::where('message_id',$message_id)->first();
        $user = $this->userDetails->get_logged_user_details();

        $message->body = $messageInfo['body'];
        $message->updated_at = Carbon::now();

        $message->update();

        $activityDetails = [
            'activity_body'=>'<strong>'.$user->username.'</strong>'." updated message ".'<strong>'.$message->message_id.'</strong>',
        ];
        HelperEvent::dispatch($activityDetails);

        return redirect()->route('profile.view',$user->user_id)->with('success','message updated successfully');
    }

    /**
     * delete a message belonging to a certain topic
     */
    public function ajax_delete_message(Request $request){
        if ($request->ajax()){
            $message_id = $request->reply_id;
            $message = Message::find($message_id);
            $user = $this->userDetails->get_logged_user_details();

            if ($message->delete()) {
                $status = 200;
                //save user activity to logs
                $activityDetails = [
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

    public function post_delete_message($message_id){
        $message = Message::where('message_id',$message_id)->first();
        $user = $this->userDetails->get_logged_user_details();
        $message->delete();

        //save user activity to logs
        $activityDetails = [
            'activity_body'=>'<strong>'.$user->username.'</strong>'." deleted message ".'<strong>'.$message->message_id.'</strong>',
        ];
        HelperEvent::dispatch($activityDetails);

        return Redirect::back()->with('info', 'message deleted successfully');
    }


    /**
     * create a new reply/comment
     */
    public function save_message_reply(Request $request){
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
            $comment->comment_id = $this->idGenerator->generateUniqueId('forum', 'comments','comment_id');
            $comment->author = $user->username;

            if($message->comments()->save($comment)) {
                $status = 200;
                //save user activity to logs
                $activityDetails = [
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
     * show form to edit a comment on a certain message
     */
    public function show_message_reply_form($message_reply_id){
        $comment = Comment::where('comment_id',$message_reply_id)->first();
        $topic = $comment->message->topic;

        return view('member.message_reply.edit_message_reply', compact('comment','topic'))
            ->with('categories',$this->get_all_categories())
            ->with('user', $this->userDetails->get_logged_user_details());
    }

    /**
     * update a comment belonging to a certain message
     */
    public function update_message_reply(Request $request,$reply_id){
        $request->validate([
            'body' => 'required'
        ]);
        $user = $this->userDetails->get_logged_user_details();
        $messageReplyInfo = $request->all();
        $comment = Comment::where('comment_id',$reply_id)->first();
        $comment->body = $messageReplyInfo['body'];
        $comment->updated_at = Carbon::now();

        $comment->update();

        $activityDetails = [
            'activity_body'=>'<strong>'.$user->username.'</strong>'." updated comment ".'<strong>'.$comment->comment_id,
        ];

        HelperEvent::dispatch($activityDetails);

        return redirect()->route('site.single.topic', $comment->message->topic->slug)->with('success', 'comment updated successfully');
    }

    /**
     * delete a comment
     */
    public function delete_message_reply(Request $request){
        if ($request->ajax()){
            $commentId = $request->comment_id;
            $comment = Comment::find($commentId);
            $user = $this->userDetails->get_logged_user_details();

            if ($comment->delete()) {
                $status = 200;
                //save user activity to logs
                $activityDetails = [
                    'activity_body'=>'<strong>'.$user->username.'</strong>'." deleted the comment to ".'<strong>'.$comment->message->author."'s".'</strong> message',
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
