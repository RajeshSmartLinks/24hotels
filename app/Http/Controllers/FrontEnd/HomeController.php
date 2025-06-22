<?php

namespace App\Http\Controllers\FrontEnd;


use App\Models\SeoSettings;
use App\Models\WebbedsCountry;
use App\Models\Popup;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $ip = $request->ip();

        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'home','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];

        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();

        $countries      = WebbedsCountry::get();

        //popup info

        $popUp = Popup::first();

        return view('front_end.index',compact('titles' ,'countries','popUp'));
    }
    
    
    public function contactUs()
    {
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'contactUs','status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        return view('front_end.contact_us',compact('titles'));
    }

    public function somethingWentWrong()
    {
        $titles = [
            'title' => "Something went wrong",
        ];
        return view('front_end.error',compact('titles'));
    }


    public function Signup(Request $request)
    {
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'signUp','status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        return view('front_end.auth.signup',compact('titles'));
    }

    public function CreateFrontEndUser(Request $request)
    {
        $this->validate($request,[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            //'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
         ]);
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
           // 'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'user_type' => 'web'
        ]);
        $role = Role::where("slug","user")->first();
        $user->assignRole($role->id);
        if($user)
        {
            return redirect()->route('login')->with('message', 'Your Account have been created');
        }
    }


}