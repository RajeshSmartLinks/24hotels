<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Ticket</title>
<style type="text/css">
@media only screen and (max-width: 600px) {
table[class="contenttable"] {
	width: 320px !important;
	border-width: 3px!important;
}
table[class="tablefull"] {
	width: 100% !important;
}
table[class="tablefull"] + table[class="tablefull"] td {
	padding-top: 0px !important;
}
table td[class="tablepadding"] {
	padding: 15px !important;
}
}
/* table {page-break-before:auto;} */
 .page-break {
  page-break-after: always;
}

</style>
</head>
<body style="margin-left:0; border: none; background:#f5f7f8">
<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tr>
    <td align="center" valign="top">
      <table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="#ffffff" style="border-width:1px; border-style: solid; border-collapse: separate; border-color:#ededed; margin-top:20px;     margin-left: 20px;font-family:Arial, Helvetica, sans-serif">
        <tr>
          <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td width="100%" height="30">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="center"><a href="#"><img alt="" src="{{asset("frontEnd/images/logo.png")}}" style="padding-bottom: 0; display: inline !important;"></a></td>
                </tr>
                <tr>
                  <td width="100%" height="30">&nbsp;</td>
                </tr>
                <tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:0px 20px;"><table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="border:4px solid #eee; border-radius:4px; padding:25px 0px;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                      <tbody>
                        <tr>
                          <td style="font-size:14px; padding:0px 25px;" width="50"><img alt="" src="{{asset("frontEnd/images/booking-successful.png")}}"></td>
                          <td style="font-size:16px; font-weight:600; color:#777; line-height:26px; padding-right:20px;"><span style="font-size:13px;">Hi Raju,
                          </span><br>
                            Congratulations! Your flight booking is <span style="color:#28a745;"> {{$response['air:ETR']['air:Ticket']['@attributes']['TicketStatusDetails']}}</span>.</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:20px;"><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">PNR -</span> <a style="outline:none; color:#0071cc; text-decoration:none;" href="#">{{$response['air:ETR']['air:AirReservationLocatorCode']}}</a></td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Booking Status -</span> {{$response['air:ETR']['air:Ticket']['@attributes']['TicketStatusDetails']}}</td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:28px;">Thank you for booking your travel itinerary with 24Flights.</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:0px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
            Passenger Information
            </h3></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px 20px 25px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
              <thead>
                <tr>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">First Name</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Last Name</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Code</td>
                </tr>
              </thead>
              <tbody>
                @foreach($response['air:ETR']['common_v52_0:BookingTraveler'] as $TravelsInfo)
                <tr>
                  <td width="50%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['First']}} </td>
                  <td width="50%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Last']}} </td>
                  <td width="50%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$TravelsInfo['@attributes']['TravelerType']}} </td>
                </tr>
                @endforeach
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td class="tablepadding" style="background:#f8f8f8;border-top:1px solid #e9e9e9;border-bottom:1px solid #e9e9e9;padding:13px 20px;"><table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td style="font-size:14px; line-height:20px;"><span style="color:#909090">Booking Date:</span><br />
                    <span style="color:#000000;display:inline-block">
                        {{-- {{date('d M, Y', strtotime(DateTimeSpliter($response['universal:UniversalRecord']['air:AirReservation']['@attributes']['CreateDate'],"date")))}} --}}
                        20 Nov,2022
                    </span></td>
                  <td style="font-size:14px; line-height:20px;"><span style="color:#909090">PNR:</span><br />
                    <a style="outline:none; color:#0071cc; text-decoration:none;" href="#">
                        {{-- {{$response['universal:UniversalRecord']['@attributes']['LocatorCode']}} --}}
                        {{$response['air:ETR']['air:AirReservationLocatorCode']}}
                    </a></td>
                  <td style="font-size:14px; line-height:20px;"><span style="color:#909090">Payment:</span><br />
                    by 
                    VISA/MASTER
                    {{-- {{$flightbookingdetails->payment_gateway}} --}}
                </td>
                <td style="font-size:14px; line-height:20px;"><span style="color:#909090">TicketNumber:</span><br />
                    by 
                    {{$response['air:ETR']['air:Ticket']['@attributes']['TicketNumber']}}

                </td>
                </tr>
              </tbody>
            </table></td>
        </tr>
      </table>
    </td>    
  </tr>

  @foreach($response['air:ETR']['air:Ticket']['air:Coupon'] as $booking)
  <tr>
    <td align="center" valign="top">
      <table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="#ffffff" style="border-width:1px; border-style: solid; border-collapse: separate; border-color:#ededed; margin-top:20px;     margin-left: 20px;font-family:Arial, Helvetica, sans-serif">
        <tr>
          <td style="padding:25px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
            Flight Details
            </h3></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
              <thead>
                <tr>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Flight</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Depart</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Arrive</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td width="25%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;"><img style="height: 40px;width:40px" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$booking['@attributes']['MarketingCarrier']}}.png"><br />
                    {{$booking['@attributes']['airlineDetails']->name}}<br />
                    <span style="font-size:13px; color:#555;">{{$booking['@attributes']['MarketingCarrier']}}-{{$booking['@attributes']['MarketingFlightNumber']}}</span></td>
                  <td valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">  {{$booking['@attributes']['OriginAirportDetails']->city_name}} ({{$booking['@attributes']['Origin']}})<br />
                    <span style="font-size:14px; color:#111111;">{{date('d M Y', strtotime(DateTimeSpliter($booking['@attributes']['DepartureTime'],"date")))}} &nbsp; {{DateTimeSpliter($booking['@attributes']['DepartureTime'],"time")}}</span><br />
                    <span style="font-size:13px; color:#555555;">Travel Time: {{segmentTime($booking['@attributes']['segmentDetails']['@attributes']['TravelTime'])}}</span><br />
                    <span style="font-size:13px; color:#555555;">Cabin Class: {{($booking['@attributes']['segmentDetails']['@attributes']['CabinClass'])}}</span><br />
                    
                  <td valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$booking['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails']->city_name}} ({{$booking['@attributes']['segmentDetails']['@attributes']['Destination']}})<br />
                    <span style="font-size:14px; color:#111111;">{{date('d M Y', strtotime(DateTimeSpliter($booking['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],"date")))}} &nbsp; {{DateTimeSpliter($booking['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],"time")}}</span><br />
                    
                    <span style="font-size:13px; color:#555;">Plane Type: 
                            @if(isset($booking['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']) && !empty($booking['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']))
                            {{$booking['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']->short_name}}
                            @else
                            {{$booking['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['Equipment']}}
                            @endif
                    
                    </span><br /></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:0px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
            Baggage Details
            </h3></td>
        </tr>
        <tr >
          <td class="tablepadding" style="padding:20px 20px 25px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
              <thead>
                <tr>
                    <th  style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">&nbsp;</th>
                    <td  style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Cabin </td>
                    <td  style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Check In</td>
                </tr>
              </thead>
              <tbody>
                @foreach($booking['@attributes']['baggageDetails'] as $pk=>$pass)
                <tr>
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$pk}} </td>
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">7 kg</td>
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$pass['checkIn']['value'].' '.$pass['checkIn']['unit']}} </td>
                
               
                </tr>
                @endforeach
              </tbody>
            </table></td>
        </tr>
      </table>
    </td>    
  </tr>
  @endforeach
      
  
  <tr>
    <td align="center" valign="top">
      <table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="#ffffff" style="border-width:1px; border-style: solid; border-collapse: separate; border-color:#ededed; margin-top:20px;     margin-left: 20px;font-family:Arial, Helvetica, sans-serif">
        <tr >
          <td style="padding:0px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
            Cancellation Fee
            </h3></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px 20px 25px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
            <thead>
                <tr>
                <th  style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">&nbsp;</th>
                <td  style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Cancel Fee (Per Passenger) </td>
                <td  style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Change Fee (Per Passenger)</td>
                </tr>
            </thead>
            <tbody>
                @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty'])  || !empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']))
                <tr>
                    <td width="20%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">Adult</td>
                    <td width="40%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">
                    @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']))
                        {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']['type'] == 'percentage') ? '%':''}}
                    @endif
                    </td>
                    <td width="40%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">
                    @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']))
                        {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']['type'] == 'percentage') ? '%':''}}
                    @endif
                    </td>
                </tr>
                @endif
                @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']) || !empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']))
                <tr>
                  <td width="20%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">Child</td>
                  <td width="40%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">
                  @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']['type'] == 'percentage') ? '%':''}} 
                    @endif
                  </td>
                  <td width="40%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">
                    @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']['type'] == 'percentage') ? '%':''}}
                    @endif
                  </td>
                </tr>
            @endif
            @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']) || !empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']) )
                <tr>
                <td width="20%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">Infant</td>
                    <td width="40%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">
                    @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']['type'] == 'percentage') ? '%':''}} 
                    @endif
                    </td>
                
                    <td width="40%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">
                    @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']['type'] == 'percentage') ? '%':''}}
                    @endif
                    </td>
                </tr>
            @endif
                
                
                
            </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:0px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
            Terms & Conditions
            </h3></td>
        </tr>
        <tr>
          <ul>
            <li>The penalty is subject to 4 hrs before departure. No Changes are allowed after that.</li>
            <li>The charges are per passenger per sector.</li>
            <li>Partial cancellation is not allowed on tickets booked under special discounted fares.</li>
            <li>In case of no-show or ticket not cancelled within the stipulated time, only statutory taxes are refundable subject to Service Fee.</li>
            <li>No Baggage Allowance for Infants</li>
            <li>Airline penalty needs to be reconfirmed prior to any amendments or cancellation.</li>
            <li>24flights admin charges applicable</li>
            <li>The add on service charges, convenience fee and discount you have received using coupon code is non refundable</li>
            <li>For exact cancellation/change fee, please call us at our customer care number.</li>
          </ul>
        </tr>
       
      </table>
    </td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
        <tbody>
          <tr>
            <td class="tablepadding" style="padding:20px 0; border-collapse:collapse">
              <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
                <tbody>
                  <tr>
                    <td class="tablepadding" align="center" style="line-height:20px; padding-top:10px; padding-bottom:20px;">Copyright &copy; {{date('Y')}} 24Flights. All Rights Reserved. </td>
                  </tr>
                  
                </tbody>
              </table></td>
          </tr>
        </tbody>
      </table></td>
  </tr>
</table>
</body>
</html>