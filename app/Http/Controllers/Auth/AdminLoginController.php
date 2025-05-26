<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
    public function login(Request $request)
    {
        // Validate form data
     
       
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string|min:8'
    
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt to login as admin
       
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password,'status' => 'Active' ,'back_end_user' => 1], $request->remember)) {
       
            return redirect()->route('admin.dashboard');
        }
        else{
            return redirect()->back()->withErrors(['email' => ' invaild credentails'])->withInput();
        }

      

        // If unsuccessful then redirect back to login page with email and remember fields
        //return redirect()->back()->withInput($request->only('email', 'remember'));

    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
