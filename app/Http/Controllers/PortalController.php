<?php

namespace App\Http\Controllers;

use App\Events\AdminEvent;
use App\Events\HelperEvent;
use App\Events\MemberEvent;
use App\HelperFunctions\GetRepetitiveItems;
use App\HelperFunctions\MyHelperClass;
use App\Jobs\AdminJob;
use App\Jobs\NewMessageJob;
use App\Models\Activity;
use App\Models\Admin;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\TopicTag;
use App\Models\User;
use App\Models\View;
use App\Notifications\AdminNotification;
use App\Notifications\MemberNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PortalController extends Controller
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
     * show the form to create a new topic/thread
     */

    public function show_create_new_topic_form(){
        return view('member.create_topic')
            ->with('user', $this->get_logged_user_details())
            ->with('categories', $this->get_all_categories());
    }

    /**
     * save a new topic
     */
    public function save_new_topic(Request $request){
        $request->validate([
            'title'=>'required',
            'category'=>'required',
            'body'=>'required'
        ]);

        $topic_info = $request->all();
        $slug = str_replace($this->special_character, "", $topic_info['title']);
        $user = $this->userDetails->get_logged_user_details();

        $topic = new Topic();
        $topic->user_id = $user->id;
        $topic->title = $topic_info['title'];
        $topic->body = $topic_info['body'];
        $topic->category_id = $topic_info['category'];
        $topic->slug = str_replace(" ","_", strtolower($slug));
        $topic->author = $user->username;

        $topic->save();

        //save user activity to logs
        $activityDetails = [
            'activity_id'=> $this->idGenerator->generateUniqueId($user->username,'activities','activity_id'),
            'activity_body'=>'<strong>'.$user->username.'</strong>'." created a new post ".'<strong>'.$topic_info['title'].'</strong>',
        ];
        HelperEvent::dispatch($activityDetails);

        if ($request->has('tags')  && $request->tags != null) {
            $tags = $request->tags;
            $array_tags = explode(",", $tags);

            $tagIds = [];
            for ($t = 0; $t < count($array_tags); $t++) {
                $tag = Tag::firstOrCreate([
                    'title' => $array_tags[$t],
                    'slug' => strtolower($array_tags[$t])
                ]);
                if ($tag) {
                    $tagIds[] = $tag->id;
                }
            }

            $topic->tags()->attach($tagIds);
        }

        //send in-app notifications
        $admins  = Admin::get();
        Notification::send($admins, new AdminNotification($topic));

        //send mail notifications
        AdminEvent::dispatch($topic);

        return redirect()->route('site.home')->with('success', 'Topic created successfully. Awaiting moderator approval');
    }


    /**
     * show form to edit a topic
     */
    public function show_edit_topic_form($slug){
        $topic = Topic::where('slug', $slug)->first();

        return view('member.edit_topic', compact('topic'))
            ->with('user', $this->get_logged_user_details())
            ->with('categories', $this->get_all_categories());
    }

    /**
     * edit a topic
     */
    public function edit_topic(Request $request, $topic_id){
        $request->validate([
            'title'=>'required',
            'category'=>'required',
            'body'=>'required'
        ]);

        $topic_info = $request->all();
        $slug = str_replace($this->special_character, "", $topic_info['title']);
        $user = $this->userDetails->get_logged_user_details();

        $topic =  Topic::find($topic_id);
        $topic->title = $topic_info['title'];
        $topic->body = $topic_info['body'];
        $topic->category_id = $topic_info['category'];
        $topic->slug = str_replace(" ","_", strtolower($slug));

        $topic->update();

        //save user activity to logs
        $activityDetails = [
            'activity_id'=> $this->idGenerator->generateUniqueId($user->username,'activities','activity_id'),
            'activity_body'=>'<strong>'.$user->username.'</strong>'." edited topic ".'<strong>'.$topic_info['title'].'</strong>',
        ];
        HelperEvent::dispatch($activityDetails);

        $old_tags = array();
        if ($request->has('tags') && $request->tags != null) {
            $tags = str_replace(" ", "", $request->tags);
            $array_tags = explode(",", $tags);

            $tagIds = [];
            for ($t = 0; $t < count($array_tags); $t++) {
                $old_tag = Tag::where('slug',strtolower($array_tags[$t]))->first();

                if (!$old_tag){
                    $tag = Tag::firstOrCreate([
                        'title' => $array_tags[$t],
                        'slug' => strtolower($array_tags[$t])
                    ]);
                    if ($tag) {
                        $tagIds[] = $tag->id;
                    }
                }

                array_push($tagIds, $old_tag->id);
            }

            $topic->tags()->sync($tagIds);

        }else{
            $topic->tags()->detach();
        }

        return redirect()->route('site.home')->with('success', 'Topic edited successfully. Awaiting moderator approval');
    }

    /**
     * delete a particular topic
     */
    public function delete_topic(Request $request){
        if ($request->ajax()){
            $topic_id = $request->topic_id;
            $topic = Topic::find($topic_id);
            $user = $this->userDetails->get_logged_user_details();

            if ($topic->delete()) {
                $status = 200;
                //save user activity to logs
                $activityDetails = [
                    'activity_id'=> $this->idGenerator->generateUniqueId($user->username,'activities','activity_id'),
                    'activity_body'=>'<strong>'.$user->username.'</strong>'." the post ".'<strong>'.$topic->title.'</strong>',
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
     * delete a particular reply
     */
    public function delete_reply(Request $request){
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

    /**
     * create a new reply/comment
     */

    public function save_new_reply(Request $request){
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
     * get topic view status based on user_id and topic_id
     */
    public function get_topic_view_status(Request $request){
        $topic_id = $request->topic_id;
        $user = $this->get_logged_user_details();

        $view = View::where('user_id', $user->id)->where('topic_id',$topic_id)->where('isViewed', 1)->first();
        $message = '';
        if ($view){
            $message = "viewed";
        }

        $data = array(
            'status'=>200,
            'message'=>$message
        );

        return response()->json($data);
    }
}
