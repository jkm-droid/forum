<?php

namespace App\Http\Controllers\Member;

use App\Events\HelperEvent;
use App\Helpers\GetRepetitiveItems;
use App\Helpers\HelperService;
use App\Models\BookMark;
use App\Models\Country;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Topic;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;

class ProfileController extends Controller
{

    use GetRepetitiveItems;

    private $userDetails, $idGenerator, $messages;

    public function __construct(HelperService $myHelperClass){
        $this->middleware('auth');
        $this->userDetails = $myHelperClass;
        $this->messages = $myHelperClass;
        $this->idGenerator = $myHelperClass;
    }

    /**
     * show a user their profile
     */
    public function view_profile($user_id){
        $user = User::where('user_id', $user_id)->first();

        if($user_id == Auth::user()->user_id) {
            return view('member.profile.view')->with('user', $user)
                ->with('forum_list', $this->get_forum_list())
                ->with('i', (request()->input('page',1) - 1) * 10)
                ->with('messages', $this->messages->get_user_messages())
                ->with('categories', $this->get_all_categories());
        }

        return Redirect::back();
    }

    /**
     * show the profile edit form
     */
    public function show_profile_edit_form($user_id){
        $user = $this->get_user($user_id);

        return view('member.profile.edit')->with('user', $user)
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    /**
     * Update the user's profile
     **/
    public function update_profile_picture(Request $request, $user_id){
        $user = $this->get_user($user_id);

        if ($request->hasFile('profile_picture')){
            $imageName = str_replace(' ', '_',$user->username).'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_pictures'), $imageName);
            File::delete($user->profile_url);

            $user->profile_url = $imageName;
        }
//        unset($user_info['profile_picture']);

        $user->update();

        //save user activity to logs
        $activityDetails = [
            'activity_body'=>'<strong>'.$user->username.'</strong>'." updated the profile image ",
        ];

        HelperEvent::dispatch($activityDetails);

        return redirect()->route('member.profile.view', $user_id)->with('success', 'Profile updated successfully');
    }

    /**
     * profile settings / update extra user information
     */
    public function profile_settings($user_id){
        $user = $this->get_user($user_id);
        $countries = Country::get();
        $profile = Profile::where('user_id',$user->id)->first();

        return view('member.profile.settings', compact('user','countries'))
            ->with('profile',$profile)
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    public function get_user($user_id){
        return User::where('user_id', $user_id)->first();
    }

    /**
     * update the extra profile settings
     */
    public function update_profile_settings(Request $request, $user_id){
        $request->validate([
            'about' => 'max:255'
        ]);

        $profileInfo = $request->all();
        $user = $this->get_user($user_id);

        $country = $dob = $website = $gender = $about = "";
        if ($request->has('dob')){
            $dob = $profileInfo['dob'];
        }

        if ($request->has('country')){
            $country = $profileInfo['country'];
        }

        if ($request->has('website')){
            $website = $profileInfo['website'];
        }

        if ($request->has('gender')){
            $gender = $profileInfo['gender'];
        }

        if ($request->has('about')){
            $about = $profileInfo['about'];
        }

        $id = $this->idGenerator->generateUniqueId($user->username,'profiles','profile_id');
        Profile::updateOrCreate(
            ['user_id'=>$user->id],
            [
                'profile_id' => $id,
                'country'=>$country,
                'dob'=>$dob,
                'website'=>$website,
                'gender'=>$gender,
                'about'=>$about
            ]
        );

        //save user activity to logs
        $activityDetails = [
            'activity_body'=>'<strong>'.$user->username.'</strong>'." added additional profile details ",
        ];

        HelperEvent::dispatch($activityDetails);

        return redirect()->route('profile.settings',$user->user_id)->with('info','Profile Updated Successfully');
    }
}
