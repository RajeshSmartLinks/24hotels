<?php

namespace App\Http\Controllers\FrontEnd\Hotel;

use PDF;
use stdClass;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\TboHotel;
use App\Models\GuestUser;
use App\Models\HotelSearch;
use App\Models\SeoSettings;
use App\Models\HotelBooking;
use App\Models\WalletLogger;
use Illuminate\Http\Request;
use App\Models\TboHotelsCity;
use Illuminate\Support\Carbon;
use App\Models\HotelReservation;
use App\Models\TboHotelsCountry;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\HotelBookingTravelsInfo;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Land\SearchController;
use App\Http\Controllers\Land\BookingController;

class HomeController extends Controller
{
    public function AjaxHotelCityList(Request $request){
        $search = $request->input('q');
        

        // if(app()->getLocale() == 'ar')
        // {
        //     // $selectquery = 'airports.airport_code',DB::raw('CONCAT(cities.name," (",airports.airport_code,")") as display_name'),'airports.name','countries.name as country_name','cities.name as city_name';
        //     $displayName = 'CONCAT(IFNULL(cities.name_ar,cities.name)," (",airports.airport_code,")") as display_name';
        //     $airportName = 'IFNULL(airports.name_ar,airports.name) as name';
        //     $countryName = 'IFNULL(countries.name_ar,countries.name) as country_name';
        //     $cityName = 'IFNULL(cities.name_ar,cities.name) as city_name';
        //     $lang = "ar";
        // }
        // else{
        //     $selectquery = `'airports.airport_code',DB::raw('CONCAT(cities.name," (",airports.airport_code,")") as display_name'),'airports.name','countries.name as country_name','cities.name as city_name'`;
        //     $displayName = 'CONCAT(cities.name," (",airports.airport_code,")") as display_name';
        //     $airportName = 'airports.name';
        //     $countryName = 'countries.name as country_name';
        //     $cityName = 'cities.name as city_name';
        //     $lang = "en";
        // }
        
       
        // DB::enableQueryLog();
        $hotel = TboHotelsCity::
        select('code','name',DB::raw('CONCAT (name,IF(state_name is null , country_name ,CONCAT (" , ",state_name ))) as display_name ,country_name'));
        // ->having(function($query) use($search )
        // {
            $hotel->having('display_name', 'LIKE', '%'.$search.'%');
        // });

       
        $hotel = $hotel->get()->toArray();
        // dd($hotel);
        
        return $hotel;
    }

    public function SearchHotels(Request $request){
       // dd($request->input());
        //dd(hotelMarkUpPrice(array('totalPrice' => 1.123 , 'currencyCode' => 'USD' , 'totalTax' => 0.000)));
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'hostelListing','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        

        $result = [
           'hotelList' => [] ,
           'filter' => []
        ];
        
        $minPrice = 0;
        $maxPrice = 0;
        $refundableCount = 0;
        $nonrefundableCount = 0;

        $rating1 = 0;
        $rating2 = 0;
        $rating3 = 0;
        $rating4 = 0;
        $rating5 = 0;

        $result['countries'] = TboHotelsCountry::get();
        // return view('front_end.hotel.search',compact('titles','result'));

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
                
                $result['hotelList'][] = [
                    'hotelName' => $hotelDetails->hotel_name,
                    'hotelRating' => $hotelDetails->hotel_rating,
                    'address' => $hotelDetails->address,
                    'image' => !empty(json_decode($hotelDetails->images)) ? json_decode($hotelDetails->images)[0] : null,
                    'hotelCode' => $hotelDetails->hotel_code,
                    'checkIn' => $hotelDetails->check_in,
                    'checkOut' => $hotelDetails->check_out,
                    'bookingCode' => $value['Rooms'][0]['BookingCode'],
                    'rooms' => $value['Rooms'][0]['Name'],
                    //'totalFare' => sprintf("%.3f", $value['Rooms'][0]['TotalFare']),
                    'currenceCode' => $value['Currency'],
                    'isRefundable' => $value['Rooms'][0]['IsRefundable'],
                    'markups' => $markup,
                    'roomPromotion' => isset($value['Rooms'][0]['RoomPromotion']) ? $value['Rooms'][0]['RoomPromotion'] :[]
                ];

                switch ($hotelDetails->hotel_rating) {
                    case '1':
                        $rating1++;
                        break;
                    case '2':
                        $rating2++;
                        break;
                    case '3':
                        $rating3++;
                        break;
                    case '4':
                        $rating4++;
                        break;
                    case '5':
                        $rating5++;
                        break; 
                }

                $value['Rooms'][0]['IsRefundable'] == 1 ? $refundableCount++ : $nonrefundableCount++;

                if($markup)
                {
                    $price = $markup['totalPrice']['value'];
                    //minprice
                    if($minPrice == 0)
                    {
                        $minPrice = $price;
                    }
                    elseif($price < $minPrice)
                    {
                        $minPrice = $price;
                    }
                    //maxprice
                    if($maxPrice == 0)
                    {
                        $maxPrice = $price;
                    }
                    elseif($price > $maxPrice)
                    {
                        $maxPrice = $price;
                    }
                }
            }

            
           
           }
           usort($result['hotelList'], function($a, $b) {
            return $a['markups']['totalPrice']['value'] <=> $b['markups']['totalPrice']['value'];
        });
        }
        else{
            //hotels not available
           
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

        // $result['minPrice'] = $minPrice;
        // $result['maxPrice'] = $maxPrice;

        $result['filter']['minPrice'] = $minPrice;
        $result['filter']['maxPrice'] = $maxPrice;
        $result['filter']['refundableCount'] = $refundableCount;
        $result['filter']['nonrefundableCount'] = $nonrefundableCount;
        $result['filter']['rating']['one_star'] = $rating1;
        $result['filter']['rating']['two_star'] = $rating2;
        $result['filter']['rating']['three_star'] = $rating3;
        $result['filter']['rating']['four_star'] = $rating4;
        $result['filter']['rating']['five_star'] = $rating5;
        
        //dd($result);
        return view('front_end.hotel.search',compact('titles','result'));
    }

    public function HotelDetails($hotelCode,$searchId){

        $hotelCode = decrypt($hotelCode);
        $searchId = decrypt($searchId);
        // dd($hotelCode,$searchId);
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'hotelDetails','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];

        $TboRooms = new SearchController();
        $hotelDetailsAndRooms = $TboRooms->getTboRooms(['hotel_code' => $hotelCode ,'search_id' => $searchId]);

        $result = [];

        $result['hotelDeatils'] = [] ;
        if(!empty($hotelDetailsAndRooms['hotelDetails'][0]))
        {
            $result['hotelDeatils'] = $hotelDetailsAndRooms['hotelDetails'][0] ;
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
                    $result['availablerooms'][$r]['roomPromotion'] = isset($result['availablerooms'][$r]['RoomPromotion']) ? $result['availablerooms'][$r]['RoomPromotion'] :[];
                }
            }
        }

        //searchRequest 

        $result['searchRequest'] = HotelSearch::find($searchId);
        $result['hotelCode'] = $hotelCode;
        // dd($result);

        return view('front_end.hotel.details',compact('titles','result'));
        
    }

    public function updatedHotelsearch(Request $request){

        //getting updated hotel details with room data
        // dd($request->input());
        $cityCode = $request->input('hotelsCityCode');
        $checkIn = $request->input('hotelsCheckIn');
        $checkOut = $request->input('hotelsCheckOut');
        $noOfRooms = $request->input('noOfRooms');
        $CIn = Carbon::parse($checkIn);
        $COut =Carbon::parse($checkOut);
        $cityDetails = DB::table('tbo_hotels_cities')->where('code',$cityCode)->first();
        $noOfGuests = 0;

        for ($i=1; $i <= $noOfRooms; $i++) { 
            $roomDetails = $request->input('room'.$i);
            $childrenAge = [];
            if(isset($roomDetails['childrenAge']) && count($roomDetails['childrenAge']) > 0)
            {
                $childrenAge = $roomDetails['childrenAge'];
            }
            $noOfGuests += $roomDetails['adult']; 
            $noOfGuests += $roomDetails['children'] ?? 0; 
            $hotelRequestArray['PaxRooms'][] = array( 
                "Adults" => $roomDetails['adult'],
                "Children" => $roomDetails['children'],
                "ChildrenAges"=> $childrenAge
            );
        }

        $hotelSearch = new HotelSearch();
        $hotelSearch->no_of_rooms = $request->input('noOfRooms');
        $hotelSearch->no_of_nights    = $CIn->diffInDays($COut);
        $hotelSearch->nationality    = $request->input('nationality');
        $hotelSearch->city_code    = $cityCode;
        $hotelSearch->no_of_guests    = $noOfGuests;
        $hotelSearch->city_name    = $cityDetails->name;
        $hotelSearch->country = $cityDetails->country_name;
        $hotelSearch->country_code = $cityDetails->country_code;
        $hotelSearch->check_in = $checkIn;
        $hotelSearch->check_out = $checkOut;
        $hotelSearch->rooms_request = json_encode($hotelRequestArray['PaxRooms']);
        $hotelSearch->ip_address = $_SERVER['REMOTE_ADDR'];
        $hotelSearch->hotel_traveller_info = $request->input('hotels-travellers-class');
        $hotelSearch->request_json = json_encode($request->input());
        $hotelSearch->save();
        //dd(['hotelCode' => encrypt($request->input('hotelsCode')), 'searchId' => encrypt($hotelSearch->id)]);

        return redirect()->route('HotelDetails', ['hotelCode' => encrypt($request->input('hotelsCode')), 'searchId' => encrypt($hotelSearch->id)]);


    }

    public function PreBooking($hotelCode,$bookingCode,$searchId){

        //PreBooking
        $hotelCode = decrypt($hotelCode);
        $bookingCode = decrypt($bookingCode);
        $searchId = decrypt($searchId);

        $titles = [
            'title' => "Save Passanger Details",
        ];
        
        $prebooking = new BookingController();
        $prebookingDeatails = $prebooking->TboPreBooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=>$bookingCode]);
        // dd($prebookingDeatails);
        $result = [];

        //hotelDetails

        $hotelDetails = TboHotel::where('hotel_code' , $hotelCode)->first()->toArray();
        $result['hotelDetails'] = $hotelDetails;
        $result['hotelDetails']['image'] = !empty(json_decode($hotelDetails['images'])) ? json_decode($hotelDetails['images'])[0] : null;
        if(!isset($prebookingDeatails['preBooking'][0]['Rooms'][0]))
        {
            //error page
            //session expire
            $data['errorresponse'] = 'Session Expired';
            $titles = [
                'title' => "Error Page",
            ];

            return view('front_end.error',compact('titles','data'));

        }
        
        if(app()->getLocale() == 'ar')
        {
            $name = 'IFNULL(name_ar,name) as name' ;
        }
        else{
            $name = 'name' ;
        }
        //dd($prebookingDeatails['preBooking'][0]['Rooms'][0]);
        if($prebookingDeatails['preBooking'][0]['Rooms'][0]){
            //$supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
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

        }
        $result['countries'] = Country::select('id',DB::raw($name),'phone_code')->whereNotNull("phone_code")->get();
        $result['roomDetails'] = $prebookingDeatails['preBooking'][0]['Rooms'][0] ?? [];
        $result['RateConditions'] = $prebookingDeatails['preBooking'][0]['RateConditions'] ?? [];
        $result['searchRequest'] = HotelSearch::find($searchId);
        $result['searchRequest']->rooms_request = json_decode($result['searchRequest']->rooms_request,true);
        $result['bookingCode'] = $bookingCode;
        $result['hotelCode'] = $hotelCode;
        $result['searchId'] = $searchId;

        $currentDate = Carbon::now()->toDateString();
        $couponCodes = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->whereIn('coupon_valid_on' ,[1,3])->get();
        $result['couponCodes'] = $couponCodes;




        return view('front_end.hotel.pre_booking',compact('titles','result'));
    }

    public function savePassanger(Request $request)
    {

        $hotelCode = decrypt($request->input('hotelCode'));
        $bookingCode = decrypt($request->input('bookingCode'));
        $searchId = decrypt($request->input('searchId'));
        
        $prebooking = new BookingController();
        $prebookingDeatails = $prebooking->TboPreBooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=> $bookingCode]);
        if(!isset($prebookingDeatails['preBooking'][0]['Rooms'][0]))
        {
            //error page
            //session expire
            $data['errorresponse'] = 'Session Expired';
            $titles = [
                'title' => "Error Page",
            ];

            return view('front_end.error',compact('titles','data'));

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

        if(Auth::guard('web')->check())
        {
            $hotelRoomBooking->user_id = Auth::guard('web')->id();
            $hotelRoomBooking->user_type = 'web';
        }
        else
        {
            $hotelRoomBooking->user_type = 'web_guest';
            $GuestUser = new GuestUser();
            $GuestUser->mobile = $request->input('mobile');
            $GuestUser->country_id = $request->input('country_id');
            $GuestUser->email = $request->input('email');
            $GuestUser->user_type = 'web';
            $GuestUser->type = 'hotel';
            $GuestUser->save();
        }
        $hotelRoomBooking->mobile = $request->input('mobile');
        $hotelRoomBooking->country_id = $request->input('country_id');
        $hotelRoomBooking->email = $request->input('email');

        
        $couponCode = null ;
        if($request->has('applyed_coupon_code') && !empty($request->input('applyed_coupon_code'))){
            $couponCode = $request->input('applyed_coupon_code') ;   
        }

        $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups'] = hotelMarkUpPrice(array('totalPrice' => isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate'] : $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax'] ,'paymentType' => $request->input('type_of_payment') ?? 'k_net' ,'couponCode' => $couponCode));

        
        
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
        foreach($request->input('room') as $r=>$room){
            if(isset($room['adult']))
            {
                foreach ($room['adult'] as $key => $value) {
                    if($value['title'] == "Mr")
                    {
                        $gender = 'M';
                    }elseif($value['title'] == "Ms")
                    {
                        $gender = 'F';
                    }elseif($value['title'] == "Mrs")
                    {
                        $gender = 'F';
                    }
                    else{
                        $gender = 'F';
                    }
                    $HotelBookingTravelers = new HotelBookingTravelsInfo();
                    $HotelBookingTravelers->title = $value['title'];
                    $HotelBookingTravelers->first_name = $value['firstName'];
                    $HotelBookingTravelers->last_name = $value['lastName'];
                    $HotelBookingTravelers->room_no = $r+1;
                    $HotelBookingTravelers->gender = $gender;
                    $HotelBookingTravelers->traveler_type = 'ADT';
                    $HotelBookingTravelers->hotel_booking_id = $hotelRoomBooking->id;
                    $HotelBookingTravelers->save();
                }
            }

            if(isset($room['child']))
            {
                foreach ($room['child'] as $key => $value) {
                    // if($value['title'] == "Master")
                    // {
                    //     $gender = 'M';
                    // }elseif($value['title'] == "Miss")
                    // {
                    //     $gender = 'F';
                    // }
                    // else{
                    //     $gender = 'F';
                    // }
                    if($value['title'] == "Mr")
                    {
                        $gender = 'M';
                    }elseif($value['title'] == "Ms")
                    {
                        $gender = 'F';
                    }elseif($value['title'] == "Mrs")
                    {
                        $gender = 'F';
                    }
                    else{
                        $gender = 'F';
                    }
                    $HotelBookingTravelers = new HotelBookingTravelsInfo();
                    $HotelBookingTravelers->title = $value['title'];
                    $HotelBookingTravelers->first_name = $value['firstName'];
                    $HotelBookingTravelers->last_name = $value['lastName'];
                    $HotelBookingTravelers->room_no = $r+1;
                    $HotelBookingTravelers->gender = $gender;
                    $HotelBookingTravelers->traveler_type = 'CNN';
                    $HotelBookingTravelers->hotel_booking_id = $hotelRoomBooking->id;
                    $HotelBookingTravelers->save();
                }
            }
        }

        $hotelbookingId = encrypt($hotelRoomBooking->id);

        return redirect()->route('HotelBookingPreview', ['bookingId' => $hotelbookingId]);

    }

    public function HotelBookingPreview($hotelbookingId){
        $titles = [
            'title' => "Traveller Preview ",
        ];
        $result =[];

        $hotelbookingId = decrypt($hotelbookingId);

        $result['bookingDetails'] = $bookingDetails = HotelBooking::with('Customercountry','CouponDetails')->find($hotelbookingId);
        $result['passengersInfo'] = $passengersInfo = HotelBookingTravelsInfo::whereHotelBookingId($hotelbookingId)->get();

        $prebooking = new BookingController();
        $prebookingDeatails = $prebooking->TboPreBooking(['hotel_code' => $bookingDetails->hotel_code ,'search_id' => $bookingDetails->search_id , 'booking_code'=> $bookingDetails->booking_code]);

        $hotelDetails = TboHotel::where('hotel_code' , $bookingDetails->hotel_code)->first()->toArray();
        $result['hotelDetails'] = $hotelDetails;
        $result['hotelDetails']['image'] = !empty(json_decode($hotelDetails['images'])) ? json_decode($hotelDetails['images'])[0] : null;
        if(!isset($prebookingDeatails['preBooking'][0]['Rooms'][0]))
        {
            //error page
            //session expire
            $data['errorresponse'] = 'Session Expired';
            $titles = [
                'title' => "Error Page",
            ];

            return view('front_end.error',compact('titles','data'));

        }
        if($prebookingDeatails['preBooking'][0]['Rooms'][0]){

            $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']:$prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax'] ,'paymentType' => $bookingDetails->type_of_payment ?? 'k_net' , 'couponCode' =>  $bookingDetails->CouponDetails->coupon_code ?? null));
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
        }

        $result['roomDetails'] = $prebookingDeatails['preBooking'][0]['Rooms'][0] ?? [];
        
        $result['RateConditions'] = $prebookingDeatails['preBooking'][0]['RateConditions'] ?? [];
        $result['searchRequest'] = HotelSearch::find($bookingDetails->search_id);


        return view('front_end.hotel.preview',compact('titles','result'));

    }

    public function HotelpaymentGateWay(Request $request)
    {
        //payment gate way invoice generation
        $bookingId = decrypt($request->input('booking_id'));
        if(empty($bookingId))
        {
            //error
            return redirect()->route('some-thing-went-wrong');
        }
        $BookingDetails = HotelBooking::with('Customercountry')->find($bookingId);
        if(empty($BookingDetails))
        {
            //error
            return redirect()->route('some-thing-went-wrong');
        }

        if($BookingDetails->type_of_payment == 'wallet'){
            $BookingDetails->booking_status = 'payment_initiated';
            $BookingDetails->save();
            return redirect()->away(route('bookHotelRooms',['hotelbookingId' => encrypt($BookingDetails->id)]));
        }else{
            //$userName = Auth::guard('web')->check() ? Auth::guard('web')->user()->name : 'guest' ;
            $passengersInfo = HotelBookingTravelsInfo::whereHotelBookingId($BookingDetails->id)->first();
        
            $userName = (!empty($passengersInfo)) ? $passengersInfo->first_name . " ".$passengersInfo->last_name : 'guest';
        
            $callbackURL = route('bookHotelRooms',['hotelbookingId' => encrypt($BookingDetails->id)]) ;
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
                'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION,
                'payment_type'       => $BookingDetails->type_of_payment
            ];
            //dd($getPayLoadData);
            $myfatoorah = new MyFatoorahController();
            $invoicedata = $myfatoorah->index($getPayLoadData);
            if($invoicedata['IsSuccess'] == "true")
            {
                $BookingDetails->invoice_id = $invoicedata['Data']['invoiceId'];
                $BookingDetails->myfatoorah_url = $invoicedata['Data']['invoiceURL'];
                $BookingDetails->booking_status = 'payment_initiated';
                $BookingDetails->save();
                $url = $invoicedata['Data']['invoiceURL'];
                return redirect()->away($url);
            }
            else{
                //error page
                return redirect()->route('some-thing-went-wrong');
            }
        }


        
        


    }

    public function bookHotelRooms($hotelBookingId){
        $hotelBookingId = decrypt($hotelBookingId);
        $hotelbookingdetails  = HotelBooking::find($hotelBookingId);
        $paymentId = ($hotelbookingdetails->type_of_payment != 'wallet') ? request('paymentId') : null;
        if($hotelbookingdetails->booking_status == 'payment_initiated')
        {
            if($hotelbookingdetails->type_of_payment == 'wallet'){
                //checking wallet balance
                if(auth()->user()->wallet_balance >= $hotelbookingdetails->sub_total){
                    //debit from wallet
                    $wallet = auth()->user()->wallet_balance - $hotelbookingdetails->sub_total;
                    $user = User::find(auth()->user()->id);
                    $user->wallet_balance = $wallet;
                    $user->save();
                    $walletDetails = WalletLogger::create([
                        'user_id' => auth()->user()->id,
                        'reference_id' => $hotelbookingdetails->id,
                        'reference_type' => 'hotel',
                        'amount' => $hotelbookingdetails->sub_total,
                        'remaining_amount' => $wallet,
                        'amount_description' => 'KWD '.$hotelbookingdetails->sub_total .' debit for booking id '.$hotelbookingdetails->booking_ref_id,
                        'action' => 'subtracted',
                        'status' =>'Active',
                        'date_of_transaction' => Carbon::now()
                    ]);
                    $walletUniqueId = 'WL'.str_pad($walletDetails->id, 7, '0', STR_PAD_LEFT);
                    $walletDetails->unique_id = $walletUniqueId;
                    $walletDetails->save();
                    $invoicedata['IsSuccess'] = true;
                    $invoicedata['Data'] = new stdClass();
                    $invoicedata['Data']->InvoiceStatus = "Paid";
                }else{
                    $invoicedata['IsSuccess'] = false;
                    $invoicedata['Data'] = new stdClass();
                    $invoicedata['Data']->InvoiceStatus = "Insufficient funds in wallet";
                }
            }else{
                $myfatoorah = new MyFatoorahController();
                $invoicedata = $myfatoorah->callback($paymentId);
            }
            
            if($invoicedata['IsSuccess'])
            {
                $titles = [
                    'title' => "Hotel Reservation Details",
                ];
                
                $hotelbookingdetails->invoice_status = $invoicedata['Data']->InvoiceStatus;
                $hotelbookingdetails->invoice_response = json_encode($invoicedata['Data']);
                $hotelbookingdetails->payment_id = $paymentId;
                if($invoicedata['Data']->InvoiceStatus == 'Paid')
                {
                    $hotelbookingdetails->booking_status = 'payment_successful';
                    if($hotelbookingdetails->type_of_payment == 'wallet'){
                        $hotelbookingdetails->payment_gateway = 'WALLET';  
                        $hotelbookingdetails->invoice_id = $walletUniqueId ?? null;
                    }else{
                        $hotelbookingdetails->payment_gateway = $invoicedata['Data']->focusTransaction->PaymentGateway;
                    }
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

                        return view('front_end.hotel.pending_reservation',compact('titles','result'));
                        
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
                        if($hotelbookingdetails->type_of_payment == 'wallet'){
                            $this->refund($hotelbookingdetails->id );
                        }
                        return view('front_end.error',compact('titles','data'));
                        
                    }
                  

                }
                else{
                    //if not paid or expired

                    $data['errorresponse'] = $invoicedata['Data']->InvoiceStatus;
                    //travelport request error response
                    //refund should initate
                    //redirect to error page

                    return view('front_end.error',compact('titles','data'));
                }
            }else{
                $titles = ['title' => "Hotel Booking failure"];
                if($hotelbookingdetails->type_of_payment == 'wallet'){
                    $data['errorresponse'] = "Insufficient funds in wallet";           
                }else{
                    $data['errorresponse'] = "Something went wrong";   
                }
                return view('front_end.error',compact('titles','data'));
            }
        }

    }

    // public function getBookingDetails(){
    //     $titles = [
    //         'title' => "Hotel Reservation Details",
    //     ];
    //     $tboBookingDeatils = new BookingController();
    //     $tboBookingDetails = $tboBookingDeatils->BookingDetails(['booking_id' => 2 , 'confirmation_number' => 'GX01F8']);

    //     $result = [];

    //     $hotel_booking_Details = HotelBooking::find(2); 

    //     $hotel_booking_Details->reservation_status = $tboBookingDetails['reservation_details']['BookingStatus'];
    //     $hotel_booking_Details->check_in = explode('T',$tboBookingDetails['reservation_details']['CheckIn'])[0] ?? null;
    //     $hotel_booking_Details->check_out = explode('T',$tboBookingDetails['reservation_details']['CheckOut'])[0] ?? null;
    //     $hotel_booking_Details->booking_details_json_request_id = $tboBookingDetails['json_request_id'];

    //     $hotel_booking_Details->save();

    //     if($hotel_booking_Details->user_type != 'web_guest')
    //     {
    //         $userdetails = User::find($hotel_booking_Details->user_id);
    //         $user = $userdetails->first_name.' '.$userdetails->last_name;
    //     }
    //     else{
    //         $user = 'Customer';
    //     }

    //     $result['hotel_details'] = TboHotel::where('hotel_code' , $hotel_booking_Details->hotel_code)->first();
    //     $result['hotel_booking_Details'] =$hotel_booking_Details;
    //     $result['reservation_details'] = $tboBookingDetails['reservation_details'];
    //     $result['hotel_booking_travelers_info'] = HotelBookingTravelsInfo::where("hotel_booking_id" , $hotel_booking_Details->id)->get();
    //     $result['user'] = $user;
        
    //     return view('front_end.hotel.email_templates.reservation',compact('titles','result'));
    //     // $filename = "Reservation_".$hotel_booking_Details->booking_ref_id.".pdf";
    //     // $pdf = PDF::loadView('front_end.hotel.email_templates.reservation', compact('titles','result'));
    //     // $pdf->save('pdf/hotel_reservation/' . $filename);


    //     dd($result);
    // }

    //cron job for hotel reservation 

    public function hotelReservation(){
        $titles = [
            'title' => "Hotel Reservation",
        ];
        $reservations = HotelReservation::whereStatus(1)->whereCronStatus(0)->whereDate('enable_request_on', '<=', date('Y-m-d'))->whereTime('enable_request_on', '<=', date('H:i:s'))->limit(2)->get();
        foreach($reservations as $reservation){
            $hotelbookingdetails = HotelBooking::find($reservation->booking_id); 
            $tboBookingDeatils = new BookingController();
            $tboBookingDetails = $tboBookingDeatils->BookingDetails(['booking_id' => $reservation->booking_id , 'confirmation_number' => $reservation->confirmation_number]);
            if($tboBookingDetails['success'] == true)
            {
                $hotelbookingdetails->reservation_status = $tboBookingDetails['reservation_details']['BookingStatus'];
                $hotelbookingdetails->check_in = explode('T',$tboBookingDetails['reservation_details']['CheckIn'])[0] ?? null;
                $hotelbookingdetails->check_out = explode('T',$tboBookingDetails['reservation_details']['CheckOut'])[0] ?? null;
                $hotelbookingdetails->booking_details_json_request_id = $tboBookingDetails['json_request_id'];
                if($tboBookingDetails['reservation_details']['BookingStatus'] == 'Confirmed')
                {
                    $hotelbookingdetails->booking_status = 'booking_completed';
                }
                $hotelbookingdetails->save();

                // if($hotelbookingdetails->user_type != 'web_guest' && $hotelbookingdetails->user_type != 'app_guest')
                // {
                //     $userdetails = User::find($hotelbookingdetails->user_id);
                //     $user = $userdetails->first_name.' '.$userdetails->last_name;
                // }
                // else{
                //     $user = 'Customer';
                // }
                $hotelCustomersInfo = HotelBookingTravelsInfo::where("hotel_booking_id" , $hotelbookingdetails->id)->get();

                $user = $hotelCustomersInfo[0]->first_name .' '.$hotelCustomersInfo[0]->last_name;

                $result['hotel_details'] = TboHotel::where('hotel_code' , $hotelbookingdetails->hotel_code)->first();
                $result['hotel_booking_Details'] =$hotelbookingdetails;
                $result['reservation_details'] = $tboBookingDetails['reservation_details'];
                $result['hotel_booking_travelers_info'] = HotelBookingTravelsInfo::where("hotel_booking_id" , $hotelbookingdetails->id)->get();
                $result['user'] = $user;
                $filename = "Reservation_".$hotelbookingdetails->booking_ref_id.".pdf";
                $pdf = PDF::loadView('front_end.hotel.email_templates.reservation', compact('titles','result'));
                $pdf->save('pdf/hotel_reservation/' . $filename);
                Mail::send('front_end.hotel.email_templates.reservation', compact('titles','result'), function($message)use($pdf,$hotelbookingdetails,$filename) {
                    $message->to($hotelbookingdetails->email)
                            ->subject('Hotel Reservation')
                            ->attachData($pdf->output(), $filename);
                });

                $reservation->hotel_reservation_booking_path = 'pdf/hotel_reservation/' . $filename;
                $reservation->json_request_id =  $tboBookingDetails['json_request_id'];
                $reservation->reservation_status = $tboBookingDetails['reservation_details']['BookingStatus'];
                $reservation->execuated_date_time =  now();
                $reservation->cron_status =  1;
                $reservation->save();

                $hotelbookingdetails->hotel_room_booking_path = 'pdf/hotel_reservation/' . $filename;
                $hotelbookingdetails->save();

                Log::info($reservation->confirmation_number . " execuated sucessfully");
            }
            else{
                $hotelbookingdetails->booking_status = 'booking_failure';
                $hotelbookingdetails->booking_details_json_request_id = $tboBookingDetails['json_request_id'];
                $hotelbookingdetails->save();

                $reservation->reservation_status = 'failure';
                $reservation->execuated_date_time =  now();
                $reservation->json_request_id = $tboBookingDetails['json_request_id'];
                $reservation->cron_status =  1;
                $reservation->save();
                Log::info($reservation->confirmation_number . " execuated failure");

            }

            
            // $result['showDownload'] = true;
            // return view('front_end.hotel.email_templates.reservation',compact('titles','result'));

        }
        
        
    }

    private function refund($bookingId)
    {
        $hotelBookingdetails = HotelBooking::find($bookingId);
    
        $hotelBookingdetails->booking_status = "refund_initiated";
        $hotelBookingdetails->save();
    
        if($hotelBookingdetails->type_of_payment == 'wallet'){
            $wallet = auth()->user()->wallet_balance + $hotelBookingdetails->sub_total;
            auth()->user()->update(['wallet_balance' => $wallet]);
            $walletDetails = WalletLogger::create([
                'user_id' => auth()->user()->id,
                'reference_id' => $hotelbookingdetails->id,
                'reference_type' => 'hotel',
                'amount' => $hotelBookingdetails->sub_total,
                'remaining_amount' => $wallet,
                'amount_description' => 'KWD '.$hotelBookingdetails->sub_total .' refunded for booking id '.$hotelBookingdetails->booking_ref_id,
                'action' => 'added',
                'status' =>'Active',
                'date_of_transaction' => Carbon::now()
            ]);
            $walletDetails->unique_id = 'WL'.str_pad($walletDetails->id, 7, '0', STR_PAD_LEFT);
            $walletDetails->save();
            $hotelBookingdetails->booking_status = "refund_completed";
            $hotelBookingdetails->save();
        }
    
    }
}
