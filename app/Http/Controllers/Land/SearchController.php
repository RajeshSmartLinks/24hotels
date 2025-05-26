<?php

namespace App\Http\Controllers\Land;

use Carbon\Carbon;
use App\Models\HotelSearch;
use App\Models\JsonRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    
   public function Search(Request $request)
    {
        // dd($request->input());
        $cityCode = $request->input('hotelsCityCode');
        $checkIn = $request->input('hotelsCheckIn');
        $checkOut = $request->input('hotelsCheckOut');
        $noOfRooms = $request->input('noOfRooms');

  


        // $hotelCodes = DB::table('tbo_hotels')->selectRaw('GROUP_CONCAT(hotel_code) as codes')->where('city_code',$cityCode)->first();
        $hotelCodes = DB::table('tbo_hotels')->select('hotel_code')->where('city_code',$cityCode)->get()->toArray();
        set_time_limit(400);

        $cityDetails = DB::table('tbo_hotels_cities')->where('code',$cityCode)->first();
        $noOfGuests = 0;
      
        if(!empty($hotelCodes))
        {
            //preprating json forrequest
            $hotelRequestArray = array(
                "CheckIn" => $checkIn,
                "CheckOut" => $checkOut,
                "HotelCodes" => '' ,
                "GuestNationality" => $request->input('nationality'),
                "PaxRooms" => [],
                "ResponseTime" => 15,
                "IsDetailedResponse" => false,
                "Filters" => array(
                    "NoOfRooms" =>  1,
                    "MealType" => "All"
                )
            );
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
            $hotelSearch = new HotelSearch();
            $hotelSearch->no_of_rooms = $request->input('noOfRooms');
            $hotelSearch->no_of_nights    = $CIn->diffInDays($COut);
            $hotelSearch->nationality    = $request->input('nationality');
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
            
            
            $list =[];

            // if(!empty($hotelCodes))
            // {
            //     $list = rtrim($hotelCodes->codes, ',');
            // }
            // $hotelList = explode(",",$list);
            $ChunkedhotelCodes = array_chunk($hotelCodes,100);
            $url = env('TBO_HOTEL_URL').'search';
            $promises = [] ;
            $request = [] ;

            foreach($ChunkedhotelCodes as $k => $chunk) {
                $hotelRequestArray['ResponseTime'] = ceil(0.23 * count($chunk));
                $hotelRequestArray['HotelCodes'] = implode(",", array_column($chunk, 'hotel_code'));
                $hotelRequestPrepration[] = [
                    'hotelRequestArray' => $hotelRequestArray,
                    'url' => $url,
                ];
            }
            // Send parallel requests using Http::pool
            $responses = Http::pool(function ($pool) use ($hotelRequestPrepration) {
                $requests = [];

                foreach ($hotelRequestPrepration as $req) {
                    $requests[] = $pool->withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))
                                    ->withHeaders(['Content-Type' => 'application/json'])
                                    ->withOptions(['verify' => false])
                                    ->asJson()
                                    ->post($req['url'], $req['hotelRequestArray']);
                }
                return $requests;
            });
            $rsp = [];
            $availableHotels = [];


            // Process the responses
            foreach ($responses as $name => $result) {
                $response = $result->json();
                if ($result->successful()) {
                    if(isset($response['HotelResult']) && is_array($response['HotelResult']))
                    {
                        $availableHotels = array_merge($availableHotels , $response['HotelResult']);
                    }
                }
                $dataJsonRequest = new JsonRequest();
                $dataJsonRequest->request_json    = json_encode($hotelRequestPrepration[$name]['hotelRequestArray']);
                $dataJsonRequest->response_json = json_encode($response);
                $dataJsonRequest->ip_address = $_SERVER['REMOTE_ADDR'];
                $dataJsonRequest->search_id = $hotelSearch->id;
                $dataJsonRequest->request_type = 'search';
                $dataJsonRequest->supplier = 'tbo';
                $dataJsonRequest->city_code = $cityCode;  
                $dataJsonRequest->save();
            }
            //response
            return [
                'availableHotels' => $availableHotels,
                'searchId' =>  $hotelSearch->id,
                'success' => true,
                'message' => 'success'
            ];


        }
        else{
            return [
                'availableHotels' => [],
                'searchId' =>  '',
                'success' => false,
                'message' => 'No Hotels Available'
            ];
        }

   

    }

    public function getTboRooms($data)
    {
        //hotel details 
        $hoteldetailsUrl = env('TBO_HOTEL_URL') . "Hoteldetails";
        $hotel_code = $data['hotel_code'];
        $hotelDeatailsrequest = array( "Hotelcodes" => $hotel_code,"Language"=> "en","IsDetailedResponse" => "true");

        //hotel room details
        $hotelSearchurl = env('TBO_HOTEL_URL').'search';
        $searchRequest = HotelSearch::find($data['search_id']);
        $hotelRequestArray = array(
                "CheckIn" => $searchRequest->check_in,
                "CheckOut" => $searchRequest->check_out,
                "HotelCodes" =>  $data['hotel_code'],
                "GuestNationality" => $searchRequest->nationality,
                "PaxRooms" => json_decode($searchRequest->rooms_request),
                "ResponseTime" => 5,
                "IsDetailedResponse" => true,
                "Filters" => array(
                    "NoOfRooms" =>  0,
                    "MealType" => "All"
                )
            );
        $hotel_code = $data['hotel_code'];


        $promises = [] ;

        $promises['hotel_details'] =  Http::withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))->withHeaders([$this->Jsonheaders])->withOptions(['verify' => false])->async()->post($hoteldetailsUrl , $hotelDeatailsrequest);
        $promises['all_rooms'] =  Http::withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))->withHeaders([$this->Jsonheaders])->withOptions(['verify' => false])->async()->post($hotelSearchurl , $hotelRequestArray);
        // Wait for the responses to be received
        $responses = Utils::unwrap($promises);

        $dataJsonRequest = new JsonRequest();
        $dataJsonRequest->request_json    = json_encode($hotelDeatailsrequest);
        $dataJsonRequest->response_json = json_encode($responses['hotel_details']->json());
        $dataJsonRequest->ip_address = $_SERVER['REMOTE_ADDR'];
        $dataJsonRequest->request_type = 'hotel_details';
        $dataJsonRequest->search_id = $data['search_id'];
        $dataJsonRequest->supplier = 'tbo';
        $dataJsonRequest->city_code = $searchRequest->city_code;
        
        $dataJsonRequest->save();

        $dataJsonRequest = new JsonRequest();
        $dataJsonRequest->request_json    = json_encode($hotelRequestArray);
        $dataJsonRequest->response_json = json_encode($responses['all_rooms']->json());
        $dataJsonRequest->ip_address = $_SERVER['REMOTE_ADDR'];
        $dataJsonRequest->request_type = 'get_all_rooms';
        $dataJsonRequest->supplier = 'tbo';
        $dataJsonRequest->search_id = $data['search_id'];
        $dataJsonRequest->city_code = $searchRequest->city_code;
        
        $dataJsonRequest->save();
        $responses['hotel_details'] = $responses['hotel_details']->json();
        $responses['all_rooms'] = $responses['all_rooms']->json();

        return [
            'hotelDetails' => ($responses['hotel_details']['Status']['Code'] == 200) ? $responses['hotel_details']['HotelDetails'] : [],
            'allRooms' =>  ($responses['all_rooms']['Status']['Code'] == 200) ? $responses['all_rooms']['HotelResult'] : [],
            'success' => true,
            'message' => 'success'
        ];
    }
}
