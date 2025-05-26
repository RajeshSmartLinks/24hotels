<?php

namespace App\Http\Controllers\Air;

use SoapClient;
use DOMDocument;
use SimpleXMLElement;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\TravelportRequest;

class SearchController extends Controller
{
    public function Search(Request $request)
    {
        $OriginCityOrAirport = $request->input('flightFromAirportCode');
        $DestinationCityOrAirport = $request->input('flightToAirportCode');
        $SearchDepTime = $request->input('DepartDate');
        $ReturnDate = $request->input('ReturnDate');
        
        $noofAdults = $request->input('noofAdults');
        $noofChildren = $request->input('noofChildren');
        $noofInfants = $request->input('noofInfants');
        $flightClass = $request->input('flight-class');

        $lastTravelportRequest = TravelportRequest::latest()->first();
        $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();
        $trace_id  = $lastId + 1;

        //Xml prepration
        
        $xml = <<<EOM
        <soapenv:Envelope xmlns:soapenv="$this->soapenvelope">
        <soapenv:Header/>
        EOM;
        $xml .=<<<EOM
        <soapenv:Body>
            <LowFareSearchReq xmlns="$this->airXmlns"  TargetBranch="$this->TragetBranch" TraceId="$trace_id" ReturnUpsellFare="true">
                <BillingPointOfSaleInfo xmlns="$this->commonXmlns" OriginApplication="uAPI" />
                <SearchAirLeg>
                    <SearchOrigin>
                        <CityOrAirport xmlns="$this->commonXmlns" Code="$OriginCityOrAirport" PreferCity="true"/>
                    </SearchOrigin>
                    <SearchDestination>
                        <CityOrAirport xmlns="$this->commonXmlns" Code="$DestinationCityOrAirport" PreferCity="true"/>
                    </SearchDestination>
                    <SearchDepTime PreferredTime="$SearchDepTime" />
                </SearchAirLeg>
        EOM; 
        if($request->input('flight-trip') == 'roundtrip' && ($ReturnDate != "" ))
        {
            $xml .=<<<EOM
                <SearchAirLeg>
                    <SearchOrigin>
                        <CityOrAirport xmlns="$this->commonXmlns" Code="$DestinationCityOrAirport" PreferCity="true"/>
                    </SearchOrigin>
                    <SearchDestination>
                        <CityOrAirport xmlns="$this->commonXmlns" Code="$OriginCityOrAirport" PreferCity="true"/>
                    </SearchDestination>
                    <SearchDepTime PreferredTime="$ReturnDate" />
                </SearchAirLeg>
            EOM;    
        }
        $xml .=<<<EOM
                <AirSearchModifiers>
                    <PreferredProviders>
                        <Provider xmlns="$this->commonXmlns" Code="1G" />
                    </PreferredProviders>
                    <PermittedCabins>
                        <CabinClass  xmlns="$this->commonXmlns" Type="$flightClass" />
                    </PermittedCabins>
                </AirSearchModifiers>
        EOM;
        for($i = 1 ; $i <=$noofAdults ; $i++ )
        {
            $key = $BookingTravelerRef = $trace_id.'ADT'.$i;
            $xml .=<<<EOM
                <SearchPassenger xmlns="$this->commonXmlns" Code="ADT"  Key="$key" BookingTravelerRef = "$BookingTravelerRef"/>
        EOM;
        }
        for($k = 1 ; $k <=$noofInfants ; $k++ )
        {
            $key = $BookingTravelerRef = $trace_id.'INF'.$k;
            $xml .=<<<EOM
                <SearchPassenger xmlns="$this->commonXmlns" Code="INF"  Key="$key" BookingTravelerRef = "$BookingTravelerRef" Age ="1"/>
        EOM;
        }
        for($j = 1 ; $j <=$noofChildren ; $j++ )
        {
            $key = $BookingTravelerRef = $trace_id.'CNN'.$j;
            $xml .=<<<EOM
                <SearchPassenger xmlns="$this->commonXmlns" Code="CNN"  Key="$key" BookingTravelerRef = "$BookingTravelerRef" Age ="10"/>
        EOM;
        }
       
        $xml .=<<<EOM
                <AirPricingModifiers   xmlns="$this->airXmlns" SellCheck="true" FaresIndicator="AllFares"></AirPricingModifiers>
            </LowFareSearchReq>
        </soapenv:Body>
        </soapenv:Envelope>
        EOM;

        $data = array(
            'xml' => $xml,
            'trace_id' => $trace_id,
            'request_type' => 'search'
        );
        //dd($xml);
        $data = $this->TravelportAirApi($data);
        return $data;
         
    }
// 46
//     <AirLegModifiers>
//     <PermittedCabins>
//         <CabinClass  xmlns="$this->commonXmlns" Type="$flightClass" />
//     </PermittedCabins>
// </AirLegModifiers>
// 107
// <AccountCodes>
// <AccountCode xmlns="$this->commonXmlns" Code="-" />
// </AccountCodes>

    public function serachPnr(Request $request)
    {
        $pnr = $request->input('pnr');
        $lastTravelportRequest = TravelportRequest::latest()->first();
        $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();
        $trace_id  = $lastId + 1;
                //Xml prepration
                $xml = <<<EOM
                <soapenv:Envelope xmlns:soapenv="$this->soapenvelope">
                <soapenv:Header/>
                    <soapenv:Body>
                        <UniversalRecordRetrieveReq xmlns="$this->universalXmlns" TraceId="$trace_id" TargetBranch="$this->TragetBranch">
                            <BillingPointOfSaleInfo xmlns="$this->commonXmlns" OriginApplication="uAPI" />
                            <UniversalRecordLocatorCode>$pnr</UniversalRecordLocatorCode>
                        </UniversalRecordRetrieveReq>
                    </soapenv:Body>
                </soapenv:Envelope>
                EOM;

        $data = array(
            'xml' => $xml,
            'trace_id' => $trace_id,
            'request_type' => 'pnr_search'
        );
       // dd($xml);
        $data = $this->TravelportAirApi($data);
        return $data;
    }

    //airarabia

    public function airArabiaSearch(Request $request)
    {
        if($request->input('flight-class') == 'Economy' || $request->input('flight-class') == 'Business')
        {
            $OriginCityOrAirport = $request->input('flightFromAirportCode');
            $DestinationCityOrAirport = $request->input('flightToAirportCode');
            $SearchDepTime = $request->input('DepartDate') .'T00:00:00';
            $ReturnDate = $request->input('ReturnDate').'T00:00:00';
            $noofAdults = $request->input('noofAdults');
            $noofChildren = $request->input('noofChildren');
            $noofInfants = $request->input('noofInfants');
            $flightClass = $request->input('flight-class');
            $flightClass = ($flightClass == 'Economy') ? 'Y' : 'C';
            

            $lastTravelportRequest = TravelportRequest::latest()->first();
            $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();
            $trace_id  = $lastId + 1;

        //Xml prepration
        
        $xml = <<<EOM
        <soap:Envelope xmlns:soap="$this->soapenvelope" xmlns:xsd="$this->w3Org" xmlns:xsi="$this->w3Org-instance">
        <soap:Header>
            <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken wsu:Id="UsernameToken-17855236" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:Username>$this->AirArabiaUsername</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">$this->AirArabiaPassword</wsse:Password>
            </wsse:UsernameToken>
            </wsse:Security>
        </soap:Header>
        EOM;
        $xml .=<<<EOM
        <soap:Body  xmlns:ns2="http://www.opentravel.org/OTA/2003/05">
            <ns2:OTA_AirAvailRQ EchoToken="11868765275150-1300257933" PrimaryLangID="en-us" SequenceNmbr="1" Target="TEST" TimeStamp="2023-01-09T04:55:27" Version="20061.00">
            <ns2:POS>
                <ns2:Source TerminalID="TestUser/Test Runner">
                <ns2:RequestorID ID="$this->AirArabiaUsername" Type="4" />
                <ns2:BookingChannel Type="12" />
                </ns2:Source>
            </ns2:POS>
            <ns2:OriginDestinationInformation>
                <ns2:DepartureDateTime>$SearchDepTime</ns2:DepartureDateTime>
                <ns2:OriginLocation LocationCode="$OriginCityOrAirport" />
                <ns2:DestinationLocation LocationCode="$DestinationCityOrAirport" />
                <ns2:TravelPreferences>
                    <ns2:CabinPref PreferLevel="Preferred" Cabin="$flightClass" />
                </ns2:TravelPreferences>
            </ns2:OriginDestinationInformation>
        EOM; 
        if($request->input('flight-trip') == 'roundtrip' && ($ReturnDate != "" ))
        {
        $xml .= <<<EOM
            <ns2:OriginDestinationInformation>
                <ns2:DepartureDateTime>$ReturnDate</ns2:DepartureDateTime>
                <ns2:OriginLocation LocationCode="$DestinationCityOrAirport" />
                <ns2:DestinationLocation LocationCode="$OriginCityOrAirport" />
                <ns2:TravelPreferences>
                    <ns2:CabinPref PreferLevel="Preferred" Cabin="$flightClass" />
                </ns2:TravelPreferences>
            </ns2:OriginDestinationInformation>
        EOM;

        }
       
        $xml .=<<<EOM
            <ns2:TravelerInfoSummary>
                <ns2:AirTravelerAvail>   
        EOM;
        if(isset($noofAdults) && $noofAdults > 0)
        {
            $xml .=<<<EOM
                <ns2:PassengerTypeQuantity Code="ADT" Quantity="$noofAdults" />
        EOM;
        }
        if(isset($noofChildren) && $noofChildren > 0)
        {
            $xml .=<<<EOM
                <ns2:PassengerTypeQuantity Code="CHD" Quantity="$noofChildren" />
        EOM;
        }
        if(isset($noofInfants) && $noofInfants > 0)
        {
            $xml .=<<<EOM
                <ns2:PassengerTypeQuantity Code="INF" Quantity="$noofInfants" />
        EOM;
        }
       
        $xml .=<<<EOM
                    </ns2:AirTravelerAvail>
                </ns2:TravelerInfoSummary>
            </ns2:OTA_AirAvailRQ>
        </soap:Body>
        </soap:Envelope>
        EOM;

        $data = array(
            'xml' => $xml,
            'trace_id' => $trace_id,
            'request_type' => 'search',
        );
        // dd($xml);
        $data = $this->AirArabiaApi($data);
        return $data;
        }
        else{
            return array('error' => 'no flights');

        }
        
    }
    

    //Jazeera
    public function prepareSearchBodyForJazeera(Request $request)
    {
        $tripType = $request->input('flight-trip');
        if ($tripType === 'onewaytrip') {
            $data = $this->prepareOnewayTripSearchBodyForJazeera($request);
        } else {
            $data = $this->prepareRoundTripSearchBodyForJazeera($request);
        }
        return $data;        
    }

    public function prepareOnewayTripSearchBodyForJazeera($request){
        $requestFrom = "WEB";
        if(!empty($request->input('requestFrom'))){
            $requestFrom = $request->input('requestFrom');
        }
        $noOfAdults                 = $request->input('noofAdults') ? (int) $request->input('noofAdults') : null;
        $noOfChildren               = $request->input('noofChildren') ? (int) $request->input('noofChildren') : null;
        $noOfInfants                = $request->input('noofInfants') ? (int) $request->input('noofInfants') : null;
        $passengerCount             = $noOfAdults + $noOfChildren + $noOfInfants;

        $originStationCode          = $request->input('flightFromAirportCode') ? $request->input('flightFromAirportCode') : null;
        $destinationStationCode     = $request->input('flightToAirportCode') ? $request->input('flightToAirportCode') : null;
        $beginDate                  = $request->input('DepartDate') ? $request->input('DepartDate') : null;

        $maxConnections             = 10;
        $compressionType            = "CompressByProductClass";
        $productClass               = [$request->input('flight-travellers-class') ? $request->input('flight-travellers-class') : null];
        $fareType                   = [""];
        $ssrCollectionsMode         = "None";

        $promotionCode              = "";
        $currencyCode               = "";

        $numberOfFaresPerJourney    = 0;
        $taxesAndFees               = "TaxesAndFees";

        $passengerTypes             = [];

        // Add adult passenger type
        if ($noOfAdults !== null && $noOfAdults > 0) {
            $passengerTypes[] = [
                "type" => "ADT",
                "count" => $noOfAdults
            ];
        }

        // Add child passenger type
        if ($noOfChildren !== null && $noOfChildren > 0) {
            $passengerTypes[] = [
                "type" => "CHD",
                "count" => $noOfChildren
            ];
        }

        // Add infant passenger type
        if ($noOfInfants !== null && $noOfInfants > 0) {
            $passengerTypes[] = [
                "type" => "INF",
                "count" => $noOfInfants
            ];
        }

        $body = [
            "passengers" => [
                "types" => $passengerTypes
            ],
            "criteria" => [
                [
                    "stations" => [
                        "destinationStationCodes" => [
                            $destinationStationCode
                        ],
                        "originStationCodes" => [
                            $originStationCode
                        ],
                        "searchDestinationMacs" => true,
                        "searchOriginMacs" => true
                    ],
                    "dates" => [
                        "beginDate" => $beginDate
                    ],
                    "filters" => [
                        "fareInclusionType" => "Default",
                        "compressionType" => $compressionType,
                        "maxPrice" => 0,
                        "minPrice" => 0,
                        "loyalty" => "MonetaryOnly",
                        "includeAllotments" => true,
                        "exclusionType" => "Default",
                        "sortOptions" => [
                            "ServiceType"
                        ],
                        "carrierCode" => "J9",
                        "type" => "None",
                        "connectionType" => "None",
                        "maxConnections" => $maxConnections
                    ],
                    "lowFarePrice" => 0,
                    "ssrCollectionsMode" => $ssrCollectionsMode
                ]
            ],
            "codes" => [
                "currencyCode" => $currencyCode
            ],
            "numberOfFaresPerJourney" => $numberOfFaresPerJourney,
            "taxesAndFees" => $taxesAndFees
        ];

        $lastTravelportRequest = TravelportRequest::latest()->first();
        $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();
        $trace_id  = $lastId + 1;
        $data = array(
            'jsonRequest' => $body,
            'trace_id' => $trace_id,
            'endpoint' => 'Availability',
            'request_type' => 'search',
            'requestFrom' => $requestFrom,
        );
        
        $data = $this->postMethodForJazeera($data);

        return $data;
    }

    public function prepareRoundTripSearchBodyForJazeera(Request $request){
        $requestFrom = "WEB";
        if(!empty($request->input('requestFrom'))){
            $requestFrom = $request->input('requestFrom');
        }
        $noOfAdults                 = $request->input('noofAdults') ? (int) $request->input('noofAdults') : null;
        $noOfChildren               = $request->input('noofChildren') ? (int) $request->input('noofChildren') : null;
        $noOfInfants                = $request->input('noofInfants') ? (int) $request->input('noofInfants') : null;
        $passengerCount             = $noOfAdults + $noOfChildren + $noOfInfants;

        $originStationCode          = $request->input('flightFromAirportCode') ? $request->input('flightFromAirportCode') : null;
        $destinationStationCode     = $request->input('flightToAirportCode') ? $request->input('flightToAirportCode') : null;
        $beginDate                  = $request->input('DepartDate') ? $request->input('DepartDate') : null;
        $returnDate                  = $request->input('ReturnDate') ? $request->input('ReturnDate') : null;

        
        $maxConnections             = 10;
        $compressionType            = "CompressByProductClass";
        $productClass               = [$request->input('flight-travellers-class') ? $request->input('flight-travellers-class') : null];
        $fareType                   = [""];
        $ssrCollectionsMode         = "None";

        $promotionCode              = "";
        $currencyCode               = "";

        $numberOfFaresPerJourney    = 0;
        $taxesAndFees               = "TaxesAndFees";

        $passengerTypes             = [];

        // Add adult passenger type
        if ($noOfAdults !== null && $noOfAdults > 0) {
            $passengerTypes[] = [
                "type" => "ADT",
                "count" => $noOfAdults
            ];
        }

        // Add child passenger type
        if ($noOfChildren !== null && $noOfChildren > 0) {
            $passengerTypes[] = [
                "type" => "CHD",
                "count" => $noOfChildren
            ];
        }

        // Add infant passenger type
        if ($noOfInfants !== null && $noOfInfants > 0) {
            $passengerTypes[] = [
                "type" => "INF",
                "count" => $noOfInfants
            ];
        }

       $body = [
            "passengers" => [
                "types" => $passengerTypes
            ],
            "criteria" => [
                [
                    "stations" => [
                        "destinationStationCodes" => [$destinationStationCode ?: ""],
                        "originStationCodes" => [$originStationCode ?: ""],
                        "searchDestinationMacs" => true,
                        "searchOriginMacs" => true
                    ],
                    "dates" => [
                        "beginDate" => $beginDate ?: ""
                    ],
                    "filters" => [
                        "fareInclusionType" => "Default",
                        "compressionType" => $compressionType,
                        "maxPrice" => 0,
                        "minPrice" => 0,
                        "loyalty" => "MonetaryOnly",
                        "includeAllotments" => true,
                        "exclusionType" => "Default",
                        "sortOptions" => ["ServiceType"],
                        "carrierCode" => "J9",
                        "type" => "None",
                        "connectionType" => "None",
                        "maxConnections" => $maxConnections
                    ],
                    "lowFarePrice" => 0,
                    "ssrCollectionsMode" => $ssrCollectionsMode
                ],
                [
                    "stations" => [
                        "destinationStationCodes" => [$originStationCode ?: ""],
                        "originStationCodes" => [$destinationStationCode ?: ""],
                        "searchDestinationMacs" => true,
                        "searchOriginMacs" => true
                    ],
                    "dates" => [
                        "beginDate" => $returnDate ?: ""
                    ],
                    "filters" => [
                        "fareInclusionType" => "Default",
                        "compressionType" => $compressionType,
                        "maxPrice" => 0,
                        "minPrice" => 0,
                        "loyalty" => "MonetaryOnly",
                        "includeAllotments" => true,
                        "exclusionType" => "Default",
                        "sortOptions" => ["ServiceType"],
                        "carrierCode" => "J9",
                        "type" => "None",
                        "connectionType" => "None",
                        "maxConnections" => $maxConnections
                    ],
                    "lowFarePrice" => 0,
                    "ssrCollectionsMode" => $ssrCollectionsMode
                ]
            ],
            "codes" => [
                "currencyCode" => $currencyCode ?: ""
            ],
            "taxesAndFees" => $taxesAndFees,
            "numberOfFaresPerJourney" => $numberOfFaresPerJourney
        ];

        $lastTravelportRequest = TravelportRequest::latest()->first();
        $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();
        $trace_id  = $lastId + 1;
        $data = array(
            'jsonRequest' => $body,
            'trace_id' => $trace_id,
            'endpoint' => 'Availability',
            'request_type' => 'search',
            'requestFrom' => $requestFrom,

        );
        
        $data = $this->postMethodForJazeera($data);
        if (isset($data['jazeeraResponse']['availabilityv4']['results'])) {
            $results        = $data['jazeeraResponse']['availabilityv4']['results'];
            $resultsCount   = count($results);
            if ($resultsCount === 2) {
                return $data;
            } else {
                return null;
            }
        }
        
    }

    public function setConversionRateForJazeera($toCurrencyCode){
        $currencyCalculationRequest = [
            'fromCurrencyCode'  => 'KWD',
            'toCurrencyCode'    => $toCurrencyCode,
            'amount'            =>  1,
        ];
        $endpoint               = 'CurrencyConverter';
        $currencyCalculation = $this->getMethodForJazeera($currencyCalculationRequest, $endpoint, null);
        if (isset($currencyCalculation['jazeeraResponse']['data']['currencyCalculation'])) {
            $currencyConversionData = $currencyCalculation['jazeeraResponse']['data'];
            session(['currencyConversionData' => $currencyConversionData]);
        }
        return $currencyCalculation;
    }
    /*End Jazeera*/
}
