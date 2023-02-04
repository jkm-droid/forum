<?php

namespace App\Http\Controllers\Member;

use App\Events\AppHelperEvent;
use App\Helpers\GetRepetitiveItems;
use App\Helpers\AppHelperService;
use App\Models\BookMark;
use App\Models\Country;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Topic;
use App\Models\User;
use App\Models\View;
use App\Services\Member\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;

class ProfileController extends Controller
{
    /**
     * @var ProfileService
     */
    private $_profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->middleware('auth');
        $this->_profileService = $profileService;
    }

    /**
     * show a user their profile
     */
    public function view_profile($user_id)
    {
       return $this->_profileService->viewProfile($user_id);
    }

    /**
     * show the profile edit form
     */
    public function show_profile_edit_form($user_id)
    {
        return $this->_profileService->profileEditForm($user_id);
    }

    /**
     * Update the user's profile
     **/
    public function update_profile_picture(Request $request, $user_id)
    {
        return $this->_profileService->updateProfilePicture($request,$user_id);
    }

    /**
     * profile settings / update extra user information
     */
    public function profile_settings($user_id)
    {
        return $this->_profileService->profileSettings($user_id);
    }

    /**
     * update the extra profile settings
     */
    public function update_profile_settings(Request $request, $user_id)
    {
        return $this->_profileService->updateProfileSettings($request,$user_id);
    }
}
