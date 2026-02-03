<?php

namespace App\Http\Controllers;


use Exception;
use XMLReader;
use App\Models\City;
use App\Models\Role;
use SimpleXMLElement;
use GuzzleHttp\Client;
use App\Models\Airport;
use Illuminate\Http\Request;
use App\Models\HotelXmlRequest;
use App\Models\TravelportRequest;
use Illuminate\Support\Facades\DB;
use App\Models\FlightBookingSearch;
use Illuminate\Support\Facades\Http;
use Mtownsend\XmlToArray\XmlToArray;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $commonXmlns = 'http://www.travelport.com/schema/common_v52_0';

    public $airXmlns = 'http://www.travelport.com/schema/air_v52_0';

    public $universalXmlns ='http://www.travelport.com/schema/universal_v52_0';

    public $soapenvelope ='http://schemas.xmlsoap.org/soap/envelope/';

    public $w3Org = 'http://www.w3.org/2001/XMLSchema';

    public $Jsonheaders = [
        'Accept'        => '*/*',
        'Content-Type' => 'application/json',
        'Connection'=> 'Keep-Alive',"Accept-Encoding"=> "gzip, deflate, br",
    ];




    public $TragetBranch ;
    public $UAPIUrl ;
    public $UAPIUniversalRecordUrl ;
    public $UAPIUsername ;
    public $UAPIPassword;
    public $AirArabiaUsername ;
    public $AirArabiaPassword ;
    //airArabia
    public $AirarabiaAPIUrl ;
    public $AirarabiaCompanyCode;


    /*Jazeera*/
    public $jazeeraApiUrl;
    public $jazeeraUsername;
    public $jazeeraPassword;
    public $jazeeraDomain;
    public $jazeeraChannelType;
    public $jazeeraApplicationName;
    public $jazeeraOrganizationNumber;
    public $jazeeraPaymentUrl;
    public $jazeeraPaymentID;
    public $jazeeraPaymentPassword;

    /*Jazeera*/

    //Production
    // public $TragetBranch = 'P4268617';
    // public $UAPIUrl = 'https://emea.universal-api.travelport.com/B2BGateway/connect/uAPI/AirService';
    // public $UAPIUsername = 'Universal API/uAPI1478120433-05e19f6a';
    // public $UAPIPassword = '3k!Yw&X5P2';
    // public $AirArabiaUsername = 'APIMASILAGROUPG9';
    // public $AirArabiaPassword = 'pass1234';
    //airArabia
    // public $AirarabiaAPIUrl = 'https://reservations.airarabia.com/webservices/services/AAResWebServices';
    // public $AirarabiaCompanyCode = 'KWI649';


    // WEBBEDS
    public $WebbedsUrl;
    public $WebbedsUsername ;   
    public $WebbedsPassword ;
    public $WebbedsCompanyCode;

    // Dida
    public $didaUrl;
    public $didaUsername ;   
    public $didaPassword ;
    public $didaCompanyCode;
    public $didaAuthToken;
    public $didaStatic;




    public function __construct()
    {
        $this->TragetBranch = env('TARGET_BRANCH');
        $this->UAPIUrl = env('UAPI_URL');
        $this->UAPIUniversalRecordUrl = env('UAPI_UNIVERSAL_RECORD_URL');

        $this->UAPIUsername = env('UAPI_USER_NAME');
        $this->UAPIPassword = env('UAPI_PASSWORD');
        //airarabia
        $this->AirArabiaUsername = env('AIR_ARABIA_USER_NAME');
        $this->AirArabiaPassword = env('AIR_ARABIA_PASSWORD');
        //airArabia
        $this->AirarabiaAPIUrl = env('AIR_ARABIA_API_URL');
        $this->AirarabiaCompanyCode = env('AIR_ARABIA_COMPANY_CODE');

        //Jazeera Airways
        // Initialize class properties from environment variables
        $this->jazeeraApiUrl            = env('JAZEERA_URL');
        $this->jazeeraUsername          = env('JAZEERA_USERNAME');
        $this->jazeeraPassword          = env('JAZEERA_PASSWORD');
        $this->jazeeraDomain            = env('JAZEERA_DOMAIN');
        $this->jazeeraChannelType       = env('JAZEERA_CHANNEL_TYPE');
        $this->jazeeraApplicationName   = env('JAZEERA_APPLICATION_NAME');
        $this->jazeeraOrganizationNumber= env('JAZEERA_ORGANIZATION');
        $this->jazeeraPaymentUrl        = env('JAZEERA_PAYMENT_URL');
        $this->jazeeraPaymentID         = env('JAZEERA_PAYMENT_ID');
        $this->jazeeraPaymentPassword   = env('JAZEERA_PAY_PASS');


        // WEBBEDS
        $this->WebbedsUrl               = env('WEBBEDS_URL');
        $this->WebbedsUsername          = env('WEBBEDS_USERNAME');
        $this->WebbedsPassword          = md5(env('WEBBEDS_PASSWORD'));
        $this->WebbedsCompanyCode       = env('WEBBEDS_COMPANYCODE');

        // DIDA
        $this->didaUrl               = env('DIDA_URL');
        $this->didaStatic            = env('DIDA_STATIC');
        $this->didaUsername          = env('DIDA_USERNAME');
        $this->didaPassword          = env('DIDA_PASSWORD');
        $this->didaCompanyCode       = env('DIDA_COMPANYCODE');
        $didaCredentials = $this->didaUsername . ':' . $this->didaPassword;
        $encoded = base64_encode($didaCredentials);
        $this->didaAuthToken         = $encoded;
      
        
    }

    public function TravelportAirApi($request)
    {
        $travelportRequestUrl = (isset($request['request_type'])&& ($request['request_type']=='universalRecordRetrieve')) ? $this->UAPIUniversalRecordUrl:$this->UAPIUrl;

        try {
            $client = new Client();
            $response = $client->request('POST', $travelportRequestUrl, [
            'headers' => [
            'Content-Type' => 'text/xml; charset=UTF8',
            "Accept"=> "application/xml",
            "SOAPAction" => '\"\"',
            "Accept-Encoding" => "gzip,deflate",
            ],
            'auth' => [$this->UAPIUsername, $this->UAPIPassword],
            'body' => $request['xml'],
            'verify' => false
            ])->getBody()->getContents();

            $responseArray = XmlToArray::convert($response, $outputRoot = false);
       

            //TravelportRequest data insert
            $dataTravelportRequest = new TravelportRequest;
            $dataTravelportRequest->request_xml    = $request['xml'];
            $dataTravelportRequest->response_xml = $response;
            $dataTravelportRequest->ip_address = $_SERVER['REMOTE_ADDR'];
            $dataTravelportRequest->trace_id = $request['trace_id'];
            $dataTravelportRequest->request_type = $request['request_type'];
            $dataTravelportRequest->supplier = 'travelport';
            $dataTravelportRequest->save();

            if(isset($responseArray['SOAP:Body']['SOAP:Fault']))
            {
                //redirection code
            }
            return $travelportResponse = [
                'travelportResponse' => $responseArray['SOAP:Body'],
                'travelportRequest' => $dataTravelportRequest
            ];

          } catch (\Exception $e) {

            return $travelportResponse = [
                'travelportResponse' => [],
                'travelportRequest' => []
            ];
          }


    }

    //airArabia
    public function AirArabiaApi($request)
    {
        $transactionIdentifier = null;
        try {
            $headers = array(
                'Content-Type' => 'text/xml; charset=UTF8',
                "Accept"=> "application/xml",
                "SOAPAction" => '\"\"',
                "Accept-Encoding" => "gzip,deflate",
                "User-Agent" => $_SERVER['HTTP_USER_AGENT']
            );
            if($request['request_type'] != 'search')
            {
                $xmlpreviousrequest = TravelportRequest::where('transactionIdentifier' , $request['transactionIdentifier'])->first();
                //dd($xmlpreviousrequest);
                $jsessionid = $xmlpreviousrequest->jsessionid;
                $headers['Cookie'] = "JSESSIONID=".$jsessionid;
            }
            $client = new Client();
            $requestData = ['headers' => $headers,'body' => $request['xml'],'verify' => false];
            if($request['request_type'] == 'search' && env('APP_ENV') != 'prod')
            {
                $requestData['connect_timeout'] = 30;
            }
            $clientrsp = $client->request('POST', $this->AirarabiaAPIUrl, $requestData);
            $response = $clientrsp->getBody()->getContents();
            $responseArray = XmlToArray::convert($response, $outputRoot = false);
            if($request['request_type'] == 'search')
            {
                $responseHeader = $clientrsp->getHeaders();
                $jsessionidheader = $responseHeader['set-cookie'][0]??'';
                //$jsessionidheader = (env('APP_ENV') == 'prod') ? $responseHeader['Set-Cookie'][0]??'' : $responseHeader['set-cookie'][0]??'';
                $jsessionidh = explode(';',$jsessionidheader);
                $jsessionidstring =  $jsessionidh[0];
                $jsessionidrray = explode('=',$jsessionidstring);
                $jsessionid = $jsessionidrray[1]??'';

                if(!isset($responseArray['soap:Body']['ns1:OTA_AirAvailRS']['ns1:Errors']['ns1:Error']))
                {
                    $transactionIdentifier = $responseArray['soap:Body']['ns1:OTA_AirAvailRS']['@attributes']['TransactionIdentifier'];
                }
            }
            elseif($request['request_type'] == 'airPricing')
            {
                if(!isset($responseArray['soap:Body']['ns1:OTA_AirPriceRS']['ns1:Errors']['ns1:Error']))
                {
                    $transactionIdentifier = $responseArray['soap:Body']['ns1:OTA_AirPriceRS']['@attributes']['TransactionIdentifier'];
                }
            }elseif($request['request_type'] == 'ticketing'){
                if(!isset($responseArray['soap:Body']['ns1:OTA_AirBookRS']['ns1:Errors']['ns1:Error']))
                {
                    $transactionIdentifier = $responseArray['soap:Body']['ns1:OTA_AirBookRS']['@attributes']['TransactionIdentifier'];
                }

            }

            //TravelportRequest data insert
            $dataTravelportRequest = new TravelportRequest;
            $dataTravelportRequest->request_xml    = $request['xml'];
            $dataTravelportRequest->response_xml = $response;
            $dataTravelportRequest->ip_address = $_SERVER['REMOTE_ADDR'];
            $dataTravelportRequest->trace_id = $request['trace_id'];
            $dataTravelportRequest->request_type = $request['request_type'];
            $dataTravelportRequest->supplier = 'airarabia';
            $dataTravelportRequest->jsessionid = $jsessionid;
            $dataTravelportRequest->transactionIdentifier = $transactionIdentifier;
            $dataTravelportRequest->save();

            if(isset($responseArray['soap:Body']['soap:Fault']))
            {
                //redirection code
            }
            return $travelportResponse = [
                'travelportResponse' => $responseArray['soap:Body'],
                'travelportRequest' => $dataTravelportRequest
            ];

          } catch (\Exception $e) {

               return $travelportResponse = [
                'travelportResponse' => [],
                'travelportRequest' => []
            ];
          }


    }

    /*Jazeera Airways function Starts*/

    public function postMethodForJazeera($requests)
    {

        if (isset($requests['requestFrom']) && $requests['requestFrom'] === "MOBILE") {
            if (isset($requests['tokenData'])) {
                $tokenData = $requests['tokenData'];
                $currentTime = time();
                $expirationTime = $tokenData['expiration_time'];
                $idleTimeout = $tokenData['idle_timeout'];
                
                // Check if the tokenData's expiration time is valid
                if ($expirationTime > $currentTime) {
                    // Update the expiration_time to the next 15 minutes
                    $newExpirationTime = $currentTime + ($idleTimeout * 60);
                    $tokenData['expiration_time'] = $newExpirationTime;
                    $token = $tokenData;
                } else {
                    // Token has expired, generate a new token and update tokenData
                    $token = $this->generateToken();
                }
            } else {
                // Token data not available, generate a new token and update tokenData
                $token = $this->generateToken();
            }
        }else{
            $token = $this->getToken();
            // Check if the token is valid or needs regeneration
            if (!$this->isTokenValid($token)) {
                $token = $this->generateToken();
                $this->storeToken($token);
            }
            // Update the last activity time
            $this->updateLastActivityTime();
        }
        
         // Check if it's a single request or an array of requests
        if (is_array($requests) && isset($requests['types']) && $requests['types']==="parallel"){
            // Handle parallel
            $responses = [];
            $client = new \GuzzleHttp\Client();
            // Create an array to store the parallel requests
            $promises = [];

            // Loop through each request
            $requests = array_slice($requests, 1);
            
            foreach ($requests as $request) {
                if(isset($request['jsonRequest'])){
                    $searchParams   = json_encode($request['jsonRequest']);
                    $endpoint       = $this->jazeeraApiUrl . $request['endpoint'];
                    $traceId        = $request['trace_id'];
                    
                    // Create a promise for each request
                    $promise = $client->postAsync($endpoint, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $token['token'],
                            'AgentID' => ((env('APP_ENV') == 'prod') ? $this->jazeeraUsername :$this->jazeeraPaymentID), // $this->jazeeraUsername
                        ],
                        'body' => $searchParams,
                    ]);

                    // Add the promise to the array
                    //$promises[] = $promise;
                    $traceIdMap[] = ['promise' => $promise, 'trace_id' => $traceId];
                }
            }

            // Wait for all promises to resolve
            //$responses = \GuzzleHttp\Promise\Utils::unwrap($promises);
            $responses = \GuzzleHttp\Promise\Utils::unwrap(array_column($traceIdMap, 'promise'));


            // Process the responses
            $travelportResponse = [];

            foreach ($responses as $key => $response) {
                try {
                    $request = $requests[$key]; // Retrieve the corresponding request
                    $traceId = $traceIdMap[$key]['trace_id'];
                    $responseBody = $response->getBody()->getContents();
                    $responseData = json_decode($responseBody, true);

                    if (isset($responseData['data'])) {
                        $jazeeraResponse = $responseData['data'];
                    } elseif (isset($responseData['addPassengerResponse'])) {
                        $jazeeraResponse = $responseData;
                    } else {
                        // Handle the case when neither 'data' nor 'booking' key is present
                        $jazeeraResponse = null; // or handle it as per your requirement
                    }

                    if ($requests['requestFrom'] === "MOBILE" && $request['endpoint']==="BookingQuote") {

                        $requestBody = $request;
                        $requestBody['tokenData'] = $token;
                        $request = $requestBody;
                      
                        
                    }

                    // Insert request and response to travelport_request table
                    $this->insertTravelportJazeeraRequest($request, $responseData);

                    $travelportResponse[] = [
                        'jazeeraResponse' => $jazeeraResponse,
                        'jazeeraRequest' => $searchParams,
                        'trace_id'      => isset($traceId) ? $traceId : null,
                        'tokenData'     => $token,
                    ];
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    // Handle request exception or error response
                    $response = $e->getResponse();
                    $statusCode = $response->getStatusCode();
                    $errorBody = $response->getBody()->getContents();
                    $responseData = json_decode($errorBody, true);
                    $travelportResponse[] = [
                        'jazeeraResponse' => $responseData,
                        'jazeeraRequest' => $searchParams,
                        //'error' => $e->getMessage(),
                    ];
                }
            }
            //dd($travelportResponse);
            return $travelportResponse;
        }else{
                //handle single request
                $searchParams   = json_encode($requests['jsonRequest']);
                if($requests['endpoint']==="bspcash/pay"){
                    $endpoint       = $this->jazeeraPaymentUrl . $requests['endpoint'];
                }else{
                    $endpoint       = $this->jazeeraApiUrl . $requests['endpoint'];
                }


                $httpClient     = new \GuzzleHttp\Client();
                try {
                    if(!empty($token)){
                        $response = $httpClient->post($endpoint, [
                            'headers' => [
                                'Content-Type'  =>  'application/json',
                                'Authorization' =>  'Bearer ' . $token['token'],
                                'AgentID'       =>   ((env('APP_ENV') == 'prod') ? $this->jazeeraUsername :$this->jazeeraPaymentID), //$this->jazeeraUsername
                            ],
                            'body' => $searchParams,
                        ]);

                        $responseBody   = $response->getBody()->getContents();
                        $responseData   = json_decode($responseBody, true);
                        //$searchData     = $responseData['data'];
                         /*Insert request and response to travelport_request table */
                        $this->insertTravelportJazeeraRequest($requests, $responseData);
                        /*End*/

                         return $travelportResponse = [
                            'jazeeraResponse'   => isset($responseData['data']) ? $responseData['data'] : $responseData,
                            'jazeeraRequest'    => $searchParams,
                            'trace_id'          => isset($requests['trace_id']) && !empty($requests['trace_id']) ? $requests['trace_id'] : null,
                            'tokenData'         => $token,
                        ];
                    }
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    $response       = $e->getResponse();
                    $statusCode     = $response->getStatusCode();
                    $errorBody      = $response->getBody()->getContents();
                    $responseData   = json_decode($errorBody, true);
                    if($requests['endpoint']==="Booking/CommitBooking" || $requests['endpoint']==="bspcash/pay"){
                        $this->insertTravelportJazeeraRequest($requests, $responseData);
                    }
                    return $travelportResponse = [
                        'jazeeraResponse' => $responseData,
                        'jazeeraRequest' => $searchParams
                    ];
                    //echo "Error status code: " . $statusCode . "\n";
                    //echo "Error response: " . $errorBody . "\n";
                    // Handle the request exception or error response
                    //throw new \Exception('Failed to perform the flight search: ' . $errorBody);
               }
        }

    }


    //GET REQUEST
    public function getMethodForJazeera($request,$endpoint,$extraInfo)
    {
         if (isset($extraInfo) && $extraInfo['requestFrom'] === "MOBILE") {
            $token = $extraInfo['tokenData'];
            if(!empty($token)){
                $token = $token ;
            }else{
                $token = $this->generateToken();
            }
        }else{
            $token = $this->getToken();
            // Check if the token is valid or needs regeneration
            if (!$this->isTokenValid($token)) {
                $token = $this->generateToken();
                $this->storeToken($token);
            }
            // Update the last activity time
            $this->updateLastActivityTime();    
        }
        

        $endpoint = $this->jazeeraApiUrl . $endpoint;

        $httpClient = new \GuzzleHttp\Client();

        try {
            $response = $httpClient->get($endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token['token'],
                    'AgentID' => ((env('APP_ENV') == 'prod') ? $this->jazeeraUsername :$this->jazeeraPaymentID),
                ],
                'query' => $request,
            ]);

            $responseBody = $response->getBody()->getContents();
            $responseData   = json_decode($responseBody, true);



            return [
                'jazeeraResponse' => $responseData,
                'token' => $token,
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorBody = $response->getBody()->getContents();
            $responseData = json_decode($errorBody, true);

            return [
                'jazeeraResponse' => $responseData
            ];

            // Handle the request exception or error response
            // throw new \Exception('Failed to perform the currency conversion: ' . $errorBody);
        }
    }

    public function deleteTokenForJazeera($request)
    {

        if(isset($request) && !empty($request) && $request['requestFrom']=="MOBILE"){
            $token      =  $request['tokenData'];
        }else{
            $token      = session('airjazeera_token');    
        }
        
        $endpoint   = $this->jazeeraApiUrl . 'Token';

        if (!empty($token)) {
            $httpClient = new \GuzzleHttp\Client();

            try {
                $response = $httpClient->delete($endpoint, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token['token'],
                    ],
                ]);
                session()->forget('airjazeera_token');
                session()->forget('last_activity_time');
                return true;
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                return false;
                // Handle the request exception or error response
                // throw new \Exception('Failed to perform the currency conversion: ' . $errorBody);
            }
        }

    }




    public function insertTravelportJazeeraRequest($requests, $responseBody)
    {
        if(isset($requests['tokenData'])){
            $responseBody['tokenData'] = $requests['tokenData'];
        }
        $searchParams                               = json_encode($requests['jsonRequest']);
        $travelportRequest                          = new TravelportRequest();
        $travelportRequest->request_xml             = "";
        $travelportRequest->response_xml            = "";
        $travelportRequest->json_request            = $searchParams;
        $travelportRequest->json_response           = json_encode($responseBody);
        $travelportRequest->ip_address              = $_SERVER['REMOTE_ADDR'];
        $travelportRequest->trace_id                = $requests['trace_id'];
        $travelportRequest->request_type            = $requests['request_type'];
        $travelportRequest->supplier                = 'jazeera';
        $travelportRequest->jsessionid              = null;
        $travelportRequest->transactionIdentifier   = null;
        $travelportRequest->save();
    }

    public function getToken()
    {
        $token = session('airjazeera_token');

        if (!$token) {
            // If the token is not found in the session, generate a new one
            $token = $this->generateToken();
            $this->storeToken($token);
        }

        return $token;
    }

    public function isTokenValid($token)
    {
        if (!empty($token)) {
            $expirationTime = $token['expiration_time'];
            $idleTimeout = $token['idle_timeout'];
            $lastActivityTime = $this->getLastActivityTime();
            $currentTime = time();

            // Calculate the expiration time based on the idle timeout and last activity time
            $effectiveExpirationTime = $lastActivityTime + ($idleTimeout * 60);

            return $expirationTime > $currentTime && $effectiveExpirationTime > $currentTime;
        }
    }

    public function generateToken()
    {

        // $credentials = [
        //     "userName" => $this->jazeeraPaymentID, // $this->jazeeraUsername
        //     "password" => $this->jazeeraPaymentPassword,
        //     "domain" => $this->jazeeraDomain,
        //     "channelType" => $this->jazeeraChannelType,
        // ];
        $credentials = [
            "userName" => ((env('APP_ENV') == 'prod') ? $this->jazeeraUsername :$this->jazeeraPaymentID), 
            "password" => ((env('APP_ENV') == 'prod') ? $this->jazeeraPassword :$this->jazeeraPaymentPassword), 
            "domain" => $this->jazeeraDomain,
            "channelType" => $this->jazeeraChannelType,
        ];
        $requestData = [
            "credentials" => $credentials,
            "applicationName" => $this->jazeeraApplicationName
        ];

        // Convert the request data to JSON
        $requestDataJson = json_encode($requestData);

        // Send a login request to the Air Jazeera API
        $response = $this->loginToAirJazeera($requestDataJson);

        // Check if the login was successful
        if ($response && isset($response['data']['token'])) {
            // Extract the token and idle timeout from the response
            $token = $response['data']['token'];
            $idleTimeoutInMinutes = $response['data']['idleTimeoutInMinutes'];

            // Create a token array with the expiration time and idle timeout
            $expirationTime = time() + ($idleTimeoutInMinutes * 60);
            $tokenData = [
                'token' => $token,
                'expiration_time' => $expirationTime,
                'idle_timeout' => $idleTimeoutInMinutes,
            ];

            return $tokenData;
        }
        return null;
        // Handle the error case if the login was unsuccessful
        //throw new Exception('Failed to generate a token for Air Jazeera.');
    }


    private function storeToken($token)
    {
        if ($token !== null && isset($token['expiration_time'])) {
            session(['airjazeera_token' => $token]);
        }
    }


    private function getLastActivityTime()
    {
        // Retrieve the last activity time from session
        return session('last_activity_time', time());
    }

    private function updateLastActivityTime()
    {
        // Update the last activity time to the current time
        // Adjust the update mechanism based on your application architecture

        session(['last_activity_time' => time()]);
    }

    private function loginToAirJazeera($requestDataJson)
    {
        $endpoint = $this->jazeeraApiUrl . 'Token';
        // Send a login request to the Air Jazeera API
        $httpClient = new \GuzzleHttp\Client();

        try {
            $response = $httpClient->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $requestDataJson,
            ]);

            $responseData = json_decode($response->getBody(), true);
            return $responseData;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle the request exception or error response
            //throw new Exception('Failed to login to Air Jazeera: ' . $e->getMessage());
            return null;
        }

    }
    /*Jazeera Function end*/


    /*Call from here*/

    public function AirportDetails($airportcode)
    {

        //array_push($ap,$airportcode);
        $airportDetails = Airport::
        select('airports.name','cities.name as city_name','countries.name as country_name','airports.airport_code')->
        leftJoin('cities' , 'cities.city_code', '=' , 'airports.reference_city_code')
        ->leftJoin('countries' , 'countries.country_code', '=' , 'airports.country_code')
        ->where(function($query) use($airportcode)
        {
            $query->where('airports.airport_code', $airportcode);
        })->first();
        return $airportDetails;
    }

    public function CityDetails($cityCode)
    {
        $airportDetails = City::
        select('cities.name as city_name','countries.name as country_name','associated_airports')
        ->leftJoin('countries' , 'countries.country_code', '=' , 'cities.country_code')
        ->where(function($query) use($cityCode)
        {
            $query->where('cities.city_code', $cityCode);
        })->first();
        return $airportDetails;
    }

    public function CityByAirportCodeDetails($airportCode)
    {
        $airportDetails = City::
        select('cities.name as city_name','countries.name as country_name','associated_airports')
        ->leftJoin('countries' , 'countries.country_code', '=' , 'cities.country_code')
        ->where(function($query) use($airportCode)
        {
            $query->where('cities.associated_airports', 'like', "%$airportCode%");
        })->first();
        return $airportDetails;
    }


    public function detachRole($user)
    {
        // Grab all the Roles and detach first
        $allRoles = Role::all();
        $user->roles()->detach($allRoles);
        return true;
    }



    function TBOApi($url="",$method="get",$data=null)
    {
        // $headers =[
        //     'Accept'        => '*/*',
        //     'Content-Type' => 'application/json',
        //     'Connection'=> 'Keep-Alive',"Accept-Encoding"=> "gzip, deflate, br",
        // ];
        $response = Http::withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))->withHeaders([$this->Jsonheaders])->withOptions(['verify' => false]);
        if($method=='get')
        {
            $response = $response->get($url);
        }
        elseif($method=='post'){
            $response = $response->post($url,$data);
        }
        $response = $response->json();
       // dd($response);
        return(($response));
    }

    public function storeSearchData($request){

        $FlightBookingSearch = new FlightBookingSearch();
        $FlightBookingSearch->user_id = auth()->user() ? auth()->user()->id : null;
        $FlightBookingSearch->flight_trip = $request->input('flight-trip');
        $FlightBookingSearch->flight_from = $request->input('flightFrom');  
        $FlightBookingSearch->flight_from_airport_code = $request->input('flightFromAirportCode');   
        $FlightBookingSearch->flight_to = $request->input('flightTo');
        $FlightBookingSearch->flight_to_airport_code = $request->input('flightToAirportCode');  
        $FlightBookingSearch->departure_date = $request->input('DepartDate');        
        $FlightBookingSearch->return_date = $request->input('ReturnDate') ?? null;
        $FlightBookingSearch->flight_travellers_class = $request->input('flight_travellers_class');  
        $FlightBookingSearch->noof_adults = $request->input('noofAdults') ?? null;   
        $FlightBookingSearch->noof_children = $request->input('noofChildren') ?? null;
        $FlightBookingSearch->noof_infants = $request->input('noofInfants') ?? null;  
        $FlightBookingSearch->flight_class = $request->input('flight-class') ?? null;  
        $FlightBookingSearch->ip_address = $_SERVER['REMOTE_ADDR'] ;  
        $FlightBookingSearch->request_json = json_encode($request->input());
        $FlightBookingSearch->request_url = $request->fullUrl();
        $FlightBookingSearch->save();
        return $FlightBookingSearch->id;
    }


    public function XmlRequestWithoutLog($request)
    {
        set_time_limit(300); 
        try {
            $headers = array(
                "Accept"=> "application/xml",
            );
            $client = new Client();
            $requestData = ['headers' => $headers,'body' => $request['xml'],'verify' => false];
            
            $clientrsp = $client->request('POST', $this->WebbedsUrl, $requestData);
            $response = $clientrsp->getBody()->getContents();

            $responseArray = XmlToArray::convert($response, $outputRoot = false);

            return $travelportResponse = [
                'hotels' => $responseArray['hotels'],
                'success' => $responseArray['successful']
            ];

          } catch (\Exception $e) {

               return $travelportResponse = [
                 'hotels' => [],
                'success' => false
           
            ];
          }
    }
    

    // public function WebbedsApi($request)
    // {
    //     //dd($request);
    //     set_time_limit(300); 
    //     try {
    //         $headers = array(
    //             "Accept"=> "application/xml",
    //             "Accept-Encoding" => "gzip, deflate"
    //         );
    //         $client = new Client();
    //         $requestData = ['headers' => $headers,'body' => $request['xml'],'verify' => false];
            
    //         $clientrsp = $client->request('POST', $this->WebbedsUrl, $requestData);
    //         $response = $clientrsp->getBody()->getContents();
    //         if(isset($request['request_type']) && ($request['request_type'] == 'confirmBooking' || $request['request_type'] == 'getbookingdetails' || $request['request_type'] == 'getRooms'|| $request['request_type'] == 'getRoomsWithBlocking')){

    //            $array =  XmlToArrayWithHTML($response);
    //         }else{
    //             $xml = simplexml_load_string($response);
    //             $array = json_decode(json_encode($xml), true);
    //         }
        

    //         // // Now you can use it like a normal array
    //         //   dd($array);


    //         // $responseArray = XmlToArray::convert($response, $outputRoot = false);
           
    //         //    SimpleXMLElement 

    //         //TravelportRequest data insert
    //         $HotelXmlRequest = new HotelXmlRequest;
    //         $HotelXmlRequest->request_xml    = $request['xml'];
    //         $HotelXmlRequest->response_xml = $response;
    //         $HotelXmlRequest->ip_address = $_SERVER['REMOTE_ADDR'];
    //         $HotelXmlRequest->request_type = $request['request_type'] ??null;
    //         $HotelXmlRequest->supplier = 'webbeds';
    //         $HotelXmlRequest->hotel_search_id = $request['searchId']??null;

    //         $HotelXmlRequest->save();
         
    //         return $hotelResponse = [
    //             'hotelResponse' => $array,
    //             'hotelRequest' => $HotelXmlRequest
    //         ];

    //       } catch (\Exception $e) {

    //         return $hotelResponse = [
    //             'hotelResponse' => [],
    //             'hotelRequest' => []
    //         ];
    //       }


    // }
    public function WebbedsApi(array $request)
    {
        set_time_limit(400);

        try {
            // Prepare request headers
            $headers = [
                'Accept'          => 'application/xml',
                'Accept-Encoding' => 'gzip, deflate'
            ];

            // Initialize Guzzle client and send request
            $client = new Client();
            $clientResponse = $client->request('POST', $this->WebbedsUrl, [
                'headers'         => $headers,
                'body'            => $request['xml'] ?? '',
                'verify'          => false,
                'timeout'         => 60, // Set 60 seconds timeout
                'connect_timeout' => 10  // Optional: 10 sec max to establish connection
            ]);

            $responseContent = $clientResponse->getBody()->getContents();

            // Parse response based on request type
            $specialRequestTypes = ['confirmBooking', 'getbookingdetails', 'getRooms', 'getRoomsWithBlocking'];
            if (!empty($request['request_type']) && in_array($request['request_type'], $specialRequestTypes, true)) {
                $parsedResponse = XmlToArrayWithHTML($responseContent);
            } else {
                $xml = simplexml_load_string($responseContent);
                $parsedResponse = json_decode(json_encode($xml), true);
            }
           

            // Log request & response to database
            $HotelXmlRequest = new HotelXmlRequest;
            $HotelXmlRequest->request_xml    = $request['xml'];
            $HotelXmlRequest->response_xml = $responseContent;
            $HotelXmlRequest->ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
            $HotelXmlRequest->request_type = $request['request_type'] ??null;
            $HotelXmlRequest->supplier = 'webbeds';
            $HotelXmlRequest->hotel_search_id = $request['searchId']??null;
            $HotelXmlRequest->save();
             // End time
            // $endTime = microtime(true);
            // $executionTime = $endTime - $startTime; // seconds
            // dd($executionTime);
            

            return [
                'hotelResponse' => $parsedResponse,
                'hotelRequest'  => $HotelXmlRequest
            ];
        } catch (\Throwable $e) {
            // Log the exception if required
            // Log::error('Webbeds API Error: '.$e->getMessage());

            return [
                'hotelResponse' => [],
                'hotelRequest'  => []
            ];
        }
    }

    public function DadiApiStaticData(array $request)
    {
        //dd($request);
        set_time_limit(400);

        try {
            $baseUrl = rtrim($this->didaStatic, '/') . '/';
            $url = $baseUrl . ltrim($request['end_point'], '/');

            // Default method
            $method = strtoupper($request['method'] ?? 'GET');

            // Always attach language param
            $queryParams = ['language' => 'en-US'];

            // Append extra query params if passed
            if (!empty($request['query'])) {
                $queryParams = array_merge($queryParams, $request['query']);
            }

            // Build final URL for GET requests
            if ($method === 'GET') {
                $url .= '?' . http_build_query($queryParams);
            }
            //dd($url);

            // Common headers
            $headers = [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . $this->didaAuthToken,
                'Accept-Encoding' => 'gzip, deflate',
            ];
            // dd($url , $headers ,$request['params']);

            // Prepare request
            $http = Http::withHeaders($headers)
                ->timeout(300)
                ->withoutVerifying(); // For local/self-signed SSL

            // Execute GET or POST
            if ($method === 'POST') {
                // Attach params as JSON body
                $response = $http->post($url, $request['params'] ?? []);
            } else {
                $response = $http->get($url);
            }

            // Check for HTTP failure
            if ($response->failed()) {
                return [
                    'response' => [],
                    'status'   => false,
                    'message'  => 'HTTP ' . $response->status() . ' ' . $response->body(),
                ];
            }

            // Return structured response
            return [
                'response' => $response->json(),
                'status'   => true,
                'message'  => 'Success',
            ];
        } catch (\Throwable $e) {
            \Log::error('Dida API Error: ' . $e->getMessage(), [
                'endpoint' => $request['end_point'] ?? null,
                'method'   => $request['method'] ?? null,
                'params'   => $request['params'] ?? null,
            ]);

            return [
                'response' => [],
                'status'   => false,
                'message'  => $e->getMessage(),
            ];
        }
    }

    // public function DadiApi(array $request)
    // {
    //     // dd(json_encode($request['payload']));
    //     set_time_limit(400);

    //     try {
    //         $baseUrl = rtrim($this->didaUrl, '/') . '/';
    //         $url = $baseUrl . ltrim($request['end_point'], '/');

    //         // Default method
    //         $method = strtoupper($request['method'] ?? 'GET');

    //         $url .= '?' . http_build_query(['$format'=>'json']);


    //         // Common headers
    //         $headers = [
    //             'Accept' => 'application/json',
    //             'Authorization' => 'Basic ' . $this->didaAuthToken,
    //             'Accept-Encoding' => 'gzip, deflate',
    //         ];

    //         // Prepare request
    //         $http = Http::withHeaders($headers)
    //             ->timeout(300)
    //             ->withoutVerifying(); // For local/self-signed SSL

    //         // Execute GET or POST
    //         if ($method === 'POST') {
    //             // Attach params as JSON body
    //             $response = $http->post($url, $request['payload'] ?? []);
    //         } else {
    //             $response = $http->get($url);
    //         }

    //         $HotelXmlRequest = new HotelXmlRequest;
    //         $HotelXmlRequest->json_request    = json_encode($request['payload']) ?? '';
    //         $HotelXmlRequest->json_response = $response->body() ?? '';
    //         $HotelXmlRequest->ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
    //         $HotelXmlRequest->request_type = $request['request_type'] ??null;
    //         $HotelXmlRequest->supplier = 'dida';
    //         $HotelXmlRequest->hotel_search_id = $request['searchId']??null;
    //         $HotelXmlRequest->save();


    //         // Check for HTTP failure
    //         if ($response->failed()) {
    //             return [
    //                 'response' => [],
    //                 'status'   => false,
    //                 'message'  => 'HTTP ' . $response->status(),
    //             ];
    //         }

    //         // Return structured response
    //         return [
    //             'response' => $response->json(),
    //             'status'   => true,
    //             'message'  => 'Success',
    //         ];
    //     } catch (\Throwable $e) {
    //         \Log::error('Dida API Error: ' . $e->getMessage(), [
    //             'endpoint' => $request['end_point'] ?? null,
    //             'method'   => $request['method'] ?? null,
    //             'params'   => $request['params'] ?? null,
    //         ]);

    //         return [
    //             'response' => [],
    //             'status'   => false,
    //             'message'  => $e->getMessage(),
    //         ];
    //     }
    // }

    public function DadiApi(array $request)
    {

        set_time_limit(400);

        try {
            $baseUrl = rtrim($this->didaUrl, '/') . '/';
            $url = $baseUrl . ltrim($request['end_point'], '/');

            // Default method
            $method = strtoupper($request['method'] ?? 'GET');

            // Append format query param
            $url .= '?' . http_build_query(['$format' => 'json']);

            // Common headers
            $headers = [
                'Accept'           => 'application/json',
                'Authorization'    => 'Basic ' . $this->didaAuthToken,
                'Accept-Encoding'  => 'gzip, deflate',
            ];

            // Prepare HTTP client
            $http = Http::withHeaders($headers)
                ->timeout(300)
                ->withoutVerifying(); // For local/self-signed SSL

            // Execute GET or POST
            if ($method === 'POST') {
                $response = $http->post($url, $request['payload'] ?? []);
            } else {
                $response = $http->get($url);
            }

            // Log request/response
            $HotelXmlRequest = new HotelXmlRequest;
            $HotelXmlRequest->json_request   = json_encode($request['payload']) ?? '';
            $HotelXmlRequest->json_response  = $response->body() ?? '';
            $HotelXmlRequest->ip_address     = $_SERVER['REMOTE_ADDR'] ?? null;
            $HotelXmlRequest->request_type   = $request['request_type'] ?? null;
            $HotelXmlRequest->supplier       = 'dida';
            $HotelXmlRequest->formate_type   = 'json';
            $HotelXmlRequest->hotel_search_id = $request['searchId'] ?? null;
            $HotelXmlRequest->save();

            // Handle HTTP failure
            if ($response->failed()) {
                return [
                    'response' => [],
                    'status'   => false,
                    'message'  => 'HTTP ' . $response->status(),
                    'hotelRequest'  => $HotelXmlRequest
                ];
            }

            // Return structured success response
            return [
                'response' => $response->json(),
                'status'   => true,
                'message'  => 'Success',
                'hotelRequest'  => $HotelXmlRequest
            ];
        } catch (\Throwable $e) {
            \Log::error('Dida API Error: ' . $e->getMessage(), [
                'endpoint' => $request['end_point'] ?? null,
                'method'   => $request['method'] ?? null,
                'params'   => $request['params'] ?? null,
            ]);

            return [
                'response' => [],
                'status'   => false,
                'message'  => $e->getMessage(),
                'hotelRequest' => []
            ];
        }
    }
}
