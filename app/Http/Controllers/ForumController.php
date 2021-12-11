<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ForumList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ForumController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->special_character = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", ",", "/", "{", "}", "[", "]", "?");
    }

    /**
     * show all forums
     */
    public function show_all_forums(){
        $forums = ForumList::latest()->paginate(20);

        return view('dashboard.forums.index', compact('forums'))
            ->with('f',1)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * publish / un-publish a forum
     */

    public function publish_draft_forum($forum_id){
        $forum = ForumList::where('id', $forum_id)->first();

        if ($forum->status == 1){
            $forum->status = 0;
            $message = "Un published successfully";
        }else{
            $forum->status = 1;
            $message = "Published successfully";
        }

        $forum->update();

        return Redirect::back()->with('success', $message);
    }

    /**
     * show only drafted forums
     */
    public function show_drafted_forums(){
        $forums = ForumList::where('status',0)->latest()->paginate();

        return view('dashboard.forums.drafted', compact('forums'))
            ->with('f',1)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * show only published forums
     */
    public function show_published_forums(){
        $forums = ForumList::where('status',1)->latest()->paginate();

        return view('dashboard.forums.published', compact('forums'))
            ->with('f',1)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * show form to create a new forum
     */

    public function show_forum_creation_form(){
        $categories = Category::get();

        return view('dashboard.forums.create', compact('categories'));
    }

    /**
     * create a new forum
     */

    public function forum_create(Request $request){
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);

        $forum_data = $request->all();
        $slug = str_replace($this->special_character, '', $forum_data['title']);

        $forum = new ForumList();
        $forum->title = $forum_data['title'];
        $forum->slug = str_replace("", "_", $slug);
        $forum->description = $forum_data['description'];
        $forum->save();

        return redirect()->route('show.drafted.forums')->with('success', "forum added successfully");
    }

    /**
     * show forum edit form
     */
    public function show_forum_edit_form($forum_id){
        $forum = ForumList::where('id', $forum_id)->first();

        return view('dashboard.forums.edit', compact('forum'));
    }

    /**
     * create a new forum
     */

    public function edit_forum(Request $request, $forum_id){
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);

        $forum_data = $request->all();
        $slug = str_replace($this->special_character, '', $forum_data['title']);

        $forum = ForumList::where('id', $forum_id)->first();
        $forum->title = $forum_data['title'];
        $forum->slug = str_replace("", "_", $slug);
        $forum->description = $forum_data['description'];
        $forum->update();

        return redirect()->route('show.drafted.forums')->with('success', "forum edited successfully");
    }


    /**
     * delete forum
     */
    public function delete_forum($forum_id){
        $forum = ForumList::find($forum_id);
        $forum->delete();

        return Redirect::back()->with('success', 'forum deleted successfully');
    }
}
