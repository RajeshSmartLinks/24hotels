<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Coupon;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\AppliedCoupon;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function validateCoupon(Request $request){
        $couponCode = $request->input('coupon');
        $totalAmount = $request->input('totalAmount');
        $standedamount = $request->input('standedamount');
        if(empty($couponCode)){
            //please enter the code
            return response()->json(['error' => 'Please enter the code' ,'AfterApplyingCouponTotalAmount' => $totalAmount , 'CouponAmount' => '0.000' ,'AfterApplyingCouponStandedAmount' => $standedamount, 'StandedCouponAmount' => '0.000'], 500);
        }else{
            $currentDate = Carbon::now()->toDateString();

            $type = $request->input('type');
            $couponValidOn = ($type == 'flight') ? [2,3] : [1,3];
            

            $couponDetails = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->where('coupon_code' , $couponCode)->whereIn('coupon_valid_on' ,$couponValidOn)->first();

            if(empty($couponDetails)){
                //invalid Coupon
                return response()->json(['error' => 'Invalid Coupon' ,'AfterApplyingCouponTotalAmount' => $totalAmount , 'CouponAmount' => '0.000' ,'AfterApplyingCouponStandedAmount' => $standedamount, 'StandedCouponAmount' => '0.000'], 500);
            }else{
                $userId = Auth::guard('web')->user()->id;
                $pastAppliedCouponsList = AppliedCoupon::where('coupon_id',$couponDetails->id)->where('user_id',$userId)->get();
                $numberOfTimesApplied = count($pastAppliedCouponsList);

                if(($couponDetails->coupon_valid_for == '0' ) || ( $couponDetails->coupon_valid_for >= $numberOfTimesApplied)){

                  
                    $CouponAmount = 0;
                    $StandedCouponAmount = 0;
                    
                    $AfterApplyingCouponTotalAmount = $totalAmount;
                    $AfterApplyingCouponStandedAmount =  $standedamount;

                    if($couponDetails->coupon_type == 'percentage'){
                        $CouponAmount = sprintf("%.3f",$totalAmount*(($couponDetails->coupon_amount)/100));
                        $StandedCouponAmount = sprintf("%.3f",$standedamount*(($couponDetails->coupon_amount)/100));
                        
                    }else{
                        $currency = config('app.currency');
                        $currencyDetails =Currency::where("currency_code_en",$currency)->first();
                        $CouponAmount =  sprintf("%.3f",$couponDetails->coupon_amount * $currencyDetails->conversion_rate);
                        $StandedCouponAmount =  sprintf("%.3f",$couponDetails->coupon_amount);
                    }
                    
                    $AfterApplyingCouponTotalAmount = sprintf("%.3f",$totalAmount - $CouponAmount);
                    $AfterApplyingCouponStandedAmount = sprintf("%.3f",$standedamount - $StandedCouponAmount);

                    return response()->json(['success' => 'Coupon Applied Successfully' ,'AfterApplyingCouponTotalAmount' => $AfterApplyingCouponTotalAmount , 'CouponAmount' => $CouponAmount ,'AfterApplyingCouponStandedAmount' => $AfterApplyingCouponStandedAmount, 'StandedCouponAmount' => $StandedCouponAmount], 200);

                }else{
                    //coupon Already used
                    return response()->json(['error' => 'Coupon Already Used' ,'AfterApplyingCouponTotalAmount' => $totalAmount , 'CouponAmount' => '0.000' ,'AfterApplyingCouponStandedAmount' => $standedamount, 'StandedCouponAmount' => '0.000'], 500);
                }
            }
        }
    }
}
