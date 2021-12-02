<?php

namespace App\Http\Controllers;

use App\HelperFunctions\GetRepetitiveItems;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    use GetRepetitiveItems;

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * show a user their profile
     */
    public function view_profile($user_id){
        $user = User::find($user_id);

        return view('profile.view')->with('user', $user)
            ->with('categories', $this->get_all_categories());
    }

    /**
     * show the profile edit form
     */
    public function edit_profile($user_id){
        $user = User::find($user_id);

        return view('profile.edit')->with('user', $user);
    }

    /**
     * Update the user's profile
     **/
    public function update_profile(Request $request, $user_id){
        $request->validate([
            'name'=>'required',
            'username'=>'required'
        ]);

        $user_info = $request->all();
        $user = User::find($user_id);

        if ($request->hasFile('profile_picture')){
            $imageName = str_replace(' ', '_',$user_info['name']).'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_pictures'), $imageName);
            File::delete($user->profile_url);

            $user_info['profile_url'] = $imageName;
            $user->profile_url = $imageName;
        }
        unset($user_info['profile_picture']);

        $user->name = $user_info['name'];
        $user->username = $user_info['username'];
        $user->update($user_info);

        return redirect()->route('profile.view', $user_id)->with('success', 'Profile updated successfully');
    }
}
