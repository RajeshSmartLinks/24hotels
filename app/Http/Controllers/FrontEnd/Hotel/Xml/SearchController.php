<?php

namespace App\Http\Controllers\FrontEnd\Hotel\Xml;

use App\Models\DidaHotel;
use App\Models\HotelSearch;
use App\Models\WebbedsHotel;
use Illuminate\Http\Request;
use App\Models\WebbedsCountry;
use Illuminate\Support\Carbon;
use App\Models\WebbedsHotelSearch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Hotel\StaticController;

class SearchController extends Controller
{
    //

    public function saticDatafetch($data)
    {
  
        $cityCode = $data['cityCode'];
        //$cityCode = '364';
     
        $from = $data['from'];
        $to = $data['to'];

        //Xml Prepration
        $xml = <<<EOM
        <customer>
            <username>$this->WebbedsUsername</username>
            <password>$this->WebbedsPassword</password>
            <id>$this->WebbedsCompanyCode</id>
            <source>1</source>
            <product>hotel</product>
            <request command="searchhotels">  
                <bookingDetails>  
                    <fromDate>$from</fromDate>
                    <toDate>$to</toDate>
                    <currency>769</currency> 
                    <rooms no="1">  
                        <room runno="0">  
                            <adultsCode>1</adultsCode>  
                            <children no="0"></children>  
                            <rateBasis>-1</rateBasis>  
                        </room>  
                    </rooms>  
                </bookingDetails>  
                <return> 
                    <filters xmlns:a="http://us.dotwconnect.com/xsd/atomicCondition" xmlns:c="http://us.dotwconnect.com/xsd/complexCondition">  
                        <city>$cityCode</city>  
                        <noPrice>true</noPrice>  
                    </filters>  
                    <fields>  
                        <field>preferred</field> 
                        <field>exclusive</field>
                        <field>description1</field>   
                        <field>hotelName</field>  
                        <field>address</field>  
                        <field>zipCode</field>  
                        <field>cityName</field>  
                        <field>cityCode</field>  
                        <field>countryName</field>  
                        <field>countryCode</field>  
                        <field>amenitie</field>
                        <field>hotelPhone</field>  
                        <field>hotelCheckIn</field>  
                        <field>hotelCheckOut</field>  
                        <field>rating</field>  
                        <field>images</field>  
                        <field>fireSafety</field>  
                        <field>hotelPreference</field>  
                        <field>geoPoint</field>  
                        <field>lastUpdated</field>  
                    </fields>  
                </return>  
            </request>
        </customer>
        EOM;
        $data = array(
            'xml' => $xml
        );
        $data = $this->XmlRequestWithoutLog($data);
        return $data;
    }

    public function Search(Request $request)
    {
        $searchId = $request->input('search_request_id');
        $serachInfo = WebbedsHotelSearch::where('id', $searchId)->first();
        $cityCode = $serachInfo->city_code ;
        $checkIn = $request->input('hotelsCheckIn');
        $checkOut = $request->input('hotelsCheckOut');
        $noOfRooms = (int) $request->input('noOfRooms');
        $nationality = $request->input('nationality');
        $residency = $request->input('residency');

        // $cityDetails = DB::table('webbeds_cities')->where('code',$cityCode)->first();
        // $noOfGuests = 0;
        //     //preprating json forrequest
            
        //     for ($i=1; $i <= $noOfRooms; $i++) { 
                
            
        //         $roomDetails = $request->input('room'.$i);
        //         $childrenAge = [];
        //         if(isset($roomDetails['childrenAge']) && count($roomDetails['childrenAge']) > 0)
        //         {
        //             $childrenAge = $roomDetails['childrenAge'];
        //         }
        //         $noOfGuests += $roomDetails['adult']; 
        //         $noOfGuests += $roomDetails['children'] ?? 0; 
        //         $hotelRequestArray['PaxRooms'][] = array( 
        //             "Adults" => $roomDetails['adult'],
        //             "Children" => $roomDetails['children'],
        //             "ChildrenAges"=> $childrenAge
        //         );
        //     }
        //     $CIn = Carbon::parse($checkIn);
        //     $COut =Carbon::parse($checkOut);

            //saving search request in HotelSearch table 
            // $hotelSearch = new WebbedsHotelSearch();
            // $hotelSearch->no_of_rooms = $request->input('noOfRooms');
            // $hotelSearch->no_of_nights    = $CIn->diffInDays($COut);
            // $hotelSearch->nationality    = $nationality;
            // $hotelSearch->residency    = $residency;
            // $hotelSearch->city_code    = $cityCode;
            // $hotelSearch->no_of_guests    = $noOfGuests;
            // $hotelSearch->city_name    = $cityDetails->name;
            // $hotelSearch->country = $cityDetails->country_name;
            // $hotelSearch->country_code = $cityDetails->country_code;
            // $hotelSearch->check_in = $checkIn;
            // $hotelSearch->check_out = $checkOut;
            // $hotelSearch->rooms_request = json_encode($hotelRequestArray['PaxRooms']);
            // $hotelSearch->ip_address = $_SERVER['REMOTE_ADDR'];
            // $hotelSearch->hotel_traveller_info = $request->input('hotels-travellers-class');
            // $hotelSearch->request_json = json_encode($request->input());
            // $hotelSearch->search_url = $request->input('search_url');
            // $hotelSearch->save();
        $xml = <<<EOM
        <customer>
            <username>{$this->WebbedsUsername}</username>
            <password>{$this->WebbedsPassword}</password>
            <id>{$this->WebbedsCompanyCode}</id>
            <source>1</source>
            <product>hotel</product>
            <request command="searchhotels">
                <bookingDetails>
                    <fromDate>{$checkIn}</fromDate>
                    <toDate>{$checkOut}</toDate>
                    <currency>769</currency>
                    <rooms no = "{$noOfRooms}">
        EOM;

        for ($i = 1; $i <= $noOfRooms; $i++) {
            $roomKey = 'room' . $i;
            $adults = (int) $request->input("{$roomKey}.adult", 0);
            $childrenCount = (int) $request->input("{$roomKey}.children", 0);
            $childrenAges = $request->input("{$roomKey}.childrenAge", []);

            $xml .= <<<EOM
                        <room runno="{$i}">
                            <adultsCode>{$adults}</adultsCode>
        EOM;

            if ($childrenCount > 0 && is_array($childrenAges)) {
                $xml .= "<children no=\"{$childrenCount}\">";
                foreach ($childrenAges as $index => $age) {
                    $xml .= "<child runno=\"{$index}\">{$age}</child>";
                }
                $xml .= "</children>";
            }
            else {
                $xml .= "<children no=\"0\" />";
            }

            $xml .= <<<EOM
                            <rateBasis>-1</rateBasis>
                            <passengerNationality>{$nationality}</passengerNationality>
                            <passengerCountryOfResidence>{$residency}</passengerCountryOfResidence>
                        </room>
        EOM;
        }

        $xml .= <<<EOM
                    </rooms>
                </bookingDetails>
                <return>
                    <filters>
                        <city>{$cityCode}</city>
                    </filters>
                </return>
            </request>
        </customer>
        EOM;
        // dd($xml);

        $data = array(
            'xml' => $xml,
            'request_type' => 'search',
            'searchId' => $request->input('search_id')
        );
        $data = $this->WebbedsApi($data);
        $data['searchId'] = $request->input('search_id');
        return $data;             
    } 

    public function fetchUnavailableHotels($data){

        $hotelIds = $data['hotelIds'];
        $cityCode = $data['cityCode'];
        $from = Carbon::today()->format('Y-m-d');
        $to = Carbon::tomorrow()->format('Y-m-d');

        if(!empty($hotelIds)){
            $chunks = array_chunk($hotelIds, 50);
            foreach ($chunks as $chunk) {
                //Xml Prepration
                $xml = <<<EOM
                    <customer>
                        <username>{$this->WebbedsUsername}</username>
                        <password>{$this->WebbedsPassword}</password>
                        <id>{$this->WebbedsCompanyCode}</id>
                        <source>1</source>
                        <product>hotel</product>
                        <request command="searchhotels">
                            <bookingDetails>
                                <fromDate>{$from}</fromDate>
                                <toDate>{$to}</toDate>
                                <currency>769</currency>
                                <rooms>
                                    <room runno="0">
                                        <adultsCode>1</adultsCode>
                                        <children no="0"></children>
                                        <rateBasis>-1</rateBasis>
                                    </room>
                                </rooms>
                            </bookingDetails>
                            <return>
                                <filters xmlns:a="http://us.dotwconnect.com/xsd/atomicCondition" xmlns:c="http://us.dotwconnect.com/xsd/complexCondition">
                                    <city>{$cityCode}</city>
                                    <noPrice>true</noPrice>
                                    <c:condition>
                                        <a:condition>
                                            <fieldName>hotelId</fieldName>
                                            <fieldTest>in</fieldTest>
                                            <fieldValues>
                    EOM;

                    foreach ($chunk as $hotelId) {
                        $xml .= "<fieldValue>{$hotelId}</fieldValue>";
                    }

                    $xml .= <<<EOM
                                            </fieldValues>
                                        </a:condition>
                                    </c:condition>
                                </filters>
                                <fields>
                                    <field>preferred</field>
                                    <field>exclusive</field>
                                    <field>description1</field>
                                    <field>hotelName</field>
                                    <field>address</field>
                                    <field>zipCode</field>
                                    <field>cityName</field>
                                    <field>cityCode</field>
                                    <field>countryName</field>
                                    <field>countryCode</field>
                                    <field>amenitie</field>
                                    <field>hotelPhone</field>
                                    <field>hotelCheckIn</field>
                                    <field>hotelCheckOut</field>
                                    <field>rating</field>
                                    <field>images</field>
                                    <field>fireSafety</field>
                                    <field>hotelPreference</field>
                                    <field>geoPoint</field>
                                    <field>lastUpdated</field>
                                </fields>
                            </return>
                        </request>
                    </customer>
                    EOM;
                $data = array(
                    'xml' => $xml
                );
                 $HotelsInfo = $this->XmlRequestWithoutLog($data);
                // $HotelsInfo = $this->WebbedsApi($data);
                if($HotelsInfo['success'])
                {
                    $HotelsInfo['hotels']['hotel'] = nodeConvertion($HotelsInfo['hotels']['hotel']);
                    foreach($HotelsInfo['hotels']['hotel'] as $hotelInfo)
                    {
                        $staticController = new StaticController();
                        $staticController->storeHotel($hotelInfo);
                    }
                }
            }
        }

    }

    public function getRooms($data)
    {
        //hotel details 
        $hotel_code = $data['hotel_code'];
        $hotelDetails = WebbedsHotel::where('hotel_code', $data['hotel_code'])->firstOrFail()->toArray();
        $searchId = $data['search_id'];


        //hotel room details
        $searchRequest = WebbedsHotelSearch::find($data['search_id']);
      


        $cityCode = $searchRequest->city_code;
        $checkIn = $searchRequest->check_in;
        $checkOut = $searchRequest->check_out;
        $noOfRooms = (int) $searchRequest->no_of_rooms;
        $nationality = $searchRequest->nationality;
        $residency = $searchRequest->residency;

        $roomRequest = json_decode($searchRequest->rooms_request,true);

    
     
           
        $xml = <<<EOM
        <customer>
            <username>{$this->WebbedsUsername}</username>
            <password>{$this->WebbedsPassword}</password>
            <id>{$this->WebbedsCompanyCode}</id>
            <source>1</source>
            <product>hotel</product>
            <request command="getrooms">
                <bookingDetails>
                    <fromDate>{$checkIn}</fromDate>
                    <toDate>{$checkOut}</toDate>
                    <currency>769</currency>
                    <rooms no="{$noOfRooms}">
        EOM;

            for ($i = 0; $i < $noOfRooms; $i++) {
                $roomData = $roomRequest[$i];
                $adults = (int) $roomData['Adults'];
                $childrenCount = (int) $roomData['Children'];
                $childrenAges = $roomData['ChildrenAges'];

            $xml .= <<<EOM
                        <room runno="{$i}">
                            <adultsCode>{$adults}</adultsCode>
        EOM;

            if ($childrenCount > 0 && is_array($childrenAges)) {
                $xml .= "<children no=\"{$childrenCount}\">";
                foreach ($childrenAges as $index => $age) {
                    $xml .= "<child runno=\"{$index}\">{$age}</child>";
                }
                $xml .= "</children>";
            }
            else {
                $xml .= "<children no=\"0\" />";
            }

            $xml .= <<<EOM
                            <rateBasis>-1</rateBasis>
                            <passengerNationality>{$nationality}</passengerNationality>
                            <passengerCountryOfResidence>{$residency}</passengerCountryOfResidence>
                        </room>
        EOM;
        }

        $xml .= <<<EOM
                    </rooms>
                     <productId>$hotel_code</productId>
                </bookingDetails>
            </request>
        </customer>
        EOM;
    

        $data = array(
            'xml' => $xml,
            'request_type' => 'getRooms',
            'searchId' => $searchId
        );
        $data = $this->WebbedsApi($data);
     
        return [
            'hotelDetails' => $hotelDetails ,
            'allRooms' =>  $data['hotelResponse'],
            'success' => isset($data['hotelResponse']['successful']) ?   $data['hotelResponse']['successful'] : false,
            'searchId' => $searchId
        ];

    } 


    public function didaSearch(Request $request)
    {
        // $cityCode = $request->input('hotelsCityCode');
        // $checkIn = $request->input('hotelsCheckIn');
        // $checkOut = $request->input('hotelsCheckOut');
        // $noOfRooms = (int) $request->input('noOfRooms', 1);
        // $nationality = $request->input('nationality', 'IN');
        // $currency = $request->input('currency', 'USD');
        $searchId = $request->input('search_request_id');
        $serachInfo = WebbedsHotelSearch::where('id', $searchId)->first();
        $nationality = WebbedsCountry::where('code', $serachInfo->nationality)->first()->alpha_code ?? 'IN';

        // $cityCode = $serachInfo->input('hotelsCityCode');
        $checkIn = $serachInfo->check_in;
        $checkOut = $serachInfo->check_out;
        $noOfRooms = (int) $serachInfo->no_of_rooms ?? 1;
        $currency = 'USD';


        $destinationCityCode = $serachInfo->dida_destination_code;
        //$destinationCityCode = 3433; 
        if($request->input('hotel_code')){
            $hotelIds = [$request->input('hotel_code')];
        }else{
            $hotelIds = DidaHotel::where('destination_code', $destinationCityCode)->pluck('hotel_id')->toArray();
        }
        // dd($hotelIds);

        
        $rooms = json_decode($serachInfo->rooms_request,true);
        //dd($rooms);


        // Default occupancy
        $maxAdults = 0;
        $maxChildren = 0;
        $childAges = [];

         // Combine occupancy across rooms (per Dida spec)
        foreach ($rooms as $room) {
            $adults = (int)($room['Adults'] ?? 0);
            $children = (int)($room['Children'] ?? 0);
            $ages = $room['ChildrenAges'] ?? [];

            $maxAdults = max($maxAdults, $adults);
            $maxChildren = max($maxChildren, $children);
            $childAges = array_merge($childAges, $ages);
        }

        // Remove duplicates and limit to required number of children
        $childAges = array_slice(array_unique($childAges), 0, $maxChildren);

        $hotelIdsChunks = array_chunk($hotelIds, 50);
        $respList = [];
        foreach($hotelIdsChunks as $hotelIds){
            $data['payload'] = [
                "Header" => [
                    "ClientID" => env('DIDA_USERNAME', 'DidaApiTestID'),
                    "LicenseKey" => env('DIDA_PASSWORD', 'TestKey'),
                ],
                "HotelIDList" => $hotelIds,
                "CheckInDate" => $checkIn,
                "CheckOutDate" => $checkOut,
                "IsRealTime" => [
                    "Value" => true,
                    "RoomCount" => $noOfRooms,
                ],
                "RealTimeOccupancy" => [
                    "AdultCount" => $maxAdults,
                    "ChildCount" => $maxChildren,
                    "ChildAgeDetails" => $childAges,
                ],
                "Currency" => $currency,
                "Nationality" => $nationality,
            ];
            $data['end_point'] = 'rate/pricesearch';
            $data['serachId'] = $searchId;
            $data['method'] = 'POST';
            $data['request_type'] = 'search';
            $hotelSearchRsp = $this->DadiApi($data);
           
      
            if($hotelSearchRsp['status']){
                $hotels = $hotelSearchRsp['response']['Success']['PriceDetails']['HotelList'] ?? [];
                $respList = array_merge($respList, $hotels);
            }
            
        }
        return ['status' => true, 'response' => $respList];

        
        

       // return response()->json($payload, 200, [], JSON_PRETTY_PRINT);
    }

}
