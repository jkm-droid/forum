<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ForumList;
use App\Models\Message;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    /**
     * show dashboard
     */

    public function dashboard(){
        $no_users= User::count();
        $no_categories = Category::count();
        $no_topics = Topic::count();
        $no_messages = Message::count();

        $forums = ForumList::take(5)->get();
        $categories = Category::take(5)->get();
        $topics = Topic::take(5)->get();
        $users = User::take(5)->get();

        return view('dashboard.dashboard', compact('forums','categories','topics','users'))
            ->with('no_users', $no_users)
            ->with('no_categories', $no_categories)
            ->with('no_topics', $no_topics)
            ->with('no_messages', $no_messages);
    }
}
