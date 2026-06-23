<?php

namespace App\Http\Controllers\FrontEnd\Hotel\Webbeds;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Hotel\Xml\BookingController;
use App\Http\Controllers\FrontEnd\Hotel\Xml\SearchController;
use App\Http\Controllers\MyFatoorahController;
use App\Models\Agency;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\DidaHotel;
use App\Models\GuestUser;
use App\Models\HotelBooking;
use App\Models\HotelBookingTravelsInfo;
use App\Models\HotelCity;
use App\Models\HotelReservation;
use App\Models\HotelRoomBookingInfo;
use App\Models\HotelSearch;
use App\Models\HotelXmlRequest;
use App\Models\PendingHotelRoomBooking;
use App\Models\SeoSettings;
use App\Models\TboHotel;
use App\Models\User;
use App\Models\WalletLogger;
use App\Models\WebbedsCity;
use App\Models\WebbedsCountry;
use App\Models\WebbedsHotel;
use App\Models\WebbedsHotelSearch;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PDF;
use stdClass;

class HomeController extends Controller
{
    //
    public function AjaxHotelCityList(Request $request){
        $search = $request->input('q');
        //$hotel = WebbedsCity::select('code','name',DB::raw('CONCAT (name," - ",country_name) as display_name ,country_name'));
        //$hotel = WebbedsCity::select('id','dida_code','long_name',DB::raw('CONCAT (long_name," - ",country_name) as display_name ,country_name'));
        $hotel = HotelCity::select('id','dida_code','long_name',DB::raw('CONCAT (name," - ",country_name) as display_name ,country_name'));
        // dida code is not empty
        $hotel->where('dida_code', '!=', 0);
        // $hotel->having('display_name', 'LIKE', '%'.$search.'%');
        $hotel->where('name' ,'LIKE', '%'.$search.'%');
        $hotel->orderBy('preference' ,'desc');
        $hotel = $hotel->get()->toArray();
        return $hotel;

        
    }

    public function SearchHotels(Request $request){
        // dd($request->input());
         set_time_limit(300); 
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

        $mealType = [];
        $bedType = [];

        $result['countries'] = WebbedsCountry::get();
        $request->merge(['search_url' => $request->fullUrl()]);


        $SearchController = new SearchController();
        $searchId = $this->SaveSearch($request);
        $request->merge(['search_request_id' => $searchId]);
        $result['searchRequest'] = WebbedsHotelSearch::find($searchId)->toArray();
        $noOfRooms = $request->input('noOfRooms');
        $cityCode = $result['searchRequest']['city_code'];
        $result['hotelList'] = [];

        $result['searchRequest']['city_code'] = null;
        
       
        //webbeds
        // if(!empty($result['searchRequest']['city_code'])){
        //     $searchResponse = $SearchController->Search($request);
        //     $searchResponse =  $searchResponse['hotelResponse'];
        //     if(isset($searchResponse['hotels']['hotel']['@attributes'])){
        //         $searchResponse['hotels']['hotel'] = [$searchResponse['hotels']['hotel']];
        //     }
        //     if($searchResponse['successful'] == "TRUE" && count($searchResponse['hotels']['hotel']) > 0)
        //     {
        //         $hotelsdata = $searchResponse['hotels']['hotel'];
        //         $roomAvailablelHotelIds = array_map(function ($hotel) {
        //             return $hotel['@attributes']['hotelid'] ?? null;
        //         }, $hotelsdata);

        //         // Optionally remove nulls (in case of missing hotelid)
        //         $roomAvailablelHotelIds = array_filter($roomAvailablelHotelIds);
                
        //         $avialableWebbedsHotel = WebbedsHotel::select('hotel_code')->whereIn('hotel_code' , $roomAvailablelHotelIds)->get();
        //         $availableHotelIdList = array_column($avialableWebbedsHotel->toArray() , 'hotel_code');
        //         $unavailableHotelIdList = array_diff($roomAvailablelHotelIds , $availableHotelIdList);

        //         //fetching unavailable hotels from webbeds
        //         $SearchController = new SearchController();
        //         $SearchController->fetchUnavailableHotels(['hotelIds' => $unavailableHotelIdList , 'cityCode' => $cityCode]);
               

        //         //after fetching 
        //         $availableHotelDetailsList = DB::table('webbeds_hotels')->select('hotel_code' , 'hotel_name' , 'hotel_rating' , 'address' , 'thumbnail' , 'check_in' , 'check_out','exclusive','preferred','phone_number','pin_code')->whereIn('hotel_code' , $roomAvailablelHotelIds)->get();
        //         //dd($roomAvailablelHotelIds ,$availableHotelDetailsList);
        //         // dd($searchResponse);
                
               
        //         foreach ($searchResponse['hotels']['hotel'] as $key => $value) {
        //             $hotelCode = $value['@attributes']['hotelid'];
        //             $hotelDetails = $availableHotelDetailsList->firstWhere('hotel_code', $hotelCode);
        //             if($hotelDetails){

        //                 $value['rooms']['room'] = nodeConvertion($value['rooms']['room']);

        //                 foreach($value['rooms']['room'] as $rk => $room){
        //                     $value['rooms']['room'][$rk]['roomType'] = nodeConvertion($value['rooms']['room'][$rk]['roomType']);
        //                     foreach($value['rooms']['room'][$rk]['roomType'] as $rtk => $roomType){
        //                         $value['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis'] = nodeConvertion($value['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis']);
        //                     }
        //                 }

        //                 $roomInfo = [];
        //                 foreach ($value['rooms']['room'] as $rk => $room) {
        //                     foreach ($room['roomType'] as $rtk => $roomType) {
        //                         foreach ($roomType['rateBases']['rateBasis'] as $rbk => $rateBasis) {
        //                             $roomTypeCode = $roomType['@attributes']['roomtypecode'];
        //                             $rateBasisId = $rateBasis['@attributes']['id'];
        //                             $key = $roomTypeCode . '_' . $rateBasisId;
        //                             // Prepare allocation detail
        //                             if (!isset($roomInfo[$key])) {
        //                                 // First time adding this combination
        //                                 $roomInfo[$key] = [
        //                                     'name' => $roomType['name'],
        //                                     'total' => $rateBasis['total'],
        //                                     'roomCount' => 1
        //                                 ];
        //                             } else {
        //                                 // Already exists — add to total and append allocationDetails
        //                                 $roomInfo[$key]['total'] += $rateBasis['total'];
        //                                 $roomInfo[$key]['roomCount']++;
        //                             }
        //                         }
        //                     }
        //                 }
        //                 //dd($roomInfo,$noOfRooms);
        //                 $roomInfo = array_values($roomInfo);
                        
        //                 foreach ($roomInfo as $key => $roomDetails) {
        //                     if($roomDetails['roomCount'] != $noOfRooms){
        //                         unset($roomInfo[$key]);
        //                     }
        //                 }
        //                 $roomInfo = array_values($roomInfo);

        //                 if(!empty($roomInfo)){
        //                     $markup = hotelMarkUpPrice(array('totalPrice' => $roomInfo[0]['total'] , 'currencyCode' => 'KWD' , 'totalTax' => $roomInfo[0]['totalTaxes'] ?? 0));
                            
        //                     $result['hotelList'][] = [
        //                         'hotelName' => $hotelDetails->hotel_name,
        //                         'hotelRating' => $hotelDetails->hotel_rating,
        //                         'address' => $hotelDetails->address,
        //                         'image' => !empty($hotelDetails->thumbnail) ? $hotelDetails->thumbnail : null,
        //                         'hotelCode' => $hotelDetails->hotel_code,
        //                         'checkIn' => $hotelDetails->check_in,
        //                         'checkOut' => $hotelDetails->check_out,
        //                         //'bookingCode' => $value['Rooms'][0]['BookingCode'],
        //                         'rooms' => $value['rooms']['room'][0]['roomType'][0]['name']??null,
        //                         //'totalFare' => sprintf("%.3f", $value['Rooms'][0]['TotalFare']),
        //                         'currenceCode' => '769',
        //                         //'isRefundable' => $value['Rooms'][0]['IsRefundable'] ??null,
        //                         'markups' => $markup,
        //                         'exclusive' => $hotelDetails->exclusive,
        //                         'preferred' => $hotelDetails->preferred,
        //                         'phone_number' => $hotelDetails->phone_number,
        //                         'pin_code' => $hotelDetails->pin_code,
        //                         'type' => 'webbeds',
        //                         'mealType' => null,
        //                         'bedType' => null
        //                         //'roomPromotion' => isset($value['Rooms'][0]['RoomPromotion']) ? $value['Rooms'][0]['RoomPromotion'] :[]
        //                     ];
                            

        //                     switch ($hotelDetails->hotel_rating) {
        //                         case '1':
        //                             $rating1++;
        //                             break;
        //                         case '2':
        //                             $rating2++;
        //                             break;
        //                         case '3':
        //                             $rating3++;
        //                             break;
        //                         case '4':
        //                             $rating4++;
        //                             break;
        //                         case '5':
        //                             $rating5++;
        //                             break; 
        //                     }

        //                     if($markup)
        //                     {
        //                         $price = $markup['totalPrice']['value'];
        //                         //minprice
        //                         if($minPrice == 0)
        //                         {
        //                             $minPrice = $price;
        //                         }
        //                         elseif($price < $minPrice)
        //                         {
        //                             $minPrice = $price;
        //                         }
        //                         //maxprice
        //                         if($maxPrice == 0)
        //                         {
        //                             $maxPrice = $price;
        //                         }
        //                         elseif($price > $maxPrice)
        //                         {
        //                             $maxPrice = $price;
        //                         }
        //                     }   
        //                 }
        //             }
        //         }
              
        //         usort($result['hotelList'], function($a, $b) {
        //             return $a['markups']['totalPrice']['value'] <=> $b['markups']['totalPrice']['value'];
        //         });
        //     }else{
              
        //         //no hotels found in webbeds
        //     }
        // }
     
        //Restel
        // if(!empty($result['searchRequest']['restel_city_code'])){
            
        //     $restelHotels = $SearchController->restelSearch($result['searchRequest'])['hotelResponse'];
        //     //dd($restelHotels);
        //     if(isset($restelHotels['param']['error'])){
        //         //no hotels found in restel
        //     }else{
        //         foreach($restelHotels['param']['hotls']['hot'] as $hotelDetails){

        //             $roomNames = null ;
        //             $price = null ;

        //             foreach($hotelDetails['res']['pax'] as $ff=>$roomDetails){
        //                 // echo $hotelDetails['nom'];
        //                 // echo "ramu";echo $ff;echo "ramu";
        //                 // print_r($roomDetails['hab'][0]['reg'][0]['@attributes']['prr']);
        //                 if(!isset($roomDetails['hab'][0])){
        //                     $roomDetails['hab'][0] = $roomDetails['hab'];
        //                     if(!isset($roomDetails['hab'][0]['reg'][0])){
        //                         $roomDetails['hab'][0]['reg'][0] = $roomDetails['hab'][0]['reg'];
        //                     }
        //                 }
        //                 $roomNames .= $roomDetails['hab'][0]['@attributes']['desc'] ?? '';
        //                 $price += (float)$roomDetails['hab'][0]['reg'][0]['@attributes']['prr'] ?? 0.00;
        //             }

        //             $markup = hotelMarkUpPrice(array('totalPrice' => $price , 'currencyCode' => 'USD' , 'totalTax' => 0));
        //             $result['hotelList'][] = [
        //                 'hotelName' => $hotelDetails['nom'],
        //                 'hotelRating' => $hotelDetails['cat'],
        //                 'address' => $hotelDetails['como_llegar'],
        //                 'image' => !empty($hotelDetails['thumbnail']) ? $hotelDetails['thumbnail'] : null,
        //                 'hotelCode' => $hotelDetails['cod'],
        //                 'checkIn' =>  Carbon::createFromFormat('Ymd', $hotelDetails['fen'])->format('d-m-Y'),
        //                 'checkOut' => Carbon::createFromFormat('Ymd', $hotelDetails['fsa'])->format('d-m-Y'),
        //                 //'bookingCode' => $value['Rooms'][0]['BookingCode'],
        //                 'rooms' => $roomNames??null,
        //                 //'totalFare' => sprintf("%.3f", $value['Rooms'][0]['TotalFare']),
        //                 'currenceCode' => '769',
        //                 //'isRefundable' => $value['Rooms'][0]['IsRefundable'] ??null,
        //                 'markups' => $markup,
        //                 'exclusive' => null,
        //                 'preferred' => null,
        //                 'phone_number' => null,
        //                 'pin_code' => null,
        //                 'tourismCertificate' => $hotelDetails['cal'],
        //                 'type' => 'restel'
        //                 //'roomPromotion' => isset($value['Rooms'][0]['RoomPromotion']) ? $value['Rooms'][0]['RoomPromotion'] :[]
        //             ];
                    
        //             switch ($hotelDetails['cat']) {
        //                 case '1':
        //                     $rating1++;
        //                     break;
        //                 case '2':
        //                     $rating2++;
        //                     break;
        //                 case '3':
        //                     $rating3++;
        //                     break;
        //                 case '4':
        //                     $rating4++;
        //                     break;
        //                 case '5':
        //                     $rating5++;
        //                     break; 
        //             }

        //             if($markup)
        //             {
        //                 $price = $markup['totalPrice']['value'];
        //                 //minprice
        //                 if($minPrice == 0)
        //                 {
        //                     $minPrice = $price;
        //                 }
        //                 elseif($price < $minPrice)
        //                 {
        //                     $minPrice = $price;
        //                 }
        //                 //maxprice
        //                 if($maxPrice == 0)
        //                 {
        //                     $maxPrice = $price;
        //                 }
        //                 elseif($price > $maxPrice)
        //                 {
        //                     $maxPrice = $price;
        //                 }
        //             } 


        //         }
        //          usort($result['hotelList'], function($a, $b) {
        //             return $a['markups']['totalPrice']['value'] <=> $b['markups']['totalPrice']['value'];
        //         });

        //     }
        // }
        // Dida
        // if(!empty($result['searchRequest']['dida_destination_code'])){
            
        //     $didaHotels = $SearchController->didaSearch($request);
        //     if(!empty($didaHotels['response'])){
        //         $response = $didaHotels['response'] ?? [];

        //         // Step 1: Extract all HotelIDs
        //         $hotelIds = collect($response)->pluck('HotelID')->toArray();

        //         // Step 2: Fetch ratings from your database
        //         // (Assuming your model is DidaHotel and has columns: hotel_id and rating)
        //         $hotelInfos = DidaHotel::whereIn('hotel_id', $hotelIds)->select('hotel_id', 'star_rating', 'address' ,'telephone', 'zip_code', 'name','images','thumbnail')->get()->keyBy('hotel_id')
        //                         ->map(function ($hotel) {
        //                             return [
        //                                 'star_rating' => $hotel->star_rating,
        //                                 'address' => $hotel->address,
        //                                 'telephone' => $hotel->telephone,
        //                                 'zip_code' => $hotel->zip_code,
        //                                 'name' => $hotel->name,
        //                                 'images' => $hotel->images,
        //                                 'thumbnail' => $hotel->thumbnail
        //                             ];
        //                         })->toArray();
        //         //dd($hotelInfos);
        //         foreach($response as $hotel){
        //             //dd($hotel);

        //             $markup = hotelMarkUpPrice(array('totalPrice' => $result['searchRequest']['no_of_rooms']*$hotel['RatePlanList'][0]['TotalPrice'] , 'currencyCode' => 'USD' , 'totalTax' => 0));

        //             $bedTypeName = didaType('BedType' , $hotel['RatePlanList'][0]['BedType']);
                    
        //             $bedTypeCode = Str::slug($bedTypeName);
        //             if(!isset($bedType[$bedTypeCode]))
        //             {
        //                 $bedType[$bedTypeCode] = ['code' => $bedTypeCode,'name' => $bedTypeName ,'count' => 1];
        //             }else{
        //                 $bedType[$bedTypeCode]['count']++;
        //             }

        //             $mealTypeName = didaType('MealType' , $hotel['RatePlanList'][0]['PriceList'][0]['MealType']);
        //             $mealTypeCode = Str::slug($mealTypeName);
        //             if(!isset($mealType[$mealTypeCode]))
        //             {
        //                 $mealType[$mealTypeCode] = ['code' => $mealTypeCode,'name' => $mealTypeName ,'count' => 1];
        //             }else{
        //                 $mealType[$mealTypeCode]['count']++;
        //             }

        //             $thumbnail = asset('frontEnd/images/no-hotel-image.png');
                    
        //             if(!empty($hotelInfos[$hotel['HotelID']]['thumbnail']))
        //             {
        //                 $thumbnail = $hotelInfos[$hotel['HotelID']]['thumbnail'];
        //             }elseif(!empty($hotelInfos[$hotel['HotelID']]['images'])){
        //                 $thumbnail = explode("," , $hotelInfos[$hotel['HotelID']]['images'])[0] ?? asset('frontEnd/images/no-hotel-image.png');
        //             }
        //             //dd($thumbnail,$hotelInfos[$hotel['HotelID']]['images'],$hotelInfos);
        //             $result['hotelList'][] = [
        //                 'hotelName' => $hotelInfos[$hotel['HotelID']]['name'] ?? '',
        //                 'hotelRating' => $hotelInfos[$hotel['HotelID']]['star_rating'] ?? 0,
        //                 'address' => $hotelInfos[$hotel['HotelID']]['address'] ?? 0,
        //                 //'image' => !empty($hotelDetails->thumbnail) ? $hotelDetails->thumbnail : null,
        //                 'image' =>  $thumbnail,
        //                 'hotelCode' => $hotel['HotelID'],
        //                 'checkIn' => $result['searchRequest']['check_in'] ,
        //                 'checkOut' => $result['searchRequest']['check_out'],
        //                 'rooms' => $hotel['RatePlanList'][0]['RoomName']??null,
        //                 //'totalFare' => sprintf("%.3f", $value['Rooms'][0]['TotalFare']),
        //                 'currenceCode' => '769',
        //                 //'isRefundable' => $value['Rooms'][0]['IsRefundable'] ??null,
        //                 'markups' => $markup,
        //                 'exclusive' => null,
        //                 'preferred' => null,
        //                 'phone_number' => $hotelInfos[$hotel['HotelID']]['telephone'] ?? 0,
        //                 'pin_code' => $hotelInfos[$hotel['HotelID']]['zip_code'] ?? 0,
        //                 'type' => 'dida',
        //                 'mealType' => $mealTypeCode,
        //                 'bedType' => $bedTypeCode
        //             ];
        //             switch ($hotelInfos[$hotel['HotelID']]['star_rating']) {
        //                 case '1':
        //                     $rating1++;
        //                     break;
        //                 case '2':
        //                     $rating2++;
        //                     break;
        //                 case '3':
        //                     $rating3++;
        //                     break;
        //                 case '4':
        //                     $rating4++;
        //                     break;
        //                 case '5':
        //                     $rating5++;
        //                     break; 
        //             }

        //             if($markup)
        //             {
        //                 $price = $markup['totalPrice']['value'];
        //                 //minprice
        //                 if($minPrice == 0)
        //                 {
        //                     $minPrice = $price;
        //                 }
        //                 elseif($price < $minPrice)
        //                 {
        //                     $minPrice = $price;
        //                 }
        //                 //maxprice
        //                 if($maxPrice == 0)
        //                 {
        //                     $maxPrice = $price;
        //                 }
        //                 elseif($price > $maxPrice)
        //                 {
        //                     $maxPrice = $price;
        //                 }
        //             } 
        //         }   
        //          usort($result['hotelList'], function($a, $b) {
        //             return $a['markups']['totalPrice']['value'] <=> $b['markups']['totalPrice']['value'];
        //         }); 
        //     } 
        // }
        if (!empty($result['searchRequest']['dida_destination_code'])) {
            
            $didaHotels = $SearchController->didaSearch($request);

            if (!empty($didaHotels['response'])) {

                $response = $didaHotels['response'];

                // Process DIDA hotels with optimized method
                $didaProcessed = $this->processDidaHotels(
                    $response,
                    $result['searchRequest'],
                    $mealType,
                    $bedType,
                    $rating1,
                    $rating2,
                    $rating3,
                    $rating4,
                    $rating5
                );

                $result['hotelList'] = $didaProcessed['hotelList'];
                $mealType = $didaProcessed['mealType'];
                $bedType = $didaProcessed['bedType'];
                $rating1 = $didaProcessed['rating1'];
                $rating2 = $didaProcessed['rating2'];
                $rating3 = $didaProcessed['rating3'];
                $rating4 = $didaProcessed['rating4'];
                $rating5 = $didaProcessed['rating5'];
                $minPrice = $didaProcessed['minPrice'] ?? 0;
                $maxPrice = $didaProcessed['maxPrice'] ?? 0;
            } 
        }

        
        //$cityDetails = DB::table('webbeds_cities')->where('code',$request->input('hotelsCityCode'))->first();
        $cityDetails = HotelCity::where('id',$request->input('hotelsCityId'))->first();
        if(!empty($cityDetails))
        {
            $result['cityName'] = $cityDetails->name;
        }
        else{
            $result['cityName'] = '';
        }
        $result['searchId'] = $searchId??'';

        $result['filter']['minPrice'] = $minPrice;
        $result['filter']['maxPrice'] = $maxPrice;
        // $result['filter']['refundableCount'] = $refundableCount;
        // $result['filter']['nonrefundableCount'] = $nonrefundableCount;
        $result['filter']['rating']['one_star'] = $rating1;
        $result['filter']['rating']['two_star'] = $rating2;
        $result['filter']['rating']['three_star'] = $rating3;
        $result['filter']['rating']['four_star'] = $rating4;
        $result['filter']['rating']['five_star'] = $rating5;  
        $result['filter']['mealType'] = $mealType;  
        $result['filter']['bedType'] = $bedType;   
        //dd($result);   

        return view('front_end.hotel.webbeds.search',compact('titles','result'));
    }

    
    private function processDidaHotels(
        $response,
        $searchRequest,
        &$mealType,
        &$bedType,
        &$rating1,
        &$rating2,
        &$rating3,
        &$rating4,
        &$rating5) 
    {
        $result = [
            'hotelList' => [],
            'mealType' => $mealType,
            'bedType' => $bedType,
            'rating1' => $rating1,
            'rating2' => $rating2,
            'rating3' => $rating3,
            'rating4' => $rating4,
            'rating5' => $rating5,
            'minPrice' => 0,
            'maxPrice' => 0,
        ];

        // Extract hotel IDs and fetch in single query
        $hotelIds = array_column($response, 'HotelID');
        
        $hotelInfos = DidaHotel::whereIn('hotel_id', $hotelIds)
            ->select('hotel_id', 'star_rating', 'address', 'telephone', 'zip_code', 'name', 'images', 'thumbnail')
            ->get()
            ->keyBy('hotel_id')
            ->toArray(); // Convert to array for faster access

        $defaultImage = asset('frontEnd/images/no-hotel-image.png');
        $bedTypeCache = [];
        $mealTypeCache = [];
        $noOfRooms = $searchRequest['no_of_rooms'];
        $checkIn = $searchRequest['check_in'];
        $checkOut = $searchRequest['check_out'];

        $prices = []; // Collect all prices for min/max calculation

        // Process hotels in a single pass
        foreach ($response as $hotel) {
            $hotelId = $hotel['HotelID'];
            $hotelInfo = $hotelInfos[$hotelId] ?? null;

            // Skip if hotel info not found
            if (!$hotelInfo) {
                continue;
            }

            // Get rate plan safely
            $ratePlan = $hotel['RatePlanList'][0] ?? [];
            
            // Calculate total price
            $totalPrice = $noOfRooms * ($ratePlan['TotalPrice'] ?? 0);

            // Calculate markup
            $markup = hotelMarkUpPrice([
                'totalPrice' => $totalPrice,
                'currencyCode' => 'USD',
                'totalTax' => 0,
            ]);

            // Get or cache bed type
            $bedTypeId = $ratePlan['BedType'] ?? null;
            if (!isset($bedTypeCache[$bedTypeId])) {
                $bedTypeCache[$bedTypeId] = didaType('BedType', $bedTypeId);
            }
            
            $bedTypeName = $bedTypeCache[$bedTypeId];
            $bedTypeCode = Str::slug($bedTypeName);
            
            // Update bed type filter
            if (!isset($result['bedType'][$bedTypeCode])) {
                $result['bedType'][$bedTypeCode] = [
                    'code' => $bedTypeCode,
                    'name' => $bedTypeName,
                    'count' => 1
                ];
            } else {
                $result['bedType'][$bedTypeCode]['count']++;
            }

            // Get or cache meal type
            $mealTypeId = $ratePlan['PriceList'][0]['MealType'] ?? null;
            if (!isset($mealTypeCache[$mealTypeId])) {
                $mealTypeCache[$mealTypeId] = didaType('MealType', $mealTypeId);
            }
            
            $mealTypeName = $mealTypeCache[$mealTypeId];
            $mealTypeCode = Str::slug($mealTypeName);
            
            // Update meal type filter
            if (!isset($result['mealType'][$mealTypeCode])) {
                $result['mealType'][$mealTypeCode] = [
                    'code' => $mealTypeCode,
                    'name' => $mealTypeName,
                    'count' => 1
                ];
            } else {
                $result['mealType'][$mealTypeCode]['count']++;
            }

            // Optimize thumbnail handling
            $thumbnail = $defaultImage;
            if (!empty($hotelInfo['thumbnail'])) {
                $thumbnail = $hotelInfo['thumbnail'];
            } elseif (!empty($hotelInfo['images'])) {
                $thumbnail = strtok($hotelInfo['images'], ',') ?: $defaultImage;
            }

            // Build hotel item
            $hotelItem = [
                'hotelName' => $hotelInfo['name'] ?? '',
                'hotelRating' => (int)($hotelInfo['star_rating'] ?? 0),
                'address' => $hotelInfo['address'] ?? '',
                'image' => $thumbnail,
                'hotelCode' => $hotelId,
                'checkIn' => $checkIn,
                'checkOut' => $checkOut,
                'rooms' => $ratePlan['RoomName'] ?? null,
                'currenceCode' => '769',
                'markups' => $markup,
                'exclusive' => null,
                'preferred' => null,
                'phone_number' => $hotelInfo['telephone'] ?? '',
                'pin_code' => $hotelInfo['zip_code'] ?? '',
                'type' => 'dida',
                'mealType' => $mealTypeCode,
                'bedType' => $bedTypeCode,
            ];

            $result['hotelList'][] = $hotelItem;

            // Update rating counters using array
            $ratingKey = [1 => 'rating1', 2 => 'rating2', 3 => 'rating3', 4 => 'rating4', 5 => 'rating5'];
            $starRating = (int)($hotelInfo['star_rating'] ?? 0);
            if (isset($ratingKey[$starRating])) {
                $result[$ratingKey[$starRating]]++;
            }

            // Collect prices for later min/max calculation
            if (!empty($markup['totalPrice']['value'])) {
                $prices[] = $markup['totalPrice']['value'];
            }
        }

        // Calculate min/max efficiently using array functions
        if (!empty($prices)) {
            $result['minPrice'] = min($prices);
            $result['maxPrice'] = max($prices);
        }

        // Sort hotels by price using usort (more efficient for large arrays)
        usort($result['hotelList'], static function ($a, $b) {
            return ($a['markups']['totalPrice']['value'] ?? 0) <=> ($b['markups']['totalPrice']['value'] ?? 0);
        });

        return $result;
    }

    public function SaveSearch(Request $request){
        $cityCode = $request->input('hotelsCityCode');
        $cityId = $request->input('hotelsCityId');
        $checkIn = $request->input('hotelsCheckIn');
        $checkOut = $request->input('hotelsCheckOut');
        $noOfRooms = (int) $request->input('noOfRooms');
        $nationality = $request->input('nationality');
        $residency = $request->input('residency');
        $residencyInfo = WebbedsCountry::where('code', $residency)->first();

        // $cityDetails = DB::table('webbeds_cities')->where('id',$cityId)->first();
         $cityDetails = HotelCity::where('id',$cityId)->first();

        $noOfGuests = 0;
        //preprating json forrequest
        
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
        $CIn = Carbon::parse($checkIn);
        $COut =Carbon::parse($checkOut);

        //saving search request in HotelSearch table 
        $hotelSearch = new WebbedsHotelSearch();
        $hotelSearch->no_of_rooms                   = $request->input('noOfRooms');
        $hotelSearch->no_of_nights                  = $CIn->diffInDays($COut);
        $hotelSearch->nationality                   = $nationality;
        $hotelSearch->residency                     = $residency;
        $hotelSearch->city_code                     = $cityDetails->id;
        $hotelSearch->no_of_guests                  = $noOfGuests;
        $hotelSearch->city_name                     = $cityDetails->long_name;
        $hotelSearch->country                       = $cityDetails->country_name;
        $hotelSearch->country_code                  = $cityDetails->country_code;
        $hotelSearch->check_in                      = $checkIn;
        $hotelSearch->check_out                     = $checkOut;
        $hotelSearch->rooms_request                 = json_encode($hotelRequestArray['PaxRooms']);
        $hotelSearch->ip_address                    = $_SERVER['REMOTE_ADDR'];
        $hotelSearch->hotel_traveller_info          = $request->input('hotels-travellers-class');
        $hotelSearch->request_json                  = json_encode($request->input());
        $hotelSearch->search_url                    = $request->input('search_url');
        $hotelSearch->dida_destination_code         = $cityDetails->dida_code;
        $hotelSearch->user_id                       = auth()->user()->id ?? null;
        // $hotelSearch->restel_city_code              = $cityDetails->restel_city_code;
        // $hotelSearch->destination_country_code      = $residencyInfo->restel_code;
        // $hotelSearch->residency_alpha_code          = $residencyInfo->alpha_code ?? null;
        $hotelSearch->save();
        //dd($hotelSearch);

        return $hotelSearch->id;
    }


    public function GethotelDetails(Request $request)
    {
        //dd($request->query());
        $type = $request->query('type') ?? null;
        $titles = [
            'title' => "Hotel Details",
        ];
        if(empty($type))
        {
            return view('front_end.error',compact('titles'));
        }

        $hotelCode =  decrypt($request->query('hotelCode'));
        $type =  decrypt($request->query('type'));
        if ($request->has('searchId')) {
            $searchId = decrypt($request->query('searchId'));
        }else{
            //dd($request->input());
            // if search id not found in url then creading new entry in search table
       

            $cityCode = $request->input('hotelsCityCode');
            $cityId = $request->input('hotelsCityId');
            $checkIn = $request->input('hotelsCheckIn');
            $checkOut = $request->input('hotelsCheckOut');
            $noOfRooms = (int) $request->input('noOfRooms');
            $nationality = $request->input('nationality');
            $residency = $request->input('residency');

            //$cityDetails = DB::table('webbeds_cities')->where('code',$cityCode)->first();
            $residencyInfo = WebbedsCountry::where('code', $residency)->first();
            //$cityDetails = DB::table('webbeds_cities')->where('id',$cityId)->first();
            $cityDetails = HotelCity::where('id',$cityId)->first();

            $noOfGuests = 0;
            //preprating json forrequest
            
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
            $CIn = Carbon::parse($checkIn);
            $COut =Carbon::parse($checkOut);

            //saving search request in HotelSearch table 
            $hotelSearch = new WebbedsHotelSearch();
            $hotelSearch->no_of_rooms            = $request->input('noOfRooms');
            $hotelSearch->no_of_nights           = $CIn->diffInDays($COut);
            $hotelSearch->nationality            = $nationality;
            $hotelSearch->residency              = $residency;
            $hotelSearch->city_code              = $cityDetails->id;
            $hotelSearch->no_of_guests           = $noOfGuests;
            $hotelSearch->city_name              = $cityDetails->long_name;
            $hotelSearch->country                = $cityDetails->country_name;
            $hotelSearch->country_code           = $cityDetails->country_code;
            $hotelSearch->check_in               = $checkIn;
            $hotelSearch->check_out              = $checkOut;
            $hotelSearch->rooms_request          = json_encode($hotelRequestArray['PaxRooms']);
            $hotelSearch->ip_address             = $_SERVER['REMOTE_ADDR'];
            $hotelSearch->hotel_traveller_info   = $request->input('hotels-travellers-class');
            $hotelSearch->request_json           = json_encode($request->input());
            $hotelSearch->search_url             = $request->fullUrl();
            $hotelSearch->dida_destination_code  = $cityDetails->dida_code;
            $hotelSearch->user_id                = auth()->user()->id ?? null;
            $hotelSearch->save();
            $searchId = $hotelSearch->id;
        }
        //dd($searchId);
     
     
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'hotelDetails','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];

        $rooms = new SearchController();
        $result = [];
        $result['countries'] = WebbedsCountry::get();
        $result['searchRequest'] = WebbedsHotelSearch::find($searchId);
        $noOfRooms = $result['searchRequest']->no_of_rooms;

        $result['hotelDeatils'] = [] ;
        

        if($type == 'webbeds'){
            $hotelDetailsAndRooms = $rooms->getRooms(['hotel_code' => $hotelCode ,'search_id' => $searchId]);
            if(!empty($hotelDetailsAndRooms['hotelDetails']))
            {
                $result['hotelDeatils'] = $hotelDetailsAndRooms['hotelDetails'] ;
            }
            $result['hotelDeatils']['type'] = 'webbeds';
            $result['availablerooms'] = [] ;
            
            if(!empty($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room']))
            {
                $result['availablerooms'] = [];
                $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'] = nodeConvertion($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room']);

                foreach($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'] as $rk => $room){
                    $roomNumber = ($rk+1);
                    $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomNumber'] = $roomNumber;
                    $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'] = nodeConvertion($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType']);
                    foreach($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'] as $rtk => $roomType){
                        $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis'] = nodeConvertion($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis']);
                        if(isset($roomType['specials'])){
                            if(isset($roomType['specials']['@attributes']) && $roomType['specials']['@attributes']['count'] > 0){
                                $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'] = nodeConvertion($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special']);
                            }else{
                                unset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']);
                            }
                        }
                    }
                }
                //after node convertion
                //room formation to single pricing

                foreach ($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'] as $rk => $room) {
                    if($rk == 1){
                        break;
                    }
                    foreach ($room['roomType'] as $rtk => $roomType) {
                        // $specialPromotionForRoom = [];
                        // if(isset($roomType['specials']['special'])){
                        //     $roomType['specials']['special'] = nodeConvertion($roomType['specials']['special']);
                        //     foreach ($roomType['specials']['special'] as $spk => $special) {
                        //         $specialPromotionForRoom[] = $special['specialName'];
                        //     }
                        // }
                    
                        foreach ($roomType['rateBases']['rateBasis'] as $rbk => $rateBasis) {
                            $specialPromotion = [];
                            $roomTypeCode = $roomType['@attributes']['roomtypecode'];
                            $rateBasisId = $rateBasis['@attributes']['id'];
                            $roomName = $roomType['name'];
                            // $tariffNotes = $rateBasis['tariff_notes_html'] ?? '';
                            $rules = formatCancellationRules($rateBasis['cancellationRules'] ?? [] );
                            $validForOccupancy = [];
                            $bookingAllocation = null;
                            $allocationDetails = null;
                            $formatedBookingCode = null;
                            $roomPrice = null;
                            $cancellationPolicy = [];
                            $tariffNotes = [];
                            $total = 0;
                            for($i=0;$i<$noOfRooms;$i++){
                                $validForOccupancyData = null;
                                if($i == 0){
                                    $bookingAllocation = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['rateBases']['rateBasis'][$rbk]['allocationDetails'];
                                    $allocationDetails[] = $bookingAllocation;
                                    
                                    $roomPrice[] = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['rateBases']['rateBasis'][$rbk]['total'];
                                    
                                    if(isset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['rateBases']['rateBasis'][$rbk]['validForOccupancy'])){
                                        $validForOccupancyData = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['rateBases']['rateBasis'][$rbk]['validForOccupancy'];
                                        $validForOccupancy[] = $validForOccupancyData['extraBed'] ." extra bed for ".$validForOccupancyData['extraBedOccupant'];
                                    }
                                    $formatedBookingCode[] = ['allocationDetails' => $bookingAllocation , 'roomTypeCode' => $roomTypeCode , 'rateBasisId' => $rateBasisId, 'validForOccupancyDetails' => isset($validForOccupancyData) && !empty($validForOccupancyData) ? $validForOccupancyData : []];
                                    if(isset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['rateBases']['rateBasis'][$rbk]['specialsApplied'])){
                                        foreach($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['rateBases']['rateBasis'][$rbk]['specialsApplied'] as $SAkey=>$SAValue){
                                            if(isset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['specials']['special'][$SAValue]['specialName'])){
                                                $specialPromotion[] = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['specials']['special'][$SAValue]['specialName'];
                                            }
                                        }
                                    }
                                    
                                    $cancellationPolicy[] = formatCancellationRules($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['rateBases']['rateBasis'][$rbk]['cancellationRules'] ?? [] );
                                    $tariffNotes[] = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$rtk]['rateBases']['rateBasis'][$rbk]['tariff_notes_html'] ?? '';
                                }else{
                                
                                    $roomTypeKey = array_search($roomName,array_column($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'],'name'));
                                    if(is_numeric($roomTypeKey) && isset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rbk])){
                                        //search for room Basis
                                        $rateBasisIdKey = array_search($rateBasisId,array_column(array_column($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'] , '@attributes'), 'id'));

                                        if(is_numeric($rateBasisIdKey) && isset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey] )){
                                            

                                            $bookingAllocation = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey]['allocationDetails'];
                                            
                                            $allocationDetails[] = $bookingAllocation;
                                            
                                            $roomPrice[] = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey]['total'];
                                            if(isset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey]['validForOccupancy']))
                                            {
                                                $validForOccupancyData = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey]['validForOccupancy'];
                                                $validForOccupancy[] = $validForOccupancyData['extraBed'] ." extra bed for ".$validForOccupancyData['extraBedOccupant'];
                                                
                                            }
                                            $formatedBookingCode[] = ['allocationDetails' => $bookingAllocation , 'roomTypeCode' => $roomTypeCode , 'rateBasisId' => $rateBasisId,'validForOccupancyDetails' => isset($validForOccupancyData) && !empty($validForOccupancyData) ? $validForOccupancyData : []];

                                            if(isset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey]['specialsApplied'])){
                                                foreach($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey]['specialsApplied'] as $SAkey=>$SAValue){
                                                    if(isset($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['specials']['special'][$SAValue]['specialName'])){
                                                        $specialPromotion[] = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['specials']['special'][$SAValue]['specialName'];
                                                    }
                                                }
                                            }
                                            $cancellationPolicy[] = formatCancellationRules($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey]['cancellationRules'] ?? [] );
                                            $tariffNotes[] = $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$i]['roomType'][$roomTypeKey]['rateBases']['rateBasis'][$rateBasisIdKey]['tariff_notes_html'] ?? '';
                                        }
                                    } 
                                }
                            }
                            $result['availablerooms'][]  =  [
                                'name' => $roomType['name'],
                                'roomPromotion' => $rateBasis['@attributes']['description'],
                                'boardbasis' => $rateBasis['@attributes']['description'],
                                'roomTypeCode' => $roomTypeCode,
                                'rateBasisId' => $rateBasisId,
                                'total' => array_sum($roomPrice),
                                'roomPrice' => $roomPrice,
                                'allocationDetails' => $allocationDetails,
                                'formatedBookingCode' => $formatedBookingCode,
                                'tariffNotes' => $tariffNotes,
                                'CancelPolicies' => $cancellationPolicy,
                                'specialPromotion' => $specialPromotion,
                                'validForOccupancy' => $validForOccupancy,
                                'type' => 'webbeds'
                            ];
                        }
                    }
                }

                $result['availablerooms'] = array_values($result['availablerooms']);
                foreach($result['availablerooms'] as $r=>$room){
                    if(count($room['roomPrice']) == $noOfRooms){
                        foreach($room['roomPrice'] as $rp => $fbc){
                            $result['availablerooms'][$r]['roomPrice'][$rp] = hotelMarkUpPrice(array('totalPrice' =>  $fbc , 'currencyCode' => 'KWD' , 'totalTax' =>  0));
                        }
                        $result['availablerooms'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  $room['total'] , 'currencyCode' => 'KWD' , 'totalTax' =>  0));
                        $result['availablerooms'][$r]['allocationDetails'] = json_encode($result['availablerooms'][$r]['allocationDetails']);
                        $bookingCode  = [ 'allocationDetails' => $result['availablerooms'][$r]['allocationDetails'] , 'code' => $result['availablerooms'][$r]['roomTypeCode'] , 'selectedRateBasis' => $result['availablerooms'][$r]['rateBasisId'] ];
                        $result['availablerooms'][$r]['bookingCode'] = json_encode($bookingCode);
                    }else{
                        unset($result['availablerooms'][$r]);
                    }
                    
                }
                $result['availablerooms'] = array_values($result['availablerooms']);
            }
        }elseif($type == 'dida'){
            
            $requestInfo = new Request([
                'hotel_code' => $hotelCode,
                'search_request_id'  => $searchId,
            ]);
            $hotelDetailsAndRooms = $rooms->didaSearch($requestInfo);
            if($hotelDetailsAndRooms['status'] && !empty($hotelDetailsAndRooms['response']) && count($hotelDetailsAndRooms['response'][0]['RatePlanList']) > 0){

                $payload = ['language' => 'en-US','hotelIds' => [$hotelCode]];

                $hotelInfo = $this->DadiApiStaticData([
                    'end_point' => 'hotel/details',
                    'method'    => 'POST',
                    'params'    => $payload,
                ]);
                if($hotelInfo['status'] && !empty($hotelInfo['response']) && count($hotelInfo['response']['data']) > 0){
                    $hotelDetails = $hotelInfo['response']['data'][0];
                    if(isset($hotelDetails['description'])){
                        $description =  $hotelDetails['description'];
                        if(isset($hotelDetails['policy']['description'])){
                            $description .=  $hotelDetails['policy']['description'];
                        }
                     }
                     
                     $ammenities = null;
                     if(isset($hotelDetails['facilities'])){
                        $ammenities = implode("," , array_column($hotelDetails['facilities'] , 'description'));
                     }
                    $result['hotelDeatils']['hotel_name'] = $hotelDetails['name'];
                    $result['hotelDeatils']['hotel_rating'] = $hotelDetails['starRating'];
                    $result['hotelDeatils']['address'] = $hotelDetails['location']['address'];
                    $result['hotelDeatils']['images'] = implode(",", array_column($hotelDetails['images'] ?? [], 'url')) ?: null;
                    $result['hotelDeatils']['check_in'] = $result['searchRequest']->check_in;
                    $result['hotelDeatils']['check_out'] = $result['searchRequest']->check_out;
                    $result['hotelDeatils']['description'] = $description;
                    $result['hotelDeatils']['hotel_code'] = $hotelDetails['id'];
                    $result['hotelDeatils']['hotel_facilities'] = $ammenities;
                    $result['hotelDeatils']['type'] = 'dida';
                }else{
                    $data['errorresponse'] = 'Session Expired';
                    $titles = [
                        'title' => "Error Page",
                    ];
                    return view('front_end.error',compact('titles','data'));

                }
          

                
                $result['availablerooms'] = [] ;
                $roomDetails = $hotelDetailsAndRooms['response'][0]['RatePlanList'];

                foreach($roomDetails as $r => $roomInfo){
                    $markup = hotelMarkUpPrice(array('totalPrice' =>  $result['searchRequest']->no_of_rooms * $roomInfo['TotalPrice'] , 'currencyCode' => $roomInfo['Currency'] , 'totalTax' =>  0));
                    $roomPrice = [];
                    $cancellationRules = [];
                    $cancellationpolicies = [];
                    $cancellationRules = formatCancellationRules($roomInfo['RatePlanCancellationPolicyList'] ?? [] , 'dida');
                    for($i = 0 ; $i < $result['searchRequest']->no_of_rooms ; $i++){
                        $roomPrice[$i] =hotelMarkUpPrice(array('totalPrice' =>  $roomInfo['TotalPrice'] , 'currencyCode' => $roomInfo['Currency'] , 'totalTax' =>  0));
                        $cancellationpolicies[] = $cancellationRules;

                    }
                    $formatedBookingCode = ['RatePlanID' => $roomInfo['RatePlanID'] , 'metadata' => $roomInfo['Metadata']];
                    //dd($cancellationRules);
                    
                    $result['availablerooms'][]  =  [
                        'name' => $roomInfo['RoomName'],
                        'roomPromotion' => null,
                        'boardbasis' => didaType('MealType', $roomInfo['BreakfastType']),
                        'roomTypeCode' => $roomInfo['RoomTypeID'],
                        'rateBasisId' => null,
                        'total' => $markup,
                        'roomPrice' => $roomPrice,
                        'markups' => $markup,
                        'allocationDetails' => null,
                        'formatedBookingCode' => $formatedBookingCode,
                        'tariffNotes' => null,
                        'CancelPolicies' => $cancellationpolicies,
                        'specialPromotion' => null,
                        'validForOccupancy' => null,
                        'type' => 'dida',
                        'bookingCode' => encrypt($formatedBookingCode) 
                    ];

                }
            }
           // dd($roomDetails,$result['availablerooms']);
        }
        //dd($result['availablerooms']);
       
        //searchRequest 
        $result['hotelCode'] = $hotelCode;
       // dd($result);

        return view('front_end.hotel.webbeds.details',compact('titles','result' ,'type'));
        
    }



    public function PreBooking($hotelCode,$bookingCode,$searchId,$type){

        //PreBooking
        $hotelCode = decrypt($hotelCode);
        $bookingCode = decrypt($bookingCode);
        $searchId = decrypt($searchId);
        $type = decrypt($type);


        $titles = [
            'title' => "Save Passanger Details",
        ];
        $result = [];
        $prebooking = new BookingController();
        $result['searchRequest'] = WebbedsHotelSearch::find($searchId);
        $result['searchRequest']->rooms_request = json_decode($result['searchRequest']->rooms_request,true);
        if($type == 'webbeds'){
            $prebookingDeatails = $prebooking->PreBooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=>$bookingCode]); 
            //hotelDetails
            $hotelDetails = WebbedsHotel::where('hotel_code', $hotelCode)->firstOrFail()->toArray();
            $result['hotelDetails'] = $hotelDetails;

            $result['hotelDetails']['image'] = explode(",", $hotelDetails['images']);
            if($prebookingDeatails['success'] == false)
            {
                //error page
                //session expire
                $data['errorresponse'] = 'Session Expired';
                $titles = [
                    'title' => "Error Page",
                ];

                return view('front_end.error',compact('titles','data'));

            }
            if(!empty($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room']))
            {
            // $result['availablerooms'] = [];
                $prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'] = nodeConvertion($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room']);

                foreach($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'] as $rk => $room){
                    $prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'] = nodeConvertion($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType']);
                    foreach($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'] as $rtk => $roomType){
                        $prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis'] = nodeConvertion($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis']);
                        if(isset($roomType['specials'])){
                            if(isset($roomType['specials']['@attributes']) && $roomType['specials']['@attributes']['count'] > 0){
                                $prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'] = nodeConvertion($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special']);
                            }else{
                                unset($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']);
                            }
                        }
                    }
                }
                //after node convertion
                //room formation to single pricing
                $bookingAllocation = null;
                $allocationDetails = [];
                $formatedBookingCode = null;
                $roomPrice = null;
                $roomPriceTax = null;
                $total = 0;
                $extraFee = null;
                $currency = ''; 
                $specialPromotion = [];
                $cancelPolicies = [];
                $tariffNotes = [];


                foreach ($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'] as $rk => $room) {
                    foreach ($room['roomType'] as $rtk => $roomType) {
                        foreach ($roomType['rateBases']['rateBasis'] as $rbk => $rateBasis) {
                            $roomTypeCode = $roomType['@attributes']['roomtypecode'];
                            
                            // Prepare allocation detail

                            if($rateBasis['status'] == 'checked'){
                                
                                $allocationDetail = $rateBasis['allocationDetails'];
                                $validForOccupancyData = null;
                                $rateBasisId = $rateBasis['@attributes']['id'];
                                $name = $roomType['name'];
                                $roomPromotion = $rateBasis['@attributes']['description'];
                                // $tariffNotes = $rateBasis['tariff_notes_html'] ?? '';
                                $key = $roomTypeCode . '_' . $rateBasisId;
                                $rules = formatCancellationRules($rateBasis['cancellationRules'] ?? [] );
                                $validForOccupancy = [] ;

                                $allocationDetails[] = $allocationDetail;
                            
                                $roomPrice[] = $rateBasis['total'];
                                $roomPriceTax[] = isset($rateBasis['totalTaxes']) ? $rateBasis['totalTaxes'] : 0;

                                if(isset($rateBasis['validForOccupancy']))
                                {
                                    $validForOccupancyData = $rateBasis['validForOccupancy'];
                                    $validForOccupancy[] = $validForOccupancyData['extraBed'] ." extra bed for ".$validForOccupancyData['extraBedOccupant'];
                                }
                                $formatedBookingCode[] = ['allocationDetails' => $allocationDetail , 'roomTypeCode' => $roomTypeCode , 'rateBasisId' => $rateBasisId, 'validForOccupancyDetails' => isset($validForOccupancyData) && !empty($validForOccupancyData) ? $validForOccupancyData : []];

                                if(isset($rateBasis['specialsApplied']))
                                {
                                    foreach($rateBasis['specialsApplied'] as $SAkey=>$SAValue)
                                    {
                                        if(isset($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'][$SAValue]['specialName'])){
                                            $specialPromotion[] = $prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'][$SAValue]['specialName'];
                                        }
                                    }
                                }
                                if(isset($rateBasis['property_fees'])){
                                    foreach($rateBasis['property_fees'] as  $tax){
                                        if($tax['includedinprice'] == 'No'){
                                            $currency = $tax['currencyshort'];
                                            $extraFee = (float)$extraFee + (float)$tax['value'];
                                        }
                                    }
                                } 
                                $cancellationPolicy[] = formatCancellationRules($rateBasis['cancellationRules'] ?? [] );
                                $tariffNotes[] = $rateBasis['tariff_notes_html'] ?? '' ;
                            }
                        }
                    
                    }
                }
            
                if(!empty($extraFee)){
                    $extraFee = $currency . ' '. $extraFee;
                }
                
                
                if(count($allocationDetails) != $result['searchRequest']->no_of_rooms){

                        // need to through error page
                        $data['errorresponse'] = 'Session Expired';
                        $titles = [
                            'title' => "Error Page",
                        ];
                        return view('front_end.error',compact('titles','data'));                
                }
                
                $result['roomDetails'][] = [
                    'Name' => $name,
                    'roomPromotion' => $roomPromotion,
                    'roomTypeCode' => $roomTypeCode,
                    'rateBasisId' => $rateBasisId,
                    'total' => array_sum($roomPrice),
                    'totalTax' => array_sum($roomPriceTax),
                    'roomPrice' => $roomPrice,
                    'allocationDetails' => $allocationDetails,
                    'formatedBookingCode' => $formatedBookingCode,
                    'tariffNotes' => $tariffNotes,
                    'CancelPolicies' => $cancellationPolicy,
                    'Inclusion' => [],
                    'supplment_charges' => [],
                    'specialPromotion' => $specialPromotion,
                    'validForOccupancy' => $validForOccupancy,
                    'extraFee' => $extraFee,
                    'type' => 'webbeds'
                ];
            
                $result['roomDetails'] = array_values($result['roomDetails']);
                foreach($result['roomDetails'] as $r=>$room){
                    foreach($room['roomPrice'] as $rp => $fbc){
                        $result['roomDetails'][$r]['roomPrice'][$rp] = hotelMarkUpPrice(array('totalPrice' =>  $fbc , 'currencyCode' => 'KWD' , 'totalTax' =>  0));
                    }
                    $result['roomDetails'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  $room['total'] , 'currencyCode' => 'KWD' , 'totalTax' =>   $room['totalTax']));
                    $result['roomDetails'][$r]['allocationDetails'] = json_encode($result['roomDetails'][$r]['allocationDetails']);
                    $bookingCode  = [ 'allocationDetails' => $result['roomDetails'][$r]['allocationDetails'] , 'code' => $result['roomDetails'][$r]['roomTypeCode'] , 'selectedRateBasis' => $result['roomDetails'][$r]['rateBasisId'],'type' => 'webbeds'];
                    $result['roomDetails'][$r]['bookingCode'] = json_encode($bookingCode);
                    $result['roomDetails'][$r]['formatedBookingCode'] = json_encode($room['formatedBookingCode']);
                }
            }
            $result['roomDetails'] = $result['roomDetails'][0];
           
            $result['bookingCode'] = $result['roomDetails']['formatedBookingCode']??'';
            //$result['webbedsBlockingId'] = $prebookingDeatails['xml_request_id'];
            $result['BlockingId'] = $prebookingDeatails['xml_request_id'];
            
        }else{
            $prebookingDetails = $prebooking->DidaPrebooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=>$bookingCode]); 
            if(isset($prebookingDetails['response']['Error']))
            {
                //error page
                //session expire
                $data['errorresponse'] = 'Session Expired';
                $titles = [
                    'title' => "Error Page",
                ];
                return view('front_end.error',compact('titles','data'));
            }else{
                
                $jsonRequestId = $prebookingDetails['hotelRequest']->id;
                //hotelDetails
                $hotelDetails= DidaHotel::where('hotel_id', $hotelCode)->firstOrFail()->toArray();

                $thumbnail = asset('frontEnd/images/no-hotel-image.png');
                // dd($result['hotelDetails']);

                if(!empty($hotelDetails['thumbnail']))
                {
                    $thumbnail = $hotelDetails['thumbnail'];
                }elseif(!empty($hotelDetails['images'])){
                    $thumbnail = explode("," , $hotelDetails['images'])[0] ?? asset('frontEnd/images/no-hotel-image.png');
                }

                $result['hotelDetails']['hotel_name'] = $hotelDetails['name'];
                $result['hotelDetails']['hotel_rating'] = $hotelDetails['star_rating'];
                $result['hotelDetails']['address'] = $hotelDetails['address'];
                $result['hotelDetails']['images'] = asset('frontEnd/images/no-hotel-image.png');
                $result['hotelDetails']['check_in'] = $result['searchRequest']->check_in;
                $result['hotelDetails']['check_out'] = $result['searchRequest']->check_out;
                $result['hotelDetails']['description'] = '';
                $result['hotelDetails']['hotel_code'] = $hotelDetails['hotel_id'];
                $result['hotelDetails']['hotel_facilities'] = '';
                $result['hotelDetails']['type'] = 'dida';
                $result['hotelDetails']['thumbnail'] = $thumbnail;
                
                
                // dd($prebookingDetails);
                $pricingInfo = $prebookingDetails['response']['Success']['PriceDetails']['HotelList'];
                $totalprice = $pricingInfo[0]['TotalPrice'] ?? 0;
                $roomPrice = [];
                $RatePlanID = [];
                foreach($prebookingDetails['response']['Success']['PriceDetails']['HotelList'][0]['RatePlanList'] as $ratePlanList){
                    $roomPrice[] =  $ratePlanList['TotalPrice'];
                    $RatePlanID[] =  $ratePlanList['RatePlanID'];
                }
                
                $cancellationRules = formatCancellationRules($pricingInfo[0]['CancellationPolicyList'] ?? [] , 'dida');
                
                // for($i=0; $i<$result['searchRequest']->no_of_rooms; $i++){
                //     $cancellationpolicies[] = $cancellationRules;
                // }
                $cancellationpolicies[] = $cancellationRules;
                //$roomPrice = array_column($pricingInfo[0]['RatePlanList'][0]['PriceList'], 'Price');
                $formatedBookingCode = ['RatePlanID' =>  $RatePlanID , 'metadata' => null , 'type' => 'dida' ,'dida_ref_id' => $prebookingDetails['response']['Success']['PriceDetails']['ReferenceNo']];
                $excludedFees = formatExcludedFees($pricingInfo[0]['ExcludedFeeList'] ?? []);

                $result['roomDetails'][] = [
                    'Name' => $pricingInfo[0]['RatePlanList'][0]['RatePlanName'] ?? null,
                    'roomPromotion' =>  didaType('MealType', $pricingInfo[0]['RatePlanList'][0]['BreakfastType']),
                    'roomTypeCode' => $pricingInfo[0]['RatePlanList'][0]['RoomTypeID'] ?? null,
                    'rateBasisId' => $RatePlanID ?? null,
                    'total' => array_sum($roomPrice) ,
                    'totalTax' => 0,
                    'roomPrice' => $roomPrice,
                    'allocationDetails' => [],
                    'formatedBookingCode' => $formatedBookingCode,
                    'tariffNotes' => [],
                    'CancelPolicies' => $cancellationpolicies,
                    'Inclusion' => [],
                    'supplment_charges' => [],
                    'specialPromotion' => null,
                    'validForOccupancy' => null,
                    'extraFee' => $excludedFees['total_excluded_amount']??null,
                    'markups' =>  hotelMarkUpPrice(array('totalPrice' =>  $totalprice , 'currencyCode' => 'USD' , 'totalTax' =>   0)),
                    'type' => 'dida',
                    'excludedFees' => $excludedFees,
                ];
                $result['roomDetails'] = array_values($result['roomDetails']);
                foreach($result['roomDetails'] as $r=>$room){
                    foreach($room['roomPrice'] as $rp => $fbc){
                        $result['roomDetails'][$r]['roomPrice'][$rp] = hotelMarkUpPrice(array('totalPrice' =>  $fbc , 'currencyCode' => 'USD' , 'totalTax' =>  0));
                    }
                    $result['roomDetails'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  $room['total'] , 'currencyCode' => 'USD' , 'totalTax' =>   0));
                    $result['roomDetails'][$r]['allocationDetails'] = json_encode([]);
                    $bookingCode  = [ 'allocationDetails' => [] , 'code' => $pricingInfo[0]['RatePlanList'][0]['RoomTypeID'] , 'selectedRateBasis' => $RatePlanID,'type' => 'dida'];
                    $result['roomDetails'][$r]['bookingCode'] = json_encode($bookingCode);
                    $result['roomDetails'][$r]['formatedBookingCode'] = json_encode($room['formatedBookingCode']);
                }


                $result['roomDetails'] = $result['roomDetails'][0];
           
                $result['bookingCode'] = $formatedBookingCode ??'';
                $result['BlockingId'] = $jsonRequestId ?? null;
            }
            
        }
        $result['RateConditions'] = [];
        $name = (app()->getLocale() == 'ar') ? 'IFNULL(name_ar,name) as name' : 'name' ;
        $result['countries'] = Country::select('id',DB::raw($name),'phone_code')->whereNotNull("phone_code")->get();
        $result['hotelCode'] = $hotelCode;
        $result['searchId'] = $searchId;
        $result['type'] = $type;
        $currentDate = Carbon::now()->toDateString();
        $couponCodes = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->whereIn('coupon_valid_on' ,[1,3])->get();
        $result['couponCodes'] = $couponCodes;
        // dd($result);

        return view('front_end.hotel.webbeds.pre_booking',compact('titles','result'));
    }

    public function savePassanger(Request $request)
    {
        // dd($request->input());
        $titles = [
            'title' => "Traveller Preview ",
        ];

        $hotelCode = decrypt($request->input('hotelCode'));
        $bookingCode = decrypt($request->input('bookingCode'));
        $searchId = decrypt($request->input('searchId'));
        $BlockingId = decrypt($request->input('BlockingId'));
        
        // $prebooking = new BookingController();
        //$prebookingDetails = $prebooking->TboPreBooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=> $bookingCode]);
        //print_r($webbedsBlockingId);
        // if(){

        // }
        $hotelXmlRequest = HotelXmlRequest::findOrFail($BlockingId);
        $supplier = strtolower($hotelXmlRequest->supplier);
        if($supplier == 'webbeds'){
            $prebookingDetails = XmlToArrayWithHTML($hotelXmlRequest->response_xml);
            $hotelDetails = WebbedsHotel::where('hotel_code' , $hotelCode)->first()->toArray();
            $hotelName = $hotelDetails['hotel_name'];
            $hotelAddress = $hotelDetails['hotel_address'];
            $currency = 'KWD';
            if($prebookingDetails['successful'] == false)
            {
                //error page
                //session expire
                $data['errorresponse'] = 'Session Expired';
                $titles = [
                    'title' => "Error Page",
                ];
                return view('front_end.error',compact('titles','data'));
            }
        }else{
            $prebookingDetails = json_decode($hotelXmlRequest->json_response, true);
            $hotelDetails = DidaHotel::where('hotel_id' , $hotelCode)->first()->toArray();
            $hotelName = $hotelDetails['name'];
            $hotelAddress = $hotelDetails['address'];
            $currency = 'USD';
            $bookingCode = json_encode($bookingCode);
            if(isset($prebookingDetails['Error']))
            {
                //error page
                //session expire
                $data['errorresponse'] = 'Session Expired';
                $titles = [
                    'title' => "Error Page",
                ];
                return view('front_end.error',compact('titles','data'));
            }
        }

        
        $searchDetails = WebbedsHotelSearch::find($searchId);

        //hotelBookingDeatils
        $hotelRoomBooking = new HotelBooking();
        $hotelRoomBooking->search_id = $searchId;
        $hotelRoomBooking->hotel_code = $hotelCode;
        $hotelRoomBooking->hotel_name = $hotelName ?? '';
        $hotelRoomBooking->hotel_address = $hotelAddress ?? '';
        $hotelRoomBooking->check_in = $searchDetails->check_in;
        $hotelRoomBooking->check_out = $searchDetails->check_out;
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
        if($supplier == 'webbeds'){
            if(!empty($prebookingDetails['hotel']['rooms']['room']))
            {
                $prebookingDetails['hotel']['rooms']['room'] = nodeConvertion($prebookingDetails['hotel']['rooms']['room']);
                foreach($prebookingDetails['hotel']['rooms']['room'] as $rk => $room){
                    $prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'] = nodeConvertion($prebookingDetails['hotel']['rooms']['room'][$rk]['roomType']);
                    foreach($prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'] as $rtk => $roomType){
                        $prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis'] = nodeConvertion($prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis']);
                        if(isset($roomType['specials'])){
                            if(isset($roomType['specials']['@attributes']) && $roomType['specials']['@attributes']['count'] > 0){
                                $prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'] = nodeConvertion($prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special']);
                            }else{
                                unset($prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']);
                            }
                        }
                    }
                }
                //after node convertion
                //room formation to single pricing

                $bookingAllocation = null;
                $allocationDetails = null;
                $formatedBookingCode = null;
                $roomPrice = null;
                $roomPriceTax = null;
                $total = 0;
                $extraFee = null;
                $currency = ''; 
                $specialPromotion = [];
                $cancellationPolicy = [];
                $tariffNotes = [];
                foreach ($prebookingDetails['hotel']['rooms']['room'] as $rk => $room) {
                    foreach ($room['roomType'] as $rtk => $roomType) {
                    
                        // if(isset($roomType['specials']['special'])){
                        //     $roomType['specials']['special'] = nodeConvertion($roomType['specials']['special']);
                        //     foreach ($roomType['specials']['special'] as $spk => $special) {
                        //         $specialPromotion[] = $special['specialName'];
                        //     }
                        // }
                        foreach ($roomType['rateBases']['rateBasis'] as $rbk => $rateBasis) {
                            $roomTypeCode = $roomType['@attributes']['roomtypecode'];
                            $rateBasisId = $rateBasis['@attributes']['id'];
                        
                            // Prepare allocation detail

                            if($rateBasis['status'] == 'checked'){
                                $allocationDetail = $rateBasis['allocationDetails'];
                                $validForOccupancyData = null;
                                $rateBasisId = $rateBasis['@attributes']['id'];
                                $name = $roomType['name'];
                                $roomPromotion = $rateBasis['@attributes']['description'];
                                
                                $key = $roomTypeCode . '_' . $rateBasisId;
                                
                                $validForOccupancy = [] ;

                                $allocationDetails[] = $allocationDetail;
                            
                                $roomPrice[] = $rateBasis['total'];
                                $roomPriceTax[] = isset($rateBasis['totalTaxes']) ? $rateBasis['totalTaxes'] : 0;



                                if(isset($rateBasis['validForOccupancy']))
                                {
                                    $validForOccupancyData = $rateBasis['validForOccupancy'];
                                    $validForOccupancy[] = $validForOccupancyData['extraBed'] ." extra bed for ".$validForOccupancyData['extraBedOccupant'];
                                }
                                $formatedBookingCode[] = ['allocationDetails' => $allocationDetail , 'roomTypeCode' => $roomTypeCode , 'rateBasisId' => $rateBasisId, 'validForOccupancyDetails' => isset($validForOccupancyData) && !empty($validForOccupancyData) ? $validForOccupancyData : []];
                                if(isset($rateBasis['specialsApplied']))
                                {
                                    foreach($rateBasis['specialsApplied'] as $SAkey=>$SAValue)
                                    {
                                        if(isset($prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'][$SAValue]['specialName'])){
                                            $specialPromotion[] = $prebookingDetails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'][$SAValue]['specialName'];
                                        }
                                    }
                                }
                                if(isset($rateBasis['property_fees'])){
                                    foreach($rateBasis['property_fees'] as  $tax){
                                        if($tax['includedinprice'] == 'No'){
                                            $currency = $tax['currencyshort'];
                                            $extraFee = (float)$extraFee + (float)$tax['value'];
                                        }
                                    }
                                }
                                $cancellationPolicy[] = formatCancellationRules($rateBasis['cancellationRules'] ?? [] );
                                $tariffNotes[] = $rateBasis['tariff_notes_html'] ?? '';
                            
                            }
                        }
                    }
                    
                }
                if(!empty($extraFee)){
                    $extraFee = $currency . ' '. $extraFee;     
                }
                if(count($allocationDetails) != $searchDetails->no_of_rooms){

                        // need to through error page
                        $data['errorresponse'] = 'Session Expired';
                        $titles = [
                            'title' => "Error Page",
                        ];
                        return view('front_end.error',compact('titles','data'));                
                }
                //dd($allocationDetails,$formatedBookingCode,$roomPrice);
                $result['roomDetails'][] = [
                    'Name' => $name,
                    'roomPromotion' => $roomPromotion,
                    'roomTypeCode' => $roomTypeCode,
                    'rateBasisId' => $rateBasisId,
                    'total' => array_sum($roomPrice),
                    'totalTax' => array_sum($roomPriceTax),
                    'roomPrice' => $roomPrice,
                    'allocationDetails' => $allocationDetails,
                    'formatedBookingCode' => $formatedBookingCode,
                    'tariffNotes' => $tariffNotes,
                    'CancelPolicies' => $cancellationPolicy,
                    'Inclusion' => [],
                    'supplment_charges' => [],
                    'specialPromotion' => $specialPromotion,
                    'validForOccupancy' => $validForOccupancy,
                    'extraFee' => $extraFee
                ];
                $result['roomDetails'] = array_values($result['roomDetails']);
                foreach($result['roomDetails'] as $r=>$room){
                    foreach($room['roomPrice'] as $rp => $fbc){
                        $result['roomDetails'][$r]['roomPrice'][$rp] = hotelMarkUpPrice(array('totalPrice' =>  $fbc , 'currencyCode' => 'KWD' , 'totalTax' =>  0));
                    }
                    $result['roomDetails'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  $room['total'] , 'currencyCode' => 'KWD' , 'totalTax' =>   $room['totalTax']));
                    $result['roomDetails'][$r]['allocationDetails'] = json_encode($result['roomDetails'][$r]['allocationDetails']);
                    $bookingCode  = [ 'allocationDetails' => $result['roomDetails'][$r]['allocationDetails'] , 'code' => $result['roomDetails'][$r]['roomTypeCode'] , 'selectedRateBasis' => $result['roomDetails'][$r]['rateBasisId']];
                    $result['roomDetails'][$r]['bookingCode'] = json_encode($bookingCode);
                    $result['roomDetails'][$r]['formatedBookingCode'] = json_encode($room['formatedBookingCode']);
                }
                //dd($result['roomDetails']);
            }
        }else{
            $thumbnail = asset('frontEnd/images/no-hotel-image.png');
            if(!empty($hotelDetails['thumbnail']))
            {
                $thumbnail = $hotelDetails['thumbnail'];
            }elseif(!empty($hotelDetails['images'])){
                $thumbnail = explode("," , $hotelDetails['images'])[0] ?? asset('frontEnd/images/no-hotel-image.png');
            }
            //$hotelDetails= DidaHotel::where('hotel_id', $hotelCode)->firstOrFail()->toArray();
            $hotelDetails['hotel_name'] = $hotelDetails['name'];
            $hotelDetails['hotel_rating'] = $hotelDetails['star_rating'];
            $hotelDetails['address'] = $hotelDetails['address'];
            $hotelDetails['images'] = asset('frontEnd/images/no-hotel-image.png');
            $hotelDetails['check_in'] = $searchDetails->check_in;
            $hotelDetails['check_out'] = $searchDetails->check_out;
            $hotelDetails['description'] = '';
            $hotelDetails['hotel_code'] = $hotelDetails['hotel_id'];
            $hotelDetails['hotel_facilities'] = '';
            $hotelDetails['type'] = 'dida';
            $hotelDetails['thumbnail'] = $thumbnail;
            
            $result['searchRequest'] = WebbedsHotelSearch::find($searchId);
            //dd($prebookingDetails);
            $pricingInfo = $prebookingDetails['Success']['PriceDetails']['HotelList'];
            //dd($pricingInfo);
            $totalprice = $pricingInfo[0]['TotalPrice'] ?? 0;
            $roomPrice = [];
            $RatePlanID = [];
            foreach($prebookingDetails['Success']['PriceDetails']['HotelList'][0]['RatePlanList'] as $ratePlanList){
                $roomPrice[] =  $ratePlanList['TotalPrice'];
                $RatePlanID[] =  $ratePlanList['RatePlanID'];
            }

            //$roomPrice = array_column($pricingInfo[0]['RatePlanList'][0]['PriceList'], 'Price');
            $formatedBookingCode = ['RatePlanID' =>  $RatePlanID , 'metadata' => null , 'type' => 'dida'];
            $cancellationRules = formatCancellationRules($pricingInfo[0]['CancellationPolicyList'] ?? [] , 'dida');
                // for($i=0; $i<$result['searchRequest']->no_of_rooms; $i++){
                //     $cancellationpolicies[] = $cancellationRules;
                // }
            $cancellationpolicies[] = $cancellationRules;
            $excludedFees = formatExcludedFees($pricingInfo[0]['ExcludedFeeList'] ?? []);

            $result['roomDetails'][] = [
                'Name' => $pricingInfo[0]['RatePlanList'][0]['RatePlanName'] ?? null,
                'roomPromotion' =>  didaType('MealType', $pricingInfo[0]['RatePlanList'][0]['BreakfastType']),
                'roomTypeCode' => $pricingInfo[0]['RatePlanList'][0]['RoomTypeID'] ?? null,
                'rateBasisId' => $pricingInfo[0]['RatePlanList'][0]['RatePlanID'] ?? null,
                'total' => array_sum($roomPrice) ,
                'totalTax' => 0,
                'roomPrice' => $roomPrice,
                'allocationDetails' => [],
                'formatedBookingCode' => $formatedBookingCode,
                'tariffNotes' => [],
                'CancelPolicies' => $cancellationpolicies,
                'Inclusion' => [],
                'supplment_charges' => [],
                'specialPromotion' => null,
                'validForOccupancy' => null,
                'extraFee' => $excludedFees['total_excluded_amount']??null,
                'markups' =>  hotelMarkUpPrice(array('totalPrice' =>  $totalprice , 'currencyCode' => 'USD' , 'totalTax' =>   0)),
                'excludedFees' => $excludedFees,
                
            ];
            $result['roomDetails'] = array_values($result['roomDetails']);
            foreach($result['roomDetails'] as $r=>$room){
                foreach($room['roomPrice'] as $rp => $fbc){
                    $result['roomDetails'][$r]['roomPrice'][$rp] = hotelMarkUpPrice(array('totalPrice' =>  $fbc , 'currencyCode' => 'USD' , 'totalTax' =>  0));
                }
                $result['roomDetails'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  $room['total'] , 'currencyCode' => 'USD' , 'totalTax' =>   0));
                $result['roomDetails'][$r]['allocationDetails'] = json_encode([]);
                $bookingCode  = [ 'allocationDetails' => [] , 'code' => $pricingInfo[0]['RatePlanList'][0]['RoomTypeID'] , 'selectedRateBasis' => $pricingInfo[0]['RatePlanList'][0]['RatePlanID'],'type' => 'dida'];
                $result['roomDetails'][$r]['bookingCode'] = json_encode($bookingCode);
                $result['roomDetails'][$r]['formatedBookingCode'] = json_encode($room['formatedBookingCode']);
            }

        }
        
        $result['roomDetails'] = $result['roomDetails'][0];
        // dd($result);



        
        $hotelRoomBooking->currency_code = $result['roomDetails']['markups']['FatoorahPaymentAmount']['currency_code'];
        $hotelRoomBooking->total_amount = $result['roomDetails']['markups']['FatoorahPaymentAmount']['value'];

        $hotelRoomBooking->actual_price = $result['roomDetails']['markups']['actualPrice']['value'];
        $hotelRoomBooking->actual_currency_code = $result['roomDetails']['markups']['actualPrice']['currency_code'];

        //$hotelRoomBooking->price_from_supplier =  $result['roomDetails']['TotalFare'];
        $hotelRoomBooking->currency_code_from_supplier = $currency;

        // if(isset($result['roomDetails']['RecommendedSellingRate'])){
        //     $hotelRoomBooking->is_rsp_price = 1;
        // }

        
        $hotelRoomBooking->basefare = $result['roomDetails']['markups']['kwd_basefare']['value'];
        $hotelRoomBooking->service_charges =  $result['roomDetails']['markups']['kwd_service_chargers']['value'] ;
        $hotelRoomBooking->tax = $result['roomDetails']['markups']['kwd_tax']['value'];
        $hotelRoomBooking->sub_total = $result['roomDetails']['markups']['FatoorahPaymentAmount']['value'];

        if(!empty($result['roomDetails']['markups']['coupon']['value']) && $result['roomDetails']['markups']['coupon']['value']!= '0.000'){
            $hotelRoomBooking->coupon_id = $result['roomDetails']['markups']['coupon']['id'];
            $hotelRoomBooking->coupon_amount = $result['roomDetails']['markups']['standed_coupon']['value'];
        }
        //dd("dd");

        $hotelRoomBooking->actual_amount = $result['roomDetails']['markups']['actualTotalAmount']['value'];

        $hotelRoomBooking->type_of_payment = $request->input('type_of_payment');
        $hotelRoomBooking->supplier = $supplier;
        $hotelRoomBooking->booking_status = 'booking_initiated';
        $hotelRoomBooking->no_of_rooms = $searchDetails->no_of_rooms;
        $hotelRoomBooking->no_of_guests = $searchDetails->no_of_guests;
        $hotelRoomBooking->no_of_nights = $searchDetails->no_of_nights;
        //dd($hotelRoomBooking);

        
       

        $hotelRoomBooking->save();
        // dd($hotelRoomBooking);

        $APP_ENV = env('APP_ENV');
        if($APP_ENV == 'local')
        {
            $hotelRoomBooking->booking_ref_id = 'MTHL'.str_pad($hotelRoomBooking->id, 7, '0', STR_PAD_LEFT);
        }
        elseif($APP_ENV == 'DEV'){
            $hotelRoomBooking->booking_ref_id = 'MTHD'.str_pad($hotelRoomBooking->id, 7, '0', STR_PAD_LEFT);
        }
        elseif($APP_ENV == 'PROD'){
            $hotelRoomBooking->booking_ref_id = 'MTHP'.str_pad($hotelRoomBooking->id, 7, '0', STR_PAD_LEFT);
        }
     
        $hotelRoomBooking->save();
        $result['searchRequest'] = WebbedsHotelSearch::find($searchId);
        $jsonRoomRequest = json_decode($result['searchRequest']['rooms_request'] , true);
        // [{"Adults":"2","Children":"1","ChildrenAges":["11"]}]

        //rooms loop
        foreach($request->input('room') as $r=>$room){
            if(isset($room['adult']))
            {
                foreach ($room['adult'] as $key => $value) {
                    $salutationCodeAndGender =webbedsSalutationsIds($value['title']);

                    $gender = $salutationCodeAndGender['gender'];
                    $webbeds_code = $salutationCodeAndGender['code'];
                    $HotelBookingTravelers = new HotelBookingTravelsInfo();
                    $HotelBookingTravelers->title = $value['title'];
                    $HotelBookingTravelers->first_name = clean_string($value['firstName'] , false);
                    $HotelBookingTravelers->last_name = clean_string($value['lastName'] , false); 
                    $HotelBookingTravelers->room_no = $r+1;
                    $HotelBookingTravelers->gender = $gender;
                    $HotelBookingTravelers->traveler_type = 'ADT';
                    $HotelBookingTravelers->hotel_booking_id = $hotelRoomBooking->id;
                    $HotelBookingTravelers->webbeds_code = $webbeds_code;
                    $HotelBookingTravelers->save();
                }
            }

            if(isset($room['child']))
            {
                foreach ($room['child'] as $key => $value) {
                    $salutationCodeAndGender =webbedsSalutationsIds($value['title']);
                    $gender = $salutationCodeAndGender['gender'];
                    $webbeds_code = $salutationCodeAndGender['code'];
                    $HotelBookingTravelers = new HotelBookingTravelsInfo();
                    $HotelBookingTravelers->title = $value['title'];
                    $HotelBookingTravelers->first_name = clean_string($value['firstName'] , false);
                    $HotelBookingTravelers->last_name = clean_string($value['lastName'] , false); 
                    $HotelBookingTravelers->room_no = $r+1;
                    $HotelBookingTravelers->gender = $gender;
                    $HotelBookingTravelers->traveler_type = 'CNN';
                    $HotelBookingTravelers->hotel_booking_id = $hotelRoomBooking->id;
                    $HotelBookingTravelers->webbeds_code = $webbeds_code;
                    $HotelBookingTravelers->age = $jsonRoomRequest[$r]['ChildrenAges'][$key];
                    $HotelBookingTravelers->save();
                }
            }
        }

        $hotelbookingId = encrypt($hotelRoomBooking->id);

        $result['bookingDetails'] = $bookingDetails = HotelBooking::with('Customercountry','CouponDetails')->find($hotelRoomBooking->id);
        $result['passengersInfo'] = $passengersInfo = HotelBookingTravelsInfo::whereHotelBookingId($hotelRoomBooking->id)->get();

        $result['hotelDetails'] = $hotelDetails;
        $result['hotelDetails']['image'] = $hotelDetails['thumbnail'];
        $result['hotelCode'] = $hotelCode;
        $result['searchId'] = $searchId;
       

        return view('front_end.hotel.webbeds.preview',compact('titles','result'));

    }

    public function holdBooking(Request $request){
        $bookingId = decrypt($request->input('booking_id'));
        $BookingDetails = HotelBooking::with('Customercountry')->find($bookingId);
        if(empty($BookingDetails))
        {
            //error
            return redirect()->route('some-thing-went-wrong');
        }

        //calling save booking Api 
        $BookingCOntroller = new BookingController();
        $saveBooking = $BookingCOntroller->SaveBooking(['booking_id' => $BookingDetails->id]);
        dd($saveBooking);

        if($saveBooking['success']){
            $BookingDetails->booking_status = 'booking_hold';
            $BookingDetails->holding_xml_id = $saveBooking['hotelRequest']->id;
            $BookingDetails->save();
        }
        return redirect()->away(route('agentbookHotelRooms',['hotelbookingId' => encrypt($BookingDetails->id)]));
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
            return redirect()->away(route('agentbookHotelRooms',['hotelbookingId' => encrypt($BookingDetails->id)]));
        }else{
            //$userName = Auth::guard('web')->check() ? Auth::guard('web')->user()->name : 'guest' ;
            $passengersInfo = HotelBookingTravelsInfo::whereHotelBookingId($BookingDetails->id)->first();
        
            $userName = (!empty($passengersInfo)) ? $passengersInfo->first_name . " ".$passengersInfo->last_name : 'guest';
        
            $callbackURL = route('agentbookHotelRooms',['hotelbookingId' => encrypt($BookingDetails->id)]) ;
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
                if(auth()->user()->agency->wallet_balance >= $hotelbookingdetails->sub_total){
                    //debit from wallet
                    $wallet = auth()->user()->agency->wallet_balance - $hotelbookingdetails->sub_total;
                    $user = User::find(auth()->user()->id);
                    // $user->wallet_balance = $wallet;
                    // $user->save();
                    $agency = Agency::find(auth()->user()->agency_id);
                    $agency->wallet_balance = $wallet;
                    $agency->save();
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
                    $confirmBooking = new BookingController();
                    $isFailure = false;
                    if($hotelbookingdetails->supplier == 'webbeds'){
                        $confirmBookingDetails = $confirmBooking->Booking(['booking_id' => $hotelBookingId]);
                        $hotelbookingdetails->webbeds_booking_request_id = $confirmBookingDetails['xml_request_id'] ?? null;
                        $booking_status = 'booking_pending';
                        if($confirmBookingDetails['success'])
                        {
                            $booking_status = 'booking_completed';
                            $confirmBookingDetails['bookingInfo']['hotelResponse']['bookings']['booking'] = nodeConvertion($confirmBookingDetails['bookingInfo']['hotelResponse']['bookings']['booking']);
                            $confirmationHtml = null;
                            
                            foreach($confirmBookingDetails['bookingInfo']['hotelResponse']['bookings']['booking'] as $rm=>$bookingResponse){
                                $hotelroomBookingInfo = new HotelRoomBookingInfo();
                                $hotelroomBookingInfo->hotel_booking_id = $hotelbookingdetails->id;
                                $hotelroomBookingInfo->room_no = $rm+1;
                                $hotelroomBookingInfo->booking_code = $bookingResponse['bookingCode'];
                                $hotelroomBookingInfo->booking_reference_no = $bookingResponse['bookingReferenceNumber'];
                                $hotelroomBookingInfo->status = ($bookingResponse['bookingStatus'] == 2) ? 'confirmed' : 'pending';
                                $hotelroomBookingInfo->save();
                                // $roomBookingDetails = new BookingController();
                                // $roomBookingInformation = $roomBookingDetails->RoomBookingDetails(['booking_code' => $bookingResponse['bookingCode'] ,'booking_status' => 1 , 'search_id' => $hotelbookingdetails->search_id]);
                                
                                // if($roomBookingInformation['success']){
                                    
                                //     $hotelroomBookingInfo->room_name = $roomBookingInformation['roomBookingInfo']['hotelResponse']['product']['roomName'];
                                //     $hotelroomBookingInfo->room_rate_basis = $roomBookingInformation['roomBookingInfo']['hotelResponse']['product']['rateBasis'];
                                
                                //     $hotelroomBookingInfo->save();
                                // }
                                // if($bookingResponse['bookingStatus'] != 2){
                                //     $booking_status = 'booking_partially_completed';
                                // }
                            }

                            $confirmationHtml = $confirmBookingDetails['bookingInfo']['hotelResponse']['confirmationText_html'] ?? null;

                            // Original HTML content
                            $cleanedHtml = $confirmationHtml;

                            // 1. Remove the entire DAILY RATES <tr> block
                            $cleanedHtml = preg_replace(
                                '/<tr>\s*<td align="center">\s*<table[^>]*?>.*?DAILY RATES.*?<\/table>\s*<table[^>]*?>.*?<\/table>\s*<\/td>\s*<\/tr>/is',
                                '',
                                $cleanedHtml
                            );

                            // 2. Remove the Total Payable paragraph
                            $cleanedHtml = preg_replace(
                                '/<p><strong>Total Payable for this Booking:.*?<\/strong><\/p>/i',
                                '',
                                $cleanedHtml
                            );

                            // 3. Replace Webbeds Customer Service with your label
                            $agentName = auth()->user()->agency->name ?? null;
                            $cleanedHtml = str_replace(
                                '<p>Webbeds Customer Service</p>',
                                '<p>'.$agentName.'</p>',
                                $cleanedHtml
                            );

                            // 4. Replace AL-MASILA GROUP intl with your label
                            $cleanedHtml = str_replace(
                                'AL-MASILA GROUP intl',
                                $agentName,
                                $cleanedHtml
                            );

                            $hotelbookingdetails->booking_status = $booking_status;

                            // //booking successfull
                            // if($confirmBookingDetails['bookingInfo']['hotelResponse']['bookings']['booking']['bookingStatus'] == 2){
                            //     //confirmed
                            //     $hotelbookingdetails->booking_status = 'booking_completed';
                            // }else{
                            //     //pending
                            //      $hotelbookingdetails->booking_status = 'booking_pending';
                            // }
                            // //bookingCode
                            // $hotelbookingdetails->confirmation_number = $confirmBookingDetails['bookingInfo']['hotelResponse']['bookings']['booking']['bookingCode'] ?? null;
                            // $hotelbookingdetails->booking_reference_number = $confirmBookingDetails['bookingInfo']['hotelResponse']['bookings']['booking']['bookingReferenceNumber']?? null;
                            $hotelbookingdetails->save();
                            $result = [];
                            $result['hotelbookingdetails'] = $hotelbookingdetails;
                            //$result['confirmationHtml'] = $confirmBookingDetails['bookingInfo']['hotelResponse']['voucher_htmls'][0] ?? null;
                            $result['confirmationHtml'] = $cleanedHtml ?? null ;
                            $address = auth()->user()->agency->address;
                            if(!empty($result['confirmationHtml']) && !empty(auth()->user()->agency->logo)){
                                $newImgUrl =  asset('uploads/agency/'.$agency->logo);
                                $result['confirmationHtml'] = preg_replace(
                                    '/<img src="[^"]*"/',
                                    '<img src="' . $newImgUrl . '" height="150px"',
                                    $result['confirmationHtml']
                                );
                            }
                            $hotelCustomersInfo = HotelBookingTravelsInfo::where("hotel_booking_id" , $hotelbookingdetails->id)->get();
                            $user = $hotelCustomersInfo[0]->first_name .' '.$hotelCustomersInfo[0]->last_name;
                            
                            //sending Invoice
                            $this->invoice($result,$user,$hotelbookingdetails);

                            $filename = "Reservation_".$hotelbookingdetails->booking_ref_id.".pdf";
                            $pdf = PDF::loadView('front_end.hotel.webbeds.email_templates.reservation', compact('titles','result'));
                            $pdf->save('pdf/hotel_reservation/' . $filename);
                            Mail::send('front_end.hotel.webbeds.email_templates.reservation', compact('titles','result'), function($message)use($pdf,$hotelbookingdetails,$filename) {
                                $message->to($hotelbookingdetails->email)
                                        ->subject('Hotel Reservation')
                                        ->attachData($pdf->output(), $filename);
                            });

                            $hotelbookingdetails->hotel_room_booking_path = 'pdf/hotel_reservation/' . $filename;
                            $hotelbookingdetails->save();
                            // Log::info($reservation->confirmation_number . " execuated sucessfully");
                            return view('front_end.hotel.webbeds.hotelConfirmation',compact('titles','result'));

                            
                        }
                        else{
                            $isFailure = true;
                        }
                    }
                    elseif($hotelbookingdetails->supplier == 'dida')
                    {
                        $confirmBookingDetails = $confirmBooking->DidaBooking(['booking_id' => $hotelBookingId]);
                        $hotelbookingdetails->webbeds_booking_request_id = $confirmBookingDetails['hotelRequest']['id'] ?? null;

                        $bookingDetails = $confirmBookingDetails['response']['Success']['BookingDetails'] ?? [];
                        if(!empty($bookingDetails)){
                            switch ($bookingDetails['Status']) {
                                case 2:
                                    $booking_status = 'booking_completed';
                                    $reservation_status = 'Confirmed';
                                    $room_status = 'confirmed';
                                    break;
                                case 3:
                                    $booking_status = 'canceled';
                                    $reservation_status = 'Canceled';
                                    $room_status = 'cancelled';
                                    break;
                                case 4:
                                    $booking_status = 'booking_failure';
                                    $reservation_status = 'Failed';
                                    $room_status = 'failed';
                                    break;
                                case 5:
                                    $booking_status = 'booking_pending';
                                    $reservation_status = 'Pending';
                                    $room_status = 'pending';
                                    break;
                                case 6:
                                    $booking_status = 'booking_pending';
                                    $reservation_status = 'OnRequest';
                                    $room_status = 'pending';
                                    break;    
                            }

                            $hotelbookingdetails->booking_status = $booking_status;
                            $hotelbookingdetails->reservation_status = $reservation_status;
                            $hotelbookingdetails->booking_reference_number = $bookingDetails['BookingID'] ?? null;
                            $hotelbookingdetails->save();
                            $result = [];
                            $hotelCustomersInfo = HotelBookingTravelsInfo::where("hotel_booking_id" , $hotelbookingdetails->id)->get();
                            $user = $hotelCustomersInfo[0]->first_name .' '.$hotelCustomersInfo[0]->last_name;
                            //sending Invoice
                            $this->invoice($result,$user,$hotelbookingdetails);

                            if($hotelbookingdetails->booking_status == 'canceled' || $hotelbookingdetails->booking_status == 'booking_failure'){
                                $isFailure = true;
                            }elseif($hotelbookingdetails->booking_status == 'booking_pending'){
                                 $titles = [
                                    'title' => "pending Reservation Details",
                                ];
                                $pendingBooking = new PendingHotelRoomBooking();
                                $pendingBooking->hotel_booking_id = $hotelbookingdetails->id;
                                if($reservation_status == 'OnRequest'){
                                    $result['reservation_message'] = "Your reservation is on request, we will try to confirm it as soon as possible. It will take more time than usual to confirm the reservation, usually it takes around 2 to 3 hours but in some cases it may take more time depending on the hotel response. We will keep you updated regarding the status of your reservation.";
                                    $pendingBooking->enable_request_on = now()->addHours(2.5);
                                }else{
                                    $result['reservation_message'] = "Your reservation is pending, we will try to confirm it as soon as possible. It usually takes around 30 minutes to confirm the reservation but in some cases it may take more time depending on the hotel response. We will keep you updated regarding the status of your reservation.";
                                    $pendingBooking->enable_request_on = now()->addMinutes(15);
                                }
                                $pendingBooking->save();
                                return view('front_end.hotel.pending_reservation',compact('titles','result'));
                            }else{
                                /*
                                |--------------------------------------------------------------------------
                                | Dida Recommendation
                                | Perform Booking Search after confirmation to get latest booking status
                                |--------------------------------------------------------------------------
                                */
                                $bookingSearchDetails = $confirmBooking->DidaBookingSearch([
                                    'booking_id' => $hotelbookingdetails->booking_reference_number,
                                    'search_id' => $hotelbookingdetails->search_id
                                ]);
                                $bookingDetails = $bookingSearchDetails['response']['Success']['BookingDetailsList'][0] ?? [];
                                if(!empty($bookingDetails)){
                                    $hotelbookingdetails->booking_search_request_id = $bookingSearchDetails['hotelRequest']['id'] ?? null;
                                    $bookingDetails = $bookingSearchDetails['response']['Success']['BookingDetailsList'][0] ?? [];
                                    $result['hotel_booking_travelers_info'] = HotelBookingTravelsInfo::where("hotel_booking_id" , $hotelbookingdetails->id)->get();
                                    
                                    $user = $result['hotel_booking_travelers_info'][0]->first_name .' '.$result['hotel_booking_travelers_info'][0]->last_name;
                                    $result['hotel_details'] = new \stdClass();
                                    $result['hotel_details']->hotel_name = $hotelbookingdetails->name;
                                    $result['hotel_details']->address = $hotelbookingdetails->address;
                                    $result['hotel_details']->check_in = $bookingDetails['CheckInDate'];
                                    $result['hotel_details']->check_out = $bookingDetails['CheckOutDate'];
                                    $result['hotel_booking_Details'] =$hotelbookingdetails;
                                
                                    $result['user'] = $user;
                                    if(auth()->user()->agency){
                                        $result['agencyName'] = auth()->user()->agency->name ?? null;
                                        $result['agencyImg'] = !empty(auth()->user()->agency->logo) ? 'uploads/agency/'.auth()->user()->agency->logo : 'frontEnd/images/logomh.png';
                                    }else{
                                        $result['agencyName'] = null;
                                        $result['agencyImg'] = 'frontEnd/images/logomh.png';
                                    }
                                    $cancellation_rules = [];
                                    $noOfRooms = $hotelbookingdetails->no_of_rooms;
                                    $insertRooms = [];
                                    foreach($bookingDetails['Hotel']['RatePlanList'] as $rm => $roomDetails){
                                        $insertRooms[] = [
                                            'hotel_booking_id' => $hotelbookingdetails->id,
                                            'room_no' =>  $rm + 1,
                                            'booking_code' =>  $roomDetails['RatePlanID'] ?? null,
                                            'booking_reference_no' => $bookingDetails['BookingID'] ?? null,
                                            'status' => $room_status,
                                            'meal_type' => didaType( 'MealType', $roomDetails['PriceList'][0]['MealType'] ?? null ),
                                            'room_name' => $roomDetails['RatePlanName'] ?? null,
                                        ];
                                        $cancellation_rules[] = convertCancellationRulesForDida($bookingDetails['Hotel']['CancellationPolicyList'] ,$roomDetails['Currency'],(int)$noOfRooms, 'Room '.($rm+1));
                                    }
                                 
                                    if (!empty($insertRooms)) {
                                        HotelRoomBookingInfo::insert($insertRooms);
                                    }
                                    
                                    $hotelbookingdetails->save();
                                    $result['cancellation_rules'] = $cancellation_rules;
                                    $result['excludedFees'] = [];
                                    if(isset($bookingDetails['Hotel']['ExcludedFeeList']) && !empty($bookingDetails['Hotel']['ExcludedFeeList'])){
                                        $result['excludedFees'] = formatExcludedFees($bookingDetails['Hotel']['ExcludedFeeList']);
                                    }

                                    

                                    $hotelbookingdetails->hotelroomBookingInfo = HotelRoomBookingInfo::where('hotel_booking_id', $hotelbookingdetails->id)->get();
                                    
                                    $filename = "Reservation_".$hotelbookingdetails->booking_ref_id.".pdf";
                                    $hotelbookingdetails->hotel_room_booking_path = 'pdf/hotel_reservation/' . $filename;   
                                    $result['hotelbookingdetails'] = $hotelbookingdetails;

                                    $agentImg = $result['agencyImg'];
                                    $successImg = 'frontEnd/images/hotel-booking-successful.png';
                                    //for pdf generation
                                    $result['agencyImg'] = asset($agentImg);
                                    $result['successImg'] = asset($successImg);

                                    $broswerHtml = $pdfhtml = view('front_end.hotel.webbeds.email_templates.hotel_reservation',compact('titles', 'result'))->render();

                                    //for broswer display
                                    // $result['agencyImg'] = asset($agentImg);
                                    // $result['successImg'] = asset($successImg);

                                    // $broswerHtml = view('front_end.hotel.webbeds.email_templates.hotel_reservation',compact('titles', 'result'))->render();

                                    $pdf = PDF::loadHTML($pdfhtml);
                                    
                                    $pdfPath = 'pdf/hotel_reservation/' . $filename;
                                    $pdf->save($pdfPath);

                                    Mail::send([], [], function ($message)
                                        use ($hotelbookingdetails,$filename,$pdfPath,$broswerHtml) {
                                        $message->to($hotelbookingdetails->email)
                                            ->subject('Hotel Reservation');
                                        // HTML BODY
                                        $message->setBody(
                                            $broswerHtml,
                                            'text/html'
                                        );

                                        // PDF ATTACHMENT
                                        $message->attach(
                                            publicFilePath($pdfPath),
                                            [
                                                'as' => $filename,
                                                'mime' => 'application/pdf',
                                            ]
                                        );
                                    });

                                    HotelBooking::where('id', $hotelbookingdetails->id)->update([
                                        'hotel_room_booking_path' => 'pdf/hotel_reservation/' . $filename
                                    ]);

                                    
                                    $hotelbookingdetails->hotel_room_booking_path = 'pdf/hotel_reservation/' . $filename;
                                    $result['confirmationHtml'] = $broswerHtml;

                                    return view('front_end.hotel.webbeds.hotelConfirmation',compact('titles','result'));
                                    
                                }else{
                                    //booking Success but booking Search Failure
                                }
                            }
                        }else{
                            $isFailure = true;
                        }
                    }
                    if($isFailure){
                        
                        //booking failed
                        $hotelbookingdetails->booking_status = 'booking_failure';
        
                        $hotelbookingdetails->save();
                        $data['errorresponse'] = 'booking failure amount will be refunded back';
                        //travelport request error response
                        //refund should initate
                        //redirect to error page
                        if($hotelbookingdetails->type_of_payment == 'wallet'){
                            $this->refund($hotelbookingdetails->id);
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
        // [{"allocationDetails":"1749386375000002B1000B0","roomTypeCode":"58934","rateBasisId":"0"},[{"allocationDetails":"1749386375000002B1000B0","roomTypeCode":"58934","rateBasisId":"0"}]]
    }

    public function invoice($result,$user,$hotelbookingdetails)
    {
        $invoiceId = $hotelbookingdetails->internal_booking == 1 ? $hotelbookingdetails->booking_ref_id :$hotelbookingdetails->invoice_id;
        $filename = "Invoice_".$invoiceId.".pdf";
        $completePath = null;
        //if(env('APP_ENV') != 'local'){
           

            $result['hotelbookingdetails'] = $hotelbookingdetails; 
            $result['user'] = $user;
            $result['agency'] = auth()->user()->agency;
            $result['agent'] = auth()->user();
        
            $result['supplier_booking_ids'] = HotelRoomBookingInfo::where('hotel_booking_id', $hotelbookingdetails->id)->selectRaw('GROUP_CONCAT(DISTINCT booking_reference_no ORDER BY booking_reference_no) AS supplier_ids')->value('supplier_ids');
            if($hotelbookingdetails->supplier == 'dida'){
                //$hotelInfo = DidaHotel::where('hotel_id' , $result['hotelbookingdetails']->hotel_code)->first();
                $result['hotel_details'] = new \stdClass();
                $result['hotel_details']->hotel_name = $hotelbookingdetails->hotel_name;
                $result['hotel_details']->address = $hotelbookingdetails->hotel_address;
                $result['hotel_details']->check_in = $result['hotelbookingdetails']->check_in;
                $result['hotel_details']->check_out = $result['hotelbookingdetails']->check_out;
            }else{
                //$hotelInfo = WebbedsHotel::where('hotel_code' , $result['hotelbookingdetails']->hotel_code)->first();
                $result['hotel_details'] = new \stdClass();
                $result['hotel_details']->hotel_name = $hotelbookingdetails->hotel_name;
                $result['hotel_details']->address = $hotelbookingdetails->hotel_address;
                $result['hotel_details']->check_in = $result['hotelbookingdetails']->check_in;
                $result['hotel_details']->check_out = $result['hotelbookingdetails']->check_out;
            }

            $agentImg = isset($result['agency']->logo) && !empty($result['agency']->logo) ? 'uploads/agency/'.$result['agency']->logo : 'frontEnd/images/logomh.png';

            $result['agencyImg'] = asset($agentImg);

            $broswerHtml = $pdfhtml = view('front_end.hotel.webbeds.email_templates.invoice',compact('result'))->render();
            
            $pdf = PDF::loadHTML($pdfhtml);

            // $result['agencyImg'] = asset($agentImg);
            // $broswerHtml = view('front_end.hotel.webbeds.email_templates.invoice',compact('result'))->render();

            $completePath = 'pdf/invoice/' . $filename;
            $hotelbookingdetails->invoice_path = $completePath;
            $hotelbookingdetails->save();
            $pdf->save('pdf/invoice/' . $filename);

            return Mail::send([], [], function ($message)
                use (
                    $hotelbookingdetails,
                    $filename,
                    $completePath,
                    $broswerHtml
                ) {

                $message->to($hotelbookingdetails->email)
                    ->subject('Invoice');

                // HTML BODY
                $message->setBody(
                    $broswerHtml,
                    'text/html'
                );

                // PDF ATTACHMENT
                $message->attach(
                    publicFilePath($completePath),
                    [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]
                );
            });



            

                            

            // $pdf = PDF::loadView('front_end.hotel.webbeds.email_templates.invoice', compact('result'));


                // return Mail::send('front_end.hotel.webbeds.email_templates.invoice', compact('result'), function($message)use($pdf,$hotelbookingdetails,$filename) {
                //     $message->to($hotelbookingdetails->email)
                //             ->subject('Invoice')
                //             ->attachData($pdf->output(), $filename);
                // });
        // }else{
        //     return 1;
        // }
    }

    private function refund($bookingId,$userid = null)
    {
        $hotelBookingdetails = HotelBooking::find($bookingId);
    
        $hotelBookingdetails->booking_status = "refund_initiated";
        $hotelBookingdetails->save();
    
        if($hotelBookingdetails->type_of_payment == 'wallet'){

            $user = $userid ? User::find($userid) : auth()->user();
            $wallet_balance = $user->agency->wallet_balance;
            $wallet = $wallet_balance + $hotelBookingdetails->sub_total;
          
            $agency = Agency::find($user->agency_id);
            $agency->wallet_balance = $wallet;
            $agency->save();
     
            $walletDetails = WalletLogger::create([
                'user_id' => $user->id,
                'reference_id' => $hotelBookingdetails->id,
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

    /**
     * Process 10 pending hotel room bookings via DIDA API
     * Fetches pending bookings, calls DIDA booking confirmation API, and updates their status
     */
    public function processPendingHotelBookings()
    {
        try {
            // Fetch 10 pending booking records
            $pendingBookings = PendingHotelRoomBooking::where('cron_status', 'pending')
                ->where('status', 'pending')
                ->limit(10)
                ->get();

            if ($pendingBookings->isEmpty()) {
                Log::info('No pending hotel bookings found to process');
                return [
                    'success' => true,
                    'message' => 'No pending bookings found',
                ];
            }

        

            foreach ($pendingBookings as $pendingBooking) {
                try {
                    // Update cron status to processing
                    $pendingBooking->cron_status = 'processing';
                    $pendingBooking->save();

                    // Get hotel booking details
                    $hotelBooking = HotelBooking::find($pendingBooking->hotel_booking_id);


                    if (!$hotelBooking) {
                      
                        Log::error("Hotel booking not found for pending booking ID: {$pendingBooking->id}");
                        $pendingBooking->cron_status = 'failed';
                        $pendingBooking->status = 'failed';
                        $pendingBooking->execuated_on = Carbon::now();
                        $pendingBooking->save();
                        continue;
                    }

                    // Call DIDA booking API
                    $bookingController = new BookingController();
                    $confirmBookingDetails = $bookingController->DidaBookingSearch([
                        'booking_id' => $hotelBooking->booking_reference_number,
                        'search_id' => $pendingBooking->search_id
                    ]);
                    $bookingDetails = $confirmBookingDetails['response']['Success']['BookingDetailsList'][0] ?? [];
            

                    if (!empty($bookingDetails)) {
                        // Booking successful - save room booking info
                        $hotelBooking->booking_search_request_id = $bookingSearchDetails['hotelRequest']['id'] ?? null;
                        switch ($bookingDetails['Status']) 
                        {
                            case 2:
                                $booking_status = 'booking_completed';
                                $reservation_status = 'Confirmed';
                                $room_status = 'confirmed';
                                break;
                            case 3:
                                $booking_status = 'canceled';
                                $reservation_status = 'Canceled';
                                $room_status = 'cancelled';
                                break;
                            case 4:
                                $booking_status = 'booking_failure';
                                $reservation_status = 'Failed';
                                $room_status = 'failed';
                                break;
                            case 5:
                                $booking_status = 'booking_pending';
                                $reservation_status = 'Pending';
                                $room_status = 'pending';
                                break;
                            case 6:
                                $booking_status = 'booking_pending';
                                $reservation_status = 'OnRequest';
                                $room_status = 'pending';
                                break;    
                        }
                        $hotelBooking->booking_status = $booking_status;
                        $hotelBooking->reservation_status = $reservation_status;
                        $hotelBooking->booking_reference_number = $bookingDetails['BookingID'] ?? null;
                        $hotelBooking->save();
                        if($hotelBooking->booking_status == 'canceled' || $hotelBooking->booking_status == 'booking_failure'){
                            if($hotelBooking->type_of_payment == 'wallet'){
                                $this->refund($hotelBooking->id , $hotelBooking->user_id); ;
                            }
                             // Update pending booking status
                            $pendingBooking->cron_status = "completed";
                            $pendingBooking->status = "cancelled";
                            $pendingBooking->execuated_on = Carbon::now();
                            $pendingBooking->save();
                            Log::info("Successfully processed booking ID: {$hotelBooking->id}");
                        }elseif($hotelBooking->booking_status == 'booking_pending'){
                            if($reservation_status == 'OnRequest'){
                                $pendingBooking->enable_request_on = now()->addHours(2.5);
                            }else{
                                $pendingBooking->enable_request_on = now()->addMinutes(15);
                            }
                            // Update pending booking status
                            $pendingBooking->cron_status = "pending";
                            $pendingBooking->status = "pending";
                            $pendingBooking->execuated_on = Carbon::now();
                            $pendingBooking->save();
                        }else
                        {
                            $result = [];
                            $result['hotel_booking_travelers_info'] = HotelBookingTravelsInfo::where("hotel_booking_id" , $hotelBooking->id)->get();
                            
                            $user = $result['hotel_booking_travelers_info'][0]->first_name .' '.$result['hotel_booking_travelers_info'][0]->last_name;
                            $result['hotel_details'] = new \stdClass();
                            $result['hotel_details']->hotel_name = $hotelBooking->name;
                            $result['hotel_details']->address = $hotelBooking->address;
                            $result['hotel_details']->check_in = $bookingDetails['CheckInDate'];
                            $result['hotel_details']->check_out = $bookingDetails['CheckOutDate'];
                            $result['hotel_booking_Details'] =$hotelBooking;
                        
                            $result['user'] = $user;
                            $result['agencyName'] = 'MasilaHolidays';
                            $result['agencyImg']    =  "frontEnd/images/logomh.png";

                            $userID = $hotelBooking->user_id;
                            if(!empty($userID) && $userID){
                                $userInfo = User::where('id', $userID)->first();
                                if(!empty($userInfo) && $userInfo->agency_id){  
                                    $agenceInfo = Agency::where('id', $userInfo->agency_id)->first();
                                    if(!empty($agenceInfo)){
                                        $result['agencyName'] = $agenceInfo->name ?? null;
                                        $result['agencyImg'] = !empty($agenceInfo->logo) ? 'uploads/agency/'.$agenceInfo->logo : 'frontEnd/images/logomh.png';
                                    }
                                }
                            }
                            //  if(auth()->user()->agency){
                            //     $result['agencyName'] = auth()->user()->agency->name ?? null;
                            //     $result['agencyImg'] = !empty(auth()->user()->agency->logo) ? 'uploads/agency/'.auth()->user()->agency->logo : 'frontEnd/images/logomh.png';
                            // }else{
                            //     $result['agencyName'] = null;
                            //     $result['agencyImg'] = 'frontEnd/images/logomh.png';
                            // } 
                            $cancellation_rules = [];
                            $noOfRooms = $hotelBooking->no_of_rooms;
                            $insertRooms = [];
                            foreach($bookingDetails['Hotel']['RatePlanList'] as $rm => $roomDetails){
                                $insertRooms[] = [
                                    'hotel_booking_id' => $hotelBooking->id,
                                    'room_no' =>  $rm + 1,
                                    'booking_code' =>  $roomDetails['RatePlanID'] ?? null,
                                    'booking_reference_no' => $bookingDetails['BookingID'] ?? null,
                                    'status' => $room_status,
                                    'meal_type' => didaType( 'MealType', $roomDetails['PriceList'][0]['MealType'] ?? null ),
                                    'room_name' => $roomDetails['RatePlanName'] ?? null,
                                ];
                                $cancellation_rules[] = convertCancellationRulesForDida($bookingDetails['Hotel']['CancellationPolicyList'] ,$roomDetails['Currency'],(int)$noOfRooms, 'Room '.($rm+1));
                            }
                            if (!empty($insertRooms)) {
                                HotelRoomBookingInfo::insert($insertRooms);
                            }
                            
                            $hotelBooking->save();
                            $result['cancellation_rules'] = $cancellation_rules;
                            $result['excludedFees'] = [];
                            if(isset($bookingDetails['Hotel']['ExcludedFeeList']) && !empty($bookingDetails['Hotel']['ExcludedFeeList'])){
                                $result['excludedFees'] = formatExcludedFees($bookingDetails['Hotel']['ExcludedFeeList']);
                            }

                            $hotelBooking->hotelroomBookingInfo = HotelRoomBookingInfo::where('hotel_booking_id', $hotelBooking->id)->get();
                            
                            $filename = "Reservation_".$hotelBooking->booking_ref_id.".pdf";
                            $hotelBooking->hotel_room_booking_path = 'pdf/hotel_reservation/' . $filename;   
                            $result['hotelbookingdetails'] = $hotelBooking;

                            $agentImg = $result['agencyImg'];
                            $successImg = 'frontEnd/images/hotel-booking-successful.png';
                            //for pdf generation
                            $result['agencyImg'] = asset($agentImg);
                            $result['successImg'] = asset($successImg);

                            $broswerHtml = $pdfhtml = view('front_end.hotel.webbeds.email_templates.hotel_reservation',compact( 'result'))->render();

                            $result['confirmationHtml'] = $broswerHtml;
                            $titles = [
                                'title' => "Hotel Reservation Details",
                            ];
                            $pdf = PDF::loadHTML($pdfhtml);
                            
                            $pdfPath = 'pdf/hotel_reservation/' . $filename;
                            $pdf->save($pdfPath);

                            Mail::send([], [], function ($message)
                                use ($hotelBooking,$filename,$pdfPath,$broswerHtml) {
                                $message->to($hotelBooking->email)
                                    ->subject('Hotel Reservation');
                                // HTML BODY
                                $message->setBody(
                                    $broswerHtml,
                                    'text/html'
                                );
                                // PDF ATTACHMENT
                                $message->attach(
                                    publicFilePath($pdfPath),
                                    [
                                        'as' => $filename,
                                        'mime' => 'application/pdf',
                                    ]
                                );
                            });
                            HotelBooking::where('id', $hotelBooking->id)->update([
                                'hotel_room_booking_path' => 'pdf/hotel_reservation/' . $filename
                            ]);
                                  // Update pending booking status
                            $pendingBooking->cron_status = "completed";
                            $pendingBooking->status = "confirmed";
                            $pendingBooking->execuated_on = Carbon::now();
                            $pendingBooking->save();
                            Log::info("DIDA booking Success for hotel booking ID: {$hotelBooking->id}");
                        }
                       
                        
                    } else {
                        // Booking failed
                        $pendingBooking->cron_status = 'failed';
                        $pendingBooking->status = 'failed';
                        $pendingBooking->execuated_on = Carbon::now();
                        $pendingBooking->save();

                        Log::error("DIDA booking failed for hotel booking ID: {$hotelBooking->id}", [
                            'response' => $confirmBookingDetails
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error("Error processing pending booking ID: {$pendingBooking->id}", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    $pendingBooking->cron_status = 'failed';
                    $pendingBooking->status = 'failed';
                    $pendingBooking->execuated_on = Carbon::now();
                    $pendingBooking->save();
                }
            }

            return [
                'success' => true,
                'message' => 'Pending bookings processing completed',
            ];
        } catch (\Exception $e) {
            Log::error("Error in processPendingHotelBookings: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error processing pending bookings',
                'error' => $e->getMessage()
            ];
        }
    }
}
