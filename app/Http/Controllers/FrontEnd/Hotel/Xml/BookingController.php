<?php

namespace App\Http\Controllers\FrontEnd\Hotel\Xml;

use Illuminate\Http\Request;
use App\Models\WebbedsHotelSearch;
use App\Http\Controllers\Controller;

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
                    <rooms>
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
            'message' => 'success'
        ];


    }
}
