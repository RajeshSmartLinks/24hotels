<?php

namespace App\Http\Controllers\FrontEnd\Hotel\Webbeds;

use PDF;
use stdClass;
use DOMDocument;
use App\Models\User;
use App\Models\Agency;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\TboHotel;
use App\Models\GuestUser;
use App\Models\HotelSearch;
use App\Models\SeoSettings;
use App\Models\WebbedsCity;
use App\Models\HotelBooking;
use App\Models\WalletLogger;
use App\Models\WebbedsHotel;
use Illuminate\Http\Request;
use App\Models\WebbedsCountry;
use Illuminate\Support\Carbon;
use App\Models\HotelXmlRequest;
use App\Models\HotelReservation;
use App\Models\WebbedsHotelSearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\HotelRoomBookingInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\HotelBookingTravelsInfo;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\FrontEnd\Hotel\Xml\SearchController;
use App\Http\Controllers\FrontEnd\Hotel\Xml\BookingController;

class HomeController extends Controller
{
    //
    public function AjaxHotelCityList(Request $request){
        $search = $request->input('q');
        $hotel = WebbedsCity::select('code','name',DB::raw('CONCAT (name," - ",country_name) as display_name ,country_name'));
        $hotel->having('display_name', 'LIKE', '%'.$search.'%');
        $hotel = $hotel->get()->toArray();
        return $hotel;
    }

    public function SearchHotels(Request $request){
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

        $result['countries'] = WebbedsCountry::get();
   

        $SearchController = new SearchController();
        $searchResponse = $SearchController->Search($request);
        $searchId = $searchResponse['searchId'] ??null;
        $searchResponse =  $searchResponse['hotelResponse'];
        $noOfRooms = $request->input('noOfRooms');

        $cityCode = $request->input('hotelsCityCode');
        if($searchResponse['successful'] == "TRUE" && count($searchResponse['hotels']['hotel']) > 0)
        {
            $hotelsdata = $searchResponse['hotels']['hotel'];
            $roomAvailablelHotelIds = array_map(function ($hotel) {
                return $hotel['@attributes']['hotelid'] ?? null;
            }, $hotelsdata);

            // Optionally remove nulls (in case of missing hotelid)
            $roomAvailablelHotelIds = array_filter($roomAvailablelHotelIds);
            
            $avialableWebbedsHotel = WebbedsHotel::select('hotel_code')->whereIn('hotel_code' , $roomAvailablelHotelIds)->get();
            $availableHotelIdList = array_column($avialableWebbedsHotel->toArray() , 'hotel_code');
            $unavailableHotelIdList = array_diff($roomAvailablelHotelIds , $availableHotelIdList);
           // dd(['roomAvailablelHotelIds' => $roomAvailablelHotelIds , 'availableHotelIdList' => $availableHotelIdList,'unavailableHotelIdList' => $unavailableHotelIdList]);

            //fetching unavailable hotels from webbeds
            $SearchController = new SearchController();
            $SearchController->fetchUnavailableHotels(['hotelIds' => $unavailableHotelIdList , 'cityCode' => $cityCode]);

            //after fetching 
            $availableHotelDetailsList = DB::table('webbeds_hotels')->select('hotel_code' , 'hotel_name' , 'hotel_rating' , 'address' , 'thumbnail' , 'check_in' , 'check_out','exclusive','preferred','phone_number','pin_code')->whereIn('hotel_code' , $roomAvailablelHotelIds)->get();
            foreach ($searchResponse['hotels']['hotel'] as $key => $value) {
                
                $hotelCode = $value['@attributes']['hotelid'];
                $hotelDetails = $availableHotelDetailsList->firstWhere('hotel_code', $hotelCode);
                if($hotelDetails){

                    $value['rooms']['room'] = nodeConvertion($value['rooms']['room']);

                    foreach($value['rooms']['room'] as $rk => $room){
                        $value['rooms']['room'][$rk]['roomType'] = nodeConvertion($value['rooms']['room'][$rk]['roomType']);
                        foreach($value['rooms']['room'][$rk]['roomType'] as $rtk => $roomType){
                            $value['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis'] = nodeConvertion($value['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis']);
                        }
                    }

                    $roomInfo = [];
                    foreach ($value['rooms']['room'] as $rk => $room) {
                        foreach ($room['roomType'] as $rtk => $roomType) {
                            foreach ($roomType['rateBases']['rateBasis'] as $rbk => $rateBasis) {
                                $roomTypeCode = $roomType['@attributes']['roomtypecode'];
                                $rateBasisId = $rateBasis['@attributes']['id'];
                                $key = $roomTypeCode . '_' . $rateBasisId;
                                // Prepare allocation detail
                                if (!isset($roomInfo[$key])) {
                                    // First time adding this combination
                                    $roomInfo[$key] = [
                                        'name' => $roomType['name'],
                                        'total' => $rateBasis['total'],
                                        'roomCount' => 1
                                    ];
                                } else {
                                    // Already exists — add to total and append allocationDetails
                                    $roomInfo[$key]['total'] += $rateBasis['total'];
                                    $roomInfo[$key]['roomCount']++;
                                }
                            }
                        }
                    }
                    //dd($roomInfo,$noOfRooms);
                    $roomInfo = array_values($roomInfo);
                    
                    foreach ($roomInfo as $key => $roomDetails) {
                        if($roomDetails['roomCount'] != $noOfRooms){
                            unset($roomInfo[$key]);
                        }
                    }
                    $roomInfo = array_values($roomInfo);

                    if(!empty($roomInfo)){
                        $markup = hotelMarkUpPrice(array('totalPrice' => $roomInfo[0]['total'] , 'currencyCode' => 'KWD' , 'totalTax' => $roomInfo[0]['totalTaxes'] ?? 0));

                        $result['hotelList'][] = [
                            'hotelName' => $hotelDetails->hotel_name,
                            'hotelRating' => $hotelDetails->hotel_rating,
                            'address' => $hotelDetails->address,
                            'image' => !empty($hotelDetails->thumbnail) ? $hotelDetails->thumbnail : null,
                            'hotelCode' => $hotelDetails->hotel_code,
                            'checkIn' => $hotelDetails->check_in,
                            'checkOut' => $hotelDetails->check_out,
                            //'bookingCode' => $value['Rooms'][0]['BookingCode'],
                            'rooms' => $value['rooms']['room'][0]['roomType'][0]['name']??null,
                            //'totalFare' => sprintf("%.3f", $value['Rooms'][0]['TotalFare']),
                            'currenceCode' => '769',
                            //'isRefundable' => $value['Rooms'][0]['IsRefundable'] ??null,
                            'markups' => $markup,
                            'exclusive' => $hotelDetails->exclusive,
                            'preferred' => $hotelDetails->preferred,
                            'phone_number' => $hotelDetails->phone_number,
                            'pin_code' => $hotelDetails->pin_code,
                            //'roomPromotion' => isset($value['Rooms'][0]['RoomPromotion']) ? $value['Rooms'][0]['RoomPromotion'] :[]
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
           }
           usort($result['hotelList'], function($a, $b) {
            return $a['markups']['totalPrice']['value'] <=> $b['markups']['totalPrice']['value'];
        });
        }
        else{
            //hotels not available
           
        }

        
        
        $cityDetails = DB::table('webbeds_cities')->where('code',$request->input('hotelsCityCode'))->first();
        if(!empty($cityDetails))
        {
            $result['cityName'] = $cityDetails->name;
        }
        else{
            $result['cityName'] = '';
        }
        $result['searchId'] = $searchId??'';
        $result['searchRequest'] = !empty($result['searchId']) ?  WebbedsHotelSearch::find($searchId)->toArray() : [];

        $result['filter']['minPrice'] = $minPrice;
        $result['filter']['maxPrice'] = $maxPrice;
        // $result['filter']['refundableCount'] = $refundableCount;
        // $result['filter']['nonrefundableCount'] = $nonrefundableCount;
        $result['filter']['rating']['one_star'] = $rating1;
        $result['filter']['rating']['two_star'] = $rating2;
        $result['filter']['rating']['three_star'] = $rating3;
        $result['filter']['rating']['four_star'] = $rating4;
        $result['filter']['rating']['five_star'] = $rating5;
        
        //dd($result);
        return view('front_end.hotel.webbeds.search',compact('titles','result'));
    }


    public function GethotelDetails(Request $request)
    {
        $hotelCode = decrypt($request->query('hotelCode'));
        if ($request->has('searchId')) {
            $searchId = decrypt($request->query('searchId'));
        }else{
            // if search id not found in url then creading new entry in search table

            $cityCode = $request->input('hotelsCityCode');
            $checkIn = $request->input('hotelsCheckIn');
            $checkOut = $request->input('hotelsCheckOut');
            $noOfRooms = (int) $request->input('noOfRooms');
            $nationality = $request->input('nationality');
            $residency = $request->input('residency');

            $cityDetails = DB::table('webbeds_cities')->where('code',$cityCode)->first();
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
            $hotelSearch->no_of_rooms = $request->input('noOfRooms');
            $hotelSearch->no_of_nights    = $CIn->diffInDays($COut);
            $hotelSearch->nationality    = $nationality;
            $hotelSearch->residency    = $residency;
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

            $searchId = $hotelSearch->id;
        }
     
     
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'hotelDetails','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];

        $rooms = new SearchController();
        $hotelDetailsAndRooms = $rooms->getRooms(['hotel_code' => $hotelCode ,'search_id' => $searchId]);


        $result = [];
        $result['countries'] = WebbedsCountry::get();
        $result['searchRequest'] = WebbedsHotelSearch::find($searchId);
        $noOfRooms = $result['searchRequest']->no_of_rooms;

        $result['hotelDeatils'] = [] ;
        if(!empty($hotelDetailsAndRooms['hotelDetails']))
        {
            $result['hotelDeatils'] = $hotelDetailsAndRooms['hotelDetails'] ;
        }
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
                            'validForOccupancy' => $validForOccupancy
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

       


        //searchRequest 
        $result['hotelCode'] = $hotelCode;

        return view('front_end.hotel.webbeds.details',compact('titles','result'));
        
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
        $prebookingDeatails = $prebooking->PreBooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=>$bookingCode]); 
        $result = [];

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
            $result['searchRequest'] = WebbedsHotelSearch::find($searchId);
            $result['searchRequest']->rooms_request = json_decode($result['searchRequest']->rooms_request,true);
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
        }
        $result['roomDetails'] = $result['roomDetails'][0];
   
        
        if(app()->getLocale() == 'ar')
        {
            $name = 'IFNULL(name_ar,name) as name' ;
        }
        else{
            $name = 'name' ;
        }
        $result['countries'] = Country::select('id',DB::raw($name),'phone_code')->whereNotNull("phone_code")->get();
        //$result['roomDetails'] = $result['availablerooms'][0] ?? [];
        $result['RateConditions'] = [];
        $result['bookingCode'] = $result['roomDetails']['formatedBookingCode']??'';
        $result['hotelCode'] = $hotelCode;
        $result['searchId'] = $searchId;
        $result['webbedsBlockingId'] = $prebookingDeatails['xml_request_id'];


        $currentDate = Carbon::now()->toDateString();
        $couponCodes = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->whereIn('coupon_valid_on' ,[1,3])->get();
        $result['couponCodes'] = $couponCodes;

        return view('front_end.hotel.webbeds.pre_booking',compact('titles','result'));
    }

    public function savePassanger(Request $request)
    {
        $titles = [
            'title' => "Traveller Preview ",
        ];

        $hotelCode = decrypt($request->input('hotelCode'));
        $bookingCode = decrypt($request->input('bookingCode'));
        $searchId = decrypt($request->input('searchId'));
        $webbedsBlockingId = decrypt($request->input('webbedsBlockingId'));
        
        // $prebooking = new BookingController();
        //$prebookingDeatails = $prebooking->TboPreBooking(['hotel_code' => $hotelCode ,'search_id' => $searchId , 'booking_code'=> $bookingCode]);
        //print_r($webbedsBlockingId);
        $hotelXmlRequest = HotelXmlRequest::findOrFail($webbedsBlockingId);
        $prebookingDeatails = XmlToArrayWithHTML($hotelXmlRequest->response_xml);
        //dd($prebookingDeatails);


        if($prebookingDeatails['successful'] == false)
        {
            //error page
            //session expire
            $data['errorresponse'] = 'Session Expired';
            $titles = [
                'title' => "Error Page",
            ];

            return view('front_end.error',compact('titles','data'));

        }
        $searchDetails = WebbedsHotelSearch::find($searchId);

        $hotelDetails = WebbedsHotel::where('hotel_code' , $hotelCode)->first()->toArray();

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

        if(!empty($prebookingDeatails['hotel']['rooms']['room']))
        {
            $prebookingDeatails['hotel']['rooms']['room'] = nodeConvertion($prebookingDeatails['hotel']['rooms']['room']);
            foreach($prebookingDeatails['hotel']['rooms']['room'] as $rk => $room){
                $prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'] = nodeConvertion($prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType']);
                foreach($prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'] as $rtk => $roomType){
                    $prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis'] = nodeConvertion($prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis']);
                    if(isset($roomType['specials'])){
                        if(isset($roomType['specials']['@attributes']) && $roomType['specials']['@attributes']['count'] > 0){
                            $prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'] = nodeConvertion($prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special']);
                        }else{
                            unset($prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']);
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
            foreach ($prebookingDeatails['hotel']['rooms']['room'] as $rk => $room) {
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
                                    if(isset($prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'][$SAValue]['specialName'])){
                                        $specialPromotion[] = $prebookingDeatails['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['specials']['special'][$SAValue]['specialName'];
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
        $result['roomDetails'] = $result['roomDetails'][0];



        
        $hotelRoomBooking->currency_code = $result['roomDetails']['markups']['FatoorahPaymentAmount']['currency_code'];
        $hotelRoomBooking->total_amount = $result['roomDetails']['markups']['FatoorahPaymentAmount']['value'];

        $hotelRoomBooking->actual_price = $result['roomDetails']['markups']['actualPrice']['value'];
        $hotelRoomBooking->actual_currency_code = $result['roomDetails']['markups']['actualPrice']['currency_code'];

        //$hotelRoomBooking->price_from_supplier =  $result['roomDetails']['TotalFare'];
        $hotelRoomBooking->currency_code_from_supplier = 'KWD';

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

        $hotelRoomBooking->actual_amount = $result['roomDetails']['markups']['actualTotalAmount']['value'];

        $hotelRoomBooking->type_of_payment = $request->input('type_of_payment');
        $hotelRoomBooking->supplier = 'webbeds';
        $hotelRoomBooking->booking_status = 'booking_initiated';
        $hotelRoomBooking->no_of_rooms = $searchDetails->no_of_rooms;
        $hotelRoomBooking->no_of_guests = $searchDetails->no_of_guests;
        $hotelRoomBooking->no_of_nights = $searchDetails->no_of_nights;

        $hotelRoomBooking->save();

        $APP_ENV = env('APP_ENV');
        if($APP_ENV == 'local')
        {
            $hotelRoomBooking->booking_ref_id = 'MTHL'.str_pad($hotelRoomBooking->id, 7, '0', STR_PAD_LEFT);
        }
        elseif($APP_ENV == 'DEV'){
            $hotelRoomBooking->booking_ref_id = 'MTHD'.str_pad($hotelRoomBooking->id, 7, '0', STR_PAD_LEFT);
        }
        elseif($APP_ENV == 'prod'){
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
       

        return view('front_end.hotel.webbeds.preview',compact('titles','result'));

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

    private function refund($bookingId)
    {
        $hotelBookingdetails = HotelBooking::find($bookingId);
    
        $hotelBookingdetails->booking_status = "refund_initiated";
        $hotelBookingdetails->save();
    
        if($hotelBookingdetails->type_of_payment == 'wallet'){
            $wallet = auth()->user()->agency->wallet_balance + $hotelBookingdetails->sub_total;
          
            $agency = Agency::find(auth()->user()->agency_id);
            $agency->wallet_balance = $wallet;
            $agency->save();
     
            $walletDetails = WalletLogger::create([
                'user_id' => auth()->user()->id,
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

    // public function HotelBookingPreview($hotelbookingId){
    //     $titles = [
    //         'title' => "Traveller Preview ",
    //     ];
    //     $result =[];

    //     $hotelbookingId = decrypt($hotelbookingId);

    //     $result['bookingDetails'] = $bookingDetails = HotelBooking::with('Customercountry','CouponDetails')->find($hotelbookingId);
    //     $result['passengersInfo'] = $passengersInfo = HotelBookingTravelsInfo::whereHotelBookingId($hotelbookingId)->get();

    //     $prebooking = new BookingController();
    //     $prebookingDeatails = $prebooking->TboPreBooking(['hotel_code' => $bookingDetails->hotel_code ,'search_id' => $bookingDetails->search_id , 'booking_code'=> $bookingDetails->booking_code]);

    //     $hotelDetails = TboHotel::where('hotel_code' , $bookingDetails->hotel_code)->first()->toArray();
    //     $result['hotelDetails'] = $hotelDetails;
    //     $result['hotelDetails']['image'] = !empty(json_decode($hotelDetails['images'])) ? json_decode($hotelDetails['images'])[0] : null;
    //     if(!isset($prebookingDeatails['preBooking'][0]['Rooms'][0]))
    //     {
    //         //error page
    //         //session expire
    //         $data['errorresponse'] = 'Session Expired';
    //         $titles = [
    //             'title' => "Error Page",
    //         ];

    //         return view('front_end.error',compact('titles','data'));

    //     }
    //     if($prebookingDeatails['preBooking'][0]['Rooms'][0]){

    //         $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']:$prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax'] ,'paymentType' => $bookingDetails->type_of_payment ?? 'k_net' , 'couponCode' =>  $bookingDetails->CouponDetails->coupon_code ?? null));
    //         //$supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
    //         if(isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']))
    //         {
    //             $supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
    //             unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']);
    //             $supplmentAmout = 0.000;
    //             $currency = '';
    //             foreach ($supplments as $skey => $svalue) {
    //                 if($svalue[0]['Type'] == 'AtProperty' &&  ($svalue[0]['Description'] == 'mandatory_fee' || $svalue[0]['Description'] == 'mandatory_tax'))
    //                 {
    //                     $supplmentAmout+=$svalue[0]['Price'] ;
    //                     $currency = $svalue[0]['Currency'];

    //                 }
    //             }
    //             $prebookingDeatails['preBooking'][0]['Rooms'][0]['supplment_charges'] = $currency.' '.$supplmentAmout;
    //         }
    //         else{
    //             $prebookingDeatails['preBooking'][0]['Rooms'][0]['supplment_charges'] = null;
    //         }
    //         $prebookingDeatails['preBooking'][0]['Rooms'][0]['roomPromotion'] = isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion'] :[];
    //         $poilcy = $prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies'];
    //         unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies']);
    //         $calcelationPolicys = [];
    //         if(isset($poilcy)){
    //             foreach ($poilcy as $key => $value) {
    //                 if($value['ChargeType'] == 'Percentage')
    //                 {
    //                     $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'].'%';
    //                 }else{
    //                     $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'];
    //                 }
    //             }
    //         }
    //         $prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies'] = $calcelationPolicys ;
    //         $prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion'] = isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion'] : [] ;
    //     }

    //     $result['roomDetails'] = $prebookingDeatails['preBooking'][0]['Rooms'][0] ?? [];
        
    //     $result['RateConditions'] = $prebookingDeatails['preBooking'][0]['RateConditions'] ?? [];
    //     $result['searchRequest'] = HotelSearch::find($bookingDetails->search_id);


    //     return view('front_end.hotel.preview',compact('titles','result'));

    // }

    // public function CountryList(Request $request){
    //     $hotel = WebbedsCity::select('country_name')->groupBy('country_name')->get()->toArray();
    //     return $hotel;
    // }
    


    //                 $dom = new DOMDocument();
    // $dom->loadXML($response);

    // $result = [];

    // // Convert basic XML to array
    // $simpleXml = simplexml_import_dom($dom);
    // $result = json_decode(json_encode($simpleXml), true);

    // // Manually fetch and insert raw CDATA content
    // $confirmationTextNodes = $dom->getElementsByTagName('confirmationText');
    // if ($confirmationTextNodes->length > 0) {
    //     $result['confirmationText_raw'] = $confirmationTextNodes->item(0)->nodeValue;
    // }

    public function test(){
        

        $roomBookingInformation = file_get_contents(public_path('roomsinfo.xml'));
        $roomBookingInformation =  XmlToArrayWithHTML($roomBookingInformation);
       


        $confirmationHtml = $roomBookingInformation['confirmationText_html'] ?? null;
      

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
                        $agentName = "Rajesh";
                        $cleanedHtml = str_replace(
                            '<p>Webbeds Customer Service</p>',
                            '<p>'.$agentName.'</p>',
                            $cleanedHtml
                        );
                          
                             return view('front_end.hotel.testhtml', ['htmlContent' => $cleanedHtml]);

















        
        $decodedJson = json_decode($jsonString, true); // decode as array

        $allRooms = $decodedJson['result']['hotel']['rooms']['room'] ?? [];

            


        $allRooms = $decodedJson['result']['hotel']['rooms']['room'] ?? [];
        
            $mergedRoomData = [];

            foreach ($allRooms as $roomIndex => $room) {
                foreach ($room['roomType'] as $roomType) {
                    $roomTypeCode = $roomType['_roomtypecode'];
                    $roomName = $roomType['name'];

                    foreach ($roomType['rateBases']['rateBasis'] as $rateBasis) {
                        $rateBasisId = $rateBasis['_id'];
                        $allocationDetails = $rateBasis['allocationDetails'];
                        $totalPrice = floatval($rateBasis['total']['__text']);

                        $key = $roomTypeCode . '_' . $rateBasisId;

                        if (!isset($mergedRoomData[$key])) {
                            $mergedRoomData[$key] = [
                                'roomTypeCode' => $roomTypeCode,
                                'roomName' => $roomName,
                                'rateBasisId' => $rateBasisId,
                                'total' => 0,
                                'allocationDetails' => [],
                                'roomCount' => 0
                            ];
                        }

                        // Merge totals and allocationDetails
                        $mergedRoomData[$key]['total'] += $totalPrice;
                        $mergedRoomData[$key]['allocationDetails'][] = $allocationDetails;
                        $mergedRoomData[$key]['roomCount'] += 1;
                    }
                }
            }

            $result = $mergedRoomData;

        dd($result) ;

    
   
    }
}
