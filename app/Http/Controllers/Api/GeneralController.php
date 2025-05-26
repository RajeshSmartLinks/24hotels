<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\AppAds;
use App\Models\AppVersion;

class GeneralController extends BaseApiController
{
    public function appVersion()
    {
        $appversion = AppVersion::find(1);
        $appAds = AppAds::select($this->ApiImage("/uploads/ads/",'image'),'link')->where("status","Active")->get();
        $response = ["status" =>true ,"message" => "App Versions" , 'data' => array( 'vesions' => $appversion, 'ads'=>$appAds) ];

        // $response = ["status" =>true ,"message" => "App Versions" , 'data' => array( 'vesions' => $appversion, 'ads'=>array(
        //     array('image' => asset('frontEnd/images/mobile_ad_1.jpg') , 'link'=> null),
        //     array('image' => asset('frontEnd/images/mobile_ad_2.jpg') , 'link'=> null)
        // ) ) ];
        return response($response, 200);
    }

    public function redirect(Request $request)
    {
        $url = $request['url'];
        $paymentId = $request['paymentId'];
        $url = $url.'?paymentId='.$paymentId;
        return view('flutter_app.holding_page', compact('url'));
    }
}
