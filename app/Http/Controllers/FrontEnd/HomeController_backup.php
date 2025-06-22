<?php

namespace App\Http\Controllers\FrontEnd;

use PDF;
use DateTime;
use stdClass;
use DateTimeZone;
use App\Models\Role;
use App\Models\User;
use App\Models\Offer;
use App\Models\Popup;
use App\Models\Coupon;
use App\Rules\DOBChek;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Country;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Equipment;
use App\Models\GuestUser;
use App\Models\AirlinesPnr;
use App\Models\Destination;
use App\Models\PendingPnrs;
use App\Models\SeoSettings;
use Illuminate\Support\Str;
use App\Models\FacebookPost;
use App\Models\WalletLogger;
use Illuminate\Http\Request;
use App\Models\AppliedCoupon;
use App\Models\FlightBooking;
use App\Models\WebbedsCountry;
use Illuminate\Support\Carbon;
use App\Models\PopularEventNews;
use App\Models\TboHotelsCountry;
use App\Models\FareRulesCategory;
use App\Models\TravelportRequest;
use App\Models\FlightTicketNumber;
use Illuminate\Support\Facades\DB;
use App\Models\AirportsCountryCity;
use App\Models\FlightBookingSearch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Mtownsend\XmlToArray\XmlToArray;
use Illuminate\Support\Facades\Config;
use App\Models\FlightBookingTravelsInfo;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\Air\SearchController;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Air\BookingController;
use App\Http\Controllers\Air\JazeeraController;

class HomeController extends Controller
{
  
    public function index(Request $request)
    {
        $ip = $request->ip();
        // $data = Location::get($ip);
        // if(!empty( $data))
        // {
        //     if($data->countryCode == 'KW')
        //     {
        //         $currency = "KWD";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "الكويت (KWI)" , "airportCode" => "KWI");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Kuwait (KWI)" , "airportCode" => "KWI");
        //         }
        //     }
        //     elseif($data->countryCode == 'SA')
        //     {
        //         $currency = "SAR";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "الرياض (RUH)" , "airportCode" => "RUH");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Riyadh (RUH)" , "airportCode" => "RUH");
        //         }
        //     }
        //     elseif($data->countryCode == 'AE')
        //     {
        //         $currency = "AED";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "دبي (DXB)" , "airportCode" => "DXB");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Dubai (DXB)" , "airportCode" => "DXB");
        //         }
        //     }
        //     elseif($data->countryCode == 'BH')
        //     {
        //         $currency = "BHD";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "المنامة (BAH)" , "airportCode" => "BAH");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Bahrain (BAH)" , "airportCode" => "BAH");
        //         }
        //     }
        //     elseif($data->countryCode == 'EG')
        //     {
        //         $currency = "EGP";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "القاهرة (CAI)" , "airportCode" => "CAI");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Cairo (CAI)" , "airportCode" => "CAI");
        //         }
        //     }
        //     elseif($data->countryCode == 'IN')
        //     {
        //         $currency = "INR";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "دلهي (DEL)" , "airportCode" => "DEL");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Delhi (DEL)" , "airportCode" => "DEL");
        //         }
        //     }
        //     elseif($data->countryCode == 'QA')
        //     {
        //         $currency = "QAR";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "الدوحة (DOH)" , "airportCode" => "DOH");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Doha (DOH)" , "airportCode" => "DOH");
        //         }
        //     }
        //     elseif(($data->countryCode == 'AT' || $data->countryCode == 'BE' || $data->countryCode == 'HR' || $data->countryCode == 'CY'|| $data->countryCode == 'EE'|| $data->countryCode == 'FI'|| $data->countryCode == 'FR'|| $data->countryCode == 'DE'|| $data->countryCode == 'GR'|| $data->countryCode == 'IE'|| $data->countryCode == 'IT'|| $data->countryCode == 'LV'|| $data->countryCode == 'LT'|| $data->countryCode == 'LU'|| $data->countryCode == 'MT' || $data->countryCode == 'PT'|| $data->countryCode == 'NL'|| $data->countryCode == 'SK'|| $data->countryCode == 'SI'|| $data->countryCode == 'ES'))
        //     {
        //         $currency = "EUR";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "باريس (CDG)" , "airportCode" => "CDG");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Paris (CDG)" , "airportCode" => "CDG");
        //         }
        //     }
        //     elseif($data->countryCode == 'US')
        //     {
        //         $currency = "USD";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "نيويورك (JFK)" , "airportCode" => "JFK");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Doha (JFK)" , "airportCode" => "JFK");
        //         }
        //     }
        //     else{
        //         $currency = "USD";
        //         if(app()->getLocale() == 'ar')
        //         {
        //             $fromDestination = array('text' => "لندن (LHR)" , "airportCode" => "LHR");
        //         }
        //         else{
        //             $fromDestination = array('text' => "Doha (LHR)" , "airportCode" => "LHR");
        //         }
        //     }
        //     session(['currency' => $currency]);
        //     Config::set('app.currency' , $currency);
        // }
        // else{
        //     $currency = 'USD';
        //     if(app()->getLocale() == 'ar')
        //     {
        //         $fromDestination = array('text' => "لندن (LHR)" , "airportCode" => "LHR");
        //     }
        //     else{
        //         $fromDestination = array('text' => "Doha (LHR)" , "airportCode" => "LHR");
        //     }
        //     session(['currency' => $currency]);
        //     Config::set('app.currency' , $currency);

        // }

        /*session clear for jazeera*/
        // session()->forget('airjazeera_token');
        // session()->forget('last_activity_time');
        // session()->forget('currencyConversionData');
        /*End*/

        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'home','status' => 'Active'])->first();
   
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];

        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        // $offers = Offer::select($name.' as name',$description.' as description','image','created_at','valid_upto','id','slug')->get();
        // $packages = Package::select($name.' as name',$description.' as description','image','created_at','id','slug')->whereStatus('Active')->get();

        // $destinations = Destination::select($name.' as name','image','created_at','id','slug')->where('status','Active')->orderBy('order','DESC')->limit(8)->get();

        // $popularEventNews = PopularEventNews::select($name.' as name','image','created_at','id','slug')->where('status','Active')->orderBy('order','DESC')->get();

        // $countries      = TboHotelsCountry::get();

        $countries      = WebbedsCountry::get();

        // $facebookPosts  = FacebookPost::get();

        //popup info
        // $settings = Setting::first();
        $popUp = Popup::first();
        // return view('front_end.index',compact('titles','offers','destinations' , 'popularEventNews' ,'fromDestination', 'packages' ,'countries','facebookPosts' ,'popUp'));

        return view('front_end.index',compact('titles' ,'countries','popUp'));
    }
    
    public function SearchFlights(Request $request)
    {

        //Store Search in data in database
        $search_id = $this->storeSearchData($request);
        
        $validatedData = $request->validate([
            'flightFromAirportCode' => ['required'],
            'flightToAirportCode' => ['required'],
            'DepartDate' => ['required'],
        ], [
            'flightFromAirportCode.required' => "Please select value from dropdown",
            'flightToAirportCode.required' => "Please select value from dropdown",
            'DepartDate.required' => "Please select date"
        ]);
        $uuid = Str::uuid()->toString();
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'flightsListing','status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        $response['air:LowFareSearchRsp'] =[];
        //original
        $AirSearchController = new SearchController();
        $searchResponse = $AirSearchController->Search($request);

        $response = $searchResponse['travelportResponse'];
        //original
        

        //airarabia xml rquest

        $AirSearchController = new SearchController();
        $searchResponseAirarabia = $AirSearchController->airArabiaSearch($request);
        if(!isset($searchResponseAirarabia['error']))
        {
            $response['airarabia'] = $searchResponseAirarabia['travelportResponse'];
        }
        $response['userOrigin'] = $request->input('flightFromAirportCode') ; 
        $response['userDestination'] = $request->input('flightToAirportCode');

        /*jazeera function start*/

        $searchResponseJazeera      = $AirSearchController->prepareSearchBodyForJazeera($request);
        $response['airjazeera']     = isset($searchResponseJazeera['jazeeraResponse']) ? $searchResponseJazeera['jazeeraResponse'] :null;
        //dd( $response['airjazeera']);
        $response['search_request'] = $request->all();
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

        // $response = file_get_contents(public_path('response2.xml'));
        // $converted = XmlToArray::convert($response, $outputRoot = false);
        // $response =[];
        // $response = $converted['SOAP:Body'];
        // //  dd($response);
       
        // // $response = file_get_contents(public_path('response2.xml'));
        // // $converted = XmlToArray::convert($response, $outputRoot = false);
        // // $response =[];
        // // $response['air:LowFareSearchRsp'] = $converted;
    
        // // if($request->input('flight-trip') == 'roundtrip')
        // // {  
        // //    $fileName = 'response2.xml';
        // // }
        // // else{
        // //     $fileName = 'response.xml';
        // // }
        // $air = file_get_contents(public_path('response.xml'));
        // $arabia = XmlToArray::convert($air, $outputRoot = false);
        // //dd($arabia['soap:Body']);
        // // $response =[];
        // $response['airarabia'] = $arabia['soap:Body'];
        // $response['userOrigin'] = $request->input('flightFromAirportCode') ; 
        // $response['userDestination'] = $request->input('flightToAirportCode');
        // //  dd($response['airarabia']);
        // // $response['air:LowFareSearchRsp'] = $converted;
        // // dd($response['air:LowFareSearchRsp']);
        // // $data = $this->roundTripSearch($response);
        //test
      

       
      
    
        // if(!isset($response['air:LowFareSearchRsp']))
        // {
        //     $data['errorresponse'] =$response['SOAP:Fault']['faultstring'];
        //     if($request->input('flight-trip') == 'onewaytrip')
        //     {
        //         return view('front_end.air.one_way',compact('titles','data'));
        //     }
        //     elseif($request->input('flight-trip') == 'roundtrip')
        //     {
        //         return view('front_end.air.round_trip',compact('titles','data'));
        //     }
        // }
       
        $airLine =[];
        $stops =[];
        $minPrice = 0;
        $maxPrice = 0;
        
        
        $currency = 'KWD';
        $response['trace_id'] = $traceId = $searchResponse['travelportRequest']->trace_id ?? '';
        // $traceId = 45; 
        
        if($request->input('flight-trip') == 'roundtrip')
        {
            
            $data = $this->roundTripSearch($response);
            $type = 'roundtrip';
        }
        else{
            $data = $this->oneWaySearch($response);
            $type = 'oneway';
        }
       
        session()->put($uuid, array('flights' => $data['result'] , 'Userrequest' =>  $request->input() ,'type' => $type ,'tarceId'=>$traceId ,'fromCode' => $request->input('flightFromAirportCode') , 'toCode' => $request->input('flightToAirportCode') , 'searchId' => $search_id));      
    

        if($request->input('flight-trip') == 'onewaytrip')
        {
            // dd($data);
            return view('front_end.air.one_way',compact('titles','data','uuid'));
        }
        elseif($request->input('flight-trip') == 'roundtrip')
        {
            return view('front_end.air.round_trip',compact('titles','data','uuid'));
        }
        
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
                //dd($value);
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
                
        
                $bagg = $this->oneBaggaeDetails($response,$value);

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
                        'bagga' => $bagg[0],
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
                            'bagga' => $bagg[$multi],
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
                    //dd($airOption['itinerary']);
                    $depature = $airOption['itinerary'][0]['AirSegment']['DepartureTime'];
                    $arrival = $airOption['itinerary'][count($airOption['itinerary'])-1]['AirSegment']['ArrivalTime'];
                    // $fareDetailskey = $value['air:AirPricingInfo']['airFareInfoRef']['@attributes']['Key'] ;
                    // $fareInfoindex = array_search($fareDetailskey,array_column(array_column($response['air:LowFareSearchRsp']['airFareInfoList']['airFareInfo'],'@attributes'),'Key'));
                    // if($value['air:AirPricingInfo']['@attributes']['TotalPrice'] )

                    //cancelPenalty ChangePenalty
                    $AdultChangePenalty = array();
                    $AdultCancelPenalty = array();
                    $childrenChangePenalty = array();
                    $childrenCancelPenalty = array();
                    $infantChangePenalty = array();
                    $infantCancelPenalty = array();

                    
                    
                    

                    $pricingInfodetails = $value['air:AirPricingInfo'];
                    if(isset($pricingInfodetails['@attributes']))
                    {
                        //only one adult or one child or one infant

                        $onepricing = $pricingInfodetails;
                        $pricingInfodetails = [] ;
                        $pricingInfodetails[0] = $onepricing ;
                    }
                    foreach($pricingInfodetails as $ky=>$pricingInfo)
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

                    // end cancelPenalty ChangePenalty

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

                    //dd($airOption['bagga']);
                    $result[] =  array(
                        'amount' => $mKprice['totalPrice']['value'],
                        'lowfarerequestKey' =>$k,
                        'lowfarerequestoptionKey' =>$AO,
                        'markupPrice' => $mKprice,
                        'layover' => $layover,
                        'traceId' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'],
                        'traceKey' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'] ."-". $k ."-" .$AO,
                        'Origin' => $Origin,
                        'Destination' => $Destination,
                        'baggage' => $airOption['bagga'],
                        'airConnectionsIndex' => $airOption['airConnectionsIndex'],
                        // 'OriginAirportDetails' =>$OriginAirportDetails,
                        // 'DestationAirportDetails' =>$DestationAirportDetails,
                        'OriginAirportDetails' =>$ListingOriginAirPort,
                        'DestationAirportDetails' =>$ListingDestationAirPort,
                        'TotalPrice' => checkExistance($value['@attributes']['TotalPrice']),
                        //'airAirPricePointKey' => $value['air:AirPricingInfo']['@attributes']['Key'],
                        'BasePrice' => $value['@attributes']['BasePrice'],
                        'ApproximateTotalPrice' => $value['@attributes']['ApproximateTotalPrice'],
                        'ApproximateBasePrice' => $value['@attributes']['ApproximateBasePrice'],
                        'EquivalentBasePrice' => isset($value['@attributes']['EquivalentBasePrice'])?$value['@attributes']['EquivalentBasePrice']:'',
                        'Taxes' => $value['@attributes']['Taxes'],
                        'ApproximateTaxes' => $value['@attributes']['ApproximateTaxes'],
                        'CompleteItinerary' => $value['@attributes']['CompleteItinerary'],
                        'Refundable' => $refund,
                        //'airTaxInfo' => $value['air:AirPricingInfo']['air:TaxInfo'],
                        'itinerary' => $airOption['itinerary'],
                        'connections' => $airOption['connections'] ,
                        // 'totalTimeTravel' => $airOption['totaltimeTravel'],
                        'totalTimeTravel' => TimeTravel($airOption['totaltimeTravel']),
                        'airline' => $airlinedetails->name,
                        'IATACODE' => $airlinedetails->vendor_code,
                        // 'depature' => $depature,
                        // 'arrival' => $arrival,
                        'depatureDate' => DateTimeSpliter($depature,"date"),
                        'depatureTime' => DateTimeSpliter($depature,"time"),
                        'arrivalDate' => DateTimeSpliter($arrival,"date"),
                        'arrivalTime' => DateTimeSpliter($arrival,"time"),
                        // 'ChangePenalty' => (isset($value['air:AirPricingInfo']['airChangePenalty']['airAmount'])) ? $value['air:AirPricingInfo']['airChangePenalty']['airAmount'] : $value['air:AirPricingInfo']['airChangePenalty']['airPercentage'],
                        // 'CancelPenalty' => (isset($value['air:AirPricingInfo']['airCancelPenalty']['airAmount'])) ? $value['air:AirPricingInfo']['airCancelPenalty']['airAmount'] : $value['air:AirPricingInfo']['airCancelPenalty']['airPercentage'],
                        // 'faredetailInfo' => (gettype($fareInfoindex)!="boolean")?$response['air:LowFareSearchRsp']['airFareInfoList']['airFareInfo'][$fareInfoindex] : [],
                        'ChangePenalty'=>0,
                        'CancelPenalty'=>0,
                        'AdultChangePenalty'=> $AdultChangePenalty,
                        'AdultCancelPenalty'=> $AdultCancelPenalty,
                        'childrenChangePenalty'=> $childrenChangePenalty,
                        'childrenCancelPenalty'=> $childrenCancelPenalty,
                        'infantChangePenalty'=> $infantChangePenalty,
                        'infantCancelPenalty'=> $infantCancelPenalty,
                        'type' => 'travelport'
                    );
                    
                }
                
            }

        }

        
        //baggage yet to implement

        // $baggage = [];

        // if(isset($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:AABundledServiceExt']))
        // {
        //     $temp =$response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:AABundledServiceExt'];
        //     $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:AABundledServiceExt']=[];
        //     $response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:AABundledServiceExt'][0] = $temp;
        // }
        // foreach ($response['airarabia']['ns1:OTA_AirAvailRS']['ns1:AAAirAvailRSExt']['ns1:PricedItineraries']['ns1:PricedItinerary']['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:AABundledServiceExt'] as $bkey => $bvalue) {
        //     $baggSegments = explode('/',$bvalue['@attributes']);
        //     $baggage[] =array(
        //         'segment' => $baggSegments[0] . " - " .$baggSegments[count($baggSegments)],
        //         'airline' => 'G9',
        //         'flightNumber' => '',
        //         'table' => array(
        //             '' => array('checkIn'=> array(
        //                 'type' => 'weight',
        //                 'value' => '25',
        //                 'unit' => 'Kilograms'
        //             ))
        //         )
        //             );
        // }
        //end of baggage

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
                    $itineraryvalue['cleanArrivalTime'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'time');
                    $itineraryvalue['cleanArrivalDate'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'date');
                    $itineraryvalue['OriginAirportDetails'] = $this->AirportDetails($itineraryvalue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode']);
                    $itineraryvalue['DestationAirportDetails'] = $this->AirportDetails($itineraryvalue['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode']);
                    // dd($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration']);
                    $itineraryvalue['FlightTravelTime'] = TimeTravel($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration'] ,'airarabia');
                    // $itineraryvalue['FlightTravelTime'] = TimeTravel($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration'] ,'airarabia');
                    $itineraryvalue['segmentType'] = 'outbound';
                    // $itineraryvalue['FlightTravelTime'] = segmentTime($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$index]['@attributes']['FlightTime'],'time');
                    $itinerary[] = ['AirSegment' => $itineraryvalue];
                }
                    //    dd($itinerary);

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
                    //$ListingDestationAirPort = $itinerary[$l]['AirSegment']['DestationAirportDetails'];
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
              
                

                
    
                $result[] =  array(
                    'amount' => $mKprice['totalPrice']['value'],
                    // 'lowfarerequestKey' =>$k,
                    // 'lowfarerequestoptionKey' =>$AO,
                    'markupPrice' => $mKprice,
                    'layover' => $layover,
                    // 'traceId' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'],
                    // 'traceKey' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'] ."-". $k ."-" .$AO,
                    // 'Origin' => $Origin,
                    // 'Destination' => $Destination,
                    // 'baggage' => $baggage,
                    // 'airConnectionsIndex' => $airOption['airConnectionsIndex'],
                    // 'OriginAirportDetails' =>$OriginAirportDetails,
                    // 'DestationAirportDetails' =>$DestationAirportDetails,
                    'OriginAirportDetails' =>$this->AirportDetails($aflightsValue['ns1:OriginLocation']['@attributes']['LocationCode']),
                    'DestationAirportDetails' => $this->AirportDetails($aflightsValue['ns1:DestinationLocation']['@attributes']['LocationCode']),
                    // 'TotalPrice' => checkExistance($value['@attributes']['TotalPrice']),
                    //'airAirPricePointKey' => $value['air:AirPricingInfo']['@attributes']['Key'],
                    // 'BasePrice' => $value['@attributes']['BasePrice'],
                    // 'ApproximateTotalPrice' => $value['@attributes']['ApproximateTotalPrice'],
                    // 'ApproximateBasePrice' => $value['@attributes']['ApproximateBasePrice'],
                    // 'EquivalentBasePrice' => isset($value['@attributes']['EquivalentBasePrice'])?$value['@attributes']['EquivalentBasePrice']:'',
                    // 'Taxes' => $value['@attributes']['Taxes'],
                    // 'ApproximateTaxes' => $value['@attributes']['ApproximateTaxes'],
                    // 'CompleteItinerary' => $value['@attributes']['CompleteItinerary'],
                    'Refundable' => false,
                    //'airTaxInfo' => $value['air:AirPricingInfo']['air:TaxInfo'],
                    'itinerary' => $itinerary,
                    'connections' => $connection ,
                    // 'totalTimeTravel' => $airOption['totaltimeTravel'],
                    // 'totalTimeTravel' => LayoverTime($aflightsValue['ns1:DepartureDateTime']['@content'] , $aflightsValue['ns1:ArrivalDateTime']['@content']),
                    'totalTimeTravel' => AirArabiaLayoverTime($aflightsValue['ns1:OriginLocation']['@attributes']['LocationCode'] ,$aflightsValue['ns1:DestinationLocation']['@attributes']['LocationCode'] , $aflightsValue['ns1:DepartureDateTime']['@content'] , $aflightsValue['ns1:ArrivalDateTime']['@content']),

                    'airline' => 'Air Arabia',
                    'IATACODE' => 'G9',
                    'depatureDate' => DateTimeSpliter($aflightsValue['ns1:DepartureDateTime']['@content'],"date"),
                    'depatureTime' => DateTimeSpliter($aflightsValue['ns1:DepartureDateTime']['@content'],"time"),
                    'arrivalDate' => DateTimeSpliter($aflightsValue['ns1:ArrivalDateTime']['@content'],"date"),
                    'arrivalTime' => DateTimeSpliter($aflightsValue['ns1:ArrivalDateTime']['@content'],"time"),
                    // 'ChangePenalty' => (isset($value['air:AirPricingInfo']['airChangePenalty']['airAmount'])) ? $value['air:AirPricingInfo']['airChangePenalty']['airAmount'] : $value['air:AirPricingInfo']['airChangePenalty']['airPercentage'],
                    // 'CancelPenalty' => (isset($value['air:AirPricingInfo']['airCancelPenalty']['airAmount'])) ? $value['air:AirPricingInfo']['airCancelPenalty']['airAmount'] : $value['air:AirPricingInfo']['airCancelPenalty']['airPercentage'],
                    // 'faredetailInfo' => (gettype($fareInfoindex)!="boolean")?$response['air:LowFareSearchRsp']['airFareInfoList']['airFareInfo'][$fareInfoindex] : [],
                    // 'ChangePenalty'=>0,
                    // 'CancelPenalty'=>0,
                    // 'AdultChangePenalty'=> $AdultChangePenalty,
                    // 'AdultCancelPenalty'=> $AdultCancelPenalty,
                    // 'childrenChangePenalty'=> $childrenChangePenalty,
                    // 'childrenCancelPenalty'=> $childrenCancelPenalty,
                    // 'infantChangePenalty'=> $infantChangePenalty,
                    // 'infantCancelPenalty'=> $infantCancelPenalty,
                    'type' => 'airarabia',
                    'transactionIdentifier' => $response['airarabia']['ns1:OTA_AirAvailRS']['@attributes']['TransactionIdentifier']
                );
            }

            usort($result, function($a, $b) {
                return $a['amount'] <=> $b['amount'];
            });
        }

        /*air jazeera one way trip search*/
         if(isset($response['airjazeera']) && empty($response['airjazeera'][0]['dotrezAPI']['dotrezErrors']['errors']) && !empty($response['airjazeera']['availabilityv4']['results']) && !empty($response['airjazeera']['availabilityv4']['faresAvailable'])){
            $data           = $response['airjazeera']['availabilityv4']; 
            $flightClass    = $response['search_request']['flight-class'];
            $originCurrency = $data['currencyCode'];
 
            $journeys           = $data['results'][0]['trips'][0]['journeysAvailableByMarket'][0]['value'];
            $responses          = array(); // Array to store the responses
            $bookingController  = new BookingController();
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
                                    $totalMinutesWithoutLayover += $this->convertFlightTravelTimeToMinutes($flightTravelTime);
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
                            $segmentMinutes  = $this->calcualteMinutes($layoverTime);
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
                        $baggageData = $this->getBaggageForPassenger($response['search_request'], $productClass, $itineraryVal);
                        $itineraryVal['baggage'] = $baggageData;
                        $itineraryVal = array_merge(
                            array_slice($itineraryVal, 0, array_search('segmentType', array_keys($itineraryVal)) + 1, true),
                            ['baggage' => $baggageData],
                            array_slice($itineraryVal, array_search('segmentType', array_keys($itineraryVal)) + 1, null, true)
                        );
                    }

                    $totalTimeWithLayover = $this->convertMinutesToFlightTravelTime($totalMinutesWithLayover);

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
                        'amount'                    => $mKprice['totalPrice']['value'],
                        'markupPrice'               => $mKprice,
                        'layover'                   => $layover,
                        'OriginAirportDetails'      => $this->AirportDetails($journeyDetails['designator']['origin']),
                        'DestationAirportDetails'   => $this->AirportDetails($journeyDetails['designator']['destination']),
                        'Refundable'                => false,
                        'itinerary'                 => $itinerary,
                        'connections'               => $connection ,
                        'totalTimeTravel'           => $totalTimeWithLayover,//LayoverTime($departureDateTime , $arrivalDateTime),
                        'airline'                   => 'Jazeera-Airways',
                        'IATACODE'                  => 'J9',
                        'depatureDate'              => DateTimeSpliter($journeyDetails['designator']['departure'],"date"),
                        'depatureTime'              => DateTimeSpliter($journeyDetails['designator']['departure'],"time"),
                        'arrivalDate'               => DateTimeSpliter($journeyDetails['designator']['arrival'],"date"),
                        'arrivalTime'               => DateTimeSpliter($journeyDetails['designator']['arrival'],"time"),
                        'type'                      => 'airjazeera',
                        'transactionIdentifier'     => null,
                        'journeyKey'                => $journeyDetails['journeyKey'],
                        'numberOfinfant'            => $response['search_request']['noofInfants'] ? $response['search_request']['noofInfants'] : 0,
                        'fareAvailabilityKey'       => $allJourney['fareAvailabilityKey'],
                        'originCurrency'            => $originCurrency,
                    );
                }         
            }
            usort($result, function($a, $b) {
                return $a['amount'] <=> $b['amount'];
            });      
        }
        //end air jazeera

        return array(
            'result' => $result,
            'airLines' => $airLine,
            'stops' => $stops,
            // 'Origin' => $Origin,
            // 'Destination' => $Destination,
            'OriginCityDetails' => $OriginCityDetails,
            'DestationCityDetails' => $DestationCityDetails,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'tarceId' => $traceId
        );
       

    }

    Public function oneBaggaeDetails($response,$airPricingpoint)
    {
        if(isset($airPricingpoint['air:AirPricingInfo']['@attributes']))
        {
            $tmp = $airPricingpoint['air:AirPricingInfo'];
            $airPricingpoint['air:AirPricingInfo'] = [];
            $airPricingpoint['air:AirPricingInfo'][0] = $tmp;
        }

        foreach($airPricingpoint['air:AirPricingInfo'] as $APK => $APV)
        {
            $temp = '';
            if(isset($APV['air:FlightOptionsList']['air:FlightOption']['air:Option']['@attributes']))
            {
                $temp =  $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption']['air:Option'];
                $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption']['air:Option'] = [];
                $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption']['air:Option'][0] = $temp;
            }
            
            foreach($airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption']['air:Option'] as $OK=>$OV)
            {
                $temp = '';

                if(isset($airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption']['air:Option'][$OK]['air:BookingInfo']['@attributes']))
                {
                    $temp = $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption']['air:Option'][$OK]['air:BookingInfo'];
                    $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption']['air:Option'][$OK]['air:BookingInfo'] = [];
                    $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption']['air:Option'][$OK]['air:BookingInfo'][0] = $temp;
                }
            }
        }
        
        $noOfPassengerTypes = count($airPricingpoint['air:AirPricingInfo']);
        foreach ($airPricingpoint['air:AirPricingInfo'][0]['air:FlightOptionsList']['air:FlightOption']['air:Option'] as $Optionskey => $Optionsvalue) {
            $baggageDetails=[];
            foreach ($Optionsvalue['air:BookingInfo'] as $bookingKey => $bookingvalue) 
            {
                $airsegmentindex = array_search($bookingvalue['@attributes']['SegmentRef'],array_column(array_column($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'],'@attributes'),'Key'));
                $table =[];
                for ($i=0; $i < $noOfPassengerTypes; $i++) { 
                    $fareKey = $airPricingpoint['air:AirPricingInfo'][$i]['air:FlightOptionsList']['air:FlightOption']['air:Option'][$Optionskey]['air:BookingInfo'][$bookingKey]['@attributes']['FareInfoRef'];
                    $airfareindex = array_search($fareKey,array_column(array_column($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'],'@attributes'),'Key'));

                    if(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
                    {
                        $passengertype = "ADULT";
                    }
                    elseif(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
                    {
                        $passengertype = "CHILD";
                    }
                    elseif(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
                    {
                        $passengertype = "INFANT";
                    }
                    //echo $passengertype;
                    // dd($response['air:LowFareSearchRsp']['air:BrandList']);
                    $checkIn = array('type'=>null,'value'=> 0 ,'unit' => null);
                    if(isset($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces']))
                    {
                        $checkIn = array('type'=>'Pcs','value'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces'],'unit'=>'Pcs');
                    }
                    elseif(isset($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']))
                    {
                        //print_r($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']);
                        $checkIn = array('type'=>'weight','value'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Value'],'unit'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Unit']);
                    }
                
                    $table[$passengertype]['checkIn'] = $checkIn;
                }
                // exit;
                
                $baggageDetails[] = [
                'segment' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Origin'].' - '.$response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Destination'],
                'airline' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Carrier'],
                'flightNumber' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['FlightNumber'],
                'table' => $table,
                ];
        
                //print_r($bookingvalue);
            }
            $airOptionBaggage[] = $baggageDetails;
        }
        return $airOptionBaggage;
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
                // else
                // {
                //     $options = $value['air:AirPricingInfo'][0]['air:FlightOptionsList']['air:FlightOption']['air:Option'];
                //     $VenderCode = $value['air:AirPricingInfo'][0]['@attributes']['PlatingCarrier'];
                // }

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

                $bagg = $this->roundBaggaeDetails($response,$value,$k);
            
                
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
                            'bagga' => $bagg[$outk+$ink],
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

                    //end  inbounded layover time

                    //cancelPenalty ChangePenalty
                    $AdultChangePenalty = array();
                    $AdultCancelPenalty = array();
                    $childrenChangePenalty = array();
                    $childrenCancelPenalty = array();
                    $infantChangePenalty = array();
                    $infantCancelPenalty = array();
                    
                    

                    $pricingInfodetails = $value['air:AirPricingInfo'];
                    if(isset($pricingInfodetails['@attributes']))
                    {
                        //only one adult or one child or one infant

                        $onepricing = $pricingInfodetails;
                        $pricingInfodetails = [] ;
                        $pricingInfodetails[0] = $onepricing ;
                    }

                    foreach($value['air:AirPricingInfo'] as $pricingInfo)
                    {
                        // //if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'ADT')
                        // if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
                        // {
                        //     if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
                        //     {
                        //         $AdultChangePenalty = array(
                        //             'type' => 'amount',
                        //             'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
                        //             'validity' => $pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        //     elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
                        //     {
                        //         $AdultChangePenalty = array(
                        //             'type' => 'percentage',
                        //             'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
                        //             'validity' => $pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                            
                        //     if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
                        //     {
                        //         $AdultCancelPenalty = array(
                        //             'type' => 'amount',
                        //             'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
                        //             'validity' => $pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        //     elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
                        //     {
                        //         $AdultCancelPenalty = array(
                        //             'type' => 'percentage',
                        //             'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
                        //             'validity' => $pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        // }
                        // // if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'CNN')
                        // if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
                        // {
                        //     if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
                        //     {
                        //         $childrenChangePenalty = array(
                        //             'type' => 'amount',
                        //             'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
                        //             'validity' => $pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        //     elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
                        //     {
                        //         $childrenChangePenalty = array(
                        //             'type' => 'percentage',
                        //             'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
                        //             'validity' => $pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                            
                        //     if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
                        //     {
                        //         $childrenCancelPenalty = array(
                        //             'type' => 'amount',
                        //             'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
                        //             'validity' => $pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        //     elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
                        //     {
                        //         $childrenCancelPenalty = array(
                        //             'type' => 'percentage',
                        //             'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
                        //             'validity' => $pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        // }
                        // // if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'INF')
                        // if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
                        // {
                        //     if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
                        //     {
                        //         $infantChangePenalty = array(
                        //             'type' => 'amount',
                        //             'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
                        //             'validity' => $pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        //     elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
                        //     {
                        //         $infantChangePenalty = array(
                        //             'type' => 'percentage',
                        //             'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
                        //             'validity' => $pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                            
                        //     if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
                        //     {
                        //         $infantCancelPenalty = array(
                        //             'type' => 'amount',
                        //             'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
                        //             'validity' => $pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        //     elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
                        //     {
                        //         $infantCancelPenalty = array(
                        //             'type' => 'percentage',
                        //             'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
                        //             'validity' => $pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']
                        //         );
                        //     }
                        // }
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

                    // end cancelPenalty ChangePenalty

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
                        'amount' => $mKprice['totalPrice']['value'],
                        'lowfarerequestKey' =>$k,
                        'lowfarerequestoptionKey' =>$RO,
                        'outBoundlayover' => $outBoundedlayover,
                        'inBoundlayover' => $inBoundedlayover,
                        'markupPrice' => $mKprice,

                        'baggage' => $airOption['bagga'],
                    
                        // 'outBoundeDepature' => $outBoundeDepature,
                        'outBoundeDepatureTime' => DateTimeSpliter($outBoundeDepature,"time"),
                        'outBoundeDepatureDate' => DateTimeSpliter($outBoundeDepature,"date"),

                        // 'outBoundedArrival' => $outBoundedArrival,
                        'outBoundedArrivalTime' => DateTimeSpliter($outBoundedArrival,"time"),
                        'outBoundedArrivalDate' => DateTimeSpliter($outBoundedArrival,"date"),

                        // 'inBoundeDepature' => $inBoundeDepature,
                        'inBoundeDepatureTime' => DateTimeSpliter($inBoundeDepature,"time"),
                        'inBoundeDepatureDate' => DateTimeSpliter($inBoundeDepature,"date"),

                        // 'inBoundedArrival' => $inBoundedArrival,
                        'inBoundedArrivalTime' => DateTimeSpliter($inBoundedArrival,"time"),
                        'inBoundedArrivalDate' => DateTimeSpliter($inBoundedArrival,"date"),

                        'outboundItinerary' => $airOption['outboundItinerary'],
                        'outboundconnection' => $airOption['outboundconnection'],
                        'inboundItinerary' => $airOption['inboundItinerary'],
                        'inboundconnection' => $airOption['inboundconnection'],

                        // 'outboundtotaltimeTravel' => $airOption['outboundtotaltimeTravel'],
                        // 'inboundtotaltimeTravel' => $airOption['inboundtotaltimeTravel'],
                        'outboundtotaltimeTravel' => TimeTravel($airOption['outboundtotaltimeTravel']),
                        'inboundtotaltimeTravel' => TimeTravel($airOption['inboundtotaltimeTravel']),

                        'airOutConnectionsIndex' => $airOption['airOutConnectionsIndex'],
                        'airInConnectionsIndex' => $airOption['airInConnectionsIndex'],

                        
                        
                        'traceId' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'],
                        'traceKey' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'] ."-". $k ."-" .$RO,
                        'Origin' => $Origin,
                        'Destination' => $Destination,
                        // 'OriginAirportDetails' =>$OriginAirportDetails,
                        // 'DestationAirportDetails' =>$DestationAirportDetails,
                        'outBoundedOriginAirportDetails' =>$outBoundedListingOriginAirPort,
                        'outBoundedDestationAirportDetails' =>$outBoudedListingDestationAirPort,
                        'inBoundedOriginAirportDetails' =>$inBoundedListingOriginAirPort,
                        'inBoundedDestationAirportDetails' =>$inboundedListingDestationAirPort,
                        'TotalPrice' => ($value['@attributes']['TotalPrice']),
                        //'airAirPricePointKey' => $value['air:AirPricingInfo']['@attributes']['Key'],
                        'BasePrice' => $value['@attributes']['BasePrice'],
                        'ApproximateTotalPrice' => $value['@attributes']['ApproximateTotalPrice'],
                        'ApproximateBasePrice' => $value['@attributes']['ApproximateBasePrice'],
                        'EquivalentBasePrice' => isset($value['@attributes']['EquivalentBasePrice'])?$value['@attributes']['EquivalentBasePrice']:'',
                        'Taxes' => $value['@attributes']['Taxes'],
                        'ApproximateTaxes' => $value['@attributes']['ApproximateTaxes'],
                        'CompleteItinerary' => $value['@attributes']['CompleteItinerary'],
                        'Refundable' => $refund,
                        //'airTaxInfo' => $value['air:AirPricingInfo']['air:TaxInfo'],
                        'airline' => $airlinedetails->name,
                        'IATACODE' => $airlinedetails->vendor_code,
                        // 'ChangePenalty' => (isset($value['air:AirPricingInfo']['airChangePenalty']['airAmount'])) ? $value['air:AirPricingInfo']['airChangePenalty']['airAmount'] : $value['air:AirPricingInfo']['airChangePenalty']['airPercentage'],
                        // 'CancelPenalty' => (isset($value['air:AirPricingInfo']['airCancelPenalty']['airAmount'])) ? $value['air:AirPricingInfo']['airCancelPenalty']['airAmount'] : $value['air:AirPricingInfo']['airCancelPenalty']['airPercentage'],
                        // 'faredetailInfo' => (gettype($fareInfoindex)!="boolean")?$response['air:LowFareSearchRsp']['airFareInfoList']['airFareInfo'][$fareInfoindex] : [],
                        'ChangePenalty'=>0,
                        'CancelPenalty'=>0,
                        'AdultChangePenalty'=> $AdultChangePenalty,
                        'AdultCancelPenalty'=> $AdultCancelPenalty,
                        'childrenChangePenalty'=> $childrenChangePenalty,
                        'childrenCancelPenalty'=> $childrenCancelPenalty,
                        'infantChangePenalty'=> $infantChangePenalty,
                        'infantCancelPenalty'=> $infantCancelPenalty,
                        'type' => 'travelport'
                        
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
                    $itineraryvalue['cleanDepartureTime'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'time');
                    $itineraryvalue['cleanDepartureDate'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['DepartureDateTime'],'date');
                    $itineraryvalue['cleanArrivalTime'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'time');
                    $itineraryvalue['cleanArrivalDate'] = DateTimeSpliter($itineraryvalue['ns1:FlightSegment']['@attributes']['ArrivalDateTime'],'date');
                    $itineraryvalue['OriginAirportDetails'] = $this->AirportDetails($itineraryvalue['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode']);
                    $itineraryvalue['DestationAirportDetails'] = $this->AirportDetails($itineraryvalue['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode']);
                    // dd($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration']);
                    $itineraryvalue['FlightTravelTime'] = TimeTravel($itineraryvalue['ns1:FlightSegment']['@attributes']['JourneyDuration'] ,'airarabia');
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
                $inBoundeDepature = $inboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'];
                $inBoundedArrival = $inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime'];

                //end  inbounded layover time

                
                $outboundconnection = count($outboundItinerary);
                $outboundconnection = $outboundconnection - 1;

                $inboundconnection = count($inboundItinerary);
                $inboundconnection = $inboundconnection - 1;

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
                    'amount' => $mKprice['totalPrice']['value'],
                    'lowfarerequestKey' =>$k,
                    'lowfarerequestoptionKey' =>$RO,
                    'outBoundlayover' => $outBoundedlayover,
                    'inBoundlayover' => $inBoundedlayover,
                    'markupPrice' => $mKprice,

                    'baggage' => [],
                   
                    // 'outBoundeDepature' => $outBoundeDepature,
                    'outBoundeDepatureTime' => DateTimeSpliter($outBoundeDepature,"time"),
                    'outBoundeDepatureDate' => DateTimeSpliter($outBoundeDepature,"date"),

                    // 'outBoundedArrival' => $outBoundedArrival,
                    'outBoundedArrivalTime' => DateTimeSpliter($outBoundedArrival,"time"),
                    'outBoundedArrivalDate' => DateTimeSpliter($outBoundedArrival,"date"),

                    // 'inBoundeDepature' => $inBoundeDepature,
                    'inBoundeDepatureTime' => DateTimeSpliter($inBoundeDepature,"time"),
                    'inBoundeDepatureDate' => DateTimeSpliter($inBoundeDepature,"date"),

                    // 'inBoundedArrival' => $inBoundedArrival,
                    'inBoundedArrivalTime' => DateTimeSpliter($inBoundedArrival,"time"),
                    'inBoundedArrivalDate' => DateTimeSpliter($inBoundedArrival,"date"),

                    'outboundItinerary' => $outboundItinerary,
                    'outboundconnection' => $outboundconnection,
                    'inboundItinerary' => $inboundItinerary,
                    'inboundconnection' => $inboundconnection,

                    // 'outboundtotaltimeTravel' => $airOption['outboundtotaltimeTravel'],
                    // 'inboundtotaltimeTravel' => $airOption['inboundtotaltimeTravel'],
                    // 'outboundtotaltimeTravel' => LayoverTime($outboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] , $outboundItinerary[count($outboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),

                    'outboundtotaltimeTravel' => AirArabiaLayoverTime($outboundItinerary[0]['AirSegment']['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode'] ,$outboundItinerary[count($outboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode'] , $outboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] ,$outboundItinerary[count($outboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    
                    
                 
                    // 'inboundtotaltimeTravel' => LayoverTime($inboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] , $inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    'inboundtotaltimeTravel' => AirArabiaLayoverTime($inboundItinerary[0]['AirSegment']['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes']['LocationCode'] ,$inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes']['LocationCode'] , $inboundItinerary[0]['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'] ,$inboundItinerary[count($inboundItinerary)-1]['AirSegment']['ns1:FlightSegment']['@attributes']['ArrivalDateTime']),
                    // 'airOutConnectionsIndex' => $airOption['airOutConnectionsIndex'],
                    // 'airInConnectionsIndex' => $airOption['airInConnectionsIndex'],

                    
                    
                    'traceId' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'],
                    'traceKey' => $response['air:LowFareSearchRsp']['@attributes']['TraceId'] ."-". $k ."-" .$RO,
                    'Origin' => $Origin,
                    'Destination' => $Destination,
                
                    'outBoundedOriginAirportDetails' =>$outBoundedListingOriginAirPort,
                    'outBoundedDestationAirportDetails' =>$outBoudedListingDestationAirPort,
                    'inBoundedOriginAirportDetails' =>$inBoundedListingOriginAirPort,
                    'inBoundedDestationAirportDetails' =>$inboundedListingDestationAirPort,
                    'TotalPrice' => ($value['@attributes']['TotalPrice']),
                    //'airAirPricePointKey' => $value['air:AirPricingInfo']['@attributes']['Key'],
                    // 'BasePrice' => $value['@attributes']['BasePrice'],
                    // 'ApproximateTotalPrice' => $value['@attributes']['ApproximateTotalPrice'],
                    // 'ApproximateBasePrice' => $value['@attributes']['ApproximateBasePrice'],
                    // 'EquivalentBasePrice' => isset($value['@attributes']['EquivalentBasePrice'])?$value['@attributes']['EquivalentBasePrice']:'',
                    // 'Taxes' => $value['@attributes']['Taxes'],
                    // 'ApproximateTaxes' => $value['@attributes']['ApproximateTaxes'],
                    'CompleteItinerary' => $value['@attributes']['CompleteItinerary'],
                    'Refundable' => false,
                    //'airTaxInfo' => $value['air:AirPricingInfo']['air:TaxInfo'],
                    'airline' => 'Air Arabia',
                    'IATACODE' => 'G9',
                    'type' => 'airarabia',
                  
                    
                    'transactionIdentifier' => $response['airarabia']['ns1:OTA_AirAvailRS']['@attributes']['TransactionIdentifier']
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
            $bookingController          = new BookingController();
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
                        $totalMinutesWithoutLayoverOutbound += $this->convertFlightTravelTimeToMinutes($flightTravelTime);
                        /*end new*/

                        $outboundItinerary[] = [
                            'AirSegment' => [
                                'segment'                   => $segment,
                                'Carrier'                   => $segment['identifier']['carrierCode'],
                                'airline'                   => "Jazeera-Airways",
                                'FlightNumber'              => $segment['identifier']['identifier'],
                                'cleanDepartureTime'        => DateTimeSpliter($segment['designator']['departure'], 'time'),
                                'cleanDepartureDate'        => DateTimeSpliter($segment['designator']['departure'], 'date'),
                                'cleanArrivalTime'          => DateTimeSpliter($segment['designator']['arrival'], 'time'),
                                'cleanArrivalDate'          => DateTimeSpliter($segment['designator']['arrival'], 'date'),
                                'OriginAirportDetails'      => $this->AirportDetails($segment['designator']['origin']),
                                'DestationAirportDetails'   => $this->AirportDetails($segment['designator']['destination']),
                                'FlightTravelTime'          => $flightTravelTime,
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
                        $totalMinutesWithoutLayoverInbound += $this->convertFlightTravelTimeToMinutes($flightTravelTime);
                        /*end new*/


                        $inboundItinerary[] = [
                            'AirSegment' => [
                                'segment'                   => $segment,
                                'Carrier'                   => $segment['identifier']['carrierCode'],
                                'airline'                   => "Jazeera-Airways",
                                'FlightNumber'              => $segment['identifier']['identifier'],
                                'cleanDepartureTime'        => DateTimeSpliter($segment['designator']['departure'], 'time'),
                                'cleanDepartureDate'        => DateTimeSpliter($segment['designator']['departure'], 'date'),
                                'cleanArrivalTime'          => DateTimeSpliter($segment['designator']['arrival'], 'time'),
                                'cleanArrivalDate'          => DateTimeSpliter($segment['designator']['arrival'], 'date'),
                                'OriginAirportDetails'      => $this->AirportDetails($segment['designator']['origin']),
                                'DestationAirportDetails'   => $this->AirportDetails($segment['designator']['destination']),
                                'FlightTravelTime'          => $flightTravelTime,
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
                            $segmentMinutes  = $this->calcualteMinutes($layoverTime);
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
                        $baggageData                = $this->getBaggageForPassenger($response['search_request'], $outBoundProductClass, $outitineryValu);
                        $outitineryValu['baggage']  = $baggageData;
                        $outboundItinerary[$l] = array_merge(
                            array_slice($outboundItinerary[$l], 0, array_search('segmentType', array_keys($outboundItinerary[$l])) + 1, true),
                            ['baggage' => $baggageData],
                            array_slice($outboundItinerary[$l], array_search('segmentType', array_keys($outboundItinerary[$l])) + 1, null, true)
                        );
                        $outBoudedListingDestationAirPort = $outboundItinerary[$l]['AirSegment']['DestationAirportDetails'];
                    }
                    $outboundTotalTimeTravel = $this->convertMinutesToFlightTravelTime($totalMinutesWithLayoverOutbound);
                     
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
                            $segmentMinutes  = $this->calcualteMinutes($layoverTime);
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
                        $baggageData                = $this->getBaggageForPassenger($response['search_request'], $inBoundProductClass, $initineryValue);
                        $initineryValue['baggage']  = $baggageData;
                        $inboundItinerary[$l] = array_merge(
                            array_slice($inboundItinerary[$l], 0, array_search('segmentType', array_keys($inboundItinerary[$l])) + 1, true),
                            ['baggage' => $baggageData],
                            array_slice($inboundItinerary[$l], array_search('segmentType', array_keys($inboundItinerary[$l])) + 1, null, true)
                        );
                        $inboundedListingDestationAirPort = $inboundItinerary[$l]['AirSegment']['DestationAirportDetails'];
                    }
                    $inboundTotalTimeTravel = $this->convertMinutesToFlightTravelTime($totalMinutesWithLayoverInbound);

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
                        'amount'                            =>  $mKprice['totalPrice']['value'],
                        'outBoundlayover'                   =>  $outBoundedlayover,
                        'inBoundlayover'                    =>  $inBoundedlayover,
                        'markupPrice'                       =>  $mKprice,
                        'outBoundeDepatureTime'             =>  $outBoundeDepatureTime,
                        'outBoundeDepatureDate'             =>  $outBoundeDepatureDate,
                        'outBoundedArrivalTime'             =>  $outBoundedArrivalTime,
                        'outBoundedArrivalDate'             =>  $outBoundedArrivalDate,
                        'inBoundeDepatureTime'              =>  $inBoundeDepatureTime,
                        'inBoundeDepatureDate'              =>  $inBoundeDepatureDate,
                        'inBoundedArrivalTime'              =>  $inBoundedArrivalTime,
                        'inBoundedArrivalDate'              =>  $inBoundedArrivalDate,
                        'outboundItinerary'                 =>  $outboundItinerary,
                        'outboundconnection'                =>  $outboundconnection,
                        'inboundItinerary'                  =>  $inboundItinerary,
                        'inboundconnection'                 =>  $inboundconnection,
                        'outboundtotaltimeTravel'           =>  $outboundTotalTimeTravel,
                        'inboundtotaltimeTravel'            =>  $inboundTotalTimeTravel,
                        'Origin'                            =>  $Origin,
                        'Destination'                       =>  $Destination,
                        'outBoundedOriginAirportDetails'    =>  $outBoundedListingOriginAirPort,
                        'outBoundedDestationAirportDetails' =>  $outBoudedListingDestationAirPort,
                        'inBoundedOriginAirportDetails'     =>  $inBoundedListingOriginAirPort,
                        'inBoundedDestationAirportDetails'  =>  $inboundedListingDestationAirPort,
                        'CompleteItinerary'                 =>  null,
                        'Refundable'                        =>  false,
                        'airline'                           =>  'Jazeera-Airways',
                        'IATACODE'                          =>  'J9',
                        'type'                              =>  'airjazeera',
                        'transactionIdentifier'             =>  null,
                        'numberOfinfant'                    =>  $response['search_request']['noofInfants'] ? $response['search_request']['noofInfants'] : 0,
                        'outBoundJourneyKey'                =>  $outbound['value']['journeyKey'],
                        'outBoundFareKey'                   =>  $outbound['fareDetails']['fareAvailabilityKey'],
                        'inBoundJourneyKey'                 =>  $inbound['value']['journeyKey'],
                        'inBoundFareKey'                    =>  $inbound['fareDetails']['fareAvailabilityKey'],
                        'originCurrency'                    =>  $originCurrency,

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

    Public function roundBaggaeDetails($response,$airPricingpoint,$k)
    {
        // echo $k;
        
        if(isset($airPricingpoint['air:AirPricingInfo']['@attributes']))
        {
            $tmp = $airPricingpoint['air:AirPricingInfo'];
            $airPricingpoint['air:AirPricingInfo'] = [];
            $airPricingpoint['air:AirPricingInfo'][0] = $tmp;
        }
       

        foreach($airPricingpoint['air:AirPricingInfo'] as $APK => $APV)
        {

            //converting air:option to multi dimension array if only one exist
            if(isset($airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option']['@attributes']))
            {
              
                $outboundedsingleoption = $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option'];
                $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option'] = [];
                $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option'][0] = $outboundedsingleoption;
            }
            if(isset($airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option']['@attributes']))
            {
                $inboundsingleoption = $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option'];
                $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option'] = [];
                $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option'][0] = $inboundsingleoption;
            }
           
            //converting air:BookingInfo to multi dimension array if only one exist
            foreach($airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option']  as $oo=>$oItinarary)
            {
                if(isset($oItinarary['air:BookingInfo']['@attributes']))
                {
                    $singleItinarary = $oItinarary['air:BookingInfo'];
                    $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option'][$oo]['air:BookingInfo'] = [];
                    $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option'][$oo]['air:BookingInfo'][0] = $singleItinarary;

                }
            }
            foreach($airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option']  as $io=>$IItinarary)
            {
                if(isset($IItinarary['air:BookingInfo']['@attributes']))
                {
                    $singleItinarary = $IItinarary['air:BookingInfo'];
                    $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option'][$io]['air:BookingInfo'] = [];
                    $airPricingpoint['air:AirPricingInfo'][$APK]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option'][$io]['air:BookingInfo'][0] = $singleItinarary;

                }
            }

            //dd($airPricingpoint);
        }
        
        $noOfPassengerTypes = count($airPricingpoint['air:AirPricingInfo']);
        //OutBound
        //echo "<pre>";
        foreach ($airPricingpoint['air:AirPricingInfo'][0]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option'] as $OutBoundOptionskey => $OutBoundOptionsvalue) {
          
            $OutBoundbaggageDetails =[];
            foreach ($OutBoundOptionsvalue['air:BookingInfo'] as $bookingKey => $bookingvalue) 
            {
                $airsegmentindex = array_search($bookingvalue['@attributes']['SegmentRef'],array_column(array_column($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'],'@attributes'),'Key'));
                $table =[];
                //dd($airPricingpoint['air:AirPricingInfo']);
                for ($i=0; $i < $noOfPassengerTypes; $i++) { 
                    // $fareKey = $airPricingpoint['air:AirPricingInfo'][$i]['air:FlightOptionsList']['air:FlightOption']['air:Option'][$Optionskey]['air:BookingInfo'][$bookingKey]['@attributes']['FareInfoRef'];

                    $fareKey = $airPricingpoint['air:AirPricingInfo'][$i]['air:FlightOptionsList']['air:FlightOption'][0]['air:Option'][$OutBoundOptionskey]['air:BookingInfo'][$bookingKey]['@attributes']['FareInfoRef'];

                    $airfareindex = array_search($fareKey,array_column(array_column($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'],'@attributes'),'Key'));

                    if(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
                    {
                        $passengertype = "ADULT";
                    }
                    elseif(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
                    {
                        $passengertype = "CHILD";
                    }
                    elseif(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
                    {
                        $passengertype = "INFANT";
                    }
                    //echo $passengertype;
                    if(isset($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces']))
                    {
                        $checkIn = array('type'=>'Pcs','value'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces'],'unit'=>'Pcs');
                    }
                    elseif(isset($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']))
                    {
                        //print_r($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']);
                        $checkIn = array('type'=>'weight','value'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Value'],'unit'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Unit']);
                    }
                
                    $table[$passengertype]['checkIn'] = $checkIn;
                }
                
                
                $OutBoundbaggageDetails[] = [
                'segment' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Origin'].' - '.$response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Destination'],
                'airline' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Carrier'],
                'flightNumber' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['FlightNumber'],
                'table' => $table,
                ];
            }
           // print_r($OutBoundbaggageDetails);

            //Inbound
            foreach ($airPricingpoint['air:AirPricingInfo'][0]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option'] as $InBoundOptionskey => $InBoundOptionsvalue) {
                $InBoundbaggageDetails = [];
                foreach ($InBoundOptionsvalue['air:BookingInfo'] as $bookingKey => $bookingvalue) 
                {
                    $airsegmentindex = array_search($bookingvalue['@attributes']['SegmentRef'],array_column(array_column($response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'],'@attributes'),'Key'));


                    $table =[];
                    for ($i=0; $i < $noOfPassengerTypes; $i++) { 
                        // $fareKey = $airPricingpoint['air:AirPricingInfo'][$i]['air:FlightOptionsList']['air:FlightOption']['air:Option'][$Optionskey]['air:BookingInfo'][$bookingKey]['@attributes']['FareInfoRef'];

                        $fareKey = $airPricingpoint['air:AirPricingInfo'][$i]['air:FlightOptionsList']['air:FlightOption'][1]['air:Option'][$InBoundOptionskey]['air:BookingInfo'][$bookingKey]['@attributes']['FareInfoRef'];

                        $airfareindex = array_search($fareKey,array_column(array_column($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'],'@attributes'),'Key'));

                        if(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
                        {
                            $passengertype = "ADULT";
                        }
                        elseif(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
                        {
                            $passengertype = "CHILD";
                        }
                        elseif(((isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($airPricingpoint['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
                        {
                            $passengertype = "INFANT";
                        }
                        //echo $passengertype;
                        if(isset($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces']))
                        {
                            $checkIn = array('type'=>'Pcs','value'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces'],'unit'=>'Pcs');
                        }
                        elseif(isset($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']))
                        {
                            //print_r($response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']);
                            $checkIn = array('type'=>'weight','value'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Value'],'unit'=>$response['air:LowFareSearchRsp']['air:FareInfoList']['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Unit']);
                        }
                    
                        $table[$passengertype]['checkIn'] = $checkIn;
                    }


                    $InBoundbaggageDetails[] = [
                        'segment' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Origin'].' - '.$response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Destination'],
                        'airline' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['Carrier'],
                        'flightNumber' => $response['air:LowFareSearchRsp']['air:AirSegmentList']['air:AirSegment'][$airsegmentindex]['@attributes']['FlightNumber'],
                        'table' => $table,
                        ];

                }
                //dd($InBoundbaggageDetails);
                // $baggageDetails =[
                //     'OutBound' => $OutBoundbaggageDetails,
                //     'InBound' => $InBoundbaggageDetails
                // ];
                $airOptionBaggage[] = array_merge($OutBoundbaggageDetails,$InBoundbaggageDetails);
            }
            
            
            
           
        }
        //dd($airOptionBaggage);
       
        return $airOptionBaggage;
    }

    // public function AjaxAirportList(Request $request)
    // {
    //     $search = $request->input('q');
    //     $search = explode(" ",$search)[0];
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
    //         $selectquery = `'airports.airport_code',DB::raw('CONCAT(cities.name," (",airports.airport_code,")") as display_name'),'airports.name','countries.name as country_name','cities.name as city_name'`;
    //         $displayName = 'CONCAT(cities.name," (",airports.airport_code,")") as display_name';
    //         $airportName = 'airports.name';
    //         $countryName = 'countries.name as country_name';
    //         $cityName = 'cities.name as city_name';
    //         $lang = "en";
    //     }
        
       
    //     // DB::enableQueryLog();
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
        
    //     return $airports;

    // }

    public function AjaxAirportList(Request $request)
    {
        $search = $request->input('q');
        //$search = explode(" ",$search)[0];
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
            $airortsList = $airortsList->get();
            return $airortsList;

        }
        else{
            return [];
        }

        
    }


    /*public function AjaxAirportList(Request $request)
    {
        $search = $request->input('q');
        $search = explode(" ",$search)[0];
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
            $airortsList = $airortsList->get();
            return $airortsList;


        }
        else{
            return [];
        } 
    }*/

    public function contactUs()
    {
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'contactUs','status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        return view('front_end.contact_us',compact('titles'));
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
    public function somethingWentWrong()
    {
        $titles = [
            'title' => "Something went wrong",
        ];
        return view('front_end.error',compact('titles'));
    }

    //booking confirmation

    public function BookingConfirmation($serachUUID,$searchKey)
    {
        $sessiondata = session()->get($serachUUID);
        if(empty($sessiondata) || !is_numeric((int)base64_decode($searchKey)))
        {
            //error
            return redirect()->route('home');
        }
        $Completeflights = $sessiondata['flights'];
        $UserRequest = $sessiondata['Userrequest'];
        $tarceId = $sessiondata['tarceId'];
        $fromCode = $sessiondata['fromCode'];
        $toCode = $sessiondata['toCode'];
        $searchId = $sessiondata['searchId'];

        $searchKey = base64_decode($searchKey);
        $AirBooking = new BookingController();
        $flights = $Completeflights[$searchKey];
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'flightsDetails','status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        if($flights['type'] == 'travelport')
        {
            $rsp = $this->TravelportAirPricing($flights,$UserRequest,$tarceId);
        }
        elseif($flights['type'] == 'airarabia'){
            $rsp = $this->AirArabiaAirPricing($flights,$UserRequest,$tarceId);
        }elseif($flights['type'] == 'airjazeera'){
            $rsp = $this->AirJazeeraAirPricing($flights,$UserRequest,$tarceId);
        }
        else
        {
            $rsp = [
                'IsSuccess' => false ,
                'errorresponse' => 'something went wrong',
            ];
            //error page
    
        }

        if(!$rsp['IsSuccess'])
        {
            $data['errorresponse'] = $rsp['errorresponse'];
            return view('front_end.air.flight_booking_confirmation_details',compact('titles','data','UserRequest'));
        }
        else{
            $uuid = Str::uuid()->toString();
            
            
            if(app()->getLocale() == 'ar')
            {
                $name = 'IFNULL(name_ar,name) as name' ;
            }
            else{
                $name = 'name' ;
            }
            $countries = Country::select('id',DB::raw($name),'phone_code')->whereNotNull("phone_code")->get();
            session()->put($uuid, array('type' => $sessiondata['type'] , 'airPricingdata' => $rsp['completeData'] , 'tarceId' => $tarceId ,'fromCode' => $fromCode , 'toCode' => $toCode , 'searchUUID' => $serachUUID, 'searchKey' => $searchKey ,'UserRequest' => $UserRequest ,'searchId' => $searchId));
            $currentDate = Carbon::now()->toDateString();
            $couponCodes = Coupon::where("status" , '1')->whereDate('coupon_valid_from', '<=', $currentDate)->whereDate('coupon_valid_to', '>=', $currentDate)->whereIn('coupon_valid_on' ,[2,3])->get();
           
            $result = $rsp['completeData'];
            
            return view('front_end.air.flight_booking_confirmation_details',compact('titles','result','UserRequest','uuid','countries','couponCodes'));

        }
    }

   // public function Book(Request $request)
    public function preview(Request $request)
    {
        // dd($request->input());
        $validatedData = $request->validate([
            'email' => ['required','email'],
            'country_id' => ['required'],
            'mobile' => ['required'],
            'adultTitle.*' => ['required'],
            'adultFirstName.*' => ['required'],
            'adultLastName.*' => ['required'],
            'adultDOB.*' => ['required',new DOBChek('ADT')],
            'adultPassportNumber.*' => ['required'],
            'adultPassportIssueCountry.*' => ['required'],
            'adultPassportExpireDate.*' => ['required'],
            'childrenTitle.*' => ['required'],
            'childrenFirstName.*' => ['required'],
            'childrenLastName.*' => ['required'],
            'childrenDOB.*' => ['required',new DOBChek('CNN')],
            'childrenPassportNumber.*' => ['required'],
            'childrenPassportIssueCountry.*' => ['required'],
            'childrenPassportExpireDate.*' => ['required'],
            'infantsTitle.*' => ['required'],
            'infantsFirstName.*' => ['required'],
            'infantsLastName.*' => ['required'],
            'infantsDOB.*' => ['required',new DOBChek('INF')],
            'infantsPassportNumber.*' => ['required'],
            'infantsPassportIssueCountry.*' => ['required'],
            'infantsPassportExpireDate.*' => ['required'],
        ]
        ,[
            'adultTitle.*.required' => 'Please select Title',
            'adultFirstName.*.required' => 'Please enter first name',
            'adultLastName.*.required' => 'Please enter last name',
            'adultDOB.*.required' => 'Please select date of birth',
            'adultPassportNumber.*.required' => 'Please enter passport number',
            'adultPassportIssueCountry.*.required' => 'Please select passport issued country',
            'adultPassportExpireDate.*.required' => 'Please select passport expire date',

            'childrenTitle.*.required' => 'Please select Title',
            'childrenFirstName.*.required' => 'Please enter first name',
            'childrenLastName.*.required' => 'Please enter last name',
            'childrenDOB.*.required' => 'Please select date of birth',
            'childrenPassportNumber.*.required' => 'Please enter passport number',
            'childrenPassportIssueCountry.*.required' => 'Please select passport issued country',
            'childrenPassportExpireDate.*.required' => 'Please select passport expire date',

            'infantsTitle.*.required' => 'Please select Title',
            'infantsFirstName.*.required' => 'Please enter first name',
            'infantsLastName.*.required' => 'Please enter last name',
            'infantsDOB.*.required' => 'Please select date of birth',
            'infantsPassportNumber.*.required' => 'Please enter passport number',
            'infantsPassportIssueCountry.*.required' => 'Please select passport issued country',
            'infantsPassportExpireDate.*.required' => 'Please select passport expire date',
        ]);

        //data from booking comformation page (details)
        $sessiondata = session()->get($request->input('UUID'));

        //getting data form search session 
        $serachSession = session()->get($sessiondata['searchUUID']);
        $searchKey = $sessiondata['searchKey'];

        if(empty($sessiondata))
        {
            //error
            return redirect()->route('home');
        }
        $Completeflights = $serachSession['flights'];
        $UserRequest = $sessiondata['UserRequest'];
        $tarceId = $sessiondata['tarceId'];
        $fromCode = $sessiondata['fromCode'];
        $toCode = $sessiondata['toCode'];
        $type = $sessiondata['type'];
        $searchId = $sessiondata['searchId'];
        $passengers = isset($sessiondata['airPricingdata']['passengers']) ? $sessiondata['airPricingdata']['passengers'] : null;

        $AirBooking = new BookingController();
        $flights = $Completeflights[$searchKey];

        $titles = ['title' => "Flight Confirmation Preview"];

        $couponCode = null ;
        if($request->has('applyed_coupon_code') && !empty($request->input('applyed_coupon_code'))){
            $couponCode = $request->input('applyed_coupon_code') ;   
        }

        if($flights['type'] == 'travelport')
        {
            $rsp = $this->TravelportAirPricing($flights,$UserRequest,$tarceId,$extraInfo =['type_of_payment' => $request->input('type_of_payment') ,'couponCode' => $couponCode]);
        }
        elseif($flights['type'] == 'airarabia'){
            $rsp = $this->AirArabiaAirPricing($flights,$UserRequest,$tarceId,$extraInfo =['type_of_payment' => $request->input('type_of_payment'),'page_type' => 'preview','travelersInfo' => $request ,'couponCode' => $couponCode]);
        }elseif($flights['type'] == 'airjazeera'){
            $rsp = $this->AirJazeeraAirPricing($flights,$UserRequest,$tarceId,$extraInfo =['type_of_payment' => $request->input('type_of_payment'),'page_type' => 'preview','travelersInfo' => $request, 'passengers'=>$passengers,'couponCode' => $couponCode]);
        }
        else
        {
            $rsp = [
                'IsSuccess' => false ,
                'errorresponse' => 'something went wrong',
            ];
            //error page
        }

        if(!$rsp['IsSuccess'])
        {
            $data['errorresponse'] = $rsp['errorresponse'];
            // return view('front_end.air.flight_booking_confirmation_details',compact('titles','data','UserRequest'));
            return view('front_end.air.confirmation_preview',compact('titles', 'data','UserRequest'));
        }
        else{

            $previewUuid = Str::uuid()->toString();
            session()->put($previewUuid, array('type' => $type , 'airPricingdata' => $rsp['completeData'] , 'tarceId' => $tarceId ,'fromCode' => $fromCode , 'toCode' => $toCode ,));


            $FlightBooking = new FlightBooking();
            $FlightBooking->booking_type = $type;
            $FlightBooking->preview_travelport_request_id = $rsp['xml_request_id'];
            
            if(Auth::guard('web')->check())
            {
                $FlightBooking->user_id = Auth::guard('web')->id();
                $FlightBooking->user_type = 'web';
                if(Auth::guard('web')->user()->email == "dubai@24flights.com")
                {
                    $FlightBooking->internal_booking = '1';
                }
            }
            else
            {
                $FlightBooking->user_type = 'web_guest';
                $GuestUser = new GuestUser();
                $GuestUser->mobile = $request->input('mobile');
                $GuestUser->country_id = $request->input('country_id');
                $GuestUser->email = $request->input('email');
                $GuestUser->user_type = 'web';
                $GuestUser->save();
            }
            $FlightBooking->mobile = $request->input('mobile');
            $FlightBooking->country_id = $request->input('country_id');
            $FlightBooking->email = $request->input('email');
            $FlightBooking->session_uuid = $previewUuid;

      
            $FlightBooking->currency_code = $rsp['completeData']['markupPrice']['FatoorahPaymentAmount']['currency_code'];
            $FlightBooking->total_amount = $rsp['completeData']['markupPrice']['FatoorahPaymentAmount']['value'];
            $FlightBooking->basefare = $rsp['completeData']['markupPrice']['basefare']['value'];
            $FlightBooking->service_charges = $rsp['completeData']['markupPrice']['service_chargers']['value'];
            $FlightBooking->tax = $rsp['completeData']['markupPrice']['tax']['value'];
            $FlightBooking->sub_total = $rsp['completeData']['markupPrice']['FatoorahPaymentAmount']['value'];
            if(!empty($rsp['completeData']['markupPrice']['coupon']['value']) && $rsp['completeData']['markupPrice']['coupon']['value']!= '0.000'){
                $FlightBooking->coupon_id = $rsp['completeData']['markupPrice']['coupon']['id'];
                $FlightBooking->coupon_amount = $rsp['completeData']['markupPrice']['standed_coupon']['value'];
            }

            $FlightBooking->actual_amount = $rsp['completeData']['markupPrice']['actual_amount']['value'];

            $FlightBooking->type_of_payment = $request->input('type_of_payment');
            $FlightBooking->supplier_type = $flights['type'];


            $FlightBooking->booking_status = 'booking_initiated';
            $FlightBooking->save();

            $FlightBooking->booking_ref_id = 'MT'.str_pad($FlightBooking->id, 7, '0', STR_PAD_LEFT);
            $FlightBooking->from = $fromCode;
            $FlightBooking->to = $toCode;
            $FlightBooking->search_id = $searchId;
            $FlightBooking->carrier = $rsp['completeData']['airSegments'][0]['Carrier'] ?? null;
            $FlightBooking->carrier_name = $rsp['completeData']['airSegments'][0]['AirLine'] ?? null;
            
            $FlightBooking->save();

            if(isset($request['adultFirstName']))
            {
                foreach($request['adultFirstName'] as $AF=>$AV)
                {
                    if($request['adultTitle'][$AF] == "Mr")
                    {
                        $gender = 'M';
                    }elseif($request['adultTitle'][$AF] == "Ms")
                    {
                        $gender = 'F';
                    }elseif($request['adultTitle'][$AF] == "Master")
                    {
                        $gender = 'M';
                    }elseif($request['adultTitle'][$AF] == "Miss")
                    {
                        $gender = 'F';
                    }
                    else{
                        $gender = 'F';
                    }
                    $FlightBookingTravelers = new FlightBookingTravelsInfo();
                    $FlightBookingTravelers->title = $request['adultTitle'][$AF];
                    $FlightBookingTravelers->first_name = $request['adultFirstName'][$AF];
                    $FlightBookingTravelers->last_name = $request['adultLastName'][$AF];
                    $FlightBookingTravelers->date_of_birth = $request['adultDOB'][$AF];
                    $FlightBookingTravelers->passport_number = $request['adultPassportNumber'][$AF];
                    $FlightBookingTravelers->passport_issued_country_id = $request['adultPassportIssueCountry'][$AF];
                    $FlightBookingTravelers->passport_expire_date = $request['adultPassportExpireDate'][$AF];
                    $FlightBookingTravelers->traveler_type = 'ADT';
                    $FlightBookingTravelers->flight_booking_id = $FlightBooking->id;
                    //$FlightBookingTravelers->traveler_ref_id = $tarceId."ADT".($AF+1);
                    if($flights['type'] == 'travelport')
                    {
                        $FlightBookingTravelers->traveler_ref_id = $tarceId."ADT".($AF+1);
                    }
                    elseif($flights['type'] == 'airarabia'){
                        $FlightBookingTravelers->traveler_ref_id = "A".($AF+1);
                        // if(isset($request['adultdepatureextrabaggage'][$AF]) && $request['adultdepatureextrabaggage'][$AF] != 'No Bag')
                        // {
                        //     $FlightBookingTravelers->depature_extra_baggage = $request['adultdepatureextrabaggage'][$AF];
                        // }
                        // if(isset($request['adultreturnextrabaggage'][$AF]) && $request['adultreturnextrabaggage'][$AF] != 'No Bag')
                        // {
                        //     $FlightBookingTravelers->return_extra_baggage = $request['adultreturnextrabaggage'][$AF];
                        // }
                    }
                    $FlightBookingTravelers->gender = $gender;

                    $FlightBookingTravelers->save();
                }
            }
            if(isset($request['infantsFirstName']))
            {
                foreach($request['infantsFirstName'] as $IF=>$AV)
                {
                    if($request['infantsTitle'][$IF] == "Mr")
                    {
                        $gender = 'M';
                    }elseif($request['infantsTitle'][$IF] == "Ms")
                    {
                        $gender = 'F';
                    }elseif($request['infantsTitle'][$IF] == "Master")
                    {
                        $gender = 'M';
                    }elseif($request['infantsTitle'][$IF] == "Miss")
                    {
                        $gender = 'F';
                    }
                    else{
                        $gender = 'F';
                    }
                    $FlightBookingTravelers = new FlightBookingTravelsInfo();
                    $FlightBookingTravelers->title = $request['infantsTitle'][$IF];
                    $FlightBookingTravelers->first_name = $request['infantsFirstName'][$IF];
                    $FlightBookingTravelers->last_name = $request['infantsLastName'][$IF];
                    $FlightBookingTravelers->date_of_birth = $request['infantsDOB'][$IF];
                    $FlightBookingTravelers->passport_number = $request['infantsPassportNumber'][$IF];
                    $FlightBookingTravelers->passport_issued_country_id = $request['infantsPassportIssueCountry'][$IF];
                    $FlightBookingTravelers->traveler_type = 'INF';
                    $FlightBookingTravelers->passport_expire_date = $request['infantsPassportExpireDate'][$IF];
                    $FlightBookingTravelers->flight_booking_id = $FlightBooking->id;
                    // $FlightBookingTravelers->traveler_ref_id = $tarceId."INF".($IF+1);
                    if($flights['type'] == 'travelport')
                    {
                        $FlightBookingTravelers->traveler_ref_id = $tarceId."INF".($IF+1);
                    }
                    elseif($flights['type'] == 'airarabia'){
                        //count
                        $AdtCount = count($request['adultFirstName']) ?? 0;
                        
                        $childCount = count($request['childrenFirstName']) ?? 0;
                        $tot = $AdtCount+$childCount+($IF+1);
                        $FlightBookingTravelers->traveler_ref_id = "I".($tot)."/A".($IF+1);
                    }
                    $FlightBookingTravelers->gender = $gender;
                    $FlightBookingTravelers->save();
                }
            }
            
            if(isset($request['childrenFirstName']))
            {
                foreach($request['childrenFirstName'] as $CF=>$AV)
                {
                    if($request['childrenTitle'][$CF] == "Mr")
                    {
                        $gender = 'M';
                    }elseif($request['childrenTitle'][$CF] == "Ms")
                    {
                        $gender = 'F';
                    }elseif($request['childrenTitle'][$CF] == "Master")
                    {
                        $gender = 'M';
                    }elseif($request['childrenTitle'][$CF] == "Miss")
                    {
                        $gender = 'F';
                    }
                    else{
                        $gender = 'F';
                    }
                    $FlightBookingTravelers = new FlightBookingTravelsInfo();
                    $FlightBookingTravelers->title = $request['childrenTitle'][$CF];
                    $FlightBookingTravelers->first_name = $request['childrenFirstName'][$CF];
                    $FlightBookingTravelers->last_name = $request['childrenLastName'][$CF];
                    $FlightBookingTravelers->date_of_birth = $request['childrenDOB'][$CF];
                    $FlightBookingTravelers->passport_number = $request['childrenPassportNumber'][$CF];
                    $FlightBookingTravelers->passport_issued_country_id = $request['childrenPassportIssueCountry'][$CF];
                    $FlightBookingTravelers->passport_expire_date = $request['childrenPassportExpireDate'][$CF];
                    $FlightBookingTravelers->traveler_type = 'CNN';
                    $FlightBookingTravelers->flight_booking_id = $FlightBooking->id;
                    // $FlightBookingTravelers->traveler_ref_id = $tarceId."CNN".($CF+1);
                    if($flights['type'] == 'travelport')
                    {
                        $FlightBookingTravelers->traveler_ref_id =  $tarceId."CNN".($CF+1);
                    }
                    elseif($flights['type'] == 'airarabia'){
                        //count
                        $AdtCount = count($request['adultFirstName']) ?? 0;
                   
                        $tot = $AdtCount+($CF+1);
                        $FlightBookingTravelers->traveler_ref_id = "C".($tot);
                    }
                    $FlightBookingTravelers->gender = $gender;
                    // if(isset($request['childrendepatureextrabaggage'][$CF]) && $request['childrendepatureextrabaggage'][$CF] != 'No Bag')
                    // {
                    //     $FlightBookingTravelers->depature_extra_baggage = $request['childrendepatureextrabaggage'][$CF];
                    // }
                    // if(isset($request['childrenreturnextrabaggage'][$CF]) && $request['childrenreturnextrabaggage'][$CF] != 'No Bag')
                    // {
                    //     $FlightBookingTravelers->return_extra_baggage = $request['childrenreturnextrabaggage'][$CF];
                    // }
                    $FlightBookingTravelers->save();
                }
            }

            if($flights['type'] == 'airarabia')
            {
                if(isset($request['Depaturebaggage']))
                {
                    $dadult = 1;
                
                    foreach ($request['Depaturebaggage'] as $key => $value) {
                        for ($dg=0; $dg < (int)$value; $dg++) { 
                            if($UserRequest['noofAdults'] >= $dadult)
                            {
                                $TravelerRefNumberRPHList = 'A'.($dadult);
                                $dadult++;
                            }
                            else{
                                //after completion of adult statring child count
                                $TravelerRefNumberRPHList = 'C'.($dadult);
                                $dadult++;
                            }
                            $flightTravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id",$FlightBooking->id)->where("traveler_ref_id",$TravelerRefNumberRPHList)->first();
                            $flightTravelerInfo->depature_extra_baggage = $key;
                            $flightTravelerInfo->save();
                            
                        }
                    }
                }
                if(isset($request['Returnbaggage']))
                {
                    $radult = 1;
                
                    foreach ($request['Returnbaggage'] as $key => $value) {
                        for ($dg=0; $dg < (int)$value; $dg++) { 
                            if($UserRequest['noofAdults'] >= $radult)
                            {
                                $TravelerRefNumberRPHList = 'A'.($radult);
                                $radult++;
                            }
                            else{
                                  //after completion of adult statring child count
                                  $TravelerRefNumberRPHList = 'C'.($radult);
                                  $radult++;
                            }
                            $flightTravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id",$FlightBooking->id)->where("traveler_ref_id",$TravelerRefNumberRPHList)->first();
                            $flightTravelerInfo->return_extra_baggage = $key;
                            $flightTravelerInfo->save();
                        }
                    }
                }
            }

            //preview

            $bookingId = $FlightBooking->id;
            $titles = [
                'title' => "Flight Confirmation Preview",
            ];
            $bookingDetails = FlightBooking::with('Customercountry')->find($bookingId);
            $passengersInfo = FlightBookingTravelsInfo::with('passportIssuedCountry')->whereFlightBookingId($bookingId)->get();

            $result = $rsp['completeData'];
            return view('front_end.air.confirmation_preview',compact('titles','result','bookingDetails', 'passengersInfo'));
        }
       
    }
    //for preview another function with out resubmitting data
    /*public function preview($flightbookingId)
    {
        $flightbookingId = decrypt($flightbookingId);

        $bookingDetails = FlightBooking::with('Customercountry')->find($flightbookingId);



        //data from booking comformation page (details)
        $sessiondata = session()->get($bookingDetails->session_uuid);

        //getting data form search session 
        $serachSession = session()->get($sessiondata['searchUUID']);
        $searchKey = $sessiondata['searchKey'];

        if(empty($sessiondata))
        {
            //error
            return redirect()->route('home');
        }

        $titles = ['title' => "Flight Confirmation Preview"];

        $Completeflights = $serachSession['flights'];
        $UserRequest = $sessiondata['UserRequest'];
        $tarceId = $sessiondata['tarceId'];
        $fromCode = $sessiondata['fromCode'];
        $toCode = $sessiondata['toCode'];
        $type = $sessiondata['type'];


        $flights = $Completeflights[$searchKey];

        if($flights['type'] == 'travelport')
        {
            $rsp = $this->TravelportAirPricing($flights,$UserRequest,$tarceId,$extraInfo =['type_of_payment' => $bookingDetails->type_of_payment]);
        }
        elseif($flights['type'] == 'airarabia'){
            $rsp = $this->AirArabiaAirPricing($flights,$UserRequest,$tarceId,$extraInfo =['type_of_payment' => $bookingDetails->type_of_payment]);
        }
        else
        {
            $rsp = [
                'IsSuccess' => false ,
                'errorresponse' => 'something went wrong',
            ];
            //error page
        }

        $passengersInfo = FlightBookingTravelsInfo::with('passportIssuedCountry')->whereFlightBookingId($flightbookingId)->get();

        $result = $rsp['completeData'];
        return view('front_end.air.confirmation_preview',compact('titles','result','bookingDetails', 'passengersInfo'));

    }
    */



    public function bookflight($flightbookingId)
    {
        $flightbookingId = decrypt($flightbookingId);
        $paymentId = request('paymentId');
        $flightbookingdetails  = FlightBooking::find($flightbookingId);
      
       
        if($flightbookingdetails->booking_status == 'payment_initiated' || $flightbookingdetails->internal_booking == 1 || $flightbookingdetails->type_of_payment == 'wallet')
        {
            $myfatoorah = new MyFatoorahController();
            if($flightbookingdetails->internal_booking == 1)
            {
                $invoicedata['IsSuccess'] = true;
                $invoicedata['Data'] = new stdClass();
                $invoicedata['Data']->InvoiceStatus = "Paid";
            }elseif($flightbookingdetails->type_of_payment == 'wallet'){
                if(auth()->user()->wallet_balance >= $flightbookingdetails->sub_total){
                    //debit from wallet
                    $wallet = auth()->user()->wallet_balance - $flightbookingdetails->sub_total;
                    $user = User::find(auth()->user()->id);
                    $user->wallet_balance = $wallet;
                    $user->save();
                    $walletDetails = WalletLogger::create([
                        'user_id' => auth()->user()->id,
                        'reference_id' => $flightbookingdetails->id,
                        'reference_type' => 'flight',
                        'amount' => $flightbookingdetails->sub_total,
                        'remaining_amount' => $wallet,
                        'amount_description' => 'KWD '.$flightbookingdetails->sub_total .' debit for booking id '.$flightbookingdetails->booking_ref_id,
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
            }
            else{
                $invoicedata = $myfatoorah->callback($paymentId);
            }
            
            if($invoicedata['IsSuccess'] )
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
                    if($flightbookingdetails->internal_booking == 1){
                        $flightbookingdetails->payment_gateway = 'AGENCY';   
                    }elseif($flightbookingdetails->type_of_payment == 'wallet'){
                        $flightbookingdetails->payment_gateway = 'WALLET';  
                        $flightbookingdetails->invoice_id = $walletUniqueId ?? null;
                    }
                    else{
                        $flightbookingdetails->payment_gateway = $invoicedata['Data']->focusTransaction->PaymentGateway;
                    }
                }
                elseif($invoicedata['Data']->InvoiceStatus == 'Expired'){
                    $flightbookingdetails->booking_status = 'payment_exipre';
                }
                elseif($invoicedata['Data']->InvoiceStatus == 'Failed')
                {
                    $flightbookingdetails->booking_status = 'payment_failure';
                }elseif($invoicedata['Data']->InvoiceStatus == 'Insufficient funds in wallet'){
                    $flightbookingdetails->booking_status = 'payment_failure';
                }
                $flightbookingdetails->save();
    
                if($invoicedata['Data']->InvoiceStatus == 'Paid')
                {
    
                    $Airpricinguuid = $flightbookingdetails->session_uuid;
                    $AirPricingData = session()->get($Airpricinguuid);
                    $AirPricing = $AirPricingData['airPricingdata'];
                    $tarceId = $AirPricingData['tarceId'];
                    $tarvelersInfo = FlightBookingTravelsInfo::with('passportIssuedCountry')->where('flight_booking_id',$flightbookingId)->get();
                    $AirBooking = new BookingController();

                    
                    
                    if(!empty($flightbookingdetails->coupon_id)){
                        $couponDetails = Coupon::find($flightbookingdetails->coupon_id);
                        $AppliedCoupon = new AppliedCoupon();
                        $AppliedCoupon->coupon_id = $flightbookingdetails->coupon_id;
                        $AppliedCoupon->user_id = $flightbookingdetails->user_id;
                        $AppliedCoupon->coupon_code = $couponDetails->coupon_code;
                        $AppliedCoupon->coupon_applied_on = Carbon::now()->toDateString();
                        $AppliedCoupon->save();
                    }
                    if($AirPricing['type'] == 'travelport')
                    {
                        //flight ticket booking integration in travelport
                    
                        $airCreateReservationResponse = $AirBooking->AirCreateReservation($AirPricing,$tarvelersInfo,$flightbookingdetails,$tarceId);
                        $totalData['response'] = $airCreateReservationResponse['travelportResponse'];
                        $travelportRequest = $airCreateReservationResponse['travelportRequest'];
                        $travelpoertReuestId = $travelportRequest->id;
                        if(!isset($totalData['response']['universal:AirCreateReservationRsp']))
                        {
                            $data['errorresponse'] =$totalData['response']['SOAP:Fault']['faultstring'];
                            //travelport request error response
                            //refund should initate
                            //redirect to error page
                    
                            return view('front_end.error',compact('titles','data'));
                        }
                    
                        $response = $totalData['response']['universal:AirCreateReservationRsp'];
                        if(isset($response['air:AirSolutionChangedInfo']))
                        {
                            if(isset($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode']) && ($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode'] == "Schedule"))
                            {
                                $error =  "Air Segments have re-Schedule ,If amount debited from your bank it will be credited back";
                            }
                            $this->refund($flightbookingdetails->id);
                            
                            return view('front_end.air.booking_flight_itinerary',compact('titles','error','flightbookingdetails'));
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
                                // $airlinesPnr->airline_pnr = $value['@attributes']['SupplierCode'];
                                // $airlinesPnr->code = $value['@attributes']['SupplierLocatorCode'];
                    
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
                        
                        if(!isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']))
                        {
                            if(isset($response['ResponseMessage']))
                            {
                                // if(isset($response['ResponseMessage']['@attributes']))
                                // {
                                //     $temp ="";
                                //     $temp = $response['ResponseMessage'];
                                //     $response['ResponseMessage'] = [];
                                //     $response['ResponseMessage'][0] = $temp;
                                // }
                                // $error ="";
                                // foreach($response['ResponseMessage'] as $responseMessage)
                                // {
                                //     $error .=  $responseMessage['@attributes'];
                                // }
                            }
                            // if(isset($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode']) && ($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode'] == "Schedule"))
                            // {
                                $error =  "something went wrong,If amount debited from your account it will be credited back";
                            //}
                            
                            $this->refund($flightbookingdetails->id);
                            
                            return view('front_end.air.booking_flight_itinerary',compact('titles','error','flightbookingdetails'));
                        }
                    
                        $response = $this->airCreationAndURRetrieveFromate($response);
      
                    
                        $bookingController = new BookingController();
                        $onlineTicketingDetails = $bookingController->OnlineTicketing($response , $tarceId);
                        $onlineTicketingresp['response'] = $onlineTicketingDetails['travelportResponse'];
                        $onlineTicketing = $onlineTicketingresp['response']['air:AirTicketingRsp'];
                        $ticketrequestdetails = $onlineTicketingDetails['travelportRequest'];
                        $flightbookingdetails->ticket_travelport_request_id = $ticketrequestdetails->id;

                        $flightbookingdetails->save();
                    
                     
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
                                    $data['errorresponse'] ="Ticket failure";
                                    return view('front_end.error',compact('titles','data'));
                                }else{
                                    //again performing Ticketing operation
                                    $response = $URRetrieveResponse['universal:UniversalRecordRetrieveRsp'];
                    
                                    //storingUpdatedValues 
                                    //$flightbookingdetails->travelport_request_id = $URRetrieveRquestId;
                                    $flightbookingdetails->galileo_pnr = $response['universal:UniversalRecord']['universal:ProviderReservationInfo']['@attributes']['LocatorCode'];
                                    $flightbookingdetails->reservation_pnr = $response['universal:UniversalRecord']['air:AirReservation']['@attributes']['LocatorCode'];
                                    $flightbookingdetails->reservation_travelport_request_id = $URRetrieveRquestId;
                                    $flightbookingdetails->save();
                    
                                    $response = $this->airCreationAndURRetrieveFromate($response);
                    
                                    $onlineTicketingDetails = $bookingController->OnlineTicketing($response , $tarceId);
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
                                $this->refund($flightbookingdetails->id);
                    
                                //mail should be triggred
                                $FlightBookingPassengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($flightbookingdetails->id)->get();
                                Mail::send('front_end.email_templates.pending-ticket',compact('flightbookingdetails','user','FlightBookingPassengersInfo'), function($message) use($flightbookingdetails) {
                                    $message->to($flightbookingdetails->email)
                                            ->subject('flightTicketPending');
                                });
                                return view('front_end.error',compact('titles','data'));
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
                        
                        $result['segments'] = $segments;
                        $result['flightBookingDetails'] = $flightbookingdetails;
                        if(!isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']))
                        {
                            if(isset($onlineTicketing['air:ETR'])){
                                foreach($onlineTicketing['air:ETR'] as $onlineTicketingDetails){
                                    if(isset($onlineTicketingDetails['common_v52_0:SupplierLocator'])){
                                        //checking in AirTicking section for Airline pnr
                                        if(isset($onlineTicketingDetails['common_v52_0:SupplierLocator']['@attributes'])){
                                            $temp = [] ;
                                            $temp = $onlineTicketingDetails['common_v52_0:SupplierLocator'];
                                            $onlineTicketingDetails['common_v52_0:SupplierLocator'] = [];
                                            $onlineTicketingDetails['common_v52_0:SupplierLocator'][0] = $temp;
                                        }
        
                                        if(isset($onlineTicketingDetails['common_v52_0:SupplierLocator']) && count($onlineTicketingDetails['common_v52_0:SupplierLocator']) > 0)
                                        {
                                            foreach ($onlineTicketingDetails['common_v52_0:SupplierLocator'] as $key => $value) {
                                                //checking Airline Pnr already exist are not 
                                                $pnrExistance = AirlinesPnr::where([
                                                    'airline_pnr' => $value['@attributes']['SupplierLocatorCode'], 
                                                    'code' => $value['@attributes']['SupplierCode'], 
                                                    'booking_id' => $flightbookingdetails->id
                                                ])->count();
                                                
                                                if ($pnrExistance == 0){
                                                    $airlinesPnr = new AirlinesPnr();
                                                    $airlinesPnr->booking_id = $flightbookingdetails->id;
                                                    $AirlinesDetails = Airline::whereVendorCode($value['@attributes']['SupplierCode'])->first();
                                                    $airlinesPnr->name = $AirlinesDetails['name'] ?? '';
                                                    $airlinesPnr->code = $value['@attributes']['SupplierCode'];
                                                    $airlinesPnr->airline_pnr = $value['@attributes']['SupplierLocatorCode'];
                                                    $airlinesPnr->save();
                                                    $airlinePnr[] = array('pnr' => $value['@attributes']['SupplierLocatorCode'] , 'airline' => $AirlinesDetails['name']);
                                                }
                                            }
                                        }
        
                                        //deleting pendingPnrs 
                                        PendingPnrs::where([
                                            'booking_id' => $flightbookingdetails->id
                                        ])->delete();
                                    }
                                }
                            }else{
                                //pnr not generated
                                //Some airline hosting systems are unable to process all the requests at the same time, hence the vendor locator is not assigned (in some cases) straight away to the PNR.
                        
                                // As per TVP recommendations, an agent should wait up to 2 hours for the vendor locator until reporting it as an issue.
                                $airlinePnr[0] = array('pnr' => '---' , 'airline' => '---');

                            }
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
                    elseif($AirPricing['type'] == 'airarabia'){
                        $airCreateReservationResponse = $AirBooking->AirAribiaBooking($AirPricing,$tarvelersInfo,$flightbookingdetails,$tarceId);
                        $response = $airCreateReservationResponse['travelportResponse'];
                        $travelportRequest = $airCreateReservationResponse['travelportRequest'];
                        $travelpoertReuestId = $travelportRequest->id;

                        if(isset($response['ns1:OTA_AirBookRS']['ns1:Errors']['ns1:Error']))
                        {
                            //AirArabia request error response
                            //refund should initate
                            //redirect to error page
                            
                            $data['errorresponse'] = $response['ns1:OTA_AirBookRS']['ns1:Errors']['ns1:Error']['@attributes']['ShortText'];
                            $this->refund($flightbookingdetails->id);
                           
                            return view('front_end.error',compact('titles','data'));
                        }

                     
                       
                
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
                        
                            return view('front_end.error',compact('titles','data'));
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
                            'Refundable' => false,
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
                        // if(isset($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:SpecialReqDetails']['ns1:BaggageRequests']['ns1:BaggageRequest']))
                        // {
                        //     $temp = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:SpecialReqDetails']['ns1:BaggageRequests'];
                        //     $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:SpecialReqDetails']['ns1:BaggageRequests'] = [];
                        //     $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:SpecialReqDetails']['ns1:BaggageRequests'][0] = $temp;
                        // }
                        // foreach($response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:SpecialReqDetails']['ns1:BaggageRequests'] as $srk =>$srv){
                        //     $explode1 =explode("|" , $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:SpecialReqDetails']['ns1:BaggageRequests'][$srk]['@attributes']['TravelerRefNumberRPHList']);
                        //     $explode2 = explode("$",$explode1[1]);
                        //     $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:SpecialReqDetails']['ns1:BaggageRequests'][$srk]['@attributes']['uniqueidentyfier'] = $response['ns1:OTA_AirBookRS']['ns1:AirReservation']['ns1:TravelerInfo']['ns1:SpecialReqDetails']['ns1:BaggageRequests'][$srk]['@attributes']['FlightNumber']."|".$explode2[0];
                        // }
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
                            $TravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id);
                            if(!empty($travelerInfo['ns1:PersonName']['ns1:NameTitle'])){
                                $TravelerInfo = $TravelerInfo->where("title",$travelerInfo['ns1:PersonName']['ns1:NameTitle']);
                            }
                        
                            $TravelerInfo = $TravelerInfo->where("first_name",$travelerInfo['ns1:PersonName']['ns1:GivenName'])
                            ->where("last_name",$travelerInfo['ns1:PersonName']['ns1:Surname'])->first();
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
                        // if($flightbookingdetails->user_type != 'web_guest')
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
                    elseif($AirPricing['type'] == 'airjazeera'){
                        $airCreateReservationResponse = $AirBooking->airJazeeraBookingCommit($AirPricing,$tarvelersInfo,$flightbookingdetails,$tarceId);
                        $response                     = $airCreateReservationResponse['jazeeraResponse']['data'];
                        
                        $travelportRequest      = $airCreateReservationResponse['jazeeraRequest'];
                        $travelpoertReuestId    = $travelportRequest['trace_id'];
                        $booking                = $response['booking'];
                        //dd( $booking );
                        if (!isset($booking) || !isset($booking['bookingKey'])) {
                            $data['errorresponse'] = "Unable to retrieve current booking session details"; 
                            return view('front_end.error', compact('titles', 'data'));
                        }

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

                        // if($flightbookingdetails->user_type != 'web_guest')
                        // {
                        //     $userdetails    = User::find($flightbookingdetails->user_id);
                        //     $user           = $userdetails->first_name.' '.$userdetails->last_name;
                        // }
                        // else{
                        //     $user = 'Customer';
                        // }
                        $user = $tarvelersInfo[0]->first_name .' '.$tarvelersInfo[0]->last_name;
                        $result['user'] = $user;
                        if($booking['info']['status'] == "Failed"|| $booking['info']['status'] == "Hold" || $booking['info']['status'] == "Default"){

                            $this->refund($flightbookingdetails->id);

                            $data['errorresponse'] ="Ticket failure";
                            //mail should be triggred
                            $FlightBookingPassengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($flightbookingdetails->id)->get();
                            Mail::send('front_end.email_templates.pending-ticket',compact('flightbookingdetails','user','FlightBookingPassengersInfo'), function($message) use($flightbookingdetails) {
                                $message->to($flightbookingdetails->email)
                                        ->subject('flightTicketPending');
                            });
                        
                            return view('front_end.error',compact('titles','data'));
                        }
                        //dd($booking);
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
                                        'Refundable'                =>  false,
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
                                        $baggage        = $this->getProductClassInfo($flightClass,$passangerType);
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
                                            $baggage        = $this->getProductClassInfo($flightClass,$passangerType);
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
                    $extrabaggageinfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where(function ($query) {
                        $query->where('depature_extra_baggage', '!=', '')
                              ->orWhere('return_extra_baggage', '!=', '');
                    })->get();
    
                    $result['extrabaggageinfo'] = $extrabaggageinfo;
                    //  return view('front_end.air.booking_flight_itinerary',compact('titles','result'));

                    if(env('APP_ENV') != 'local')
                    {
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
                    }else{
                        $completePath = null;
                        $flightbookingdetails->flight_ticket_path = $completePath;
                        $flightbookingdetails->save();
                    }

                    $this->invoice($result,$user,$flightbookingdetails);
    
                    return view('front_end.air.booking_flight_itinerary',compact('titles','result'));
    
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
                //
                $titles = ['title' => "Flight Booked itinerary"];
                if($flightbookingdetails->type_of_payment == 'wallet'){
                    $data['errorresponse'] = "Insufficient funds in wallet";           
                }else{
                    $data['errorresponse'] = "Something went wrong";   
                }
                return view('front_end.error',compact('titles','data'));
            }

        }
        else{
            //second time page reloaded 
            //error
            return redirect()->route('some-thing-went-wrong');
        }
    }

    public function Signup(Request $request)
    {
        $seoData = SeoSettings::where(['page_type' => 'static' , 'static_page_name' => 'signUp','status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
        ];
        return view('front_end.auth.signup',compact('titles'));
    }

    public function CreateFrontEndUser(Request $request)
    {
        $this->validate($request,[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            //'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
         ]);
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
           // 'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'user_type' => 'web'
        ]);
        $role = Role::where("slug","user")->first();
        $user->assignRole($role->id);
        if($user)
        {
            return redirect()->route('login')->with('message', 'Your Account have been created');
        }
    }

    public function invoice($result,$user,$flightbookingdetails)
    {
        $invoiceId = $flightbookingdetails->internal_booking == 1 ? $flightbookingdetails->booking_ref_id :$flightbookingdetails->invoice_id;
        $filename = "Invoice_".$invoiceId.".pdf";
        $completePath = null;
        if(env('APP_ENV') != 'local'){
            $pdf = PDF::loadView('front_end.air.invoice', compact('result'));
            $completePath = 'pdf/invoice/' . $filename;
            $flightbookingdetails->invoice_path = $completePath;
            $flightbookingdetails->save();
            $pdf->save('pdf/invoice/' . $filename);

            return Mail::send('front_end.air.invoice', compact('result','flightbookingdetails'), function($message)use($pdf,$flightbookingdetails,$filename) {
                $message->to($flightbookingdetails->email)
                        ->subject('Invoice')
                        ->attachData($pdf->output(), $filename);
            });
        }else{
            return 1;
        }
    }

    public function pnr(Request $request)
    {
        $pnr = $request->input('pnr');
       
        $flightbookingdetails = FlightBooking::select('flight_bookings.*')->LeftJoin('airlines_pnrs' , 'airlines_pnrs.booking_id' ,'=' , 'flight_bookings.id')->where('ticket_status', 1)->where(function($query) use($pnr)
        {
            $query->where('booking_ref_id' ,  $pnr)
            ->orWhere('airline_pnr' , $pnr);
        })->first();

        if(empty($flightbookingdetails))
        {
            //error
            return   response()->json([
                "status" => "400",
                "message" => "Booking Reference / PNR No not found",
                "html" => []
             ], 400);
        }
        elseif($flightbookingdetails->is_cancel == 1)
        {
            //error
            return   response()->json([
                "status" => "400",
                "message" => "Ticket Cancled",
                "html" => []
             ], 400);
        }
        else{
            $travelportrequest = TravelportRequest::where('id' , $flightbookingdetails->travel_request_id)->first();
            if ($flightbookingdetails->supplier_type !== 'airjazeera') {
                $responseArray = XmlToArray::convert($travelportrequest->response_xml, $outputRoot = false);
            }
           
         
        }

        $titles = [
            'title' => "Flight Booked itinerary",
        ];

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
                        //print_r($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']);
                        $checkIn = array('type'=>'weight','value'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Value'],'unit'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Unit']);
                    }
                // echo "<pre>";
                    $table[$passengertype]['checkIn'] = $checkIn;
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
                    $airlineName = $airlineName->short_name ?? '' ;
                    $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][$supplierkey]['@attributes']['airline_name'] = $airlineName;
                }
            }
            
           


            // $AdultChangePenalty = array();
            // $AdultCancelPenalty = array();
            // $childrenChangePenalty = array();
            // $childrenCancelPenalty = array();
            // $infantChangePenalty = array();
            // $infantCancelPenalty = array();
            // foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $ky=>$pricingInfo)
            // {
            //     if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
            //     {
            //         if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
            //         {
            //             $validity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
            //             $AdultChangePenalty = array(
            //                 'type' => 'amount',
            //                 'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
            //                 'validity' => $validity
            //             );
            //         }
            //         elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
            //         {
            //             // print_r(['air:ChangePenalty']);
            //             $validity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
            //             $AdultChangePenalty = array(
            //                 'type' => 'percentage',
            //                 'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
            //                 'validity' => $validity
            //             );
            //         }
                    
            //         if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
            //         {
            //             $validity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
            //             $AdultCancelPenalty = array(
            //                 'type' => 'amount',
            //                 'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
            //                 'validity' => $validity
            //             );
            //         }
            //         elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
            //         {
            //             $validity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
            //             $AdultCancelPenalty = array(
            //                 'type' => 'percentage',
            //                 'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
            //                 'validity' => $validity
            //             );
            //         }
            //     }
            //     //if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'CNN')
            //     if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
            //     {
            //         $changevalidity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
            //         $cancelvalidity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
            //         if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
            //         {
            //             $childrenChangePenalty = array(
            //                 'type' => 'amount',
            //                 'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
            //                 'validity' => $changevalidity
            //             );
            //         }
            //         elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
            //         {
            //             $childrenChangePenalty = array(
            //                 'type' => 'percentage',
            //                 'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
            //                 'validity' => $changevalidity
            //             );
            //         }
                    
            //         if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
            //         {
            //             $childrenCancelPenalty = array(
            //                 'type' => 'amount',
            //                 'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
            //                 'validity' => $cancelvalidity
            //             );
            //         }
            //         elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
            //         {
            //             $childrenCancelPenalty = array(
            //                 'type' => 'percentage',
            //                 'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
            //                 'validity' => $cancelvalidity
            //             );
            //         }
            //     }
            //     //if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'INF')
            //     if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
            //     {
            //         $changevalidity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
            //         $cancelvalidity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
            //         if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
            //         {
            //             $infantChangePenalty = array(
            //                 'type' => 'amount',
            //                 'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
            //                 'validity' => $changevalidity
            //             );
            //         }
            //         elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
            //         {
            //             $infantChangePenalty = array(
            //                 'type' => 'percentage',
            //                 'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
            //                 'validity' => $changevalidity
            //             );
            //         }
                    
            //         if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
            //         {
            //             $infantCancelPenalty = array(
            //                 'type' => 'amount',
            //                 'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
            //                 'validity' => $cancelvalidity
            //             );
            //         }
            //         elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
            //         {
            //             $infantCancelPenalty = array(
            //                 'type' => 'percentage',
            //                 'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
            //                 'validity' => $cancelvalidity
            //             );
            //         }
            //     }
            // }

            // $response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty'] = $AdultChangePenalty;
            // $response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty'] = $AdultCancelPenalty;
            // $response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty'] = $childrenChangePenalty;
            // $response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty'] = $childrenCancelPenalty;
            // $response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty'] = $infantChangePenalty;
            // $response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty'] = $infantCancelPenalty;

            $response['universal:UniversalRecord']['air:AirReservation']['refundable'] = (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable']) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable'] == "true")) ? True : False;

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
                    'FlightNumber' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['FlightNumber'],
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
            // dd($result);

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
                    'Refundable' => false,
                    'FlightName' => $rspSegValue['ns1:FlightSegment']['@attributes']['FlightNumber'],
                    'Class' => (isset($rspSegValue['ns1:FlightSegment']['@attributes']['ResCabinClass']) ? ($rspSegValue['ns1:FlightSegment']['@attributes']['ResCabinClass'] == 'Y' ? "Economy" : "Business" ) : ""),
                    'CheckIn' => 'Include a generous 10 KG Hand Baggage',
                    'Layover' => '',
                    'passengersList' => $passengersList
                );
                }
                if($flightbookingdetails->booking_type == 'roundtrip')
                {
                    //no change for oneway
                   
                    // $totalItenaryCount = count($segments);
  
                    // $itinerary =[];
                    // $nextAirportCode = "";
                    // $dateandTime = 0;
                    // dd($segments);

                    //in airarabia itinary are not in order making it in order
                    // for($i = 0; $i<$totalItenaryCount ; $i++)
                    // {
                    //     if($i == 0)
                    //     {
                    //         foreach($segments as $segmentkey => $segmentvalue)
                    //         {
                    //             if($segmentvalue['OriginAirportDetails']->airport_code == $flightbookingdetails->from)
                    //             {
                    //                 echo "first".$segmentkey;
                    //                 $itinerary[$i] = $segments[$segmentkey];
                    //                 $nextAirportCode = $segmentvalue['DestinationAirportDetails']->airport_code;
                    //                 $dateandTime = strtotime($segmentvalue['DepartureDate']." ".$segmentvalue['DepartureTime']);
                    //                 break;
                    //             } 
                    //         }
                    //     }
                    //     else{
                    //         foreach($segments as $segkey => $segvalue)
                    //         {   
                    //             echo "second".$segkey;
                    //             if($segvalue['OriginAirportDetails']->airport_code == $nextAirportCode && (strtotime($segvalue['DepartureDate']." ".$segvalue['DepartureTime']) >  $dateandTime))
                    //             {
                    //                 $nextAirportCode = $segvalue['DestinationAirportDetails']->airport_code;
                    //                 $itinerary[$i] = $segments[$segkey];
                    //                 $dateandTime = strtotime($segvalue['DepartureDate']." ".$segvalue['DepartureTime']);
                    //                 break;
                    //             }
                    //         }
                    //     }
                    // }
                    
                    // dd($segments);
                    // $segments = $itinerary;

            

                }
                usort($segments, function($a, $b) {
                    return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
                });
              
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
                $passengersList = [];
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
            //$frontEndHomeController = new \App\Http\Controllers\FrontEnd\HomeController();
            $data = ["pnr"=> $pnr, "requestFrom" => "WEB"];
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
                      
                        $baggageData             = $this->getBaggageForPassenger($userRequest, $productClass, $myItinary);
                       

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


                $result = [
                    'segments' => $result,  // Assign $result to the 'segments' key
                    'flightBookingDetails' => $flightbookingdetails,
                    'airLinePnrs' => $airLinePnrs  // array for 'airLinePnrs'
                ];
 
            }
        }
    
        $html =  View::make('front_end.air.bookingpopup',compact('titles','result'))->render();

        return   response()->json([
            "status" => "200",
            "message" => "Flight Ticket Preview",
            "html" => $html
         ], 200);

    }

    public function farerules(Request $request)
    {
        $sessionId = $request->input('sessionid');
        
        $sessiondata = session()->get($sessionId);

        $AirPricing = $sessiondata['airPricingdata'];

        $tarceId = $sessiondata['tarceId'];

        $FareRule = new BookingController();
                    
        $FareRuleresult = $FareRule->FareRules($AirPricing,$tarceId);

        $FareRuleResp = $FareRuleresult['travelportResponse'];

        if(isset($FareRuleResp['air:AirFareRulesRsp']['air:FareRule']['@attributes']))
        {
            $temp = $FareRuleResp['air:AirFareRulesRsp']['air:FareRule'];
            $FareRuleResp['air:AirFareRulesRsp']['air:FareRule'] = [];
            $FareRuleResp['air:AirFareRulesRsp']['air:FareRule'][0] = $temp;
        }

        foreach ($FareRuleResp['air:AirFareRulesRsp']['air:FareRule'] as $key => $value) {
            foreach ($FareRuleResp['air:AirFareRulesRsp']['air:FareRule'][$key]['air:FareRuleLong'] as $ruleKey => $ruleValue) {
                $categoryId = $FareRuleResp['air:AirFareRulesRsp']['air:FareRule'][$key]['air:FareRuleLong'][$ruleKey]['@attributes']['Category'];
                $categoryDeatils = FareRulesCategory::where('category' , $categoryId )->first();
                $categoryName = !empty($categoryDeatils)?$categoryDeatils->category_name:"";

                $FareRuleResp['air:AirFareRulesRsp']['air:FareRule'][$key]['air:FareRuleLong'][$ruleKey]['@attributes']['CategoryName'] = $categoryName; 
            }
        }

        $titles = [
            'title' => "Fare Rule",
        ];

        $html =  View::make('front_end.air.fare_rules',compact('titles','FareRuleResp'))->render();

        return   response()->json([
            "status" => "200",
            "message" => "Fare Rules",
            "html" => $html
         ], 200);

    }


    public function paymentGateWay(Request $request)
    {
        //payment gate way invoice generation
        $bookingId = decrypt($request->input('booking_id'));
        if(empty($bookingId))
        {
            //error
            return redirect()->route('some-thing-went-wrong');
        }
        $BookingDetails = FlightBooking::with('Customercountry')->find($bookingId);
        if(empty($BookingDetails))
        {
            //error
            return redirect()->route('some-thing-went-wrong');
        }

        if($BookingDetails->internal_booking == 1)
        {
            return redirect()->route('bookflight',['flightbookingId' => encrypt($BookingDetails->id)]);
        }
        
        //$userName = Auth::guard('web')->check() ? Auth::guard('web')->user()->name : 'guest' ;
        $passengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($BookingDetails->id)->first();
       
        $userName = (!empty($passengersInfo)) ? $passengersInfo->first_name . " ".$passengersInfo->last_name : 'guest';
       
        $callbackURL = route('bookflight',['flightbookingId' => encrypt($BookingDetails->id)]) ;
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

    public function pendingTicket()
    {

        Mail::send('front_end.email_templates.pending-ticket',[], function($message) {
            $message->to('rajesh@smartlinks.com')
                    ->subject('flightTicketPending');
        });

    }


    public function TravelportAirPricing($flights,$UserRequest,$tarceId,$extraInfo =[])
    {

        $AirBooking = new BookingController();
        $airPricingrResponse = $AirBooking->AirPricing($flights,$UserRequest,$tarceId);
        $response = $airPricingrResponse['travelportResponse'];
        

        // $response = file_get_contents(public_path('response.xml'));
        // $converted = XmlToArray::convert($response, $outputRoot = false);
        // $response =[];
        // $response['air:AirPriceRsp'] = $converted;
        //     echo "hh";
        //  dd($response);
        
        $pricingResult=[];

        if(!isset($response['air:AirPriceRsp']))
        {
            $pricingResult=[];
            $pricingResult['IsSuccess'] = false;
            $pricingResult['errorresponse'] = $response['SOAP:Fault']['faultstring'] ?? '';
    
            return $pricingResult;
        }

        // if(isset($response['air:AirPriceRsp']['common_v52_0:ResponseMessage'])){

        //     $responseMessage = $response['air:AirPriceRsp']['common_v52_0:ResponseMessage'];
    

        //     if(isset($responseMessage['@attributes']))
        //     {
        //         $temp ="";
        //         $temp = $responseMessage;
        //         $responseMessage = [];
        //         $responseMessage[0] = $temp;
        //     }
        //     //$error ="";
        //     foreach($responseMessage as $responseMessage)
        //     {
        //         //$error .=  $responseMessage['@content'];
        //         if($responseMessage['@attributes']['Code'] == '4772')
        //         {
        //             //Schedule Change Occurred and the air segment(s) DepartureTime and/or ArrivalTime have been updated
        //             $pricingResult=[];
        //             $pricingResult['IsSuccess'] = false;
        //             $pricingResult['errorresponse'] = $responseMessage['@content'];
            
        //             return $pricingResult;
        //         }
        //     }
        // }

        $tarceId = $response['air:AirPriceRsp']['@attributes']['TraceId'];
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

            $mKprice = markUpPrice($result['air:AirPricingSolution']['@attributes']['TotalPrice'],$result['air:AirPricingSolution']['@attributes']['Taxes'],$result['air:AirPricingSolution']['@attributes']['ApproximateBasePrice'] , ((!empty($extraInfo) && isset($extraInfo['type_of_payment'])) ? $extraInfo['type_of_payment'] : 'k_net'),(isset($extraInfo['couponCode']) && !empty($extraInfo['couponCode'])) ? ['couponCode' => $extraInfo['couponCode']] : []);

            

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
                    
                    $chekin[$ke]['table'][$passengertype] = array('air:TextInfo'=>$val['air:TextInfo'],'air:BagDetails'=> isset($val['air:BagDetails']) ? $val['air:BagDetails'] : "" );
                }
            }
            $cabin =[];
            foreach($result['air:AirPricingSolution']['air:AirPricingInfo'][0]['air:BaggageAllowances']['air:CarryOnAllowanceInfo'] as $ke =>$val)
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
                    if(!isset($cabin[$ke]))
                    {
                        $cabin[$ke] = array('@attributes'=>$val['@attributes']);
                    }
                    $cabin[$ke]['table'][$passengertype] = array('air:TextInfo'=>isset($val['air:TextInfo']) ?$val['air:TextInfo'] : '','air:CarryOnDetails'=>isset($val['air:CarryOnDetails']) ?$val['air:CarryOnDetails'] : '');
                }
            }
            $result['air:AirPricingSolution']['@attributes']['chekin'] = $chekin;
            $result['air:AirPricingSolution']['@attributes']['cabin'] = $cabin;

        

            //cancellation chargers
            $AdultChangePenalty = array();
            $AdultCancelPenalty = array();
            $childrenChangePenalty = array();
            $childrenCancelPenalty = array();
            $infantChangePenalty = array();
            $infantCancelPenalty = array();

            foreach($result['air:AirPricingSolution']['air:AirPricingInfo'] as $ky=>$pricingInfo)
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
            $result['air:AirPricingSolution']['@attributes']['AdultChangePenalty'] = $AdultChangePenalty;
            $result['air:AirPricingSolution']['@attributes']['AdultCancelPenalty'] = $AdultCancelPenalty;
            $result['air:AirPricingSolution']['@attributes']['childrenChangePenalty'] = $childrenChangePenalty;
            $result['air:AirPricingSolution']['@attributes']['childrenCancelPenalty'] = $childrenCancelPenalty;
            $result['air:AirPricingSolution']['@attributes']['infantChangePenalty'] = $infantChangePenalty;
            $result['air:AirPricingSolution']['@attributes']['infantCancelPenalty'] = $infantCancelPenalty;

            //using for displaying in web view
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
            $result['refund'] = $refund;
            $result['markupPrice'] = $mKprice;
            $result['type'] = 'travelport';

            $pricingResult=[];
            $pricingResult['IsSuccess'] = true;
            $pricingResult['completeData'] = $result;
            $pricingResult['xml_request_id'] = $airPricingrResponse['travelportRequest']->id;
            
            return $pricingResult;
            

        }
        else{
            $pricingResult=[];
            $pricingResult['IsSuccess'] = false;
            $pricingResult['errorresponse'] = 'some thing went wrong';
            return $pricingResult;
        }


    }

    public function AirArabiaAirPricing($flights,$UserRequest,$traceId,$extraInfo =[])
    {
        // dd($UserRequest);
        $AirBooking = new BookingController();
        if((isset($extraInfo['page_type']) && ($extraInfo['page_type'] == 'preview')))
        {
            // dd($flights);
            $airPricingrResponse = $AirBooking->AirArabiaPricing($flights,$UserRequest,$traceId,$extraInfo);
        }
        else{
            $airPricingrResponse = $AirBooking->AirArabiaPricing($flights,$UserRequest,$traceId);
        }
        
        $response = $airPricingrResponse['travelportResponse'];
        // $response = file_get_contents(public_path('response.xml'));
        // $converted = XmlToArray::convert($response, $outputRoot = false);
        // $response =[];
        // $response = $converted['soap:Body'];
        //    dd($response);
        if(isset($response['ns1:OTA_AirPriceRS']['ns1:Errors']['ns1:Error']))
        {
            $pricingResult=[];
            $pricingResult['IsSuccess'] = false;
            $pricingResult['errorresponse'] = $response['ns1:OTA_AirPriceRS']['ns1:Errors']['ns1:Error']['@attributes']['ShortText'];
            return $pricingResult;
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

            $mKprice = markUpPrice($TotalPrice,$tax,$ApproximateBasePrice , ((!empty($extraInfo) && isset($extraInfo['type_of_payment'])) ? $extraInfo['type_of_payment'] : 'k_net' ) ,array('currency_code' => $currencyCode , 'from' => 'airarabia' ,'couponCode' => ( isset($extraInfo['couponCode']) && !empty($extraInfo['couponCode']) ) ? $extraInfo['couponCode'] : null ) );
            
            if(isset($AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption']['ns1:FlightSegment']))
            {
                $temp = $AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'];
                $AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] = [];
                $AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'][0] = $temp;
            }
            foreach($AirPrice['ns1:AirItinerary']['ns1:OriginDestinationOptions']['ns1:OriginDestinationOption'] as $itinerary)
            {
                $segments[] =  array(
                    'airarabiaData'=>$itinerary,
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
                );
            }
            usort($segments, function($a, $b) {
                return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
            });
            if($UserRequest['flight-trip'] == 'roundtrip')
            {
                //no change for oneway

               
                $bound = 'outbound' ;
                foreach ($segments as $segkey => $segvalue) {
                    $segments[$segkey]['segmentType'] = $bound;
                    if($segvalue['DestationAirportDetails']->airport_code == $UserRequest['flightToAirportCode']){
                        $bound = 'inbound' ;
                    }
                }
            }
            //  dd($segments);
            $result['airSegments'] = $segments;
            $result['refund'] = false;
            $result['markupPrice'] = $mKprice;
            $result['pricing'] = $AirPrice['ns1:AirItineraryPricingInfo']['ns1:ItinTotalFare']['ns1:TotalFare']; 
            $result['transactionIdentifier'] = $response['ns1:OTA_AirPriceRS']['@attributes']['TransactionIdentifier'];
            $result['type'] = 'airarabia';

            if(!(isset($extraInfo['page_type']) && ($extraInfo['page_type'] == 'preview')))
            {
                //Baggage details 
                if($UserRequest['flight-trip'] == 'roundtrip')
                {
                    $result['DeparatureBaggage'] = $this->airArabiaExtraBaggage(array('flightDetails' => $result , 'UserRequest' => $UserRequest , 'traceId' => $traceId ,'bound' => 'outbound'));
                    $result['ReturnBaggage'] = $this->airArabiaExtraBaggage(array('flightDetails' => $result , 'UserRequest' => $UserRequest , 'traceId' => $traceId ,'bound' => 'inbound'));
                }
                else{
                    $result['DeparatureBaggage'] = $this->airArabiaExtraBaggage(array('flightDetails' => $result , 'UserRequest' => $UserRequest , 'traceId' => $traceId ));
                }
            }
            

            $pricingResult=[];
            $pricingResult['IsSuccess'] = true;
            $pricingResult['completeData'] = $result;
            $pricingResult['xml_request_id'] = $airPricingrResponse['travelportRequest']->id ;
            // dd($pricingResult);

            return $pricingResult;
        }
    }
    public function airArabiaExtraBaggage($data=null)
    {
        $AirBooking = new BookingController();
        $response = $AirBooking->AirArabiaBaggage($data);
        $response = $response['travelportResponse'];
        // $response = file_get_contents(public_path('response2.xml'));
        // $converted = XmlToArray::convert($response, $outputRoot = false);
        // $response =[];
        // $response = $converted['soap:Body'];
        // dd($response);
        
        if(isset($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:Errors']) && !empty($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:Errors']))
        {
            //error
            return [];
        }else{
            
            if(isset($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']) && !empty($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']))
            {
                if(isset($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo']['@attributes']))
                {
                    $temp = $response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo'];
                    $response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo'] = [];
                    $response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo'][0] = $temp;
                }
                $segments = [] ;
                foreach ($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo'] as $segmentKey => $segmentValue) {
                    
                    $segments[] = [
                        'DepartureAirport' => $segmentValue['ns1:DepartureAirport']['@attributes']['LocationCode'],
                        'ArrivalAirport' => $segmentValue['ns1:ArrivalAirport']['@attributes']['LocationCode'],
                        'FlightNumber' => $segmentValue['@attributes']['FlightNumber'],
                        'RPH' => $segmentValue['@attributes']['RPH'],
                        'Carrier' => 'G9',
                        'SegmentCode' => $segmentValue['@attributes']['SegmentCode'],
                        'DepartureDateTimeFormate'=>DateTimeSpliter($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo'][$segmentKey]['@attributes']['DepartureDateTime'],'date')." ".DateTimeSpliter($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo'][$segmentKey]['@attributes']['DepartureDateTime'],'time'),
                        'ArrivalDateTimeFormate' => DateTimeSpliter($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo'][$segmentKey]['@attributes']['ArrivalDateTime'],'date')." ".DateTimeSpliter($response['ns1:AA_OTA_AirBaggageDetailsRS']['ns1:BaggageDetailsResponses']['ns1:OnDBaggageDetailsResponse']['ns1:OnDFlightSegmentInfo'][$segmentKey]['@attributes']['ArrivalDateTime'],'time')
                    ] ;
                    
                }

                usort($segments, function($a, $b) {
                    return strtotime($a['DepartureDateTimeFormate']) <=> strtotime($a['DepartureDateTimeFormate']);
                });

                // dd($segments);

                

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

                return ['segments' => $segments, 'baggage' => $baggage];

            }
            else
            {
                return [];
            }
           
        }

    }

    // Baggage details jazeera airways
    function getBaggageForPassenger($response ,$productClass, $itinerary)
    {   
        $itineraryDetails       = $itinerary['AirSegment'];
        $noOfAdults             = $response['noofAdults'];
        $noOfChildren           = $response['noofChildren'];
        $noOfInfants            = $response['noofInfants'];
        $flightFromAirportCode  = $itineraryDetails['OriginAirportDetails']['airport_code'];
        $flightToAirportCode    = $itineraryDetails['DestationAirportDetails']['airport_code'];

        $baggage = [];
        $baggage['product'] = $productClass;
        $baggage['segment'] = $flightFromAirportCode . ' - ' . $flightToAirportCode;
        $baggage['airline'] = "J9";
        $baggage['flightNumber'] = $itineraryDetails['FlightNumber'];
        $baggage['table'] = [];

        if ($noOfAdults && $noOfAdults !== "0") {
            

            // Retrieve baggage information for ADULT passenger type
            $adultBaggageInfo = $this->getProductClassInfo($productClass, 'ADT');
            if ($adultBaggageInfo !== null) {
                $baggage['table']['ADULT'] = $adultBaggageInfo;
            }
        }

        if ($noOfChildren && $noOfChildren !== "0") {
           

            // Retrieve baggage information for CHILD passenger type
            $childBaggageInfo = $this->getProductClassInfo($productClass, 'CHD');
            if ($childBaggageInfo !== null) {
                $baggage['table']['CHILD'] = $childBaggageInfo;
            }
        }

        if ($noOfInfants && $noOfInfants !== "0") {
           

            // Retrieve baggage information for INFANT passenger type
            $infantBaggageInfo = $this->getProductClassInfo($productClass, 'INF');
            if ($infantBaggageInfo !== null) {
                $baggage['table']['INFANT'] = $infantBaggageInfo;
            }
        }
        return $baggage;
    }

    function getProductClassInfo($productClass, $passengerType)
    {
        
        switch ($productClass) {
            case 'EL':
                if ($passengerType === 'ADT' || $passengerType === 'CHD') {
                    return [
                        'checkIn' => [ 
                            'type' => 'weight',
                            'value' => '0',
                            'unit' => 'Kilograms',
                        ],
                        'carryOn' => [   
                            'type' => 'weight',
                            'value' => '7',
                            'unit' => 'Kg',
                        ],
                    ];
                } elseif ($passengerType === 'INF') {
                    return [
                        'carryOn' => [  
                            'type' => 'weight',
                            'value' => '10',
                            'unit' => 'Kg',
                        ],
                    ];
                }
                break;
            case 'EV':
                if ($passengerType === 'ADT' || $passengerType === 'CHD') {
                    return [
                        'checkIn' => [ 
                            'type' => 'weight',
                            'value' => '20',
                            'unit' => 'Kilograms',
                        ],
                        'carryOn' => [  
                            'type' => 'weight',
                            'value' => '7',
                            'unit' => 'Kg',
                        ],
                    ];
                } elseif ($passengerType === 'INF') {
                    return [
                        'carryOn' => [  
                            'type' => 'weight',
                            'value' => '10',
                            'unit' => 'Kg',
                        ],
                    ];
                }
                break;
            case 'EE':
                if ($passengerType === 'ADT' || $passengerType === 'CHD') {
                    return [
                        'checkIn' => [ 
                            'type' => 'weight',
                            'value' => '30',
                            'unit' => 'Kilograms',
                        ],
                        'carryOn' => [  
                            'type' => 'weight',
                            'value' => '7',
                            'unit' => 'Kg',
                        ],
                    ];
                } elseif ($passengerType === 'INF') {
                    return [
                        'carryOn' => [  
                            'type' => 'weight',
                            'value' => '10',
                            'unit' => 'Kg',
                        ],
                    ];
                }
                break;
            case 'BU':
                if ($passengerType === 'ADT' || $passengerType === 'CHD') {
                    return [
                        'checkIn' => [ 
                            'type' => 'weight',
                            'value' => '60',
                            'unit' => 'Kilograms',
                        ],
                        'carryOn' => [  
                            'type' => 'weight',
                            'value' => '15',
                            'unit' => 'Kg',
                        ],
                    ];
                } elseif ($passengerType === 'INF') {
                    return [
                        'carryOn' => [  
                            'type' => 'weight',
                            'value' => '10',
                            'unit' => 'Kg',
                        ],
                    ];
                }
                break;
            default:
                return null;
        }
    }

    function convertFlightTravelTimeToMinutes($flightTravelTime) {
        $parts = explode(':', $flightTravelTime);
        $hours = intval($parts[0]);
        $minutes = intval($parts[1]);
        
        return ($hours * 60) + $minutes;
    }

    function convertMinutesToFlightTravelTime($totalMinutes) {
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    function calcualteMinutes($time){
        $days = 0;
        $hours = 0;
        $minutes = 0;
        if (strpos($time, 'D') !== false) {
            preg_match('/(\d+)D/', $time, $matches);
            $days = intval($matches[1]);
        }

        if (strpos($time, 'H') !== false) {
            preg_match('/(\d+)H/', $time, $matches);
            $hours = intval($matches[1]);
        }

        if (strpos($time, 'M') !== false) {
            preg_match('/(\d+)M/', $time, $matches);
            $minutes = intval($matches[1]);
        }

        // Calculate the total minutes
        $totalMinutes = ($days * 24 * 60) + ($hours * 60) + $minutes;
        return $totalMinutes; 

    }
     public function AirJazeeraAirPricing($flights,$UserRequest,$traceId,$extraInfo =[])
    { 
        $AirBooking          = new BookingController();
        $UserRequest['currencyCode'] = $flights['originCurrency'];
        if((isset($extraInfo['page_type']) && ($extraInfo['page_type'] == 'preview')))
        {
            $airPricingrResponse = $AirBooking->tripSellRequestJazeera($flights,$UserRequest,$traceId,$extraInfo);
        }
        else{
            $airPricingrResponse = $AirBooking->bookingQuoteRequestJazeera($flights,$UserRequest,$traceId);
        }

        //dd($airPricingrResponse);
        //dd($airPricingrResponse['jazeeraResponse']);
        if(isset($airPricingrResponse['jazeeraResponse'][0]['dotrezAPI']['dotrezErrors']))
        {
            $pricingResult                  = [];
            $pricingResult['IsSuccess']     = false;
            $pricingResult['errorresponse'] = $airPricingrResponse['jazeeraResponse'][0]['dotrezAPI']['dotrezErrors']['errors'][0]['rawMessage'];
            return $pricingResult;
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
           
            $mKprice = markUpPrice($convertedTotalPrice,$convertedTax,$convertedApproximateBasePrice , ((!empty($extraInfo) && isset($extraInfo['type_of_payment'])) ? $extraInfo['type_of_payment'] : 'k_net' ) ,array('currency_code' => "KWD" , 'from' => 'airjazeera' , 'couponCode' => ( ( isset($extraInfo['couponCode']) && !empty($extraInfo['couponCode']) ) ? $extraInfo['couponCode']: null )) );

            //dd($mKprice);
            foreach($journeyDetails as $journey)
            {
                foreach($journey['segments'] as $itinerary){  
                $departureTimeUtc       = $itinerary['legs'][0]['legInfo']['departureTimeUtc'];
                $arrivalTimeUtc         = $itinerary['legs'][0]['legInfo']['arrivalTimeUtc'];
                $departureDateTimeUtc   = new DateTime($departureTimeUtc, new DateTimeZone('UTC'));
                $arrivalDateTimeUtc     = new DateTime($arrivalTimeUtc, new DateTimeZone('UTC'));
                $flightDuration         = $departureDateTimeUtc->diff($arrivalDateTimeUtc);
                $flightTravelTime       = $flightDuration->format('%H:%I');

                    $segments[] =  array(
                        'airJazeeraData'            =>  $itinerary,
                        'OriginAirportDetails'      =>  $this->AirportDetails($itinerary['designator']['origin']),
                        'DestationAirportDetails'   =>  $this->AirportDetails($itinerary['designator']['destination']),
                        'DepartureDate'             =>  DateTimeSpliter($itinerary['designator']['departure'],'date'),
                        'DepartureTime'             =>  DateTimeSpliter($itinerary['designator']['departure'],'time'),
                        'ArrivalDate'               =>  DateTimeSpliter($itinerary['designator']['arrival'],'date'),
                        'ArrivalTime'               =>  DateTimeSpliter($itinerary['designator']['arrival'],'time'),
                        'Carrier'                   =>  $itinerary['identifier']['carrierCode'],
                        'CodeshareInfo'             =>  'Air Jazeera',
                        'AirLine'                   =>  'Air Jazeera',
                        'FlightNumber'              =>  $itinerary['identifier']['identifier'],
                        'FlightTime'                =>  $flightTravelTime,
                    );
                }
            }

            usort($segments, function($a, $b) {
                return strtotime($a['DepartureDate']." ".$a['DepartureTime']) <=> strtotime($b['DepartureDate']." ".$b['DepartureTime']);
            });

            if($UserRequest['flight-trip'] == 'roundtrip')
            {
                $bound = 'outbound' ;
                foreach ($segments as $segkey => $segvalue) {
                    $segments[$segkey]['segmentType'] = $bound;
                    if($segvalue['DestationAirportDetails']->airport_code == $UserRequest['flightToAirportCode']){
                        $bound = 'inbound' ;
                    }
                }
            }

            $result['airSegments']              =   $segments;
            $result['refund']                   =   false;
            $result['markupPrice']              =   $mKprice;
            $result['pricing']                  =   null; 
            $result['transactionIdentifier']    =   null;
            $result['type']                     =   'airjazeera';
            $result['DeparatureBaggage']        =   null;
            $result['passengers']                =   $passengers;
            $pricingResult                      =   [];
            $pricingResult['IsSuccess']         =   true;
            $pricingResult['completeData']      =   $result;
            $pricingResult['xml_request_id']    =   null ;
            return $pricingResult;
        }else{
            $pricingResult                  = [];
            $pricingResult['IsSuccess']     = false;
            $pricingResult['errorresponse'] = "Something went wrong.";
            return $pricingResult;
        }
    }

    public function getPendingPnrs(){

        $pendingUniversalPnrs = PendingPnrs::with('flightBooking')->whereStatus(1)->whereCronStatus(0)->whereDate('enable_request_on', '<=', date('Y-m-d'))->whereTime('enable_request_on', '<=', date('H:i:s'))->limit(2)->get();
        // ddd($pendingUniversalPnrs);

        // $pendingUniversalPnrs = PendingPnrs::where('id',4)->get();


        $Booking = new BookingController();

        foreach($pendingUniversalPnrs as $vendorpnr){
            try {
                // dd($vendorpnr);
                $flightbookingdetails = FlightBooking::find($vendorpnr->booking_id); 

                $universalRecord = $Booking->getTravelportUniversalRecord(array('universalPnr' => $vendorpnr->vendor_pnr ,'traceId' => $vendorpnr->flightBooking->trace_id ?? rand(100000,999999)));
    
                // $response = file_get_contents(public_path('response2.xml'));
                // $converted = XmlToArray::convert($response, $outputRoot = false);
                // $response =[];
    
                // $response = $converted['soap:Body'];
                // dd($converted);
                // $Airpricinguuid = $flightbookingdetails->session_uuid;
                // $AirPricingData = session()->get($Airpricinguuid);
                // $AirPricing = $AirPricingData['airPricingdata'];
                // $tarceId = $AirPricingData['tarceId'];
                $tarvelersInfo = FlightBookingTravelsInfo::with('passportIssuedCountry')->where('flight_booking_id',$vendorpnr->booking_id)->get();
                // $AirBooking = new BookingController();
    
                //flight ticket booking integration in travelport
    
                // $airCreateReservationResponse = $AirBooking->AirCreateReservation($AirPricing,$tarvelersInfo,$flightbookingdetails,$tarceId);
    
                $response =[];
                $totalData['response'] = $universalRecord['travelportResponse'];
                $travelportRequest = $universalRecord['travelportRequest'];
                // $totalData['response'] = $response;

                $vendorpnr->travelport_request_id = $travelportRequest->id;
                $vendorpnr->save();


    
                // $travelportReuestId = $travelportRequest->id;
    
                // $travelpoertReuestId = 12545;
                // dd($totalData);
    
                if(!isset($totalData['response']['universal:UniversalRecordRetrieveRsp']))
                {
                    //error
                    continue;
                }
                
    
                $response = $totalData['response']['universal:UniversalRecordRetrieveRsp'];
        
                $pnr = $response['universal:UniversalRecord']['@attributes']['LocatorCode'];
    
            
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
                        $airlinesPnr->booking_id = $vendorpnr->booking_id;
                        $AirlinesDetails = Airline::whereVendorCode($value['@attributes']['SupplierCode'])->first();
                        $airlinesPnr->name = $AirlinesDetails['name'] ?? '';
                        $airlinesPnr->code = $value['@attributes']['SupplierCode'];
                        $airlinesPnr->airline_pnr = $value['@attributes']['SupplierLocatorCode'];
                        $airlinesPnr->save();
                    }
                }        
    
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

                $response['universal:UniversalRecord']['air:AirReservation']['refundable'] = (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable']) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable'] == "true")) ? True : False;
                
                //Airline Pnrs
                if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes'])){
                    $temp= [];
                    $temp = $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'];
                    $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] = [];
                    $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0] = $temp;
                }
                // print_r($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']);
                if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) && count($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) > 0)
                {
                    foreach($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $supplierkey => $suppliervalue) {
                        $airlineName = Airline::where('vendor_code' , $suppliervalue['@attributes']['SupplierCode'])->first();
                        $airlineName = $airlineName->short_name ?? '' ;
                        $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][$supplierkey]['@attributes']['airline_name'] = $airlineName;
                    }
                }
                
                //User Name
                $user = $tarvelersInfo[0]->first_name .' '.$tarvelersInfo[0]->last_name;
    
                //formatting 
    
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
                //     $TravelerInfodetails = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where("title",$TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Prefix'])->where("first_name",$TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['First'])->where("last_name",$TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Last'])->first();
                //     $passengersList[] = array(
                //         'travelerType' => $TravelerType,
                //         'prefix' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Prefix'],
                //         'firstName' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['First'],
                //         'lastName' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Last'],
                //         'ticketNumber' => $TravelerInfodetails->travel_port_ticket_number??'---',
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
    
                $extrabaggageinfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where(function ($query) {
                    $query->where('depature_extra_baggage', '!=', '')
                            ->orWhere('return_extra_baggage', '!=', '');
                })->get();
    
                $result['extrabaggageinfo'] = $extrabaggageinfo;
                return view('front_end.email_templates.ticket',compact('result'));
    
                $filename = "Ticket_".$flightbookingdetails->booking_ref_id.".pdf";
                $completePath = null;
                if(env('APP_ENV') != 'local'){
                    $pdf = PDF::loadView('front_end.email_templates.ticket', compact('titles','result'));
                    $pdf->save('pdf/tickets/' . $filename);

                    $completePath = 'pdf/tickets/' . $filename;
                    $flightbookingdetails->flight_ticket_path = $completePath;
                    $flightbookingdetails->ticketing_travelport_request_id = $travelportRequest->id;
                    $flightbookingdetails->save();
        
                    Mail::send('front_end.email_templates.ticket', compact('titles','result'), function($message)use($pdf,$flightbookingdetails,$filename) {
                        $message->to($flightbookingdetails->email)
                                ->subject('flightTicket')
                                ->attachData($pdf->output(), $filename);
                    });
                }
                else{
                    $flightbookingdetails->flight_ticket_path = $completePath;
                    $flightbookingdetails->ticketing_travelport_request_id = null;
                    $flightbookingdetails->save();
                }
                $vendorpnr->old_ticketing_travelport_request_id = $flightbookingdetails->ticketing_travelport_request_id;
                $vendorpnr->is_success = 1;
                $vendorpnr->save();
            } catch (\Throwable $th) {
                //throw $th;
                $vendorpnr->is_success = 0;
                $vendorpnr->save();
            }
            $vendorpnr->cron_status = 1;
            $vendorpnr->save();
        }
    }   
    // public function test(){
    //     // dd("dd");
    //     $flightbookingId = 174;
    //     $flightbookingdetails  = FlightBooking::find($flightbookingId);
    //      //test

    //     // $response = file_get_contents(public_path('response2.xml'));
    //     // $converted = XmlToArray::convert($response, $outputRoot = false);
    //     // $response =[];
    //     // $response = $converted['SOAP:Body'];
    //     // if($flightbookingdetails->booking_status == 'payment_initiated' || $flightbookingdetails->internal_booking == 1)
    //     // {
    //         // $myfatoorah = new MyFatoorahController();
    //         // if($flightbookingdetails->internal_booking == 1)
    //         // {
    //         //     $invoicedata['IsSuccess'] = true;
    //         //     $invoicedata['Data'] = new stdClass();
    //         //     $invoicedata['Data']->InvoiceStatus = "Paid";
    //         // }
    //         // else{
    //         //     $invoicedata = $myfatoorah->callback($paymentId);
    //         // }
            
    //         // if($invoicedata['IsSuccess'] )
    //         // {
    //             $titles = [
    //                 'title' => "Flight Booked itinerary",
    //             ];
                
    //             // $flightbookingdetails->invoice_status = $invoicedata['Data']->InvoiceStatus;
    //             // $flightbookingdetails->invoice_response = json_encode($invoicedata['Data']);
    //             // $flightbookingdetails->payment_id = $paymentId;
    //             // if($invoicedata['Data']->InvoiceStatus == 'Paid')
    //             // {
    //             //     $flightbookingdetails->booking_status = 'payment_successful';
    //             //     if($flightbookingdetails->internal_booking == 1){
    //             //         $flightbookingdetails->payment_gateway = 'AGENCY';
                        
    //             //     }
    //             //     else{
    //             //         $flightbookingdetails->payment_gateway = $invoicedata['Data']->focusTransaction->PaymentGateway;
    //             //     }
    //             // }
    //             // elseif($invoicedata['Data']->InvoiceStatus == 'Expired'){
    //             //     $flightbookingdetails->booking_status = 'payment_exipre';
    //             // }
    //             // elseif($invoicedata['Data']->InvoiceStatus == 'Failed')
    //             // {
    //             //     $flightbookingdetails->booking_status = 'payment_failure';
    //             // }
    //             // $flightbookingdetails->save();
    
    //             // if($invoicedata['Data']->InvoiceStatus == 'Paid')
    //             // {
    
    //                 // $Airpricinguuid = $flightbookingdetails->session_uuid;
    //                 // $AirPricingData = session()->get($Airpricinguuid);
    //                 // $AirPricing = $AirPricingData['airPricingdata'];
    //                 // $tarceId = $AirPricingData['tarceId'];
    //                 $tarvelersInfo = FlightBookingTravelsInfo::with('passportIssuedCountry')->where('flight_booking_id',$flightbookingId)->get();
    //                 $AirBooking = new BookingController();
    //                 // if($AirPricing['type'] == 'travelport')
    //                 // {
    //                     //flight ticket booking integration in travelport

    //                     // $airCreateReservationResponse = $AirBooking->AirCreateReservation($AirPricing,$tarvelersInfo,$flightbookingdetails,$tarceId);
    //                     // $totalData['response'] = $airCreateReservationResponse['travelportResponse'];
    //                     // $travelportRequest = $airCreateReservationResponse['travelportRequest'];
    //                     $response = file_get_contents(public_path('response2.xml'));
    //     $converted = XmlToArray::convert($response, $outputRoot = false);
    //     $response =[];
    //     $totalData['response'] = $converted['SOAP:Body'];
    //     // dd($totalData['response']);
    //                     $travelpoertReuestId = 123;
    //                     if(!isset($totalData['response']['universal:AirCreateReservationRsp']))
    //                     {
    //                         $data['errorresponse'] =$totalData['response']['SOAP:Fault']['faultstring'];
    //                         //travelport request error response
    //                         //refund should initate
    //                         //redirect to error page
        
    //                         return view('front_end.error',compact('titles','data'));
    //                     }
        
    //                     $response = $totalData['response']['universal:AirCreateReservationRsp'];
    //                     $traceId = 124;
    //                     $pnr = $response['universal:UniversalRecord']['@attributes']['LocatorCode'];
                
    //                     $flightbookingdetails->trace_id = 124;
    //                     $flightbookingdetails->pnr = $pnr;
    //                     $flightbookingdetails->booking_status = 'booking_completed';
    //                     $flightbookingdetails->travel_request_id = $travelpoertReuestId;
    //                     $flightbookingdetails->reservation_travelport_request_id = $travelpoertReuestId;
    //                     $flightbookingdetails->galileo_pnr = $response['universal:UniversalRecord']['universal:ProviderReservationInfo']['@attributes']['LocatorCode'];
    //                     $flightbookingdetails->reservation_pnr = $response['universal:UniversalRecord']['air:AirReservation']['@attributes']['LocatorCode'];
    //                     //$flightbookingdetails->supplier_pnr = $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes']['SupplierLocatorCode'];
    //                     // $flightbookingdetails->save();
    //                     //adding all supplierLocator codes in airLinePnrs table
    //                     if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes']))
    //                     {
    //                         $temp = [] ;
    //                         $temp = $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'];
    //                         $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] = [];
    //                         $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0] = $temp;
    //                     }
    //                     if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) && count($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) > 0)
    //                     {
    //                         foreach ($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $key => $value) {
    //                             $airlinesPnr = new AirlinesPnr();
    //                             $airlinesPnr->booking_id = $flightbookingdetails->id;
    //                             $AirlinesDetails = Airline::whereVendorCode($value['@attributes']['SupplierCode'])->first();
    //                             $airlinesPnr->name = $AirlinesDetails['name'] ?? '';
    //                             // $airlinesPnr->airline_pnr = $value['@attributes']['SupplierCode'];
    //                             // $airlinesPnr->code = $value['@attributes']['SupplierLocatorCode'];
    
    //                             $airlinesPnr->code = $value['@attributes']['SupplierCode'];
    //                             $airlinesPnr->airline_pnr = $value['@attributes']['SupplierLocatorCode'];
    
    
    //                             // $airlinesPnr->save();
    //                         }
    //                     }
    //                     else{
    //                         $pendingpnr = new PendingPnrs();
    //                         $pendingpnr->booking_id = $flightbookingdetails->id;
    //                         $pendingpnr->vendor_pnr = $pnr;
    //                         $pendingpnr->cron_status = 0;
    //                         $pendingpnr->status = 1;
    //                         $pendingpnr->enable_request_on = date('Y-m-d H:i:s', strtotime('+130 minutes'));
    //                         $pendingpnr->save();
    //                     }
                     
                        
        
    //                     if(isset($response['SOAP:Fault']['faultstring']))
    //                     {
    //                         $error =  $response['SOAP:Fault']['faultstring'];
    //                         //error
    //                         return view('front_end.air.booking_flight_itinerary',compact('titles','error','flightbookingdetails'));
    //                     }
    //                     if(isset($response['air:AirSolutionChangedInfo']))
    //                     {
    //                         if(isset($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode']) && ($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode'] == "Schedule"))
    //                         {
    //                             $error =  "Air Segments have re-Schedule ,If amount debited from your bank it will be credited back";
    //                         }
    //                         $flightbookingdetails->booking_status = "refund_initiated";
    //                         $flightbookingdetails->save();

                            
    //                         return view('front_end.air.booking_flight_itinerary',compact('titles','error','flightbookingdetails'));
    //                     }
    //                     if(!isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']))
    //                     {
    //                         if(isset($response['ResponseMessage']))
    //                         {
    //                             // if(isset($response['ResponseMessage']['@attributes']))
    //                             // {
    //                             //     $temp ="";
    //                             //     $temp = $response['ResponseMessage'];
    //                             //     $response['ResponseMessage'] = [];
    //                             //     $response['ResponseMessage'][0] = $temp;
    //                             // }
    //                             // $error ="";
    //                             // foreach($response['ResponseMessage'] as $responseMessage)
    //                             // {
    //                             //     $error .=  $responseMessage['@attributes'];
    //                             // }
    //                         }
    //                         // if(isset($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode']) && ($response['air:AirSolutionChangedInfo']['@attributes']['ReasonCode'] == "Schedule"))
    //                         // {
    //                             $error =  "something went wrong,If amount debited from your account it will be credited back";
    //                         //}
    //                         $flightbookingdetails->booking_status = "refund_initiated";
    //                         $flightbookingdetails->save();

                            
    //                         return view('front_end.air.booking_flight_itinerary',compact('titles','error','flightbookingdetails'));
    //                     }
    //                     if(isset($response['universal:UniversalRecord']['common_v52_0:BookingTraveler']['@attributes']))
    //                     {
    //                         $temp = '';
    //                         $temp = $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'];
    //                         $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] = [];
    //                         $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'][0] = $temp;
    //                     }
    //                     if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment']['@attributes']))
    //                     {
    //                         $temp = '';
    //                         $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'];
    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] = [];
    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][0] = $temp;
    //                     }
    //                     if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']['@attributes']))
    //                     {
    //                         $temp = '';
    //                         $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'];
    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] = [];
    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0] = $temp;
    //                     }
                        
    //                     foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $APK =>$APV)
    //                     {
    //                         if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo']['@attributes']))
    //                         {
    //                             $temp = '';
    //                             $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'];
    //                             $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'] = [];
    //                             $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:FareInfo'][0] = $temp;
    //                         }
    //                         if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo']['@attributes']))
    //                         {
    //                             $temp = '';
    //                             $temp = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'];
    //                             $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'] = [];
    //                             $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$APK]['air:BookingInfo'][0] = $temp;
    //                         }
    //                     }

    //                     foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] as $s=>$value)
    //                     {
    //                         $airlinedetails = Airline::whereVendorCode($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Carrier'])->first();

    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['airLineDetais'] =  $airlinedetails;

    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['OriginAirportDetails'] = $this->AirportDetails($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Origin']);

    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['DestinationAirportDetails'] = $this->AirportDetails($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Destination']);

    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['air:FlightDetails']['@attributes']['EquipmentDetails'] = Equipment::where('equipment_code',$response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['air:FlightDetails']['@attributes']['Equipment'])->first();

    //                     }

    //                     $noOfPassengerTypes = count($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']);
    //                     foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'] as $bookingK =>$bookingV )
    //                     {

    //                         $SegmentIndex = array_search($bookingV['@attributes']['SegmentRef'],array_column(array_column($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'],'@attributes'),'Key'));

    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bookingK]['@attributes']['segmentDetails'] = $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$SegmentIndex];

    //                         $table =[];
    //                         for ($i=0; $i < $noOfPassengerTypes; $i++) { 
    //                             $fareKey = $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:BookingInfo'][$bookingK]['@attributes']['FareInfoRef'];

    //                             $airfareindex = array_search($fareKey,array_column(array_column($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'],'@attributes'),'Key'));

    //                             if(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
    //                             {
    //                                 $passengertype = "ADULT";
    //                             }
    //                             elseif(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
    //                             {
    //                                 $passengertype = "CHILD";
    //                             }
    //                             elseif(((isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'])) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
    //                             {
    //                                 $passengertype = "INFANT";
    //                             }
    //                             // echo $passengertype;
    //                             if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces']))
    //                             {
    //                                 $checkIn = array('type'=>'Pcs','value'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:NumberOfPieces'],'unit'=>'Pcs');
    //                             }
    //                             elseif(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']))
    //                             {
    //                                 //print_r($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']);
    //                                 $checkIn = array('type'=>'weight','value'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Value'],'unit'=>$response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][$i]['air:FareInfo'][$airfareindex]['air:BaggageAllowance']['air:MaxWeight']['@attributes']['Unit']);
    //                             }
    //                         // echo "<pre>";
    //                             $table[$passengertype]['checkIn'] = $checkIn;
    //                         }

    //                         $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bookingK]['@attributes']['baggageDetails'] = $table;


                            
    //                     }
    //                     $AdultChangePenalty = array();
    //                     $AdultCancelPenalty = array();
    //                     $childrenChangePenalty = array();
    //                     $childrenCancelPenalty = array();
    //                     $infantChangePenalty = array();
    //                     $infantCancelPenalty = array();
    //                     foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $ky=>$pricingInfo)
    //                     {
    //                         if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'ADT')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'ADT') ) )
    //                         {
    //                             if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
    //                             {
    //                                 $validity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
    //                                 $AdultChangePenalty = array(
    //                                     'type' => 'amount',
    //                                     'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
    //                                     'validity' => $validity
    //                                 );
    //                             }
    //                             elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
    //                             {
    //                                 // print_r(['air:ChangePenalty']);
    //                                 $validity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
    //                                 $AdultChangePenalty = array(
    //                                     'type' => 'percentage',
    //                                     'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
    //                                     'validity' => $validity
    //                                 );
    //                             }
                                
    //                             if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
    //                             {
    //                                 $validity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
    //                                 $AdultCancelPenalty = array(
    //                                     'type' => 'amount',
    //                                     'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
    //                                     'validity' => $validity
    //                                 );
    //                             }
    //                             elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
    //                             {
    //                                 $validity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
    //                                 $AdultCancelPenalty = array(
    //                                     'type' => 'percentage',
    //                                     'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
    //                                     'validity' => $validity
    //                                 );
    //                             }
    //                         }
    //                         //if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'CNN')
    //                         if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'CNN')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'CNN') ) )
    //                         {
    //                             $changevalidity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
    //                             $cancelvalidity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
    //                             if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
    //                             {
    //                                 $childrenChangePenalty = array(
    //                                     'type' => 'amount',
    //                                     'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
    //                                     'validity' => $changevalidity
    //                                 );
    //                             }
    //                             elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
    //                             {
    //                                 $childrenChangePenalty = array(
    //                                     'type' => 'percentage',
    //                                     'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
    //                                     'validity' => $changevalidity
    //                                 );
    //                             }
                                
    //                             if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
    //                             {
    //                                 $childrenCancelPenalty = array(
    //                                     'type' => 'amount',
    //                                     'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
    //                                     'validity' => $cancelvalidity
    //                                 );
    //                             }
    //                             elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
    //                             {
    //                                 $childrenCancelPenalty = array(
    //                                     'type' => 'percentage',
    //                                     'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
    //                                     'validity' => $cancelvalidity
    //                                 );
    //                             }
    //                         }
    //                         //if($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'INF')
    //                         if(((isset($pricingInfo['air:PassengerType']['@attributes']['Code'])) && ($pricingInfo['air:PassengerType']['@attributes']['Code'] == 'INF')) ||  ( (isset($pricingInfo['air:PassengerType'][0]['@attributes']['Code'])) && ($pricingInfo['air:PassengerType'][0]['@attributes']['Code'] == 'INF') ) )
    //                         {
    //                             $changevalidity = isset($pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:ChangePenalty']['@attributes']['PenaltyApplies']:'';
    //                             $cancelvalidity = isset($pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies'])?$pricingInfo['air:CancelPenalty']['@attributes']['PenaltyApplies']:'';
    //                             if(isset($pricingInfo['air:ChangePenalty']['air:Amount']))
    //                             {
    //                                 $infantChangePenalty = array(
    //                                     'type' => 'amount',
    //                                     'value' => $pricingInfo['air:ChangePenalty']['air:Amount'],
    //                                     'validity' => $changevalidity
    //                                 );
    //                             }
    //                             elseif(isset($pricingInfo['air:ChangePenalty']['air:Percentage']))
    //                             {
    //                                 $infantChangePenalty = array(
    //                                     'type' => 'percentage',
    //                                     'value' => $pricingInfo['air:ChangePenalty']['air:Percentage'],
    //                                     'validity' => $changevalidity
    //                                 );
    //                             }
                                
    //                             if(isset($pricingInfo['air:CancelPenalty']['air:Amount']))
    //                             {
    //                                 $infantCancelPenalty = array(
    //                                     'type' => 'amount',
    //                                     'value' => $pricingInfo['air:CancelPenalty']['air:Amount'],
    //                                     'validity' => $cancelvalidity
    //                                 );
    //                             }
    //                             elseif(isset($pricingInfo['air:CancelPenalty']['air:Percentage']))
    //                             {
    //                                 $infantCancelPenalty = array(
    //                                     'type' => 'percentage',
    //                                     'value' => $pricingInfo['air:CancelPenalty']['air:Percentage'],
    //                                     'validity' => $cancelvalidity
    //                                 );
    //                             }
    //                         }
    //                     }
    //                     $response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty'] = $AdultChangePenalty;
    //                     $response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty'] = $AdultCancelPenalty;
    //                     $response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty'] = $childrenChangePenalty;
    //                     $response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty'] = $childrenCancelPenalty;
    //                     $response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty'] = $infantChangePenalty;
    //                     $response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty'] = $infantCancelPenalty;
    //                     $response['universal:UniversalRecord']['air:AirReservation']['refundable'] = (isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable']) && ($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['@attributes']['Refundable'] == "true")) ? True : False;
    //                     //Airline Pnrs
    //                     if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']['@attributes'])){
    //                         $temp= [];
    //                         $temp = $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'];
    //                         $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] = [];
    //                         $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0] = $temp;
    //                     }
    //                     // print_r($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']);
    //                     if(isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) && count($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) > 0)
    //                     {
    //                         foreach($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $supplierkey => $suppliervalue) {
    //                             $airlineName = Airline::where('vendor_code' , $suppliervalue['@attributes']['SupplierCode'])->first();
    //                             $airlineName = $airlineName->short_name ?? '' ;
    //                             $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][$supplierkey]['@attributes']['airline_name'] = $airlineName;
    //                         }
    //                     }

    //                     $bookingController = new BookingController();
    //                     // $onlineTicketingDetails = $bookingController->OnlineTicketing($response , $tarceId);

                        
    //                     // $onlineTicketingresp['response'] = $onlineTicketingDetails['travelportResponse'];
    //                     $response3 = file_get_contents(public_path('response3.xml'));
    //                     $converted = XmlToArray::convert($response3, $outputRoot = false);
    //                     $response3 =[];
    //                     $onlineTicketing = $converted['SOAP:Body']['air:AirTicketingRsp'];
        
    //                     // $onlineTicketing = $onlineTicketingresp['response']['air:AirTicketingRsp'];

    //                     // $ticketrequestdetails = $onlineTicketingDetails['travelportRequest'];
    //                     $flightbookingdetails->ticket_travelport_request_id = 125;
    //                     // $flightbookingdetails->save();

    //                     // if($flightbookingdetails->user_type != 'web_guest')
    //                     // {
    //                     //     $userdetails = User::find($flightbookingdetails->user_id);
    //                     //     $user = $userdetails->first_name.' '.$userdetails->last_name;
    //                     // }
    //                     // else{
    //                     //     $user = 'Customer';
    //                     // }
    //                     $user = $tarvelersInfo[0]->first_name .' '.$tarvelersInfo[0]->last_name;

    //                     if(isset($onlineTicketing['air:TicketFailureInfo'])){
    //                         //tickting Failure
                            
    //                         $data['errorresponse'] ="Ticket failure";
    //                         //travelport request error response
    //                         //refund should initate
    //                         //redirect to error page

    //                         //mail should be triggred
    //                         $FlightBookingPassengersInfo = FlightBookingTravelsInfo::whereFlightBookingId($flightbookingdetails->id)->get();
    //                         Mail::send('front_end.email_templates.pending-ticket',compact('flightbookingdetails','user','FlightBookingPassengersInfo'), function($message) use($flightbookingdetails) {
    //                             $message->to($flightbookingdetails->email)
    //                                     ->subject('flightTicketPending');
    //                         });
                        
    //                         return view('front_end.error',compact('titles','data'));
    //                     }
    //                     else
    //                     {
    //                         $flightbookingdetails->ticket_status = 1;
    //                         $flightbookingdetails->save();
    //                         if(isset($onlineTicketing['air:ETR']['@attributes']))
    //                         {
    //                             $temp = [];
    //                             $temp = $onlineTicketing['air:ETR'];
    //                             $onlineTicketing['air:ETR'] = [];
    //                             $onlineTicketing['air:ETR'][0] = $temp; 
    //                         }
    //                         // foreach($onlineTicketing['air:ETR'] as $EtrKey=>$EtrVlaue)
    //                         // {
    //                         //     if(isset($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']))
    //                         //     $TravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where("title",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['Prefix'])->where("first_name",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['First'])->where("last_name",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['Last'])->first();
    //                         //     if(isset($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatus']))
    //                         //     {
    //                         //         $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatusDetails'] = TicketStatus($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatus']);
    //                         //     }
    //                         //     else{
    //                         //         $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatusDetails'] = "";
    //                         //     }
    //                         //     $travelerflightticketnumber = new FlightTicketNumber();
    //                         //     $travelerflightticketnumber->flight_booking_id = $flightbookingdetails->id;
    //                         //     $travelerflightticketnumber->ticket_number = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketNumber'];
    //                         //     $travelerflightticketnumber->flight_number = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['FlightNumber'];
    //                         //     $travelerflightticketnumber->ticket_status = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatus'];
    //                         //     $travelerflightticketnumber->from = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['Origin'];



    //                         //     $travelerflightticketnumber->save();

    //                         //     // $TravelerInfo->travel_port_ticket_status = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketStatus'];
    //                         //     // $TravelerInfo->travel_port_ticket_number = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketNumber'];
    //                         //     // $TravelerInfo->save();
                                

    //                         //     // $serachbaleKeyValue = $onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['@attributes']['Key'];

    //                         //     // $SerchableKey =  (array_search($serachbaleKeyValue,array_column(array_column($response['universal:UniversalRecord']['common_v52_0:BookingTraveler'],'@attributes'),'Key')));

    //                         //     // $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'][$SerchableKey]['common_v52_0:BookingTravelerName']['@attributes']['TicketNumber'] = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']['TicketNumber'];
    //                         // }
    //                         foreach($onlineTicketing['air:ETR'] as $EtrKey=>$EtrVlaue)
    //                         {
                                
    //                             if(isset($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket']['@attributes']))
    //                             {
    //                                 $temp = [];
    //                                 $temp = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'];
    //                                 $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'] =[];
    //                                 $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][0] = $temp;
    //                             }
    //                             foreach($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'] as $ticketKey =>$ticketValue){
    //                                 if(isset($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon']['@attributes'])){
    //                                     $temp = [];
    //                                     $temp = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon'];
    //                                     $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon'] =[];
    //                                     $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon'][0] = $temp;
    //                                 };
    //                                 foreach ($onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['air:Coupon'] as $ticketSegmentkey => $ticketSegmentValue) {
    //                                     $TravelerInfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where("title",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['Prefix'])->where("first_name",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['First'])->where("last_name",$onlineTicketing['air:ETR'][$EtrKey]['common_v52_0:BookingTraveler']['common_v52_0:BookingTravelerName']['@attributes']['Last'])->first();
    //                                     if(isset($TravelerInfo)){
    //                                         $travelerflightticketnumber = new FlightTicketNumber();
    //                                         $travelerflightticketnumber->flight_booking_id = $flightbookingdetails->id;
    //                                         $travelerflightticketnumber->flight_booking_travels_info_id = $TravelerInfo->id;
    //                                         $travelerflightticketnumber->ticket_number = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['@attributes']['TicketNumber'];
    //                                         $travelerflightticketnumber->ticket_status = $onlineTicketing['air:ETR'][$EtrKey]['air:Ticket'][$ticketKey]['@attributes']['TicketStatus'];
    //                                         $travelerflightticketnumber->from = $ticketSegmentValue['@attributes']['Origin'];
    //                                         $travelerflightticketnumber->to = $ticketSegmentValue['@attributes']['Destination'];
    //                                         $travelerflightticketnumber->carrier = $ticketSegmentValue['@attributes']['MarketingCarrier'];
    //                                         $travelerflightticketnumber->flight_number = $ticketSegmentValue['@attributes']['MarketingFlightNumber'];
    //                                         // $travelerflightticketnumber->save();
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                     // dd($response);

    //                     //formatting 

    //                     foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'] as $bk=>$bookinginfo){
    //                         //layover
    //                         $layover = null;
                            
    //                         if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk+1]))
    //                         {
    //                             if($flightbookingdetails->booking_type == 'roundtrip' && $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk]['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails']->airport_code == strtoupper($flightbookingdetails->to) )
    //                             {
    //                                 $layover = null ;
    //                             }
    //                             else{
    //                                 $layover = LayoverTime($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk]['@attributes']['segmentDetails']['@attributes']['ArrivalTime'] , $response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'][$bk+1]['@attributes']['segmentDetails']['@attributes']['DepartureTime']);
    //                             }
    //                         }
    //                         else
    //                         {
    //                             $layover = null;
    //                         }


    //                         $passengersList = [];
    //                         $flightNumber = $bookinginfo['@attributes']['segmentDetails']['@attributes']['FlightNumber'];
    //                         // $passengersInfo = FlightBookingTravelsInfo::leftjoin("flight_ticket_numbers","flight_booking_travels_infos.id","=","flight_ticket_numbers.flight_booking_travels_info_id")->where("flight_booking_travels_infos.flight_booking_id" , $flightbookingdetails->id)->where('flight_number',$flightNumber)->get();

    //                         $passengersInfo = FlightBookingTravelsInfo::leftjoin("flight_ticket_numbers","flight_booking_travels_infos.id","=","flight_ticket_numbers.flight_booking_travels_info_id")->where("flight_booking_travels_infos.flight_booking_id" , $flightbookingdetails->id)->where('flight_number',$flightNumber)->where('from',$bookinginfo['@attributes']['segmentDetails']['@attributes']['Origin'])->where('to',$bookinginfo['@attributes']['segmentDetails']['@attributes']['Destination'])->get();

                            
    //                         foreach ($passengersInfo as $TravelsInfo) {
    //                             if($TravelsInfo->traveler_type == 'ADT'){
    //                                 $TravelerType = "Adult";
    //                             }
    //                             elseif($TravelsInfo->traveler_type == 'CNN')
    //                             {
    //                             $TravelerType = "Child";
    //                             }
    //                             elseif($TravelsInfo->traveler_type == 'INF')
    //                             {
    //                             $TravelerType = "Infant";
    //                             }
    //                             else{$TravelerType = "Infant";}
    //                             $passengersList[] = array(
    //                                 'travelerType' => $TravelerType,
    //                                 'prefix' => $TravelsInfo->title,
    //                                 'firstName' => $TravelsInfo->first_name,
    //                                 'lastName' => $TravelsInfo->last_name,
    //                                 'ticketNumber' => $TravelsInfo->ticket_number,
    //                             );
                                
    //                         }

    //                         $segments[] =  array(
    //                             'OriginAirportDetails' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['OriginAirportDetails'],
    //                             'DestinationAirportDetails' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails'],
    //                             'DepartureDate' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['DepartureTime'],'date'),
    //                             'DepartureTime' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['DepartureTime'],'time'),
    //                             'ArrivalDate' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],'date'),
    //                             'ArrivalTime' => DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],'time'),
    //                             'Status' => ($bookinginfo['@attributes']['segmentDetails']['@attributes']['Status'] == 'HK') ? 'Confirmed' : 'Not - Confirmed', 
    //                             'Carrier' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['Carrier'],
    //                             'AirLine' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['airLineDetais'],
    //                             'FlightNumber' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['FlightNumber'],
    //                             'FlightTime' =>segmentTime($bookinginfo['@attributes']['segmentDetails']['@attributes']['TravelTime']),
    //                             'Refundable' => $response['universal:UniversalRecord']['air:AirReservation']['refundable'],
    //                             'FlightName' => (isset($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']) && !empty($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails'])) ?$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']->short_name : $bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['Equipment'],
    //                             'Class' => $bookinginfo['@attributes']['segmentDetails']['@attributes']['CabinClass'],
    //                             'CheckIn' => $bookinginfo['@attributes']['baggageDetails'],
    //                             'Layover' => $layover,
    //                             'passengersList' => $passengersList,
    //                         );
            
    //                     }
                        
    //                     // $passengersList = [];
    //                     // foreach ($response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] as $TravelsInfo) {
    //                     //     if($TravelsInfo['@attributes']['TravelerType'] == 'ADT'){
    //                     //         $TravelerType = "Adult";
    //                     //     }
    //                     //     elseif($TravelsInfo['@attributes']['TravelerType'] == 'CNN')
    //                     //     {
    //                     //     $TravelerType = "Child";
    //                     //     }
    //                     //     elseif($TravelsInfo['@attributes']['TravelerType'] == 'INF')
    //                     //     {
    //                     //     $TravelerType = "Infant";
    //                     //     }
    //                     //     else{$TravelerType = "Infant";}
    //                     //     $passengersList[] = array(
    //                     //         'travelerType' => $TravelerType,
    //                     //         'prefix' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Prefix'],
    //                     //         'firstName' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['First'],
    //                     //         'lastName' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Last'],
    //                     //         'ticketNumber' => $TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['TicketNumber'],
    //                     //     );
                            
    //                     // }
    //                     // $result['passengersList'] = $passengersList;
    //                     $result['segments'] = $segments;
    //                     $result['flightBookingDetails'] = $flightbookingdetails;
    //                     if(!isset($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']))
    //                     {
    //                         //pnr not generated
    //                         //Some airline hosting systems are unable to process all the requests at the same time, hence the vendor locator is not assigned (in some cases) straight away to the PNR.

    //                         // As per TVP recommendations, an agent should wait up to 2 hours for the vendor locator until reporting it as an issue.
    //                         $airlinePnr[0] = array('pnr' => '---' , 'airline' => '---');
    //                     }

    //                     elseif(count($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator']) == 1 )
    //                     {
    //                         $airlinePnr[0] = array('pnr' => $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0]['@attributes']['SupplierLocatorCode'] , 'airline' => $response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'][0]['@attributes']['airline_name']);
    //                     }
    //                     else{
    //                         foreach($response['universal:UniversalRecord']['air:AirReservation']['common_v52_0:SupplierLocator'] as $supplierCode)
    //                         {
    //                             $airlinePnr[] = array('pnr' => $supplierCode['@attributes']['SupplierLocatorCode'] , 'airline' => $supplierCode['@attributes']['airline_name']);
            
    //                         }
    //                     }
    //                     $result['airLinePnrs'] = $airlinePnr;
    //                     $result['user'] = $user;

    //                 // }
                    
                    
    //                 $extrabaggageinfo = FlightBookingTravelsInfo::where("flight_booking_id" , $flightbookingdetails->id)->where(function ($query) {
    //                     $query->where('depature_extra_baggage', '!=', '')
    //                           ->orWhere('return_extra_baggage', '!=', '');
    //                 })->get();
    
    //                 $result['extrabaggageinfo'] = $extrabaggageinfo;
    //                  return view('front_end.email_templates.ticket',compact('titles','result'));

    //                 $filename = "Ticket_".$flightbookingdetails->booking_ref_id.".pdf";
    //                 $pdf = PDF::loadView('front_end.email_templates.ticket', compact('titles','result'));
    //                 $pdf->save('pdf/tickets/' . $filename);

    //                 $completePath = 'pdf/tickets/' . $filename;
    //                 $flightbookingdetails->flight_ticket_path = $completePath;
    //                 $flightbookingdetails->save();

    //                 Mail::send('front_end.email_templates.ticket', compact('titles','result'), function($message)use($pdf,$flightbookingdetails,$filename) {
    //                     $message->to($flightbookingdetails->email)
    //                             ->subject('flightTicket')
    //                             ->attachData($pdf->output(), $filename);
    //                 });

    //                 $this->invoice($result,$user,$flightbookingdetails);
    
    //                 return view('front_end.air.booking_flight_itinerary',compact('titles','result'));
    
    //             // }
    //             // else{
    //             //     //if not paid or expired

    //             //     $data['errorresponse'] = $invoicedata['Data']->InvoiceStatus;
    //             //     //travelport request error response
    //             //     //refund should initate
    //             //     //redirect to error page

    //             //     return view('front_end.error',compact('titles','data'));
    //             // }
    //         // }

    //     // }

    // }

    public function getURPnrInfo(){

        $booking = new BookingController();
        //universalLocatorCode = L44ZMA //in prod
        //ProviderLocatorCode = 6QRJPZ //in dev
        echo "L44ZMA";
        $data = ['universalPnr' => 'L44ZMA','traceId' => '41495'];
        $searchResponse = $booking->getTravelportUniversalRecord($data);
        dd($searchResponse);

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
    private function refund($bookingId)
    {
        $flightbookingdetails = FlightBooking::find($bookingId);
    
        $flightbookingdetails->booking_status = "refund_initiated";
        $flightbookingdetails->save();
    
        if($flightbookingdetails->type_of_payment == 'wallet'){
            $wallet = auth()->user()->wallet_balance + $flightbookingdetails->sub_total;
            auth()->user()->update(['wallet_balance' => $wallet]);
            $walletDetails = WalletLogger::create([
                'user_id' => auth()->user()->id,
                'reference_id' => $flightbookingdetails->id,
                'reference_type' => 'flight',
                'amount' => $flightbookingdetails->sub_total,
                'remaining_amount' => $wallet,
                'amount_description' => 'KWD '.$flightbookingdetails->sub_total .' refunded for booking id '.$flightbookingdetails->booking_ref_id,
                'action' => 'added',
                'status' =>'Active',
                'date_of_transaction' => Carbon::now()
            ]);
            $walletDetails->unique_id = 'WL'.str_pad($walletDetails->id, 7, '0', STR_PAD_LEFT);
            $walletDetails->save();
            $flightbookingdetails->booking_status = "refund_completed";
            $flightbookingdetails->save();
        }
    
    }
}