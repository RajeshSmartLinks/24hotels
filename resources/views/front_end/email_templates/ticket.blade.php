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
        @if($result['flightBookingDetails']->internal_booking == 1)
        <tr>
          <td style="font-size:14px; line-height:28px;padding:0px 20px;">Address : Off NO.15, Street 39,Karama,Dubai -UAE  <a href="tel:+971 504300107">+971 50 430 0107</a><br>
            <a href="mailto: booking@24flights.com">booking@24flights.com</a></td>
        </tr>
        @endif
        <tr>
          <td style="padding:0px 20px;"><table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="border:4px solid #eee; border-radius:4px; padding:25px 0px;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                      <tbody>
                        <tr>
                          <td style="font-size:14px; padding:0px 25px;" width="50">
                            @if($result['flightBookingDetails']->ticket_status == 1)
                            <img alt="" src="{{asset("frontEnd/images/booking-successful.png")}}">
                            @else
                            <img alt="" src="{{asset("frontEnd/images/pending.jpg")}}">
                            @endif
                          </td>
                          <td style="font-size:16px; font-weight:600; color:#777; line-height:26px; padding-right:20px;"><span style="font-size:13px;">Hi {{$result['user']}} ,
                          </span><br>
                            @if($result['flightBookingDetails']->ticket_status == 1)
                              Congratulations! Your flight booking is <span style="color:#28a745;">confirmed</span>.
                            @else
                              Your flight booking ticket is <span style="color:red;"> Not - Confirmed</span>.
                            @endif
                          </td>
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
                @if(count($result['airLinePnrs']) == 1 )
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">PNR -</span> <a style="outline:none; color:#0071cc; text-decoration:none;" href="#">{{ $result['airLinePnrs'][0]['pnr']}}</a></td>
                </tr>
                @endif
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Booking Status -</span> {{$result['flightBookingDetails']->ticket_status == 1 ? 'Confirmed' : 'Not - Confirmed'}}</td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:28px;">Thank you for booking your travel itinerary with 24Flights.</td>
                </tr>
              </tbody>
            </table></td>
        </tr>

        @if(count($result['airLinePnrs']) >1)
        <tr>
          <td style="padding:0px 20px 0px;">
            <h3 style="margin:0; font-weight:normal; color:#444444;">
            Airline Pnrs
            </h3></td>
            <td style="padding:0px 20px 0px;">
              <h3 style="margin:0; font-weight:normal; color:#444444;">
              Pnrs
            </h3></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px 20px 25px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
              <tbody>
                @foreach($result['airLinePnrs'] as $supplierCode)
                <tr>
                  <td width="60%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$supplierCode['airline']}} </td>
                  <td width="30%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$supplierCode['pnr']}}</td>
                </tr>
                @endforeach
              </tbody>
            </table></td>
        </tr>
        @endif


        <tr>
          <td class="tablepadding" style="background:#f8f8f8;border-top:1px solid #e9e9e9;border-bottom:1px solid #e9e9e9;padding:13px 20px;"><table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td style="font-size:14px; line-height:20px;"><span style="color:#909090">Booking Date:</span><br />
                    <span style="color:#000000;display:inline-block">{{date('d M, Y', strtotime($result['flightBookingDetails']->created_at))}}</span></td>

                    @if(count($result['airLinePnrs']) == 1 )
                    <td style="font-size:14px; line-height:20px;"><span style="color:#909090">PNR:</span><br />
                      <a style="outline:none; color:#0071cc; text-decoration:none;" href="#">{{ $result['airLinePnrs'][0]['pnr']}}</a></td>
                    @endif
                  <td style="font-size:14px; line-height:20px;"><span style="color:#909090">Payment:</span><br />
                    by {{$result['flightBookingDetails']->payment_gateway}}</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
      </table>
    </td>    
  </tr>

  @foreach($result['segments'] as $segment)
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
                  <td width="25%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;"><img style="height: 40px;width:40px" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$segment['Carrier']}}.png"><br />
                    {{$segment['AirLine']->name}}<br />
                    @if($result['flightBookingDetails']->supplier_type == 'airarabia')
                    <span style="font-size:13px; color:#555;">{{$segment['FlightNumber']}}</span>
                    @else
                    <span style="font-size:13px; color:#555;">{{$segment['Carrier']}}-{{$segment['FlightNumber']}}</span>
                    @endif
                   
                  </td>
                  <td valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">  {{$segment['OriginAirportDetails']->city_name}} ({{$segment['OriginAirportDetails']->airport_code}})<br />
                    <span style="font-size:14px; color:#111111;">{{date('d M Y', strtotime($segment['DepartureDate']))}} &nbsp; {{$segment['DepartureTime']}}</span><br />
                    <span style="font-size:13px; color:#555555;">Travel Time: {{$segment['FlightTime']}}</span><br />
                    <span style="font-size:13px; color:#555555;">Cabin Class: {{$segment['Class']}}</span><br />
                    
                  <td valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$segment['DestinationAirportDetails']->city_name}} ({{$segment['DestinationAirportDetails']->airport_code}})<br />
                    <span style="font-size:14px; color:#111111;">{{date('d M Y', strtotime($segment['ArrivalDate']))}} &nbsp; {{$segment['ArrivalTime']}}</span><br />
                    
                    <span style="font-size:13px; color:#555;">Plane Type: 
                            {{-- @if(isset($booking['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']) && !empty($booking['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']))
                            {{$booking['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']->short_name}}
                            @else
                            {{$booking['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['Equipment']}}
                            @endif --}}
                            {{$segment['FlightName']}}
                    
                    </span><br /></td>
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
              <tbody>
                @foreach($segment['passengersList'] as $TravelsInfo)
                <tr>
                  <td width="15%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$TravelsInfo['travelerType']}} </td>
                  <td width="18%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$TravelsInfo['prefix']}} </td>
                  <td width="55%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$TravelsInfo['firstName']}} {{$TravelsInfo['lastName']}}</td>
                  <td width="22%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$TravelsInfo['ticketNumber']}} </td>
                </tr>
                @endforeach
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:0px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
            Baggage Details
            </h3></td>
        </tr>
        @if($result['flightBookingDetails']->supplier_type == 'travelport')
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
                @foreach($segment['CheckIn'] as $pk=>$pass)
                <tr>
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$pk}} </td>
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">7 kg</td>
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$pass['checkIn']['value'].' '.$pass['checkIn']['unit']}} </td>
                
               
                </tr>
                @endforeach
              </tbody>
            </table></td>
        </tr>
        @elseif($result['flightBookingDetails']->supplier_type == 'airjazeera')

        @if(isset($result['baggageInfo']) && !empty($result['baggageInfo']))

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
                @foreach($result['baggageInfo'] as $passengerType => $baggage)
                  @if($baggage['class']===$segment['Class'] && $baggage['flightNumber']===$segment['FlightNumber'])
                  <tr>
                      <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$baggage['travelerType']}} </td>
                      <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;"> @if (isset($baggage['info']['carryOn']))
                              {{ $baggage['info']['carryOn']['value'] }} {{ $baggage['info']['carryOn']['unit'] }}
                          @else
                              0 Kilograms
                          @endif</td>
                      <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;"> @if (isset($baggage['info']['checkIn']))
                            @if ($baggage['info']['checkIn']['type'] == 'weight')
                                {{ $baggage['info']['checkIn']['value'] }} {{ $baggage['info']['checkIn']['unit'] }}
                            @endif
                        @else
                            0 Kilograms
                        @endif</td>
                  </tr>
                  @endif
                @endforeach
              </tbody>
            </table></td>
        </tr>
        @endif

        @elseif($result['flightBookingDetails']->supplier_type == 'airarabia')
          <tr>
            <ul>
              <li>Include a generous 10 KG Hand Baggage</li>
            </ul>
          </tr>
        @endif
      </table>
    </td>    
  </tr>
  @endforeach
  @if($result['flightBookingDetails']->supplier_type == 'airarabia' && !empty($result['extrabaggageinfo']))
  <tr>
    <td align="center" valign="top">
      <table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="#ffffff" style="border-width:1px; border-style: solid; border-collapse: separate; border-color:#ededed; margin-top:20px;     margin-left: 20px;font-family:Arial, Helvetica, sans-serif">
        <tr>
          <td style="padding:25px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
            Extra Baggage Details
            </h3></td>
        </tr>
        
        <tr >
          <td class="tablepadding" style="padding:20px 20px 25px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
              <thead>
                <tr>
                    <th  style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Name</th>
                  
                    <td  style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Depature Extra Baggage </td>
                  
                    @if($result['flightBookingDetails']->booking_type == 'roundtrip')
                    <td  style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Return Extra Baggage</td>
                    @endif
                </tr>
              </thead>
              <tbody>
                @foreach($result['extrabaggageinfo'] as $extrabaggage)
                <tr>
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$extrabaggage->first_name}} {{$extrabaggage->last_name}} </td>
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$extrabaggage->depature_extra_baggage}}</td>
                    @if($result['flightBookingDetails']->booking_type == 'roundtrip')
                    <td width="33%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$extrabaggage->return_extra_baggage}} </td>
                    @endif
                </tr>
                @endforeach
              </tbody>
            </table></td>
        </tr>
    
      </table>
    </td>    
  </tr>
  @endif
      
  
  <tr>
    <td align="center" valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="#ffffff" style="border-width:1px;border-style:solid;border-collapse:separate;border-color:#ededed;margin-top:20px;margin-left:20px;font-family:Arial,Helvetica,sans-serif">
        
        <tbody><tr>
          <td style="padding:0px 20px 0px"><h3 style="margin-top: 25px;font-weight:normal;color:#444444">
            Terms &amp; Conditions
            </h3></td>
        </tr>
        <tr>
          <td><ul>
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
        </td></tr>
       
      </tbody></table>
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