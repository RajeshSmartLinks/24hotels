<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use Illuminate\Http\Request;

class NotificationsController extends BaseApiController
{
    public function index(){
        $name = 'title_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $offers = PushNotification::select($name.' as title',$description.' as description')->orderBy('id','desc')->get();

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $offers
        ], 200);
    }
}
