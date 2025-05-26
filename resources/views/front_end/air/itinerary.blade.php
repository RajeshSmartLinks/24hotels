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
</head>
<body>
<div class="container-fluid invoice-container">
  <div class="row align-items-center">
    <div class="col-7"> <img src="{{asset("frontEnd/images/logo.png")}}" title="24Flights" /> </div>
    <div class="col-5 text-center">
      <div class="btn-group btn-group-sm float-end d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> <a  class="btn btn-light border text-black-50 shadow-none download-pdf" onclick="generatePdf('{{encrypt($traceId)}}')"><i class="fa fa-download"></i> Download</a> </div>
    </div>
  </div>
  <hr >
  <div class="row">
    <div class="col-6">
        <div style="text-align: center;">PNR : {{$response['universal:UniversalRecord']['@attributes']['LocatorCode']}}</div>
    </div>
    <div class="col-6">
        <div style="text-align: center;">Booking Ref Id : {{$flightbookingdetails->booking_ref_id}}</div>
    </div>
  </div>
  <hr>
  @foreach($response['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'][0]['air:BookingInfo'] as $bookinginfo)
    {{-- {{dd($bookinginfo['@attributes']['segmentDetails'])}} --}}
    <div class="card mt-4">
      <div class="card-header">
        <div class="row align-items-center trip-title">
          <div class="col-5 col-sm-auto text-center text-sm-start">
            <h5 class="m-0 trip-place">{{$bookinginfo['@attributes']['segmentDetails']['@attributes']['OriginAirportDetails']->city_name}} ({{$bookinginfo['@attributes']['segmentDetails']['@attributes']['Origin']}})</h5>
          </div>
          <div class="col-2 col-sm-auto text-8 text-black-50 text-center trip-arrow">➝</div>
          <div class="col-5 col-sm-auto text-center text-sm-start">
            <h5 class="m-0 trip-place">{{$bookinginfo['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails']->city_name}} ({{$bookinginfo['@attributes']['segmentDetails']['@attributes']['Destination']}})</h5>
          </div>
          <div class="col-12 mt-1 d-block d-md-none"></div>
          <div class="col-6 col-sm col-md-auto text-3 date"> {{date('d M D', strtotime(DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['DepartureTime'],"date")))}} ,{{date('d M D', strtotime(DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],"date")))}} </div>
          @if($bookinginfo['@attributes']['segmentDetails']['@attributes']['Status'] == 'HK')
          <div class="col col-md-auto text-center ms-auto order-sm-0"><span class="badge bg-success py-1 px-2 fw-normal text-0">Confirmed <i class="fas fa-check-circle"></i></span></div>
          @else
          <div class="col col-md-auto text-center ms-auto order-sm-0"><span class="badge bg-danger py-1 px-2 fw-normal text-0">Not - Confirmed <i class="fas fa-check-circle"></i></span></div>
          @endif
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-3 text-center text-md-start d-lg-flex company-info"> <span class="align-middle"><img class="img-fluid" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$bookinginfo['@attributes']['segmentDetails']['@attributes']['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-2 text-dark mt-1 mt-lg-0">{{$bookinginfo['@attributes']['segmentDetails']['@attributes']['airLineDetais']->name}}</span> <small class="text-muted d-block">{{$bookinginfo['@attributes']['segmentDetails']['@attributes']['FlightNumber']}}</small> </span> </div>
          <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['DepartureTime'],"time")}}</span> <small class="text-muted d-block">Departure</small> </div>
          <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-3 text-dark">{{segmentTime($bookinginfo['@attributes']['segmentDetails']['@attributes']['TravelTime'])}}</span> <small class="text-muted d-block">Duration</small> </div>
          <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{DateTimeSpliter($bookinginfo['@attributes']['segmentDetails']['@attributes']['ArrivalTime'],"time")}}</span> <small class="text-muted d-block">Arrival</small> </div>
        </div>
        <p class="mt-3 lh-base text-1">
          Class of Service: {{$bookinginfo['@attributes']['segmentDetails']['@attributes']['CabinClass']}}</p>
        <div class="row">
          <div class="col-5 text-1 lh-base"> <strong class="text-uppercase text-2 fw-600">Airport Info</strong><br>
            {{$bookinginfo['@attributes']['segmentDetails']['@attributes']['OriginAirportDetails']->name}},<br>
            {{$bookinginfo['@attributes']['segmentDetails']['@attributes']['OriginAirportDetails']->city_name}}<br>
  
            <div class="d-flex align-items-center my-1">
              <hr class="flex-grow-1 my-2">
              <span class="mx-2">to</span>
              <hr class="flex-grow-1 my-2">
            </div>
            {{$bookinginfo['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails']->name}},<br>
            {{$bookinginfo['@attributes']['segmentDetails']['@attributes']['DestinationAirportDetails']->city_name}}<br>
  
          </div>
          {{-- {{dd($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails'])}} --}}
          <div class="col-7 text-1 lh-base"> <strong class="text-uppercase text-2 fw-600">Flight Info</strong><br>
            @if(isset($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']) && !empty($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']))
            {{$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails']->short_name}}
            @else
            {{$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['Equipment']}}
            @endif
            <br>
  
          </div>
        </div>
        <br>
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
                @foreach($bookinginfo['@attributes']['baggageDetails'] as $pk=>$pass)
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
      </div>
    </div>
  @endforeach 
  <br><h5>Passenger Information</h5>
  <div class="table-responsive-md">
    <table class="table table-hover table-bordered">
      <thead>
        <tr>
       
          <td class="text-center">First Name</td>
          <td class="text-center">Last Name</td>
        </tr>
      </thead>
      <tbody>
        @foreach($response['universal:UniversalRecord']['common_v52_0:BookingTraveler'] as $TravelsInfo)
        <tr>
          <td class="text-center">{{$TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['First']}} </td>
        
          <td class="text-center">{{$TravelsInfo['common_v52_0:BookingTravelerName']['@attributes']['Last']}} </td>

        </tr>
        @endforeach
        
      </tbody>
    </table>
  </div>
  <br><h5>Chargers</h5>
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
                {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultCancelPenalty']['type'] == 'percentage') ? '%':''}}
              @endif
            </td>
            <td class="text-center">
              @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']))
                {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['AdultChangePenalty']['type'] == 'percentage') ? '%':''}}
              @endif
            </td>
          </tr>
        @endif
        @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']) || !empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']))
          <tr>
            <td>Child</td>
            <td class="text-center">
              @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']))
                {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenCancelPenalty']['type'] == 'percentage') ? '%':''}} 
              @endif
            </td>
            <td class="text-center">
              @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']))
                {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['childrenChangePenalty']['type'] == 'percentage') ? '%':''}}
              @endif
            </td>
          </tr>
        @endif
        @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']) || !empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']) )
          <tr>
            <td>Infant</td>
              <td class="text-center">
                @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']))
                {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantCancelPenalty']['type'] == 'percentage') ? '%':''}} 
                @endif
              </td>
         
              <td class="text-center">
                @if(!empty($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']))
                {{$response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']['value']}} {{($response['universal:UniversalRecord']['air:AirReservation']['chargers']['infantChangePenalty']['type'] == 'percentage') ? '%':''}}
                @endif
              </td>
          </tr>
        @endif
      </tbody>
  </table>
  </div>
</div>
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