<?php

namespace App\Http\Controllers\Api\Flights;

use PDF;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Offer;
use App\Models\Coupon;
use App\Rules\DOBChek;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Country;
use App\Models\Package;
use App\Models\Equipment;
use App\Models\GuestUser;
use App\Models\AirlinesPnr;
use App\Models\Destination;
use App\Models\PendingPnrs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AppliedCoupon;
use App\Models\FlightBooking;
use App\Models\PopularEventNews;
use App\Models\TravelportRequest;
use App\Models\FlightTicketNumber;
use Illuminate\Support\Facades\DB;
use App\Models\AirportsCountryCity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mtownsend\XmlToArray\XmlToArray;
use App\Models\FlightBookingTravelsInfo;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Air\SearchController;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Air\BookingController;
use App\Http\Controllers\Api\BaseApiController;

class HomeController extends BaseApiController
{
  
    // public function AirportCodesList(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'q' => ['required','min:3'],
    //     ]);

    //     if ($validator->fails()) {
    //         $errorMessages = $validator->messages()->all();
    //         return response()->json([
    //             'status' => false,
    //             "message" => $errorMessages[0]
    //         ], 200);
    //     }

    //     $search = $request->input('q');
    //     $except = $request->input('ff');
       
    //     if(app()->getLocale() == 'ar')
    //     {
    //         // $selectquery = 'airports.airport_code',DB::raw('CONCAT(cities.name," (",airports.airport_code,")") as display_name'),'airports.name','countries.name as country_name','cities.name as city_name';
    //         $displayName = 'CONCAT(IFNULL(cities.name_ar,cities.name)," (",airports.airport_code,")") as display_name';
    //         $airportName = 'IFNULL(airports.name_ar,airports.name) as name';
    //         $countryName = 'IFNULL(countries.name_ar,countries.name) as country_name';
    //         $cityName = 'IFNULL(cities.name_ar,cities.name) as city_name';
    //         $lang = "ar";
    //     }
    //     else{
    //        // $selectquery = `'airports.airport_code',DB::raw('CONCAT(cities.name," (",airports.airport_code,")") as display_name'),'airports.name','countries.name as country_name','cities.name as city_name'`;
    //         $displayName = 'CONCAT(cities.name," (",airports.airport_code,")") as display_name';
    //         $airportName = 'airports.name';
    //         $countryName = 'countries.name as country_name';
    //         $cityName = 'cities.name as city_name';
    //         $lang = "en";
    //     }
        
       
    //     $airports = Airport::
    //     select('airports.airport_code',DB::raw($displayName),DB::raw($airportName),DB::raw($countryName),DB::raw($cityName))
    //     ->leftJoin('cities' , 'cities.city_code', '=' , 'airports.reference_city_code')
    //     ->leftJoin('countries' , 'countries.country_code', '=' , 'airports.country_code')
    //     ->where(function($query) use($search ,$lang)
    //     {
    //         if($lang =="ar"){
    //             $query->where('cities.name_ar', 'LIKE', $search.'%')
    //             ->orWhere('cities.city_code', 'LIKE', $search.'%')
    //             ->orWhere('cities.associated_airports', 'LIKE', $search.'%')
    //             ->orWhere('IFNULL(airports.name_ar,airports.name)', 'LIKE', $search.'%');
    //         }
    //         else{
    //             $query->where('cities.name', 'LIKE', $search.'%')
    //             ->orWhere('cities.city_code', 'LIKE', $search.'%')
    //             ->orWhere('cities.associated_airports', 'LIKE', $search.'%')
    //             ->orWhere('airports.name', 'LIKE', $search.'%');
    //         }
            
    //     })
    //     ->where(function($query) use($search)
    //     {
    //         $query->whereIn('airports.airport_type', [1,2,3,4,8,9]);
    //     });
       
        
        
    //     if(!empty($except))
    //     {
    //         $airports =$airports->where(function($query) use($except)
    //         {
    //             $query->where('airports.airport_code', '!=', $except);
    //         });
    //     }
       
    //     $airports = $airports->get()->toArray();
        
    //     return response()->json([
    //         'status' => true,
    //         'message' => self::SUCCESS_MSG,
    //         "data" => $airports
    //     ], 200);


    
    // }

    /*public function AirportCodesList(Request $request)
    {
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
        $except = $request->input('ff');
       
        if(!empty($search)){
            if(app()->getLocale() == 'ar')
            {

                $displayName = 'display_name_ar as display_name';
                $airportName = 'name_ar as name';
                $countryName = 'country_name_ar as country_name';
                $cityName = 'city_name_ar as city_name';

                $serachcityName = 'city_name_ar';
                $serachairportName = 'airport_en_ar';
            }
            else{
                $displayName = 'display_name';
                $airportName = 'name';
                $countryName = 'country_name';
                $cityName = 'city_name';

                $serachcityName = 'city_name';
                $serachairportName = 'name';
            }

            $airortsList = AirportsCountryCity::select('airport_code',DB::raw($displayName),DB::raw($airportName),DB::raw($countryName),DB::raw($cityName));
            $airortsList->where(function ($query) use($serachcityName , $search , $serachairportName) {
                $query->where($serachcityName, 'LIKE', $search.'%')->orWhere('city_code', 'LIKE', $search.'%')->orWhere('airport_code', 'LIKE', $search.'%')->orWhere($serachairportName, 'LIKE', $search.'%');
            });
            $airortsList->whereIn('airport_type', [1,2,3,4,8,9]);

            if(!empty($except))
            {
                $airortsList =$airortsList->where(function($query) use($except)
                {
                    $query->where('airport_code', '!=', $except);
                });
            }
            $airortsList = $airortsList->get()->toArray();
        }
        else{
            $airortsList = [];
        }
        
        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $airortsList
        ], 200);
    }*/

    //updated 12 dec 2023

    public function AirportCodesList(Request $request)
    {
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
        $except = $request->input('ff');
       
        if(!empty($search)){
            if(app()->getLocale() == 'ar')
            {

                $displayName = 'display_name_ar as display_name';
                $airportName = 'name_ar as name';
                $countryName = 'country_name_ar as country_name';
                $cityName = 'city_name_ar as city_name';

                $serachcityName = 'city_name_ar';
                $serachairportName = 'airport_en_ar';
            }
            else{
                $displayName = 'display_name';
                $airportName = 'name';
                $countryName = 'country_name';
                $cityName = 'city_name';

                $serachcityName = 'city_name';
                $serachairportName = 'name';
            }

            $airortsList = AirportsCountryCity::select('airport_code',DB::raw($displayName),DB::raw($airportName),DB::raw($countryName),DB::raw($cityName));
            // $airortsList->where(function ($query) use($serachcityName , $search , $serachairportName) {
            //     $query->where($serachcityName, 'LIKE', $search.'%')->orWhere('city_code', 'LIKE', $search.'%')->orWhere('airport_code', 'LIKE', $search.'%')->orWhere($serachairportName, 'LIKE', $search.'%');
            // });
            $airortsList->where(function ($query) use($serachcityName , $search , $serachairportName) {
                $query->where($serachcityName, 'LIKE', $search.'%')->orWhere('airport_code', 'LIKE', $search.'%')->orWhere($serachairportName, 'LIKE', $search.'%');
            });
            $airortsList->whereIn('airport_type', [1,2,3,4,8,9]);

            if(!empty($except))
            {
                $airortsList =$airortsList->where(function($query) use($except)
                {
                    $query->where('airport_code', '!=', $except);
                });
            }
            $airortsList = $airortsList->get()->toArray();
        }
        else{
            $airortsList = [];
        }
        
        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $airortsList
        ], 200);

    
    }


    public function home()
    {
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $data['offers'] = Offer::select($name.' as name',$description.' as description','created_at','valid_upto','id','slug',$this->ApiImage("/uploads/offers/"))->get();

        $data['packages'] = Package::select($name.' as name',$description.' as description','image','created_at','id','slug',$this->ApiImage("/uploads/packages/"))->whereStatus('Active')->get();

        $data['destinations'] = Destination::select($name.' as name',$description.' as description','image','created_at','id','slug',$this->ApiImage("/uploads/destinations/"))->where('status','Active')->orderBy('order','DESC')->get();

        $data['popular_events_news'] = PopularEventNews::select($name.' as name',$description.' as description','image','created_at','id','slug',$this->ApiImage("/uploads/popular_events_news/"))->where('status','Active')->orderBy('order','DESC')->get();

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $data
        ], 200);
    }

    public function SearchFlights(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'flight-trip' => ['required','in:onewaytrip,roundtrip'],
            'flightFromAirportCode' => 'required | min:3 |max:3',
            'flightToAirportCode' => 'required | min:3 |max:3',
            'DepartDate' => 'required',
            'noofAdults' => ['required' , 'numeric'],
            'noofChildren' => ['required' , 'numeric'],
            'noofInfants' => ['required' , 'numeric'],
            'flight-class' => ['required','in:Economy,Business,First']
        ]);
       
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }


        //Store Search in data in database
        $search_id = $this->storeSearchData($request);

        $request['search_id'] = $search_id;
      
        $response['air:LowFareSearchRsp'] =[];
        //original
        $AirSearchController = new SearchController();
        $searchResponse = $AirSearchController->Search($request);
        $response = $searchResponse['travelportResponse'];
        //original

        //AirArabia

        $AirSearchController = new SearchController();
        // $searchResponse = $AirSearchController->airArabiaSearch($request);
        $searchResponseAirarabia = $AirSearchController->airArabiaSearch($request);
        if(!isset($searchResponseAirarabia['error']))
        {
            $response['airarabia'] = $searchResponseAirarabia['travelportResponse'];
        }
        // $response['airarabia'] = $searchResponse['travelportResponse'];
        $response['userOrigin'] = $request->input('flightFromAirportCode') ; 
        $response['userDestination'] = $request->input('flightToAirportCode');
        $response['trace_id']  = $searchResponse['travelportRequest']->trace_id;
        //

         /*jazeera function start*/
        $request['requestFrom']     = "MOBILE";
        $searchResponseJazeera      = $AirSearchController->prepareSearchBodyForJazeera($request);
        $response['tokenData']      = isset($searchResponseJazeera['tokenData']) ? $searchResponseJazeera['tokenData'] : null;
        $response['airjazeera']     = isset($searchResponseJazeera['jazeeraResponse']) ? $searchResponseJazeera['jazeeraResponse'] :null;
        $response['search_request'] = $request->all();
        $response['trace_id']       = isset($searchResponseJazeera['trace_id']) ? $searchResponseJazeera['trace_id'] :null;
        if (isset($response['airjazeera'])) {
            $airjazeeraData = $response['airjazeera'];
            if (isset($airjazeeraData['availabilityv4'])) {
                $availabilityData = $airjazeeraData['availabilityv4'];
                if (isset($availabilityData['currencyCode']) && !empty($availabilityData['currencyCode']) && $availabilityData['currencyCode'] !="KWD") {
                    $fromCurrencyCode = $availabilityData['currencyCode'];
                    $AirSearchController->setConversionRateForJazeera($fromCurrencyCode);
                }
            }
        }
        /*jazeera function end*/


        //test
        // if($request->input('flight-trip') == 'roundtrip')
        // {
            
        //    $fileName = 'response2.xml';
        // }
        // else{
        //     $fileName = 'response.xml';
        // }
        // $response = file_get_contents(public_path($fileName));
        // $converted = XmlToArray::convert($response, $outputRoot = false);
        // $response =[];
        // $response['air:LowFareSearchRsp'] = $converted;
        // $data = $this->roundTripSearch($response);
        //test
      
        // if(!isset($response['air:LowFareSearchRsp']))
        // {
        //     return response()->json([
        //         'status' => false,
        //         'message' => $response['SOAP:Fault']['faultstring'],
        //     ], 200);
        // }

        
        if($request->input('flight-trip') == 'roundtrip')
        {
            $data = $this->roundTripSearch($response);
            $type = 'roundtrip';
        }
        else{
            $data = $this->oneWaySearch($response);
            $type = 'oneway';
        }
        $data['userRequest'] = json_encode($request->all());
       
        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $data
        ], 200);
       
        
    }

    public function oneWaySearch($response)
    {

        $result = [];
        $airLine =[];
        $stops =[];
        $minPrice = 0;
        $maxPrice = 0;
        $OriginCityDetails = [];
        $DestationCityDetails = [];
        $OriginCityDetails = $this->CityDetails($response['userOrigin']);
        $DestationCityDetails = $this->CityDetails($response['userDestination']);
        $traceId = $response['trace_id'];
        if(isset($response['air:LowFareSearchRsp'])){
            $traceId = $response['air:LowFareSearchRsp']['@attributes']['TraceId'];
            $Origin = $response['air:LowFareSearchRsp']['air:RouteList']['air:Route']['air:Leg']['@attributes']['Origin'];
            $Destination = $response['air:LowFareSearchRsp']['air:RouteList']['air:Route']['air:Leg']['@attributes']['Destination'];

            $OriginCityDetails = $this->CityDetails($Origin);
            $DestationCityDetails = $this->CityDetails($Destination);

            if(isset($response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint']['@attributes']))
            {
                $airPricing = $response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint'];
                $response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint'] = [];
                $response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint'][0] =  $airPricing;
            }

            foreach($response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint'] as $k=>$value)
            {
                $airOptions = [] ;
                $itinerary = [] ;
                
                if(isset($value['air:AirPricingInfo']['@attributes'])){
                    $options = $value['air:AirPricingInfo']['air:FlightOptionsList']['air:FlightOption']['air:Option'];
                    $VenderCode = $value['air:AirPricingInfo']['@attributes']['PlatingCarrier'];
                }
                else
                {
                    $options = $value['air:AirPricingInfo'][0]['air:FlightOptionsList']['air:FlightOption']['air:Option'];
                    $VenderCode = $value['air:AirPricingInfo'][0]['@attributes']['PlatingCarrier'];
                }
                $airlinedetails = Airline::whereVendorCode($VenderCode)->first();
                if(count($airLine) == 0)
                {
                    $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                }
                else{
                    $Ai = array_search($airlinedetails->name, array_column($airLine , "name"));
                    if(gettype($Ai) == "boolean")
                    {
                        $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                    }
                }

                if(isset($options['@attributes']))
                {
                    $connection = isset($options['air:Connection'])?count($options['air:Connection']) : 0;

                    if(count($stops) == 0)
                    {
                        $stops[] = array('name' => Connections($connection) ,'count'=>1);
                    }
                    else{
                        $Ai = array_search(Connections($connection), array_column($stops , "name"));
                        if(gettype($Ai) == "boolean")
                        {
                            $stops[] = array('name' => Connections($connection) ,'count' =>1);
                        }
                        else{
                            $stops[$Ai]['count'] =  $stops[$Ai]['count'] + 1;
                        }
                    }
                    $airConnectionsIndex = [];
                    if($connection > 0)
                    {
                        if(isset($options['air:Connection']['@attributes']))
                        {
                            $airConnectionsIndex[0] = $options['air:Connection'];
                        }
                        else{
                            $airConnectionsIndex = $options['air:Connection'];
                        }
                    }
                    
                    if(isset($options['air:BookingInfo']['@attributes']))
                    {
        
                        //direct airline
                        $segmentRefNumber = $options['air:BookingInfo']['@attributes']['SegmentRef'];
                        $bookingCode = $options['air:BookingInfo']['@attributes']['BookingCode'];
                    
                        $itinerary[] = $this->AirSegmentAndFlightDetails($response , $segmentRefNumber ,$bookingCode );
                        
                    }
                    else{
                        //one air option multiple stops
                        foreach($options['air:BookingInfo'] as $j=>$bookingInfo)
                        {
                            $segmentRefNumber = $bookingInfo['@attributes']['SegmentRef'];
                            $bookingCode = $bookingInfo['@attributes']['BookingCode'];
                        
                            $itinerary[] = $this->AirSegmentAndFlightDetails($response , $segmentRefNumber , $bookingCode);
                        }
                    }
        
                    $airOptions[] = array(
                        'itinerary' => $itinerary,
                        'connections' => $connection,
                        'totaltimeTravel' => $options['@attributes']['TravelTime'],
                        // 'bagga' => $bagg[0],
                        'airConnectionsIndex' => $airConnectionsIndex
                    );
        
                    
                }
                else{
                    //multiple air options
                    foreach($options as $multi=>$multiOptions)
                    {
                        $connection = isset($multiOptions['air:Connection']) ? count($multiOptions['air:Connection']) : 0 ;
                        if(count($stops) == 0)
                        {
                            $stops[] = array('name' => Connections($connection) ,'count'=>1);
                        }
                        else{
                            $Ai = array_search(Connections($connection), array_column($stops , "name"));
                            if(gettype($Ai) == "boolean")
                            {
                                $stops[] = array('name' => Connections($connection) ,'count' =>1);
                            }
                            else{
                                $stops[$Ai]['count'] =  $stops[$Ai]['count'] + 1;
                            }
                        }

                        $airConnectionsIndex = [];

                        if($connection > 0)
                        {
                            if(isset($multiOptions['air:Connection']['@attributes']))
                            {
                                $airConnectionsIndex[0] = $multiOptions['air:Connection'];
                            }
                            else{
                                $airConnectionsIndex = $multiOptions['air:Connection'];
                            }
                        }
        
                        $itinerary =[];
                    
                        if(isset($multiOptions['air:BookingInfo']['@attributes']))
                        {
                            //multiple air options with direct flight
                            $segmentRefNumber = $multiOptions['air:BookingInfo']['@attributes']['SegmentRef'];
                            $bookingCode = $multiOptions['air:BookingInfo']['@attributes']['BookingCode'];
                            
                            $itinerary[] = $this->AirSegmentAndFlightDetails($response , $segmentRefNumber ,$bookingCode);
                        }
                        else{
                            //multiple air options with connecting flight
                            foreach($multiOptions['air:BookingInfo'] as $mu=>$bookingInfo)
                            {
                                $segmentRefNumber = $bookingInfo['@attributes']['SegmentRef'];
                                $bookingCode = $bookingInfo['@attributes']['BookingCode'];
                                $itinerary[] = $this->AirSegmentAndFlightDetails($response , $segmentRefNumber , $bookingCode);
                            }
                        }
        
                        $airOptions[] = array(
                            'itinerary' => $itinerary,
                            'connections' => $connection,
                            'totaltimeTravel' => $multiOptions['@attributes']['TravelTime'],
                            // 'bagga' => $bagg[$multi],
                            'airConnectionsIndex' => $airConnectionsIndex
                        );
                    }
                    
                }
                foreach($airOptions as $AO=>$airOption)
                {
                    $layover = "";
                    $layover .= (count($airOption['itinerary'])==1)?"":((count($airOption['itinerary'])>2)?"Layovers - ":"Layover - ");
                    $ListingOriginAirPort = $airOption['itinerary'][0]['AirSegment']['OriginAirportDetails'];
                    foreach($airOption['itinerary'] as $l=>$itinerary)
                    {
                        if(isset($airOption['itinerary'][$l+1]))
                        {
                            
                            $layoverTime = LayoverTime($airOption['itinerary'][$l]['AirSegment']['ArrivalTime'] ,$airOption['itinerary'][$l+1]['AirSegment']['DepartureTime'] );
                            $airOption['itinerary'][$l]['LayOverTime'] = $layoverTime;
                            $layover .=  $airOption['itinerary'][$l]['AirSegment']['DestationAirportDetails']->city_name." ".$layoverTime;
                            if(isset($airOption['itinerary'][$l+2]))
                            {
                                $layover .= ",";
                            }
                        }
                        else{
                            $airOption['itinerary'][$l]['LayOverTime'] ='';
                        }
                        $ListingDestationAirPort = $airOption['itinerary'][$l]['AirSegment']['DestationAirportDetails'];
                    }

                    $depature = $airOption['itinerary'][0]['AirSegment']['DepartureTime'];
                    $arrival = $airOption['itinerary'][count($airOption['itinerary'])-1]['AirSegment']['ArrivalTime'];
                
                    $pricingInfodetails = $value['air:AirPricingInfo'];
                    if(isset($pricingInfodetails['@attributes']))
                    {
                        //only one adult or one child or one infant

                        $onepricing = $pricingInfodetails;
                        $pricingInfodetails = [] ;
                        $pricingInfodetails[0] = $onepricing ;
                    }
                    

                    $mKprice = markUpPrice($value['@attributes']['TotalPrice'],$value['@attributes']['Taxes'],$value['@attributes']['ApproximateBasePrice']);

                    if($mKprice)
                    {
                        $price = $mKprice['totalPrice']['value'];
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

                    //refund
                    if(isset($value['air:AirPricingInfo']['@attributes']['Refundable']))
                    {
                        $refund = $value['air:AirPricingInfo']['@attributes']['Refundable'];
                    }
                    elseif(isset($value['air:AirPricingInfo'][0]['@attributes']['Refundable'])){
                        $refund = $value['air:AirPricingInfo'][0]['@attributes']['Refundable'];
                    }
                    else{
                        $refund = "false";
                    }

                    $result[] =  array(
                        'layover' => $layover,
                        'Origin' => $ListingOriginAirPort['airport_code'],
                        'Destination' => $ListingDestationAirPort['airport_code'],
                        'OriginAirportDetails' =>$ListingOriginAirPort,
                        'DestationAirportDetails' =>$ListingDestationAirPort,
                        'Refundable' => $refund,
                        'connections' => $airOption['connections'] ,
                        'totalTimeTravel' => TimeTravel($airOption['totaltimeTravel']),
                        'airline' => $airlinedetails->name,
                        'IATACODE' => $airlinedetails->vendor_code,
                        'depature' => explode("+",$depature)[0],
                        'arrival' => explode("+",$arrival)[0],
                        'type' => 'travelport',
                        'currency_code' => $mKprice['totalPrice']['currency_code'],
                        'amount' =>$mKprice['totalPrice']['value'],
                        'completeData' => json_encode(array(
                            'markupPrice' => $mKprice,
                            'layover' => $layover,
                            'traceId' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'],
                            'Origin' => $Origin,
                            'Destination' => $Destination,
                            'airConnectionsIndex' => $airOption['airConnectionsIndex'],
                            'OriginAirportDetails' =>$ListingOriginAirPort,
                            'DestationAirportDetails' =>$ListingDestationAirPort,
                            'TotalPrice' => checkExistance($value['@attributes']['TotalPrice']),
                            'BasePrice' => $value['@attributes']['BasePrice'],
                            'ApproximateTotalPrice' => $value['@attributes']['ApproximateTotalPrice'],
                            'ApproximateBasePrice' => $value['@attributes']['ApproximateBasePrice'],
                            'EquivalentBasePrice' => isset($value['@attributes']['EquivalentBasePrice'])?$value['@attributes']['EquivalentBasePrice']:'',
                            'Taxes' => $value['@attributes']['Taxes'],
                            'ApproximateTaxes' => $value['@attributes']['ApproximateTaxes'],
                            'CompleteItinerary' => $value['@attributes']['CompleteItinerary'],
                            'Refundable' => $refund,
                            'itinerary' => $airOption['itinerary'],
                            'connections' => $airOption['connections'] ,
                            'totalTimeTravel' => $airOption['totaltimeTravel'],
                            'airline' => $airlinedetails->name,
                            'IATACODE' => $airlinedetails->vendor_code,
                            'depature' => $depature,
                            'arrival' => $arrival,
                            'type' => 'travelport',
                        ))
                    );
                }
                
            }

        }

        if(isset($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation']))
        {
            //airarabia
            if(isset($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation']['@attributes']))
            {
                $temp = [];
                $temp = $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'];
                $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'] = [];
                $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'][0] = $temp;
            }
            foreach($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'] as $aflightsKey => $aflightsValue)
            {

                $airlinedetails = Airline::whereVendorCode('G9')->first();
                if(count($airLine) == 0)
                {
                    $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                }
                else{
                    $Ai = array_search($airlinedetails->name, array_column($airLine , "name"));
                    if(gettype($Ai) == "boolean")
                    {
                        $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                    }
                }

                

                $TotalPrice = $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:TotalFare']['@attributes']['Amount'];
                $currencyCode = $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:TotalFare']['@attributes']['CurrencyCode'];
                $tax = $TotalPrice - $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:BaseFare']['@attributes']['Amount'];
                $ApproximateBasePrice = $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:BaseFare']['@attributes']['Amount'];

                $mKprice = markUpPrice($TotalPrice,$tax,$ApproximateBasePrice,'',array('currency_code' => $currencyCode , 'from' => 'airarabia'));
                // dd($TotalPrice,$tax,$ApproximateBasePrice,'',array('currency_code' => $currencyCode , 'from' => 'airarabia'),$mKprice);
                
                //itinerary
                if(isset($aflightsValue['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption']['ns1:FlightSegment']))
                {
                    $temp = [];
                    $temp = $aflightsValue['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'];
                    $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'][$aflightsKey]['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] = [];
                    $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'][$aflightsKey]['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'][0] = $temp;
                }
                $itinerary = [];
                foreach ($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'][$aflightsKey]['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] as $itinerarykey => $itineraryvalue) {
            
                    $itineraryvalue['Carrier'] = 'G9';
                    $itineraryvalue['airline'] = 'Air Arabia';
                    $itineraryvalue['FlightNumber'] = $itineraryvalue['ns1:FlightSegment']['@attributes']['FlightNumber'];
                    $itineraryvalue['cleanDepartureTime'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'time');
                    $itineraryvalue['cleanDepartureDate'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'date');
                    $itineraryvalue['DepartureDate'] = ($itineraryvalue['ns1:FlightSegment']['@attributes']['DepartureDateTime']);
                    $itineraryvalue['cleanArrivalTime'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'time');
                    $itineraryvalue['cleanArrivalDate'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'date');
                    $itineraryvalue['ArrivalDate'] = ($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime']);
                    $itineraryvalue['OriginAirportDetails'] = $this->AirportDetails($itineraryvalue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode']);
                    $itineraryvalue['DestationAirportDetails'] = $this->AirportDetails($itineraryvalue['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode']);
                    // dd($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration']);
                    $itineraryvalue['FlightTravelTime'] = TimeTravel($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration'] ,'airarabia');
                    $itineraryvalue['segmentType'] = 'outbound';
                    $itineraryvalue['from'] = 'mobile';
                    $itinerary[] = ['AirSegment' => $itineraryvalue];
                }

                $layover = "";
                $layover .= (count($itinerary)==1)?"":((count($itinerary)>2)?"Layovers - ":"Layover - ");
                // $ListingOriginAirPort = $itinerary[0]['AirSegment']['OriginAirportDetails'];
                foreach($itinerary as $l=>$itineraryVal)
                {
                    if(isset($itinerary[$l+1]))
                    {
                    
                        $layoverTime = LayoverTime($itinerary[$l]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime'] ,$itinerary[$l+1]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime']);
                        $itinerary[$l]['LayOverTime'] = $layoverTime;
                        $layover .=  $itinerary[$l]['AirSegment']['DestationAirportDetails']->city_name." ".$layoverTime;
                        if(isset($itinerary[$l+2]))
                        {
                            $layover .= ",";
                        }
                    }
                    else{
                        $itinerary[$l]['LayOverTime'] ='';
                    }

                }
                $itenaryCount = count($itinerary);
                $connection = $itenaryCount - 1;

                if(count($stops) == 0)
                {
                    $stops[] = array('name' => Connections($connection) ,'count'=>1);
                }
                else{
                    $Ai = array_search(Connections($connection), array_column($stops , "name"));
                    if(gettype($Ai) == "boolean")
                    {
                        $stops[] = array('name' => Connections($connection) ,'count' =>1);
                    }
                    else{
                        $stops[$Ai]['count'] =  $stops[$Ai]['count'] + 1;
                    }
                }

                //minPrice and maxPrice
                if($mKprice)
                {
                    $price = $mKprice['totalPrice']['value'];
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
              
                $depature = $itinerary[0]['AirSegment']['DepartureDate'];
                $arrival = $itinerary[count($itinerary)-1]['AirSegment']['ArrivalDate'];
    
                $result[] =  array(
                    'layover' => $layover,
                    'Origin' => $Origin,
                    'Destination' => $Destination,
                    'OriginAirportDetails' =>$this->AirportDetails($aflightsValue['ns1:OriginLocation']['@attributes']['LocationCode']),
                    'DestationAirportDetails' => $this->AirportDetails($aflightsValue['ns1:DestinationLocation']['@attributes']['LocationCode']),
                    'Refundable' => "false",
                    'connections' => $connection ,
                    // 'totalTimeTravel' => LayoverTime($aflightsValue['ns1:DepartureDateTime']['@content'] , $aflightsValue['ns1:ArrivalDateTime']['@content']),
                    'totalTimeTravel' => AirArabiaLayoverTime($aflightsValue['ns1:OriginLocation']['@attributes']['LocationCode'] ,$aflightsValue['ns1:DestinationLocation']['@attributes']['LocationCode'] , $aflightsValue['ns1:DepartureDateTime']['@content'] , $aflightsValue['ns1:ArrivalDateTime']['@content']),
                    'airline' => 'Air Arabia',
                    'IATACODE' => 'G9',
                    'depature' => $depature,
                    'arrival' => $arrival,
                    'type' => 'airarabia',
                    'amount' => $mKprice['totalPrice']['value'],
                    'currency_code' => $mKprice['totalPrice']['currency_code'],
                    'completeData' => json_encode(array(
                        'amount' => $mKprice['totalPrice']['value'],
                        'traceId' => $traceId,
                        'markupPrice' => $mKprice,
                        'layover' => $layover,
                        'OriginAirportDetails' =>$this->AirportDetails($aflightsValue['ns1:OriginLocation']['@attributes']['LocationCode']),
                        'DestationAirportDetails' => $this->AirportDetails($aflightsValue['ns1:DestinationLocation']['@attributes']['LocationCode']),
                        'Refundable' => false,
                        'itinerary' => $itinerary,
                        'connections' => $connection ,
                        'totalTimeTravel' => LayoverTime($aflightsValue['ns1:DepartureDateTime']['@content'] , $aflightsValue['ns1:ArrivalDateTime']['@content']),
                        'airline' => 'Air Arabia',
                        'IATACODE' => 'G9',
                        'type' => 'airarabia',
                        'transactionIdentifier' => $response['airarabia']['ns1:OTA_AirAvailRS']['@attributes']['TransactionIdentifier'],
                    ))
                );

                
            }

            usort($result, function($a, $b) {
                return $a['amount'] <=> $b['amount'];
            });
        }

        /*air jazeera one way trip search*/
        if(isset($response['airjazeera']) && empty($response['airjazeera'][0]['dotrezAPI']['dotrezErrors']['errors']) && !empty($response['airjazeera']['availabilityv4']['results']) && !empty($response['airjazeera']['availabilityv4']['faresAvailable'])){
            $tokenData      = isset($response['tokenData']) ? $response['tokenData'] : null;
            $data           = $response['airjazeera']['availabilityv4']; 
            $flightClass    = $response['search_request']['flight-class'];
            $originCurrency = $data['currencyCode'];
            $jazeeratraceId        = isset($response['trace_id']) && !empty($response['trace_id']) ? $response['trace_id'] : null;
 
            $journeys               = $data['results'][0]['trips'][0]['journeysAvailableByMarket'][0]['value'];
            $responses              = array(); // Array to store the responses
            $bookingController      = new BookingController();
            $frontEndHomeController = new \App\Http\Controllers\FrontEnd\HomeController();

            // Create arrays to store the keys
            
            foreach ($journeys as $journey) {
                $fares = $journey['fares'];
                foreach ($fares as $fare) {
                    $fareAvailabilityKey = $fare['fareAvailabilityKey'];
                    foreach ($fare['details'] as $detail) {
                        $availableCount = $detail['availableCount'];
                        $status         = $detail['status'];
                        $reference      = $detail['reference'];
                        // Exclude the "fares" key data
                        unset($journey['fares']);
                        $faresAvailable = $data['faresAvailable'];
                        $matchedFare = null;
                        foreach ($faresAvailable as $faresAvailableItem) {
                            if ($faresAvailableItem['key'] === $fareAvailabilityKey) {
                                $matchedFare = $faresAvailableItem;
                                break;
                            }
                        }
                        $journey['faresDetails'] = $matchedFare ? $matchedFare : [];
                        $fareKeyProductClass     = $journey['faresDetails']['value']['fares'][0]['productClass'];
                        // Create an associative array for the response if same class

                        if (($flightClass === "Economy" && in_array($fareKeyProductClass, ["EL", "EV", "EE"])) 
                            || ($flightClass === "Business" && $fareKeyProductClass === "BU"))
                        {
                            
                            $noOfInfants        = $response['search_request']['noofInfants'] ? (int) $response['search_request']['noofInfants'] : 0;
                            
                            $bookingQuoteData = null;
                            if ($noOfInfants !== null && $noOfInfants > 0) {
                                // Create the key object and add it to the array
                                $key = [
                                    "journeyKey" => $journey['journeyKey'],
                                    "fareAvailabilityKey" => $fareAvailabilityKey,
                                ];
                                $response['search_request']['currencyCode'] = $originCurrency;
                                $response['search_request']['tokenData']    = $tokenData;
                                $response['search_request']['requestFrom']  = "MOBILE";
                                $bookingQuoteDataResponse   = $bookingController->bookingQuoteRequestJazeera($key,$response['search_request'],$traceId=null);
                                if(isset($bookingQuoteDataResponse) && isset($bookingQuoteDataResponse['jazeeraResponse']) && isset($bookingQuoteDataResponse['jazeeraResponse']['breakdown']) && !empty($bookingQuoteDataResponse['jazeeraResponse']['breakdown'])){
                                    $bookingQuoteData = $bookingQuoteDataResponse['jazeeraResponse']['breakdown'];
                                }

                            }


                            $allResults = array(
                                "fareAvailabilityKey"   => $fareAvailabilityKey,
                                "availableCount"        => $availableCount,
                                "status"                => $status,
                                "reference"             => $reference,
                                "value"                 => $journey,
                                "breakdown"             => $bookingQuoteData
                            );
                            
                            $responses[] = $allResults;
 
                        }
                    }
                }
            }
            
            $itinerary = [];
            $airlinedetails = Airline::whereVendorCode('J9')->first();
            $airlineAdded = false; // Flag variable

            foreach ($responses as $allJourney) {
                $productClass = $allJourney['value']['faresDetails']['value']['fares'][0]['productClass'];
                if (($flightClass === "Economy" && in_array($productClass, ["EL", "EV", "EE"])) 
                    || ($flightClass === "Business" && $productClass === "BU"))
                {
                    /*ADD AIRLINE*/
                    if (!$airlineAdded) {
                        if(count($airLine) == 0)
                        {
                            $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                        }
                        else{
                            $Ai = array_search($airlinedetails->name, array_column($airLine , "name"));
                            if(gettype($Ai) == "boolean")
                            {
                                $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                                $airlineAdded = true;
                            }
                        }
                    }

                    $infantTax            = 0;
                    $infantTotal          = 0;
                     
                    //check infant base price and tax if available
                    if(isset($allJourney['breakdown']) && !empty($allJourney['breakdown']['passengerTotals']['infant'])){
                        $infantTotal    = $allJourney['breakdown']['passengerTotals']['infant']['total'];
                        $infantTax      = $allJourney['breakdown']['passengerTotals']['infant']['taxes'];
                    }

                    $journeyDetails       = $allJourney['value'];
                    $TotalPrice           = $allJourney['value']['faresDetails']['value']['totals']['fareTotal'] + $infantTotal + $infantTax;
                    $currencyCode         = $originCurrency;
                    $tax                  = $TotalPrice - ($allJourney['value']['faresDetails']['value']['totals']['revenueTotal'] + $infantTotal);
                    $ApproximateBasePrice = $TotalPrice - $tax;
                    
                    /*currency conversion with jazeera*/
                    $convertedTotalPrice  = getCurrencyConversionData($TotalPrice, $currencyCode);
                    $convertedTax         = getCurrencyConversionData($tax, $currencyCode);
                    $convertedApproximateBasePrice = getCurrencyConversionData($ApproximateBasePrice, $currencyCode);

                    $mKprice = markUpPrice($convertedTotalPrice,$convertedTax,$convertedApproximateBasePrice,'',array('currency_code' => "KWD" , 'from' => 'airjazeera'));
                     
                    if(isset($journeyDetails['segments']))
                    {       
                            $totalMinutesWithoutLayover=0;
                            $itinerary = [];
                            foreach ($journeyDetails['segments'] as $itinerarykey => $itineraryvalue) {

                                    /*newcode*/
                                    $departureTimeUtc       = $itineraryvalue['legs'][0]['legInfo']['departureTimeUtc'];
                                    $arrivalTimeUtc         = $itineraryvalue['legs'][0]['legInfo']['arrivalTimeUtc'];
                                    $departureDateTimeUtc   = new DateTime($departureTimeUtc, new DateTimeZone('UTC'));
                                    $arrivalDateTimeUtc     = new DateTime($arrivalTimeUtc, new DateTimeZone('UTC'));
                                    $flightDuration         = $departureDateTimeUtc->diff($arrivalDateTimeUtc);
                                    $flightTravelTime       = $flightDuration->format('%H:%I');
                                    $totalMinutesWithoutLayover += $frontEndHomeController->convertFlightTravelTimeToMinutes($flightTravelTime);
                                    /*end new*/

                                    $departureDate                              = DateTimeSpliter($itineraryvalue['designator']['departure'],'date');
                                    $departureTime                              = DateTimeSpliter($itineraryvalue['designator']['departure'],'time');
                                    $arrivalDate                                = DateTimeSpliter($itineraryvalue['designator']['arrival'],'date');
                                    $arrivalTime                                = DateTimeSpliter($itineraryvalue['designator']['arrival'],'time');
                                   
                                    $itineraryvalue['Carrier']                  = $itineraryvalue['identifier']['carrierCode'];
                                    $itineraryvalue['airline']                  = "Jazeera-Airways";
                                    $itineraryvalue['FlightNumber']             = $itineraryvalue['identifier']['identifier'];
                                    $itineraryvalue['cleanDepartureTime']       = $departureTime;
                                    $itineraryvalue['cleanDepartureDate']       = $departureDate;
                                    $itineraryvalue['cleanArrivalTime']         = $arrivalTime;
                                    $itineraryvalue['cleanArrivalDate']         = $arrivalDate;
                                    $itineraryvalue['OriginAirportDetails']     = $this->AirportDetails($itineraryvalue['designator']['origin']);
                                    $itineraryvalue['DestationAirportDetails']  = $this->AirportDetails($itineraryvalue['designator']['destination']);
                                    $itineraryvalue['FlightTravelTime']         = $flightTravelTime;
                                    $itineraryvalue['segmentType']              = 'outbound';
                                    $itinerary[]                                = ['AirSegment' => $itineraryvalue];
                            }
                    }

                    $totalMinutesWithLayover   = $totalMinutesWithoutLayover;
                    $layover        = "";
                    $layover .= (count($itinerary)==1)?"":((count($itinerary)>2)?"Layovers - ":"Layover - ");
                    
                    foreach ($itinerary as $l => &$itineraryVal) {
                        if (isset($itinerary[$l + 1])) {
                            // Get the current arrival and next departure information
                            $currentArrival               = $itinerary[$l]['AirSegment']['designator']['arrival'];
                            $nextDeparture                = $itinerary[$l + 1]['AirSegment']['designator']['departure'];
                            $layoverTime                  = LayoverTime($currentArrival, $nextDeparture);
                            $itinerary[$l]['LayOverTime'] = $layoverTime;
                            /*Convert in to minutes*/
                            $segmentMinutes  = $frontEndHomeController->calcualteMinutes($layoverTime);
                            $totalMinutesWithLayover += $segmentMinutes;
                            /**/
                            $layover .= $itinerary[$l]['AirSegment']['DestationAirportDetails']->city_name . " " . $layoverTime;
                            if (isset($itinerary[$l + 2])) {
                                $layover .= ",";
                            }
                        } else {
                            $itinerary[$l]['LayOverTime'] = '';
                        }

                        // Retrieve the baggage data
                        $baggageData = $frontEndHomeController->getBaggageForPassenger($response['search_request'], $productClass, $itineraryVal);
                        $itineraryVal['baggage'] = $baggageData;
                        $itineraryVal = array_merge(
                            array_slice($itineraryVal, 0, array_search('segmentType', array_keys($itineraryVal)) + 1, true),
                            ['baggage' => $baggageData],
                            array_slice($itineraryVal, array_search('segmentType', array_keys($itineraryVal)) + 1, null, true)
                        );
                    }

                    $totalTimeWithLayover = $frontEndHomeController->convertMinutesToFlightTravelTime($totalMinutesWithLayover);

                    $itenaryCount = count($itinerary);
                    $connection = $itenaryCount - 1;
                    
                    if(count($stops) == 0)
                    {
                        $stops[] = array('name' => Connections($connection) ,'count'=>1);
                    }
                    else{
                        $Ai = array_search(Connections($connection), array_column($stops , "name"));
                        if(gettype($Ai) == "boolean")
                        {
                            $stops[] = array('name' => Connections($connection) ,'count' =>1);
                        }
                        else{
                            $stops[$Ai]['count'] =  $stops[$Ai]['count'] + 1;
                        }
                    }

                    if($mKprice)
                    {
                        $price = $mKprice['totalPrice']['value'];
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

                    $departureDateTime  = $journeyDetails['designator']['departure'];
                    $arrivalDateTime    = $journeyDetails['designator']['arrival'];
                    $result[] =  array(
                        'layover'                   => $layover,
                        'Origin'                    => $Origin,
                        'Destination'               => $Destination,
                        'OriginAirportDetails'      => $this->AirportDetails($journeyDetails['designator']['origin']),
                        'DestationAirportDetails'   => $this->AirportDetails($journeyDetails['designator']['destination']),
                        'Refundable'                => "false",
                        'connections'               => $connection ,
                        'totalTimeTravel'           => $totalTimeWithLayover,//LayoverTime($departureDateTime , $arrivalDateTime),
                        'airline'                   => 'Jazeera-Airways',
                        'IATACODE'                  => 'J9',
                        'depature'                  => $journeyDetails['designator']['departure'],
                        'arrival'                   => $journeyDetails['designator']['arrival'],
                        'type'                      => 'airjazeera',
                        'amount'                    => $mKprice['totalPrice']['value'],
                        'currency_code'             => $mKprice['totalPrice']['currency_code'],

                        'completeData' => json_encode(array(
                            'amount'                 => $mKprice['totalPrice']['value'],
                            'traceId'                => $jazeeratraceId,
                            'markupPrice'            => $mKprice,
                            'layover'                => $layover,
                            'OriginAirportDetails'   => $this->AirportDetails($journeyDetails['designator']['origin']),
                            'DestationAirportDetails'=> $this->AirportDetails($journeyDetails['designator']['destination']),
                            'Refundable'             => "false",
                            'itinerary'              => $itinerary,
                            'connections'            => $connection ,
                            'totalTimeTravel'        => $totalTimeWithLayover,
                            'airline'                => 'Jazeera-Airways',
                            'IATACODE'               => 'J9',
                            'type'                   => 'airjazeera',
                            'journeyKey'            =>  $journeyDetails['journeyKey'],
                            'numberOfinfant'        => $response['search_request']['noofInfants'] ? $response['search_request']['noofInfants'] : 0,
                            'fareAvailabilityKey'   => $allJourney['fareAvailabilityKey'],
                            'originCurrency'        => $originCurrency,
                            'tokenData'             => $tokenData,
                        ))
                    );
                }         
            }
            usort($result, function($a, $b) {
                return $a['amount'] <=> $b['amount'];
            });      
        }
        /*end air jazeera*/


        return array(
            'result' => $result,
            'airLines' => $airLine,
            'stops' => $stops,
            'Origin' => $Origin,
            'Destination' => $Destination,
            'OriginCityDetails' => $OriginCityDetails,
            'DestationCityDetails' => $DestationCityDetails,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'tarceId' => $traceId,
        );
       

    }


    public function roundTripSearch($response)
    {
        $result = [];
        $airLine =[];
        $stops =[];
        $minPrice = 0;
        $maxPrice = 0;
        $OriginCityDetails = [];
        $DestationCityDetails = [];
        $OriginCityDetails = $this->CityDetails($response['userOrigin']);
        $DestationCityDetails = $this->CityDetails($response['userDestination']);
        $Origin = $response['userOrigin'];
        $Destination = $response['userDestination'];

        $traceId = $response['trace_id'];
        if(isset($response['air:LowFareSearchRsp'])){

            $traceId = $response['air:LowFareSearchRsp']['@attributes']['TraceId'];
            $Origin = $response['air:LowFareSearchRsp']['air:RouteList']['air:Route']['air:Leg'][0]['@attributes']['Origin'];
            $Destination = $response['air:LowFareSearchRsp']['air:RouteList']['air:Route']['air:Leg'][0]['@attributes']['Destination'];

            $OriginCityDetails = $this->CityDetails($Origin);
            $DestationCityDetails = $this->CityDetails($Destination);

            $airLine =[];
            $stops =[];
            $minPrice = 0;
            $maxPrice = 0;

            if(isset($response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint']['@attributes']))
            {
                $airPricing = $response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint'];
                $response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint'] = [];
                $response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint'][0] =  $airPricing;
            }
            foreach($response['air:LowFareSearchRsp']['air:AirPricePointList']['air:AirPricePoint'] as $k=>$value)
            {
                $airOptions = [] ;
            
                if(isset($value['air:AirPricingInfo']['@attributes'])){
                    $options = $value['air:AirPricingInfo']['air:FlightOptionsList']['air:FlightOption'];
                    $VenderCode = $value['air:AirPricingInfo']['@attributes']['PlatingCarrier'];
                }
                else
                {
                    $options = $value['air:AirPricingInfo'][0]['air:FlightOptionsList']['air:FlightOption'];
                    $VenderCode = $value['air:AirPricingInfo'][0]['@attributes']['PlatingCarrier'];

                }

                $airlinedetails = Airline::whereVendorCode($VenderCode)->first();
                if(count($airLine) == 0)
                {
                    $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                }
                else{
                    $Ai = array_search($airlinedetails->name, array_column($airLine , "name"));
                    if(gettype($Ai) == "boolean")
                    {
                        $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                    }
                }
            
                
                //converting air:option to multi dimension array if only one exist
                if(isset($options[0]['air:Option']['@attributes']))
                {
                
                    $outboundedsingleoption = $options[0]['air:Option'];
                    $options[0]['air:Option'] = [];
                    $options[0]['air:Option'][0] = $outboundedsingleoption;
                }
                if(isset($options[1]['air:Option']['@attributes']))
                {
                    $inboundsingleoption = $options[1]['air:Option'];
                    $options[1]['air:Option'] = [];
                    $options[1]['air:Option'][0] = $inboundsingleoption;
                }
            
                //converting air:BookingInfo to multi dimension array if only one exist
                foreach($options[0]['air:Option']  as $oo=>$oItinarary)
                {
                    if(isset($oItinarary['air:BookingInfo']['@attributes']))
                    {
                        $singleItinarary = $oItinarary['air:BookingInfo'];
                        $options[0]['air:Option'][$oo]['air:BookingInfo'] = [];
                        $options[0]['air:Option'][$oo]['air:BookingInfo'][0] = $singleItinarary;

                    }
                }
                foreach($options[1]['air:Option']  as $io=>$IItinarary)
                {
                    if(isset($IItinarary['air:BookingInfo']['@attributes']))
                    {
                        $singleItinarary = $IItinarary['air:BookingInfo'];
                        $options[1]['air:Option'][$io]['air:BookingInfo'] = [];
                        $options[1]['air:Option'][$io]['air:BookingInfo'][0] = $singleItinarary;

                    }
                }

                foreach($options[0]['air:Option'] as $outk=>$out )
                {
                    //outbounded airsegments
                    $Outconnection = isset($out['air:Connection']) ? count($out['air:Connection']) : 0 ;
                    if(count($stops) == 0)
                    {
                        $stops[] = array('name' => Connections($Outconnection) ,'count'=>1);
                    }
                    else{
                        $Ai = array_search(Connections($Outconnection), array_column($stops , "name"));
                        if(gettype($Ai) == "boolean")
                        {
                            $stops[] = array('name' => Connections($Outconnection) ,'count' =>1);
                        }
                        else{
                            $stops[$Ai]['count'] =  $stops[$Ai]['count'] + 1;
                        }
                    }

                    $airOutConnectionsIndex = [];
                
                    if($Outconnection > 0)
                    {
                        if(isset($out['air:Connection']['@attributes']))
                        {
                            $airOutConnectionsIndex[0] = $out['air:Connection'];
                        }
                        else{
                            $airOutConnectionsIndex = $out['air:Connection'];
                        }
                    }

                    $outbound = [];
                    foreach($out['air:BookingInfo'] as $outIntinarary)
                    {
                        $segmentRefNumber = $outIntinarary['@attributes']['SegmentRef'];
                        $bookingCode = $outIntinarary['@attributes']['BookingCode'];
                        $outbound[] = $this->AirSegmentAndFlightDetails($response , $segmentRefNumber , $bookingCode);

                    }

                    foreach($options[1]['air:Option'] as $ink=>$in )
                    {
                        //inbounded airsegments

                        $Inconnection = isset($in['air:Connection']) ? count($in['air:Connection']) : 0 ;

                        $airInConnectionsIndex = [];
                        if($Inconnection > 0)
                        {
                            if(isset($in['air:Connection']['@attributes']))
                            {
                                $airInConnectionsIndex[0] = $in['air:Connection'];
                            }
                            else{
                                $airInConnectionsIndex = $in['air:Connection'];
                            }
                        }
                    
                        $inbound = [];
                        foreach($in['air:BookingInfo'] as $inIntinarary)
                        {
                            $segmentRefNumber = $inIntinarary['@attributes']['SegmentRef'];
                            $bookingCode = $inIntinarary['@attributes']['BookingCode'];
                            $inbound[] = $this->AirSegmentAndFlightDetails($response , $segmentRefNumber , $bookingCode);
                        }

                        $airOptions[] = array(
                            'outboundItinerary' => $outbound,
                            'outboundconnection' => $Outconnection,
                            'inboundItinerary' => $inbound,
                            'inboundconnection' => $Inconnection,
                            'outboundtotaltimeTravel' => $out['@attributes']['TravelTime'],
                            'inboundtotaltimeTravel' => $in['@attributes']['TravelTime'],
                            // 'bagga' => $bagg[$outk+$ink],
                            'airOutConnectionsIndex' => $airOutConnectionsIndex,
                            'airInConnectionsIndex' => $airInConnectionsIndex,
                        );
                    }

                }
            
                foreach($airOptions as $RO=>$airOption)
                {
                    //outbounded layover time
                    $outBoundedlayover = "";
                    $outBoundedlayover .= (count($airOption['outboundItinerary'])==1)?"":((count($airOption['outboundItinerary'])>2)?"Layovers - ":"Layover - ");
                    $outBoundedListingOriginAirPort = $airOption['outboundItinerary'][0]['AirSegment']['OriginAirportDetails'];
                    foreach($airOption['outboundItinerary'] as $l=>$outboundItinerary)
                    {
                        if(isset($airOption['outboundItinerary'][$l+1]))
                        {
                            $layoverTime = LayoverTime($airOption['outboundItinerary'][$l]['AirSegment']['ArrivalTime'] ,$airOption['outboundItinerary'][$l+1]['AirSegment']['DepartureTime'] );
                            $airOption['outboundItinerary'][$l]['LayOverTime'] = $layoverTime;
                            $outBoundedlayover .=  $airOption['outboundItinerary'][$l]['AirSegment']['DestationAirportDetails']->city_name." ".$layoverTime;
                            if(isset($airOption['outboundItinerary'][$l+2]))
                            {
                                $outBoundedlayover .= ",";
                            }
                        }
                        else{
                            $airOption['outboundItinerary'][$l]['LayOverTime'] ='';
                        }
                        $outBoudedListingDestationAirPort = $airOption['outboundItinerary'][$l]['AirSegment']['DestationAirportDetails'];
                    }
                    $outBoundeDepature = $airOption['outboundItinerary'][0]['AirSegment']['DepartureTime'];
                    $outBoundedArrival = $airOption['outboundItinerary'][count($airOption['outboundItinerary'])-1]['AirSegment']['ArrivalTime'];
                    //end  outbounded layover time

                    //inbound layover time
                    $inBoundedlayover = "";
                    $inBoundedlayover .= (count($airOption['inboundItinerary'])==1)?"":((count($airOption['inboundItinerary'])>2)?"Layovers - ":"Layover - ");
                    $inBoundedListingOriginAirPort = $airOption['inboundItinerary'][0]['AirSegment']['OriginAirportDetails'];
                    foreach($airOption['inboundItinerary'] as $l=>$inboundItinerary)
                    {
                        if(isset($airOption['inboundItinerary'][$l+1]))
                        {
                            
                            $layoverTime = LayoverTime($airOption['inboundItinerary'][$l]['AirSegment']['ArrivalTime'] ,$airOption['inboundItinerary'][$l+1]['AirSegment']['DepartureTime'] );
                            $airOption['inboundItinerary'][$l]['LayOverTime'] = $layoverTime;
                            $inBoundedlayover .=  $airOption['inboundItinerary'][$l]['AirSegment']['DestationAirportDetails']->city_name." ".$layoverTime;
                            if(isset($airOption['inboundItinerary'][$l+2]))
                            {
                                $inBoundedlayover .= ",";
                            }
                        }
                        else{
                            $airOption['inboundItinerary'][$l]['LayOverTime'] ='';
                        }
                        $inboundedListingDestationAirPort = $airOption['inboundItinerary'][$l]['AirSegment']['DestationAirportDetails'];
                    }

                    $inBoundeDepature = $airOption['inboundItinerary'][0]['AirSegment']['DepartureTime'];
                    $inBoundedArrival = $airOption['inboundItinerary'][count($airOption['inboundItinerary'])-1]['AirSegment']['ArrivalTime'];



                    $mKprice = markUpPrice($value['@attributes']['TotalPrice'],$value['@attributes']['Taxes'],$value['@attributes']['ApproximateBasePrice']);

                    if($mKprice)
                    {
                        $price = $mKprice['totalPrice']['value'];
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
                    //refund
                    if(isset($value['air:AirPricingInfo']['@attributes']['Refundable']))
                    {
                        $refund = $value['air:AirPricingInfo']['@attributes']['Refundable'];
                    }
                    elseif(isset($value['air:AirPricingInfo'][0]['@attributes']['Refundable'])){
                        $refund = $value['air:AirPricingInfo'][0]['@attributes']['Refundable'];
                    }
                    else{
                        $refund = "false";
                    }

                    $result[] =  array(
                        'outBoundlayover' => $outBoundedlayover,
                        'inBoundlayover' => $inBoundedlayover,
                        'outBoundeDepature' =>  explode("+",$outBoundeDepature)[0],
                        'outBoundedArrival' => explode("+",$outBoundedArrival)[0], 
                        'inBoundeDepature' => explode("+",$inBoundeDepature)[0], 
                        'inBoundedArrival' => explode("+",$inBoundedArrival)[0],
                        'outboundconnection' => $airOption['outboundconnection'],
                        'inboundconnection' => $airOption['inboundconnection'],
                        'outboundtotaltimeTravel' => TimeTravel($airOption['outboundtotaltimeTravel']),
                        'inboundtotaltimeTravel' => TimeTravel($airOption['inboundtotaltimeTravel']),
                        'Origin' => $Origin,
                        'Destination' => $Destination,
                        'outBoundedOriginAirportDetails' =>$outBoundedListingOriginAirPort,
                        'outBoundedDestationAirportDetails' =>$outBoudedListingDestationAirPort,
                        'inBoundedOriginAirportDetails' =>$inBoundedListingOriginAirPort,
                        'inBoundedDestationAirportDetails' =>$inboundedListingDestationAirPort,
                        'Refundable' => $refund,
                        'airline' => $airlinedetails->name,
                        'IATACODE' => $airlinedetails->vendor_code,
                        'airlineOutBound' => $airOption['outboundItinerary'][0]['AirSegment']['airline'],
                        'IATACODEOutBound' => $airOption['outboundItinerary'][0]['AirSegment']['Carrier'],
                        'airlineInBound' => $airOption['inboundItinerary'][0]['AirSegment']['airline'],
                        'IATACODEInBound' => $airOption['inboundItinerary'][0]['AirSegment']['Carrier'],
                        'type' => 'travelport',
                        'currency_code' => $mKprice['totalPrice']['currency_code'],
                        'amount' =>$mKprice['totalPrice']['value'],
                        'compltedData' => json_encode(array(
                            'traceId' => $traceId,
                            'outBoundlayover' => $outBoundedlayover,
                            'inBoundlayover' => $inBoundedlayover,
                            'markupPrice' => $mKprice,
                            'outBoundeDepature' => $outBoundeDepature,
                            'outBoundedArrival' => $outBoundedArrival,
                            'inBoundeDepature' => $inBoundeDepature,
                            'inBoundedArrival' => $inBoundedArrival,
                            'outboundItinerary' => $airOption['outboundItinerary'],
                            'outboundconnection' => $airOption['outboundconnection'],
                            'inboundItinerary' => $airOption['inboundItinerary'],
                            'inboundconnection' => $airOption['inboundconnection'],
                            'outboundtotaltimeTravel' => $airOption['outboundtotaltimeTravel'],
                            'inboundtotaltimeTravel' => $airOption['inboundtotaltimeTravel'],
                            'airOutConnectionsIndex' => $airOption['airOutConnectionsIndex'],
                            'airInConnectionsIndex' => $airOption['airInConnectionsIndex'],
                            'traceId' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'],
                            'traceKey' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'] ."-". $k ."-" .$RO,
                            'Origin' => $Origin,
                            'Destination' => $Destination,
                            'outBoundedOriginAirportDetails' =>$outBoundedListingOriginAirPort,
                            'outBoundedDestationAirportDetails' =>$outBoudedListingDestationAirPort,
                            'inBoundedOriginAirportDetails' =>$inBoundedListingOriginAirPort,
                            'inBoundedDestationAirportDetails' =>$inboundedListingDestationAirPort,
                            'TotalPrice' => ($value['@attributes']['TotalPrice']),
                            'BasePrice' => $value['@attributes']['BasePrice'],
                            'ApproximateTotalPrice' => $value['@attributes']['ApproximateTotalPrice'],
                            'ApproximateBasePrice' => $value['@attributes']['ApproximateBasePrice'],
                            'EquivalentBasePrice' => isset($value['@attributes']['EquivalentBasePrice'])?$value['@attributes']['EquivalentBasePrice']:'',
                            'Taxes' => $value['@attributes']['Taxes'],
                            'ApproximateTaxes' => $value['@attributes']['ApproximateTaxes'],
                            'CompleteItinerary' => $value['@attributes']['CompleteItinerary'],
                            'Refundable' => $refund,
                            'airline' => $airlinedetails->name,
                            'IATACODE' => $airlinedetails->vendor_code,
                            'type' => 'travelport',
                        ))
                    );
                }
            }

        }
        

        if(isset($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation']))
        {
            //airarabia
            if(isset($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation']['@attributes']))
            {
                $temp = [];
                $temp = $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'];
                $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'] = [];
                $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'][0] = $temp;
            }
            $arabiaOriginAirPort = $response['userOrigin'];
            $arabiaDestinationAirPort = $response['userDestination'];
            foreach($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'] as $aflightsKey => $aflightsValue)
            {
                $airlinedetails = Airline::whereVendorCode('G9')->first();
                if(count($airLine) == 0)
                {
                    $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                }
                else{
                    $Ai = array_search($airlinedetails->name, array_column($airLine , "name"));
                    if(gettype($Ai) == "boolean")
                    {
                        $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                    }
                }

                

                $TotalPrice = $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:TotalFare']['@attributes']['Amount'];
                $currencyCode = $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:TotalFare']['@attributes']['CurrencyCode'];
                $tax = $TotalPrice - $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:BaseFare']['@attributes']['Amount'];
                $ApproximateBasePrice = $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:BaseFare']['@attributes']['Amount'];

                $mKprice = markUpPrice($TotalPrice,$tax,$ApproximateBasePrice,'',array('currency_code' => $currencyCode , 'from' => 'airarabia'));
            
                
                //itinerary
                if(isset($aflightsValue['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption']['ns1:FlightSegment']))
                {
                    $temp = [];
                    $temp = $aflightsValue['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'];
                    $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'][$aflightsKey]['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] = [];
                    $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'][$aflightsKey]['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'][0] = $temp;
                }
                $itinerary = [];
                $outboundItinerary = [];
                $inboundItinerary = [];
                $outBoundedstated = false;
                $inBoundedstated = false;

                foreach ($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:OriginDestinationInformation'][$aflightsKey]['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] as $itinerarykey => $itineraryvalue) 
                {
                   
                    $itinerary = [];
                    $itineraryvalue['Carrier'] = 'G9';
                    $itineraryvalue['airline'] = 'Air Arabia';
                    $itineraryvalue['FlightNumber'] = $itineraryvalue['ns1:FlightSegment']['@attributes']['FlightNumber'];
                    // $itineraryvalue['cleanDepartureTime'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'time');
                    // $itineraryvalue['cleanDepartureDate'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'date');
                    $itineraryvalue['DepartureDate'] = ($itineraryvalue['ns1:FlightSegment']['@attributes']['DepartureDateTime']);
                    // $itineraryvalue['cleanArrivalTime'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'time');
                    // $itineraryvalue['cleanArrivalDate'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'date');
                    $itineraryvalue['ArrivalDate'] = ($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime']);
                    $itineraryvalue['OriginAirportDetails'] = $this->AirportDetails($itineraryvalue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode']);
                    $itineraryvalue['DestationAirportDetails'] = $this->AirportDetails($itineraryvalue['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode']);
                    // dd($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration']);
                    $itineraryvalue['FlightTravelTime'] = TimeTravel($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration'] ,'airarabia');
                    $itineraryvalue['from'] = 'mobile';
                    // $itineraryvalue['FlightTravelTime'] = segmentTime($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['FlightTime'],'time');
                    $itinerary = ['AirSegment' => $itineraryvalue];
                   
                    if($itineraryvalue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode'] == $arabiaOriginAirPort)
                    {
                        $itinerary['AirSegment']['segmentType'] = 'outbound';
                        $outboundItinerary[] = $itinerary;
                        $outBoundedstated  = true;
                    }
                    elseif($itineraryvalue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode'] == $arabiaDestinationAirPort)
                    {
                        $itinerary['AirSegment']['segmentType'] = 'inbound';
                        $inboundItinerary[] = $itinerary;
                        $outBoundedstated  = false;
                        $inBoundedstated  = true;
                    }elseif($outBoundedstated)
                    {
                        $itinerary['AirSegment']['segmentType'] = 'outbound';
                        $outboundItinerary[] = $itinerary;
                    }elseif($inBoundedstated)
                    {
                        $itinerary['AirSegment']['segmentType'] = 'inbound';
                        $inboundItinerary[] = $itinerary;
                    }
                }

                //outbounded layover time
                $outBoundedlayover = "";
                $outBoundedlayover .= (count($outboundItinerary)==1)?"":((count($outboundItinerary)>2)?"Layovers - ":"Layover - ");
                $outBoundedListingOriginAirPort = $outboundItinerary[0]['AirSegment']['OriginAirportDetails'];
                foreach($outboundItinerary as $l=>$outitineryValu)
                {
                    if(isset($outboundItinerary[$l+1]))
                    {
                        $layoverTime = LayoverTime($outboundItinerary[$l]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime'] , $outboundItinerary[$l+1]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] );
                        $outboundItinerary[$l]['LayOverTime'] = $layoverTime;
                        $outBoundedlayover .=  $outboundItinerary[$l]['AirSegment']['DestationAirportDetails']->city_name." ".$layoverTime;
                        if(isset($outboundItinerary[$l+2]))
                        {
                            $outBoundedlayover .= ",";
                        }
                    }
                    else{
                        $outboundItinerary[$l]['LayOverTime'] ='';
                    }
                    $outBoudedListingDestationAirPort = $outboundItinerary[$l]['AirSegment']['DestationAirportDetails'];
                }
                $outBoundeDepature = $outboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'];
                $outBoundedArrival = $outboundItinerary[count($outboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime'];
                
                //end  outbounded layover time
 
                //inbound layover time
                $inBoundedlayover = "";
                $inBoundedlayover .= (count($inboundItinerary)==1)?"":((count($inboundItinerary)>2)?"Layovers - ":"Layover - ");
                $inBoundedListingOriginAirPort = $inboundItinerary[0]['AirSegment']['OriginAirportDetails'];
                foreach($inboundItinerary as $l=>$initineryValue)
                {
                    if(isset($inboundItinerary[$l+1]))
                    {
                        
                        $layoverTime = LayoverTime($inboundItinerary[$l]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime'] ,$inboundItinerary[$l+1]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] );
                        $inboundItinerary[$l]['LayOverTime'] = $layoverTime;
                        $inBoundedlayover .=  $inboundItinerary[$l]['AirSegment']['DestationAirportDetails']->city_name." ".$layoverTime;
                        if(isset($inboundItinerary[$l+2]))
                        {
                            $inBoundedlayover .= ",";
                        }
                    }
                    else{
                        $inboundItinerary[$l]['LayOverTime'] ='';
                    }
                    $inboundedListingDestationAirPort = $inboundItinerary[$l]['AirSegment']['DestationAirportDetails'];
                }
                $outBoundeDepature = $inboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'];
                $outBoundedArrival = $inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime'];

                //end  inbounded layover time

                
                $outboundconnection = count($outboundItinerary);
                $outboundconnection = $outboundconnection - 1;

                $inboundconnection = count($inboundItinerary);
                $inboundconnection = $inboundconnection - 1;

                // $outBoundeDepature = $outboundItinerary[0]['AirSegment']['DepartureTime'];
                // $outBoundedArrival = $outboundItinerary[count($outboundItinerary)-1]['AirSegment']['ArrivalTime'];
                // $inBoundeDepature = $inboundItinerary[0]['AirSegment']['DepartureTime'];
                // $inBoundedArrival = $inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ArrivalTime'];

                if(count($stops) == 0)
                {
                    $stops[] = array('name' => Connections($outboundconnection) ,'count'=>1);
                }
                else{
                    $Ai = array_search(Connections($outboundconnection), array_column($stops , "name"));
                    if(gettype($Ai) == "boolean")
                    {
                        $stops[] = array('name' => Connections($outboundconnection) ,'count' =>1);
                    }
                    else{
                        $stops[$Ai]['count'] =  $stops[$Ai]['count'] + 1;
                    }
                }

                //minPrice and maxPrice
                if($mKprice)
                {
                    $price = $mKprice['totalPrice']['value'];
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
    
                $result[] =  array(
                    'outBoundlayover' => $outBoundedlayover,
                    'inBoundlayover' => $inBoundedlayover,
                    'outBoundeDepature' => $outBoundeDepature,
                    'outBoundedArrival' => $outBoundedArrival,
                    'inBoundeDepature' => $inBoundeDepature,
                    'inBoundedArrival' => $inBoundedArrival,
                    'outboundconnection' => $outboundconnection,
                    'inboundconnection' => $inboundconnection,
                    // 'outboundtotaltimeTravel' => LayoverTime($outboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] , $outboundItinerary[count($outboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    // 'inboundtotaltimeTravel' => LayoverTime($inboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] , $inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    'outboundtotaltimeTravel' => AirArabiaLayoverTime($outboundItinerary[0]['AirSegment']['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode'] ,$outboundItinerary[count($outboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode'] , $outboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] ,$outboundItinerary[count($outboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    'inboundtotaltimeTravel' => AirArabiaLayoverTime($inboundItinerary[0]['AirSegment']['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode'] ,$inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode'] , $inboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] ,$inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    'Origin' => $Origin,
                    'Destination' => $Destination,
                    'outBoundedOriginAirportDetails' =>$outBoundedListingOriginAirPort,
                    'outBoundedDestationAirportDetails' =>$outBoudedListingDestationAirPort,
                    'inBoundedOriginAirportDetails' =>$inBoundedListingOriginAirPort,
                    'inBoundedDestationAirportDetails' =>$inboundedListingDestationAirPort,
                    'Refundable' => "false",
                    'airline' => 'Air Arabia',
                    'IATACODE' => 'G9',
                    'airlineOutBound' => 'Air Arabia',
                    'IATACODEOutBound' => 'G9',
                    'airlineInBound' => 'Air Arabia',
                    'IATACODEInBound' => 'G9',
                    'type' => 'airarabia',
                    'amount' => $mKprice['totalPrice']['value'],
                    'currency_code' => $mKprice['totalPrice']['currency_code'],
                    'transactionIdentifier' => $response['airarabia']['ns1:OTA_AirAvailRS']['@attributes']['TransactionIdentifier'],
                    'compltedData' => json_encode(array(
                        'traceId' => $traceId+1,

                        // 'outBoundlayover' => $outBoundedlayover,
                        // 'inBoundlayover' => $inBoundedlayover,
                        'markupPrice' => $mKprice,
                        // 'outBoundeDepature' => $outBoundeDepature,
                        // 'outBoundedArrival' => $outBoundedArrival,
                        // 'inBoundeDepature' => $inBoundeDepature,
                        // 'inBoundedArrival' => $inBoundedArrival,
                        'outboundItinerary' => $outboundItinerary,
                        // 'outboundconnection' => $outboundconnection,
                        'inboundItinerary' => $inboundItinerary,
                        // 'inboundconnection' => $inboundconnection,
                        // 'outboundtotaltimeTravel' => $airOption['outboundtotaltimeTravel'],
                        // 'inboundtotaltimeTravel' => $airOption['inboundtotaltimeTravel'],
                        // 'airOutConnectionsIndex' => $airOption['airOutConnectionsIndex'],
                        // 'airInConnectionsIndex' => $airOption['airInConnectionsIndex'],
                        // 'traceId' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'],
                        // 'traceKey' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'] ."-". $k ."-" .$RO,
                        // 'Origin' => $Origin,
                        // 'Destination' => $Destination,
                        // 'outBoundedOriginAirportDetails' =>$outBoundedListingOriginAirPort,
                        // 'outBoundedDestationAirportDetails' =>$outBoudedListingDestationAirPort,
                        // 'inBoundedOriginAirportDetails' =>$inBoundedListingOriginAirPort,
                        // 'inBoundedDestationAirportDetails' =>$inboundedListingDestationAirPort,
                        // 'TotalPrice' => ($value['@attributes']['TotalPrice']),
                        // 'BasePrice' => $value['@attributes']['BasePrice'],
                        // 'ApproximateTotalPrice' => $value['@attributes']['ApproximateTotalPrice'],
                        // 'ApproximateBasePrice' => $value['@attributes']['ApproximateBasePrice'],
                        // 'EquivalentBasePrice' => isset($value['@attributes']['EquivalentBasePrice'])?$value['@attributes']['EquivalentBasePrice']:'',
                        // 'Taxes' => $value['@attributes']['Taxes'],
                        // 'ApproximateTaxes' => $value['@attributes']['ApproximateTaxes'],
                        // 'CompleteItinerary' => $value['@attributes']['CompleteItinerary'],
                        // 'Refundable' => false,
                        // 'airline' => 'Air Arabia',
                        // 'IATACODE' => 'G9',
                        'type' => 'airarabia',
                        'from' => 'mobile',
                        'transactionIdentifier' => $response['airarabia']['ns1:OTA_AirAvailRS']['@attributes']['TransactionIdentifier'],
                    ))
                );
            }

            usort($result, function($a, $b) {
                return $a['amount'] <=> $b['amount'];
            });
        }

        /*Jazeera Round Trip START*/
        if(isset($response['airjazeera']) && empty($response['airjazeera'][0]['dotrezAPI']['dotrezErrors']['errors']) && !empty($response['airjazeera']['availabilityv4']['results']) && !empty($response['airjazeera']['availabilityv4']['faresAvailable'])){
            $data                       = $response['airjazeera']['availabilityv4']; 
            $flightClass                = $response['search_request']['flight-class'];
            $arabiaOriginAirPort        = $response['userOrigin'];
            $arabiaDestinationAirPort   = $response['userDestination'];  
            $tokenData                  = isset($response['tokenData']) ? $response['tokenData'] : null;
            $jazeeratraceId             = isset($response['trace_id']) && !empty($response['trace_id']) ? $response['trace_id'] : null;
            $bookingController          = new BookingController();
            $frontEndHomeController     = new \App\Http\Controllers\FrontEnd\HomeController();
            $data           = $response['airjazeera'];
            $originCurrency = $data['availabilityv4']['currencyCode'];
            $responses      = array(); // Array to store the responses
            $newTrips       = [];
            $resultsCount   = 1;
            foreach ($data['availabilityv4']['results'] as $results) {
                $trips = $results['trips'];
                foreach ($trips as $trip) {
                    $journeys = $trip['journeysAvailableByMarket'];

                    foreach ($journeys as $journey) {
                        $key = $journey['key'];
                        $values = $journey['value'];
                        foreach ($values as $value) {
                            $fares = $value['fares'];
                            foreach ($fares as $fare) {
                                $fareAvailabilityKey = $fare['fareAvailabilityKey'];
                                $matchedFare = null;
                                foreach ($data['availabilityv4']['faresAvailable'] as $faresAvailable) {
                                    if (isset($faresAvailable['key']) && $faresAvailable['key'] === $fareAvailabilityKey) {
                                        $matchedFare = $faresAvailable;
                                        break;
                                    }
                                }
                                if ($matchedFare !== null) {
                                    $fare['fareAvailable'] = $matchedFare; 
                                }

                                $productClass = $fare['fareAvailable']['value']['fares'][0]['productClass'];
                                if (($flightClass == "Economy" && (in_array($productClass, ["EL", "EV", "EE"]) && in_array($productClass, ["EL", "EV", "EE"]))) || ($flightClass === "Business" && (in_array($productClass, ["BU"]) && in_array($productClass, ["BU"]))))
                                {

                                    $newTrip = [
                                        "key"           => $key,
                                        "date"          => $trip['date'],
                                        "value"         => $value,
                                        "fareDetails"   => $fare,
                                    ];
                                    unset($newTrip['value']['fares'], $newTrip['faresDetails']['details'], $newTrip['faresDetails']['fareAvailabilityKey']);
                                    if ($resultsCount === 1) {
                                        $newTrips['Outbound'][] = $newTrip;
                                    } else {
                                        $newTrips['Inbound'][] = $newTrip;
                                    }
                                }



                            }
                        }
                    }
                }
                $resultsCount++;
            }
            
            $outboundTrips = isset($newTrips['Outbound']) ? $newTrips['Outbound'] :null; 
            $inboundTrips = isset($newTrips['Inbound']) ? $newTrips['Inbound'] :null;
            $combinations = [];
            if(!empty($outboundTrips) && !empty($inboundTrips)){
                foreach ($outboundTrips as $outboundTrip) {
                    // Iterate over each inbound trip
                    foreach ($inboundTrips as $inboundTrip) {
                        // Create a combination with the outbound and inbound trips
                        $noOfInfants        = $response['search_request']['noofInfants'] ? (int) $response['search_request']['noofInfants'] : 0;
                        $bookingQuoteData   = null;
                        
                        if ($noOfInfants !== null && $noOfInfants > 0) {
                            // Create the key object and add it to the array
                            
                            $outBoundJourneyKey     =  $outboundTrip['value']['journeyKey'];
                            $outBoundFareKey        =  $outboundTrip['fareDetails']['fareAvailabilityKey'];
                            $inBoundJourneyKey      =  $inboundTrip['value']['journeyKey'];
                            $inBoundFareKey         =  $inboundTrip['fareDetails']['fareAvailabilityKey'];


                            $key = [
                                
                                    "outBoundJourneyKey"=> $outBoundJourneyKey,
                                    "outBoundFareKey"   => $outBoundFareKey,
                                    "inBoundJourneyKey" => $inBoundJourneyKey,
                                    "inBoundFareKey"    => $inBoundFareKey,
                            ];

                            $response['search_request']['currencyCode'] = $originCurrency;
                            $response['search_request']['tokenData']    = $tokenData;
                            $response['search_request']['requestFrom']  = "MOBILE";
                            $bookingQuoteDataResponse   = $bookingController->bookingQuoteRequestJazeera($key,$response['search_request'],$traceId=null);
                            //dd($bookingQuoteDataResponse);
                            if(isset($bookingQuoteDataResponse) && isset($bookingQuoteDataResponse['jazeeraResponse']) && isset($bookingQuoteDataResponse['jazeeraResponse']['breakdown']) && !empty($bookingQuoteDataResponse['jazeeraResponse']['breakdown'])){
                                $bookingQuoteData = $bookingQuoteDataResponse['jazeeraResponse']['breakdown'];
                            }

                        }

                        //Time calculation if > 90 minutes
                        $outboundArrivalTime        = $outboundTrip['value']['designator']['arrival'];
                        $inboundDepartTime          = $inboundTrip['value']['designator']['departure'];
                        $outboundArrivalTimestamp   = strtotime($outboundArrivalTime);
                        $inboundDepartTimestamp     = strtotime($inboundDepartTime);
                        $timeDifference             = $inboundDepartTimestamp - $outboundArrivalTimestamp;
                         // Check if the time difference is at least 90 minutes
                        if ($timeDifference >= 90 * 60) { // 90 minutes = 90 * 60 seconds
                            // Create a combination with the outbound and inbound trips
                            $combination = [
                                'outbound' => $outboundTrip,
                                'inbound' => $inboundTrip,
                                'breakdown'=>$bookingQuoteData,
                            ];

                            // Add the combination to the list
                            $combinations[] = $combination;
                        }
                    }
                }    
            }
            
            $itinerary = [];
            $airlinedetails = Airline::whereVendorCode('J9')->first();
            $airlineAdded = false; // Flag variable

            foreach ($combinations as $allJourney) {

                $outBoundProductClass   = $allJourney['outbound']['fareDetails']['fareAvailable']['value']['fares'][0]['productClass'];
                $inBoundProductClass    = $allJourney['inbound']['fareDetails']['fareAvailable']['value']['fares'][0]['productClass'];
                
                if (($flightClass == "Economy" && (in_array($inBoundProductClass, ["EL", "EV", "EE"]) && in_array($outBoundProductClass, ["EL", "EV", "EE"]))) || ($flightClass === "Business" && (in_array($inBoundProductClass, ["BU"]) && in_array($outBoundProductClass, ["BU"]))))
                {

                    /*ADD AIRLINE*/
                    if (!$airlineAdded) {
                        if(count($airLine) == 0)
                        {
                            $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                        }
                        else{
                            $Ai = array_search($airlinedetails->name, array_column($airLine , "name"));
                            if(gettype($Ai) == "boolean")
                            {
                                $airLine[] = array('name' => $airlinedetails->name,'IATACODE'=>$airlinedetails->vendor_code);
                                $airlineAdded = true;
                            }
                        }
                    }
                    /*END*/

                    $infantTax            = 0;
                    $infantTotal          = 0;

                     //check infant base price and tax if available
                    if(isset($allJourney['breakdown']) && !empty($allJourney['breakdown']['passengerTotals']['infant'])){
                        $infantTotal    = $allJourney['breakdown']['passengerTotals']['infant']['total'];
                        $infantTax      = $allJourney['breakdown']['passengerTotals']['infant']['taxes'];
                    }

                    //total for inbound and outbund flights
                    $outBoundTotals   =  $allJourney['outbound']['fareDetails']['fareAvailable']['value']['totals']['fareTotal'];
                    $inBoundTotals    =  $allJourney['inbound']['fareDetails']['fareAvailable']['value']['totals']['fareTotal'];
                    $outBoundTax      =  $outBoundTotals - $allJourney['outbound']['fareDetails']['fareAvailable']['value']['totals']['revenueTotal'];
                    $inBoundTax       =  $inBoundTotals - $allJourney['inbound']['fareDetails']['fareAvailable']['value']['totals']['revenueTotal'];  
                    $TotalPrice                     = $outBoundTotals + $inBoundTotals + $infantTotal + $infantTax;
                    $tax                            = $outBoundTax + $inBoundTax +  $infantTax;
                    $journeyDetails                 = $allJourney;
                    $ApproximateBasePrice           = $TotalPrice - $tax;
                    $convertedTotalPrice            = getCurrencyConversionData($TotalPrice, $originCurrency);
                    $convertedTax                   = getCurrencyConversionData($tax, $originCurrency);
                    $convertedApproximateBasePrice  = getCurrencyConversionData($ApproximateBasePrice, $originCurrency);
                    $mKprice = markUpPrice($convertedTotalPrice,$convertedTax,$convertedApproximateBasePrice,'',array('currency_code' => "KWD" , 'from' => 'airjazeera'));
                    
                    $itinerary             = [];
                    $outboundItinerary     = [];
                    $inboundItinerary      = []; 
                    $outbound              = $allJourney['outbound'];
                    $inbound               = $allJourney['inbound'];
                    $outBoundProductClass  = $outbound['fareDetails']['fareAvailable']['value']['fares'][0]['productClass'];
                    $inBoundProductClass   = $inbound['fareDetails']['fareAvailable']['value']['fares'][0]['productClass'];
                    
                    // Extract values for the outbound segment
                    $outBoundeDepatureTime = DateTimeSpliter($outbound['value']['designator']['departure'], 'time');
                    $outBoundeDepatureDate = DateTimeSpliter($outbound['value']['designator']['departure'], 'date');
                    $outBoundedArrivalTime = DateTimeSpliter($outbound['value']['designator']['arrival'], 'time');
                    $outBoundedArrivalDate = DateTimeSpliter($outbound['value']['designator']['arrival'], 'date');

                    // Extract values for the inbound segment
                    $inBoundeDepatureTime = DateTimeSpliter($inbound['value']['designator']['departure'], 'time');
                    $inBoundeDepatureDate = DateTimeSpliter($inbound['value']['designator']['departure'], 'date');
                    $inBoundedArrivalTime = DateTimeSpliter($inbound['value']['designator']['arrival'], 'time');
                    $inBoundedArrivalDate = DateTimeSpliter($inbound['value']['designator']['arrival'], 'date');

                    $totalMinutesWithoutLayoverOutbound=0;
                    $outboundItinerary = [];
                    foreach ($outbound['value']['segments'] as $segment) {

                        /*$departureDate      = DateTimeSpliter($segment['designator']['departure'], 'date');
                        $departureTime      = DateTimeSpliter($segment['designator']['departure'], 'time');
                        $departureDateTime  = Carbon::parse($departureDate . ' ' . $departureTime);
                        $arrivalDate        = DateTimeSpliter($segment['designator']['arrival'], 'date');
                        $arrivalTime        = DateTimeSpliter($segment['designator']['arrival'], 'time');
                        $arrivalDateTime    = Carbon::parse($arrivalDate . ' ' . $arrivalTime);
                        $flightTravelTime   = $arrivalDateTime->diff($departureDateTime)->format('%H:%I');*/
                        /*newcode*/
                        $departureTimeUtc       = $segment['legs'][0]['legInfo']['departureTimeUtc'];
                        $arrivalTimeUtc         = $segment['legs'][0]['legInfo']['arrivalTimeUtc'];
                        $departureDateTimeUtc   = new DateTime($departureTimeUtc, new DateTimeZone('UTC'));
                        $arrivalDateTimeUtc     = new DateTime($arrivalTimeUtc, new DateTimeZone('UTC'));
                        $flightDuration         = $departureDateTimeUtc->diff($arrivalDateTimeUtc);
                        $flightTravelTime       = $flightDuration->format('%H:%I');
                        $totalMinutesWithoutLayoverOutbound += $frontEndHomeController->convertFlightTravelTimeToMinutes($flightTravelTime);
                        /*end new*/

                        $outboundItinerary[] = [
                            'AirSegment' => [
                                'segment'                   => $segment,
                                'Carrier'                   => $segment['identifier']['carrierCode'],
                                'airline'                   => "Jazeera-Airways",
                                'FlightNumber'              => $segment['identifier']['identifier'],
                                'DepartureDate'             => $segment['designator']['departure'],
                                'ArrivalDate'               => $segment['designator']['arrival'],
                                'OriginAirportDetails'      => $this->AirportDetails($segment['designator']['origin']),
                                'DestationAirportDetails'   => $this->AirportDetails($segment['designator']['destination']),
                                'FlightTravelTime'          => $flightTravelTime,
                                'from'                      => 'mobile',                                
                                'segmentType'               => 'outbound'
                            ],
                        ];
                    }

                    // Create the inbound itinerary structure
                    $totalMinutesWithoutLayoverInbound=0;
                    $inboundItinerary = [];
                    foreach ($inbound['value']['segments'] as $segment) {
                        /*$departureDate      = DateTimeSpliter($segment['designator']['departure'], 'date');
                        $departureTime      = DateTimeSpliter($segment['designator']['departure'], 'time');
                        $departureDateTime  = Carbon::parse($departureDate . ' ' . $departureTime);
                        $arrivalDate        = DateTimeSpliter($segment['designator']['arrival'], 'date');
                        $arrivalTime        = DateTimeSpliter($segment['designator']['arrival'], 'time');
                        $arrivalDateTime    = Carbon::parse($arrivalDate . ' ' . $arrivalTime);
                        $flightTravelTime = $arrivalDateTime->diff($departureDateTime)->format('%H:%I');*/

                         /*newcode*/
                        $departureTimeUtc       = $segment['legs'][0]['legInfo']['departureTimeUtc'];
                        $arrivalTimeUtc         = $segment['legs'][0]['legInfo']['arrivalTimeUtc'];
                        $departureDateTimeUtc   = new DateTime($departureTimeUtc, new DateTimeZone('UTC'));
                        $arrivalDateTimeUtc     = new DateTime($arrivalTimeUtc, new DateTimeZone('UTC'));
                        $flightDuration         = $departureDateTimeUtc->diff($arrivalDateTimeUtc);
                        $flightTravelTime       = $flightDuration->format('%H:%I');
                        $totalMinutesWithoutLayoverInbound += $frontEndHomeController->convertFlightTravelTimeToMinutes($flightTravelTime);
                        /*end new*/


                        $inboundItinerary[] = [
                            'AirSegment' => [
                                'segment'                   => $segment,
                                'Carrier'                   => $segment['identifier']['carrierCode'],
                                'airline'                   => "Jazeera-Airways",
                                'FlightNumber'              => $segment['identifier']['identifier'],
                                'DepartureDate'             => $segment['designator']['departure'],
                                'ArrivalDate'               => $segment['designator']['arrival'],
                                'OriginAirportDetails'      => $this->AirportDetails($segment['designator']['origin']),
                                'DestationAirportDetails'   => $this->AirportDetails($segment['designator']['destination']),
                                'FlightTravelTime'          => $flightTravelTime,
                                'from'                      => 'mobile',                                
                                'segmentType'               => 'inbound'
                            ],
                        ];
                    }

                    // Outbound layover time calculation
                    $totalMinutesWithLayoverOutbound   = $totalMinutesWithoutLayoverOutbound;
                    $outBoundedlayover = "";
                    $outBoundedlayover .= (count($outboundItinerary) == 1) ? "" : ((count($outboundItinerary) > 2) ? "Layovers - " : "Layover - ");
                    $outBoundedListingOriginAirPort = $outboundItinerary[0]['AirSegment']['OriginAirportDetails'];

                    foreach ($outboundItinerary as $l => $outitineryValu) {
                        if (isset($outboundItinerary[$l + 1])) { 

                            /*Layover Time*/
                            $currentSegment = $outboundItinerary[$l]['AirSegment']['segment'];
                            $currentArrival = $currentSegment['designator']['arrival'];
                            $nextSegment    = isset($outboundItinerary[$l + 1]) ? $outboundItinerary[$l + 1]['AirSegment']['segment'] : null;
                            $nextDeparture  = isset($nextSegment) ? $nextSegment['designator']['departure'] : null;
                            $layoverTime    = LayoverTime($currentArrival, $nextDeparture);
                            /*Convert in to minutes*/
                            $segmentMinutes  = $frontEndHomeController->calcualteMinutes($layoverTime);
                            $totalMinutesWithLayoverOutbound += $segmentMinutes;
                            /**/
                            $outboundItinerary[$l]['LayOverTime'] = $layoverTime;
                            $outBoundedlayover .= $outboundItinerary[$l]['AirSegment']['DestationAirportDetails']->city_name . " " . $layoverTime;
                            if (isset($outboundItinerary[$l + 2])) {
                                $outBoundedlayover .= ",";
                            }
                        } else {
                            $outboundItinerary[$l]['LayOverTime'] = '';
                        }
                        
                        // Retrieve the baggage data
                        $baggageData                = $frontEndHomeController->getBaggageForPassenger($response['search_request'], $outBoundProductClass, $outitineryValu);
                        $outitineryValu['baggage']  = $baggageData;
                        $outboundItinerary[$l] = array_merge(
                            array_slice($outboundItinerary[$l], 0, array_search('segmentType', array_keys($outboundItinerary[$l])) + 1, true),
                            ['baggage' => $baggageData],
                            array_slice($outboundItinerary[$l], array_search('segmentType', array_keys($outboundItinerary[$l])) + 1, null, true)
                        );
                        $outBoudedListingDestationAirPort = $outboundItinerary[$l]['AirSegment']['DestationAirportDetails'];
                    }
                    $outboundTotalTimeTravel = $frontEndHomeController->convertMinutesToFlightTravelTime($totalMinutesWithLayoverOutbound);
                     
                    $outBoundeDepature = $outboundItinerary[0]['AirSegment']['segment']['designator']['departure'];
                    $outBoundedArrival = $outboundItinerary[0]['AirSegment']['segment']['designator']['arrival'];

                    // Inbound layover time calculation
                    $totalMinutesWithLayoverInbound   = $totalMinutesWithoutLayoverInbound;
                    $inBoundedlayover = "";
                    $inBoundedlayover .= (count($inboundItinerary) == 1) ? "" : ((count($inboundItinerary) > 2) ? "Layovers - " : "Layover - ");
                    $inBoundedListingOriginAirPort = isset($inboundItinerary[0]) ? $inboundItinerary[0]['AirSegment']['OriginAirportDetails'] : null;

                    foreach ($inboundItinerary as $l => $initineryValue) {
                        if (isset($inboundItinerary[$l + 1])) {
                            /*Layover Time*/
                            $currentSegment = $inboundItinerary[$l]['AirSegment']['segment'];
                            $currentArrival = $currentSegment['designator']['arrival'];
                            $nextSegment    = isset($inboundItinerary[$l + 1]) ? $inboundItinerary[$l + 1]['AirSegment']['segment'] : null;
                            $nextDeparture  = isset($nextSegment) ? $nextSegment['designator']['departure'] : null;
                            $layoverTime    = LayoverTime($currentArrival, $nextDeparture);
                            /*Convert in to minutes*/
                            $segmentMinutes  = $frontEndHomeController->calcualteMinutes($layoverTime);
                            $totalMinutesWithLayoverInbound += $segmentMinutes;
                            /**/
                            $inboundItinerary[$l]['LayOverTime'] = $layoverTime;
                            $inBoundedlayover .= $inboundItinerary[$l]['AirSegment']['DestationAirportDetails']->city_name . " " . $layoverTime;
                            if (isset($inboundItinerary[$l + 2])) {
                                $inBoundedlayover .= ",";
                            }
                        } else {
                            $inboundItinerary[$l]['LayOverTime'] = '';
                        }
                        
                        // Retrieve the baggage data
                        $baggageData                = $frontEndHomeController->getBaggageForPassenger($response['search_request'], $inBoundProductClass, $initineryValue);
                        $initineryValue['baggage']  = $baggageData;
                        $inboundItinerary[$l] = array_merge(
                            array_slice($inboundItinerary[$l], 0, array_search('segmentType', array_keys($inboundItinerary[$l])) + 1, true),
                            ['baggage' => $baggageData],
                            array_slice($inboundItinerary[$l], array_search('segmentType', array_keys($inboundItinerary[$l])) + 1, null, true)
                        );
                        $inboundedListingDestationAirPort = $inboundItinerary[$l]['AirSegment']['DestationAirportDetails'];
                    }
                    $inboundTotalTimeTravel = $frontEndHomeController->convertMinutesToFlightTravelTime($totalMinutesWithLayoverInbound);

                    $inBoundeDepature = $inboundItinerary[0]['AirSegment']['segment']['designator']['departure'];
                    $inBoundedArrival = $inboundItinerary[count($inboundItinerary)-1]['AirSegment']['segment']['designator']['departure'];
                
                    $outboundconnection = count($outboundItinerary);
                    $outboundconnection = $outboundconnection - 1;
                    $inboundconnection  = count($inboundItinerary);
                    $inboundconnection  = $inboundconnection - 1;

                    if(count($stops) == 0)
                    {
                        $stops[] = array('name' => Connections($outboundconnection) ,'count'=>1);
                    }
                    else{
                        $Ai = array_search(Connections($outboundconnection), array_column($stops , "name"));
                        if(gettype($Ai) == "boolean")
                        {
                            $stops[] = array('name' => Connections($outboundconnection) ,'count' =>1);
                        }
                        else{
                            $stops[$Ai]['count'] =  $stops[$Ai]['count'] + 1;
                        }
                    }

                    /* minPrice and maxPrice funtion*/
                    if($mKprice)
                    {
                        $price = $mKprice['totalPrice']['value'];
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
                    
                    /*$outboundDeparture          = $outboundItinerary[0]['AirSegment']['segment']['designator']['departure'];
                    $outboundArrival            = $outboundItinerary[count($outboundItinerary) - 1]['AirSegment']['segment']['designator']['arrival'];
                    $outboundTotalTimeTravel    = LayoverTime($outboundDeparture, $outboundArrival);

                    $inboundDeparture           = $inboundItinerary[0]['AirSegment']['segment']['designator']['departure'];
                    $inboundArrival             = $inboundItinerary[count($inboundItinerary) - 1]['AirSegment']['segment']['designator']['arrival'];
                    $inboundTotalTimeTravel     = LayoverTime($inboundDeparture, $inboundArrival);*/

                    // Desired structure and assign the extracted values to $result

                    $result[] = [
                        'outBoundlayover'                   =>  $outBoundedlayover,
                        'inBoundlayover'                    =>  $inBoundedlayover,
                        'outBoundeDepature'                 =>  $outbound['value']['designator']['departure'],
                        'outBoundedArrival'                 =>  $outbound['value']['designator']['arrival'],
                        'inBoundeDepature'                  =>  $inbound['value']['designator']['departure'],
                        'inBoundedArrival'                  =>  $inbound['value']['designator']['arrival'],
                        'outboundconnection'                =>  $outboundconnection,
                        'inboundconnection'                 =>  $inboundconnection,
                        'outboundtotaltimeTravel'           =>  $outboundTotalTimeTravel,
                        'inboundtotaltimeTravel'            =>  $inboundTotalTimeTravel,
                        'Origin'                            =>  $Origin,
                        'Destination'                       =>  $Destination,
                        'outBoundedOriginAirportDetails'    =>  $outBoundedListingOriginAirPort,
                        'outBoundedDestationAirportDetails' =>  $outBoudedListingDestationAirPort,
                        'inBoundedOriginAirportDetails'     =>  $inBoundedListingOriginAirPort,
                        'inBoundedDestationAirportDetails'  =>  $inboundedListingDestationAirPort,
                        'Refundable'                        =>  "false",
                        'airline'                           =>  'Jazeera Airways',
                        'IATACODE'                          =>  'J9',
                        'airlineOutBound'                   =>  'Jazeera Airways',
                        'IATACODEOutBound'                  =>  'J9',
                        'airlineInBound'                    =>  'Jazeera Airways',
                        'IATACODEInBound'                   =>  'J9',
                        'type'                              =>  'airjazeera',
                        'amount'                            =>  $mKprice['totalPrice']['value'],
                        'currency_code'                     =>  $mKprice['totalPrice']['currency_code'],
                        'transactionIdentifier'             =>  null,
                        'compltedData' => json_encode(array(
                            'traceId'           =>  $jazeeratraceId,
                            'markupPrice'       =>  $mKprice,
                            'outboundItinerary' =>  $outboundItinerary,
                            'inboundItinerary'  =>  $inboundItinerary,
                            'type'              =>  'airjazeera',
                            'from'              =>  'mobile',
                            'outBoundJourneyKey'=>  $outbound['value']['journeyKey'],
                            'outBoundFareKey'   =>  $outbound['fareDetails']['fareAvailabilityKey'],
                            'inBoundJourneyKey' =>  $inbound['value']['journeyKey'],
                            'inBoundFareKey'    =>  $inbound['fareDetails']['fareAvailabilityKey'],
                            'originCurrency'    =>  $originCurrency,
                            'numberOfinfant'    =>  isset($response['search_request']['noofInfants']) ? $response['search_request']['noofInfants'] : 0,
                            'tokenData'         => $tokenData,
                        )) 

                    ];       
                }   
            }

            usort($result, function($a, $b) {
                return $a['amount'] <=> $b['amount'];
            });
        }
        /*Jazeera Round Trip END*/
        return array(
            'result' => $result,
            'airLines' => $airLine,
            'stops' => $stops,
            'Origin' => $Origin,
            'Destination' => $Destination,
            'OriginCityDetails' => $OriginCityDetails,
            'DestationCityDetails' => $DestationCityDetails,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'tarceId' => $traceId
        );
    }



    public function AirSegmentAndFlightDetails($response , $segmentRefNumber ,$bookingCode)
    {
        $index = array_search($segmentRefNumber,array_column(array_column($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'],'@attributes'),'Key'));
        // $FlightDetailsRef = $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['air:FlightDetailsRef']['@attributes']['Key'];
        // $FlightDetailsIndex = array_search($FlightDetailsRef,array_column(array_column($response['air:LowFareSearchRsp']['air:FlightDetailsList']['air:FlightDetails'],'@attributes'),'Key'));
        $Origin = $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['Origin'];
        $Destination = $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['Destination'];
        $OriginAirportDetails = $this->AirportDetails($Origin);
        $DestationAirportDetails = $this->AirportDetails($Destination);
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['OriginAirportDetails'] = $OriginAirportDetails;
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['DestationAirportDetails'] = $DestationAirportDetails;
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['Carrier'] = $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['Carrier'];
        $airline = Airline::whereVendorCode($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['Carrier'])->first();
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['airline'] = $airline->name;
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['cleanDepartureTime'] = DateTimeSpliter($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['DepartureTime'],'time');
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['cleanArrivalTime'] = DateTimeSpliter($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['ArrivalTime'],'time');
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['cleanDepartureDate'] = DateTimeSpliter($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['DepartureTime'],'date');
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['cleanArrivalDate'] = DateTimeSpliter($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['ArrivalTime'],'date');
        $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['FlightTravelTime'] = segmentTime($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['FlightTime']);
        return array(
            'AirSegment' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes'],
            'BookingCode' => $bookingCode,
            //'FlightDetails' => $response['air:LowFareSearchRsp']['air:FlightDetailsList']['air:FlightDetails'][$FlightDetailsIndex]['@attributes'],
        );
        

    }

    public function Details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'completeData' => ['required'],
            'userRequest' => ['required']
        ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         "message" => $validator->errors(),
        //     ], 200);
        // } 
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
    
        $flights = json_decode($request->input('completeData') ,true);
        $userRequest = json_decode($request->input('userRequest'),true);


        $traceId = $flights['traceId'];
        // $fromCode = strtoupper($userRequest['flightFromAirportCode']);
        // $toCode = strtoupper($userRequest['flightToAirportCode']);


        $AirBooking = new BookingController();

       

        if($flights['type'] == 'travelport'){
            $parsingData = $this->TravelportAirPricingDetails($flights,$userRequest,$traceId,$extraInfo =[]);
        }
        elseif($flights['type'] == 'airarabia'){
            $parsingData = $this->AirArabiaDetails($flights,$userRequest,$traceId,$extraInfo =['page_type' => 'details']);
        }elseif($flights['type'] == 'airjazeera'){
            $parsingData = $this->AirJazeeraDetails($flights,$userRequest,$traceId,$extraInfo = ['page_type' => 'details']);
        }
        else{
            //error page
        }

        if($parsingData['status'] == true){
            $currentDate = Carbon::now()->toDateString();
            $couponCodes = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->whereIn('coupon_valid_on' ,[2,3])->get();
            $parsingData['data']['availableCouponCode'] = $couponCodes;
            $fromAirport = $userRequest['flightFromAirportCode'];
            $toAirport = $userRequest['flightToAirportCode'];
            $OriginAirportDetails = $this->AirportDetails($fromAirport);
            $DestationAirportDetails = $this->AirportDetails($toAirport);
            $parsingData['data']['city_info'] = ['from'=>$OriginAirportDetails , 'to' =>$DestationAirportDetails];
        }
       
        return response()->json($parsingData, 200);
    }

    public function TravelportAirPricingDetails($flights,$userRequest,$traceId,$extraInfo =[])
    {

        if(!(isset($extraInfo['xmlresponse']) && !empty($extraInfo['xmlresponse']) )){
            $AirBooking = new BookingController();
            $airPricingrResponse = $AirBooking->AirPricing($flights,$userRequest,$traceId);
            $response = $airPricingrResponse['travelportResponse'];
            $detailsRequestId = $airPricingrResponse['travelportRequest']->id;
        }
        else{
            $airPricingrResponse = $extraInfo['xmlresponse'];
            $response = $airPricingrResponse;
            $detailsRequestId = $extraInfo['detailsRequestId'];
        }
        
        //$response = $airPricingrResponse['travelportResponse'];
        
        if(!isset($response['air:AirPriceRsp']))
        {
            // return response()->json([
            //     'status' => false,
            //     'message' => $response['SOAP:Fault']['faultstring'],
            // ], 200);
            return array(
                'status' => false,
                'message' => $response['SOAP:Fault']['faultstring']
            );
        }

        // $traceId = $response['air:AirPriceRsp']['@attributes']['TraceId'];
        // dd( $response['air:AirPriceRsp']);
        if(isset($response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution']) )
        {
            if(isset($response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution']['@attributes']))
            {
                //only one airprice
                $AirPrice = $response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution'];
                // $AirPricingsessionData['air:AirPricingSolution'] = $response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution'];

            }
            else{
                //multiple Air Price we will take only first one
                $AirPrice = $response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution'][0];
                // $AirPricingsessionData['air:AirPricingSolution'] = $response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution'][0];
            }
           

            $result['air:AirPricingSolution']['@attributes'] = $AirPrice['@attributes'];

            $additonalInfo = ['RequestIsFrom' => 'api'];
            $additonalInfo['couponCode'] = (isset($extraInfo['couponCode']) && !empty($extraInfo['couponCode'])) ? $extraInfo['couponCode'] : null;
     
            $mKprice = markUpPrice($result['air:AirPricingSolution']['@attributes']['TotalPrice'],$result['air:AirPricingSolution']['@attributes']['Taxes'],$result['air:AirPricingSolution']['@attributes']['ApproximateBasePrice'] , ((!empty($extraInfo) && isset($extraInfo['type_of_payment'])) ? $extraInfo['type_of_payment'] : 'k_net'), $additonalInfo);

            $result['air:AirPricingSolution']['@attributes']['markupPrice'] = $mKprice;
            

            if(isset($AirPrice['air:AirSegmentRef']['@attributes']))
            {
                //only one air Segment
                $index = array_search($AirPrice['air:AirSegmentRef']['@attributes']['Key'],array_column(array_column($response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'],'@attributes'),'Key'));
                if(isset($response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment']['@attributes']))
                {
                    $result['air:AirPricingSolution']['AirSegment'][] = $response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'];
                }
                else{
                    $result['air:AirPricingSolution']['AirSegment'][] = $response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'][$index];
                }

                $Origin = $result['air:AirPricingSolution']['AirSegment'][0]['@attributes']['Origin'];
                $Destination = $result['air:AirPricingSolution']['AirSegment'][0]['@attributes']['Destination'];
                $OriginAirportDetails = $this->AirportDetails($Origin);
                $DestationAirportDetails = $this->AirportDetails($Destination);
                $result['air:AirPricingSolution']['AirSegment'][0]['@attributes']['OriginAirportDetails'] = $OriginAirportDetails;
                $result['air:AirPricingSolution']['AirSegment'][0]['@attributes']['DestationAirportDetails'] = $DestationAirportDetails;
            }
            else{
                //multiple Air Segments
                foreach($AirPrice['air:AirSegmentRef'] as $segments)
                {
                    $index = array_search($segments['@attributes']['Key'],array_column(array_column($response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'],'@attributes'),'Key'));
                    if(isset($response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment']['@attributes']))
                    {
                        $result['air:AirPricingSolution']['AirSegment'][] = $response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'];
                    }
                    else{
                        
                        $result['air:AirPricingSolution']['AirSegment'][] = $response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'][$index];
                    }
                    
                }
                foreach($result['air:AirPricingSolution']['AirSegment'] as $A=>$Asegment)
                {
                    $Origin = $result['air:AirPricingSolution']['AirSegment'][$A]['@attributes']['Origin'];
                    $Destination = $result['air:AirPricingSolution']['AirSegment'][$A]['@attributes']['Destination'];
                    $OriginAirportDetails = $this->AirportDetails($Origin);
                    $DestationAirportDetails = $this->AirportDetails($Destination);
                    $result['air:AirPricingSolution']['AirSegment'][$A]['@attributes']['OriginAirportDetails'] = $OriginAirportDetails;
                    $result['air:AirPricingSolution']['AirSegment'][$A]['@attributes']['DestationAirportDetails'] = $DestationAirportDetails;
                }
            }
        
            
            $result['air:AirPricingSolution']['air:AirPricingInfo'] = $AirPrice['air:AirPricingInfo'];
            $result['air:AirPricingSolution']['air:FareNote'] = $AirPrice['air:FareNote'];
            $result['air:AirPricingSolution']['common_v52_0:HostToken'] = $AirPrice['common_v52_0:HostToken'];

            if(isset($result['air:AirPricingSolution']['air:AirPricingInfo']['@attributes']))
            {
                $temp = '';
                $temp = $result['air:AirPricingSolution']['air:AirPricingInfo'];
                $result['air:AirPricingSolution']['air:AirPricingInfo'] = [];
                $result['air:AirPricingSolution']['air:AirPricingInfo'][0] = $temp;
            }

            //refund
            if(isset($result['air:AirPricingSolution']['air:AirPricingInfo']['@attributes']['Refundable']))
            {
                $refund = $result['air:AirPricingSolution']['air:AirPricingInfo']['@attributes']['Refundable'];
            }
            elseif(isset($result['air:AirPricingSolution']['air:AirPricingInfo'][0]['@attributes']['Refundable'])){
                $refund = $result['air:AirPricingSolution']['air:AirPricingInfo'][0]['@attributes']['Refundable'];
            }
            else{
                $refund = "false";
            }

            $result['air:AirPricingSolution']['@attributes']['Refundable'] = $refund;

            //baggage details and FareRuleKeys

            foreach($result['air:AirPricingSolution']['air:AirPricingInfo'] as $APK => $APV)
            {
                if(isset($APV['air:BaggageAllowances']['air:BaggageAllowanceInfo']['@attributes']))
                {
                    $temp = '';
                    $temp = $APV['air:BaggageAllowances']['air:BaggageAllowanceInfo'];
                    $result['air:AirPricingSolution']['air:AirPricingInfo'][$APK]['air:BaggageAllowances']['air:BaggageAllowanceInfo'] =[];
                    $result['air:AirPricingSolution']['air:AirPricingInfo'][$APK]['air:BaggageAllowances']['air:BaggageAllowanceInfo'][0] = $temp;
                }
                if(isset($APV['air:BaggageAllowances']['air:CarryOnAllowanceInfo']['@attributes']))
                {
                    $temp = '';
                    $temp = $APV['air:BaggageAllowances']['air:CarryOnAllowanceInfo'];
                    $result['air:AirPricingSolution']['air:AirPricingInfo'][$APK]['air:BaggageAllowances']['air:CarryOnAllowanceInfo'] =[];
                    $result['air:AirPricingSolution']['air:AirPricingInfo'][$APK]['air:BaggageAllowances']['air:CarryOnAllowanceInfo'][0] = $temp;
                }
                //FareRuleKeys
                if(isset($APV['air:FareInfo']['@attributes']))
                {
                    $temp = '';
                    $temp = $APV['air:FareInfo'];
                    $result['air:AirPricingSolution']['air:AirPricingInfo'][$APK]['air:FareInfo'] =[];
                    $result['air:AirPricingSolution']['air:AirPricingInfo'][$APK]['air:FareInfo'][0] = $temp;
                }
            }
            $noOfPassengerTypes = count($result['air:AirPricingSolution']['air:AirPricingInfo']);
            $chekin =[];

            foreach($result['air:AirPricingSolution']['air:AirPricingInfo'][0]['air:BaggageAllowances']['air:BaggageAllowanceInfo'] as $ke =>$val)
            {
                for ($i=0; $i < $noOfPassengerTypes; $i++) { 
            

                    if(((isset($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
                    {
                        $passengertype = "ADULT";
                    }
                    elseif(((isset($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
                    {
                        $passengertype = "CHILD";
                    }
                    elseif(((isset($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($result['air:AirPricingSolution']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
                    {
                        $passengertype = "INFANT";
                    }
                    if(!isset($chekin[$ke]))
                    {
                        $chekin[$ke] = array('@attributes'=>$val['@attributes'],'air:URLInfo'=>$val['air:URLInfo']);
                    }
                    
                    // $chekin[$ke]['table'][$passengertype] = array('air:TextInfo'=>$val['air:TextInfo']);
                    $chekin[$ke]['table'][$passengertype] = $val['air:TextInfo']['air:Text'][0];
                    //,'air:BagDetails'=> isset($val['air:BagDetails']) ? $val['air:BagDetails'] : "" 
                }

            }
            
            $result['air:AirPricingSolution']['@attributes']['chekin'] = $chekin;

            $segments = [];
            foreach ($result['air:AirPricingSolution']['AirSegment'] as $segkey => $segvalue) {
                //layover
                $layover = null;
                if(isset($result['air:AirPricingSolution']['AirSegment'][$segkey+1]))
                {
                    if($userRequest['flight-trip'] == 'roundtrip' && $result['air:AirPricingSolution']['AirSegment'][$segkey]['@attributes']['Destination'] == strtoupper($userRequest['flightToAirportCode']))
                    {
                        $layover = null ;
                    }
                    else{
                        $layover = LayoverTime($result['air:AirPricingSolution']['AirSegment'][$segkey]['@attributes']['ArrivalTime'] ,$result['air:AirPricingSolution']['AirSegment'][$segkey+1]['@attributes']['DepartureTime'] );
                    }
                }
                else
                {
                    $layover = null;
                }
                // dd($segvalue['@attributes']);
                $segments[] =  array(
                    'airarabiaData' => '',
                    'OriginAirportDetails' => $segvalue['@attributes']['OriginAirportDetails'],
                    'DestationAirportDetails' => $segvalue['@attributes']['DestationAirportDetails'],
                    'DepartureDate' => DateTimeSpliter($segvalue['@attributes']['DepartureTime'],'date'),
                    'DepartureTime' => DateTimeSpliter($segvalue['@attributes']['DepartureTime'],'time'),
                    'ArrivalDate' => DateTimeSpliter($segvalue['@attributes']['ArrivalTime'],'date'),
                    'ArrivalTime' => DateTimeSpliter($segvalue['@attributes']['ArrivalTime'],'time'),
                    'Carrier' => $segvalue['@attributes']['Carrier'],
                    'CodeshareInfo' => $segvalue['air:CodeshareInfo']['@content'],
                    'AirLine' => $segvalue['air:CodeshareInfo']['@content'],
                    'FlightNumber' => $segvalue['@attributes']['FlightNumber'],
                    'FlightTime' =>segmentTime($segvalue['@attributes']['FlightTime']),
                    'from' => 'mobile',
                    'Layover' => $layover,
                   
                );
            }
            $apidata['airSegments'] = $segments;	
            $apidata['refund'] = $refund;	
            $apidata['markupPrice'] = $mKprice;	
            $apidata['checkin'] = $chekin;	
            $apidata['type'] = 'travelport';	
            $apidata['detailsRequestId'] = $detailsRequestId;
            $apidata['userRequest'] = json_encode($userRequest);
            $apidata['transactionIdentifier'] = '';

            return array('status' => true,'message' => self::SUCCESS_MSG,'data' => $apidata	);
        }
      

    }
    

    public function AirArabiaDetails($flights,$userRequest,$traceId,$extraInfo =[])
    {
        if(!(isset($extraInfo['xmlresponse']) && !empty($extraInfo['xmlresponse']) )){
            $AirBooking = new BookingController();
            $airPricingrResponse = $AirBooking->AirArabiaPricing($flights,$userRequest,$traceId,$extraInfo);
            $response = $airPricingrResponse['travelportResponse'];
            $detailsRequestId = $airPricingrResponse['travelportRequest']->id;
        }
        else{
            $airPricingrResponse = $extraInfo['xmlresponse'];
            // dd($airPricingrResponse);
            $response = $airPricingrResponse;
            $detailsRequestId = $extraInfo['detailsRequestId'];
        }
       
        

        // $airPricingrResponse = $AirBooking->AirArabiaPricing($flights,$UserRequest,$traceId);
        // $response = $airPricingrResponse['travelportResponse'];
        // $response = file_get_contents(public_path('response.xml'));
        // $converted = XmlToArray::convert($response, $outputRoot = false);
        // $response =[];
        // $response = $converted['soap:Body'];
        // dd($response);
        if(isset($response['ns1:OTA_AirPriceRS']['ns1:Errors']['ns1:Error']))
        {
            // return response()->json([
            //     'status' => false,
            //     'message' => $response['ns1:OTA_AirPriceRS']['ns1:Errors']['ns1:Error']['@attributes']['ShortText'],
            // ], 200);
            return array(
                'status' => false,
                // 'message' => $response['ns1:OTA_AirPriceRS']['ns1:Errors']['ns1:Error']['@attributes']['ShortText'],
                'message' => "Transaction expired",
            );
        }
        else{

            // PricedItineraries
            
            if(isset($response['ns1:OTA_AirPriceRS']['ns1:PricedItineraries']['ns1:PricedItinerary']['@attributes']))
            {
                $AirPrice = $response['ns1:OTA_AirPriceRS']['ns1:PricedItineraries']['ns1:PricedItinerary'];
            }
            else{
                $AirPrice = $response['ns1:OTA_AirPriceRS']['ns1:PricedItineraries']['ns1:PricedItinerary'][0];
            }
            $segments = [];
            $TotalPrice = $AirPrice['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:TotalFare']['@attributes']['Amount'];
            $currencyCode = $AirPrice['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:TotalFare']['@attributes']['CurrencyCode'];
            $tax = $TotalPrice - $AirPrice['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:BaseFare']['@attributes']['Amount'];
            $ApproximateBasePrice = $AirPrice['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:BaseFare']['@attributes']['Amount'];

            $additonalInfo = ['RequestIsFrom' => 'api' , 'currency_code' => $currencyCode , 'from' => 'airarabia'];
            $additonalInfo['couponCode'] = (isset($extraInfo['couponCode']) && !empty($extraInfo['couponCode'])) ? $extraInfo['couponCode'] : null;
            $mKprice = markUpPrice($TotalPrice,$tax,$ApproximateBasePrice , ((!empty($extraInfo) && isset($extraInfo['type_of_payment'])) ? $extraInfo['type_of_payment'] : 'k_net' ) , $additonalInfo );
            if(isset($AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption']['ns1:FlightSegment']))
            {
                $temp = $AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'];
                $AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] = [];
                $AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'][0] = $temp;
            }
            foreach($AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] as $iK =>$itinerary)
            {
                
                $segments[] =  array(
                    'airarabiaData' => json_encode($itinerary),
                    'OriginAirportDetails' => $this->AirportDetails($itinerary['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode']),
                    'DestationAirportDetails' => $this->AirportDetails($itinerary['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode']),
                    'DepartureDate' => DateTimeSpliter($itinerary['ns1:FlightSegment']['@attributes']['DepartureDateTime'],"date"),
                    'DepartureTime' => DateTimeSpliter($itinerary['ns1:FlightSegment']['@attributes']['DepartureDateTime'],"time"),
                    'ArrivalDate' => DateTimeSpliter($itinerary['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],"date"),
                    'ArrivalTime' => DateTimeSpliter($itinerary['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],"time"),
                    'Carrier' => 'G9',
                    'CodeshareInfo' => 'Air Arabia',
                    'AirLine' => 'Air Arabia',
                    'FlightNumber' => $itinerary['ns1:FlightSegment']['@attributes']['FlightNumber'],
                    'FlightTime' =>  LayoverTime($itinerary['ns1:FlightSegment']['@attributes']['DepartureDateTime'] , $itinerary['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    'from' => 'mobile',
                    'Layover'=> null
                );
            }

            usort($segments, function($a, $b) {
                return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
            });
            
            foreach ($segments as $itkey => $itvalue) {
                $layover = null;
                if(!empty($userRequest))
                {
                    if(isset($segments[$itkey+1]))
                    {
                        if($userRequest['flight-trip'] == 'roundtrip' && $segments[$itkey]['DestationAirportDetails']->airport_code == strtoupper($userRequest['flightToAirportCode']))
                        {
                            $layover = null ;
                        }
                        else{
                            $layover = LayoverTime( $segments[$itkey]['ArrivalDate']."T".$segments[$itkey]['ArrivalTime'].":00.000+00:00", $segments[$itkey+1]['DepartureDate']."T".$segments[$itkey+1]['DepartureTime'].":00.000+00:00");
                        }
                    }
                    else
                    {
                        $layover = null;
                    }
                    
                }
                $segments[$itkey]['Layover'] = $layover;
            }
           

            if((isset($userRequest['flight-trip']) && $userRequest['flight-trip'] == 'roundtrip') || (isset($extraInfo['booking_type']) && $extraInfo['booking_type'] == 'roundtrip'))
            {
                //no change for oneway
                
                $bound = 'outbound' ;
                $flightToAirportCode = isset($userRequest['flightToAirportCode']) ? $userRequest['flightToAirportCode'] : $extraInfo['flightToAirportCode'];
                foreach ($segments as $segkey => $segvalue) {
                    $segments[$segkey]['segmentType'] = $bound;
                    if($segvalue['DestationAirportDetails']->airport_code == $flightToAirportCode){
                        $bound = 'inbound' ;
                    }
                }
            }

            $apidata['airSegments'] = $segments;	
            $apidata['refund'] = "false";	
            $apidata['markupPrice'] = $mKprice;	
            $apidata['airAirabiaCheckin'] = '10 kg';	
            $apidata['type'] = 'airarabia';	
            $apidata['transactionIdentifier'] = $response['ns1:OTA_AirPriceRS']['@attributes']['TransactionIdentifier'];
            $apidata['pricing'] = $AirPrice['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:TotalFare']; 
            // $apidata['completeData'] = json_encode($result);	
            $apidata['detailsRequestId'] = $detailsRequestId;
            $apidata['userRequest'] = json_encode($userRequest);
            if(isset($extraInfo['page_type']) && ($extraInfo['page_type'] == 'details'))
            {
                //Baggage details 
                if($userRequest['flight-trip'] == 'roundtrip')
                {
                    $apidata['DepartureExtraBaggage'] = $this->airArabiaExtraBaggage(array('flightDetails' => $apidata , 'UserRequest' => $userRequest , 'traceId' => $traceId ,'bound' => 'outbound'));
                    $apidata['ReturnExtraBaggage'] = $this->airArabiaExtraBaggage(array('flightDetails' => $apidata , 'UserRequest' => $userRequest , 'traceId' => $traceId ,'bound' => 'inbound'));
                }
                else{
                    $apidata['DepartureExtraBaggage'] = $this->airArabiaExtraBaggage(array('flightDetails' => $apidata , 'UserRequest' => $userRequest , 'traceId' => $traceId ));
                }
            }
            return array(
                'status' => true,	
                'message' => self::SUCCESS_MSG,	
                "data" => $apidata	
            );
        }

    }
    //  $apidata['airSegments'] = $segments;	
    //         $apidata['refund'] = $refund;	
    //         $apidata['markupPrice'] = $mKprice;	
    //         $apidata['checkin'] = $chekin;	
    //         // $apidata['completeData'] = json_encode($result);	
    //         $apidata['detailsRequestId'] = $airPricingrResponse['travelportRequest']->id;
    //         $apidata['userRequest'] =  json_encode($userRequest);

    public function SavePassangerDetails(Request $request)
    {
        //saving passenger details and providing data for preview

        $input = $request->all();
        $rules = [];
       
        $rules['users'] = 'required';
        if($request->exists('users') )
        {
            foreach($input['users'] as $key => $val)
            {
                $rules['users.'.$key.'.passengerType'] = 'required|min:3';
                
                if($request->exists('users.'.$key.'.passengerType') && $request->input('users.'.$key.'.passengerType') == 'ADT')
                {
                    $rules['users.'.$key.'.title'] = 'required';
                    $rules['users.'.$key.'.firstName'] = 'required';
                    $rules['users.'.$key.'.lastName'] = 'required|min:2';
                    $rules['users.'.$key.'.dob'] = ['required',new DOBChek('ADT')];
                    $rules['users.'.$key.'.passportNumber'] = 'required';
                    $rules['users.'.$key.'.passportIssueCountry'] = 'required';
                    $rules['users.'.$key.'.passportExpireDate'] = 'required|after:today';
                }elseif($request->exists('users.'.$key.'.passengerType') && $request->input('users.'.$key.'.passengerType') == 'CNN')
                {
                    $rules['users.'.$key.'.title'] = 'required';
                    $rules['users.'.$key.'.firstName'] = 'required';
                    $rules['users.'.$key.'.lastName'] = 'required|min:2';
                    $rules['users.'.$key.'.dob'] = ['required',new DOBChek('CNN')];
                    $rules['users.'.$key.'.passportNumber'] = 'required';
                    $rules['users.'.$key.'.passportIssueCountry'] = 'required';
                    $rules['users.'.$key.'.passportExpireDate'] = 'required';
                }elseif($request->exists('users.'.$key.'.passengerType') && $request->input('users.'.$key.'.passengerType') == 'INF')
                {
                    $rules['users.'.$key.'.title'] = 'required';
                    $rules['users.'.$key.'.firstName'] = 'required';
                    $rules['users.'.$key.'.lastName'] = 'required|min:2';
                    $rules['users.'.$key.'.dob'] = ['required',new DOBChek('INF')];
                    $rules['users.'.$key.'.passportNumber'] = 'required';
                    $rules['users.'.$key.'.passportIssueCountry'] = 'required';
                    $rules['users.'.$key.'.passportExpireDate'] = 'required';
                }

            }
           
        }
        $errorMessage = [
            'users.*.title.required' => 'Please select Title',
            'users.*.firstName.required' => 'Please enter first name',
            'users.*.lastName.required' => 'Please enter last name',
            'users.*.dob.required' => 'Please select date of birth',
            'users.*.passportNumber.required' => 'Please enter passport number',
            'users.*.passportIssueCountry.required' => 'Please select passport issued country',
            'users.*.passportExpireDate.required' => 'Please select passport expire date',
            'users.*.passportExpireDate.after' => 'passport have been expired',
        ];
        
       
        $rules['email'] = 'required';
        $rules['countryId'] = 'required';
        $rules['mobile'] = 'required';
        $rules['detailsRequestId'] = 'required';
        $rules['userRequest'] = 'required';

        $validator = Validator::make($input, $rules , $errorMessage);

        //Now check validation:
        // if ($validator->fails()) 
        // { 
        //     return response()->json([
        //         'status' => false,
        //         "message" => $validator->errors(),
        //     ], 200);

        // }
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
        
        $userRequest = json_decode($request->input('userRequest'),true);
        $flights = json_decode($request->input('completeData') ,true);
        // if($userRequest['noofAdults'] == $request['users'])
        $countdata = array_count_values(array_column($request['users'], 'passengerType'));
        if(($userRequest['noofAdults'] > 0 && isset($countdata['ADT']) && $userRequest['noofAdults'] != $countdata['ADT']) ||($userRequest['noofChildren'] > 0 && isset($countdata['CNN']) && $userRequest['noofChildren'] != $countdata['CNN'])  || ($userRequest['noofInfants'] > 0 && isset($countdata['INF']) && $userRequest['noofInfants'] != $countdata['INF']))
        {
            return response()->json([
                'status' => false,
                "message" => "Invalid data",
            ], 200);
        }
      
        $couponCode = null ;
        if($request->has('couponCode') && !empty($request->input('couponCode'))){
            $couponCode = $request->input('couponCode') ;   
        }
      
        $fromCode = strtoupper($userRequest['flightFromAirportCode']);
        $toCode = strtoupper($userRequest['flightToAirportCode']);
        $xmlData = TravelportRequest::find($request->input('detailsRequestId'));

        $traceId =$xmlData->trace_id;
        // $airPricingrResponse = $this->TravelportAirApi(array('xml' => $xmlData->request_xml,'trace_id' => $xmlData->trace_id,'request_type' => 'airPricing'));

        // $response = $airPricingrResponse['travelportResponse'];
         
        if($xmlData['supplier'] == 'travelport' || $xmlData['supplier'] == 'airarabia'){
            $airPricingrResponse = $xmlData->response_xml;
            $responseArray = XmlToArray::convert($airPricingrResponse, $outputRoot = false);
        }
        if($xmlData['supplier'] == 'travelport'){
          
            $airPricingrResponse = $responseArray['SOAP:Body'];

            $parsingData = $this->TravelportAirPricingDetails([],$userRequest,$traceId,$extraInfo =['xmlresponse' => $airPricingrResponse ,'type_of_payment' => $request->input('type_of_payment'),'detailsRequestId'=>$request->input('detailsRequestId'),'couponCode' => $couponCode]);
            $detailsRequestId = $request->input('detailsRequestId');
        }
        elseif($xmlData['supplier'] == 'airarabia'){
            $airPricingrResponse = $responseArray['soap:Body'];
            // $parsingData = $this->AirArabiaDetails([],$userRequest,$traceId,$extraInfo =['xmlresponse' => $airPricingrResponse ,'type_of_payment' => $request->input('type_of_payment'),'detailsRequestId'=>$request->input('detailsRequestId')]);

            $parsingData = $this->AirArabiaDetails($flights,$userRequest,$traceId,$extraInfo =['type_of_payment' => $request->input('type_of_payment'),'page_type' => 'preview','travelersInfo' => $request->input('users'),'couponCode' => $couponCode]);
            if($parsingData['status']){
                $detailsRequestId = $parsingData['data']['detailsRequestId'];
            }

        }
        elseif($xmlData->supplier =="jazeera"){
            $parsingData = $this->AirJazeeraDetails($flights,$userRequest,$traceId,$extraInfo =['type_of_payment' => $request->input('type_of_payment'),'page_type' => 'preview','travelersInfo' => $request->input('users'), 'requestTFrom'=>'MOBILE','couponCode' => $couponCode]);
            if($parsingData['status']){
                $detailsRequestId = $parsingData['data']['detailsRequestId'];
            }
            $xmlData['supplier'] = "airjazeera";
        }
        else{
            //error page
            
        }

        if(!$parsingData['status']){
            return response()->json(
                $parsingData
            , 200);
        }
        // dd("123");

        $FlightBooking = new FlightBooking();
        $FlightBooking->booking_type = ($userRequest['flight-trip']=='onewaytrip') ? 'oneway':$userRequest['flight-trip'];
        $FlightBooking->preview_travelport_request_id = $detailsRequestId;
        $FlightBooking->trace_id = $detailsRequestId;

        //for now guest user only
        
        if(auth('api')->user())
        {
            $FlightBooking->user_id = auth('api')->user()->id;
            // $userName = Auth::guard('web')->user()->name;
            $FlightBooking->user_type = 'app';
        }
        else
        {
            // $userName = 'guest';
            $FlightBooking->user_type = 'app_guest';
            $GuestUser = new GuestUser();
            $GuestUser->mobile = $request->input('mobile');
            $GuestUser->country_id = $request->input('countryId');
            $GuestUser->email = $request->input('email');
            $GuestUser->user_type = 'app';
            $GuestUser->save();
        }
        $FlightBooking->mobile = $request->input('mobile');
        $FlightBooking->country_id = $request->input('countryId');
        $FlightBooking->email = $request->input('email');
        // $FlightBooking->session_uuid = null;

        
        // $FlightBooking->currency_code = $result['air:AirPricingSolution']['@attributes']['markupPrice']['FatoorahPaymentAmount']['currency_code'];
        // $FlightBooking->total_amount = $result['air:AirPricingSolution']['@attributes']['markupPrice']['FatoorahPaymentAmount']['value'];
        // $FlightBooking->basefare = $result['air:AirPricingSolution']['@attributes']['markupPrice']['basefare']['value'];
        // $FlightBooking->tax = $result['air:AirPricingSolution']['@attributes']['markupPrice']['tax']['value'];
        // $FlightBooking->service_charges = $result['air:AirPricingSolution']['@attributes']['markupPrice']['service_chargers']['value'];
        // $FlightBooking->sub_total = $result['air:AirPricingSolution']['@attributes']['markupPrice']['FatoorahPaymentAmount']['value'];

        $FlightBooking->currency_code = $parsingData['data']['markupPrice']['FatoorahPaymentAmount']['currency_code'];
        $FlightBooking->total_amount = $parsingData['data']['markupPrice']['FatoorahPaymentAmount']['value'];
        $FlightBooking->basefare = $parsingData['data']['markupPrice']['basefare']['value'];
        $FlightBooking->tax = $parsingData['data']['markupPrice']['tax']['value'];
        $FlightBooking->service_charges = $parsingData['data']['markupPrice']['service_chargers']['value'];
        $FlightBooking->sub_total = $parsingData['data']['markupPrice']['FatoorahPaymentAmount']['value'];
        $FlightBooking->type_of_payment = $request->input('type_of_payment');
        $FlightBooking->supplier_type = $xmlData['supplier'];
        $FlightBooking->search_id = $userRequest['search_id'];

        if(!empty($parsingData['data']['markupPrice']['coupon']['value']) && $parsingData['data']['markupPrice']['coupon']['value']!= '0.000'){
            $FlightBooking->coupon_id = $parsingData['data']['markupPrice']['coupon']['id'];
            $FlightBooking->coupon_amount = $parsingData['data']['markupPrice']['standed_coupon']['value'];
        }

        $FlightBooking->actual_amount = $parsingData['data']['markupPrice']['actual_amount']['value'];

        $FlightBooking->booking_status = 'booking_initiated';
        $FlightBooking->save();

        $FlightBooking->booking_ref_id = 'MT'.str_pad($FlightBooking->id, 7, '0', STR_PAD_LEFT);
        $FlightBooking->from = $fromCode;
        $FlightBooking->to = $toCode;
        $FlightBooking->carrier = $parsingData['data']['airSegments'][0]['Carrier'] ?? null;
        $FlightBooking->carrier_name = $parsingData['data']['airSegments'][0]['AirLine'] ?? null;
        
        $FlightBooking->save();


        $adult = 0;
        $children = 0;
        $infant = 0;
        foreach ($request->input('users') as $key => $value) {
            if($xmlData['supplier'] == 'travelport')
            {
                if($value['passengerType'] == 'ADT')
                {
                    $adult++;
                    $traveler_ref_id = $traceId."ADT".($adult);
                }
                elseif($value['passengerType'] == 'CNN')
                {
                    $children++;
                    $traveler_ref_id = $traceId."CNN".($children);
                }
                elseif($value['passengerType'] == 'INF')
                {
                    $infant++;
                    $traveler_ref_id = $traceId."INF".($infant);
                }
            }
            elseif($xmlData['supplier'] == 'airarabia')
            {
                if($value['passengerType'] == 'ADT')
                {
                    $adult++;
                    $traveler_ref_id = "A".($key+1);
                }
                elseif($value['passengerType'] == 'CNN')
                {
                    $children++;
                    $traveler_ref_id = "C".($key+1);
                }
                elseif($value['passengerType'] == 'INF')
                {
                    $infant++;
                    $traveler_ref_id = "I".($key+1)."/A".($infant);
                }

            }
            elseif($xmlData['supplier'] == 'airjazeera'){

                if($value['passengerType'] == 'ADT')
                {
                    $adult++;
                    $traveler_ref_id = "A".($key+1);
                }
                elseif($value['passengerType'] == 'CNN')
                {
                    $children++;
                    $traveler_ref_id = "C".($key+1);
                }
                elseif($value['passengerType'] == 'INF')
                {
                    $infant++;
                    $traveler_ref_id = "I".($key+1)."/A".($infant);
                }


            }
            
            if($value['title']== "Mr")
            {
                $gender = 'M';
            }elseif($value['title'] == "Ms")
            {
                $gender = 'F';
            }elseif($value['title'] == "Master")
            {
                $gender = 'M';
            }elseif($value['title'] == "Miss")
            {
                $gender = 'F';
            }
            else{
                $gender = 'F';
            }
            $FlightBookingTravelers = new FlightBookingTravelsInfo();
            $FlightBookingTravelers->title = $value['title'];
            $FlightBookingTravelers->first_name = $value['firstName'];
            $FlightBookingTravelers->last_name = $value['lastName'];
            $FlightBookingTravelers->date_of_birth = $value['dob'];
            $FlightBookingTravelers->passport_number = $value['passportNumber'];
            $FlightBookingTravelers->passport_issued_country_id = $value['passportIssueCountry'];
            $FlightBookingTravelers->passport_expire_date = $value['passportExpireDate'];
            $FlightBookingTravelers->traveler_type = $value['passengerType'];
            $FlightBookingTravelers->flight_booking_id = $FlightBooking->id;
            
            $FlightBookingTravelers->traveler_ref_id = $traveler_ref_id;
            $FlightBookingTravelers->gender = $gender;

            if(isset($value['depatureextrabaggage']) && $value['depatureextrabaggage'] != 'No Bag')
            {
                $FlightBookingTravelers->depature_extra_baggage = $value['depatureextrabaggage'];
            }
            if(isset($value['returnextrabaggage']) && $value['returnextrabaggage'] != 'No Bag')
            {
                $FlightBookingTravelers->return_extra_baggage = $value['returnextrabaggage'];
            }

            $FlightBookingTravelers->save();
        }
        $bookingId = $FlightBooking->id;
        
        $parsingData['data']['bookingDetails'] = FlightBooking::with('Customercountry')->find($bookingId);
        $parsingData['data']['passengersInfo'] = FlightBookingTravelsInfo::with('passportIssuedCountry')->whereFlightBookingId($bookingId)->get();
        return response()->json([	
                    'status' => true,	
                    'message' => self::SUCCESS_MSG,	
                    "data" => $parsingData['data']	
                ], 200);
    }

    public function Countries()
    {
        $name = 'name';
        $countries = Country::select('id',$name.' as name','phone_code')->whereNotNull("phone_code")->get();


        return response()->json([
                    'status' => true,
                    'message' => self::SUCCESS_MSG,
                    "data" => $countries
                ], 200);
    }

    public function paymentGateWay(Request $request)
    {
        //myfathoora
        //payment gate way invoice generation
        
        $validator = Validator::make($request->all(), [
            'booking_id' => ['required']
        ]);
    

        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
        $bookingId = ($request->input('booking_id'));
        
        $BookingDetails = FlightBooking::with('Customercountry')->find($bookingId);
        if(empty($BookingDetails))
        {
            return response()->json([
                'status' => false,
                "message" => "InValid Booking Id"
            ], 200);
        }
        
        if($BookingDetails->supplier_type === "airjazeera"){
            $travelPort = TravelportRequest::where('id' , $BookingDetails->preview_travelport_request_id)->first();
            $response = $travelPort->json_response;
            $data = json_decode($response, true);
            if ($data !== null) {
                // Check if 'tokenData' exists in the decoded data
                if (isset($data['tokenData'])) {
                    // Access 'tokenData'
                    $tokenData = $data['tokenData'];
                    $expirationTime = $tokenData['expiration_time'];
                    $currentTime = time();
                    if ($expirationTime <= $currentTime) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Session Expired.'
                        ], 200);
                    }
                }else{
                    return response()->json([
                        'status' => false,
                        "message" => "Token Not Found."
                    ], 200);
                }
            }
        }

        //$userName = Auth::guard('web')->check() ? Auth::guard('web')->user()->name : 'guest' ;
        $passengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($BookingDetails->id)->first();
        
        $userName = (!empty($passengersInfo)) ? $passengersInfo->first_name . " ".$passengersInfo->last_name : 'guest';
        
        // $callbackURL = route('app.response',['booking_id' => $BookingDetails->id]) ;
        
        $url = route('app.bookflightTicket',['flightbookingId' => ($BookingDetails->id)]) ;
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
            'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION,
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

    public function bookflight($flightbookingId)
    {
        // set_time_limit(1000);
        $flightbookingId = $flightbookingId;
        $paymentId = request('paymentId');
        $flightbookingdetails  = FlightBooking::find($flightbookingId);
        if($flightbookingdetails->booking_status == 'payment_initiated')
        {
            $myfatoorah = new MyFatoorahController();
            $invoicedata = $myfatoorah->callback($paymentId);
            $invoicedata['IsSuccess'] =true;
            if($invoicedata['IsSuccess'])
            {
                $titles = [
                    'title' => "Flight Booked itinerary",
                ];
                
                $flightbookingdetails->invoice_status = $invoicedata['Data']->InvoiceStatus;
                $flightbookingdetails->invoice_response = json_encode($invoicedata['Data']);
                $flightbookingdetails->payment_id = $paymentId;
                if($invoicedata['Data']->InvoiceStatus == 'Paid')
                {
                    $flightbookingdetails->booking_status = 'payment_successful';
                    $flightbookingdetails->payment_gateway = $invoicedata['Data']->focusTransaction->PaymentGateway;
                }
                elseif($invoicedata['Data']->InvoiceStatus == 'Expired'){
                    $flightbookingdetails->booking_status = 'payment_failure';
                }
                elseif($invoicedata['Data']->InvoiceStatus == 'Failed')
                {
                    $flightbookingdetails->booking_status = 'payment_exipre';
                }
                $flightbookingdetails->save();
                
                if($invoicedata['Data']->InvoiceStatus == 'Paid') 
                {
    
                    //flight booking integration in travelport

                    $previewId = $flightbookingdetails->preview_travelport_request_id;
                    $xmlData = TravelportRequest::find($previewId);
                   
                        $xmlRsp = $xmlData->response_xml;
                        $traceId = $xmlData->trace_id;
                        $tarvelersInfo = FlightBookingTravelsInfo::with('passportIssuedCountry')->where('flight_booking_id',$flightbookingId)->get();
                        
                        if($xmlData->supplier != 'jazeera'){
                            $responseArray = XmlToArray::convert($xmlRsp, $outputRoot = false);    
                        }
                    
                        if(!empty($flightbookingdetails->coupon_id)){
                            $couponDetails = Coupon::find($flightbookingdetails->coupon_id);
                            $AppliedCoupon = new AppliedCoupon();
                            $AppliedCoupon->coupon_id = $flightbookingdetails->coupon_id;
                            $AppliedCoupon->user_id = $flightbookingdetails->user_id;
                            $AppliedCoupon->coupon_code = $couponDetails->coupon_code;
                            $AppliedCoupon->coupon_applied_on = Carbon::now()->toDateString();
                            $AppliedCoupon->save();
                        }
                    if($xmlData->supplier == 'travelport')
                    {
                        $response = $responseArray['SOAP:Body'];

                        if(isset($response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution']) )
                        {
                            if(isset($response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution']['@attributes']))
                            {
                                //only one airprice
                                $AirPrice = $response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution'];
                                // $AirPricingsessionData['air:AirPricingSolution'] = $response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution'];

                            }
                            else{
                                //multiple Air Price we will take only first one
                                $AirPrice = $response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution'][0];
                                // $AirPricingsessionData['air:AirPricingSolution'] = $response['air:AirPriceRsp']['air:AirPriceResult']['air:AirPricingSolution'][0];
                            }
                        
                            $result['air:AirPricingSolution']['@attributes'] = $AirPrice['@attributes'];

                            if(isset($AirPrice['air:AirSegmentRef']['@attributes']))
                            {
                                //only one air Segment
                                $index = array_search($AirPrice['air:AirSegmentRef']['@attributes']['Key'],array_column(array_column($response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'],'@attributes'),'Key'));
                                if(isset($response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment']['@attributes']))
                                {
                                    $result['air:AirPricingSolution']['AirSegment'][] = $response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'];
                                }
                                else{
                                    $result['air:AirPricingSolution']['AirSegment'][] = $response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'][$index];
                                }

                                $Origin = $result['air:AirPricingSolution']['AirSegment'][0]['@attributes']['Origin'];
                                $Destination = $result['air:AirPricingSolution']['AirSegment'][0]['@attributes']['Destination'];
                                $OriginAirportDetails = $this->AirportDetails($Origin);
                                $DestationAirportDetails = $this->AirportDetails($Destination);
                                $result['air:AirPricingSolution']['AirSegment'][0]['@attributes']['OriginAirportDetails'] = $OriginAirportDetails;
                                $result['air:AirPricingSolution']['AirSegment'][0]['@attributes']['DestationAirportDetails'] = $DestationAirportDetails;
                            }
                            else{
                                //multiple Air Segments
                                foreach($AirPrice['air:AirSegmentRef'] as $segments)
                                {
                                    $index = array_search($segments['@attributes']['Key'],array_column(array_column($response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'],'@attributes'),'Key'));
                                    if(isset($response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment']['@attributes']))
                                    {
                                        $result['air:AirPricingSolution']['AirSegment'][] = $response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'];
                                    }
                                    else{
                                        
                                        $result['air:AirPricingSolution']['AirSegment'][] = $response['air:AirPriceRsp']['air:AirItinerary']['air:AirSegment'][$index];
                                    }
                                    
                                }
                                foreach($result['air:AirPricingSolution']['AirSegment'] as $A=>$Asegment)
                                {
                                    $Origin = $result['air:AirPricingSolution']['AirSegment'][$A]['@attributes']['Origin'];
                                    $Destination = $result['air:AirPricingSolution']['AirSegment'][$A]['@attributes']['Destination'];
                                    $OriginAirportDetails = $this->AirportDetails($Origin);
                                    $DestationAirportDetails = $this->AirportDetails($Destination);
                                    $result['air:AirPricingSolution']['AirSegment'][$A]['@attributes']['OriginAirportDetails'] = $OriginAirportDetails;
                                    $result['air:AirPricingSolution']['AirSegment'][$A]['@attributes']['DestationAirportDetails'] = $DestationAirportDetails;
                                }
                            }

                            
                            $result['air:AirPricingSolution']['air:AirPricingInfo'] = $AirPrice['air:AirPricingInfo'];
                            $result['air:AirPricingSolution']['air:FareNote'] = $AirPrice['air:FareNote'];
                            $result['air:AirPricingSolution']['common_v52_0:HostToken'] = $AirPrice['common_v52_0:HostToken'];

                            if(isset($result['air:AirPricingSolution']['air:AirPricingInfo']['@attributes']))
                            {
                                $temp = '';
                                $temp = $result['air:AirPricingSolution']['air:AirPricingInfo'];
                                $result['air:AirPricingSolution']['air:AirPricingInfo'] = [];
                                $result['air:AirPricingSolution']['air:AirPricingInfo'][0] = $temp;
                            }

                            // FareRuleKeys

                            foreach($result['air:AirPricingSolution']['air:AirPricingInfo'] as $APK => $APV)
                            {
                                
                                //FareRuleKeys
                                if(isset($APV['air:FareInfo']['@attributes']))
                                {
                                    $temp = '';
                                    $temp = $APV['air:FareInfo'];
                                    $result['air:AirPricingSolution']['air:AirPricingInfo'][$APK]['air:FareInfo'] =[];
                                    $result['air:AirPricingSolution']['air:AirPricingInfo'][$APK]['air:FareInfo'][0] = $temp;
                                }
                            }

                            $segments = [];
                            foreach ($result['air:AirPricingSolution']['AirSegment'] as $segkey => $segvalue) {
                                $segments[] =  array(
                                    'OriginAirportDetails' => $segvalue['@attributes']['OriginAirportDetails'],
                                    'DestationAirportDetails' => $segvalue['@attributes']['DestationAirportDetails'],
                                    'DepartureDate' => DateTimeSpliter($segvalue['@attributes']['DepartureTime'],'date'),
                                    'DepartureTime' => DateTimeSpliter($segvalue['@attributes']['DepartureTime'],'time'),
                                    'ArrivalDate' => DateTimeSpliter($segvalue['@attributes']['ArrivalTime'],'date'),
                                    'ArrivalTime' => DateTimeSpliter($segvalue['@attributes']['ArrivalTime'],'time'),
                                    'Carrier' => $segvalue['@attributes']['Carrier'],
                                    'CodeshareInfo' => $segvalue['air:CodeshareInfo']['@content'],
                                    'AirLine' => $segvalue['air:CodeshareInfo']['@content'],
                                    'FlightNumber' => $segvalue['@attributes']['FlightNumber'],
                                    'FlightTime' =>segmentTime($segvalue['@attributes']['FlightTime']),
                                );
                            }
                            $result['airSegments'] = $segments;
                        
                        }
                        else{
                            //error
                        }
                        $AirPricing = $result;

                        $AirBooking = new BookingController();
                        
                        $airCreateReservationResponse = $AirBooking->AirCreateReservation($AirPricing,$tarvelersInfo,$flightbookingdetails,$traceId);
                        $totalData['response'] = $airCreateReservationResponse['travelportResponse'];
                        $travelportRequest = $airCreateReservationResponse['travelportRequest'];
                        $travelpoertReuestId = $travelportRequest->id;
                        if(!isset($totalData['response']['universal:AirCreateReservationRsp']))
                        {
                            //travelport request error response
                            //refund should initate
                            //redirect to error page

                            return $this->app_web_error(['error' =>$totalData['response']['SOAP:Fault']['faultstring'],'booking_id'=>$flightbookingId]);
                        }

                        $response = $totalData['response']['universal:AirCreateReservationRsp'];

                        if(isset($response['air:AirSolutionChangedInfo']))
                        {
                            if(isset($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode']) && ($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode'] == "Schedule"))
                            {
                                $error =  "Air Segments have re-Schedule ,If amount debited from your bank it will be credited back";
                            }
                            $flightbookingdetails->booking_status = "refund_initiated";
                            $flightbookingdetails->save();

                            return $this->app_web_error(['error' =>$error,'booking_id'=>$flightbookingId]);
                        }
                        
                        $traceId = $travelportRequest->trace_id;
                        $pnr = $response['universal:UniversalRecord']['@attributes']['LocatorCode'];

                        $flightbookingdetails->trace_id = $travelportRequest->trace_id;
                        $flightbookingdetails->pnr = $pnr;
                        $flightbookingdetails->booking_status = 'booking_completed';
                        $flightbookingdetails->travel_request_id = $travelpoertReuestId;
                        $flightbookingdetails->reservation_travelport_request_id = $travelpoertReuestId;
                        $flightbookingdetails->galileo_pnr = $response['universal:UniversalRecord']['universal:ProviderReservationInfo']['@attributes']['LocatorCode'];
                        $flightbookingdetails->reservation_pnr = $response['universal:UniversalRecord']['air:AirReservation']['@attributes']['LocatorCode'];
                        //$flightbookingdetails->supplier_pnr = $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes']['SupplierLocatorCode'];
                        $flightbookingdetails->save();
                        //adding all supplierLocator codes in airLinePnrs table
                        if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes']))
                        {
                            $temp = [] ;
                            $temp = $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'];
                            $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] = [];
                            $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0] = $temp;
                        }
                        if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) && count($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) > 0)
                        {
                            foreach ($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $key => $value) {
                                $airlinesPnr = new AirlinesPnr();
                                $airlinesPnr->booking_id = $flightbookingdetails->id;
                                $AirlinesDetails = Airline::whereVendorCode($value['@attributes']['SupplierCode'])->first();
                                $airlinesPnr->name = $AirlinesDetails['name'] ?? '';
                                $airlinesPnr->code = $value['@attributes']['SupplierCode'];
                                $airlinesPnr->airline_pnr = $value['@attributes']['SupplierLocatorCode'];
                                $airlinesPnr->save();
                            }
                        }
                        else{
                            $pendingpnr = new PendingPnrs();
                            $pendingpnr->booking_id = $flightbookingdetails->id;
                            $pendingpnr->vendor_pnr = $pnr;
                            $pendingpnr->cron_status = 0;
                            $pendingpnr->status = 1;
                            $pendingpnr->enable_request_on = date('Y-m-d H:i:s', strtotime('+130 minutes'));
                            $pendingpnr->save();
                        }
                        
                        

                        if(isset($response['SOAP:Fault']['faultstring']))
                        {
                            //error
                            return $this->app_web_error(['error' =>$response['SOAP:Fault']['faultstring'],'booking_id'=>$flightbookingId]);

                        }
                     
                        if(!isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']))
                        {
                        
                            $error =  "something went wrong,If amount debited from your account it will be credited back";
                            $flightbookingdetails->booking_status = "refund_initiated";
                            $flightbookingdetails->save();
                            // return response()->json([
                            //     'status' => false,
                            //     'message' => $error,
                            //     "data" => [],
                            // ], 200);
                            return $this->app_web_error(['error' =>$error,'booking_id'=>$flightbookingId]);
                        }

                        $response = $this->airCreationAndURRetrieveFromate($response);
                        

                        $bookingController = new BookingController();
                        $onlineTicketingDetails = $bookingController->OnlineTicketing($response , $traceId);
                        $onlineTicketingresp['response'] = $onlineTicketingDetails['travelportResponse'];
                        $onlineTicketing = $onlineTicketingresp['response']['air:AirTicketingRsp'];
                        $ticketrequestdetails = $onlineTicketingDetails['travelportRequest'];
                        $flightbookingdetails->ticket_travelport_request_id = $ticketrequestdetails->id;
                        $flightbookingdetails->save();

                        // if($flightbookingdetails->user_type != 'web_guest' && $flightbookingdetails->user_type != 'app_guest')
                        // {
                        //     $userdetails = User::find($flightbookingdetails->user_id);
                        //     $user = $userdetails->first_name.' '.$userdetails->last_name;
                        // }
                        // else{
                        //     $user = 'Customer';
                        // }
                        $user = $tarvelersInfo[0]->first_name .' '.$tarvelersInfo[0]->last_name;


                        if(isset($onlineTicketing['air:TicketFailureInfo'])){
                            //tickting Failure
                            $ticketFailure = true;

                            if($onlineTicketing['air:TicketFailureInfo']['@attributes']['Message'] == 'Host error during ticket issue. IGNORE AND RETRIEVE BOOKING FILE')
                            {
                                /*Host error during ticket issue. IGNORE AND RETRIEVE BOOKING FILE
                                As per travelport suggestion
                                you can try to call URRetrieveReq to get the latest PNR information and then call the AirTicketing again. No need to perform booking again
                                */
                                $data = ['universalPnr' => $pnr,'traceId' => $traceId];
                                $URRetrieve = $bookingController->getTravelportUniversalRecord($data);
                    
                                $URRetrieveResponse = $URRetrieve['travelportResponse'];
                                $URtravelportRequest = $URRetrieve['travelportRequest'];
                                $URRetrieveRquestId = $URtravelportRequest->id;
                                $flightbookingdetails->ur_retrival_request_id = $URRetrieveRquestId;
                    
                               
                                $flightbookingdetails->save();
                                if(isset($URRetrieveResponse['SOAP:Fault']))
                                {
                                    //urrretrivalfailure
                                    //send to ticket failure
                                    //travelport request error response
                                    //refund should initate
                                    //redirect to error page
                                    $error ="Ticket failure";
                                    return $this->app_web_error(['error' =>$error,'booking_id'=>$flightbookingId]);
                                }else{
                                    //again performing Ticketing operation
                                    $response = $URRetrieveResponse['universal:UniversalRecordRetrieveRsp'];
                    
                                    //storingUpdatedValues 
                                    $flightbookingdetails->travelport_request_id = $URRetrieveRquestId;
                                    $flightbookingdetails->galileo_pnr = $response['universal:UniversalRecord']['universal:ProviderReservationInfo']['@attributes']['LocatorCode'];
                                    $flightbookingdetails->reservation_pnr = $response['universal:UniversalRecord']['air:AirReservation']['@attributes']['LocatorCode'];
                                    $flightbookingdetails->reservation_travelport_request_id = $URRetrieveRquestId;
                                    $flightbookingdetails->save();
                    
                                    $response = $this->airCreationAndURRetrieveFromate($response);
                                    
                                    $onlineTicketingDetails = $bookingController->OnlineTicketing($response , $traceId);
                                    $onlineTicketingresp['response'] = $onlineTicketingDetails['travelportResponse'];
                                    $onlineTicketing = $onlineTicketingresp['response']['air:AirTicketingRsp'];
                                    $ticketrequestdetails = $onlineTicketingDetails['travelportRequest'];
                             
                                    $flightbookingdetails->re_ticketing_travel_port_request_id = $ticketrequestdetails->id;
                                    $flightbookingdetails->save();
                    
                                    if(!isset($onlineTicketing['air:TicketFailureInfo'])){
                                        $ticketFailure = false;
                                    }
                    
                                }
                            }

                            if($ticketFailure == true){
                                $data['errorresponse'] ="Ticket failure";
                                //travelport request error response
                                //refund should initate
                                //redirect to error page
                    
                                //mail should be triggred
                                $FlightBookingPassengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($flightbookingdetails->id)->get();
                                Mail::send('front_end.email_templates.pending-ticket',compact('flightbookingdetails','user','FlightBookingPassengersInfo'), function($message) use($flightbookingdetails) {
                                    $message->to($flightbookingdetails->email)
                                            ->subject('flightTicketPending');
                                });
                                return $this->app_web_error(['error' =>'Ticket failure','booking_id'=>$flightbookingId]);
                            }
                        }
                        else
                        {
                            $flightbookingdetails->ticket_status = 1;
                            $flightbookingdetails->save();
                            if(isset($onlineTicketing['air:ETR']['@attributes']))
                            {
                                $temp = [];
                                $temp = $onlineTicketing['air:ETR'];
                                $onlineTicketing['air:ETR'] = [];
                                $onlineTicketing['air:ETR'][0] = $temp; 
                            }
                            // foreach($onlineTicketing['air:ETR'] as $EtrKey=>$EtrVlaue)
                            // {
                            //     $TravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where("title",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['Prefix'])->where("first_name",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['First'])->where("last_name",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['Last'])->first();
                            //     if(isset($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatus']))
                            //     {
                            //         $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatusDetails'] = TicketStatus($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatus']);
                            //     }
                            //     else{
                            //         $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatusDetails'] = "";
                            //     }
                            //     $TravelerInfo->travel_port_ticket_status = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatus'];
                            //     $TravelerInfo->travel_port_ticket_number = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketNumber'];
                            //     $TravelerInfo->save();

                            //     $serachbaleKeyValue = $onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['@attributes']['Key'];

                            //     $SerchableKey =  (array_search($serachbaleKeyValue,array_column(array_column($response['universal:UniversalRecord']['common_v52_0:BookingTraveler'],'@attributes'),'Key')));

                            //     $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'][$SerchableKey]['common_v52_0:BookingTravelerName']['@attributes']['TicketNumber'] = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketNumber'];
                            // }
                            foreach($onlineTicketing['air:ETR'] as $EtrKey=>$EtrVlaue)
                            {
                                
                                if(isset($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']))
                                {
                                    $temp = [];
                                    $temp = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'];
                                    $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'] =[];
                                    $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][0] = $temp;
                                }
                                foreach($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'] as $ticketKey =>$ticketValue){
                                    if(isset($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon']['@attributes'])){
                                        $temp = [];
                                        $temp = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon'];
                                        $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon'] =[];
                                        $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon'][0] = $temp;
                                    };
                                    foreach ($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon'] as $ticketSegmentkey => $ticketSegmentValue) {
                                        $TravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where("title",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['Prefix'])->where("first_name",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['First'])->where("last_name",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['Last'])->first();
                                        if(isset($TravelerInfo)){
                                            $travelerflightticketnumber = new FlightTicketNumber();
                                            $travelerflightticketnumber->flight_booking_id = $flightbookingdetails->id;
                                            $travelerflightticketnumber->flight_booking_travels_info_id = $TravelerInfo->id;
                                            $travelerflightticketnumber->ticket_number = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['@attributes']['TicketNumber'];
                                            $travelerflightticketnumber->ticket_status = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['@attributes']['TicketStatus'];
                                            $travelerflightticketnumber->from = $ticketSegmentValue['@attributes']['Origin'];
                                            $travelerflightticketnumber->to = $ticketSegmentValue['@attributes']['Destination'];
                                            $travelerflightticketnumber->carrier = $ticketSegmentValue['@attributes']['MarketingCarrier'];
                                            $travelerflightticketnumber->flight_number = $ticketSegmentValue['@attributes']['MarketingFlightNumber'];
                                            $travelerflightticketnumber->save();
                                        }
                                    }
                                }
                            }
                        }  
                        //formatting 
                        $segments = [];
                        foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'] as $bk=>$bookinginfo){
                            //layover
                            $layover = null;
                            
                            if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk+1]))
                            {
                                if($flightbookingdetails->booking_type == 'roundtrip' && $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk]['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails']->airport_code == strtoupper($flightbookingdetails->to) )
                                {
                                    $layover = null ;
                                }
                                else{
                                    $layover = LayoverTime($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk]['@attributes']['segmentDetails']['@attributes']['ArrivalTime'] , $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk+1]['@attributes']['segmentDetails']['@attributes']['DepartureTime']);
                                }
                            }
                            else
                            {
                                $layover = null;
                            }


                            $passengersList = [];
                            $flightNumber = $bookinginfo['@attributes']['segmentDetails']['@attributes']['FlightNumber'];
                            // $passengersInfo = FlightBookingTravelsInfo::leftjoin("flight_ticket_numbers","flight_booking_travels_infos.id","=","flight_ticket_numbers.flight_booking_travels_info_id")->where("flight_booking_travels_infos.flight_booking_id" , $flightbookingdetails->id)->where('flight_number',$flightNumber)->get();

                            $passengersInfo = FlightBookingTravelsInfo::leftjoin("flight_ticket_numbers","flight_booking_travels_infos.id","=","flight_ticket_numbers.flight_booking_travels_info_id")->where("flight_booking_travels_infos.flight_booking_id" , $flightbookingdetails->id)->where('flight_number',$flightNumber)->where('from',$bookinginfo['@attributes']['segmentDetails']['@attributes']['Origin'])->where('to',$bookinginfo['@attributes']['segmentDetails']['@attributes']['Destination'])->get();

                            
                            foreach ($passengersInfo as $TravelsInfo) {
                                if($TravelsInfo->traveler_type == 'ADT'){
                                    $TravelerType = "Adult";
                                }
                                elseif($TravelsInfo->traveler_type == 'CNN')
                                {
                                $TravelerType = "Child";
                                }
                                elseif($TravelsInfo->traveler_type == 'INF')
                                {
                                $TravelerType = "Infant";
                                }
                                else{$TravelerType = "Infant";}
                                $passengersList[] = array(
                                    'travelerType' => $TravelerType,
                                    'prefix' => $TravelsInfo->title,
                                    'firstName' => $TravelsInfo->first_name,
                                    'lastName' => $TravelsInfo->last_name,
                                    'ticketNumber' => $TravelsInfo->ticket_number,
                                );
                                
                            }

                            $segments[] =  array(
                                'OriginAirportDetails' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['OriginAirportDetails'],
                                'DestinationAirportDetails' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails'],
                                'DepartureDate' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['DepartureTime'],'date'),
                                'DepartureTime' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['DepartureTime'],'time'),
                                'ArrivalDate' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],'date'),
                                'ArrivalTime' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],'time'),
                                'Status' => ($bookinginfo['@attributes']['segmentDetails']['@attributes']['Status'] == 'HK') ? 'Confirmed' : 'Not - Confirmed', 
                                'Carrier' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['Carrier'],
                                'AirLine' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['airLineDetais'],
                                'FlightNumber' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['FlightNumber'],
                                'FlightTime' =>segmentTime($bookinginfo['@attributes']['segmentDetails']['@attributes']['TravelTime']),
                                'Refundable' => $response['universal:UniversalRecord']['air:AirReservation']['refundable'],
                                'FlightName' => (isset($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']) && !empty($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails'])) ?$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']->short_name : $bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['Equipment'],
                                'Class' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['CabinClass'],
                                'CheckIn' => $bookinginfo['@attributes']['baggageDetails'],
                                'Layover' => $layover,
                                'passengersList' => $passengersList,
                            );

                        }
                        
                        // $passengersList = [];
                        // foreach ($response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] as $TravelsInfo) {
                        //     if($TravelsInfo['@attributes']['TravelerType'] == 'ADT'){
                        //         $TravelerType = "Adult";
                        //     }
                        //     elseif($TravelsInfo['@attributes']['TravelerType'] == 'CNN')
                        //     {
                        //     $TravelerType = "Child";
                        //     }
                        //     elseif($TravelsInfo['@attributes']['TravelerType'] == 'INF')
                        //     {
                        //     $TravelerType = "Infant";
                        //     }
                        //     else{$TravelerType = "Infant";}
                        //     $passengersList[] = array(
                        //         'travelerType' => $TravelerType,
                        //         'prefix' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Prefix'],
                        //         'firstName' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['First'],
                        //         'lastName' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Last'],
                        //         'ticketNumber' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['TicketNumber'],
                        //     );
                            
                        // }
                        // $result['passengersList'] = $passengersList;
                        $result['segments'] = $segments;
                        $result['flightBookingDetails'] = $flightbookingdetails;
                        if(!isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']))
                        {
                            //pnr not generated
                            //Some airline hosting systems are unable to process all the requests at the same time, hence the vendor locator is not assigned (in some cases) straight away to the PNR.

                            // As per TVP recommendations, an agent should wait up to 2 hours for the vendor locator until reporting it as an issue.
                            $airlinePnr[0] = array('pnr' => '---' , 'airline' => '---');
                        }

                        elseif(count($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) == 1 )
                        {
                            $airlinePnr[0] = array('pnr' => $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0]['@attributes']['SupplierLocatorCode'] , 'airline' => $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0]['@attributes']['airline_name']);
                        }
                        else{
                            foreach($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $supplierCode)
                            {
                                $airlinePnr[] = array('pnr' => $supplierCode['@attributes']['SupplierLocatorCode'] , 'airline' => $supplierCode['@attributes']['airline_name']);

                            }
                        }
                        $result['airLinePnrs'] = $airlinePnr;
                        $result['user'] = $user;

                    }
                    elseif($xmlData->supplier == 'airarabia'){
                        
                        $parsingData = $this->AirArabiaDetails([],[],$traceId,$extraInfo =['xmlresponse' => $responseArray['soap:Body'] ,'type_of_payment' => $flightbookingdetails->type_of_payment,'detailsRequestId'=>$previewId,'booking_type' => $flightbookingdetails->flightbookingdetails ,'flightToAirportCode' => $flightbookingdetails->to]);
                        // dd($parsingData);
                        $AirBooking = new BookingController();

                        $airCreateReservationResponse = $AirBooking->AirAribiaBooking($parsingData['data'],$tarvelersInfo,$flightbookingdetails,$traceId);

                        $response = $airCreateReservationResponse['travelportResponse'];
                        $travelportRequest = $airCreateReservationResponse['travelportRequest'];
                        $travelpoertReuestId = $travelportRequest->id;

                        // dd($response['ns1:OTA_AirBookRS']);

                        if(isset($response['ns1:OTA_AirBookRS']['ns1:Errors']['ns1:Error']))
                        {
                            // dd("dd");
                            //AirArabia request error response
                            //refund should initate
                            //redirect to error page

                            if($flightbookingdetails->user_type != 'web_guest' && $flightbookingdetails->user_type != 'app_guest')
                            {
                                $userdetails = User::find($flightbookingdetails->user_id);
                                $user = $userdetails->first_name.' '.$userdetails->last_name;
                            }
                            else{
                                $user = 'Customer';
                            }

                            $FlightBookingPassengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($flightbookingdetails->id)->get();
                            Mail::send('front_end.email_templates.pending-ticket',compact('flightbookingdetails','user','FlightBookingPassengersInfo'), function($message) use($flightbookingdetails) {
                                $message->to($flightbookingdetails->email)
                                        ->subject('flightTicketPending');
                            });

                            return $this->app_web_error(['error' =>$response['ns1:OTA_AirBookRS']['ns1:Errors']['ns1:Error']['@attributes']['ShortText'],'booking_id'=>$flightbookingId]);
                            

                        }

                         
                        // $airCreateReservationResponse = $AirBooking->AirAribiaBooking($AirPricing,$tarvelersInfo,$flightbookingdetails,$traceId);
                        // $response = $airCreateReservationResponse['travelportResponse'];
                        // $travelportRequest = $airCreateReservationResponse['travelportRequest'];
                        // $travelpoertReuestId = $travelportRequest->id;

                        // if(isset($response['ns1:OTA_AirBookRS']['ns1:Errors']['ns1:Error']))
                        // {
                        //     //AirArabia request error response
                        //     //refund should initate
                        //     //redirect to error page
                            
                        //     $data['errorresponse'] = $response['ns1:OTA_AirBookRS']['ns1:Errors']['ns1:Error']['@attributes']['ShortText'];
                            
                        //     return view('front_end.error',compact('titles','data'));
                        // }

                        
                        

                        $flightbookingdetails->trace_id = $travelportRequest->trace_id;
                        
                        $flightbookingdetails->booking_status = 'booking_completed';
                        $flightbookingdetails->travel_request_id = $travelpoertReuestId;
                        $flightbookingdetails->reservation_travelport_request_id = $travelpoertReuestId;
                        $flightbookingdetails->ticket_travelport_request_id = $travelpoertReuestId;
                        
                        $flightbookingdetails->ticket_status = ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:Ticketing']['@attributes']['TicketingStatus'] == 3) ? 1 :0;
                        
                        
                        $flightbookingdetails->save();
                        

                        $result['flightBookingDetails'] = $flightbookingdetails;
                        if(isset($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID']['@attributes']))
                        {
                            $temp = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID'];
                            $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID'] =[];
                            $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID'][0] = $temp;
                        }
                        $airLinePnrs = [];
                        foreach ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID'] as $pnrKey => $pnrValue) {
                            //adding all codes in airLinePnrs table
                            $airlinesPnr = new AirlinesPnr();
                            $airlinesPnr->booking_id = $flightbookingdetails->id;
                            $airlinesPnr->name = 'Air Arabia';
                            $airlinesPnr->code = 'G9';
                            $airlinesPnr->airline_pnr = $pnrValue['@attributes']['ID'];
                            $airlinesPnr->save();
                            $airLinePnrs[] =array(
                                'pnr' => $pnrValue['@attributes']['ID'],
                                'airline' => 'Air Arabia',
                            );
                        }
                        $flightbookingdetails->pnr = $airLinePnrs[0]['pnr'];
                        $flightbookingdetails->galileo_pnr = $airLinePnrs[0]['pnr'];
                        $flightbookingdetails->reservation_pnr = $airLinePnrs[0]['pnr'];
                        $flightbookingdetails->save();
                        if($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:Ticketing']['@attributes']['TicketingStatus'] != '3'){
                            //tickting Failure

                            $data['errorresponse'] ="Ticket failure";
                            //travelport request error response
                            //refund should initate
                            //redirect to error page

                            //mail should be triggred
                            $FlightBookingPassengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($flightbookingdetails->id)->get();
                            Mail::send('front_end.email_templates.pending-ticket',compact('flightbookingdetails','user','FlightBookingPassengersInfo'), function($message) use($flightbookingdetails) {
                                $message->to($flightbookingdetails->email)
                                        ->subject('flightTicketPending');
                            });
                        
                            // return view('front_end.error',compact('titles','data'));
                            return $this->app_web_error(['error' =>'Ticket Failure','booking_id'=>$flightbookingId]);
                        }
                        $segments = [];
                        if(isset($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption']['ns1:FlightSegment']))
                        {
                            $temp = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'];
                            $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] = [];
                            $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'][0] = $temp;
                        }
                        foreach ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] as $rspSegkey => $rspSegValue) {
                            //layover yet to do
                            $segments[] = array(
                            'OriginAirportDetails' => $this->AirportDetails($rspSegValue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode']),
                            'DestinationAirportDetails' => $this->AirportDetails($rspSegValue['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode']),
                            'DepartureDate' => DateTimeSpliter($rspSegValue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'date'),
                            'DepartureTime' => DateTimeSpliter($rspSegValue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'time'),
                            'ArrivalDate' => DateTimeSpliter($rspSegValue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'date'),
                            'ArrivalTime' => DateTimeSpliter($rspSegValue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'time'),
                            'Status' => ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:Ticketing']['@attributes']['TicketingStatus'] == '3') ? 'Confirmed' : 'Not - Confirmed', 
                            'Carrier' => 'G9',
                            'AirLine' => Airline::whereVendorCode('G9')->first(),
                            'FlightNumber' => $rspSegValue['ns1:FlightSegment']['@attributes']['FlightNumber'],
                            'FlightTime' => LayoverTime($rspSegValue['ns1:FlightSegment']['@attributes']['DepartureDateTime'] , $rspSegValue['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                            'Refundable' => "false",
                            'FlightName' => $rspSegValue['ns1:FlightSegment']['@attributes']['FlightNumber'],
                            'Class' => (isset($rspSegValue['ns1:FlightSegment']['@attributes']['ResCabinClass']) ? ($rspSegValue['ns1:FlightSegment']['@attributes']['ResCabinClass'] == 'Y' ? "Economy" : "Business" ) : ""),
                            'CheckIn' => 'Include a generous 10 KG Hand Baggage',
                            'Layover' => '',
                            'Origin' => $rspSegValue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode'],
                            'Destination' => $rspSegValue['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode']
                        );
                        }
                        
                        usort($segments, function($a, $b) {
                            return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
                        });
                        
                        $passengersList = [];
                        if(isset($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler']['ns1:PersonName']))
                        {
                            $temp = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler'];
                            $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler'] = [];
                            $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler'][0] = $temp;
                        }
                        foreach ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler'] as $tk =>$travelerInfo) {
                            if($travelerInfo['@attributes']['PassengerTypeCode'] == 'ADT')
                            {
                                $passangerType = 'Adult';
                            }elseif($travelerInfo['@attributes']['PassengerTypeCode'] == 'CHD'){
                                $passangerType = 'Child';
                            }else{
                                $passangerType = 'Infant';
                            }
                            if(isset($travelerInfo['ns1:ETicketInfo']['ns1:ETicketInfomation']['@attributes']))
                            {
                                $temp = $travelerInfo['ns1:ETicketInfo']['ns1:ETicketInfomation'];
                                $travelerInfo['ns1:ETicketInfo']['ns1:ETicketInfomation'] = [];
                                $travelerInfo['ns1:ETicketInfo']['ns1:ETicketInfomation'][0] =$temp;
                            }
                            
                            // $ticketnumber = $travelerInfo['ns1:ETicketInfo']['ns1:ETicketInfomation'][0]['@attributes']['eTicketNo'];

                            $TravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id);
                            if(!empty($travelerInfo['ns1:PersonName']['ns1:NameTitle'])){
                                $TravelerInfo = $TravelerInfo->where("title",$travelerInfo['ns1:PersonName']['ns1:NameTitle']);
                            }

                            $TravelerInfo = $TravelerInfo->where("first_name",$travelerInfo['ns1:PersonName']['ns1:GivenName'])
                            ->where("last_name",$travelerInfo['ns1:PersonName']['ns1:Surname'])->first();
                            
                            // $TravelerInfo->travel_port_ticket_status = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:Ticketing']['@attributes']['TicketingStatus'];
                            // $TravelerInfo->travel_port_ticket_number = $ticketnumber;
                            // $TravelerInfo->save();
                            foreach ($travelerInfo['ns1:ETicketInfo']['ns1:ETicketInfomation'] as $ticketKey => $ticketValue) {
                                $OriginDestinationArray = explode("/",$travelerInfo['ns1:ETicketInfo']['ns1:ETicketInfomation'][$ticketKey]['@attributes']['flightSegmentCode']);
                        
                                $key = array_search($OriginDestinationArray[0], array_column($segments, 'Origin'));

                                $segmentInfo  = searchValueByKeys($segments, 'Origin', 'Destination', $OriginDestinationArray[0], $OriginDestinationArray[1]);
                                $flightNumber = null;
                                if($segmentInfo)
                                {
                                    $flightNumber = $segmentInfo['FlightNumber'];
                                }
                                
                                if(isset($TravelerInfo)){
                                    $travelerflightticketnumber = new FlightTicketNumber();
                                    $travelerflightticketnumber->flight_booking_id = $flightbookingdetails->id;
                                    $travelerflightticketnumber->flight_booking_travels_info_id = $TravelerInfo->id;
                                    $travelerflightticketnumber->ticket_number =$travelerInfo['ns1:ETicketInfo']['ns1:ETicketInfomation'][$ticketKey]['@attributes']['eTicketNo'];
                                    $travelerflightticketnumber->ticket_status = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:Ticketing']['@attributes']['TicketingStatus'];
                                    $travelerflightticketnumber->from = $OriginDestinationArray[0];
                                    $travelerflightticketnumber->to = $OriginDestinationArray[1];
                                    $travelerflightticketnumber->carrier = 'G9';
                                    $travelerflightticketnumber->flight_number = $flightNumber ?? null;
                                    $travelerflightticketnumber->save();
                                }
                            }
                        }
                        

                            // $passengersList[] = array(
                            //     "travelerType" => $passangerType,
                            //     "prefix" => $travelerInfo['ns1:PersonName']['ns1:NameTitle']??'',
                            //     "firstName" => $travelerInfo['ns1:PersonName']['ns1:GivenName']??'',
                            //     "lastName" => $travelerInfo['ns1:PersonName']['ns1:Surname']??'',
                            //     "ticketNumber" => $ticketnumber
                            // );
                        foreach ($segments as $Skey => $Svalue) {
                            $segments[$Skey]['passengersList'] = [];
                            $passengersList = [];
                        
                            $passengersInfo = FlightBookingTravelsInfo::leftjoin("flight_ticket_numbers","flight_booking_travels_infos.id","=","flight_ticket_numbers.flight_booking_travels_info_id")->where("flight_booking_travels_infos.flight_booking_id" , $flightbookingdetails->id)->where('flight_number',$Svalue['FlightName'])->where('from',$Svalue['Origin'])->where('to',$Svalue['Destination'])->get();

                            foreach ($passengersInfo as $TravelsInfo) {
                                if($TravelsInfo->traveler_type == 'ADT'){
                                    $TravelerType = "Adult";
                                }
                                elseif($TravelsInfo->traveler_type == 'CNN')
                                {
                                $TravelerType = "Child";
                                }
                                elseif($TravelsInfo->traveler_type == 'INF')
                                {
                                $TravelerType = "Infant";
                                }
                                else{$TravelerType = "Infant";}
                                $passengersList[] = array(
                                    'travelerType' => $TravelerType,
                                    'prefix' => $TravelsInfo->title,
                                    'firstName' => $TravelsInfo->first_name,
                                    'lastName' => $TravelsInfo->last_name,
                                    'ticketNumber' => $TravelsInfo->ticket_number,
                                );
                                
                            }
                            $segments[$Skey]['passengersList'] = $passengersList;
                        
                            
                        }

                        // $result['passengersList'] = $passengersList;
                        $result['airLinePnrs'] = $airLinePnrs;
                        $result['segments'] = $segments;
                        // if($flightbookingdetails->user_type != 'web_guest' && $flightbookingdetails->user_type != 'app_guest')
                        // {
                        //     $userdetails = User::find($flightbookingdetails->user_id);
                        //     $user = $userdetails->first_name.' '.$userdetails->last_name;
                        // }
                        // else{
                        //     $user = 'Customer';
                        // }
                        $user = $tarvelersInfo[0]->first_name .' '.$tarvelersInfo[0]->last_name;
                        $result['user'] = $user;
                    }
                    elseif($xmlData->supplier =="jazeera"){
                        
                      
                        /*check the token session*/
                        $travelPort = TravelportRequest::where('id' , $flightbookingdetails->preview_travelport_request_id)->first();
                        $travelPortResponse = $travelPort->json_response;
                        $travelPortdata = json_decode($travelPortResponse, true);
                        $tokenData = null;
                        if ($travelPortdata !== null) {
                            // Check if 'tokenData' exists in the decoded data
                            if (isset($travelPortdata['tokenData'])) {
                                // Access 'tokenData'
                                $tokenData = $travelPortdata['tokenData'];
                            }
                        }

                        $requestData['tokenData'] = $tokenData;
                        $requestData['requestFrom'] = "MOBILE";
                        $AirBooking = new BookingController();
                        $airCreateReservationResponse = $AirBooking->airJazeeraBookingCommit($requestData,[],$flightbookingdetails,[] );
                        $response                     = $airCreateReservationResponse['jazeeraResponse']['data'];
                        $booking                      = isset($response['booking']) ? $response['booking'] : null;

                        /*userget*/
                        $user = $tarvelersInfo[0]->first_name .' '.$tarvelersInfo[0]->last_name;
                        $result['user'] = $user;
                        /*IF fail after payment mail should be sent*/
                        if(!isset($booking) || $booking['info']['status'] == "Failed"|| $booking['info']['status'] == "Hold" || $booking['info']['status'] == "Default"){   
                            $FlightBookingPassengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($flightbookingdetails->id)->get();
                            Mail::send('front_end.email_templates.pending-ticket',compact('flightbookingdetails','user','FlightBookingPassengersInfo'), function($message) use($flightbookingdetails) {
                                $message->to($flightbookingdetails->email)
                                        ->subject('flightTicketPending');
                            });
                        
                            return $this->app_web_error(['error' =>'Unable to retrieve current booking session details','booking_id'=>$flightbookingId]);
                        }
                        
                        $travelportRequest      = $airCreateReservationResponse['jazeeraRequest'];
                        $travelpoertReuestId    = $travelportRequest['trace_id'];
                        
                        $flightbookingdetails->trace_id           = $travelpoertReuestId;
                        $flightbookingdetails->booking_status     = 'booking_completed';
                        $flightbookingdetails->travel_request_id  = $travelpoertReuestId;
                        $flightbookingdetails->reservation_travelport_request_id = $travelpoertReuestId;
                        $flightbookingdetails->ticket_travelport_request_id      = $travelpoertReuestId;
                        $flightbookingdetails->ticket_status = ($booking['info']['status'] == "Confirmed") ? 1 :0; //confirmed/hold/failed
                        $flightbookingdetails->save();

                       
                        $result['flightBookingDetails'] = $flightbookingdetails;
                        if(isset($booking))
                        {
                            $temp = $booking['recordLocator'];
                            $booking['recordLocator'] =[];
                            $booking['recordLocator'] = $temp;
                        }
                        $airLinePnrs[] =array(
                            'pnr' => $booking['recordLocator'],
                            'airline' => 'Jazeera-Airways',
                        );

                        //adding all codes in airLinePnrs table
                        $airlinesPnr                = new AirlinesPnr();
                        $airlinesPnr->booking_id    = $flightbookingdetails->id;
                        $airlinesPnr->name          = 'Jazeera-Airways';
                        $airlinesPnr->code          = 'J9';
                        $airlinesPnr->airline_pnr   = $booking['recordLocator'];
                        $airlinesPnr->save();
                        
                        /*PNR*/
                        $flightbookingdetails->pnr              = $booking['recordLocator'];
                        $flightbookingdetails->galileo_pnr      = $booking['recordLocator'];
                        $flightbookingdetails->reservation_pnr  = $booking['recordLocator'];
                        $flightbookingdetails->save();
                        
                        $productClasses = [];
                        if(isset($booking) && isset($booking['journeys'])){
                            $journeyDetails       = $booking['journeys'];
                            //$productClass         = $journeyDetails[0]['segments'][0]['fares'][0]['productClass'];
                            foreach($journeyDetails as $journey)
                            {
                                foreach($journey['segments'] as $itinerary){  
                                $flightClass            = $itinerary['fares'][0]['productClass'];
                                $productClasses[]       = ['flightClass' => $flightClass,'flightNumber' => $itinerary['identifier']['identifier']];
                                $departureTimeUtc       = $itinerary['legs'][0]['legInfo']['departureTimeUtc'];
                                $arrivalTimeUtc         = $itinerary['legs'][0]['legInfo']['arrivalTimeUtc'];
                                $departureDateTimeUtc   = new DateTime($departureTimeUtc, new DateTimeZone('UTC'));
                                $arrivalDateTimeUtc     = new DateTime($arrivalTimeUtc, new DateTimeZone('UTC'));
                                $flightDuration         = $departureDateTimeUtc->diff($arrivalDateTimeUtc);
                                $flightTravelTime       = $flightDuration->format('%H:%I');

                                    $segments[] =  array(
                                        'OriginAirportDetails'      =>  $this->AirportDetails($itinerary['designator']['origin']),
                                        'DestinationAirportDetails' =>  $this->AirportDetails($itinerary['designator']['destination']),
                                        'DepartureDate'             =>  DateTimeSpliter($itinerary['designator']['departure'],'date'),
                                        'DepartureTime'             =>  DateTimeSpliter($itinerary['designator']['departure'],'time'),
                                        'ArrivalDate'               =>  DateTimeSpliter($itinerary['designator']['arrival'],'date'),
                                        'ArrivalTime'               =>  DateTimeSpliter($itinerary['designator']['arrival'],'time'),
                                        'Status'                    =>  $booking['info']['status'],
                                        'Carrier'                   =>  $itinerary['identifier']['carrierCode'],
                                        //'CodeshareInfo'           =>  'Air Jazeera',
                                        'AirLine'                   =>  Airline::whereVendorCode('J9')->first(),
                                        'FlightNumber'              =>  $itinerary['identifier']['identifier'],
                                        'FlightTime'                =>  $flightTravelTime,
                                        'Refundable'                =>  "false",
                                        'FlightName'                =>  $itinerary['identifier']['identifier'],
                                        'Class'                     =>  $itinerary['fares'][0]['productClass'],
                                        'CheckIn'                   =>  '',
                                        'Layover'                   =>  ''
                                    );
                                }
                            }

                            usort($segments, function($a, $b) {
                                return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
                            });

                            //echo "<pre>"; print_r($booking['passengers']);
                            $baggageDetails = [];
                            $passengersList = [];
                            $frontEndHomeController = new \App\Http\Controllers\FrontEnd\HomeController();
                            if(isset($booking['passengers'])) {
                                foreach ($booking['passengers'] as $passenger) {
                                    $passengerInfo = $passenger['value'];
                                    
                                    $prefix         = $passengerInfo['name']['title'];
                                    $firstName      = $passengerInfo['name']['first'];
                                    $lastName       = $passengerInfo['name']['last'];
                                    $passangerType  = $passengerInfo['passengerTypeCode'];

                                    /*Each Product class baggage*/
                                    foreach ($productClasses as $productClass) { 
                                        $flightClass = $productClass['flightClass'];
                                        $flightNumber = $productClass['flightNumber'];
                                        $baggage        = $frontEndHomeController->getProductClassInfo($flightClass,$passangerType);
                                        $baggageDetails[]=[
                                            "info"              => $baggage,
                                            "travelerType"      => $passangerType,
                                            "class"             => $flightClass,
                                            "flightNumber"      => $flightNumber,
                                        ];
                                    }

                                    $passengersList[] = [
                                        "travelerType"  => $passangerType,
                                        "prefix"        => $prefix,
                                        "firstName"     => $firstName,
                                        "lastName"      => $lastName,
                                        "ticketNumber"  => $booking['recordLocator'],
                                    ];

                                    //ADT & CHD ticket update
                                    $TravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id", $flightbookingdetails->id);
                                     
                                    if (!empty($firstName)) {
                                        $TravelerInfo = $TravelerInfo->where("first_name", $firstName);
                                    }

                                    $TravelerInfo = $TravelerInfo->where("first_name", $firstName)
                                        ->where("last_name", $lastName)
                                        ->first();

                                    if ($TravelerInfo) {
                                        $TravelerInfo->travel_port_ticket_status = $booking['info']['status'];
                                        $TravelerInfo->travel_port_ticket_number = $booking['recordLocator'];
                                        $TravelerInfo->save();
                                    } 
                                     
                                    
                                     
                                    if (isset($passengerInfo['infant'])) {
                                        $infantInfo         = $passengerInfo['infant'];
                                        $infantFirstName    = $infantInfo['name']['first'];
                                        $infantLastName     = $infantInfo['name']['last'];
                                        $infantPrefix       = $infantInfo['name']['title'];
                                        $passangerType      = "INF";
                                        /*Each Product baggage*/
                                        foreach ($productClasses as $productClass) { 
                                            $flightClass = $productClass['flightClass'];
                                            $flightNumber = $productClass['flightNumber'];
                                            $baggage        = $frontEndHomeController->getProductClassInfo($flightClass,$passangerType);
                                            $baggageDetails[]=[
                                                "info"              => $baggage,
                                                "travelerType"      => $passangerType,
                                                "class"             => $flightClass,
                                                "flightNumber"      => $flightNumber,
                                            ];
                                        }

                                        $passengersList[]   = [
                                            "travelerType"  => $passangerType,
                                            "prefix"        => $infantPrefix,
                                            "firstName"     => $infantFirstName,
                                            "lastName"      => $infantLastName,
                                            "ticketNumber"  => $booking['recordLocator'],

                                        ];
                                        //INF TICKET UODATE
                                        $TravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id", $flightbookingdetails->id);
                                         
                                        if (!empty($infantFirstName)) {
                                            $TravelerInfo = $TravelerInfo->where("first_name", $infantFirstName);
                                        }

                                        $TravelerInfo = $TravelerInfo->where("first_name", $infantFirstName)
                                            ->where("last_name", $infantLastName)
                                            ->first();

                                        if ($TravelerInfo) {
                                            $TravelerInfo->travel_port_ticket_status = $booking['info']['status'];
                                            $TravelerInfo->travel_port_ticket_number = $booking['recordLocator'];
                                            $TravelerInfo->save();
                                        }
                                    }

                                }
                            }

                            // $result['passengersList']   = $passengersList;
                            foreach($segments as $key=>$segment){
                                $segments[$key]['passengersList'] = $passengersList;
                            }

                            $result['airLinePnrs']      = $airLinePnrs;
                            $result['segments']         = $segments;
                            $result['baggageInfo']      = $baggageDetails;
                        }
                       
                    }
                    //return view('front_end.email_templates.ticket',compact('titles','result'));

                    $extrabaggageinfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where(function ($query) {
                        $query->where('depature_extra_baggage', '!=', '')
                              ->orWhere('return_extra_baggage', '!=', '');
                    })->get();
    
                    $result['extrabaggageinfo'] = $extrabaggageinfo;
                    
               
                    $filename = "Ticket_".$flightbookingdetails->booking_ref_id.".pdf";
                    $pdf = PDF::loadView('front_end.email_templates.ticket', compact('titles','result'));
                    $pdf->save('pdf/tickets/' . $filename);

                    $completePath = 'pdf/tickets/' . $filename;
                    $flightbookingdetails->flight_ticket_path = $completePath;
                    $flightbookingdetails->save();

                    
                    Mail::send('front_end.email_templates.ticket', compact('titles','result'), function($message)use($pdf,$flightbookingdetails,$filename) {
                        $message->to($flightbookingdetails->email)
                                ->subject('flightTicket')
                                ->attachData($pdf->output(), $filename);
                    });

                    $this->invoice($result,$user,$flightbookingdetails);

                    // return response()->json([
                    //     'status' => true,
                    //     'message' => "ticket done",
                    //     "data" => [],
                    // ], 200);
                    header("Cache-Control: no-cache");
                    $data = [
                        "reference_no" => $flightbookingdetails->booking_ref_id,
                        "payment_id" => $paymentId,
                        "paid_amount" => $flightbookingdetails->total_amount,
                        "currency_code" => $flightbookingdetails->currency_code,
                        "status" => str_replace("_"," ",$flightbookingdetails->booking_status),
                    ];
                    //echo "<pre>"; print_r($data);die;
                    return view('flutter_app.success', compact('data'));
    
                    // return view('front_end.air.booking_flight_itinerary',compact('titles','response','user','traceId','flightbookingdetails'));
    
                }
                else{
                    //if not paid or expired

                    $data['errorresponse'] = $invoicedata['Data']->InvoiceStatus;
                    //travelport request error response
                    //refund should initate
                    //redirect to error page

                    // return view('front_end.error',compact('titles','data'));
                    // return response()->json([
                    //     'status' => false,
                    //     'message' => $invoicedata['Data']->InvoiceStatus,
                    //     "data" => [],
                    // ], 200);
                    return $this->app_web_error(['error' =>$invoicedata['Data']->InvoiceStatus,'booking_id'=>$flightbookingId]);

                } 
    
            }

        }
        else{
            //second time page reloaded 
            //error
            return redirect()->route('some-thing-went-wrong');
        }
    }

    public function app_web_error($arrayData)
    {
        $flightbookingdetails = FlightBooking::find($arrayData['booking_id']);
        header("Cache-Control: no-cache");
        $data = [
            "reference_no" => $flightbookingdetails->booking_ref_id,
            "payment_id" => $flightbookingdetails->payment_id,
            "paid_amount" => $flightbookingdetails->total_amount,
            "currency_code" => $flightbookingdetails->currency_code,
            "status" => str_replace("_"," ",$flightbookingdetails->booking_status),
            "error" =>$arrayData['error'],
        ];
        return view('flutter_app.failure', compact('data'))->render();

    }
    
    public function invoice($result,$user,$flightbookingdetails)
    {
        $filename = "Invoice_".$flightbookingdetails->invoice_id.".pdf";
        $pdf = PDF::loadView('front_end.air.invoice', compact('result'));
        // $path = public_path('pdf/invoice/');
        $completePath = 'pdf/invoice/' . $filename;
        $flightbookingdetails->invoice_path = $completePath;
        $flightbookingdetails->save();
        $pdf->save('pdf/invoice/' . $filename);

        return Mail::send('front_end.air.invoice', compact('result','flightbookingdetails'), function($message)use($pdf,$flightbookingdetails,$filename) {
            $message->to($flightbookingdetails->email)
                    ->subject('Invoice')
                    ->attachData($pdf->output(), $filename);
        });
    }

    public function pnr(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pnr' => ['required']
        ]);
   

        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
        $pnr = $request->input('pnr');
       

        $flightbookingdetails = FlightBooking::select('flight_bookings.*',$this->ApiImage("/",'flight_ticket_path'))->LeftJoin('airlines_pnrs' , 'airlines_pnrs.booking_id' ,'=' , 'flight_bookings.id')->where('ticket_status', 1)->where(function($query) use($pnr)
        {
            $query->where('booking_ref_id' ,  $pnr)
            ->orWhere('airline_pnr' , $pnr);
        })->first();

        if(empty($flightbookingdetails))
        {
            //error
             return response()->json([
                'status' => false,
                'message' => "Booking Reference / PNR No not found",
            ], 200);
        }
        elseif($flightbookingdetails->is_cancel == 1)
        {
            //error
             return response()->json([
                'status' => false,
                'message' => "Ticket Canceled",
            ], 200);
             
        }
        else{

            $travelportrequest = TravelportRequest::where('id' , $flightbookingdetails->travel_request_id)->first();
            if ($flightbookingdetails->supplier_type !== 'airjazeera') {
                $responseArray = XmlToArray::convert($travelportrequest->response_xml, $outputRoot = false);
            }
            
            
        }
        if($flightbookingdetails->supplier_type == 'travelport')
        {
            $response = ($travelportrequest->request_type == 'universalRecordRetrieve')?$responseArray['SOAP:Body']['universal:UniversalRecordRetrieveRsp'] : $responseArray['SOAP:Body']['universal:AirCreateReservationRsp'];
            // $response = $responseArray['SOAP:Body']['universal:AirCreateReservationRsp'];
            if(isset($response['universal:UniversalRecord']['common_v52_0:BookingTraveler']['@attributes']))
            {
                $temp = '';
                $temp = $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'];
                $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] = [];
                $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'][0] = $temp;
            }
            foreach($response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] as $key=>$travelerInfo) {

                $tickendingDetails = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where("title",$travelerInfo['common_v52_0:BookingTravelerName']['@attributes']['Prefix'])->where("first_name",$travelerInfo['common_v52_0:BookingTravelerName']['@attributes']['First'])->where("last_name",$travelerInfo['common_v52_0:BookingTravelerName']['@attributes']['Last'])->first();
                $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'][$key]['common_v52_0:BookingTravelerName']['@attributes']['TicketNumber'] = $tickendingDetails->travel_port_ticket_number?? '';
            }
            if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment']['@attributes']))
            {
                $temp = '';
                $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'];
                $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] = [];
                $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][0] = $temp;
            }
            if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']['@attributes']))
            {
                $temp = '';
                $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'];
                $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] = [];
                $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0] = $temp;
            }
            foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $APK =>$APV)
            {
                if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo']['@attributes']))
                {
                    $temp = '';
                    $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'];
                    $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'] = [];
                    $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'][0] = $temp;
                }
                if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo']['@attributes']))
                {
                    $temp = '';
                    $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'];
                    $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'] = [];
                    $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'][0] = $temp;
                }
            }

            foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] as $s=>$value)
            {
                $airlinedetails = Airline::whereVendorCode($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Carrier'])->first();

                $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['airLineDetais'] =  $airlinedetails;

                $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['OriginAirportDetails'] = $this->AirportDetails($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Origin']);

                $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['DestinationAirportDetails'] = $this->AirportDetails($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Destination']);

                $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['air:FlightDetails']['@attributes']['EquipmentDetails'] = Equipment::where('equipment_code',$response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['air:FlightDetails']['@attributes']['Equipment'])->first();

            }

            $noOfPassengerTypes = count($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']);
            foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'] as $bookingK =>$bookingV )
            {

                $SegmentIndex = array_search($bookingV['@attributes']['SegmentRef'],array_column(array_column($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'],'@attributes'),'Key'));

                $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bookingK]['@attributes']['segmentDetails'] = $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$SegmentIndex];

                $table =[];
                for ($i=0; $i < $noOfPassengerTypes; $i++) { 
                    $fareKey = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:BookingInfo'][$bookingK]['@attributes']['FareInfoRef'];

                    $airfareindex = array_search($fareKey,array_column(array_column($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'],'@attributes'),'Key'));

                    if(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
                    {
                        $passengertype = "ADULT";
                    }
                    elseif(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
                    {
                        $passengertype = "CHILD";
                    }
                    elseif(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
                    {
                        $passengertype = "INFANT";
                    }
                    // echo $passengertype;
                    if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces']))
                    {
                        $checkIn = array('type'=>'Pcs','value'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces'],'unit'=>'Pcs');
                    }
                    elseif(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']))
                    {
                        $checkIn = array('type'=>'weight','value'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Value'],'unit'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Unit']);
                    }
                    $table[$passengertype] = $checkIn;
                }

                $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bookingK]['@attributes']['baggageDetails'] = $table;


                
            }

            //Airline Pnrs
            if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes'])){
                $temp= [];
                $temp = $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes'];
                $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] = [];
                $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0]['@attributes'] = $temp;
            }

            if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']))
            {
                foreach($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $supplierkey => $suppliervalue) {
                    $airlineName = Airline::where('vendor_code' , $suppliervalue['@attributes']['SupplierCode'])->first();
                    // $airlineName = $airlineName->short_name ?? '' ;
                    $airlineName = $airlineName->name ?? '' ;
                    $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][$supplierkey]['@attributes']['airline_name'] = $airlineName;
                }
            }
            // foreach($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $supplierkey => $suppliervalue) {
            //     $airlineName = Airline::where('vendor_code' , $suppliervalue['@attributes']['SupplierCode'])->first();
            //     $airlineName = $airlineName->short_name ?? '' ;
            //     $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][$supplierkey]['@attributes']['airline_name'] = $airlineName;
            // }


            $response['universal:UniversalRecord']['air:AirReservation']['refundable'] = (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable']) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable'] == "true")) ? True : False;

            // if($flightbookingdetails->user_type != 'web_guest' && $flightbookingdetails->user_type != 'app_guest')
            // {
            //     $userdetails = User::find($flightbookingdetails->user_id);
            //     $user = $userdetails->first_name.' '.$userdetails->last_name;;
            // }
            // else{
            //     $user = '';
            // }
            $segments = [];
            foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'] as $bk=>$bookinginfo){
                //layover
                $layover = null;
                
                if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk+1]))
                {
                    if($flightbookingdetails->booking_type == 'roundtrip' && $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk]['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails']->airport_code == strtoupper($flightbookingdetails->to) )
                    {
                        $layover = null ;
                    }
                    else{
                        $layover = LayoverTime($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk]['@attributes']['segmentDetails']['@attributes']['ArrivalTime'] , $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk+1]['@attributes']['segmentDetails']['@attributes']['DepartureTime']);
                    }
                }
                else
                {
                    $layover = null;
                }
                $passengersList = [];
                $flightNumber = $bookinginfo['@attributes']['segmentDetails']['@attributes']['FlightNumber'];

                $passengersInfo = FlightBookingTravelsInfo::leftjoin("flight_ticket_numbers","flight_booking_travels_infos.id","=","flight_ticket_numbers.flight_booking_travels_info_id")->where("flight_booking_travels_infos.flight_booking_id" , $flightbookingdetails->id)->where('flight_number',$flightNumber)->where('from',$bookinginfo['@attributes']['segmentDetails']['@attributes']['Origin'])->where('to',$bookinginfo['@attributes']['segmentDetails']['@attributes']['Destination'])->get();

                foreach ($passengersInfo as $TravelsInfo) {
                    if($TravelsInfo->traveler_type == 'ADT'){
                        $TravelerType = "Adult";
                    }
                    elseif($TravelsInfo->traveler_type == 'CNN')
                    {
                    $TravelerType = "Child";
                    }
                    elseif($TravelsInfo->traveler_type == 'INF')
                    {
                    $TravelerType = "Infant";
                    }
                    else{$TravelerType = "Infant";}
                    $passengersList[] = array(
                        'travelerType' => $TravelerType,
                        'prefix' => $TravelsInfo->title,
                        'firstName' => $TravelsInfo->first_name,
                        'lastName' => $TravelsInfo->last_name,
                        'ticketNumber' => $TravelsInfo->ticket_number,
                    );
                    
                }
                $segments[] =  array(
                    'OriginAirportDetails' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['OriginAirportDetails'],
                    'DestinationAirportDetails' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails'],
                    'DepartureDate' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['DepartureTime'],'date'),
                    'DepartureTime' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['DepartureTime'],'time'),
                    'ArrivalDate' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],'date'),
                    'ArrivalTime' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],'time'),
                    'Status' => ($bookinginfo['@attributes']['segmentDetails']['@attributes']['Status'] == 'HK') ? 'Confirmed' : 'Not - Confirmed', 
                    'Carrier' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['Carrier'],
                    'AirLine' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['airLineDetais'],
                    'FlightNumber' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['Carrier'].$bookinginfo['@attributes']['segmentDetails']['@attributes']['FlightNumber'],
                    'FlightTime' =>segmentTime($bookinginfo['@attributes']['segmentDetails']['@attributes']['TravelTime']),
                    'Refundable' => $response['universal:UniversalRecord']['air:AirReservation']['refundable'],
                    'FlightName' => (isset($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']) && !empty($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails'])) ?$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']->short_name : $bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['Equipment'],
                    'Class' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['CabinClass'],
                    'CheckIn' => $bookinginfo['@attributes']['baggageDetails'],
                    'Layover' => $layover,
                    'passengersList' => $passengersList
                );

            }
            // $passengersList = [];
            // foreach ($response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] as $TravelsInfo) {
            //     if($TravelsInfo['@attributes']['TravelerType'] == 'ADT'){
            //         $TravelerType = "Adult";
            //     }
            //     elseif($TravelsInfo['@attributes']['TravelerType'] == 'CNN')
            //     {
            //     $TravelerType = "Child";
            //     }
            //     elseif($TravelsInfo['@attributes']['TravelerType'] == 'INF')
            //     {
            //     $TravelerType = "Infant";
            //     }
            //     else{$TravelerType = "Infant";}
            //     $passengersList[] = array(
            //         'travelerType' => $TravelerType,
            //         'prefix' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Prefix'],
            //         'firstName' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['First'],
            //         'lastName' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Last'],
            //         'ticketNumber' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['TicketNumber'],
            //     );
                
            // }
            // $result['passengersList'] = $passengersList;
            $result['segments'] = $segments;
            $result['flightBookingDetails'] = $flightbookingdetails;
            if(!isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']))
            {
                //pnr not generated
                //Some airline hosting systems are unable to process all the requests at the same time, hence the vendor locator is not assigned (in some cases) straight away to the PNR.

                // As per TVP recommendations, an agent should wait up to 2 hours for the vendor locator until reporting it as an issue.
                $airlinePnr[0] = array('pnr' => '---' , 'airline' => '---');
            }

            elseif(count($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) == 1 )
            {
                $airlinePnr[0] = array('pnr' => $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0]['@attributes']['SupplierLocatorCode'] , 'airline' => $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0]['@attributes']['airline_name']);
            }
            else{
                foreach($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $supplierCode)
                {
                    $airlinePnr[] = array('pnr' => $supplierCode['@attributes']['SupplierLocatorCode'] , 'airline' => $supplierCode['@attributes']['airline_name']);

                }
            }
            $result['airLinePnrs'] = $airlinePnr;

        }
        elseif($flightbookingdetails->supplier_type == 'airarabia')
        // elseif($flightbookingdetailssupplier_type == 'airarabia')
        {

            $response = $responseArray['soap:Body'];
            //airarabia flight Ticket
            // $response = file_get_contents(public_path('response.xml'));
            // $converted = XmlToArray::convert($response, $outputRoot = false);
            // $response =[];
            // $response = $converted['soap:Body'];
           
        
            if(isset($response['ns1:Errors']))
            {
                //error
            }
            else{
                $result['flightBookingDetails'] = $flightbookingdetails;
                $segments = [];
                if(isset($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption']['ns1:FlightSegment']))
                {
                    $temp = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'];
                    $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] = [];
                    $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'][0] = $temp;
                }
                foreach ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] as $rspSegkey => $rspSegValue) {

                    $passengersList = [];
                    $flightNumber = $rspSegValue['ns1:FlightSegment']['@attributes']['FlightNumber'];


                    $passengersInfo = FlightBookingTravelsInfo::leftjoin("flight_ticket_numbers","flight_booking_travels_infos.id","=","flight_ticket_numbers.flight_booking_travels_info_id")->where("flight_booking_travels_infos.flight_booking_id" , $flightbookingdetails->id)->where('flight_number',$flightNumber)->where('from',$rspSegValue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode'])->where('to',$rspSegValue['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode'])->get();

                    foreach ($passengersInfo as $TravelsInfo) {
                        if($TravelsInfo->traveler_type == 'ADT'){
                            $TravelerType = "Adult";
                        }
                        elseif($TravelsInfo->traveler_type == 'CHD')
                        {
                        $TravelerType = "Child";
                        }
                        elseif($TravelsInfo->traveler_type == 'INF')
                        {
                        $TravelerType = "Infant";
                        }
                        else{$TravelerType = "Infant";}
                        $passengersList[] = array(
                            'travelerType' => $TravelerType,
                            'prefix' => $TravelsInfo->title,
                            'firstName' => $TravelsInfo->first_name,
                            'lastName' => $TravelsInfo->last_name,
                            'ticketNumber' => $TravelsInfo->ticket_number,
                        );
                        
                    }
                    //layover yet to do
                    $segments[] = array(
                    'OriginAirportDetails' => $this->AirportDetails($rspSegValue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode']),
                    'DestinationAirportDetails' => $this->AirportDetails($rspSegValue['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode']),
                    'DepartureDate' => DateTimeSpliter($rspSegValue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'date'),
                    'DepartureTime' => DateTimeSpliter($rspSegValue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'time'),
                    'ArrivalDate' => DateTimeSpliter($rspSegValue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'date'),
                    'ArrivalTime' => DateTimeSpliter($rspSegValue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'time'),
                    'Status' => ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:Ticketing']['@attributes']['TicketingStatus'] == '3') ? 'Confirmed' : 'Not - Confirmed', 
                    'Carrier' => 'G9',
                    'AirLine' => Airline::whereVendorCode('G9')->first(),
                    'FlightNumber' => $rspSegValue['ns1:FlightSegment']['@attributes']['FlightNumber'],
                    'FlightTime' => LayoverTime($rspSegValue['ns1:FlightSegment']['@attributes']['DepartureDateTime'] , $rspSegValue['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    'Refundable' => "false",
                    'FlightName' => $rspSegValue['ns1:FlightSegment']['@attributes']['FlightNumber'],
                    'Class' => (isset($rspSegValue['ns1:FlightSegment']['@attributes']['ResCabinClass']) ? ($rspSegValue['ns1:FlightSegment']['@attributes']['ResCabinClass'] == 'Y' ? "Economy" : "Business" ) : ""),
                    'AirArabiaCheckIn' => 'Include a generous 10 KG Hand Baggage',
                    'Layover' => '',
                    'passengersList' => $passengersList
                );
                }
                usort($segments, function($a, $b) {
                    return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
                });
                if($flightbookingdetails->booking_type == 'roundtrip')
                {
                    //no change for oneway
                    
                }
                $layover = null;
                // foreach ($segments as $sk => $segment) {
                //     $layover = null;
                    
                //     if(isset($segments[$sk+1]))
                //     {
                //         if($flightbookingdetails->booking_type == 'roundtrip' && $segment['DestinationAirportDetails']['airport_code'] == strtoupper($flightbookingdetails->to))
                //         {
                //             $layover = null ;
                //         }
                //         else{
                //             $layover = LayoverTime( $segments[$sk]['ArrivalDate']."+".$segments[$sk]['ArrivalTime'], $segments[$sk+1]['DepartureDate']."+".$segments[$sk]['DepartureTime']);
                //         }
                //     }
                //     else
                //     {
                //         $layover = null;
                //     }
                //     $segments[$sk]['Layover'] = $layover;
                // }
                foreach ($segments as $itkey => $itvalue) {
                    $layover = null;
                    if(isset($segments[$itkey+1]))
                    {
                        if($flightbookingdetails->booking_type == 'roundtrip' && $segments[$itkey]['DestinationAirportDetails']->airport_code == strtoupper($flightbookingdetails->to))
                        {
                            $layover = null ;
                        }
                        else{
                            $layover = LayoverTime( $segments[$itkey]['ArrivalDate']."T".$segments[$itkey]['ArrivalTime'].":00.000+00:00", $segments[$itkey+1]['DepartureDate']."T".$segments[$itkey+1]['DepartureTime'].":00.000+00:00");
                        }
                    }
                    else
                    {
                        $layover = null;
                    }
                    $segments[$itkey]['Layover'] = $layover;
                }
                
                

                if(isset($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID']['@attributes']))
                {
                    $temp = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID'];
                    $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID'] =[];
                    $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID'][0] = $temp;

                }
             
                $airLinePnrs = [];
                foreach ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:BookingReferenceID'] as $pnrKey => $pnrValue) {
                    $airLinePnrs[] =array(
                        'pnr' => $pnrValue['@attributes']['ID'],
                        'airline' => 'Air Arabia',
                    );
                }
                // $passengersList = [];
                if(isset($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler']['ns1:PersonName']))
                {
                    $temp = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler'];
                    $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler'] = [];
                    $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler'][0] = $temp;
                }
                // foreach ($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:AirTraveler'] as $travelerInfo) {
                //     if($travelerInfo['@attributes']['PassengerTypeCode'] == 'ADT')
                //     {
                //         $passangerType = 'Adult';
                //     }elseif($travelerInfo['@attributes']['PassengerTypeCode'] == 'CHD'){
                //         $passangerType = 'Child';
                //     }else{
                //         $passangerType = 'Infant';
                //     }
                //     $tickendingDetails = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id);
                //     if(!empty($travelerInfo['ns1:PersonName']['ns1:NameTitle'])){
                //         $tickendingDetails = $tickendingDetails->where("title",$travelerInfo['ns1:PersonName']['ns1:NameTitle']);
                //     }
                
                //     $tickendingDetails = $tickendingDetails->where("first_name",$travelerInfo['ns1:PersonName']['ns1:GivenName'])->where("last_name",$travelerInfo['ns1:PersonName']['ns1:Surname'])->first();
                       
                //     $passengersList[] = array(
                //         "travelerType" => $passangerType,
                //         "prefix" => $travelerInfo['ns1:PersonName']['ns1:NameTitle'] ?? strtoupper($tickendingDetails->title),
                //         "firstName" => $travelerInfo['ns1:PersonName']['ns1:GivenName']??'',
                //         "lastName" => $travelerInfo['ns1:PersonName']['ns1:Surname']??'',
                //         "ticketNumber" => $tickendingDetails->travel_port_ticket_number ?? ''
                //     );
                // }
                $extrabaggageinfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where(function ($query) {
                    $query->where('depature_extra_baggage', '!=', '')
                          ->orWhere('return_extra_baggage', '!=', '');
                })->get();

                $result['extrabaggageinfo'] = $extrabaggageinfo;
                $result['passengersList'] = $passengersList;
                $result['airLinePnrs'] = $airLinePnrs;
                $result['segments'] = $segments;
  
            }
        }
        elseif($flightbookingdetails->supplier_type == 'airjazeera')
        {
            $pnr = $flightbookingdetails->reservation_pnr;
            $bookingController = new \App\Http\Controllers\Air\BookingController();
            $frontEndHomeController = new \App\Http\Controllers\FrontEnd\HomeController();
            $data = ["pnr"=> $pnr, "requestFrom" => "MOBILE"];
            $booking = $bookingController->retrieveBookingByRecordLocator($data);
  
            if(isset($booking) && isset($booking['jazeeraResponse']['data']['journeys'])){
                $bookingResponse    =   $booking['jazeeraResponse']['data'];
                $journeyDetails     =   $bookingResponse['journeys'];
                $statusInfo         =   $bookingResponse['info'];
                $passengers         =   $bookingResponse['passengers'];
                
                $statusText = '';
                switch ($statusInfo['status']) {
                    case 0:
                        $statusText = 'Default';
                        break;
                    case 1:
                        $statusText = 'Hold';
                        break;
                    case 2:
                        $statusText = 'Confirmed';
                        break;
                    case 3:
                        $statusText = 'Closed';
                        break;
                    case 4:
                        $statusText = 'HoldCanceled';
                        break;
                    case 5:
                        $statusText = 'PendingArchive';
                        break;
                    case 6:
                        $statusText = 'Archived';
                        break;
                    default:
                        $statusText = 'Unknown';  
                        break;
                }
                
                $prevArrivalTimeUtc = null;
                foreach($journeyDetails as $journey)
                {
                    foreach($journey['segments'] as $itinerary){  
                        //$flightClass            = $itinerary['fares'][0]['productClass'];
                        // $productClasses[]       = ['flightClass' => $flightClass,'flightNumber' => $itinerary['identifier']['identifier']];
                        $departureTimeUtc       = $itinerary['legs'][0]['legInfo']['departureTimeUtc'];
                        $arrivalTimeUtc         = $itinerary['legs'][0]['legInfo']['arrivalTimeUtc'];
                        $departureDateTimeUtc   = new DateTime($departureTimeUtc, new DateTimeZone('UTC'));
                        $arrivalDateTimeUtc     = new DateTime($arrivalTimeUtc, new DateTimeZone('UTC'));
                        $flightDuration         = $departureDateTimeUtc->diff($arrivalDateTimeUtc);
                        $flightTravelTime       = $flightDuration->format('%H:%I');

                          // Calculate layover time
                        $layoverTime = null;
                        if ($prevArrivalTimeUtc !== null) {
                            $layoverStart       = new DateTime($prevArrivalTimeUtc, new DateTimeZone('UTC'));
                            $layoverEnd         = $departureDateTimeUtc;
                            $layoverDuration    = $layoverStart->diff($layoverEnd);
                            // Get the total minutes of layover
                            $layoverMinutes     = $layoverDuration->days * 24 * 60 + $layoverDuration->h * 60 + $layoverDuration->i;
                            // Calculate days, hours, and minutes
                            $layoverDays        = floor($layoverMinutes / (24 * 60));
                            $layoverHours       = floor(($layoverMinutes - ($layoverDays * 24 * 60)) / 60);
                            $layoverMinutes     = $layoverMinutes % 60;
                            // Format the layover time
                            $layoverTime = '';
                            if ($layoverDays > 0) {
                                $layoverTime .= sprintf('%dD ', $layoverDays);
                            }
                            if ($layoverHours > 0) {
                                $layoverTime .= sprintf('%dH ', $layoverHours);
                            }
                            if ($layoverMinutes > 0 || empty($layoverTime)) {
                                $layoverTime .= sprintf('%dM', $layoverMinutes);
                            }
                        }


                        $passengersList = [];
                        /*Passanger*/
                        $noofAdults = 0;
                        $noofChildren = 0;
                        $noofInfants = 0;
                        if(isset($passengers)) {
                            foreach ($passengers as $passenger) {
                                $prefix         = $passenger['name']['title'];
                                $firstName      = $passenger['name']['first'];
                                $lastName       = $passenger['name']['last'];
                                $passangerType  = ($passenger['passengerTypeCode'] === 'ADT') ? 'Adult' : 'Child';  
                                if ($passangerType === 'Adult') {
                                    $noofAdults++;
                                } elseif ($passangerType === 'Child') {
                                    $noofChildren++;
                                }
                                $passengersList[] = [
                                    "travelerType"  => $passangerType,
                                    "prefix"        => $prefix,
                                    "firstName"     => $firstName,
                                    "lastName"      => $lastName,
                                    "ticketNumber"  => $pnr,
                                ];
                                if (isset($passenger['infant'])) {
                                    $noofInfants++;
                                    $infantInfo         = $passenger['infant'];
                                    $infantFirstName    = $infantInfo['name']['first'];
                                    $infantLastName     = $infantInfo['name']['last'];
                                    $infantPrefix       = $infantInfo['name']['title'];
                                    $passangerType      = "Infant";
                       
                                    $passengersList[]   = [
                                        "travelerType"  => $passangerType,
                                        "prefix"        => $infantPrefix,
                                        "firstName"     => $infantFirstName,
                                        "lastName"      => $infantLastName,
                                        "ticketNumber"  => $pnr,

                                    ];
         
                                }
                            }
                        }

                        $productClass            = $itinerary['fares'][0]['productClass'];
                        $myItinary['AirSegment'] = $itinerary;
                        $userRequest = [
                            'noofAdults' => $noofAdults,
                            'noofChildren' => $noofChildren,
                            'noofInfants' =>  $noofInfants

                        ];

                        $originStationCode = $this->AirportDetails($itinerary['designator']['origin']);
                        $destinationStationCode = $this->AirportDetails($itinerary['designator']['destination']);

                        $myItinary['AirSegment'] = [
                            'OriginAirportDetails'      => $originStationCode,
                            'DestationAirportDetails' =>  $destinationStationCode,
                            'FlightNumber' =>   $itinerary['identifier']['identifier'],
                        ];
                      
                        $baggageData             = $frontEndHomeController->getBaggageForPassenger($userRequest, $productClass, $myItinary);
                       

                        $checkIn = [];

                        if (isset($baggageData["table"]["ADULT"])) {
                            $checkIn["ADULT"] = [
                                "type" => "weight",
                                "value" => $baggageData["table"]["ADULT"]["checkIn"]["value"],
                                "unit" => "Kilograms"
                            ];
                        }

                        if (isset($baggageData["table"]["CHILD"])) {
                             $checkIn["CHILD"] = [
                                "type" => "weight",
                                "value" => $baggageData["table"]["CHILD"]["checkIn"]["value"],
                                "unit" => "Kilograms"
                            ];
                        }
 
                         
                        /*End Passanger*/
                        $result[] =  array(
                            'OriginAirportDetails'      =>  $originStationCode,
                            'DestinationAirportDetails' =>  $destinationStationCode,
                            'DepartureDate'             =>  DateTimeSpliter($itinerary['designator']['departure'],'date'),
                            'DepartureTime'             =>  DateTimeSpliter($itinerary['designator']['departure'],'time'),
                            'ArrivalDate'               =>  DateTimeSpliter($itinerary['designator']['arrival'],'date'),
                            'ArrivalTime'               =>  DateTimeSpliter($itinerary['designator']['arrival'],'time'),
                            'Status'                    =>  $statusText,
                            'Carrier'                   =>  $itinerary['identifier']['carrierCode'],
                            //'CodeshareInfo'           =>  'Air Jazeera',
                            'AirLine'                   =>  Airline::whereVendorCode('J9')->first(),
                            'FlightNumber'              =>  $itinerary['identifier']['carrierCode'].$itinerary['identifier']['identifier'],
                            'FlightTime'                =>  $flightTravelTime,
                            'Refundable'                =>  "false",
                            'FlightName'                =>  $itinerary['identifier']['identifier'],
                            'Class'                     =>  $itinerary['fares'][0]['productClass'],
                            'CheckIn'                   =>  $checkIn,
                            'Layover'                   =>  ($layoverTime === '00:00') ? null : $layoverTime, // Set to null if layover is 00:00
                            'passengersList'            =>  $passengersList
                        );

                        $prevArrivalTimeUtc = $arrivalTimeUtc;
                    }
                    $prevArrivalTimeUtc = null;
                }

                usort($result, function($a, $b) {
                    return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
                });
                
  

                $airLinePnrs[] =array(
                    'pnr' => $pnr,
                    'airline' => 'Jazeera Airways',
                );

                $response = [
                    'status' => true,
                    'message' => self::SUCCESS_MSG,
                    'data' => [
                        'segments' => $result,  // Assign $result to the 'segments' key
                        'flightBookingDetails' => $flightbookingdetails,
                        'airLinePnrs' => $airLinePnrs  // array for 'airLinePnrs'
                    ]
                ];

                return response()->json($response, 200);

            }
        }

        // $html =  View::make('front_end.air.bookingpopup',compact('titles','response','user','traceId','flightbookingdetails'))->render();

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $result
        ], 200);

    }
    public function airArabiaExtraBaggage($data=null)
    {
        $AirBooking = new BookingController();
        $response = $AirBooking->AirArabiaBaggage($data);
        $response = $response['travelportResponse'];        
        if(isset($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:Errors']) && !empty($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:Errors']))
        {
            //error
            return [];
        }else{
            if(isset($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']) && !empty($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']))
            {
                if(isset($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:Baggage']['ns1:baggageCode']))
                {
                    $temp = $response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:Baggage'];
                    $response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:Baggage'] = [];
                    $response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:Baggage'][0] = $temp;
                }
                $baggage = [];
                foreach ($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:Baggage'] as $key => $value) {
                    $baggage[] = array(
                        'baggageCode'=> $value['ns1:baggageCode'],
                        'baggageCharge' => extraPricing(array('amount' => $value['ns1:baggageCharge'],'currency_code' => $value['ns1:currencyCode'] ,'from' => 'airarabia' ,'withOutMarkUp' => true)),
                        'baggageDescription' => $value['ns1:baggageDescription'],
                    );
                }
                
                usort($baggage, function($a, $b) {
                    return $a['baggageCharge']['total_price']['value'] <=> $b['baggageCharge']['total_price']['value'];
                });
                // dd($baggage);
                return $baggage;

            }
            else
            {
                // echo 123;
                return [];
            }
           
        }

    }

    public function AirJazeeraDetails($flights,$userRequest,$traceId,$extraInfo =[])
    {
         
 
        $AirBooking = new BookingController();
        $frontEndHomeController = new \App\Http\Controllers\FrontEnd\HomeController();
   
        if((isset($extraInfo['page_type']) && ($extraInfo['page_type'] == 'preview')))
        {
             

            $passengersKey = TravelportRequest::find($traceId);
            $passengersKeyDecode = $phpArray = json_decode($passengersKey->json_response, true);
            if(isset($passengersKeyDecode['data']['passengers'])){
                $extraInfo['passengers'] = $passengersKeyDecode['data']['passengers'];
            }
            $airPricingrResponse = $AirBooking->tripSellRequestJazeera($flights,$userRequest,$traceId,$extraInfo); 
        }
        else{
            /*set request for mobile*/
            $userRequest['currencyCode'] = $flights['originCurrency'];
            $userRequest['tokenData']    = $flights['tokenData'];
            $userRequest['requestFrom']  = "MOBILE";
            $airPricingrResponse = $AirBooking->bookingQuoteRequestJazeera($flights,$userRequest,$traceId,$extraInfo);
        }

        //dd("FrontHere");

        if(isset($airPricingrResponse['jazeeraResponse'][0]['dotrezAPI']['dotrezErrors']))
        {
            return array(
                'status'    => false,
                'message'   => "Something went wrong.",
            );
        }

        if(isset($airPricingrResponse['jazeeraResponse']) && isset($airPricingrResponse['jazeeraResponse']['passengers'])){
            $infantTax            = 0;
            $infantTotal          = 0;
            $passengers           = $airPricingrResponse['jazeeraResponse']['passengers'];
            $journeyDetails       = $airPricingrResponse['jazeeraResponse']['journeys'];
            $fareDetails          = $airPricingrResponse['jazeeraResponse']['breakdown'];
            $TotalPrice           = $fareDetails['totalAmount'];
            $currencyCode         = $flights['originCurrency'];

            //check infant base price and tax if available
            if(isset($fareDetails['passengerTotals']['infant']) && !empty($fareDetails['passengerTotals']['infant'])){
                $infantTotal = $fareDetails['passengerTotals']['infant']['total'];
                $infantTax = $fareDetails['passengerTotals']['infant']['taxes'];

            }
            $tax                  = $fareDetails['journeyTotals']['totalTax'] + $infantTax;
            $ApproximateBasePrice = $fareDetails['journeyTotals']['totalAmount'] + $infantTotal;

            $convertedTotalPrice  = getCurrencyConversionData($TotalPrice, $currencyCode);
            $convertedTax         = getCurrencyConversionData($tax, $currencyCode);
            $convertedApproximateBasePrice = getCurrencyConversionData($ApproximateBasePrice, $currencyCode);

            $additonalInfo = ['RequestIsFrom' => 'api' , 'currency_code' => "KWD" , 'from' => 'airjazeera'];
            $additonalInfo['couponCode'] = (isset($extraInfo['couponCode']) && !empty($extraInfo['couponCode'])) ?  $extraInfo['couponCode'] : null;
           
            $mKprice = markUpPrice($convertedTotalPrice,$convertedTax,$convertedApproximateBasePrice , ((!empty($extraInfo) && isset($extraInfo['type_of_payment'])) ? $extraInfo['type_of_payment'] : 'k_net' ) , $additonalInfo );


            $prevArrivalTimeUtc = null;

            foreach($journeyDetails as $journey)
            {
               /* return ($journey);
                $productClass = $journey['value']['faresDetails']['value']['fares'][0]['productClass'];
                return($productClass);*/

                foreach($journey['segments'] as $itineraryvalue){  
                    $departureTimeUtc       = $itineraryvalue['legs'][0]['legInfo']['departureTimeUtc'];
                    $arrivalTimeUtc         = $itineraryvalue['legs'][0]['legInfo']['arrivalTimeUtc'];
                    $departureDateTimeUtc   = new DateTime($departureTimeUtc, new DateTimeZone('UTC'));
                    $arrivalDateTimeUtc     = new DateTime($arrivalTimeUtc, new DateTimeZone('UTC'));
                    $flightDuration         = $departureDateTimeUtc->diff($arrivalDateTimeUtc);
                    $flightTravelTime       = $flightDuration->format('%H:%I');

                    // Calculate layover time
                    $layoverTime = null;
                    if ($prevArrivalTimeUtc !== null) {
                        $layoverStart       = new DateTime($prevArrivalTimeUtc, new DateTimeZone('UTC'));
                        $layoverEnd         = $departureDateTimeUtc;
                        $layoverDuration    = $layoverStart->diff($layoverEnd);
                        // Get the total minutes of layover
                        $layoverMinutes     = $layoverDuration->days * 24 * 60 + $layoverDuration->h * 60 + $layoverDuration->i;
                        // Calculate days, hours, and minutes
                        $layoverDays        = floor($layoverMinutes / (24 * 60));
                        $layoverHours       = floor(($layoverMinutes - ($layoverDays * 24 * 60)) / 60);
                        $layoverMinutes     = $layoverMinutes % 60;
                        // Format the layover time
                        $layoverTime = '';
                        if ($layoverDays > 0) {
                            $layoverTime .= sprintf('%dD ', $layoverDays);
                        }
                        if ($layoverHours > 0) {
                            $layoverTime .= sprintf('%dH ', $layoverHours);
                        }
                        if ($layoverMinutes > 0 || empty($layoverTime)) {
                            $layoverTime .= sprintf('%dM', $layoverMinutes);
                        }
                    }

                    $segments[] =  array(
                        'airJazeeraData'            =>  json_encode($itineraryvalue),
                        'OriginAirportDetails'      =>  $this->AirportDetails($itineraryvalue['designator']['origin']),
                        'DestationAirportDetails'   =>  $this->AirportDetails($itineraryvalue['designator']['destination']),
                        'DepartureDate'             =>  DateTimeSpliter($itineraryvalue['designator']['departure'],'date'),
                        'DepartureTime'             =>  DateTimeSpliter($itineraryvalue['designator']['departure'],'time'),
                        'ArrivalDate'               =>  DateTimeSpliter($itineraryvalue['designator']['arrival'],'date'),
                        'ArrivalTime'               =>  DateTimeSpliter($itineraryvalue['designator']['arrival'],'time'),
                        'Carrier'                   =>  $itineraryvalue['identifier']['carrierCode'],
                        'CodeshareInfo'             =>  'Air Jazeera',
                        'AirLine'                   =>  'Air Jazeera',
                        'FlightNumber'              =>  $itineraryvalue['identifier']['identifier'],
                        'FlightTime'                =>  $flightTravelTime,
                        'from'                      =>  'mobile',
                        'Layover'                   =>   ($layoverTime === '00:00') ? null : $layoverTime, // Set to null if layover is 00:00
                        'productClass'              =>  $itineraryvalue['fares'][0]['productClass'],
                    );

                     $prevArrivalTimeUtc = $arrivalTimeUtc;
                }

                 $prevArrivalTimeUtc = null;
            }

            usort($segments, function($a, $b) {
                return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
            });

            
            // one baggage info if same product class
            /*$checkInBag = [];
            $displayedProductClasses = [];

            foreach ($segments as $l => &$itineraryVal) {
                // Retrieve the baggage data
                $productClass = $itineraryVal['productClass'];
                $myItinary['AirSegment'] = $itineraryVal;
                $baggageData = $frontEndHomeController->getBaggageForPassenger($userRequest, $productClass, $myItinary);

                $baggage = [
                    "@attributes" => [
                        "TravelerType" => "ADT",
                        "Origin" => $itineraryVal['OriginAirportDetails']->airport_code,
                        "Destination" => $itineraryVal['DestationAirportDetails']->airport_code,
                        "Carrier" => "J9"
                    ],
                    "air:URLInfo" => [
                        "air:URL" => ""
                    ],
                    "table" => []
                ];

                if (isset($baggageData["table"]["ADULT"])) {
                    $baggage["table"]["ADULT"] = $baggageData["table"]["ADULT"]["checkIn"]["value"] . "K";
                }

                if (isset($baggageData["table"]["CHILD"])) {
                    $baggage["table"]["CHILD"] = $baggageData["table"]["CHILD"]["carryOn"]["value"] . "K";
                }

                // Check if baggage information for this product class has been displayed before
                if (!isset($displayedProductClasses[$productClass])) {
                    $checkInBag[] = $baggage;
                    // Mark this product class as displayed
                    $displayedProductClasses[$productClass] = true;
                }

                // Update the itineraryVal with the baggage details
                //$itineraryVal['checkin'] = $checkInBag;
            }
            */
            //end
            $checkInBag = [];
            foreach ($segments as $l => &$itineraryVal) {
                $productClass            = $itineraryVal['productClass'];
                $myItinary['AirSegment'] = $itineraryVal;
                $baggageData             = $frontEndHomeController->getBaggageForPassenger($userRequest, $productClass, $myItinary);
                $baggage = [
                    "@attributes" => [
                        "TravelerType"  => "ADT",
                        "Origin"        => $itineraryVal['OriginAirportDetails']->airport_code,
                        "Destination"   => $itineraryVal['DestationAirportDetails']->airport_code,
                        "Carrier"       => "J9"
                    ],
                    "air:URLInfo" => [
                        "air:URL" => ""
                    ],
                    "table" => []
                ];

                if (isset($baggageData["table"]["ADULT"])) {
                    $baggage["table"]["ADULT"] = $baggageData["table"]["ADULT"]["checkIn"]["value"] . "K";
                }

                if (isset($baggageData["table"]["CHILD"])) {
                    $baggage["table"]["CHILD"] = $baggageData["table"]["CHILD"]["carryOn"]["value"] . "K";
                }

                $checkInBag[] = $baggage;

                // Update the itineraryVal with the baggage details
                //$itineraryVal['checkin'] = $checkInBag;
            }
            //dd($checkInBag);
            if($userRequest['flight-trip'] == 'roundtrip')
            {
                $bound = 'outbound' ;
                foreach ($segments as $segkey => $segvalue) {
                    $segments[$segkey]['segmentType'] = $bound;
                    if($segvalue['DestationAirportDetails']->airport_code == $userRequest['flightToAirportCode']){
                        $bound = 'inbound' ;
                    }
                }
            }

            /*Unset old user request and update with new token*/
            if(isset($airPricingrResponse['tokenData'])){
                $userRequest['tokenData'] = $airPricingrResponse['tokenData'];
            }

            $apidata['airSegments']             =   $segments;
            $apidata['refund']                  =   "false";
            $apidata['markupPrice']             =   $mKprice;
            $apidata['checkin']                 =   $checkInBag;
            $apidata['type']                    =   'airjazeera'; 
            $apidata['detailsRequestId']        =   $airPricingrResponse['trace_id'];
            $apidata['userRequest']             =   json_encode($userRequest);
            $apidata['transactionIdentifier']   =   null;

            return array(
                'status'    => true,   
                'message'   => self::SUCCESS_MSG, 
                "data"      => $apidata  
            );
        }        
    }

    private function airCreationAndURRetrieveFromate($response){
     
        if(isset($response['universal:UniversalRecord']['common_v52_0:BookingTraveler']['@attributes']))
        {
            $temp = '';
            $temp = $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'];
            $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] = [];
            $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'][0] = $temp;
        }
        if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment']['@attributes']))
        {
            $temp = '';
            $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'];
            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] = [];
            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][0] = $temp;
        }
        if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']['@attributes']))
        {
            $temp = '';
            $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'];
            $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] = [];
            $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0] = $temp;
        }
        
        foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $APK =>$APV)
        {
            if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo']['@attributes']))
            {
                $temp = '';
                $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'];
                $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'] = [];
                $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'][0] = $temp;
            }
            if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo']['@attributes']))
            {
                $temp = '';
                $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'];
                $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'] = [];
                $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'][0] = $temp;
            }
        }

        foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] as $s=>$value)
        {
            $airlinedetails = Airline::whereVendorCode($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Carrier'])->first();

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['airLineDetais'] =  $airlinedetails;

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['OriginAirportDetails'] = $this->AirportDetails($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Origin']);

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['DestinationAirportDetails'] = $this->AirportDetails($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Destination']);

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['air:FlightDetails']['@attributes']['EquipmentDetails'] = Equipment::where('equipment_code',$response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['air:FlightDetails']['@attributes']['Equipment'])->first();

        }

        $noOfPassengerTypes = count($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']);
        foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'] as $bookingK =>$bookingV )
        {

            $SegmentIndex = array_search($bookingV['@attributes']['SegmentRef'],array_column(array_column($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'],'@attributes'),'Key'));

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bookingK]['@attributes']['segmentDetails'] = $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$SegmentIndex];

            $table =[];
            for ($i=0; $i < $noOfPassengerTypes; $i++) { 
                $fareKey = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:BookingInfo'][$bookingK]['@attributes']['FareInfoRef'];

                $airfareindex = array_search($fareKey,array_column(array_column($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'],'@attributes'),'Key'));

                if(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
                {
                    $passengertype = "ADULT";
                }
                elseif(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
                {
                    $passengertype = "CHILD";
                }
                elseif(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
                {
                    $passengertype = "INFANT";
                }
                // echo $passengertype;
                if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces']))
                {
                    $checkIn = array('type'=>'Pcs','value'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces'],'unit'=>'Pcs');
                }
                elseif(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']))
                {
                    //print_r($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']);
                    $checkIn = array('type'=>'weight','value'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Value'],'unit'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Unit']);
                }
            // echo "<pre>";
                $table[$passengertype]['checkIn'] = $checkIn;
            }

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bookingK]['@attributes']['baggageDetails'] = $table;


            
        }
        $AdultChangePenalty = array();
        $AdultCancelPenalty = array();
        $childrenChangePenalty = array();
        $childrenCancelPenalty = array();
        $infantChangePenalty = array();
        $infantCancelPenalty = array();
        foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $ky=>$pricingInfo)
        {
            if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
            {
                if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
                {
                    $validity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
                    $AdultChangePenalty = array(
                        'type' => 'amount',
                        'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
                        'validity' => $validity
                    );
                }
                elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
                {
                    // print_r(['air:ChangePenalty']);
                    $validity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
                    $AdultChangePenalty = array(
                        'type' => 'percentage',
                        'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
                        'validity' => $validity
                    );
                }
                
                if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
                {
                    $validity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
                    $AdultCancelPenalty = array(
                        'type' => 'amount',
                        'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
                        'validity' => $validity
                    );
                }
                elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
                {
                    $validity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
                    $AdultCancelPenalty = array(
                        'type' => 'percentage',
                        'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
                        'validity' => $validity
                    );
                }
            }
            //if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'CNN')
            if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
            {
                $changevalidity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
                $cancelvalidity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
                if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
                {
                    $childrenChangePenalty = array(
                        'type' => 'amount',
                        'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
                        'validity' => $changevalidity
                    );
                }
                elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
                {
                    $childrenChangePenalty = array(
                        'type' => 'percentage',
                        'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
                        'validity' => $changevalidity
                    );
                }
                
                if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
                {
                    $childrenCancelPenalty = array(
                        'type' => 'amount',
                        'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
                        'validity' => $cancelvalidity
                    );
                }
                elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
                {
                    $childrenCancelPenalty = array(
                        'type' => 'percentage',
                        'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
                        'validity' => $cancelvalidity
                    );
                }
            }
            //if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'INF')
            if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
            {
                $changevalidity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
                $cancelvalidity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
                if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
                {
                    $infantChangePenalty = array(
                        'type' => 'amount',
                        'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
                        'validity' => $changevalidity
                    );
                }
                elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
                {
                    $infantChangePenalty = array(
                        'type' => 'percentage',
                        'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
                        'validity' => $changevalidity
                    );
                }
                
                if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
                {
                    $infantCancelPenalty = array(
                        'type' => 'amount',
                        'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
                        'validity' => $cancelvalidity
                    );
                }
                elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
                {
                    $infantCancelPenalty = array(
                        'type' => 'percentage',
                        'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
                        'validity' => $cancelvalidity
                    );
                }
            }
        }
        $response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty'] = $AdultChangePenalty;
        $response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty'] = $AdultCancelPenalty;
        $response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty'] = $childrenChangePenalty;
        $response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty'] = $childrenCancelPenalty;
        $response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty'] = $infantChangePenalty;
        $response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty'] = $infantCancelPenalty;
        $response['universal:UniversalRecord']['air:AirReservation']['refundable'] = (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable']) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable'] == "true")) ? True : False;
        //Airline Pnrs
        if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes'])){
            $temp= [];
            $temp = $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'];
            $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] = [];
            $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0] = $temp;
        }

        if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) && count($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) > 0)
        {
            foreach($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $supplierkey => $suppliervalue) {
                $airlineName = Airline::where('vendor_code' , $suppliervalue['@attributes']['SupplierCode'])->first();
                $airlineName = $airlineName->short_name ?? '' ;
                $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][$supplierkey]['@attributes']['airline_name'] = $airlineName;
            }
        }

        return $response;


    }


}
