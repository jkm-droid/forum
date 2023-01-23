<?php

namespace App\Services\Member;

use App\Helpers\GetRepetitiveItems;
use App\Helpers\MakeAvatars;
use App\Helpers\HelperService;
use App\Jobs\EmailVerificationJob;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MemberAuthService
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

    public function showLoginPage()
    {
        return view('user.login')
            ->with('forum_list', $this->get_forum_list());
    }

    public function loginUser($request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);

        $info = $request->all();
        $credentials = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(Auth::attempt(array($credentials=>$info['username'], 'password'=>$info['password']))){//, 'is_email_verified'=>1

//            return redirect()->setIntendedUrl(url('/'));
            return redirect()->intended(route('site.home'))->with('success', 'logged in successfully');
        }

        return redirect()->route('show.login')->with('error', 'Error, login details are incorrect');
    }

    public function showRegisterPage()
    {
        return view('user.register')
            ->with('forum_list', $this->get_forum_list());
    }

    public function registerUser($request)
    {
        $request->validate([
            'username'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'password_confirm'=>'required|min:6|same:password',
        ]);

        $user_data = $request->all();

        /** Make avatar */
        $path = 'profile_pictures/';
        $fontPath = public_path('fonts/Oliciy.ttf');
        $char = strtoupper($request->username[1]);
        $newAvatarName = trim($user_data['username']).'_avatar.png';
        $dest = $path.$newAvatarName;

        $avatar = new MakeAvatars();

        $createAvatar = $avatar->makeAvatar($fontPath,$dest,$char);
        $picture = $createAvatar == true ? $newAvatarName : '';

        //create a new user
        $user = $this->createUser($user_data, $picture);

        //send email verification message
        $token = Str::random(70);
        UserVerification::create([
            'user_id'=>$user->id,
            'token'=>$token
        ]);
        $details = [
            'username'=>$user_data['username'],
            'token'=> $token,
        ];

        //send the email
        EmailVerificationJob::dispatch($user_data['email'], $details);

        return redirect()->route('show.login')
            ->with('success', 'Registered successfully. An email verification link has been sent to '.$user_data['email']);
    }

    public function logoutUser($request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->invalidate();

        return redirect()->route('user.show.login')->with('success', 'Logged out successfully');
    }

    public function verifyUserEmail($token)
    {
        $userVerify = UserVerification::where('token', $token)->first();
        $message = 'Your email cannot be recognized';

        if (!is_null($userVerify)){
            $user = $userVerify->user;

            if (!$user->is_email_verified){
                $userVerify->user->is_email_verified = 1;
                $userVerify->user->save();
                $message = "Email has been verified. You can now login";
            }else{
                $message = "Seems like your email is already verified. You can now login";
            }
        }

        return redirect()->route('show.login')->with('success', $message);
    }

    /**
     *
     * create the user
     */
    private function createUser(array $data, $profile_url){
        return User::create([
            'user_id'=>$this->_helperService->generateUniqueId($data['username'],'users','user_id'),
            'username'=>$data['username'],
            'email'=>$data['email'],
            'profile_url'=>$profile_url,
            'password'=>Hash::make(trim($data['password']))
        ]);
    }

}
