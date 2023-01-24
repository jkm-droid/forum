<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ForumList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->special_character = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", ",", "/", "{", "}", "[", "]", "?");
    }


    /**
     * show all categorys
     */
    public function show_all_categories(){
        $categories = Category::latest()->paginate(20);
        $categoryCount = Category::count();

        return view('dashboard.categories.index', compact('categories'))
            ->with('f',1)
            ->with('categoryCount', $categoryCount)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * publish / un-publish a category
     */

    public function publish_draft_category($category_id){
        $category = Category::where('id', $category_id)->first();

        if ($category->status == 1){
            $category->status = 0;
            $message = "Un published successfully";
        }else{
            $category->status = 1;
            $message = "Published successfully";
        }

        $category->update();

        return Redirect::back()->with('success', $message);
    }

    /**
     * show only drafted categories
     */
    public function show_drafted_categories(){
        $categories = Category::where('status',0)->latest()->paginate();
        $no_draft = Category::where('status',0)->count();

        return view('dashboard.categories.drafted', compact('categories'))
            ->with('f',1)
            ->with('no_drafts', $no_draft)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * show only published categories
     */
    public function show_published_categories(){
        $categories = Category::where('status',1)->latest()->paginate();
        $no_published = Category::where('status',1)->count();

        return view('dashboard.categories.published', compact('categories'))
            ->with('f',1)
            ->with('no_published', $no_published)
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * show form to create a new category
     */

    public function show_category_creation_form(){
        $forums = ForumList::get();

        return view('dashboard.categories.create', compact('forums'));
    }

    /**
     * create a new category
     */

    public function category_create(Request $request){
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'forum'=>'required'
        ]);

        $category_data = $request->all();
        $slug = str_replace($this->special_character, '', $category_data['title']);

        $category = new Category();
        $category->title = $category_data['title'];
        $category->slug = str_replace("", "_", $slug);
        $category->description = $category_data['description'];
        $category->forum_list_id = $category_data['forum'];
        $category->save();

        return redirect()->route('show.drafted.categories')->with('success', "category added successfully");
    }

    /**
     * show category edit form
     */
    public function show_category_edit_form($category_id){
        $category = Category::find($category_id);
        $forums = ForumList::get();

        return view('dashboard.categories.edit', compact('category','forums'));
    }

    /**
     * create a new category
     */

    public function edit_category(Request $request, $category_id){
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'forum'=>'required'
        ]);

        $category_data = $request->all();
        $slug = str_replace($this->special_character, '', $category_data['title']);

        $category = Category::where('id', $category_id)->first();
        $category->title = $category_data['title'];
        $category->slug = str_replace("", "_", $slug);
        $category->description = $category_data['description'];
        $category->forum_list_id = $category_data['forum'];
        $category->update();

        return redirect()->route('show.drafted.categories')->with('success', "category edited successfully");
    }

    /**
     * delete category
     */
    public function delete_category($category_id){
        $category = Category::find($category_id);
        $category->delete();

        return Redirect::back()->with('success', 'category deleted successfully');
    }
}
