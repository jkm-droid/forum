<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except( 'logout');
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
        if(Auth::attempt(array($credentials=>$info['username'], 'password'=>$info['password']))){

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
        $this->create($user_data);

        return redirect()->route('show.login')
            ->with('success', 'registered successfully');
    }

    /**
     *
     * create the user
     */
    public function create(array $data){
        return User::create([
            'username'=>$data['username'],
            'email'=>$data['email'],
            'password'=>Hash::make(trim($data['password']))
        ]);
    }

    /**
     * logout user from the system
     * */
    public function logout(Request $request){

        Auth::logout();
        Session::flush();

        $request->session()->invalidate();
        return redirect()->route('show.login')->with('success', 'Logged out successfully');

    }

    public function show_forgot_pass_form(){
        return view('user.forgot_pass');
    }

    public function submit_forgot_pass_form(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users',
        ]);

        //generate token
        $token = Str::random(65);
        DB::table('password_resets')->insert([
            'email'=>trim($request->email),
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);

        Mail::send('mails.forgot_pass', ['token'=>$token], function ($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password Notification');
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
