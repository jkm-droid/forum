<?php

namespace App\Http\Controllers\Forum;

use App\Events\AdminEvent;
use App\Events\HelperEvent;
use App\Helpers\GetRepetitiveItems;
use App\Helpers\HelperService;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\View;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TopicController extends Controller
{
    use GetRepetitiveItems;
    private $userDetails, $activity, $idGenerator;

    public function __construct(HelperService $myHelperClass){
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
        return view('member.topic.create_topic')
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
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
        $topic->topic_id = $this->idGenerator->generateUniqueId('forum','topics','topic_id');
        $topic->title = $topic_info['title'];
        $topic->body = $topic_info['body'];
        $topic->category_id = $topic_info['category'];
        $topic->slug = str_replace(" ","_", strtolower($slug));
        $topic->author = $user->username;

        $topic->save();

        //save user activity to logs
        $activityDetails = [
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
    public function show_edit_topic_form($topic_id){
        $topic = Topic::where('topic_id', $topic_id)->first();

        return view('member.topic.edit_topic', compact('topic'))
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    /**
     * edit a topic
     */
    public function update_topic(Request $request, $topic_id){
        $request->validate([
            'title'=>'required',
            'category'=>'required',
            'body'=>'required'
        ]);

        $topic_info = $request->all();
        $slug = str_replace($this->special_character, "", $topic_info['title']);
        $user = $this->userDetails->get_logged_user_details();

        $topic =  Topic::where('topic_id',$topic_id)->first();
        $topic->title = $topic_info['title'];
        $topic->body = $topic_info['body'];
        $topic->category_id = $topic_info['category'];
        $topic->slug = str_replace(" ","_", strtolower($slug));

        $topic->update();

        //save user activity to logs
        $activityDetails = [
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

        return redirect()->route('site.home')->with('success', 'Topic edited successfully.');
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
