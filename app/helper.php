<?php

use DOMDocument;
use App\Models\Coupon;
use App\Models\MarkUp;
use GuzzleHttp\Client;
use App\Models\Airport;
use App\Models\Currency;
use App\Models\HotelMarkUp;
use Illuminate\Support\Str;
use App\Models\AppliedCoupon;
use Illuminate\Support\Carbon;
use App\Models\AdditionalPrice;
use App\Services\FirebaseService;
use App\Models\HotelAdditionalPrice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Air\SearchController;

if (! function_exists('DateTimeSpliter')) {
    function DateTimeSpliter($dateTime, $type )
    {
       $Dt = explode("T",$dateTime);
       if($type == "date")
       {
            return $Dt[0];
       }
       if($type == "time")
       {
            $time = explode(".",$Dt[1]);
            return substr($time[0],0,5);
       }
    }
}

//P1DT11H21M0S
// PT1H35M0.000S

if (! function_exists('TimeTravel')) {
    function TimeTravel($string,$type='')
    {
        $string = explode('.',$string);
        $string = $string[0];
        // echo '<br>';
        // echo  $string;
        $days = 0;
        $hours = 0;
        $min = 0;
        $seconds = 0;

        if($type == 'airarabia')
        {
            if (preg_match('/P(.*?)DT/', $string, $match) == 1) {
                $days = $match[1];
            }
            if (preg_match('/T(.*?)H/', $string, $match) == 1) {
                $hours = $match[1];
            }
            if (preg_match('/H(.*?)M/', $string, $match) == 1) {
                $min = $match[1];
            }
            if (preg_match('/M(.*?)S/', $string, $match) == 1) {
                $seconds = $match[1];
            }
            if($days == 0 )
            {
                return $hours."H ".$min."M ";
            }
            else{
                return $days."D ".$hours."H ".$min."M ";

            }

        }
        else{
            if (preg_match('/P(.*?)DT/', $string, $match) == 1) {
                $days = $match[1];
            }
            if (preg_match('/DT(.*?)H/', $string, $match) == 1) {
                $hours = $match[1];
            }
            if (preg_match('/H(.*?)M/', $string, $match) == 1) {
                $min = $match[1];
            }
            if (preg_match('/M(.*?)S/', $string, $match) == 1) {
                $seconds = $match[1];
            }
            if($days == 0 )
            {
                return $hours."H ".$min."M ";
            }
            else{
                return $days."D ".$hours."H ".$min."M ";

            }

        }




    }
}
if (! function_exists('Connections')) {
    function Connections($number)
    {
        if($number == 0)
        {
            return "Non Stop";
        }
        elseif($number >0)
        {
            return $number." Stop";
        }
    }
}
if (! function_exists('segmentTime')) {
    function segmentTime($number)
    {
        if(!empty($number))
        {
            //dd($number);
            // $s = $number%60;
            // $m = floor(($number%3600)/60);
            // $h = floor(($number%86400)/3600);
            // $d = floor(($number%2592000)/86400);
            $days = floor($number/(60*24));
            $hour = floor(($number%(60*24))/(60));
            $min =  $number%(60*24)%60;
            if($hour < 10)
            {
                $hour = "0".$hour;
            }
            if($min < 10)
            {
                $min = "0".$min;
            }
            if($days > 0)
            {
                return $days."d ".$hour."h ".$min."m";
            }
            else{
                return $hour."h ".$min."m";
            }
        }


    }
}
if (! function_exists('clean')) {
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}
if (! function_exists('AES_Encrypt')) {
    function AES_Encrypt($string) {
        $aesObj = new AES();
        $response = $aesObj->encrypt($string, 'JKj178jircAPx7h4CbGyY', 'The@1234');
       return $response;
    }
}
if (! function_exists('AES_Decrypt')) {
    function AES_Decrypt($string) {
        $aesObj = new AES();
        $response = $aesObj->decrypt($string, 'JKj178jircAPx7h4CbGyY', 'The@1234');
       return $response;
    }
}

if (! function_exists('unique_slug')) {
    function unique_slug($title = '', $model = 'Ad', $id = '')
    {
        //dd($title, $model,$id);
        $slug = Str::slug($title);
        //get unique slug...
        $nSlug = $slug;
        $i = 0;

        $model = str_replace(' ', '', "\App\Models\ " . $model);
        $slugcount = $model::whereSlug($nSlug);
        if (!empty($id)) {
            $slugcount = $slugcount->where('id', '!=', $id);
        }
        $slugcount = $slugcount->count();
       // ddd($slugcount);

        while ($slugcount > 0) {
            $i++;
            $nSlug = $slug . '-' . $i;
        }
        if ($i > 0) {
            $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
        } else {
            $newSlug = $slug;
        }
        return $newSlug;
    }
}

//function for deleteImage image

if (! function_exists('deleteImage')) {
 function deleteImage($imagePath, $imageName)
    {
        $originalPath = $imagePath;

        // Delete the previous image
        $imageCheck = $originalPath . $imageName;

        if (File::exists($imageCheck)) {
            \File::delete($imageCheck);
        }
        return true;
    }
}

//function for translation

if (! function_exists('aztran')) {
    function aztran($key, $lang = '')
    {
        $lang = empty($lang) ? app()->getLocale() : $lang;
        $value = 'message_' . $lang;

        $rs = \App\Models\Translation::whereMessageKey($key)->first();
        if ($rs) {
            return $rs->$value;
        }
        return '';
    }
}

//function for LayoverTime calculation

if (! function_exists('LayoverTime')) {
    function LayoverTime($arrTime, $depTime )
    {
        if(empty($arrTime) || empty($arrTime))
        {
            return '';
        }
        // 2022-09-30T22:25:00.000+05:30
        $arrTime = str_replace("T" , ' ',explode('.',explode('+',$arrTime)[0])[0]) ;
        $depTime = str_replace("T" , ' ',explode('.',explode('+',$depTime)[0])[0]) ;
        $start_datetime = new DateTime($arrTime);
        $diff = $start_datetime->diff(new DateTime($depTime));
        $layoverTime = '';
        if($diff->d > 0)
        {
            $layoverTime .= $diff->d.'D ';
        }
        if($diff->h > 0)
        {
            $layoverTime .= $diff->h.'H ';
        }
        if($diff->i > 0)
        {
            $layoverTime .= $diff->i.'M ';
        }

        return $layoverTime;


        // echo $diff->d.' Days<br>';
        // echo $diff->h.' Hours<br>';
        // echo $diff->i.' Minutes<br>';
        // echo $diff->s.' Seconds<br>';
        // exit;
        //$depTime = explode('.',explode('+',$depTime)[0])[0];

    }
}

//check if exist or empty
if (! function_exists('checkExistance')) {
    function checkExistance($key)
    {
        if(isset($key))
        {
            return $key;

        }
        else{
            return '';
        }
    }
}

//split currencycode and currency
if (! function_exists('splitCurrency')) {
    function splitCurrency($string)
    {
        if(isset($string))
        {

            return array(
                'currency_code' => substr($string, 0, 3),
                'value' => substr($string,3),
            );

        }
        else{
            return '';
        }
    }
}

//Mark Up total Price
if (! function_exists('markUpPrice')) {
    function markUpPrice($totalPrice , $tax , $basefare , $paymentType = 'k_net' ,$additional = [])
    {
        if(isset($totalPrice))
        {
            //original
            /*$price = array(
                'totalPrice' =>array(
                    'currency_code' => (count($additional) > 0 && $additional['from'] == 'airarabia') ? $additional['currency_code'] : substr($totalPrice, 0, 3) ,
                    'value' => (count($additional) > 0 && $additional['from'] == 'airarabia') ? $totalPrice : substr($totalPrice,3),
                ),
                'tax' =>array(
                    'currency_code' => (count($additional) > 0 && $additional['from'] == 'airarabia') ? $additional['currency_code'] : substr($tax, 0, 3) ,
                    'value' => (count($additional) > 0 && $additional['from'] == 'airarabia') ? $tax : substr($tax,3),

                    // 'currency_code' => substr($tax, 0, 3),
                    // 'value' => substr($tax,3),
                ),
                'basefare' =>array(
                    'currency_code' => (count($additional) > 0 && $additional['from'] == 'airarabia') ? $additional['currency_code'] :substr($basefare, 0, 3) ,
                    'value' => (count($additional) > 0 && $additional['from'] == 'airarabia') ? $basefare : sprintf("%.3f", substr($basefare,3)),

                    // 'currency_code' => substr($basefare, 0, 3),
                    // 'value' =>  sprintf("%.3f", substr($basefare,3)),
                )
            );
            // dd($price);
            $MarkUp = Cache::remember('MarkUpPrice', 60*60*24*30, function () {
                return  MarkUp::where('status' , 'Active')->where('id' , 1)->first();
            });*/


            $price = array(
                'totalPrice' => array(
                    'currency_code' => (count($additional) > 0 && isset($additional['from']) && ($additional['from'] == 'airarabia' || $additional['from'] == 'airjazeera')) ? $additional['currency_code'] : substr($totalPrice, 0, 3),
                    'value' => (count($additional) > 0 && isset($additional['from']) && ($additional['from'] == 'airarabia' || $additional['from'] == 'airjazeera')) ? $totalPrice : substr($totalPrice, 3),
                ),
                'tax' => array(
                    'currency_code' => (count($additional) > 0 && isset($additional['from']) && ($additional['from'] == 'airarabia' || $additional['from'] == 'airjazeera')) ? $additional['currency_code'] : substr($tax, 0, 3),
                    'value' => (count($additional) > 0 && isset($additional['from']) && ($additional['from'] == 'airarabia' || $additional['from'] == 'airjazeera')) ? $tax : substr($tax, 3),

                    // 'currency_code' => substr($tax, 0, 3),
                    // 'value' => substr($tax,3),
                ),
                'basefare' => array(
                    'currency_code' => (count($additional) > 0 && isset($additional['from']) && ($additional['from'] == 'airarabia' || $additional['from'] == 'airjazeera')) ? $additional['currency_code'] : substr($basefare, 0, 3),
                    'value' => (count($additional) > 0 && isset($additional['from']) && ($additional['from'] == 'airarabia' || $additional['from'] == 'airjazeera')) ? $basefare : sprintf("%.3f", substr($basefare, 3)),

                    // 'currency_code' => substr($basefare, 0, 3),
                    // 'value' =>  sprintf("%.3f", substr($basefare,3)),
                )
            );
            // dd($price);
            $cacheName = 'MarkUpPrice';
            $markUpId = 1;
            if(Auth::guard('web')->check() && auth()->user()->is_agent == 1)
            {
                $cacheName = "MarkUpPrice".auth()->user()->id;
            }
            $MarkUp = Cache::remember($cacheName, 60 * 60 * 24 * 30, function () {
                if(Auth::guard('web')->check() && auth()->user()->is_agent == 1)
                {
                    return MarkUp::where('status', 'Active')->where('user_id', auth()->user()->id)->first();
                }else{
                    return MarkUp::where('status', 'Active')->where('id', 1)->first();
                }
            });

            if(!empty($MarkUp))
            {

                $markupValue = ($MarkUp->fee_value == 'fixed') ?  $MarkUp->fee_amount : ($price['totalPrice']['value']*($MarkUp->fee_amount/100)) ;

                $price['totalPrice']['value'] =  sprintf("%.3f", ($MarkUp->fee_type == 'addition') ? ($price['totalPrice']['value'] + $markupValue) : ($price['totalPrice']['value'] - $markupValue));

                $price['tax']['value'] = sprintf("%.3f", ($MarkUp->fee_type == 'addition') ? ($price['tax']['value'] + $markupValue) : ($price['tax']['value'] - $markupValue));

                $currency = config('app.currency');

                $currencyDetails = Cache::remember('currencyDetails', 60*60*24*30, function () use($currency) {
                    return  Currency::where("currency_code_en",$currency)->first();
                });
                if($currencyDetails->currency_code_en!=$currency)
                {
                    Cache::forget('currencyDetails');
                    $currencyDetails = Cache::remember('currencyDetails', 60*60*24*30, function () use($currency) {
                        return  Currency::where("currency_code_en",$currency)->first();
                    });
                }

                $serviceFee = Cache::remember('serviceFee', 60*60*24*30, function () use($currency) {
                    return  AdditionalPrice::where('status','Active')->first();
                });

                if(!empty($currencyDetails))
                {
      
                    $price['standed_price']['currency_code'] = $price['FatoorahPaymentAmount']['currency_code'] = $price['totalPrice']['currency_code'];
                    $price['standed_price']['value'] = $price['FatoorahPaymentAmount']['value'] =  $price['totalPrice']['value'];
                    
                    $price['totalPrice']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['totalPrice']['value'] = sprintf("%.3f",$price['totalPrice']['value']*$currencyDetails->conversion_rate);

                    $price['tax']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['tax']['value'] = sprintf("%.3f",$price['tax']['value']*$currencyDetails->conversion_rate);

                    $price['basefare']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['basefare']['value'] = sprintf("%.3f",$price['basefare']['value']*$currencyDetails->conversion_rate);

                    $price['service_chargers']['currency_code'] = "KWD";
                    $price['service_chargers']['value']  = '0.000';

                    $price['previewDisplay']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['previewDisplay']['value'] = $price['totalPrice']['value'];
                    $price['FatoorahPaymentAmount']['value'] = (float)$price['FatoorahPaymentAmount']['value'];

                    $price['coupon']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['coupon']['value'] = '0.000';
                    $price['standed_coupon']['value'] = '0.000';

                    $price['actual_amount']['value'] = sprintf("%.3f",$price['FatoorahPaymentAmount']['value']);

                    
                    $price['coupon']['id'] = null;
                    $CouponAmount = 0;

                    if(isset($additional['couponCode']) && !empty($additional['couponCode'])){

                        $couponCode = $additional['couponCode'];

                        $currentDate = Carbon::now()->toDateString();

                        $couponDetails = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->where('coupon_code' , $couponCode)->whereIn('coupon_valid_on' ,[2,3])->first();


                        if(empty($couponDetails)){
                            //invalid Coupon
                        }else{
                            $userId = null ;
                            if(isset($additional['RequestIsFrom']) && $additional['RequestIsFrom'] == 'api'){
                                if(Auth::guard('api')->check()){
                                    $userId = Auth::guard('api')->user()->id ;
                                }
                            }else{
                                if(Auth::check()){
                                    $userId = Auth::guard('web')->user()->id ;
                                }
                            }
                            
                            if(!empty($userId)){
                                $pastAppliedCouponsList = AppliedCoupon::where('coupon_id',$couponDetails->id)->where('user_id',$userId)->get();
                                $numberOfTimesApplied = count($pastAppliedCouponsList);
                                

                                if(($couponDetails->coupon_valid_for == '0' ) || ( $couponDetails->coupon_valid_for >= $numberOfTimesApplied)){
                                    if($couponDetails->coupon_type == 'percentage'){
                                        $CouponAmount = sprintf("%.3f",$price['standed_price']['value']*(($couponDetails->coupon_amount)/100));
                                    }else{
                                        $CouponAmount =  sprintf("%.3f",$couponDetails->coupon_amount);
                                    }
                                    $price['coupon']['id'] = $couponDetails->id;
                                }else{
                                    //coupon Already used
                                }

                            }
                            
                        }

                    }

                    if(!empty($serviceFee))
                    {
                        if($paymentType == "k_net")
                        {
                            $price['service_chargers']['currency_code'] = $currencyDetails->currency_code_en;
                            $price['service_chargers']['value'] = sprintf("%.3f",$serviceFee->additional_price * $currencyDetails->conversion_rate) ;
                            $extrafee = $serviceFee->additional_price;
                            $price['service_chargers']['type_of_payment'] = 'k_net';

                        }
                        elseif($paymentType == "credit_card")
                        {
                            //for credit card amount will be + 3.0%
                            $creditCardpercentage = $serviceFee->credit_card_percentage * 0.01;
                            $price['service_chargers']['currency_code'] = $currencyDetails->currency_code_en;
                            $price['service_chargers']['value'] = sprintf("%.3f",($price['standed_price']['value'] * $creditCardpercentage) * $currencyDetails->conversion_rate) ;
                            //echo $extrafee = $price['standed_price']['value'] * 0.03;
                            $extrafee =  $price['standed_price']['value'] * $creditCardpercentage;
                            $price['service_chargers']['type_of_payment'] = 'credit_card';
                        }else{
                            $price['service_chargers']['currency_code'] = $currencyDetails->currency_code_en;
                            $price['service_chargers']['value'] = sprintf("%.3f",$serviceFee->wallet_price * $currencyDetails->conversion_rate) ;
                            $extrafee = $serviceFee->wallet_price;
                            $price['service_chargers']['type_of_payment'] = 'wallet';

                        }
                        $price['previewDisplay']['currency_code'] = $currencyDetails->currency_code_en;
                        $price['previewDisplay']['value'] = sprintf("%.3f",($price['standed_price']['value'] + $extrafee - $CouponAmount)*($currencyDetails->conversion_rate));

                        $price['FatoorahPaymentAmount']['currency_code'] = $price['standed_price']['currency_code'];

                        $price['actual_amount']['value'] = sprintf("%.3f",($price['standed_price']['value'] + $extrafee));
                        
                        $price['FatoorahPaymentAmount']['value'] = $price['standed_price']['value'] + $extrafee - $CouponAmount;
                        $price['FatoorahPaymentAmount']['value'] = (float)$price['FatoorahPaymentAmount']['value'];

                        if($CouponAmount != 0)
                        {
                            $price['standed_coupon']['value'] = sprintf("%.3f",$CouponAmount);
                            $price['coupon']['value'] = sprintf("%.3f",$CouponAmount * $currencyDetails->conversion_rate);
                        }
                        
                        
                    }
                }
            }

        }
        else{
            $price = array(
                'totalPrice' => array('currency_code' => 'KWD','value' => 0),
                'tax'        => array('currency_code' => 'KWD','value' => 0),
                'basefare'   => array('currency_code' => 'KWD','value' => 0)
            );

        }
        //dd($price);
        return $price;

    }
}

if (! function_exists('extraPricing')) {
    function extraPricing($data)
    {
        $price = array(
            'total_price' => array('currency_code' => 'KWD','value' => 0),
            'standed_price' => array('currency_code' => 'KWD','value' => 0),
        );
        if(isset($data['amount']))
        {

            $price = array(
                'total_price' =>array(
                    'currency_code' => ( $data['from'] == 'airarabia') ? $data['currency_code'] : substr($data['amount'], 0, 3) ,
                    'value' => ( $data['from'] == 'airarabia') ? $data['amount'] : substr($data['amount'],3),
                ),

            );
            $price['standed_price']['currency_code'] =  $price['total_price']['currency_code'];
            $price['standed_price']['value'] =  $price['total_price']['value'];

            if(isset($data['withOutMarkUp']) && $data['withOutMarkUp'] == true  )
            {
                $MarkUp = [];
            }
            else{

                $cacheName = 'MarkUpPrice';
                $markUpId = 1;
                if(Auth::guard('web')->check() && auth()->user()->is_agent == 1)
                {
                    $cacheName = "MarkUpPrice".auth()->user()->id;
                }
                $MarkUp = Cache::remember($cacheName, 60 * 60 * 24 * 30, function () {
                    if(Auth::guard('web')->check() && auth()->user()->is_agent == 1)
                    {
                        return MarkUp::where('status', 'Active')->where('user_id', auth()->user()->id)->first();
                    }else{
                        return MarkUp::where('status', 'Active')->where('id', 1)->first();
                    }
                });


                // $MarkUp = Cache::remember('MarkUpPrice', 60*60*24*30, function () {
                //     return  MarkUp::where('status' , 'Active')->where('id' , 1)->first();
                // });
            }


            $currency = config('app.currency');

            $currencyDetails = Cache::remember('currencyDetails', 60*60*24*30, function () use($currency) {
                return  Currency::where("currency_code_en",$currency)->first();
            });
            if($currencyDetails->currency_code_en!=$currency)
            {
                Cache::forget('currencyDetails');
                $currencyDetails = Cache::remember('currencyDetails', 60*60*24*30, function () use($currency) {
                    return  Currency::where("currency_code_en",$currency)->first();
                });
            }
            // echo $currencyDetails->currency_code_en;exit;
            if($price['total_price']['value'] != 0)
            {
                if(!empty($MarkUp))
                {
                    $markupValue = ($MarkUp->fee_value == 'fixed') ?  $MarkUp->fee_amount : ($price['total_price']['value']*($MarkUp->fee_amount/100)) ;

                    $price['total_price']['value'] =  sprintf("%.3f", ($MarkUp->fee_type == 'addition') ? ($price['total_price']['value'] + $markupValue) : ($price['total_price']['value'] - $markupValue));

                    if(!empty($currencyDetails))
                    {
                        $price['standed_price']['currency_code']  = $price['total_price']['currency_code'];
                        $price['standed_price']['value'] = $price['total_price']['value'];

                        $price['total_price']['currency_code'] = $currencyDetails->currency_code_en;
                        $price['total_price']['value'] = sprintf("%.3f",$price['total_price']['value']*$currencyDetails->conversion_rate);
                    }
                }
                else{
                    $price['standed_price']['currency_code'] = $price['total_price']['currency_code'];
                    $price['standed_price']['value'] = $price['total_price']['value'];

                    $price['total_price']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['total_price']['value'] = sprintf("%.3f",$price['total_price']['value']*$currencyDetails->conversion_rate);
                }
            }
            else
            {
                $price = array(
                    'total_price' => array('currency_code' => $currencyDetails->currency_code_en,'value' => 0),
                    'standed_price' => array('currency_code' => $price['total_price']['currency_code'],'value' => 0),
                );

            }


        }
        return $price;

    }
}

if (! function_exists('amountOnly')) {
    function amountOnly($amount, $decimal = '0')
    {
        $amount = empty($amount) ? "0" : $amount;
        $formatted = number_format($amount, $decimal, '.', ',');
        return $formatted;
    }
}

if (! function_exists('currencyList')) {
    function currencyList()
    {
        $currency = Cache::remember('currencyList', 60*60*24*30, function () {
            return  Currency::get();
        });

        return $currency;
    }
}

if (! function_exists('TicketStatus')) {
    function TicketStatus($code)
    {
       switch ($code) {
        case 'U':
            return 'Unticketed';
            break;
        case 'T':
            return 'Ticketed';
            break;
        case 'V':
            return 'Voided';
            break;
        case 'R':
            return 'Refunded';
            break;
        case 'X':
            return 'eXchanged';
            break;
        case 'Z':
            return 'Unknown/Archived/Carrier Modified';
            break;
        case 'N':
            return 'Unused';
            break;
        case 'S':
            return 'Used';
            break;

        default:
            return $code;
            break;
       }
    }
}

if (! function_exists('callApi')) {
    function callApi($url="",$method="get",$data=null)
    {
        $headers =[
            'Accept'        => '*/*',
            'Content-Type' => 'application/json',
            'Connection'=> 'Keep-Alive',"Accept-Encoding"=> "gzip, deflate, br",
        ];
        $response = Http::withHeaders([$headers])->withOptions(['verify' => false]);
        if($method=='get')
        {
            $response = $response->get($url);
        }
        elseif($method=='post'){
            $response = $response->post($url,$data);
        }
        return(($response));
    }
}
// if (! function_exists('sendNotification')) {
//     function sendNotificationFcm($notification_id, $title, $message, $id = 0, $type = "default", $sendMode = 'topic')
//     {

//         $accesstoken = env('FCM_KEY');

//         $url = "https://fcm.googleapis.com/fcm/send";

//         $notification = [
//             'title' => $title,
//             'body' => $message,
//             'type' => $type,
//             'id' => (string)$id,
//             'sound' => 'default',
//             'android_channel_id' => '1',
//         ];
//         $data = [
//             'title' => $title,
//             'body' => $message,
//             'type' => $type,
//             'id' => (string)$id,
//             'status' => 'done',
//             'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
//         ];


//         if ($sendMode == 'topic') {
//             $arrayToSend = [
//                 'to' => $notification_id,
//                 'data' => $data,
//                 'notification' => $notification,
//                 'priority' => 'high',
//                 'channel_id' => '1',
//             ];
//         }

//         if ($sendMode == 'device') {
//             $arrayToSend = [
//                 'registration_ids' => $notification_id,
//                 'data' => $data,
//                 'notification' => $notification,
//                 'priority' => 'high',
//                 'channel_id' => '1',
//             ];
//         }

//         // echo json_encode($arrayToSend);exit;

//         $ch = curl_init();

//         $headers = array();
//         $headers[] = 'Content-Type: application/json';
//         $headers[] = 'Authorization: key=' . $accesstoken;
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayToSend));
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//         $rest = curl_exec($ch);

//         // print_r($rest);exit;

//         if ($rest === false) {
//             // throw new Exception('Curl error: ' . curl_error($crl));
//             // print_r('Curl error: ' . curl_error($crl));
//             $result_noti = 0;
//         } else {
//             $result_noti = 1;
//         }

//         //curl_close($crl);
//         // print_r($result_noti);die;
//         return $result_noti;
//     }
// }

// if (! function_exists('sendNotification')) {
//     function sendNotification($token,$data)
//     {
//         $client = new Client();
//         $firebase = new FirebaseService();
//         $accessToken = $firebase->getAccessToken();
//         $message = [
//             'message' => [
//                 'token' => $token,
//                 'notification' => [
//                     'title' => 'test',
//                     'body' => 'body',
//                 ],
//                 'data' => ["key1"=> "value1",
//                 "key2"=> "value2"],
//             ],
//         ];

//         try {
//             $response = $client->post('https://fcm.googleapis.com/v1/projects/' . env('PROJECT_ID') . '/messages:send', [
//                 'headers' => [
//                     'Authorization' => 'Bearer ' . $accessToken,
//                     'Content-Type' => 'application/json',
//                 ],
//                 'json' => $message
//             ]);
//             $message = json_decode($response->getBody(), true);
//             $status = true;
//             return ['status' => $status, 'message' => $message];
//         } catch (RequestException $e) {
//             dd($e);
//             $message = json_decode($e->getResponse()->getBody()->getContents(), true);
//             $status = false;
//             return ['status' => $status, 'message' => $message];
//         }
//     }
// }

if (! function_exists('sendNotification')) {
    function sendNotification($topic,$title,$body,$sendMode = 'topic')
    {
       
        $client = new Client();
        $firebase = new FirebaseService();
        $accessToken = $firebase->getAccessToken();

        // Message structure for FCM
        if($sendMode = 'topic'){
            $message = [
                'message' => [
                    'topic' => $topic,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ];
        }
        

        try {

            $url = 'https://fcm.googleapis.com/v1/projects/' . env('PROJECT_ID') . '/messages:send';
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ],
                'json' => $message,
            ]);

            $message =  json_decode($response->getBody(), true);
            $status = true;
            
            return ['status' => $status, 'message' => $message];
        } catch (RequestException $e) {
            $message = json_decode($e->getResponse()->getBody()->getContents(), true);
            $status = false;
            return ['status' => $status, 'message' => $message];
        }
    }
}

/*Jazeera Function Start*/
if (! function_exists('getCurrencyConversionData')) {
    function getCurrencyConversionData($amount, $currencyCode)
        {
            if ($currencyCode !== 'KWD') {
                return convertAmount($amount, $currencyCode);
            }
            return $amount;
        }
}

if (! function_exists('convertAmount')) {
    function convertAmount($amount, $currencyCode)
    {
        $currencyConversionData = session('currencyConversionData');

         // Check if the currency conversion data is available in the cache
        if ($currencyConversionData) {
            // Check if the currency code matches the cached data
            if ($currencyConversionData['currencyCalculation']['toCurrencyCode'] === $currencyCode) {
                 $exchangeRate      = $currencyConversionData['currencyCalculation']['exchangeRate'];
                $convertedAmount    = $amount / $exchangeRate;
                return $convertedAmount;
            }
        }

        // If the currency conversion data is not available or does not match, retrieve it again
        $controller         = new SearchController();
        $data               = $controller->setConversionRateForJazeera($currencyCode);
        $exchangeRate       = $data['jazeeraResponse']['data']['currencyCalculation']['exchangeRate'];
        $convertedAmount    = $amount / $exchangeRate;
        return $convertedAmount;

    }

}

/*Jazeera Function END*/

 // Hotel mark up prices
if (!function_exists('hotelMarkUpPrice')) {
    function hotelMarkUpPrice($data)
    {
        // dd($data);
        if(isset($data))
        {

            // $price = array(
            //     'totalPrice' =>array(
            //         'currency_code' => $data['currencyCode'] ,
            //         'value' => sprintf("%.3f",$data['totalPrice']),
            //     ),
            //     'tax' =>array(
            //         'currency_code' => $data['currencyCode'] ,
            //         'value' => sprintf("%.3f",$data['totalTax']),

            //     ),
            //     'basefare' =>array(
            //         'currency_code' => $data['currencyCode'] ,
            //         'value' => sprintf("%.3f",$data['totalPrice'] - $data['totalTax']),

            //     )
            // );
            if(isset($data['currencyCode']) && $data['currencyCode'] == 'KWD'){
                $usdtokwd = 1;
            }else{
                $usdtokwd = Cache::remember('usdtokwd', 60*60*24*30, function () {
                    $conversion =  Currency::where("currency_code_en","USD")->first();
                    return  (1/$conversion->conversion_rate);
                });
            }
            

            //converting usd to kwd
            //$usdtokwd = (1/$hotelCurrencyDetailsUsdToKwd->conversion_rate);
            $price = array(
                'actualPrice' =>array(
                    'currency_code' => 'KWD' ,
                    'value' => sprintf("%.3f",$usdtokwd*$data['totalPrice']),
                ),
                'actualTotalAmount' =>array(
                    'currency_code' => 'KWD' ,
                    'value' => sprintf("%.3f",$usdtokwd*$data['totalPrice']),
                ),

                'totalPrice' =>array(
                    'currency_code' => 'KWD' ,
                    'value' => sprintf("%.3f",$usdtokwd*$data['totalPrice']),
                ),
                'tax' =>array(
                    'currency_code' => 'KWD' ,
                    'value' => sprintf("%.3f",$usdtokwd*$data['totalTax']),

                ),
                'basefare' =>array(
                    'currency_code' => 'KWD' ,
                    'value' => sprintf("%.3f",$usdtokwd*($data['totalPrice'] - $data['totalTax'])),

                )
            );


            // $MarkUp = Cache::remember('HotelMarkUpPrice', 60*60*24*30, function () {
            //     return  HotelMarkUp::where('status' , 'Active')->where('id' , 1)->first();
            // });

            $cacheName = 'HotelMarkUpPrice';
            $markUpId = 1;
            if(Auth::guard('web')->check() && auth()->user()->is_agent == 1)
            {
                $cacheName = "HotelMarkUpPrice".auth()->user()->id;
            }
            $MarkUp = Cache::remember($cacheName, 60 * 60 * 24 * 30, function () {
                if(Auth::guard('web')->check() && auth()->user()->is_agent == 1)
                {
                    return HotelMarkUp::where('status', 'Active')->where('user_id', auth()->user()->id)->first();
                }else{
                    return HotelMarkUp::where('status', 'Active')->where('id', 1)->first();
                }
            });




            if(!empty($MarkUp))
            {

                $markupValue = ($MarkUp->fee_value == 'fixed') ?  $MarkUp->fee_amount : ($price['totalPrice']['value']*($MarkUp->fee_amount/100)) ;

                $price['totalPrice']['value'] =  sprintf("%.3f", ($MarkUp->fee_type == 'addition') ? ($price['totalPrice']['value'] + $markupValue) : ($price['totalPrice']['value'] - $markupValue));

                $price['tax']['value'] = sprintf("%.3f", ($MarkUp->fee_type == 'addition') ? ($price['tax']['value'] + $markupValue) : ($price['tax']['value'] - $markupValue));

                $currency = config('app.currency');

                $currencyDetails = Cache::remember('currencyDetails', 60*60*24*30, function () use($currency) {
                    return  Currency::where("currency_code_en",$currency)->first();
                });
                if($currencyDetails->currency_code_en!=$currency)
                {
                    Cache::forget('currencyDetails');
                    $currencyDetails = Cache::remember('currencyDetails', 60*60*24*30, function () use($currency) {
                        return  Currency::where("currency_code_en",$currency)->first();
                    });
                }

                $hotelserviceFee = Cache::remember('hotelserviceFee', 60*60*24*30, function () use($currency) {
                    return  HotelAdditionalPrice::where('status','Active')->first();
                });
                //  dd($hotelserviceFee);


                if(!empty($currencyDetails))
                {

                    $price['standed_price']['currency_code'] = $price['FatoorahPaymentAmount']['currency_code'] = $price['totalPrice']['currency_code'];
                    $price['standed_price']['value'] = $price['FatoorahPaymentAmount']['value'] = $price['totalPrice']['value'];

                    $price['totalPrice']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['totalPrice']['value'] = sprintf("%.3f",$price['totalPrice']['value']*$currencyDetails->conversion_rate);

                    $price['tax']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['tax']['value'] = sprintf("%.3f",$price['tax']['value']*$currencyDetails->conversion_rate);

                    $price['basefare']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['basefare']['value'] = sprintf("%.3f",$price['basefare']['value']*$currencyDetails->conversion_rate);

                    $price['service_chargers']['currency_code'] = "KWD";
                    $price['service_chargers']['value']  = '0.000';

                    $price['previewDisplay']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['previewDisplay']['value'] = $price['totalPrice']['value'];

                    $price['coupon']['currency_code'] = $currencyDetails->currency_code_en;
                    $price['coupon']['value'] = '0.000';
                    $price['standed_coupon']['value'] = '0.000';

                    
                    $price['coupon']['id'] = null;
                    $CouponAmount = 0;

                    if(isset($data['couponCode']) && !empty($data['couponCode'])){

                        $couponCode = $data['couponCode'];

                        $currentDate = Carbon::now()->toDateString();

                        $couponDetails = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->where('coupon_code' , $couponCode)->whereIn('coupon_valid_on' ,[2,3])->first();
                        
                        //dd($couponDetails);
                        if(empty($couponDetails)){
                            //invalid Coupon
                        }else{

                            $userId = null;
                
                            if(isset($data['RequestIsFrom']) && $data['RequestIsFrom'] == 'api'){
                                if(Auth::guard('api')->check()){
                                    $userId = Auth::guard('api')->user()->id ;
                                }
                            }else{
                                if(Auth::check()){
                                    $userId = Auth::guard('web')->user()->id ;
                                }
                            }
                            if(!empty($userId)){
                                $pastAppliedCouponsList = AppliedCoupon::where('coupon_id',$couponDetails->id)->where('user_id',$userId)->get();
                                $numberOfTimesApplied = count($pastAppliedCouponsList);
                                

                                if(($couponDetails->coupon_valid_for == '0' ) || ( $couponDetails->coupon_valid_for >= $numberOfTimesApplied)){
                                    if($couponDetails->coupon_type == 'percentage'){
                                        $CouponAmount = sprintf("%.3f",$price['standed_price']['value']*(($couponDetails->coupon_amount)/100));
                                    }else{
                                        $CouponAmount =  sprintf("%.3f",$couponDetails->coupon_amount);
                                    }
                                    $price['coupon']['id'] = $couponDetails->id;
                                }else{
                                    //coupon Already used
                                }

                            }
                            
                        }

                    }


                    if(!empty($hotelserviceFee))
                    {
                        if((!isset($data['paymentType'])) || (isset($data['paymentType']) && $data['paymentType'] == 'k_net'))
                        {
                            $price['service_chargers']['currency_code'] = $currencyDetails->currency_code_en;
                            $price['service_chargers']['value'] = sprintf("%.3f",$hotelserviceFee->additional_price * $currencyDetails->conversion_rate) ;
                            $extrafee = $hotelserviceFee->additional_price;
                            $price['service_chargers']['type_of_payment'] = 'k_net';

                        }
                        elseif($data['paymentType'] == "credit_card")
                        {
                            //for credit card amount will be + 3.0%
                            $price['service_chargers']['currency_code'] = $currencyDetails->currency_code_en;
                            $creditCard = ($hotelserviceFee->credit_card_percentage / 100);
                            $price['service_chargers']['value'] = sprintf("%.3f",($price['standed_price']['value'] * $creditCard) * $currencyDetails->conversion_rate) ;
                            //echo $extrafee = $price['standed_price']['value'] * 0.03;
                            $extrafee =  $price['standed_price']['value'] * $creditCard;
                            $price['service_chargers']['type_of_payment'] = 'credit_card';
                        }else{
                            //wallet
                            $price['service_chargers']['currency_code'] = $currencyDetails->currency_code_en;
                            $price['service_chargers']['value'] = sprintf("%.3f",$hotelserviceFee->wallet_price * $currencyDetails->conversion_rate) ;
                            $extrafee = $hotelserviceFee->wallet_price;
                            $price['service_chargers']['type_of_payment'] = 'wallet';

                        }
                        $price['previewDisplay']['currency_code'] = $currencyDetails->currency_code_en;
                        $price['previewDisplay']['value'] = sprintf("%.3f",($price['standed_price']['value'] + $extrafee - $CouponAmount)*($currencyDetails->conversion_rate));

                        $price['FatoorahPaymentAmount']['currency_code'] = $price['standed_price']['currency_code'];
                        $price['FatoorahPaymentAmount']['value'] = $price['standed_price']['value'] + $extrafee - $CouponAmount;
                        $price['actualTotalAmount']['value'] = $price['standed_price']['value'] + $extrafee;


                        $price['kwd_totalPrice']['currency_code'] = 'KWD';
                        $price['kwd_totalPrice']['value'] = sprintf("%.3f",$price['totalPrice']['value'] / $currencyDetails->conversion_rate);

                        $price['kwd_basefare']['currency_code'] = 'KWD';
                        $price['kwd_basefare']['value'] = sprintf("%.3f",$price['basefare']['value'] / $currencyDetails->conversion_rate);

                        $price['kwd_service_chargers']['currency_code'] = 'KWD';
                        $price['kwd_service_chargers']['value'] = sprintf("%.3f",$price['service_chargers']['value'] / $currencyDetails->conversion_rate);

                        $price['kwd_tax']['currency_code'] = 'KWD';
                        $price['kwd_tax']['value'] = sprintf("%.3f",$price['tax']['value'] / $currencyDetails->conversion_rate);

                        if($CouponAmount != 0)
                        {
                            $price['standed_coupon']['value'] = sprintf("%.3f",$CouponAmount);
                            $price['coupon']['value'] = sprintf("%.3f",$CouponAmount * $currencyDetails->conversion_rate);
                        }
                    }

                }
            }

        }
        else{
            $price = array(
                'actualTotalAmount' => array('currency_code' => 'KWD','value' => 0),
                'actualPrice' => array('currency_code' => 'KWD','value' => 0),
                'totalPrice' => array('currency_code' => 'KWD','value' => 0),
                'tax'        => array('currency_code' => 'KWD','value' => 0),
                'basefare'   => array('currency_code' => 'KWD','value' => 0)
            );

        }

        return $price;

    }


}

if(!function_exists('ssremailformater')){
    function ssremailformater($email)
    {
        if(!empty($email))
        {
            $email = str_replace("@","//",$email);
            $email = str_replace("_","..",$email);
            $email = str_replace("-","./",$email);
            return $email;
        }
        return $email;
    }

}

//function for LayoverTime calculation

if (! function_exists('AirArabiaLayoverTime')) {
    function AirArabiaLayoverTime($departureAirport, $arrivalAirport, $departureTime, $arrivalTime)
    {
        // Convert departure and arrival times to Carbon objects
        $departureDateTime1 = Carbon::createFromFormat('Y-m-d\TH:i:s', $departureTime, getTimeZoneByAirportCode($departureAirport)); // Kuwait is UTC+3
        $arrivalDateTime1 = Carbon::createFromFormat('Y-m-d\TH:i:s', $arrivalTime, getTimeZoneByAirportCode($arrivalAirport)); // Kochi, India, is UTC+5:30
        // Convert departure and arrival times to UTC
        $departureDateTime1->setTimezone('UTC');
        $arrivalDateTime1->setTimezone('UTC');

        // Calculate the time difference between the arrival and departure times
        $totalTravelTime = $arrivalDateTime1->diff($departureDateTime1);

        // Display the total travel time
        if($totalTravelTime->format('%D') > 0)  {
            return $totalTravelTime->format('%D D %H H %I M');
        }
        else
        {
            return $totalTravelTime->format('%H H %I M');
        }
    }

}



if (! function_exists('getTimeZoneByAirportCode')) {
    function getTimeZoneByAirportCode($airportCode)
    {
        $AirportCode = Airport::where('airport_code', $airportCode)->first();
        if(empty($AirportCode))
        {
            return 'Asia/Kuwait';
        }
        $countryCode = $AirportCode->country_code??null; // Replace with the ISO 3166-1 alpha-2 code for the desired country
        // Get the time zone for the given country code
        $countryTimeZone = null;
        $timeZoneIdentifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode);
        if (!empty($timeZoneIdentifiers)) {
            $countryTimeZone = new \DateTimeZone($timeZoneIdentifiers[0]);
        }

        // Display the time zone if found
        if ($countryTimeZone !== null) {
            return $countryTimeZone->getName();
        } else {
            return 'Asia/Kuwait';
        }
    }

}

if (! function_exists('searchValueByKeys')) {
    function searchValueByKeys($array, $key_a, $key_b, $value_a, $value_b) {
        foreach ($array as $item) {
            if ($item[$key_a] == $value_a && $item[$key_b] == $value_b) {
                return $item;
            }
        }
        return null; // Value not found
    }
}

if(! function_exists('imagenameMaker')){
    function imagenameMaker($imageOriginalName , $extension = 'png'){
        if(!empty($imageOriginalName)){
            $imageName = Str::slug($imageOriginalName) . '_' . time() . '_' . uniqid() . '.' . $extension;
            return $imageName;
        }
        else{
            //empty
            return 'empty'. time() . '_' . uniqid() . '.png';
        }
       
    }
}

if(! function_exists('nodeConvertion')){
    function nodeConvertion($node){
        //converting single node to multiple node
        if(isset($node['@attributes']))
        {
            $temp = [] ;
            $temp = $node;
            $node = [];
            $node[0] = $temp;
            return $node;
        }else{
            return $node;
        }
       
    }
}

if(! function_exists('XmlToArray')){
    function XmlToArray($response){

        $xml = simplexml_load_string($response);
        $array = json_decode(json_encode($xml), true);
        return $array;
    }
}

if(! function_exists('webbedsSalutationsIds')){
    function webbedsSalutationsIds($salutation){

        // Mapping of salutation to [code, gender]
        $map = [
            'Child'          => ['code' => '14632', 'gender' => 'O'],
            'Dr'            => ['code' => '558',   'gender' => 'O'],
            'Madame'         => ['code' => '1671',  'gender' => 'F'],
            'Mademoiselle'   => ['code' => '74195', 'gender' => 'F'],
            'Messrs'        => ['code' => '9234',  'gender' => 'M'],
            'Miss'           => ['code' => '15134', 'gender' => 'F'],
            'Monsieur'       => ['code' => '74185', 'gender' => 'M'],
            'Mr'            => ['code' => '147',   'gender' => 'M'],
            'Mrs'           => ['code' => '149',   'gender' => 'F'],
            'Ms'            => ['code' => '148',   'gender' => 'F'],
            'Sir'            => ['code' => '1328',  'gender' => 'M'],
            'Sir/Madam'      => ['code' => '3801',  'gender' => 'O']
        ];

        return $map[$salutation] ?? ['code' => null, 'gender' => 'U'];

        
    }
}


if(! function_exists('XmlToArrayWithHTML')){
    function XmlToArrayWithHTML($response) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // suppress warnings
        $dom->loadXML($response);

        // Convert to array
        $simpleXml = simplexml_import_dom($dom);
        $result = json_decode(json_encode($simpleXml), true);

        // Manually extract raw HTML CDATA
        $confirmationTextNode = $dom->getElementsByTagName('confirmationText')->item(0);
        if ($confirmationTextNode) {
            $result['confirmationText_html'] = $confirmationTextNode->nodeValue;
        }

        // Extract <voucher> for each booking
        $voucherHTMLs = [];
        foreach ($dom->getElementsByTagName('voucher') as $voucherNode) {
            $voucherHTMLs[] = $voucherNode->nodeValue;
        }
        $result['voucher_htmls'] = $voucherHTMLs;

        return $result;
    }
}

if (!function_exists('clean_string')) {
    function clean_string($string, $keepSpaces = true) {
        $pattern = $keepSpaces ? '/[^A-Za-z0-9 ]/' : '/[^A-Za-z0-9]/';
        return preg_replace($pattern, '', trim($string));
    }
}




?>
