<?php

namespace App\Http\Controllers\FrontEnd\Hotel\Xml;

use App\Models\DidaHotel;
use App\Models\HotelSearch;
use App\Models\WebbedsHotel;
use Illuminate\Http\Request;
use App\Models\WebbedsCountry;
use Illuminate\Support\Carbon;
use App\Models\WebbedsHotelSearch;
use App\Models\GtsHotel;
use App\Models\GtsCityHotel;
use App\Models\RestelHotelCode;
use App\Models\TdsHotel;
use App\Models\TdsHotelList;
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

    public function tdsCityDatafetch()
    {
        $xml = <<<EOM
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns="{$this->TdsXmlns}">
            <soapenv:Header/>
            <soapenv:Body>
                <CityList>
                    <CityListRQ Version="1.1" Language="en">
                        <Login Password="{$this->TdsPassword}" Email="{$this->TdsUsername}"/>
                    </CityListRQ>
                </CityList>
            </soapenv:Body>
        </soapenv:Envelope>
        EOM;
        $data = array(
            'xml' => $xml,
            'endPoint' => "staticdatatransactions.asmx"
        );
        $data = $this->TdsApiXmlRequestWithoutLog($data);
        return $data;
    }

    public function tdsHotelListDatafetch($nextToken = null, $recordsPerPage = 2)
    {
        $nextTokenAttr = !empty($nextToken) ? ' Token="' . htmlspecialchars($nextToken, ENT_XML1, 'UTF-8') . '"' : '';
        $recordsPerPageAttr = !empty($recordsPerPage) ? ' RecordsPerPage="' . $recordsPerPage . '"' : ' RecordsPerPage="2"';

        $xml = <<<EOM
                    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns="{$this->TdsXmlns}">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <HotelPortfolio>
                        <HotelPortfolioRQ Version="1.1" Language="en"{$recordsPerPageAttr}{$nextTokenAttr}>
                            <Login Password="{$this->TdsPassword}" Email="{$this->TdsUsername}"/>
                        </HotelPortfolioRQ>
                        </HotelPortfolio>
                    </soapenv:Body>
                    </soapenv:Envelope>
                EOM;
        $data = array(
            'xml' => $xml,
            'endPoint' => "staticdatatransactions.asmx"
        );
        $data = $this->TdsApiXmlRequestWithoutLog($data);
        return $data;
    }

    public function tdsHotelDetailDatafetch($hotelCodes = [], $request = null)
    {
        if (is_string($hotelCodes)) {
            $hotelCodes = [$hotelCodes];
        }

        $hotelTags = '';
        foreach ($hotelCodes as $code) {
            $code = trim($code);
            if (!empty($code)) {
                $hotelTags .= '<Hotel Code="' . htmlspecialchars($code, ENT_XML1, 'UTF-8') . '"/>' . "\n";
            }
        }

        if(isset($request['RatePlanCode'])){
            $hotelTags = '';
            $hotelTags .= '<Hotel RatePlanCode="'.$request['RatePlanCode'].'"/>' . "\n";
        }

        $xml = <<<EOM
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns="{$this->TdsXmlns}">
  <soapenv:Header/>
  <soapenv:Body>
    <HotelContent>
      <HotelContentRQ Version="1.1" Language="en">
        <Login Password="{$this->TdsPassword}" Email="{$this->TdsUsername}"/>
        <HotelContentList>
          {$hotelTags}
        </HotelContentList>
      </HotelContentRQ>
    </HotelContent>
  </soapenv:Body>
</soapenv:Envelope>
EOM;


        $data = array(
            'xml' => $xml,
            'skip_array' => true,
            'endPoint' => "staticdatatransactions.asmx"

        );
        $data = $this->TdsApiXmlRequestWithoutLog($data);
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


    // public function didaSearch(Request $request)
    // {
    //     // $cityCode = $request->input('hotelsCityCode');
    //     // $checkIn = $request->input('hotelsCheckIn');
    //     // $checkOut = $request->input('hotelsCheckOut');
    //     // $noOfRooms = (int) $request->input('noOfRooms', 1);
    //     // $nationality = $request->input('nationality', 'IN');
    //     // $currency = $request->input('currency', 'USD');
    //     $searchId = $request->input('search_request_id');
    //     $serachInfo = WebbedsHotelSearch::where('id', $searchId)->first();
    //     $nationality = WebbedsCountry::where('code', $serachInfo->nationality)->first()->alpha_code ?? 'IN';

    //     // $cityCode = $serachInfo->input('hotelsCityCode');
    //     $checkIn = $serachInfo->check_in;
    //     $checkOut = $serachInfo->check_out;
    //     $noOfRooms = (int) $serachInfo->no_of_rooms ?? 1;
    //     $currency = 'USD';


    //     $destinationCityCode = $serachInfo->dida_destination_code;
    //     $destinationCityCode = 3433; 
    //     if($request->input('hotel_code')){
    //         $hotelIds = [$request->input('hotel_code')];
    //     }else{
    //         $hotelIds = DidaHotel::where('destination_code', $destinationCityCode)->pluck('hotel_id')->toArray();
    //     }
    //     // dd($hotelIds);

        
    //     $rooms = json_decode($serachInfo->rooms_request,true);
    //     //dd($rooms);


    //     // Default occupancy
    //     $maxAdults = 0;
    //     $maxChildren = 0;
    //     $childAges = [];

    //      // Combine occupancy across rooms (per Dida spec)
    //     foreach ($rooms as $room) {
    //         $adults = (int)($room['Adults'] ?? 0);
    //         $children = (int)($room['Children'] ?? 0);
    //         $ages = $room['ChildrenAges'] ?? [];

    //         $maxAdults = max($maxAdults, $adults);
    //         $maxChildren = max($maxChildren, $children);
    //         $childAges = array_merge($childAges, $ages);
    //     }

    //     // Remove duplicates and limit to required number of children
    //     $childAges = array_slice(array_unique($childAges), 0, $maxChildren);

    //     $hotelIdsChunks = array_chunk($hotelIds, 50);
    //     $respList = [];
    //     foreach($hotelIdsChunks as $hotelIds){
    //         $data['payload'] = [
    //             "Header" => [
    //                 "ClientID" => env('DIDA_USERNAME', 'DidaApiTestID'),
    //                 "LicenseKey" => env('DIDA_PASSWORD', 'TestKey'),
    //             ],
    //             "HotelIDList" => $hotelIds,
    //             "CheckInDate" => $checkIn,
    //             "CheckOutDate" => $checkOut,
    //             "IsRealTime" => [
    //                 "Value" => true,
    //                 "RoomCount" => $noOfRooms,
    //             ],
    //             "RealTimeOccupancy" => [
    //                 "AdultCount" => $maxAdults,
    //                 "ChildCount" => $maxChildren,
    //                 "ChildAgeDetails" => $childAges,
    //             ],
    //             "Currency" => $currency,
    //             "Nationality" => $nationality,
    //         ];
    //         $data['end_point'] = 'rate/pricesearch';
    //         $data['serachId'] = $searchId;
    //         $data['method'] = 'POST';
    //         $data['request_type'] = 'search';
    //         $hotelSearchRsp = $this->DadiApi($data);
           
      
    //         if($hotelSearchRsp['status']){
    //             $hotels = $hotelSearchRsp['response']['Success']['PriceDetails']['HotelList'] ?? [];
    //             $respList = array_merge($respList, $hotels);
    //         }
            
    //     }
    //     return ['status' => true, 'response' => $respList];

        
        

    //    // return response()->json($payload, 200, [], JSON_PRETTY_PRINT);
    // }
    //updated code for dida search with parallel request execution and hotel details fetch
    public function didaSearch(Request $request)
    {
        $searchId = $request->input('search_request_id');

        $serachInfo = WebbedsHotelSearch::select(
            'nationality',
            'check_in',
            'check_out',
            'no_of_rooms',
            'dida_destination_code',
            'rooms_request'
        )->find($searchId);

        if (!$serachInfo) {
            return [
                'status' => false,
                'response' => [],
                'message' => 'Search record not found'
            ];
        }

        $nationality = WebbedsCountry::where(
            'code',
            $serachInfo->nationality
        )->value('alpha_code') ?? 'IN';

        $checkIn = $serachInfo->check_in;
        $checkOut = $serachInfo->check_out;
        $noOfRooms = (int) ($serachInfo->no_of_rooms ?: 1);
        $destinationCityCode = $serachInfo->dida_destination_code;
        if(env('APP_ENV') == 'local'){
            $destinationCityCode = 3433;
        }
        $currency = 'USD';

        /*
        |--------------------------------------------------------------------------
        | Hotel IDs
        |--------------------------------------------------------------------------
        */

        if ($request->filled('hotel_code')) {

            $hotelIds = [
                $request->input('hotel_code')
            ];

        } else {

            $hotelIds = DidaHotel::where(
                'destination_code',
                $destinationCityCode
            )
            ->pluck('hotel_id')
            ->all();
        }

        if (empty($hotelIds)) {
            return [
                'status' => true,
                'response' => []
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Room Occupancy
        |--------------------------------------------------------------------------
        */

        $rooms = json_decode(
            $serachInfo->rooms_request,
            true
        ) ?? [];

        $maxAdults = 0;
        $maxChildren = 0;
        $childAges = [];

        foreach ($rooms as $room) {

            $adults = (int) ($room['Adults'] ?? 0);
            $children = (int) ($room['Children'] ?? 0);

            $maxAdults = max($maxAdults, $adults);
            $maxChildren = max($maxChildren, $children);

            if (!empty($room['ChildrenAges'])) {
                $childAges = array_merge(
                    $childAges,
                    $room['ChildrenAges']
                );
            }
        }

        $childAges = array_slice(
            array_unique($childAges),
            0,
            $maxChildren
        );

        /*
        |--------------------------------------------------------------------------
        | Base Payload
        |--------------------------------------------------------------------------
        */

        $basePayload = [
            "Header" => [
                "ClientID" => env('DIDA_USERNAME', 'DidaApiTestID'),
                "LicenseKey" => env('DIDA_PASSWORD', 'TestKey'),
            ],
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

        /*
        |--------------------------------------------------------------------------
        | Build Requests
        |--------------------------------------------------------------------------
        */

        $hotelChunks = array_chunk($hotelIds, 50);

        $requests = [];

        foreach ($hotelChunks as $chunk) {

            $payload = $basePayload;
            $payload['HotelIDList'] = $chunk;

            $requests[] = [
                'payload' => $payload,
                'end_point' => 'rate/pricesearch',
                'searchId' => $searchId,
                'method' => 'POST',
                'request_type' => 'search',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Execute Requests In Parallel
        |--------------------------------------------------------------------------
        */

        $respList = [];

        // 5 concurrent requests at a time
        $requestGroups = array_chunk($requests, 8);

        foreach ($requestGroups as $group) {

            $responses = $this->DadiApiPool($group);

            foreach ($responses as $hotelSearchRsp) {

                if (
                    !empty($hotelSearchRsp['status']) &&
                    !empty(
                        $hotelSearchRsp['response']['Success']['PriceDetails']['HotelList']
                    )
                ) {

                    $respList = array_merge(
                        $respList,
                        $hotelSearchRsp['response']['Success']['PriceDetails']['HotelList']
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Return Result
        |--------------------------------------------------------------------------
        */

        return [
            'status' => true,
            'response' => $respList,
            'total_hotels' => count($respList)
        ];
    }


    public function didaSearch2(Request $request)
    {
        

        $data['payload'] = [
                "Header" => [
                    "ClientID" => env('DIDA_USERNAME', 'DidaApiTestID'),
                    "LicenseKey" => env('DIDA_PASSWORD', 'TestKey'),
                ],
               
                "CheckInDate" => $checkIn,
                "CheckOutDate" => $checkOut,
                "Destination" => [
                    "CityCode" => '6138970'
                ],
                
                "Currency" => $currency,
                "Nationality" => $nationality,
            ];
             $data['end_point'] = 'rate/pricesearch';
            $data['serachId'] = $searchId;
            $data['method'] = 'POST';
            $data['request_type'] = 'search';
            $hotelSearchRsp = $this->DadiApi($data);
            dd($hotelSearchRsp);
    }

    public function gtsSearch(Request $request)
    {
        $searchId = $request->input('search_request_id');

        $serachInfo = WebbedsHotelSearch::select(
            'nationality',
            'check_in',
            'check_out',
            'no_of_rooms',
            'rooms_request',
            'gts_code'
        )->find($searchId);

        if (!$serachInfo) {
            return [
                'status' => false,
                'response' => [],
                'message' => 'Search record not found'
            ];
        }

        $nationality = WebbedsCountry::where(
            'code',
            $serachInfo->nationality
        )->value('alpha_code') ?? 'IN';

        $checkIn = $serachInfo->check_in;
        $checkOut = $serachInfo->check_out;
        $noOfRooms = (int) ($serachInfo->no_of_rooms ?: 1);
        $currency = 'USD';

        if(env('APP_ENV') == 'local'){
            $GtsHotels = GtsHotel::orderBy('id', 'desc')->limit(100)->pluck('hotel_id')->toArray();
        }else{
            $GtsHotels = GtsCityHotel::where('city_code',$serachInfo->gts_code)->pluck('hotel_id')->toArray();
        }
        $GtsHotels = ["40011644"];
        $hotelIds = $GtsHotels;

        $rooms = json_decode($serachInfo->rooms_request, true) ?? [];

        $queryParams = [
            'currency' => $currency,
            'checkIn'  => $checkIn,
            'checkOut' => $checkOut,
            'hotelIds' => $hotelIds,
        ];

        if (!empty($nationality)) {
            $queryParams['nationality'] = $nationality;
        }

        foreach ($rooms as $index => $room) {
            $roomNum = $index + 1;
            $queryParams["room{$roomNum}AdultCount"] = (int) ($room['Adults'] ?? 1);
            if (!empty($room['Children']) && !empty($room['ChildrenAges'])) {
                $queryParams["room{$roomNum}ChildAges"] = $room['ChildrenAges'];
            }
        }

        $hotelChunks = array_chunk($hotelIds, 50);
        $requests = [];

        foreach ($hotelChunks as $chunk) {
            $chunkParams = $queryParams;
            $chunkParams['hotelIds'] = $chunk;

            $requests[] = [
                'query' => $chunkParams,
                'end_point' => 'hotels',
                'searchId' => $searchId,
                'method' => 'GET',
                'request_type' => 'search',
            ];
        }

        $respList = [];
        $requestGroups = array_chunk($requests, 8);

        foreach ($requestGroups as $group) {
            $responses = $this->GtsApiPool($group);

            foreach ($responses as $hotelSearchRsp) {
                if (
                    !empty($hotelSearchRsp['status']) &&
                    !empty($hotelSearchRsp['response']['hotels'])
                ) {
                    $token = $hotelSearchRsp['response']['token'];
                      foreach ($hotelSearchRsp['response']['hotels'] as $hotel) {
                        $hotel['token'] = $token;
                        $respList[] = $hotel;
                    }
                    // $respList = array_merge(
                    //     $respList,
                    //     $hotelSearchRsp['response']['hotels']
                    // );
                }
            }
        }

        return [
            'status' => true,
            'response' => $respList,
            'total_hotels' => count($respList)
        ];
    }
    public function gtsRooms(Request $request)
    {
        $searchId = $request->input('search_request_id');

        $serachInfo = WebbedsHotelSearch::select(
            'nationality',
            'check_in',
            'check_out',
            'no_of_rooms',
            'rooms_request'
        )->find($searchId);

        if (!$serachInfo) {
            return [
                'status' => false,
                'response' => [],
                'message' => 'Search record not found'
            ];
        }

        $nationality = WebbedsCountry::where(
            'code',
            $serachInfo->nationality
        )->value('alpha_code') ?? 'IN';

        $checkIn = $serachInfo->check_in;
        $checkOut = $serachInfo->check_out;
        $noOfRooms = (int) ($serachInfo->no_of_rooms ?: 1);
        $currency = 'USD';

   
        $hotelId = $request->input('hotel_code');

        $rooms = json_decode($serachInfo->rooms_request, true) ?? [];

        $queryParams = [
            'currency' => $currency,
            'checkIn'  => $checkIn,
            'checkOut' => $checkOut,
            // 'hotelId' => $hotelId,
        ];

        if (!empty($nationality)) {
            $queryParams['nationality'] = $nationality;
        }

        foreach ($rooms as $index => $room) {
            $roomNum = $index + 1;
            $queryParams["room{$roomNum}AdultCount"] = (int) ($room['Adults'] ?? 1);
            if (!empty($room['Children']) && !empty($room['ChildrenAges'])) {
                $queryParams["room{$roomNum}ChildAges"] = $room['ChildrenAges'];
            }
        }

        // $hotelChunks = array_chunk($hotelIds, 50);
      

        // foreach ($hotelChunks as $chunk) {
        //     $chunkParams = $queryParams;
        //     $chunkParams['hotelIds'] = $chunk;

        //     $requests[] = [
        //         'query' => $chunkParams,
        //         'end_point' => 'hotels',
        //         'searchId' => $searchId,
        //         'method' => 'GET',
        //         'request_type' => 'search',
        //     ];
        // }
      

     

        $requests = [
                'query' => $queryParams,
                'end_point' => 'hotels/'.$hotelId.'/directrooms',
                'searchId' => $searchId,
                'method' => 'GET',
                'request_type' => 'search',
            ];

        $responses = $this->GtsAPI($requests);
      

        return [
            'status' => true,
            'response' => $responses,
            'total_hotels' => count($responses)
        ];
    }

    public function restelSearch($serachInfo){
       
        
       
        $hotelCodesData         = RestelHotelCode::where('codpobhot', $serachInfo['restel_city_code'])->pluck('hot_codcobol')->toArray(); 
        $hotelsCode             = implode('#' , $hotelCodesData);
        $checkIn                = date('m/d/Y', strtotime($serachInfo['check_in']));
        $checkOut               = date('m/d/Y', strtotime($serachInfo['check_out']));
        $pais                   = $serachInfo['destination_country_code'];
        $pais_cliente           = $serachInfo['residency_alpha_code'];
        $afiliacion             = $this->RestelAfil;
        $usuario                = $this->RestelCodusu;
        $rooms                  = json_decode($serachInfo['rooms_request'] ,true);
       
        


        // STEP 1: group rooms
        $grouped = [];
        foreach ($rooms as $room) {
            // Fill missing child ages with default 11
            if ($room["Children"] > 0 && count($room["ChildrenAges"]) < $room["Children"]) {
                $missing = $room["Children"] - count($room["ChildrenAges"]);
                $room["ChildrenAges"] = array_merge($room["ChildrenAges"], array_fill(0, $missing, "11"));
            }
            $ages = implode(",", $room["ChildrenAges"]);
            $key = $room["Adults"] . "-" . $room["Children"] . "-" . $ages;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    "count" => 0,
                    "Adults" => $room["Adults"],
                    "Children" => $room["Children"],
                    "Ages" => $ages,
                ];
            }
            $grouped[$key]["count"]++;
        }

        $index = 1;
        $xml = <<<EOM
                <peticion>
                <tipo>110</tipo>
                <nombre>Servicio de disponibilidad por lista de hoteles</nombre>
                <agencia>AL MASILA GROUP INT`L B2B XML XML</agencia>
                    <parametros>
                        <hotel>$hotelsCode</hotel>
                        <pais>$pais</pais>
                        <pais_cliente>$pais_cliente</pais_cliente>
                        <fechaentrada>$checkIn</fechaentrada>
                        <fechasalida>$checkOut</fechasalida>
                        <afiliacion>$afiliacion</afiliacion>
                        <usuario>$usuario</usuario>
            EOM;
            foreach ($grouped as $room) {
                $xml .= <<<EOM

                            <numhab{$index}>{$room['count']}</numhab{$index}>
                            <paxes{$index}>{$room['Adults']}-{$room['Children']}</paxes{$index}>
                            <edades{$index}>{$room['Ages']}</edades{$index}>
                EOM;
                $index++;
            }
            $xml .= <<<EOM

                        <idioma>2</idioma>
                        <informacion_hotel>1</informacion_hotel>
                        <tarifas_reembolsables>1</tarifas_reembolsables>
                        <comprimido>2</comprimido>
                        <gastos>1</gastos>
                    </parametros>
                </peticion>
            EOM;

        $data = array(
            'xml' => $xml,
            'request_type' => 'search',
            'searchId' => $serachInfo['id']
        );
        //dd($data);
   
        $data = $this->RestelAPI($data);
        $data['searchId'] = $serachInfo['id'];
        return $data;
    }

    public function tdsSearch(Request $request)
    {
        $searchId = $request->input('search_request_id');

        $serachInfo = WebbedsHotelSearch::select(
            'id',
            'nationality',
            'residency',
            'check_in',
            'check_out',
            'no_of_rooms',
            'rooms_request',
            'tds_code',
            'city_code'
        )->find($searchId);

        if (!$serachInfo) {
            return [
                'status'   => false,
                'response' => [],
                'message'  => 'Search record not found'
            ];
        }

        $nationality = WebbedsCountry::where(
            'code',
            $serachInfo->nationality
        )->value('alpha_code') ?? 'ES';

        $checkIn = Carbon::parse($serachInfo->check_in)->format('Y-m-d');
        $checkOut = Carbon::parse($serachInfo->check_out)->format('Y-m-d');
        $noOfRooms = (int) ($serachInfo->no_of_rooms ?: 1);

        /*
        |--------------------------------------------------------------------------
        | Hotel Codes
        |--------------------------------------------------------------------------
        */
        if ($request->filled('hotel_code')) {
            $hotelCodes = [$request->input('hotel_code')];
        } else {
            $hotelCodes = TdsHotel::where('city_jpd_code', $serachInfo->tds_code)
                ->pluck('hotel_jp_code')
                ->filter()
                ->values()
                ->toArray();
            //$hotelCodes = ["JP046300", "JP077424", "JP046391", "JP046183"];
        }


        /*
        |--------------------------------------------------------------------------
        | Prepare Paxes & RelPaxesDist from rooms_request
        |--------------------------------------------------------------------------
        */
        $rooms = json_decode($serachInfo->rooms_request, true) ?? [];
        if (empty($rooms)) {
            $rooms = [
                ['Adults' => 1, 'Children' => 0, 'ChildrenAges' => []]
            ];
        }

        $paxXml = '';
        $relPaxesDistXml = '';
        $currentPaxId = 1;

        foreach ($rooms as $roomIndex => $room) {
            $adults = (int) ($room['Adults'] ?? 1);
            $children = (int) ($room['Children'] ?? 0);
            $childrenAges = $room['ChildrenAges'] ?? [];

            $roomPaxIds = [];

            // Adults
            for ($a = 0; $a < $adults; $a++) {
                $paxXml .= "          <Pax IdPax=\"{$currentPaxId}\"/>\n";
                $roomPaxIds[] = $currentPaxId;
                $currentPaxId++;
            }

            // Children
            for ($c = 0; $c < $children; $c++) {
                $childAge = isset($childrenAges[$c]) && is_numeric($childrenAges[$c]) ? (int) $childrenAges[$c] : 8;
                $paxXml .= "          <Pax IdPax=\"{$currentPaxId}\">\n            <Age>{$childAge}</Age>\n          </Pax>\n";
                $roomPaxIds[] = $currentPaxId;
                $currentPaxId++;
            }

            $relPaxesDistXml .= "            <RelPaxDist>\n              <RelPaxes>\n";
            foreach ($roomPaxIds as $pId) {
                $relPaxesDistXml .= "                <RelPax IdPax=\"{$pId}\"/>\n";
            }
            $relPaxesDistXml .= "              </RelPaxes>\n            </RelPaxDist>\n";
        }

        /*
        |--------------------------------------------------------------------------
        | Chunk Hotel Codes and Build Requests
        |--------------------------------------------------------------------------
        */
        $hotelChunks = array_chunk($hotelCodes, 250);
        $requests = [];

        foreach ($hotelChunks as $chunk) {
            $hotelCodesXml = '';
            foreach ($chunk as $hCode) {
                $hCode = htmlspecialchars(trim($hCode), ENT_XML1, 'UTF-8');
                if (!empty($hCode)) {
                    $hotelCodesXml .= "              <HotelCode>{$hCode}</HotelCode>\n";
                }
            }

            $xml = <<<EOM
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns="{$this->TdsXmlns}" Context="FULLAVAIL">
                <soapenv:Header/>
                <soapenv:Body>
                    <HotelAvail>
                    <HotelAvailRQ Version="1.1" Language="en">
                        <Login Email="{$this->TdsUsername}" Password="{$this->TdsPassword}"/>
                        <Paxes>
                {$paxXml}        </Paxes>
                        <HotelRequest>
                        <SearchSegmentsHotels>
                            <SearchSegmentHotels Start="{$checkIn}" End="{$checkOut}"/>
                            <CountryOfResidence>{$nationality}</CountryOfResidence>
                            <HotelCodes>
                {$hotelCodesXml}            </HotelCodes>
                        </SearchSegmentsHotels>
                        <RelPaxesDist>
                {$relPaxesDistXml}          </RelPaxesDist>
                        </HotelRequest>
                        <AdvancedOptions>
                        <ShowHotelInfo>false</ShowHotelInfo>
                        <ShowOnlyBestPriceCombination>true</ShowOnlyBestPriceCombination>
                        <TimeOut>8000</TimeOut>
                        </AdvancedOptions>
                    </HotelAvailRQ>
                    </HotelAvail>
                </soapenv:Body>
                </soapenv:Envelope>
                EOM;

            $requests[] = [
                'xml'          => $xml,
                'searchId'     => $searchId,
                'request_type' => 'search',
                'soap_action'  => 'HotelAvail',
                'endPoint' => "availtransactions.asmx"
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Execute Requests and Collect Results
        |--------------------------------------------------------------------------
        */
        $respList = [];

        if (count($requests) === 1) {
            $apiResult = $this->TdsAPI($requests[0]);
            $parsedHotels = $this->extractTdsHotelResults($apiResult['hotelResponse'] ?? null);
            if (!empty($parsedHotels)) {
                $respList = $parsedHotels;
            }
        } else {
            $requestGroups = array_chunk($requests, 5);
            foreach ($requestGroups as $group) {
                $responses = $this->TdsApiPool($group);
                foreach ($responses as $apiResult) {
                    $parsedHotels = $this->extractTdsHotelResults($apiResult['hotelResponse'] ?? null);
                    if (!empty($parsedHotels)) {
                        $respList = array_merge($respList, $parsedHotels);
                    }
                }
            }
        }

        return [
            'status'       => true,
            'response'     => $respList,
            'total_hotels' => count($respList)
        ];
    }

    public function extractTdsHotelResults($responseArray)
    {
        if (empty($responseArray) || !is_array($responseArray)) {
            return [];
        }

        $availRS = $responseArray['soap:Body']['HotelAvailResponse']['AvailabilityRS']
            ?? $responseArray['HotelAvailResponse']['AvailabilityRS']
            ?? $responseArray['AvailabilityRS']
            ?? $responseArray;

        $results = $availRS['Results']['HotelResult'] ?? null;
        if (empty($results)) {
            return [];
        }

        // If single hotel result
        if (isset($results['@attributes']) || isset($results['Code']) || isset($results['JPCode']) || isset($results['HotelOptions'])) {
            $results = [$results];
        }

        $hotels = [];
        foreach ($results as $hotel) {
            if (!is_array($hotel)) {
                continue;
            }
            $hotels[] = $hotel;
        }

        return $hotels;
    }
}
