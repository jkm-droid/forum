<?php

namespace App\Services\Forum;

use App\Events\ContentCreationEvent;
use App\Events\HelperEvent;
use App\Helpers\HelperService;
use App\Models\Comment;
use App\Models\Message;
use App\Notifications\CommentNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CommentService
{
    /**
     * @var HelperService
     */
    private $_helperService;

    public function __construct(HelperService $helperService)
    {
        $this->_helperService = $helperService;
    }

    public function saveMessageReply($request)
    {
        $validator = Validator::make($request->all(),[
            'body'=>'required',
        ]);

        if ($validator->passes()){
            $reply_body = $request->body;
            $message_id = $request->message_id;
            $user = $this->_helperService->get_logged_user_details();

            $message = Message::find($message_id);
            $comment = new Comment();
            $comment->body = $reply_body;
            $comment->comment_id = $this->_helperService->generateUniqueId('forum', 'comments','comment_id');
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

    public function messageReplyForm($message_reply_id)
    {
        $comment = Comment::where('comment_id',$message_reply_id)->first();
        $topic = $comment->message->topic;

        return view('member.message_reply.edit_message_reply', compact('comment','topic'))
            ->with('categories',$this->get_all_categories())
            ->with('forum_list', $this->get_forum_list())
            ->with('user', $this->_helperService->get_logged_user_details());
    }

    public function updateMessageReply($request,$reply_id)
    {
        $request->validate([
            'body' => 'required'
        ]);
        $user = $this->_helperService->get_logged_user_details();
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

    public function deleteMessageReply($request)
    {
        if ($request->ajax()){
            $commentId = $request->comment_id;
            $comment = Comment::find($commentId);
            $user = $this->_helperService->get_logged_user_details();

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
