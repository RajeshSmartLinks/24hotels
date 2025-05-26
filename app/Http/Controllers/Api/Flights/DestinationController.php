<?php

namespace App\Http\Controllers\Api\Flights;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseApiController;

class DestinationController extends BaseApiController
{
    public function index()
    {   
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $destination = Destination::select($name.' as name',$description.' as description','created_at','id','slug',$this->ApiImage("/uploads/destinations/"))->where('status','Active')->orderBy('order','DESC')->get();

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $destination
        ], 200);
    }
    public function Details($slug)
    {
       
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $destination = Destination::select($name.' as name',$description.' as description',$this->ApiImage("uploads/destinations/"),'created_at','id','slug')->where('slug',$slug)->first();



        if(empty($destination))
        {
            return response()->json([
                'status' => true,
                'message' => trans('lang.no_destination_found'),
                "data" => []
            ], 200);
        }
       

        return response()->json([
            'message' => self::SUCCESS_MSG,
            "data" => $destination
        ], 200);

    }

}
