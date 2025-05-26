<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Rules\frontEndEmailCheck;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseApiController;

class RegisterController extends BaseApiController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            //'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed','regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/' ],
        ],[
            'password.regex' => 'password must contain at least one lowercase letter,at least one uppercase letter ,at least one digit,at least one special charactor',


        ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         "message" => $validator->errors(),
        //     ], 200);
        // }
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'user_type' => 'app'
        ]);
        $role = Role::where("slug","user")->first();
        $user->assignRole($role->id);
        $user = User::select('id','email','mobile','country_id','title','date_of_birth','first_name','last_name',$this->ApiImage("/uploads/users/","profile_pic"))->find($user->id);
        $token = $user->createToken('API Token')->accessToken;

        return response([ 'status'=>true,'user' => $user, 'token' => $token]);
       
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required','email','exists:users',new frontEndEmailCheck()],
        ]);
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
      
        $user = User::where('email',$request->email)->first();

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);
        $name = $user->name;

        //return view('front_end.email_templates.forgot-password',compact('token','name'));

        $mailResponse = Mail::send('front_end.email_templates.forgot-password', ['token' => $token,'name'=>$name,'resetPsswordLink'=>route('user-reset.password.get',['token'=>$token]),'image' => asset('frontEnd/images/logo.png')], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
  
        if(count(Mail::failures()) > 0){
            return response([ 'status'=>false,'message' => "something went wrong"]);
        }else{
            return response([ 'status'=>true,'message' => "We have e-mailed your password reset link!"]);
        }
    }


}
