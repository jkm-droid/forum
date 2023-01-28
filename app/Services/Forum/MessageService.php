<?php

namespace App\Services\Forum;

use App\Events\ContentCreationEvent;
use App\Events\HelperEvent;
use App\Helpers\GetRepetitiveItems;
use App\Helpers\HelperService;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Topic;
use App\Notifications\CommentNotification;
use App\Notifications\MessageNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MessageService
{
    use GetRepetitiveItems;
    /**
     * @var HelperService
     */
    private $_helperService;

    public function __construct(HelperService $helperService){
        $this->_helperService = $helperService;
    }

    public function getSingleMessage($message_id)
    {
        $message = Message::where('message_id', $message_id)->first();

        return view('site.messages.single_message', compact('message'))
            ->with('forum_list', $this->get_forum_list())
            ->with('user', $this->get_logged_user_details());
    }

    public function saveMessage($request)
    {
        $validator = Validator::make($request->all(),[
            'body'=>'required',
        ]);

        if ($validator->passes()){
            $message_body = $request->body;
            $topic_id = $request->topic_id;
            $user = $this->_helperService->get_logged_user_details();

            $topic = Topic::find($topic_id);

            $message = new Message();
            $message->body = $message_body;
            $message->user_id = $user->id;
            $message->message_id = $this->_helperService->generateUniqueId('forum','messages','message_id');
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
                    'topic' => $topic,
                    'user' => $user,
                    'purpose' => 'message'
                ];

                //send email notification to the topic's author
                ContentCreationEvent::dispatch($details);

                //send in-app notification
                Notification::send($topic->user, new MessageNotification([
                    'title' => 'New post reaction from '.$topic->author,
                    'time' => $message->created_at,
                    'message' => 'Your post <strong>'.$topic->title.'</strong> has new reaction from <strong>'.$user->username.'</strong>'
                ]));

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

    public function messageEditForm($message_id)
    {
        $message = Message::where('message_id',$message_id)->first();
        $topic = $message->topic;

        return view('member.message.edit_message', compact('message','topic'))
            ->with('categories',$this->get_all_categories())
            ->with('forum_list', $this->get_forum_list())
            ->with('user', $this->_helperService->get_logged_user_details());
    }

    public function updateMessage($request, $message_id)
    {
        $request->validate([
            'body' => 'required'
        ]);
        $messageInfo = $request->all();
        $message = Message::where('message_id',$message_id)->first();
        $user = $this->_helperService->get_logged_user_details();

        $message->body = $messageInfo['body'];
        $message->updated_at = Carbon::now();

        $message->update();

        $activityDetails = [
            'activity_body'=>'<strong>'.$user->username.'</strong>'." updated message ".'<strong>'.$message->message_id.'</strong>',
        ];
        HelperEvent::dispatch($activityDetails);

        return redirect()->route('profile.view',$user->user_id)->with('success','message updated successfully');
    }

    public function ajaxDeleteMessage($request)
    {
        if ($request->ajax()){
            $message_id = $request->reply_id;
            $message = Message::find($message_id);
            $user = $this->_helperService->get_logged_user_details();

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

    public function postDeleteMessage($message_id){
        $message = Message::where('message_id',$message_id)->first();
        $user = $this->_helperService->get_logged_user_details();
        $message->delete();

        //save user activity to logs
        $activityDetails = [
            'activity_body'=>'<strong>'.$user->username.'</strong>'." deleted message ".'<strong>'.$message->message_id.'</strong>',
        ];
        HelperEvent::dispatch($activityDetails);

        return Redirect::back()->with('info', 'message deleted successfully');
    }

}
