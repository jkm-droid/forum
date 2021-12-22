<?php

namespace App\Http\Controllers;

use App\HelperFunctions\GetRepetitiveItems;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{

    use GetRepetitiveItems;

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * show a user their profile
     */
    public function view_profile($username){
        $user = User::where('username', $username)->first();
        if($user->id == Auth::user()->id) {

            return view('profile.view')->with('user', $user)
                ->with('categories', $this->get_all_categories());
        }

        return Redirect::back();
    }

    /**
     * show the profile edit form
     */
    public function show_profile_edit_form($username){
        $user = User::where('username', $username)->first();

        return view('profile.edit')->with('user', $user)
            ->with('categories', $this->get_all_categories());
    }

    /**
     * Update the user's profile
     **/
    public function update_profile(Request $request, $username){
        $user = $this->get_user($username);

        if ($request->hasFile('profile_picture')){
            $imageName = str_replace(' ', '_',$user->username).'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_pictures'), $imageName);
            File::delete($user->profile_url);

            $user->profile_url = $imageName;
        }
//        unset($user_info['profile_picture']);

        $user->update();

        return redirect()->route('profile.view', $user->username)->with('success', 'Profile updated successfully');
    }

    /**
     * profile settings / update extra user information
     */

    public function profile_settings(Request $request, $username){
        $user = $this->get_user($username);
        $countries = Country::get();
        return view('profile.settings', compact('user','countries'))
            ->with('categories', $this->get_all_categories());
    }

    public function get_user($username){
        return User::where('username', $username)->first();
    }
}
