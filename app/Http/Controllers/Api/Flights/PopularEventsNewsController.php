<?php

namespace App\Http\Controllers\Api\Flights;

use App\Http\Controllers\Controller;
use App\Models\PopularEventNews;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;

class PopularEventsNewsController extends BaseApiController
{
    public function index()
    {   
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $popularEventsnews = PopularEventNews::select($name.' as name',$description.' as description','created_at','id','slug',$this->ApiImage("/uploads/popular_events_news/"))->where('status','Active')->orderBy('order','DESC')->get();

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $popularEventsnews
        ], 200);
    }
    public function Details($slug)
    {
       
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $PopularEventNews = PopularEventNews::select($name.' as name',$description.' as description',$this->ApiImage("uploads/popular_events_news/"),'created_at','id','slug')->where('slug',$slug)->first();



        if(empty($PopularEventNews))
        {
            return response()->json([
                'status' => true,
                'message' => trans('lang.no_popular_events_news_found'),
                "data" => []
            ], 200);
        }
       

        return response()->json([
            'message' => self::SUCCESS_MSG,
            "data" => $PopularEventNews
        ], 200);

    }
}
