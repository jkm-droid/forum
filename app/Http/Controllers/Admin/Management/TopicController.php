<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TopicController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->special_character = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", ",", "/", "{", "}", "[", "]", "?");
    }


    /**
     * show all topics
     */
    public function show_all_topics(){
        $topics= Topic::latest()->paginate(20);
        $allTopics = Topic::count();

        return view('dashboard.topics.index', compact('topics'))
            ->with('f',1)
            ->with('topicCount', $allTopics)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * publish / un-publish a topic
     */

    public function publish_draft_topic($topic_id){
        $topic = Topic::where('id', $topic_id)->first();

        if ($topic->status == 1){
            $topic->status = 0;
            $message = "Topic Un published successfully";
        }else{
            $topic->status = 1;
            $message = "Topic Published successfully";
        }

        $topic->update();

        return Redirect::back()->with('success', $message);
    }

    /**
     * show only drafted topics
     */
    public function show_drafted_topics(){
        $topics= topic::where('status',0)->latest()->paginate();
        $drafts = Topic::where('status',0)->count();
        return view('dashboard.topics.drafted', compact('topics'))
            ->with('f',1)
            ->with('drafts',$drafts)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * show only published topics
     */
    public function show_published_topics(){
        $topics= Topic::where('status',1)->latest()->paginate();
        $publishes = Topic::where('status',1)->count();

        return view('dashboard.topics.published', compact('topics'))
            ->with('f',1)
            ->with('publishes',$publishes)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }


    /**
     * delete topic
     */
    public function delete_topic($topic_id){
        $topic = topic::find($topic_id);
        $topic->delete();

        return Redirect::back()->with('success', 'topic deleted successfully');
    }

}
