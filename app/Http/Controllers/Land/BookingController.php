<?php

namespace App\Http\Controllers\Land;

use App\Models\HotelSearch;
use App\Models\JsonRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Utils;
use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\HotelBookingTravelsInfo;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function TboPreBooking($data){

        //hotel details 
        // $hoteldetailsUrl = env('TBO_HOTEL_URL') . "Hoteldetails";
        // $hotel_code = $data['hotel_code'];
        // $hotelDeatailsrequest = array( "Hotelcodes" => $hotel_code,"Language"=> "en","IsDetailedResponse" => "true");

        $searchRequest = HotelSearch::find($data['search_id']);

        //hotel room details
        $hotelSearchurl = env('TBO_HOTEL_URL').'PreBook';

        //as we are B2B User we should use Payment mode AS LIMIT as suggested by Tbo supplier

        $hotelRequestArray = array(
                "BookingCode" => $data['booking_code'],
                "PaymentMode" => 'limit'
            );
       

        $promises = [] ;

        //$promises['hotel_details'] =  Http::withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))->withHeaders([$this->Jsonheaders])->withOptions(['verify' => false])->async()->post($hoteldetailsUrl , $hotelDeatailsrequest);
        $promises['pre_booking'] =  Http::withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))->withHeaders([$this->Jsonheaders])->withOptions(['verify' => false])->async()->post($hotelSearchurl , $hotelRequestArray);
        // Wait for the responses to be received
        $responses = Utils::unwrap($promises);
        
        $dataJsonRequest = new JsonRequest();
        $dataJsonRequest->request_json    = json_encode($hotelRequestArray);
        $dataJsonRequest->response_json = json_encode($responses['pre_booking']->json());
        $dataJsonRequest->ip_address = $_SERVER['REMOTE_ADDR'];
        $dataJsonRequest->request_type = 'pre_booking';
        $dataJsonRequest->supplier = 'tbo';
        $dataJsonRequest->search_id = $data['search_id'];
        $dataJsonRequest->city_code = $searchRequest->city_code;
        
        $dataJsonRequest->save();

     
        $responses['pre_booking'] = $responses['pre_booking']->json();
        return [
            'preBooking' =>  ($responses['pre_booking']['Status']['Code'] == 200) ? $responses['pre_booking']['HotelResult'] : [],
            'success' => true,
            'message' => 'success'
        ];


    }

    public function Booking($data){

        $bookingId = $data['booking_id'];
        $hotelBookingDetails = HotelBooking::with('Customercountry')->find($bookingId);
        $travelersInfo = HotelBookingTravelsInfo::where("hotel_booking_id" , $data['booking_id'])->get();
        $requestArray = [] ;
        $requestArray['BookingCode'] = $hotelBookingDetails->booking_code;
        $requestArray['CustomerDetails'] = [];
        $requestArray['ClientReferenceId'] = $hotelBookingDetails->booking_ref_id;
        $requestArray['BookingReferenceId'] = $hotelBookingDetails->booking_ref_id;
        $requestArray['TotalFare'] = $hotelBookingDetails->price_from_supplier;
        $requestArray['EmailId'] = $hotelBookingDetails->email;
        $requestArray['PhoneNumber'] = str_replace("+","",$hotelBookingDetails->Customercountry->phone_code??'').$hotelBookingDetails->mobile;
        $requestArray['BookingType'] = "Voucher";
        $requestArray['PaymentMode'] = "Limit";

        $searchRequest = HotelSearch::find($hotelBookingDetails->search_id);

        for($i = 1 ; $i<=$searchRequest->no_of_rooms;$i++){
            $membersinRoom = $travelersInfo->where('room_no', '=', $i);
            $members = [];
            foreach($membersinRoom as $memb)
            {
                $type = $memb->traveler_type == 'ADT'? 'Adult' : 'Child';
                $members[] = [
                        "Title"=> $memb->title,
                        "FirstName"=> $memb->first_name,
                        "LastName"=> $memb->last_name,
                        "Type"=> $type
                ];
            }
            $requestArray['CustomerDetails'][]['CustomerNames'] = $members;
        }

        $hotelSearchurl = env('TBO_HOTEL_URL').'Book';
        $promises = [] ;

        //$promises['hotel_details'] =  Http::withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))->withHeaders([$this->Jsonheaders])->withOptions(['verify' => false])->async()->post($hoteldetailsUrl , $hotelDeatailsrequest);
        $promises['booking'] =  Http::withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))->withHeaders([$this->Jsonheaders])->withOptions(['verify' => false])->async()->post($hotelSearchurl , $requestArray);
        // Wait for the responses to be received
        $responses = Utils::unwrap($promises);
        
        $dataJsonRequest = new JsonRequest();
        $dataJsonRequest->request_json    = json_encode($requestArray);
        $dataJsonRequest->response_json = json_encode($responses['booking']->json());
        $dataJsonRequest->ip_address = $_SERVER['REMOTE_ADDR'];
        $dataJsonRequest->request_type = 'booking';
        $dataJsonRequest->supplier = 'tbo';
        $dataJsonRequest->search_id = $hotelBookingDetails->search_id;
        $dataJsonRequest->city_code = $searchRequest->city_code;
        
        $dataJsonRequest->save();

     
        $responses['booking'] = $responses['booking']->json();
        if($responses['booking']['Status']['Code'] == 200 && $responses['booking']['Status']['Description'] == 'Successful')
        {
            return [
                'confirmation_number' =>  ($responses['booking']['Status']['Code'] == 200) ? $responses['booking']['ConfirmationNumber'] : '',
                'success' => true,
                'message' => 'success',
                'json_request_id' => $dataJsonRequest->id
            ];
        }
        else
        {
            return [
                'confirmation_number' =>  ($responses['booking']['Status']['Code'] == 200) ? $responses['booking']['ConfirmationNumber'] : '',
                'success' => false,
                'message' => $responses['booking']['Status']['Description'],
                'json_request_id' => $dataJsonRequest->id
            
            ];
        }
       




    }

    public function BookingDetails($data){

        $hotelBookingDetails = HotelBooking::with('Customercountry')->find($data['booking_id']);

        $searchRequest = HotelSearch::find($hotelBookingDetails->search_id);

        $requestArray = [] ;
        //$requestArray['ConfirmationNumber'] = $data['confirmation_number'];
        $requestArray['BookingReferenceId'] = $hotelBookingDetails->booking_ref_id;
        $requestArray['PaymentMode'] = "Limit";

        $hotelSearchurl = env('TBO_HOTEL_URL').'BookingDetail';
        $promises = [] ;

   
        $promises['booking_details'] =  Http::withBasicAuth(env('TBO_USERNAME'), env('TBO_PASSWORD'))->withHeaders([$this->Jsonheaders])->withOptions(['verify' => false])->async()->post($hotelSearchurl , $requestArray);
        // Wait for the responses to be received
        $responses = Utils::unwrap($promises);
        
        $dataJsonRequest = new JsonRequest();
        $dataJsonRequest->request_json    = json_encode($requestArray);
        $dataJsonRequest->response_json = json_encode($responses['booking_details']->json());
        $dataJsonRequest->ip_address = $_SERVER['REMOTE_ADDR'];
        $dataJsonRequest->request_type = 'booking_details';
        $dataJsonRequest->supplier = 'tbo';
        $dataJsonRequest->search_id = $searchRequest->id;
        $dataJsonRequest->city_code = $searchRequest->city_code;
        
        $dataJsonRequest->save();

     
        $responses['booking_details'] = $responses['booking_details']->json();
        if($responses['booking_details']['Status']['Code'] == 200)
        {
            return [
                'reservation_details' =>  ($responses['booking_details']['Status']['Code'] == 200) ? $responses['booking_details']['BookingDetail'] : [],
                'success' => true,
                'message' => 'success',    
                'json_request_id' => $dataJsonRequest->id
            ];

        }
        else{
            return [
                'reservation_details' =>  ($responses['booking_details']['Status']['Code'] == 200) ? $responses['booking_details']['BookingDetail'] : [],
                'success' => false,
                'message' => 'success',    
                'json_request_id' => $dataJsonRequest->id
            ];
        }
 
    }
}
