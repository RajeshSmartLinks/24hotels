<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    CONST API_PAGINATION = 25;
    CONST SUCCESS_MSG = "Success";
    CONST FAILED_MSG = "Failed";

 



    public function __construct()
    {

        /*if (\request()->get('lang')) {
            app()->setLocale(strtolower(request()->get('lang')));
        }
        $setting = \config('settings');
        view()->share(['_setting' => $setting]);*/

    }

    public function ApiImage($path,$dbfiels="image")
    {
        $ApiImageBasepath = env("APP_URL").$path;
        return $image = DB::raw("CONCAT('$ApiImageBasepath',$dbfiels) AS $dbfiels");
    }

    public function sendResponse($status, $keyVal)
    {
        $arrayResponse = [];
        $arrayResponse['status'] = $status;
        foreach ($keyVal as $key => $value) {
            // print_r($value) ;exit;
            $arrayResponse[$key] = $this->nonul($value);
        }
        return response()->json($arrayResponse);
    }

    public function nonul($value)
    {
        if ($value == NULL || $value == '' || empty($value)) {
            $value = array();
        }
        return $value;
    }

    public function emptyObject()
    {
        return $emptyObj = (object)NULL;
    }


    // public function sendFcmNotification($titleAr, $titleEn, $contentAr, $contentEn, $token, $userId = null)
    // {

    //     if ($userId != null) {
    //         if (is_array($userId)) {
    //             foreach ($userId as $item) {
    //                 DB::table('notifications')->insert(['user_id' => $item, 'titleEn' => $titleEn, 'contentEn' => $contentEn, 'titleAr' => $titleAr, 'contentAr' => $contentAr]);
    //             }
    //         } else {
    //             \DB::table('notifications')->insert(['user_id' => $userId, 'titleEn' => $titleEn, 'contentEn' => $contentEn, 'titleAr' => $titleAr, 'contentAr' => $contentAr]);
    //         }
    //     }

    //     $url = "https://fcm.googleapis.com/fcm/send";
    //     $serverKey = env('SERVER_KEY');
    //     $notification = array('title' => $titleEn, 'text' => $contentEn, 'sound' => 'default', 'badge' => '1');
    //     $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');
    //     $json = json_encode($arrayToSend);
    //     $headers = array();
    //     $headers[] = 'Content-Type: application/json';
    //     $headers[] = 'Authorization: key=' . $serverKey;
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     //Send the request
    //     $response = curl_exec($ch);
    //     //Close request
    //     if ($response === FALSE) {
    //         curl_close($ch);
    //         return false;
    //         //die('FCM Send Error: ' . curl_error($ch));
    //     }
    //     curl_close($ch);
    //     return true;


    // }

    function generateAPIToken()
    {
        return $token = hash('sha256', Str::random(60));
    }



    public function amenitesmakeArr($ameneties)
    {
        if (count($ameneties) > 0) {
            foreach ($ameneties as $amenety) {
                $out[$amenety] = $amenety;
            }
        } else {
            $out = array();
        }

        return $out;
    }


}
