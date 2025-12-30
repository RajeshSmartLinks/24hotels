<?php

namespace App\Http\Controllers\Auth;

use Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class CustomLoginController extends Controller
{
    public function login(Request $request)
    {
        
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

           
            $otp = rand(100000, 999999);

            // set expiry (5 minutes from now)
            $otpExpiresAt = Carbon::now()->addMinutes(5);

            // store in database
            $user->otp = $otp;
            $user->otp_expires_at = $otpExpiresAt;
            $user->save();

            Auth::logout(); // logout until verified

            // send OTP via email
        
            Mail::send('front_end.email_templates.otp', compact('otp','user'), function($message)use($user) {
                $message->to($user->email)->subject(env('APP_NAME').' OTP Code for Login');
            });

            return response()->json([
                'success'     => false,
                'two_factor'  => true,
                'message'     => 'OTP has been sent to your email.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials.',
        ], 401);
    }

    public function verify2FA(Request $request)
    {
        $request->validate([
            'otp'      => 'required|digits:6',
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email.',
            ], 200);
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password.',
            ], 200);
        }

        // Check OTP from DB
        if ($user->otp !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP code.',
            ], 200);
        }

        // Check expiry if using expiry
        if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired.',
            ], 200);
        }

        // OTP verified → clear OTP and login user
        $user->update([
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);
        $user->update([
            'last_login_at'       => now(),
        ]);
        $route = ($user->first_login == 1) ? route('change-password') : route('home');

        Auth::login($user);
        //Auth::login($user, true);  //forlong run we need to use this
        $request->session()->regenerate();

        return response()->json([
            'success'      => true,
            'redirect_url' => $route,
        ]);
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Generate new OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // Send email

        Mail::send('front_end.email_templates.otp', compact('otp','user'), function($message)use($user) {
                $message->to($user->email)->subject(env('APP_NAME').' OTP Code for Login');
        });

        return response()->json([
            'success' => true,
            'message' => 'New OTP sent successfully.',
        ]);
    }


}
