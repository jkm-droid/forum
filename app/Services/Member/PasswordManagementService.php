<?php

namespace App\Services\Member;

use App\Helpers\GetRepetitiveItems;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordManagementService
{
    use GetRepetitiveItems;

    public function showForgotPassForm()
    {
        return view('user.forgot_pass')
            ->with('forum_list', $this->get_forum_list());
    }

    public function processForgotPassForm($request)
    {
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

    public function showResetPassForm($token)
    {
        return view('user.reset_pass', ['token'=>$token])
            ->with('forum_list', $this->get_forum_list());
    }

    public function processResetPassForm($request)
    {
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
