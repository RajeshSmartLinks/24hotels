<?php

namespace App\Http\Controllers\FrontEnd;


use App\Models\Role;
use App\Models\User;
use App\Models\Popup;
use App\Models\SeoSettings;
use Illuminate\Http\Request;
use App\Models\WebbedsCountry;
use App\Models\WebbedsHotelSearch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Stevebauman\Location\Facades\Location;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $ip = $request->ip();
        $data = Location::get($ip);
        if(!empty( $data))
        {
            if($data->countryCode == 'KW')
            {
                $currency = "KWD";
                if(app()->getLocale() == 'ar')
                {
                    $fromDestination = array('text' => "الكويت (KWI)" , "airportCode" => "KWI");
                }
                else{
                    $fromDestination = array('text' => "Kuwait (KWI)" , "airportCode" => "KWI");
                }
            }
            elseif($data->countryCode == 'SA')
            {
                $currency = "SAR";
                
            }
            elseif($data->countryCode == 'AE')
            {
                $currency = "AED";
            }
            elseif($data->countryCode == 'BH')
            {
                $currency = "BHD";
            }
            elseif($data->countryCode == 'EG')
            {
                $currency = "EGP";
            }
            elseif($data->countryCode == 'IN')
            {
                $currency = "INR";
            }
            elseif($data->countryCode == 'QA')
            {
                $currency = "QAR";
            }
            elseif(($data->countryCode == 'AT' || $data->countryCode == 'BE' || $data->countryCode == 'HR' || $data->countryCode == 'CY'|| $data->countryCode == 'EE'|| $data->countryCode == 'FI'|| $data->countryCode == 'FR'|| $data->countryCode == 'DE'|| $data->countryCode == 'GR'|| $data->countryCode == 'IE'|| $data->countryCode == 'IT'|| $data->countryCode == 'LV'|| $data->countryCode == 'LT'|| $data->countryCode == 'LU'|| $data->countryCode == 'MT' || $data->countryCode == 'PT'|| $data->countryCode == 'NL'|| $data->countryCode == 'SK'|| $data->countryCode == 'SI'|| $data->countryCode == 'ES'))
            {
                $currency = "EUR";
            }
            elseif($data->countryCode == 'US')
            {
                $currency = "USD";
            }
            else{
                $currency = "USD";
            }
            session(['currency' => $currency]);
            Config::set('app.currency' , $currency);
        }
        else{
            $currency = 'USD';
            session(['currency' => $currency]);
            Config::set('app.currency' , $currency);

        }

        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'home','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];

        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();

        $countries      = WebbedsCountry::get();


        // $recentSearches = [];
        // if(isset(auth()->user()->id)){
        //     $recentSearches = WebbedsHotelSearch::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->limit(3)->get();
        // }
       


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