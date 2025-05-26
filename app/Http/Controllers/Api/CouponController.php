<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\AppliedCoupon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CouponController extends Controller
{
    public function validateCoupon(Request $request){
        if(!auth('api')->check()){
            //Unauthorized user
            // return response()->json(['error' => 'Unauthorized' ], 401);
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                "data" => []
            ], 401);
        }
        $couponCode = $request->input('coupon');
 
        if(empty($couponCode)){
            //please enter the code
            //return response()->json(['error' => 'Please enter the code' ], 500);
            return response()->json([
                'status' => false,
                'message' => Lang::get('please_enter_coupon_code'),
                "data" => []
            ], 200);
        }else{
            $currentDate = Carbon::now()->toDateString();
            $type = $request->has('type') ? $request->input('type') : 'flight';
            $couponValidOn = ($type == 'flight') ? [2,3] : [1,3];

            $couponDetails = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->where('coupon_code' , $couponCode)->whereIn('coupon_valid_on' ,$couponValidOn)->first();

            if(empty($couponDetails)){
                //invalid Coupon
                //return response()->json(['error' => 'Invalid Coupon' ], 500);
                return response()->json([
                    'status' => false,
                    'message' => Lang::get('invalid_coupon_code'),
                    "data" => []
                ], 200);
            }else{
                $userId = auth('api')->user()->id;
                $pastAppliedCouponsList = AppliedCoupon::where('coupon_id',$couponDetails->id)->where('user_id',$userId)->get();
                $numberOfTimesApplied = count($pastAppliedCouponsList);

                if(($couponDetails->coupon_valid_for == '0' ) || ( $couponDetails->coupon_valid_for >= $numberOfTimesApplied)){
                    $currency = config('app.currency');
                    $currencyDetails =Currency::where("currency_code_en",$currency)->first();
                    $couponDetails->conversion_rate = sprintf("%.3f",$currencyDetails->conversion_rate);
                    //return response()->json(['success' => 'Coupon Details' ,'data' => $couponDetails], 200);
                    return response()->json([
                        'status' => true,
                        'message' => Lang::get('success'),
                        "data" => $couponDetails
                    ], 200);
                }else{
                    //coupon Already used
                    //return response()->json(['error' => 'Coupon Already Used'], 500);
                    return response()->json([
                        'status' => false,
                        'message' => Lang::get('coupon_code_already_used'),
                        "data" => []
                    ], 200);
                }
            }
        }
    }
}
