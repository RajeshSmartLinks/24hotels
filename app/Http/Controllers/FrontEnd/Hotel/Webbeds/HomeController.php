<?php

namespace App\Http\Controllers\FrontEnd\Hotel\Webbeds;

use App\Models\SeoSettings;
use App\Models\WebbedsCity;
use App\Models\WebbedsHotel;
use Illuminate\Http\Request;
use App\Models\WebbedsCountry;
use App\Models\WebbedsHotelSearch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Hotel\Xml\SearchController;

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
                    $value['rooms']['room'][0]['roomType'] = nodeConvertion($value['rooms']['room'][0]['roomType']);
                    $value['rooms']['room'][0]['roomType'][0]['rateBases']['rateBasis'] = nodeConvertion($value['rooms']['room'][0]['roomType'][0]['rateBases']['rateBasis']);
                    $markup = hotelMarkUpPrice(array(
                        'totalPrice' => $value['rooms']['room'][0]['roomType'][0]['rateBases']['rateBasis'][0]['total'] , 'currencyCode' => 'KWD' , 'totalTax' => $value['rooms']['room'][0]['roomType'][0]['rateBases']['rateBasis'][0]['totalTaxes'] ?? 0));


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

    // public function CountryList(Request $request){
    //     $hotel = WebbedsCity::select('country_name')->groupBy('country_name')->get()->toArray();
    //     return $hotel;
    // }
}
