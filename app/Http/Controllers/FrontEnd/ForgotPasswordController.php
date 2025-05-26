<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Rules\frontEndEmailCheck;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        $titles = [
            'title' => "Forgot Password",
        ];
        return view('front_end.auth.forgot_password',compact('titles'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
      
        $request->validate([
            'email' => ['required','email','exists:users',new frontEndEmailCheck()],
        ]);
        $user = User::where('email',$request->email)->first();

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);
        $name = $user->name;

        //return view('front_end.email_templates.forgot-password',compact('token','name'));

        Mail::send('front_end.email_templates.forgot-password', ['token' => $token,'name'=>$name,'resetPsswordLink'=>route('user-reset.password.get',['token'=>$token]),'image' => asset('frontEnd/images/logo.png')], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token) { 
        $titles = [
            'title' => "Reset Password",
        ];

        return view('front_end.auth.reset_password', compact('token','titles'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'new-password' => 'required|string|min:8|confirmed',
            'new-password_confirmation' => 'required'
        ]);
        //dd($request->token);
        $updatePassword = DB::table('password_resets')
                            ->where(['token' => $request->token])
                            ->where('created_at','>',Carbon::now()->subMinutes(60))
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }
        $email = $updatePassword->email;

        $userDetails = User::where('email', $email)->first();

        if (Hash::check($request->input('new-password'), $userDetails->password)) {
            return back()->withInput()->with('error', 'Old password and new password should not be same try another combination');
         }
        
        $user = User::where('email', $email)
                    ->update(['password' => Hash::make($request->input('new-password'))]);

        DB::table('password_resets')->where(['email'=> $email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed!');
    }
}
