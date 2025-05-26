<?php

namespace App\Http\Controllers\Api\Flights;

use App\Models\Offer;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\BaseApiController;

class OffersController extends BaseApiController
{
    public function index()
    {   
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $offers = Offer::select($name.' as name',$description.' as description','created_at','valid_upto','id','slug',$this->ApiImage("uploads/offers/"))->get();

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $offers
        ], 200);
    }

    public function OfferDetails($slug)
    {
       
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $offer = Offer::select($name.' as name',$description.' as description',$this->ApiImage("uploads/offers/"),'created_at','valid_upto','id','slug')->where('slug',$slug)->first();

        //$offers = Offer::select($name.' as name',$description.' as description','image','created_at','valid_upto','id','slug')->orderBy('created_at',"DESC")->get();

        if(empty($offer))
        {
            return response()->json([
                'status' => true,
                'message' => trans('lang.no_offers_found'),
                "data" => []
            ], 200);
        }
       
        // dd($offer);

        return response()->json([
            'message' => self::SUCCESS_MSG,
            "data" => $offer
        ], 200);

    }
}
