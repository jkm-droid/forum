<?php

namespace App\Http\Controllers;

use App\HelperFunctions\GetRepetitiveItems;
use App\Jobs\AdminTopicJob;
use App\Jobs\NewMessageJob;
use App\Models\Admin;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\TopicTag;
use App\Models\User;
use App\Models\View;
use App\Notifications\AdminTopicNotifications;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSiteController extends Controller
{
    use GetRepetitiveItems;

    public function __construct(){
        $this->middleware('auth');
        $this->special_character = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", ",", "/", "{", "}", "[", "]", "?");
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

            $topic = Topic::find($topic_id);

            $message = new Message();
            $message->body = $message_body;
            $message->user_id = $this->get_id()->id;
            $message->author = $this->get_id()->username;

            $details = array();
            if($topic->messages()->save($message)) {
                $status = 200;

                $details = [
                    'author'=>$topic->author,
                    'post_title'=> $topic->title,
                    'message_author'=>$this->get_id()->username
                ];
//                NewMessageJob::dispatch($topic->user->email, $details);

                $this->send_new_message_notification($message, $topic,$topic->user);
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

    public function send_new_message_notification($message, $topic, $recipient){
        Notification::send($recipient, new NewMessageNotification($message, $topic));
    }

    /**
     * show the form to create a new topic/thread
     */

    public function show_create_new_topic_form(){
        return view('site_auth.create_topic')
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
        $topic = new Topic();
        $topic->user_id = $this->get_id()->id;
        $topic->title = $topic_info['title'];
        $topic->body = $topic_info['body'];
        $topic->category_id = $topic_info['category'];
        $topic->slug = str_replace(" ","_", strtolower($slug));
        $topic->author = $this->get_id()->username;

        $topic->save();

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

        $this->send_topic_notifications($topic);

        return redirect()->route('site.home')->with('success', 'Topic created successfully. Awaiting moderator approval');
    }

    public function send_topic_notifications($topic){
        $details = [
            'author'=>$topic->author,
            'topic_title'=> $topic->title
        ];

        $admins  = Admin::get();

        Notification::send($admins, new AdminTopicNotifications($topic));

        //send mail notifications
        foreach ($admins as $admin) {
            AdminTopicJob::dispatch($admin->email,$details);
        }
    }

    /**
     * show form to edit a topic
     */

    public function show_edit_topic_form($slug){
        $topic = Topic::where('slug', $slug)->first();

        return view('site_auth.edit_topic', compact('topic'))
            ->with('user', $this->get_logged_user_details())
            ->with('categories', $this->get_all_categories());
    }

    /**
     * edit a topic
     */

    public function edit_topic(Request $request, $id){
        $request->validate([
            'title'=>'required',
            'category'=>'required',
            'body'=>'required'
        ]);

        $topic_info = $request->all();
        $slug = str_replace($this->special_character, "", $topic_info['title']);
        $topic =  Topic::find($id);
        $topic->title = $topic_info['title'];
        $topic->body = $topic_info['body'];
        $topic->category_id = $topic_info['category'];
        $topic->slug = str_replace(" ","_", strtolower($slug));

        $topic->update();
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
            if ($topic->delete())
                $status = 200;
            else
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
     * delete a particular reply
     */

    public function delete_reply(Request $request){
        if ($request->ajax()){
            $reply_id = $request->reply_id;
            $message = Message::find($reply_id);
            if ($message->delete())
                $status = 200;
            else
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

            $message = Message::find($message_id);
            $comment = new Comment();
            $comment->body = $reply_body;
            $comment->author = Auth::user()->username;

            if($message->comments()->save($comment))
                $status = 200;
            else
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
     * get authenticated user id
     */
    public function get_id(){
        $user = '';
        if (Auth::check())
            $user = User::where('id', Auth::user()->id)->first();

        return $user;
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
