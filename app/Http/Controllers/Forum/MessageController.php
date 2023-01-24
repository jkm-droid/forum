<?php

namespace App\Http\Controllers\Forum;

use App\Events\ContentCreationEvent;
use App\Events\HelperEvent;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Message;
use App\Notifications\CommentNotification;
use App\Services\Forum\MessageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MessageController extends Controller
{

    /**
     * @var MessageService
     */
    private $_messageService;

    public function __construct(MessageService $messageService)
    {
        $this->middleware('auth');
        $this->_messageService = $messageService;
    }

    /**
     * save a message belonging to a certain topic
     */

    public function save_message(Request $request)
    {
        return $this->_messageService->saveMessage($request);
    }

    /**
     * show form to edit message
     */
    public function show_message_edit_form($message_id)
    {
        return $this->_messageService->messageEditForm($message_id);
    }

    /**
     * update message
     */
    public function update_message(Request $request, $message_id)
    {
        return $this->_messageService->updateMessage($request, $message_id);
    }

    /**
     * delete a message belonging to a certain topic - async
     */
    public function ajax_delete_message(Request $request)
    {
        return $this->_messageService->ajaxDeleteMessage($request);
    }

    /**
     * delete a message belonging to a certain topic - post method
     */
    public function post_delete_message($message_id)
    {
       return $this->_messageService->postDeleteMessage($message_id);
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

                $details = [
                    'message' => $message,
                    'user' => $user,
                    'purpose' => 'comment'
                ];

                //send email notification to the topic's author
                ContentCreationEvent::dispatch($details);

                //send in-app notification
                Notification::send($message->user,new CommentNotification([
                    'title' => 'New comment from '.$user->username,
                    'time' => Carbon::now(),
                    'message' => 'Your thread <strong>'.Str::limit($message->body,'100','...').'</strong> has a new comment from <strong>'.$user->username.'</strong>'
                ]));
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
            ->with('forum_list', $this->get_forum_list())
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
