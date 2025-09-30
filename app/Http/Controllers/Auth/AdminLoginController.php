<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        if(Auth::guard('admin')->user())
        {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }
    // public function login(Request $request)
    // {
    //     // Validate form data
     
       
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|string',
    //         'password' => 'required|string|min:8'
    
    //     ]);
    //     if($validator->fails())
    //     {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Attempt to login as admin
       
    //     if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password,'status' => 'Active' ,'back_end_user' => 1], $request->remember)) {
       
    //         return redirect()->route('admin.dashboard');
    //     }
    //     else{
    //         return redirect()->back()->withErrors(['email' => ' invaild credentails'])->withInput();
    //     }

      

    //     // If unsuccessful then redirect back to login page with email and remember fields
    //     //return redirect()->back()->withInput($request->only('email', 'remember'));

    // }
    public function login(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Attempt login as admin (check active + backend user)
        if (Auth::guard('admin')->attempt([
            'email'        => $request->email,
            'password'     => $request->password,
            'status'       => 'Active',
            'back_end_user'=> 1
        ], $request->remember)) {

            $user = Auth::guard('admin')->user();

            // Logout until OTP verified
            Auth::guard('admin')->logout();

            // Generate OTP
            $otp = rand(100000, 999999);

            // Save OTP & expiry in DB
            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();

            // Send OTP via email
            Mail::send('front_end.email_templates.otp', compact('otp','user'), function($message)use($user) {
                    $message->to($user->email)->subject(env('APP_NAME').' OTP Code for Login');
            });

            // Return JSON so Ajax can switch to OTP form
            return response()->json([
                'success' => true,
                'step'    => 'otp',
                'message' => 'OTP sent to your email. Please verify to continue.',
            ]);
        }

        // Invalid credentials
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials.',
        ], 401);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
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

        // Login user
        Auth::guard('admin')->login($user);
        $request->session()->regenerate();

        return response()->json([
            'success'      => true,
            'redirect_url' => route('admin.dashboard'),
        ]);
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

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
            'message' => 'A new OTP has been sent to your email.',
        ]);
    }



    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
