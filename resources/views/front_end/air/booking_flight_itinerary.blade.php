<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{{asset('frontEnd/images/favicon.png')}}" rel="icon" />
<title>{{ env('APP_NAME') }} - {{ isset($titles['title']) && !empty($titles['title']) ? $titles['title'] : '' }}</title>


<meta name="author" content="harnishdesign.net">

<!-- Web Fonts
    ============================================= -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<!-- Bootstrap -->
<link href="{{ asset('frontEnd/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('frontEnd/vendor/font-awesome/css/all.min.css')}}" rel="stylesheet">

<!-- Styling -->
<link rel="stylesheet" type="text/css" href="{{ asset('frontEnd/css/stylesheet.css')}}" />
<style>
  .table:not(.table-sm) > :not(caption) > * > * {
    padding: 0.25rem 0.25rem !important;
}
  </style>
</head>
<body>
  @if(!isset($error))
    <div class="container-fluid invoice-container">
      <div class="row align-items-center">
        <div class="col-7"> <img src="{{asset("frontEnd/images/logo.png")}}" title="24Flights" /> </div>
        <div class="col-5 text-center">
          <div class="btn-group btn-group-sm float-end d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> <a  class="btn btn-light border text-black-50 shadow-none download-pdf" 
            {{-- onclick="generatePdf('{{encrypt($traceId)}}')" --}}
            download href="{{asset($result['flightBookingDetails']->flight_ticket_path)}}"><i class="fa fa-download"></i> Download</a> </div>
        </div>
      </div>
      <hr >
      <div class="row">
        @if(count($result['airLinePnrs']) == 1 )
        <div class="col-6">
            <div style="text-align: center;">PNR : {{ $result['airLinePnrs'][0]['pnr']}}</div>
        </div>
        <div class="col-6">
        @else
        <div class="col-12">
        @endif  
            <div style="text-align: center;">Booking Ref Id : {{$result['flightBookingDetails']->booking_ref_id}}</div>
        </div>
      </div>
      <hr>
      <br>
      @if(count($result['airLinePnrs']) >1)
      <tr>
        <td style="padding:0px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
          Airline Pnrs
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
      @foreach($result['segments'] as $segment)
        {{-- {{dd($bookinginfo['@attributes']['segmentDetails'])}} --}}
        <div class="card mt-4">
          <div class="card-header">
            <div class="row align-items-center trip-title">
              <div class="col-5 col-sm-auto text-center text-sm-start">
                <h5 class="m-0 trip-place">{{$segment['OriginAirportDetails']->city_name}} ({{$segment['OriginAirportDetails']->airport_code}})</h5>
              </div>
              <div class="col-2 col-sm-auto text-8 text-black-50 text-center trip-arrow">➝</div>
              <div class="col-5 col-sm-auto text-center text-sm-start">
                <h5 class="m-0 trip-place">{{$segment['DestinationAirportDetails']->city_name}} ({{$segment['DestinationAirportDetails']->airport_code}})</h5>
              </div>
              <div class="col-12 mt-1 d-block d-md-none"></div>
              <div class="col-6 col-sm col-md-auto text-3 date"> {{date('d M D', strtotime($segment['DepartureDate']))}} ,{{date('d M D', strtotime($segment['ArrivalDate']))}} </div>
              @if($segment['Status'] == 'Confirmed')
              <div class="col col-md-auto text-center ms-auto order-sm-0"><span class="badge bg-success py-1 px-2 fw-normal text-0">Confirmed <i class="fas fa-check-circle"></i></span></div>
              @else
              <div class="col col-md-auto text-center ms-auto order-sm-0"><span class="badge bg-danger py-1 px-2 fw-normal text-0">Not - Confirmed <i class="fas fa-check-circle"></i></span></div>
              @endif
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-3 text-center text-md-start d-lg-flex company-info"> <span class="align-middle"><img class="img-fluid" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$segment['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-2 text-dark mt-1 mt-lg-0">{{$segment['AirLine']->name}}</span> <small class="text-muted d-block" style="color: black">{{$segment['FlightNumber']}}</small> </span> </div>
              <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{$segment['DepartureTime']}}</span> <small class="text-muted d-block" style="color: black">Departure</small> </div>
              <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-3 text-dark">{{$segment['FlightTime']}}</span> <small class="text-muted d-block">Duration</small> </div>
              <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{$segment['ArrivalTime']}}</span> <small class="text-muted d-block" style="color: black">Arrival</small> </div>
            </div>
            <div class ="row">
              <div class ="col-6">
                <p class="mt-3 lh-base text-1">
                  Class of Service: {{$segment['Class']}}</p>
              </div>
              <div class ="col-6">
                <p class="mt-3 lh-base text-1">
                  Ticket Type: 
                  @if($segment['Refundable'])
                  Refundable
                  @else
                    Non-Refundable
                  @endif   
                
                </p>
              </div>
    
            </div>
            <div class="row">
              <div class="col-5 text-1 lh-base"> <strong class="text-uppercase text-2 fw-600">Airport Info</strong><br>
                {{$segment['OriginAirportDetails']->name}},<br>
                {{$segment['OriginAirportDetails']->city_name}}<br>
      
                <div class="d-flex align-items-center my-1">
                  <hr class="flex-grow-1 my-2">
                  <span class="mx-2">to</span>
                  <hr class="flex-grow-1 my-2">
                </div>
                {{$segment['DestinationAirportDetails']->name}},<br>
                {{$segment['DestinationAirportDetails']->city_name}}<br>
      
              </div>
              {{-- {{dd($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails'])}} --}}
              <div class="col-7 text-1 lh-base"> <strong class="text-uppercase text-2 fw-600">Flight Info</strong><br>
                {{-- @if(isset($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']) && !empty($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']))
                {{$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']->short_name}}
                @else
                {{$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['Equipment']}}
                @endif --}}
                {{$segment['FlightName']}}
                <br>
      
              </div>
            </div>
            <br>
            @if($result['flightBookingDetails']->supplier_type == 'travelport')
            <div class="table-responsive-md">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>&nbsp;</th>
                      <td class="text-center">Cabin</td>
                      <td class="text-center">Check-In</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($segment['CheckIn'] as $pk=>$pass)
                    <tr>
                      <td>{{$pk}}</td>
                      <td class="text-center">7 kg</td>
                      @if($pass['checkIn']['type'] == "weight")
                      <td class="text-center">{{$pass['checkIn']['value'].' '.$pass['checkIn']['unit']}} </td>
                      @elseif($pass['checkIn']['type'] == "Pcs")
                      <td class="text-center">{{$pass['checkIn']['value'].' '.$pass['checkIn']['unit']}} </td>
                      @endif
                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>

              
              {{-- @endforeach --}}
            </div>
            @elseif($result['flightBookingDetails']->supplier_type == 'airarabia')
            <div class="table-responsive-md">
              <ul>
                <li>Include a generous 10 KG Hand Baggage</li>
              </ul>
            </div>
            @endif
            <div class="table-responsive-md">
              <table class="table table-bordered">
                <tbody>
                  @foreach($segment['passengersList'] as $TravelsInfo)
                  <tr>
                    <td class="text-center">{{$TravelsInfo['travelerType']}}</td>
                    <td class="text-center">{{$TravelsInfo['prefix']}} </td>
                    <td class="text-center">{{$TravelsInfo['firstName']}} {{$TravelsInfo['lastName']}} </td>
                    <td class="text-center">{{$TravelsInfo['ticketNumber']}} </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div> 
          </div>
        </div>
      @endforeach 
     
      {{-- <br><h5>Cancellation Chargers</h5>
      <div class="table-responsive-md">
        <table class="table table-hover table-bordered">
          <thead>
          <tr>
              <th>&nbsp;</th>
              <td class="text-center">{{__('lang.cancel_fee_per_passenger')}} </td>
              <td class="text-center">{{__('lang.change_fee_per_passenger')}} </td>
          </tr>
          </thead>
          <tbody>
            @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty'])  || !empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']))
              <tr>
                <td>Adult</td>
                <td class="text-center">
                  @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']['type'] == 'percentage') ? '%':''}}+ admin charges
                  @endif
                </td>
                <td class="text-center">
                  @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']['type'] == 'percentage') ? '%':''}}+ admin charges
                  @endif
                </td>
              </tr>
            @endif
            @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']) || !empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']))
              <tr>
                <td>Child</td>
                <td class="text-center">
                  @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']['type'] == 'percentage') ? '%':''}} + admin charges
                  @endif
                </td>
                <td class="text-center">
                  @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']['type'] == 'percentage') ? '%':''}}+ admin charges
                  @endif
                </td>
              </tr>
            @endif
            @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']) || !empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']) )
              <tr>
                <td>Infant</td>
                  <td class="text-center">
                    @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']['type'] == 'percentage') ? '%':''}} + admin charges
                    @endif
                  </td>
            
                  <td class="text-center">
                    @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']))
                    {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']['type'] == 'percentage') ? '%':''}}+ admin charges
                    @endif
                  </td>
              </tr>
            @endif
          </tbody>
        </table>
        <div class ="text-center" style="color: black">Airline penalty needs to be reconfirmed prior to any amendments or cancellation.</div>
        <div class ="text-center" style="color: black">24flights admin charges applicable</div>
      </div> --}}
      <br>
      @if($result['flightBookingDetails']->supplier_type == 'airarabia' && !empty($result['extrabaggageinfo']))
      <h5>Extra Baggage Info</h5>
      <br>
      <div class="table-responsive-md">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td class="text-center">Name</td>
              <td class="text-center">Depature Baggage</td>
              @if($result['flightBookingDetails']->booking_type == 'roundtrip')
              <td class="text-center">Return Baggage</td>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($result['extrabaggageinfo'] as $extrabaggage)
            <tr>
              <td class="text-center">{{$extrabaggage->first_name}} {{$extrabaggage->last_name}} </td>
              <td class="text-center">{{$extrabaggage->depature_extra_baggage}}</td>
              @if($result['flightBookingDetails']->booking_type == 'roundtrip')
              <td class="text-center">{{$extrabaggage->return_extra_baggage}} </td>
              @endif
            </tr>
            @endforeach
            
          </tbody>
        </table>
      </div>
      @endif
      <br>
      <h5>Terms & Conditions</h5>
      <div class="table-responsive-md">
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
      </div>
      <br>
    </div>
  @else
  <div class="container-fluid invoice-container">
    <div class="row align-items-center">
      <div class="col-7"> <img src="{{asset("frontEnd/images/logo.png")}}" title="24Flights" /> </div>
      <div class="col-5 text-center">
      
      </div>
    </div>
    <hr >
    <div class="row">
      <div class="col-12">
          <div style="text-align: center;">{{$error}}</div>
      </div>
      
    </div>
  </div>
  @endif 
<p class="text-center d-print-none"><a href="{{url('/')}}">&laquo; Back to Home</a></a></p>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
 
    function generatePdf(traceId)
    {
      var data = {'traceId' : traceId};
      var route = "{{route('pdf-generator')}}";
      $.ajax({
          type: 'GET',
          url: route,
          data: data,
          xhrFields: {
              responseType: 'blob'
          },
          success: function(response){
            console.log(response);
              var blob = new Blob([response]);
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.download = new Date().getTime()+".pdf";
              link.click();
          },
          error: function(blob){
              console.log(blob);
          }
      });

    }
  </script>