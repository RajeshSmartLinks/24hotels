<?php

namespace App\Http\Controllers\FrontEnd\Hotel\Xml;

use App\Models\HotelSearch;
use App\Models\HotelBooking;
use Illuminate\Http\Request;
use App\Models\WebbedsHotelSearch;
use App\Http\Controllers\Controller;
use App\Models\HotelBookingTravelsInfo;

class BookingController extends Controller
{
    public function preBooking($data){

        //hotel details 
        $bookingCode = $data['booking_code']; 
        $data['booking_code'] = json_decode($data['booking_code'] , true);
        $allocationDetails = json_decode($data['booking_code']['allocationDetails'] , true);
       
        //dd($allocationDetails);
        $code = $data['booking_code']['code'];
        $selectedRateBasis = $data['booking_code']['selectedRateBasis'];
        $hotelCode = $data['hotel_code'];
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
        <customer xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
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
                $allocationDetailsValue = $allocationDetails[$i];

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
                            <roomTypeSelected>
                                <code>{$code}</code>
                                <selectedRateBasis>{$selectedRateBasis}</selectedRateBasis>
                                <allocationDetails>{$allocationDetailsValue}</allocationDetails>
                            </roomTypeSelected>
                        </room>
        EOM;
        }
        $xml .= <<<EOM
                    </rooms>
                     <productId>$hotelCode</productId>
                </bookingDetails>
            </request>
        </customer>
        EOM;

        $data = array(
            'xml' => $xml,
            'request_type' => 'getRoomsWithBlocking',
            'searchId' => $searchId
        );
        $data = $this->WebbedsApi($data);

    
        return [
            'preBooking' =>  $data,
            'success' => $data['hotelResponse']['successful'] ?? false,
            'xml_request_id' => $data['hotelRequest']->id ?? null,
            'message' => 'success'
        ];


    }


    public function Booking($data){

        $bookingId = $data['booking_id'];
        $hotelBookingDetails = HotelBooking::with('Customercountry')->find($bookingId);
        $travelersInfo = HotelBookingTravelsInfo::where("hotel_booking_id" , $data['booking_id'])->get();
        $bookingDetails = HotelBooking::where("id" , $data['booking_id'])->first();

        $hotelCode = $hotelBookingDetails->hotel_code;

        //hotel room details
        $searchRequest = WebbedsHotelSearch::find($hotelBookingDetails->search_id);

        $cityCode = $searchRequest->city_code;
        $checkIn = $searchRequest->check_in;
        $checkOut = $searchRequest->check_out;
        $noOfRooms = (int) $searchRequest->no_of_rooms;
        $nationality = $searchRequest->nationality;
        $residency = $searchRequest->residency;

        $roomRequest = json_decode($searchRequest->rooms_request,true);
        $bookingCode = json_decode($bookingDetails->booking_code,true);


        $xml = <<<EOM
                <customer>
                    <username>{$this->WebbedsUsername}</username>
                    <password>{$this->WebbedsPassword}</password>
                    <id>{$this->WebbedsCompanyCode}</id>
                    <source>1</source>
                    <product>hotel</product>
                    <request command="confirmbooking">
                        <bookingDetails>
                            <fromDate>{$checkIn}</fromDate>
                            <toDate>{$checkOut}</toDate>
                            <currency>769</currency>
                            <productId>{$hotelCode}</productId>
                            <customerReference>{$hotelBookingDetails->booking_ref_id}</customerReference>
                            <rooms no="{$noOfRooms}">
                EOM;

            // Grouping travelers by room number
            $groupedTravelers = [];
            foreach ($travelersInfo as $traveler) {
                $groupedTravelers[$traveler->room_no][] = $traveler;
            }
            $groupedTravelers = array_values($groupedTravelers);
            foreach ($groupedTravelers as $roomIndex => $roomTravelers) 
            {
                $adults = 0;
                $children = 0;
                $childrenAges = [];

                foreach ($roomTravelers as $traveler) {
                    if ($traveler->traveler_type == 'CNN') {
                        $children++;
                        $childrenAges[] = $traveler->age;
                    } else {
                        $adults++;
                    }
                }
                $allocationDetailsValue = $bookingCode[$roomIndex]['allocationDetails'];
                $rateBasisIds = $bookingCode[$roomIndex]['rateBasisId'];
                $roomTypeCodes = $bookingCode[$roomIndex]['roomTypeCode'];
                $validForOccupancyDetails = $bookingCode[$roomIndex]['validForOccupancyDetails'] ?? [];
                $adultsCode = $adults;
                $actualAdults = $adults;
                $extrabeds = 0;
                if(!empty($validForOccupancyDetails)){
                    $adultsCode = $validForOccupancyDetails['adults'];
                    $extrabeds = $validForOccupancyDetails['extraBed'];
                    if(isset($validForOccupancyDetails['children'])){
                        $occupencyChildren = $validForOccupancyDetails['children'];
                        $occupencyChildrenAges = explode("," ,$validForOccupancyDetails['childrenAges']);
                    }
                    
                }

                $xml .= <<<EOM
                            <room runno="{$roomIndex}">
                                <roomTypeCode>{$roomTypeCodes}</roomTypeCode>
                                <selectedRateBasis>{$rateBasisIds}</selectedRateBasis>
                                <allocationDetails>{$allocationDetailsValue}</allocationDetails>
                                <adultsCode>{$adultsCode}</adultsCode>
                                <actualAdults>{$actualAdults}</actualAdults>
                EOM;

                // Children
            
                if ($children > 0) {

                    //with validForOccupancyDetails changing this tag values
                    if(isset($occupencyChildren)){
                         $xml .= "<children no=\"{$occupencyChildren}\">";
                        foreach ($occupencyChildrenAges as $index => $age) {
                             
                            $xml .= "<child runno=\"{$index}\">{$age}</child>";
                            
                        }
                        $xml .= "</children>";
                    }else{
                        $xml .= "<children no=\"{$children}\">";
                        foreach ($childrenAges as $index => $age) {
                            $xml .= "<child runno=\"{$index}\">{$age}</child>";
                        }
                        $xml .= "</children>";
                    }
                    

                    $xml .= "<actualChildren no=\"{$children}\">";
                    foreach ($childrenAges as $index => $age) {
                        $xml .= "<actualChild runno=\"{$index}\">{$age}</actualChild>";
                    }
                    $xml .= "</actualChildren>";
                } else {
                    $xml .= "<children no=\"0\" ></children>";
                    $xml .= "<actualChildren no=\"0\" ></actualChildren>";
                }

                $xml .= <<<EOM
                                <extraBed>$extrabeds</extraBed>
                                <passengerNationality>{$nationality}</passengerNationality>
                                <passengerCountryOfResidence>{$residency}</passengerCountryOfResidence>
                                <passengersDetails>
                EOM;

                foreach ($roomTravelers as $index => $traveler) {
                    $leading = $index == 0 ? "yes" : "no";
                    $salutation = htmlspecialchars($traveler->webbeds_code);
                    $firstName = htmlspecialchars($traveler->first_name);
                    $lastName = htmlspecialchars($traveler->last_name);

                    $xml .= <<<EOM
                                    <passenger leading="{$leading}">
                                        <salutation>{$salutation}</salutation>
                                        <firstName>{$firstName}</firstName>
                                        <lastName>{$lastName}</lastName>
                                    </passenger>
                EOM;
            }

                $xml .= <<<EOM
                                </passengersDetails>
                                <specialRequests count="0"></specialRequests>
                            </room>
            EOM;
            }

            $xml .= <<<EOM
                        </rooms>
                    </bookingDetails>
                </request>
            </customer>
        EOM;
        $data = array(
            'xml' => $xml,
            'request_type' => 'confirmBooking',
            'searchId' => $hotelBookingDetails->search_id
        );
        $data = $this->WebbedsApi($data);

    
        return [
            'bookingInfo' =>  $data,
            'success' => $data['hotelResponse']['successful'] ?? false,
            'xml_request_id' => $data['hotelRequest']->id ?? null
        ];

    }

    public function RoomBookingDetails($data){
        $booking_code = $data['booking_code'];
        $booking_status = $data['booking_status'];
        $searchId = $data['search_id'];
        
        $xml = <<<EOM
                <customer>
                    <username>{$this->WebbedsUsername}</username>
                    <password>{$this->WebbedsPassword}</password>
                    <id>{$this->WebbedsCompanyCode}</id>
                    <source>1</source>
                    <product>hotel</product>
                    <request command="getbookingdetails">
                        <bookingDetails>
                            <bookingType>{$booking_status}</bookingType>
                            <bookingCode>{$booking_code}</bookingCode>
                        </bookingDetails>
                    </request>
                </customer>        
                EOM;

        $data = array(
            'xml' => $xml,
            'request_type' => 'getbookingdetails',
            'searchId' => $searchId
        );
        $data = $this->WebbedsApi($data);
        return [
            'roomBookingInfo' =>  $data,
            'success' => $data['hotelResponse']['successful'] ?? false,
            'xml_request_id' => $data['hotelRequest']->id ?? null
        ];
    }
}
