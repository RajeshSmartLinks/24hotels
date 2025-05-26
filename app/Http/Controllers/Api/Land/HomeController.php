<?php

namespace App\Http\Controllers\Api\Land;

use App\Models\Coupon;
use App\Models\Country;
use App\Models\TboHotel;
use App\Models\GuestUser;
use App\Models\HotelSearch;
use App\Models\HotelBooking;
use Illuminate\Http\Request;
use App\Models\TboHotelsCity;
use Illuminate\Support\Carbon;
use App\Models\HotelReservation;
use App\Models\TboHotelsCountry;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\HotelBookingTravelsInfo;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Land\SearchController;
use App\Http\Controllers\Land\BookingController;

class HomeController extends BaseApiController
{
    public function HotelCityCodes(Request $request){
        $validator = Validator::make($request->all(), [
            'q' => ['required','min:3'],
        ]);
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
        $search = $request->input('q');

        $hotel = TboHotelsCity::
        select('code','name',DB::raw('CONCAT (name,IF(state_name is null , country_name ,CONCAT (" , ",state_name ))) as display_name ,country_name'));
        $hotel->having('display_name', 'LIKE', '%'.$search.'%');

        $hotel = $hotel->get()->toArray();
        
        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $hotel
        ], 200);

    }


    public function SearchHotels(Request $request){
        //request json sample
        // {"hotelsCityCode":"145710","hotelsCheckIn":"2023-07-20","hotelsCheckOut":"2023-08-24","noOfRooms":"2","room1":{"adult":"1","children":"1","childrenAge":["12"]},"room2":{"adult":"1","children":"0"},"nationality":"AR"}

        $validator = Validator::make($request->all(), [
            'hotelsCityCode' => ['required',
            'hotelsCheckIn' => ['required'],
            'hotelsCheckOut' => ['required'],
            'noOfRooms' => ['required'],
            'nationality' => ['required']
        ],
        ]);
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }

        $result = [
           'hotelList' => [] 
        ];

        // $result['countries'] = TboHotelsCountry::get();

        $SearchController = new SearchController();
        $searchResponse = $SearchController->Search($request);
        if($searchResponse['success'] == true && count($searchResponse['availableHotels']) > 0)
        {
           $availableHotelCodeList = array_column($searchResponse['availableHotels'] , 'HotelCode');
           $availableHotelDetailsList = DB::table('tbo_hotels')->select('hotel_code' , 'hotel_name' , 'hotel_rating' , 'address' , 'images' , 'check_in' , 'check_out')->whereIn('hotel_code' , $availableHotelCodeList)->get();
      
           foreach ($searchResponse['availableHotels'] as $key => $value) {
            $hotelDetails = $availableHotelDetailsList->firstWhere('hotel_code', $value['HotelCode']);
            if($hotelDetails){
                $markup = hotelMarkUpPrice(array('totalPrice' => isset($value['Rooms'][0]['RecommendedSellingRate']) ? $value['Rooms'][0]['RecommendedSellingRate']:$value['Rooms'][0]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' => $value['Rooms'][0]['TotalTax']));
                $img = [];
                if(!empty(json_decode($hotelDetails->images)))
                {
                    $imgesArray = json_decode($hotelDetails->images);
                    foreach($imgesArray as $k=>$images){
                        $img[] = $images;
                        if($k>3){
                            break;
                        }
                    }
                }
                
                $result['hotelList'][] = [
                    'hotelName' => $hotelDetails->hotel_name,
                    'hotelRating' => $hotelDetails->hotel_rating,
                    'address' => $hotelDetails->address,
                    'image' => $img,
                    'hotelCode' => $hotelDetails->hotel_code,
                    'checkIn' => $hotelDetails->check_in,
                    'checkOut' => $hotelDetails->check_out,
                    // 'bookingCode' => $value['Rooms'][0]['BookingCode'],
                    'rooms' => $value['Rooms'][0]['Name'],
                    //'totalFare' => sprintf("%.3f", $value['Rooms'][0]['TotalFare']),
                    // 'currenceCode' => $value['Currency'],
                    'isRefundable' => $value['Rooms'][0]['IsRefundable'],
                    'markups' => $markup,
                    'RoomPromotion' => isset($value['Rooms'][0]['RoomPromotion']) ? $value['Rooms'][0]['RoomPromotion'] :[]
                ];  
            }         
           }
           usort($result['hotelList'], function($a, $b) {
            return $a['markups']['totalPrice']['value'] <=> $b['markups']['totalPrice']['value'];
        });
        }
        else{
            //hotels not available
            $result['hotelList'] = [];
           
        }

        $cityDetails = DB::table('tbo_hotels_cities')->where('code',$request->input('hotelsCityCode'))->first();
        if(!empty($cityDetails))
        {
            $result['cityName'] = $cityDetails->name;
        }
        else{
            $result['cityName'] = '';
        }
        $result['searchId'] = $searchResponse['searchId']??'';
        $result['searchRequest'] = !empty($result['searchId']) ?  HotelSearch::find($searchResponse['searchId'])->toArray() : [];
        
        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $result
        ], 200);
    }

    public function HotelDetails(Request $request){
        // {"hotelCode" : "1569722" ,"searchId" : 219}

        
        $validator = Validator::make($request->all(), [
            'hotelCode' => ['required'],
            'searchId' => ['required']
        ]);
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
        // dd($hotelCode,$searchId);
        $hotelCode = $request->input('hotelCode');
        $searchId = $request->input('searchId');

        $TboRooms = new SearchController();
        $hotelDetailsAndRooms = $TboRooms->getTboRooms(['hotel_code' => $hotelCode ,'search_id' => $searchId]);

        $result = [];

        $result['hotelDetails'] = [] ;
        if(!empty($hotelDetailsAndRooms['hotelDetails'][0]))
        {
            $result['hotelDetails'] = $hotelDetailsAndRooms['hotelDetails'][0] ;
        }
        $result['availablerooms'] = [] ;
        if(!empty($hotelDetailsAndRooms['allRooms']))
        {
            if(!empty($hotelDetailsAndRooms['allRooms'][0]['Rooms']))
            {
                $result['availablerooms'] = $hotelDetailsAndRooms['allRooms'][0]['Rooms'] ;
    
                foreach($result['availablerooms'] as $r=>$room){
                    if(isset($room['Supplements']))
                    {
                        $supplments = $room['Supplements'];
                        unset($result['availablerooms'][$r]['Supplements']);
                        $supplmentAmout = 0.000;
                        $currency = '';
                        foreach ($supplments as $skey => $svalue) {
                            if($svalue[0]['Type'] == 'AtProperty' && ($svalue[0]['Description'] == 'mandatory_fee' || $svalue[0]['Description'] == 'mandatory_tax'))
                            {
                                $supplmentAmout+=$svalue[0]['Price'] ;
                                $currency = $svalue[0]['Currency'];
    
                            }
                         
                        }
                        $result['availablerooms'][$r]['supplment_charges'] = $currency.' '.$supplmentAmout;
                    }
                    else{
                        $result['availablerooms'][$r]['supplment_charges'] = null;
                    }
                    $result['availablerooms'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  isset($result['availablerooms'][$r]['RecommendedSellingRate']) ? $result['availablerooms'][$r]['RecommendedSellingRate'] : $result['availablerooms'][$r]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $result['availablerooms'][$r]['TotalTax']));
                    unset($result['availablerooms'][$r]['TotalFare']);
                    unset($result['availablerooms'][$r]['TotalTax']);
                    $poilcy = $room['CancelPolicies'];
                    unset($result['availablerooms'][$r]['CancelPolicies']);
                    $calcelationPolicys = [];
                    if(isset($poilcy)){
                        foreach ($poilcy as $key => $value) {
                            if($value['ChargeType'] == 'Percentage')
                            {
                                $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'].'%';
                            }else{
                                $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'];
                            }
                        }
                    }
                    $result['availablerooms'][$r]['CancelPolicies'] = $calcelationPolicys ;
                    $result['availablerooms'][$r]['RoomPromotion'] = isset($result['availablerooms'][$r]['RoomPromotion']) ? $result['availablerooms'][$r]['RoomPromotion'] :[];
                    if(isset($result['availablerooms'][$r]['DayRates']))
                    {
                        unset($result['availablerooms'][$r]['DayRates']);
                    }
                }
            }
        }

        //searchRequest 

        $result['searchRequest'] = HotelSearch::find($searchId);
        // unset($result['searchRequest']->rooms_request);
        $result['hotelCode'] = $hotelCode;

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $result
        ], 200);

    }

    public function PreBooking(Request $request){
        // {"hotelCode" : "1569722","searchId" : 219,"bookingCode" : "1569722!TB!3!TB!5ecb11d9-57d9-4496-aaac-33e5bf61258e"}

        //PreBooking
        $validator = Validator::make($request->all(), [
            'hotelCode' => ['required'],
            'searchId' => ['required'],
            'bookingCode' => ['required']
        ]);
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }

        $hotelCode = $request->input('hotelCode');
        $searchId = $request->input('searchId');
        $bookingCode = $request->input('bookingCode');
        
        $prebooking = new BookingController();
        $prebookingDeatails = $prebooking->TboPreBooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=>$bookingCode]);
        $result = [];

        //hotelDetails

        $hotelDetails = TboHotel::where('hotel_code' , $hotelCode)->first()->toArray();
        $result['hotelDetails'] = $hotelDetails;
        $result['hotelDetails']['images'] = json_decode($result['hotelDetails']['images'])??[];
        $result['hotelDetails']['attractions'] = json_decode($result['hotelDetails']['attractions'])??[];
        $result['hotelDetails']['hotel_facilities'] = json_decode($result['hotelDetails']['hotel_facilities'])??[];
        // $result['hotelDetails']['images'] = !empty(json_decode($hotelDetails['images'])) ? json_decode($hotelDetails['images']) : null;
        if(!isset($prebookingDeatails['preBooking'][0]['Rooms'][0]))
        {
            //error page
            //session expire
            return response()->json([
                'status' => false,
                "message" => 'Session Expired'
            ], 200);

        }
        
        if(app()->getLocale() == 'ar')
        {
            $name = 'IFNULL(name_ar,name) as name' ;
        }
        else{
            $name = 'name' ;
        }
        if($prebookingDeatails['preBooking'][0]['Rooms'][0]){
            if(isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']))
            {
                $supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
                unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']);
                $supplmentAmout = 0.000;
                $currency = '';
                foreach ($supplments as $skey => $svalue) {
                    if($svalue[0]['Type'] == 'AtProperty' && ($svalue[0]['Description'] == 'mandatory_fee' || $svalue[0]['Description'] == 'mandatory_tax'))
                    {
                        $supplmentAmout+=$svalue[0]['Price'] ;
                        $currency = $svalue[0]['Currency'];
                    }
                 
                }
                $prebookingDeatails['preBooking'][0]['Rooms'][0]['supplment_charges'] = $currency.' '.$supplmentAmout;
            }
            else{
                $prebookingDeatails['preBooking'][0]['Rooms'][0]['supplment_charges'] = null;
            }

            $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  
            isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate'] : $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax']));
            unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare']);
            unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax']);
            $poilcy = $prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies'];
            unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies']);
            $calcelationPolicys = [];
            if(isset($poilcy)){
                foreach ($poilcy as $key => $value) {
                    if($value['ChargeType'] == 'Percentage')
                    {
                        $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'].'%';
                    }else{
                        $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'];
                    }
                }
            }
            $prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies'] = $calcelationPolicys ;
            $prebookingDeatails['preBooking'][0]['Rooms'][0]['roomPromotion'] = isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion'] :[];
            unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['DayRates']);
        }
        // $result['countries'] = Country::select('id',DB::raw($name),'phone_code')->whereNotNull("phone_code")->get();
        $result['roomDetails'] = $prebookingDeatails['preBooking'][0]['Rooms'][0] ?? [];
        $result['RateConditions'] = $prebookingDeatails['preBooking'][0]['RateConditions'] ?? [];
        $result['searchRequest'] = HotelSearch::find($searchId);
        // $result['searchRequest']->rooms_request = json_decode($result['searchRequest']->rooms_request,true);
        $result['bookingCode'] = $bookingCode;
        $result['hotelCode'] = $hotelCode;
        $result['searchId'] = $searchId;
        
        $currentDate = Carbon::now()->toDateString();
        $couponCodes = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->whereIn('coupon_valid_on' ,[1,3])->get();
        $result['availableCouponCode'] = $couponCodes;
        

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $result
        ], 200);

    }

    public function SavePassanger(Request $request)
    {
        /*{
            "email" : "test@test.com","countryId" : 103,"mobile" : "8686868652","hotelCode" : "1569722","searchId" : 219,"bookingCode" : "1569722!TB!3!TB!5ecb11d9-57d9-4496-aaac-33e5bf61258e","type_of_payment" : "k_net","users":[{"title":"Mr","firstName":"ravi","lastName":"murthi", "room_no":"1","traveler_type":"ADT"},{"title":"Mr","firstName":"chiru","lastName":"mega", "room_no":"1","traveler_type":"CNN"},{"title":"Mr","firstName":"walid","lastName":"mega", "room_no":"1","traveler_type":"ADT"}],"couponCode": "HOTELYEAR" //optional
        }*/

        $input = $request->all();
        $rules = [];
       
        $rules['users'] = 'required';
        if($request->exists('users') )
        {
            foreach($input['users'] as $key => $val)
            {
                // $rules['users.'.$key.'.passengerType'] = 'required|min:3';
                
                // if($request->exists('users.'.$key.'.passengerType') )
                // {
                    $rules['users.'.$key.'.title'] = 'required';
                    $rules['users.'.$key.'.firstName'] = 'required';
                    $rules['users.'.$key.'.lastName'] = 'required|min:2';
                    $rules['users.'.$key.'.room_no'] = ['required'];
                    $rules['users.'.$key.'.traveler_type'] = ['required'];
                    
                // }

            }
           
        }
        $errorMessage = [
            'users.*.title.required' => 'Please select Title',
            'users.*.firstName.required' => 'Please enter first name',
            'users.*.lastName.required' => 'Please enter last name',
            'users.*.dob.room_no' => 'Please select Room number',
            'users.*.dob.traveler_type' => 'Please select Traveler Type',
        ];
        
       
        $rules['email'] = 'required';
        $rules['countryId'] = 'required';
        $rules['mobile'] = 'required';
        $rules['hotelCode'] = 'required';
        $rules['searchId'] = 'required';
        $rules['bookingCode'] = 'required';
        $rules['type_of_payment'] = 'required';

        

        $validator = Validator::make($input, $rules , $errorMessage);

        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }


        $hotelCode = $request->input('hotelCode');
        $searchId = $request->input('searchId');
        $bookingCode = $request->input('bookingCode');
        
        $prebooking = new BookingController();
        $prebookingDeatails = $prebooking->TboPreBooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=> $bookingCode]);
        if(!isset($prebookingDeatails['preBooking'][0]['Rooms'][0]))
        {
            //error page
            //session expire
            return response()->json([
                'status' => false,
                "message" => 'Session Expired'
            ], 200);

        }
        $searchDetails = HotelSearch::find($searchId);

        $hotelDetails = TboHotel::where('hotel_code' , $hotelCode)->first()->toArray();

        //hotelBookingDeatils
        $hotelRoomBooking = new HotelBooking();
        $hotelRoomBooking->search_id = $searchId;
        $hotelRoomBooking->hotel_code = $hotelCode;
        $hotelRoomBooking->hotel_name = $hotelDetails['hotel_name'] ?? '';
        // $hotelRoomBooking->check_in = $searchDetails->check_in;
        // $hotelRoomBooking->check_out = $searchDetails->check_out;
        $hotelRoomBooking->booking_code =$bookingCode;

        if(auth('api')->user())
        {
            $hotelRoomBooking->user_id = auth('api')->user()->id;
            $hotelRoomBooking->user_type = 'app';
        }
        else
        {
            $hotelRoomBooking->user_type = 'app_guest';
            $GuestUser = new GuestUser();
            $GuestUser->mobile = $request->input('mobile');
            $GuestUser->country_id = $request->input('countryId');
            $GuestUser->email = $request->input('email');
            $GuestUser->user_type = 'app';
            $GuestUser->type = 'hotel';
            $GuestUser->save();
        }
        $hotelRoomBooking->mobile = $request->input('mobile');
        $hotelRoomBooking->country_id = $request->input('countryId');
        $hotelRoomBooking->email = $request->input('email');

        $couponCode = null ;
        if($request->has('couponCode') && !empty($request->input('couponCode'))){
            $couponCode = $request->input('couponCode') ;   
        }

        $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups'] = hotelMarkUpPrice(array('totalPrice' => isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate'] : $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax'] ,'paymentType' => $request->input('type_of_payment') ?? 'k_net' ,'couponCode' => $couponCode ,'RequestIsFrom' => 'api'));


        
        
        $hotelRoomBooking->currency_code = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['FatoorahPaymentAmount']['currency_code'];
        $hotelRoomBooking->total_amount = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['FatoorahPaymentAmount']['value'];

        $hotelRoomBooking->actual_price = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['actualPrice']['value'];
        $hotelRoomBooking->actual_currency_code = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['actualPrice']['currency_code'];

        $hotelRoomBooking->price_from_supplier =  $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare'];
        $hotelRoomBooking->currency_code_from_supplier = 'USD';

        if(isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate'])){
            $hotelRoomBooking->is_rsp_price = 1;
        }

        
        $hotelRoomBooking->basefare = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['kwd_basefare']['value'];
        $hotelRoomBooking->service_charges =  $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['kwd_service_chargers']['value'] ;
        $hotelRoomBooking->tax = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['kwd_tax']['value'];
        $hotelRoomBooking->sub_total = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['FatoorahPaymentAmount']['value'];
        
        if(!empty($prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['coupon']['value']) && $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['coupon']['value']!= '0.000'){
            $hotelRoomBooking->coupon_id = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['coupon']['id'];
            $hotelRoomBooking->coupon_amount = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['standed_coupon']['value'];
        }

        $hotelRoomBooking->actual_amount = $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups']['actualTotalAmount']['value'];


        $hotelRoomBooking->type_of_payment = $request->input('type_of_payment');
        $hotelRoomBooking->supplier = 'tbo';
        $hotelRoomBooking->booking_status = 'booking_initiated';
        $hotelRoomBooking->no_of_rooms = $searchDetails->no_of_rooms;
        $hotelRoomBooking->no_of_guests = $searchDetails->no_of_guests;
        $hotelRoomBooking->no_of_nights = $searchDetails->no_of_nights;
        
        if($prebookingDeatails['preBooking'][0]['Rooms'][0]){
            //$supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
            if(isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']))
            {
                $supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
                unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']);
                $supplmentAmout = 0.000;
                $currency = '';
                foreach ($supplments as $skey => $svalue) {
                    if($svalue[0]['Type'] == 'AtProperty' &&  ($svalue[0]['Description'] == 'mandatory_fee' || $svalue[0]['Description'] == 'mandatory_tax'))
                    {
                        $supplmentAmout+=$svalue[0]['Price'] ;
                        $currency = $svalue[0]['Currency'];

                    }
                 
                }
                $supplment_charges = $currency.' '.$supplmentAmout;
            }
            else{
                $supplment_charges = null;
            }
            

        }
        if(!empty($supplment_charges))
        {
            $hotelRoomBooking->supplement_charges = $supplment_charges;
        }

        $hotelRoomBooking->save();

        $APP_ENV = env('APP_ENV');
        if($APP_ENV == 'local')
        {
            $hotelRoomBooking->booking_ref_id = 'MTHL'.str_pad($hotelRoomBooking->id, 7, '0', STR_PAD_LEFT);
        }
        elseif($APP_ENV == 'dev'){
            $hotelRoomBooking->booking_ref_id = 'MTHD'.str_pad($hotelRoomBooking->id, 7, '0', STR_PAD_LEFT);
        }
        elseif($APP_ENV == 'prod'){
            $hotelRoomBooking->booking_ref_id = 'MTHP'.str_pad($hotelRoomBooking->id, 7, '0', STR_PAD_LEFT);
        }
     
        $hotelRoomBooking->save();

        //rooms loop
        // foreach($request->input('room') as $r=>$room){
        //     if(isset($room['adult']))
        //     {
        //         foreach ($room['adult'] as $key => $value) {
        //             if($value['title'] == "Mr")
        //             {
        //                 $gender = 'M';
        //             }elseif($value['title'] == "Ms")
        //             {
        //                 $gender = 'F';
        //             }elseif($value['title'] == "Mrs")
        //             {
        //                 $gender = 'F';
        //             }
        //             else{
        //                 $gender = 'F';
        //             }
        //             $HotelBookingTravelers = new HotelBookingTravelsInfo();
        //             $HotelBookingTravelers->title = $value['title'];
        //             $HotelBookingTravelers->first_name = $value['firstName'];
        //             $HotelBookingTravelers->last_name = $value['lastName'];
        //             $HotelBookingTravelers->room_no = $value['room_no'];
        //             $HotelBookingTravelers->gender = $gender;
        //             $HotelBookingTravelers->traveler_type = 'ADT';
        //             $HotelBookingTravelers->hotel_booking_id = $hotelRoomBooking->id;
        //             $HotelBookingTravelers->save();
        //         }
        //     }

        //     if(isset($room['child']))
        //     {
        //         foreach ($room['child'] as $key => $value) {
        //             if($value['title'] == "Mr")
        //             {
        //                 $gender = 'M';
        //             }elseif($value['title'] == "Ms")
        //             {
        //                 $gender = 'F';
        //             }elseif($value['title'] == "Mrs")
        //             {
        //                 $gender = 'F';
        //             }
        //             else{
        //                 $gender = 'F';
        //             }
        //             $HotelBookingTravelers = new HotelBookingTravelsInfo();
        //             $HotelBookingTravelers->title = $value['title'];
        //             $HotelBookingTravelers->first_name = $value['firstName'];
        //             $HotelBookingTravelers->last_name = $value['lastName'];
        //             $HotelBookingTravelers->room_no = $value['room_no'];
        //             $HotelBookingTravelers->gender = $gender;
        //             $HotelBookingTravelers->traveler_type = 'CNN';
        //             $HotelBookingTravelers->hotel_booking_id = $hotelRoomBooking->id;
        //             $HotelBookingTravelers->save();
        //         }
        //     }
        // }

        //users loop

        foreach($request->input('users') as $User)
        {
            if($User['title'] == "Mr")
            {
                $gender = 'M';
            }elseif($User['title'] == "Ms")
            {
                $gender = 'F';
            }elseif($User['title'] == "Mrs")
            {
                $gender = 'F';
            }
            else{
                $gender = 'F';
            }
            $HotelBookingTravelers = new HotelBookingTravelsInfo();
            $HotelBookingTravelers->title = $User['title'];
            $HotelBookingTravelers->first_name = $User['firstName'];
            $HotelBookingTravelers->last_name = $User['lastName'];
            $HotelBookingTravelers->room_no = $User['room_no'];
            $HotelBookingTravelers->gender = $gender;
            $HotelBookingTravelers->traveler_type = $User['traveler_type'];
            $HotelBookingTravelers->hotel_booking_id = $hotelRoomBooking->id;
            $HotelBookingTravelers->save();
        }

        $hotelbookingId = encrypt($hotelRoomBooking->id);

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $hotelRoomBooking->id
        ], 200);

    } 

    public function HotelBookingPreview(Request $request){
        /* {"bookingId" : 71} */
        $validator = Validator::make($request->all(), [
            'bookingId' => ['required']
        ]);
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }

        $result =[];

        $hotelbookingId = $request->input('bookingId');

        $result['bookingDetails'] = $bookingDetails = HotelBooking::with('Customercountry','CouponDetails')->find($hotelbookingId);
        $result['passengersInfo'] = $passengersInfo = HotelBookingTravelsInfo::whereHotelBookingId($hotelbookingId)->get();

        $prebooking = new BookingController();
        $prebookingDeatails = $prebooking->TboPreBooking(['hotel_code' => $bookingDetails->hotel_code ,'search_id' => $bookingDetails->search_id , 'booking_code'=> $bookingDetails->booking_code]);

        $hotelDetails = TboHotel::where('hotel_code' , $bookingDetails->hotel_code)->first()->toArray();
        $result['hotelDetails'] = $hotelDetails;
        $result['hotelDetails']['images'] = json_decode($result['hotelDetails']['images'])??[];
        $result['hotelDetails']['attractions'] = json_decode($result['hotelDetails']['attractions'])??[];
        $result['hotelDetails']['hotel_facilities'] = json_decode($result['hotelDetails']['hotel_facilities'])??[];
        if(!isset($prebookingDeatails['preBooking'][0]['Rooms'][0]))
        {
            //error page
            //session expire
            return response()->json([
                'status' => false,
                "message" => 'Session Expired'
            ], 200);

        }
        if($prebookingDeatails['preBooking'][0]['Rooms'][0]){
            $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']:$prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax'] ,'paymentType' => $bookingDetails->type_of_payment ?? 'k_net' , 'couponCode' =>  $bookingDetails->CouponDetails->coupon_code ?? null ,'RequestIsFrom' => 'api'));

            //$supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
            if(isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']))
            {
                $supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
                unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']);
                $supplmentAmout = 0.000;
                $currency = '';
                foreach ($supplments as $skey => $svalue) {
                    if($svalue[0]['Type'] == 'AtProperty' &&  ($svalue[0]['Description'] == 'mandatory_fee' || $svalue[0]['Description'] == 'mandatory_tax'))
                    {
                        $supplmentAmout+=$svalue[0]['Price'] ;
                        $currency = $svalue[0]['Currency'];

                    }
                }
                $prebookingDeatails['preBooking'][0]['Rooms'][0]['supplment_charges'] = $currency.' '.$supplmentAmout;
            }
            else{
                $prebookingDeatails['preBooking'][0]['Rooms'][0]['supplment_charges'] = null;
            }
            $prebookingDeatails['preBooking'][0]['Rooms'][0]['roomPromotion'] = isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion'] :[];
            $poilcy = $prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies'];
            unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies']);
            $calcelationPolicys = [];
            if(isset($poilcy)){
                foreach ($poilcy as $key => $value) {
                    if($value['ChargeType'] == 'Percentage')
                    {
                        $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'].'%';
                    }else{
                        $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'];
                    }
                }
            }
            $prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies'] = $calcelationPolicys ;
            $prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion'] = isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion'] : [] ;
            unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['DayRates']);
        }

        $result['roomDetails'] = $prebookingDeatails['preBooking'][0]['Rooms'][0] ?? [];
        $result['RateConditions'] = $prebookingDeatails['preBooking'][0]['RateConditions'] ?? [];
        $result['searchRequest'] = HotelSearch::find($bookingDetails->search_id);


        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $result
        ], 200);

    }

    public function paymentGateWay(Request $request)
    {
        /* {"bookingId" : 72} */
        //myfathoora
        //payment gate way invoice generation
        
        $validator = Validator::make($request->all(), [
            'bookingId' => ['required']
        ]);
    

        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
        $bookingId = ($request->input('bookingId'));
        
        $BookingDetails = HotelBooking::with('Customercountry')->find($bookingId);
        if(empty($BookingDetails))
        {
            return response()->json([
                'status' => false,
                "message" => "InValid Booking Id"
            ], 200);
        }
        
        //$userName = Auth::guard('web')->check() ? Auth::guard('web')->user()->name : 'guest' ;
        $passengersInfo = HotelBookingTravelsInfo::whereHotelBookingId($BookingDetails->id)->first();
        
        $userName = (!empty($passengersInfo)) ? $passengersInfo->first_name . " ".$passengersInfo->last_name : 'guest';
        
        
        $url = route('app.hotelRoombooking',['hotelbookingId' => ($BookingDetails->id)]) ;
        $callbackURL = route('redirect',['url'=>$url]);
        $getPayLoadData =  [
            'CustomerName'       => $userName,
            'InvoiceValue'       => $BookingDetails->total_amount,
            'DisplayCurrencyIso' => $BookingDetails->currency_code,
            'CustomerEmail'      => $BookingDetails->email,
            'CallBackUrl'        => $callbackURL,
            'ErrorUrl'           => $callbackURL,
            'MobileCountryCode'  => $BookingDetails->Customercountry->phone_code,
            'CustomerMobile'     => $BookingDetails->mobile,
            'Language'           => 'en',
            'CustomerReference'  => $BookingDetails->booking_ref_id,
            // 'ExpiryDate'         => Carbon::now()->add(20,'minute')->format('Y-m-d\TH:i:s'),
            'SourceInfo'         => '24Flights ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION,
            'payment_type'       => $BookingDetails->type_of_payment
        ];
        // dd($getPayLoadData);
        $myfatoorah = new MyFatoorahController();
        $invoicedata = $myfatoorah->index($getPayLoadData);
        if($invoicedata['IsSuccess'] == "true")
        {
            $BookingDetails->invoice_id = $invoicedata['Data']['invoiceId'];
            $BookingDetails->myfatoorah_url = $invoicedata['Data']['invoiceURL'];
            $BookingDetails->booking_status = 'payment_initiated';
            $BookingDetails->save();
            $url = $invoicedata['Data']['invoiceURL'];
            return response()->json([
                'status' => true,
                'message' => self::SUCCESS_MSG,
                "data" => ['url'=>$url,'invoice_id' =>$invoicedata['Data']['invoiceId'],'amount' =>$BookingDetails->total_amount,'curreny_code'=>$BookingDetails->currency_code],
            ], 200);
            // return redirect()->away($url);
        }
        else{
            return response()->json([
                'status' => false,
                "message" => "Some thing went wrong"
            ], 200);
     
        }
    }

    public function app_web_error($arrayData)
    {
        $Hotelbookingdetails = HotelBooking::find($arrayData['booking_id']);
        header("Cache-Control: no-cache");
        $data = [
            "reference_no" => $Hotelbookingdetails->booking_ref_id,
            "payment_id" => $Hotelbookingdetails->payment_id,
            "paid_amount" => $Hotelbookingdetails->total_amount,
            "currency_code" => $Hotelbookingdetails->currency_code,
            "status" => str_replace("_"," ",$Hotelbookingdetails->booking_status),
            "error" =>$arrayData['error'],
            "from" => "hotel"
        ];
        return view('flutter_app.failure', compact('data'))->render();

    }

    public function bookHotelRooms($hotelBookingId){
        $hotelBookingId = ($hotelBookingId);
        $paymentId = request('paymentId');
        $hotelbookingdetails  = HotelBooking::find($hotelBookingId);
        if($hotelbookingdetails->booking_status == 'payment_initiated')
        {
            $myfatoorah = new MyFatoorahController();
            $invoicedata = $myfatoorah->callback($paymentId);
            if($invoicedata['IsSuccess'])
            {   
                $hotelbookingdetails->invoice_status = $invoicedata['Data']->InvoiceStatus;
                $hotelbookingdetails->invoice_response = json_encode($invoicedata['Data']);
                $hotelbookingdetails->payment_id = $paymentId;
                if($invoicedata['Data']->InvoiceStatus == 'Paid')
                {
                    $hotelbookingdetails->booking_status = 'payment_successful';
                    $hotelbookingdetails->payment_gateway = $invoicedata['Data']->focusTransaction->PaymentGateway;
                }
                elseif($invoicedata['Data']->InvoiceStatus == 'Expired'){
                    $hotelbookingdetails->booking_status = 'payment_exipre';
                }
                elseif($invoicedata['Data']->InvoiceStatus == 'Failed')
                {
                    $hotelbookingdetails->booking_status = 'payment_failure';
                }
                $hotelbookingdetails->save();
    
                if($invoicedata['Data']->InvoiceStatus == 'Paid')
                {
                    $tboBooking = new BookingController();
                    $tboBookingDetails = $tboBooking->Booking(['booking_id' => $hotelBookingId]);
                    if($tboBookingDetails['success'])
                    {
                        // $result = [];
                        // $result['booking_detail'] =$tboBookingDetails['confirmation_number'];
                        // $result['hotel_details'] = TboHotel::where('hotel_code' , $hotelbookingdetails->hotel_code)->first();
                        // $result['hotel_booking_detail'] = $hotelbookingdetails;

                        //booking successfull
                        $hotelbookingdetails->booking_status = 'booking_pending';
                        $hotelbookingdetails->confirmation_number = $tboBookingDetails['confirmation_number'];
                       
                        
                        $hotelbookingdetails->save();
                     

                        $result = [];
                        $result['hotelbookingdetails'] = $hotelbookingdetails;
                 

                        $HotelReservation = new HotelReservation();
                        $HotelReservation->booking_id = $hotelBookingId;
                        $HotelReservation->confirmation_number = $tboBookingDetails['confirmation_number'];
                        $HotelReservation->reservation_status = 'Pending';
                        $HotelReservation->cron_status = 0;
                        $HotelReservation->status = 1;
                        $HotelReservation->enable_request_on = date('Y-m-d H:i:s', strtotime('+120 seconds'));
                        $HotelReservation->save();

                        header("Cache-Control: no-cache");
                        $data = [
                            "reference_no" => $hotelbookingdetails->booking_ref_id,
                            "payment_id" => $paymentId,
                            "paid_amount" => $hotelbookingdetails->total_amount,
                            "currency_code" => $hotelbookingdetails->currency_code,
                            "status" => str_replace("_"," ",$hotelbookingdetails->booking_status),
                            "from" => "hotel"
                        ];
                        return view('flutter_app.success', compact('data'));

                        // return view('front_end.hotel.pending_reservation',compact('titles','result'));
                        
                    }
                    else{
                        //booking failed
                        $hotelbookingdetails->booking_status = 'booking_failure';
                        $hotelbookingdetails->booking_json_request_id = $tboBookingDetails['json_request_id'];
                        $hotelbookingdetails->save();
                        $data['errorresponse'] = 'booking failure amount will be refunded back';
                        //travelport request error response
                        //refund should initate
                        //redirect to error page
    
           
                        return $this->app_web_error(['error' =>'booking failure amount will be refunded back','booking_id'=>$hotelBookingId]);
                        
                    }
                  

                }
                else{
                    //if not paid or expired

      
                    //travelport request error response
                    //refund should initate
                    //redirect to error page

                    return $this->app_web_error(['error' =>$invoicedata['Data']->InvoiceStatus,'booking_id'=>$hotelBookingId]);
                }
            }
            else{
                return $this->app_web_error(['error' =>'some thing went wrong','booking_id'=>$hotelBookingId]);
            }
        }
        else{
            return $this->app_web_error(['error' =>'some thing went wrong','booking_id'=>$hotelBookingId]);
        }

    }
}
