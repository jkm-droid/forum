<?php

namespace App\Http\Controllers;

use App\HelperFunctions\GetRepetitiveItems;
use App\Models\Message;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSiteController extends Controller
{
    use GetRepetitiveItems;

    public function __construct(){
        $this->middleware('auth');
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
            $message->author = Auth::user()->username;

            if($topic->messages()->save($message))
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
     * show the form to create a new topic/thread
     */

    public function show_create_new_topic_form(){
        return view('site.create_topic')
            ->with('categories', $this->get_all_categories());
    }

    /**
     * save a new topic
     */

    public function save_new_topic(Request $request){
        $request->validate([
            'title'=>'required|unique:topics',
            'category'=>'required',
            'body'=>'required'
        ]);

        $topic_info = $request->all();
        $slug = str_replace($this->special_character, "", $topic_info['title']);
        $topic = new Topic();
        $topic->title = $topic_info['title'];
        $topic->body = $topic_info['body'];
        $topic->category_id = $topic_info['category'];
        $topic->slug = str_replace(" ","_", strtolower($slug));
        $topic->author = Auth::user()->username;

        $topic->save();

        $tags = $request->tags;
        $array_tags = explode(",", $tags);

        $tagIds = [];
        for ($t = 0;$t < count($array_tags);$t++){
            $tag =   Tag::firstOrCreate([
                'title'=>$array_tags[$t],
                'slug'=>strtolower($array_tags[$t])
            ]);
            if ($tag){
                $tagIds[] = $tag->id;
            }
        }

        $topic->tags()->attach($tagIds);

        return redirect()->route('site.home')->with('success', 'Topic created successfully. Awaiting moderator approval');
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
}
