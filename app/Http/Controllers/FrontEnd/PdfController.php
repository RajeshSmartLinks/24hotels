<?php

namespace App\Http\Controllers\FrontEnd;

use PDF;
use App\Models\User;
use App\Models\Airline;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\FlightBooking;
use App\Models\TravelportRequest;
use App\Http\Controllers\Controller;
use Mtownsend\XmlToArray\XmlToArray;

class PdfController extends Controller
{

    public function index()
    {
        return view('pdf.index');
    }

    public function create(Request $request)
    {
        $res = TravelportRequest::where('trace_id' , decrypt($request->input('traceId')))->first();
        //dd(decrypt($request->input('traceId')));
        if($res)
        {
            $response = XmlToArray::convert($res->response_xml, $outputRoot = false);
            $response = $response['SOAP:Body']['universal:AirCreateReservationRsp'];
        }
        else{
            //error
        }

        if(isset($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment']['@attributes']))
        {
            $segmentData = $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'];
            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] =[];
            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][0] = $segmentData;
        }
        foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] as $s=>$value)
        {
            $airlinedetails = Airline::whereVendorCode($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Carrier'])->first();
           
            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['airLineDetais'] =  $airlinedetails;

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['OriginAirportDetails'] = $this->AirportDetails($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Origin']);

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['DestinationAirportDetails'] = $this->AirportDetails($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['@attributes']['Destination']);

            $response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['air:FlightDetails']['@attributes']['EquipmentDetails'] = Equipment::where('equipment_code',$response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'][$s]['air:FlightDetails']['@attributes']['Equipment'])->first();

        }
        if(isset($response['universal:UniversalRecord']['common_v52_0:BookingTraveler']['@attributes']))
        {
            $travelersInfo = $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'];
            $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] = [];
            $response['universal:UniversalRecord']['common_v52_0:BookingTraveler'][0] = $travelersInfo;

        }

        // $titles = [
        //     'title' => "Flight Booked itinerary",
        // ];
        //echo $request->input('traceId');
        $flightbookingdetails = FlightBooking::where('trace_id',decrypt($request->input('traceId')))->first();
        //print_r($flightbookingdetails);exit;
        if($flightbookingdetails->user_type != 'guest')
        {
            $userdetails = User::find($flightbookingdetails->user_id);
            $user = $userdetails->name;
        }
        else{
            $user = '';
        }
        $pdf = PDF::loadView('front_end.email_templates.ticket', compact('response','flightbookingdetails','user'));
        $path = public_path('pdf/');
        $fileName =  time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);

        $pdf = public_path('pdf/'.$fileName);
        return response()->download($pdf,$fileName);
    }
}
