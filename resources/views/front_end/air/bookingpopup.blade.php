<style>
  .table:not(.table-sm) > :not(caption) > * > * {
    padding: 0.25rem 0.25rem !important;
}
  </style>

<div class="invoice-container" style="padding: 0px;    border: 0px solid #ccc;">
    <div class="row align-items-center">
      <div class="col-7"> <img src="{{asset("frontEnd/images/logo.png")}}" title="24Flights" /> </div>
      <div class="col-5 text-center">

        <div class="btn-group btn-group-sm float-end d-print-none"> 
             <a  class="btn btn-light border text-black-50 shadow-none download-pdf" href = "{{asset($result['flightBookingDetails']->flight_ticket_path)}}" download><i class="fa fa-download" ></i> Download</a> 
            </div>
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
    {{-- <h5>Passenger Information</h5>
    <br>
  <div class="table-responsive-md">
    <table class="table table-bordered">
      <tbody>
        @foreach($result['passengersList'] as $TravelsInfo)
        <tr>
          <td class="text-center">{{$TravelsInfo['travelerType']}}</td>
          <td class="text-center">{{$TravelsInfo['prefix']}} </td>
          <td class="text-center">{{$TravelsInfo['firstName']}} {{$TravelsInfo['lastName']}} </td>
          <td class="text-center">{{$TravelsInfo['ticketNumber']}} </td>
        </tr>
        @endforeach
        
      </tbody>
    </table>
  </div> --}}

  <hr>
  @if(count($result['airLinePnrs']) >1)
  <h5>Airline Pnrs</h5>
  <div class="table-responsive-md">
    <table class="table table-bordered">
      <thead>
        <tr>
          <td class="text-center">Airline</td>
          <td class="text-center">PNR</td>
        </tr>
      </thead>
      <tbody>
        @foreach($result['airLinePnrs'] as $supplierCode)
        <tr>
          <td class="text-center">{{$supplierCode['airline']}}</td>
          <td class="text-center">{{$supplierCode['pnr']}} </td>
        </tr>
        @endforeach
        
      </tbody>
    </table>
  </div>
  <hr>
  @endif
    @foreach($result['segments'] as $segment)
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
          <div class="col-12 col-sm-3 text-center text-md-start d-lg-flex company-info"> <span class="align-middle"><img class="img-fluid" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$segment['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-2 text-dark mt-1 mt-lg-0">{{$segment['AirLine']->name}}</span> <small class="text-muted d-block">{{$segment['FlightNumber']}}</small> </span> </div>
          <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{$segment['DepartureTime']}}</span> <small class="text-muted d-block">Departure</small> </div>
          <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-3 text-dark">{{$segment['FlightTime']}}</span> <small class="text-muted d-block">Duration</small> </div>
          <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{$segment['ArrivalTime']}}</span> <small class="text-muted d-block">Arrival</small> </div>
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
          <div class="col-6 text-1 lh-base"> <strong class="text-uppercase text-2 fw-600">Airport Info</strong><br>
            {{$segment['OriginAirportDetails']->name}},<br>
            {{$segment['OriginAirportDetails']->city_name}}<br>
            {{-- @if(isset($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['OriginTerminal']))
                Terminal {{$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['OriginTerminal']}}
            @endif --}}
  
            <div class="d-flex align-items-center my-1">
              <hr class="flex-grow-1 my-2">
              <span class="mx-2">to</span>
              <hr class="flex-grow-1 my-2">
            </div>
            {{$segment['DestinationAirportDetails']->name}},<br>
            {{$segment['DestinationAirportDetails']->city_name}}<br>
            {{-- @if(isset($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['DestinationTerminal']))
              Terminal {{$bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['DestinationTerminal']}}
            @endif --}}
  
          </div>
          {{-- {{dd($bookinginfo['@attributes']['segmentDetails']['air:FlightDetails']['@attributes']['EquipmentDetails'])}} --}}
          <div class="col-6 text-1 lh-base"> <strong class="text-uppercase text-2 fw-600">Flight Info</strong><br>
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
        </div>
        @elseif($result['flightBookingDetails']->supplier_type == 'airarabia')
        <div class="table-responsive-md">
          <ul>
            <li>Include a generous 10 KG Hand Baggage</li>
          </ul>
        </div>
        @endif
        <h5>Passenger Information</h5>
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
  <br>
  <hr>
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