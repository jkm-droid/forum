<?php

namespace App\Services\Forum;

use App\Constants\AppConstants;
use App\Events\AdminEvent;
use App\Events\HelperEvent;
use App\Helpers\GetRepetitiveItems;
use App\Helpers\HelperService;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\View;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TopicService
{
    use GetRepetitiveItems;
    /**
     * @var HelperService
     */
    private $_helperService;

    public function __construct(HelperService $helperService)
    {
        $this->_helperService = $helperService;
    }

    public function createNewTopicForm()
    {
        return view('member.topic.create_topic')
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    public function saveNewTopic($request)
    {
        $request->validate([
            'title'=>'required',
            'category'=>'required',
            'body'=>'required'
        ]);

        $topic_info = $request->all();
        $slug = str_replace(AppConstants::$special_character, "", $topic_info['title']);
        $user = $this->_helperService->get_logged_user_details();

        $topic = new Topic();
        $topic->user_id = $user->id;
        $topic->topic_id = $this->_helperService->generateUniqueId('forum','topics','topic_id');
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

    public function editTopicForm($topic_id)
    {
        $topic = Topic::where('topic_id', $topic_id)->first();

        return view('member.topic.edit_topic', compact('topic'))
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    public function updateTopic($request, $topic_id)
    {
        $request->validate([
            'title'=>'required',
            'category'=>'required',
            'body'=>'required'
        ]);

        $topic_info = $request->all();
        $slug = str_replace(AppConstants::$special_character, "", $topic_info['title']);
        $user = $this->_helperService->get_logged_user_details();

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

    public function deleteTopic($request)
    {
        if ($request->ajax()){
            $topic_id = $request->topic_id;
            $topic = Topic::find($topic_id);
            $user = $this->_helperService->get_logged_user_details();

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

    public function showTopic($slug)
    {
        $topic = Topic::where('slug', $slug)->first();
        $topic->title = substr($topic->title,0,20);

        //register views
        if (Auth::check()) {
            $user = $this->get_logged_user_details();
            if (!$user->views()->where('topic_id', $topic->id)->first()) {
                $topic->views = $topic->views + 2;
                $topic->update();

                $view = new View();
                $view->user_id = $user->id;
                $view->topic_id = $topic->id;
                $view->isViewed = 1;
                $view->save();
            }
        }else{
            $topic->incrementViewCount();
        }

        $messages = Message::where('topic_id', $topic->id)->latest()->paginate(10);

        return view('site.single_topic', compact('topic', 'messages'))
            ->with('i', (request()->input('page',1) - 1) * 10)
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    public function topTopics()
    {
        $top_topics = Topic::where('status',1)->orderBy('views', 'DESC')->take(20)->get();

        return view('site.top_topics', compact('top_topics'))
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    public function topicViewStatus($request)
    {
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
