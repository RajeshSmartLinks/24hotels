<?php

namespace App\Http\Controllers\FrontEnd\Hotel\Webbeds;

use App\Models\Coupon;
use App\Models\Country;
use App\Models\SeoSettings;
use App\Models\WebbedsCity;
use App\Models\WebbedsHotel;
use Illuminate\Http\Request;
use App\Models\WebbedsCountry;
use Illuminate\Support\Carbon;
use App\Models\WebbedsHotelSearch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
                                        'total' => $rateBasis['total']
                                    ];
                                } else {
                                    // Already exists — add to total and append allocationDetails
                                    $roomInfo[$key]['total'] += $rateBasis['total'];
                                }
                            }
                        }
                    }
                    $roomInfo = array_values($roomInfo);

                    $markup = hotelMarkUpPrice(array('totalPrice' => $roomInfo[0]['total'] , 'currencyCode' => 'KWD' , 'totalTax' => $roomInfo[0]['totalTaxes'] ?? 0));


                //         	<rooms>
				// <room adults="1" children="2" childrenages="3,8" extrabeds="0">
				// 	<roomType roomtypecode="62754">
				// 		<name>DELUXE ROOM</name>
				// 		<rateBases>
				// 			<rateBasis id="0">
				// 				<rateType currencyid="769">1</rateType>
				// 				<total>37.3002</total>
				// 			</rateBasis>
				// 			<rateBasis id="1331">
				// 				<rateType currencyid="769">1</rateType>
				// 				<total>45.2931</total>
				// 			</rateBasis>
				// 		</rateBases>
				// 	</roomType>
				// </room>
                    
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
                    //dd($result['hotelList']);

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

                    //$value['Rooms'][0]['IsRefundable'] == 1 ? $refundableCount++ : $nonrefundableCount++;

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

        // $result['minPrice'] = $minPrice;
        // $result['maxPrice'] = $maxPrice;

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
        $searchId = decrypt($request->query('searchId'));
        // dd($hotelCode,$searchId);
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'hotelDetails','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];

        $rooms = new SearchController();
        $hotelDetailsAndRooms = $rooms->getRooms(['hotel_code' => $hotelCode ,'search_id' => $searchId]);


        // dd($hotelDetailsAndRooms);

        $result = [];

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
                $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'] = nodeConvertion($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType']);
                foreach($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'] as $rtk => $roomType){
                    $hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis'] = nodeConvertion($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'][$rk]['roomType'][$rtk]['rateBases']['rateBasis']);
                }
            }
            //after node convertion
            //room formation to single pricing

            foreach ($hotelDetailsAndRooms['allRooms']['hotel']['rooms']['room'] as $rk => $room) {
                foreach ($room['roomType'] as $rtk => $roomType) {
                    foreach ($roomType['rateBases']['rateBasis'] as $rbk => $rateBasis) {
                        $roomTypeCode = $roomType['@attributes']['roomtypecode'];
                        $rateBasisId = $rateBasis['@attributes']['id'];
                        $key = $roomTypeCode . '_' . $rateBasisId;

                        // Prepare allocation detail

                        $allocationDetail = $rateBasis['allocationDetails'];
                        if (!isset( $result['availablerooms'][$key])) {
                            // First time adding this combination
                             $result['availablerooms'][$key] = [
                                'name' => $roomType['name'],
                                'roomPromotion' => $rateBasis['@attributes']['description'],
                                'roomTypeCode' => $roomTypeCode,
                                'rateBasisId' => $rateBasisId,
                                'total' => $rateBasis['total'],
                                'roomPrice' => [$rateBasis['total']],
                                'allocationDetails' => [$allocationDetail]
                            ];
                        } else {
                            // Already exists — add to total and append allocationDetails
                            $result['availablerooms'][$key]['roomPrice'][] = $rateBasis['total'];
                            $result['availablerooms'][$key]['total'] += $rateBasis['total'];
                            if (!in_array($allocationDetail,  $result['availablerooms'][$key]['allocationDetails'])) {
                                 $result['availablerooms'][$key]['allocationDetails'][] = $allocationDetail;
                            }
                        }
                    }
                }
            }
            $result['availablerooms'] = array_values($result['availablerooms']);
            foreach($result['availablerooms'] as $r=>$room){
                $result['availablerooms'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  $room['total'] , 'currencyCode' => 'KWD' , 'totalTax' =>  0));
                $result['availablerooms'][$r]['allocationDetails'] = json_encode($result['availablerooms'][$r]['allocationDetails']);
                $bookingCode  = [ 'allocationDetails' => $result['availablerooms'][$r]['allocationDetails'] , 'code' => $result['availablerooms'][$r]['roomTypeCode'] , 'selectedRateBasis' => $result['availablerooms'][$r]['rateBasisId']];
                $result['availablerooms'][$r]['bookingCode'] = json_encode($bookingCode);

                // $result['availablerooms'][$r]['roomPromotion'] = [];
                $result['availablerooms'][$r]['CancelPolicies'] = [];
            }
            // foreach($result['availablerooms'] as $r=>$room){
            //     if(isset($room['Supplements']))
            //     {
            //         $supplments = $room['Supplements'];
            //         unset($result['availablerooms'][$r]['Supplements']);
            //         $supplmentAmout = 0.000;
            //         $currency = '';
            //         foreach ($supplments as $skey => $svalue) {
            //             if($svalue[0]['Type'] == 'AtProperty' && ($svalue[0]['Description'] == 'mandatory_fee' || $svalue[0]['Description'] == 'mandatory_tax'))
            //             {
            //                 $supplmentAmout+=$svalue[0]['Price'] ;
            //                 $currency = $svalue[0]['Currency'];

            //             }
                        
            //         }
            //         $result['availablerooms'][$r]['supplment_charges'] = $currency.' '.$supplmentAmout;
            //     }
            //     else{
            //         $result['availablerooms'][$r]['supplment_charges'] = null;
            //     }
            //     $result['availablerooms'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  isset($result['availablerooms'][$r]['RecommendedSellingRate']) ? $result['availablerooms'][$r]['RecommendedSellingRate'] : $result['availablerooms'][$r]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $result['availablerooms'][$r]['TotalTax']));
            //     unset($result['availablerooms'][$r]['TotalFare']);
            //     unset($result['availablerooms'][$r]['TotalTax']);
            //     $poilcy = $room['CancelPolicies'];
            //     unset($result['availablerooms'][$r]['CancelPolicies']);
            //     $calcelationPolicys = [];
            //     if(isset($poilcy)){
            //         foreach ($poilcy as $key => $value) {
            //             if($value['ChargeType'] == 'Percentage')
            //             {
            //                 $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'].'%';
            //             }else{
            //                 $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'];
            //             }
            //         }
            //     }
            //     $result['availablerooms'][$r]['CancelPolicies'] = $calcelationPolicys ;
            //     $result['availablerooms'][$r]['roomPromotion'] = isset($result['availablerooms'][$r]['RoomPromotion']) ? $result['availablerooms'][$r]['RoomPromotion'] :[];
            // }
        }

        //searchRequest 

        $result['searchRequest'] = WebbedsHotelSearch::find($searchId);
        $result['hotelCode'] = $hotelCode;
        //dd($result);

        return view('front_end.hotel.webbeds.details',compact('titles','result'));
        
    }

    public function PreBooking($hotelCode,$bookingCode,$searchId){

        //PreBooking
        $hotelCode = decrypt($hotelCode);
        $bookingCode = decrypt($bookingCode);
        $searchId = decrypt($searchId);
        // dd($hotelCode,$bookingCode,$searchId);

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
                }
            }
            //after node convertion
            //room formation to single pricing

            foreach ($prebookingDeatails['preBooking']['hotelResponse']['hotel']['rooms']['room'] as $rk => $room) {
                foreach ($room['roomType'] as $rtk => $roomType) {
                    foreach ($roomType['rateBases']['rateBasis'] as $rbk => $rateBasis) {
                        $roomTypeCode = $roomType['@attributes']['roomtypecode'];
                        $rateBasisId = $rateBasis['@attributes']['id'];
                        $key = $roomTypeCode . '_' . $rateBasisId;

                        // Prepare allocation detail

                        if($rateBasis['status'] == 'checked'){
                            $allocationDetail = $rateBasis['allocationDetails'];
                            if (!isset( $result['roomDetails'][$key])) {
                                // First time adding this combination
                                $result['roomDetails'][$key] = [
                                    'Name' => $roomType['name'],
                                    'roomPromotion' => $rateBasis['@attributes']['description'],
                                    'roomTypeCode' => $roomTypeCode,
                                    'rateBasisId' => $rateBasisId,
                                    'total' => $rateBasis['total'],
                                    'roomPrice' => [$rateBasis['total']],
                                    'allocationDetails' => [$allocationDetail],
                                    'Inclusion' => [],
                                    'supplment_charges' => []
                                ];
                            } else {
                                // Already exists — add to total and append allocationDetails
                                $result['roomDetails'][$key]['roomPrice'][] = $rateBasis['total'];
                                $result['roomDetails'][$key]['total'] += $rateBasis['total'];
                                if (!in_array($allocationDetail,  $result['roomDetails'][$key]['allocationDetails'])) {
                                    $result['roomDetails'][$key]['allocationDetails'][] = $allocationDetail;
                                }
                            }
                        }

                        
                    }
                }
            }
            $result['roomDetails'] = array_values($result['roomDetails']);
            foreach($result['roomDetails'] as $r=>$room){
                $result['roomDetails'][$r]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  $room['total'] , 'currencyCode' => 'KWD' , 'totalTax' =>  0));
                $result['roomDetails'][$r]['allocationDetails'] = json_encode($result['roomDetails'][$r]['allocationDetails']);
                $bookingCode  = [ 'allocationDetails' => $result['roomDetails'][$r]['allocationDetails'] , 'code' => $result['roomDetails'][$r]['roomTypeCode'] , 'selectedRateBasis' => $result['roomDetails'][$r]['rateBasisId']];
                $result['roomDetails'][$r]['bookingCode'] = json_encode($bookingCode);
                $result['roomDetails'][$r]['CancelPolicies'] = [];
            }
        }
        $result['roomDetails'] = $result['roomDetails'][0];
   
        
        
        
       
        //dd($prebookingDeatails['preBooking'][0]['Rooms'][0]);
        // if($prebookingDeatails['preBooking'][0]['Rooms'][0]){
        //     //$supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
        //     if(isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']))
        //     {
        //         $supplments = $prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements'];
        //         unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['Supplements']);
        //         $supplmentAmout = 0.000;
        //         $currency = '';
        //         foreach ($supplments as $skey => $svalue) {
        //             if($svalue[0]['Type'] == 'AtProperty' && ($svalue[0]['Description'] == 'mandatory_fee' || $svalue[0]['Description'] == 'mandatory_tax'))
        //             {
        //                 $supplmentAmout+=$svalue[0]['Price'] ;
        //                 $currency = $svalue[0]['Currency'];

        //             }
                 
        //         }
        //         $prebookingDeatails['preBooking'][0]['Rooms'][0]['supplment_charges'] = $currency.' '.$supplmentAmout;
        //     }
        //     else{
        //         $prebookingDeatails['preBooking'][0]['Rooms'][0]['supplment_charges'] = null;
        //     }

        //     $prebookingDeatails['preBooking'][0]['Rooms'][0]['markups'] = hotelMarkUpPrice(array('totalPrice' =>  
        //     isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RecommendedSellingRate'] : $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare'] , 'currencyCode' => 'USD' , 'totalTax' =>  $prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax']));
        //     unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalFare']);
        //     unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['TotalTax']);
        //     $poilcy = $prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies'];
        //     unset($prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies']);
        //     $calcelationPolicys = [];
        //     if(isset($poilcy)){
        //         foreach ($poilcy as $key => $value) {
        //             if($value['ChargeType'] == 'Percentage')
        //             {
        //                 $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'].'%';
        //             }else{
        //                 $calcelationPolicys[] = 'From '.$value['FromDate']. ' cancellation charge '.$value['CancellationCharge'];
        //             }
        //         }
        //     }
        //     $prebookingDeatails['preBooking'][0]['Rooms'][0]['CancelPolicies'] = $calcelationPolicys ;
        //     $prebookingDeatails['preBooking'][0]['Rooms'][0]['roomPromotion'] = isset($prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion']) ? $prebookingDeatails['preBooking'][0]['Rooms'][0]['RoomPromotion'] :[];

        // }
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
        $result['searchRequest'] = WebbedsHotelSearch::find($searchId);
        $result['searchRequest']->rooms_request = json_decode($result['searchRequest']->rooms_request,true);
        $result['bookingCode'] = $result['roomDetails']['bookingCode']??'';
        $result['hotelCode'] = $hotelCode;
        $result['searchId'] = $searchId;

        $currentDate = Carbon::now()->toDateString();
        $couponCodes = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->whereIn('coupon_valid_on' ,[1,3])->get();
        $result['couponCodes'] = $couponCodes;

        return view('front_end.hotel.webbeds.pre_booking',compact('titles','result'));
    }

    // public function CountryList(Request $request){
    //     $hotel = WebbedsCity::select('country_name')->groupBy('country_name')->get()->toArray();
    //     return $hotel;
    // }
}
