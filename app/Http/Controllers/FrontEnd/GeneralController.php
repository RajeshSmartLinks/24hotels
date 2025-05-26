<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Faq;
use App\Models\SeoSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class GeneralController extends Controller
{
    public function Faq()
    {
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'faq','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        $name = 'question_' . app()->getLocale();
        $answer = 'answer_' . app()->getLocale();
    
        $faqs = Faq::select($name.' as question',$answer.' as answer')->whereStatus('Active')->get();
        return view('front_end.general.faq',compact('titles','faqs'));
    }
    public function TermsOfUse()
    {
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'termsOfUse','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
   
        return view('front_end.general.terms_and_conditions',compact('titles'));

    }

    public function PrivacyPolicy()
    {
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'privacyPolicy','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
   
        return view('front_end.general.privacy_policy',compact('titles'));

    }

    public function changeLang($lang)
    {
        session(['lang' => $lang]);
        return redirect()->back();
    }

    public function changecurrency($currency)
    {
        Cache::forget('currencyDetails');
        session(['currency' => $currency]);
        return redirect()->back();
    }

    public function flightbooking()
    {
        
        $titles = [
            'title' => "Flight-booking",
        ];
        
        return view('front_end.general.flightbooking',compact('titles'));
    }
    

    
}
