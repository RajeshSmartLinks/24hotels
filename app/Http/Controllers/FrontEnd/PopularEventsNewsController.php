<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Offer;
use App\Models\Package;
use App\Models\SeoSettings;
use Illuminate\Http\Request;
use App\Models\PopularEventNews;
use App\Http\Controllers\Controller;

class PopularEventsNewsController extends Controller
{
    public function Details($slug)
    {
       
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $popularEvents = PopularEventNews::select($name.' as name',$description.' as description','image','created_at','meta_tag_keywords' , 'meta_tag_description','id','slug')->where('slug',$slug)->first();

        $offers = Offer::select($name.' as name',$description.' as description','image','created_at','valid_upto','id','slug')->orderBy('created_at',"DESC")->get();

        $packages = Package::select($name.' as name',$description.' as description','image','created_at','id','slug')->orderBy('created_at',"DESC")->limit(3)->get();


        if(empty($popularEvents) || $popularEvents == null)
        {
            $titles = [
                'title' => "Something went wrong",
            ];
            return view('front_end.error',compact('titles'));
        }
        $seoData = SeoSettings::where(['page_type' => 'dynamic' , 'dynamic_page_type' => 'popularEvents','dynamic_page_id'=>$popularEvents->id,'status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        $titles = [
            'title' => "Popular Events News",
            'keywords' => $popularEvents->meta_tag_keywords,
            'description' => $popularEvents->meta_tag_description,
        ];

        return view('front_end.popular_events_news.details',compact('titles','popularEvents','offers','packages'));

    }
}
