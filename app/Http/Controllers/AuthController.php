<?php

namespace App\Http\Controllers;

use App\HelperFunctions\MyHelperClass;
use App\Jobs\EmailVerificationJob;
use App\Models\User;
use App\Models\UserVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\HelperFunctions\MakeAvatars;

class AuthController extends Controller
{
    private $idGenerator;

    public function __construct(MyHelperClass $myHelperClass){
        $this->middleware('guest')->except( 'logout');
        $this->idGenerator = $myHelperClass;
    }

    /**
     * show the login page
     * */
    public function show_login_page(){
        return view('user.login');
    }

    /**
     * attempt to login user to the system
     * */
    public function login(Request $request){

        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);

        $info = $request->all();
        $credentials = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(Auth::attempt(array($credentials=>$info['username'], 'password'=>$info['password']))){//, 'is_email_verified'=>1

//            return redirect()->setIntendedUrl(url('/'));
            return redirect()->route('site.home')->with('success', 'logged in successfully');
        }

        return redirect()->route('show.login')->with('error', 'Error, login details are incorrect');
    }

    /**
     * show the register page
     * */
    public function show_register_page()
    {
        return view('user.register');
    }

    /**
     * create a new user
     * */
    public function register(Request $request){
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
        $user = $this->create($user_data, $picture);

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

    /**
     *
     * create the user
     */
    public function create(array $data, $profile_url){
        return User::create([
            'user_id'=>$this->idGenerator->generateUniqueId($data['username'],'users','user_id'),
            'username'=>$data['username'],
            'email'=>$data['email'],
            'profile_url'=>$profile_url,
            'password'=>Hash::make(trim($data['password']))
        ]);
    }

    /**
     * verify user email
     */
    public function verify_user_email($token){
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
     * logout user from the system
     * */
    public function logout(Request $request){

        Auth::logout();
        Session::flush();

        $request->session()->invalidate();
        return redirect()->route('user.show.login')->with('success', 'Logged out successfully');

    }

    public function show_forgot_pass_form(){
        return view('user.forgot_pass');
    }

    public function submit_forgot_pass_form(Request $request){
        $request->validate([
            'email'=>'required|email',
        ]);

        //generate token
        $token = Str::random(65);
        DB::table('password_resets')->insert([
            'email'=>trim($request->email),
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);

        Mail::send('mail.forgot_pass', ['token'=>$token], function ($message) use($request){
            $message->to($request->email);
            $message->subject('Ask and you shall receive...Reset Password');
        });

        return redirect()->route('user.show.forgot_pass_form')->with('success', 'We have emailed a reset link to '.$request->email);
    }

    public function show_reset_pass_form($token){
        return view('user.reset_pass', ['token'=>$token]);
    }

    public function reset_pass(Request $request){
        $request->validate([
            'email'=>'email|exists:users',
            'password'=>'required|string|min:6|same:password_confirm',
            'password_confirm'=>'required|min:6'
        ]);

        $info = $request->all();
        $email = trim($info['email']);
        $password = trim($info['password']);
        $token = $request->token;

        $new_password = DB::table('password_resets')->where([
            'email'=>$email,
            'token'=>$token
        ])->first();

        if (!$new_password){
            return back()->withInput()->with('error','Invalid token');
        }

        User::where('email', $email)->update(['password'=>Hash::make($password)]);
        DB::table('password_resets')->where(['email'=>$email])->delete();

        return redirect()->route('show.login')->with('success', 'Password changed successfully, Login');
    }
}
