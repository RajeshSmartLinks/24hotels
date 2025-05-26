<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Offer;
use App\Models\Package;
use App\Models\SeoSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OffersController extends Controller
{
    public function index()
    {
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'offersListing','status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];

        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $offers = Offer::select($name.' as name',$description.' as description','image','created_at','valid_upto','id','slug')->paginate(10);

        $packages = Package::select($name.' as name',$description.' as description','image','created_at','id','slug')->orderBy('created_at',"DESC")->limit(3)->get();

        $offfersCount = Offer::count();
       
        return view('front_end.offer.list',compact('titles','offers','offfersCount','packages'));
    }
    
    public function OfferDetails($slug)
    {
       
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $offer = Offer::select($name.' as name',$description.' as description','image','created_at','valid_upto','id','slug')->where('slug',$slug)->first();

        $offers = Offer::select($name.' as name',$description.' as description','image','created_at','valid_upto','id','slug')->orderBy('created_at',"DESC")->get();

        $packages = Package::select($name.' as name',$description.' as description','image','created_at','id','slug')->orderBy('created_at',"DESC")->limit(3)->get();


        if(empty($offer) || $offer == null)
        {
            $titles = [
                'title' => "Something went wrong",
            ];
            return view('front_end.error',compact('titles'));
        }
        $seoData = SeoSettings::where(['page_type' => 'dynamic' , 'dynamic_page_type' => 'offers','dynamic_page_id'=>$offer->id,'status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        

        return view('front_end.offer.details',compact('titles','offer','offers','packages'));

    }
}
