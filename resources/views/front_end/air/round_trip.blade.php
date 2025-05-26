@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.flights_round_trip')}} </h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}} </a></li>
            <li><a href="#">{{__('lang.flights')}} </a></li>
            <li class="active">{{__('lang.flights_round_trip_breadcurm')}} </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Page Header end --> 
  
  <!-- Content
  ============================================= -->
  <div id="content">
    <section class="container">
      <form id="bookingFlight" method="get" action="{{route('SearchFlights')}}">
        <div class="mb-3">
          <div class="form-check form-check-inline">
            <input id="oneway" name="flight-trip" class="form-check-input" {{app('request')->input('flight-trip') == "onewaytrip"?"checked":""}} required type="radio" value = "onewaytrip" >
            <label class="form-check-label" for="oneway">{{__('lang.one_way')}}</label>
            
          </div>
          <div class="form-check form-check-inline">
            <input id="roundtrip" name="flight-trip" class="form-check-input" {{app('request')->input('flight-trip') == "roundtrip"?"checked":""}} required type="radio" value = "roundtrip">
            <label class="form-check-label" for="roundtrip">{{__('lang.round_trip')}}</label>
          </div>
        </div>
        <div class="row g-3 mb-4">
          <div class="col-md-6 col-lg-2">
            <div class="position-relative">
              <input type="text" class="form-control" name = "flightFrom" id="flightFrom" required placeholder="{{__('lang.from')}}" value="{{app('request')->input('flightFrom')}}">
              <input type="hidden" class="form-control" id="flightFromAirportCode"  name = "flightFromAirportCode" value="{{app('request')->input('flightFromAirportCode')}}" >
              <span class="icon-inside"   onclick="switchFlightDir()"><i class="fas fa-exchange-alt arrowicon"></i></span> 
            </div>
          </div>
          <div class="col-md-6 col-lg-2">
            <div class="position-relative">
              <input type="text" class="form-control" id="flightTo" name = "flightTo" required  placeholder="{{__('lang.to')}}" value="{{app('request')->input('flightTo')}}">
              <input type="hidden" class="form-control" id="flightToAirportCode"  name = "flightToAirportCode"  value="{{app('request')->input('flightToAirportCode')}}">
            </div>
              
          </div>
          <div class="col-md-6 col-lg-2">
            <div class="position-relative">
              <input id="flightDepart" type="text" class="form-control" required placeholder="{{__('lang.depart_date')}}" name="DepartDate" autocomplete="off" value="{{app('request')->input('DepartDate')}}">
              <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> </div>
          </div>
          <div class="col-md-6 col-lg-2">
            <div class="position-relative">
              <input id="flightReturn" type="text" class="form-control"  placeholder="{{__('lang.return_date')}}" name = "ReturnDate" autocomplete="off" value="{{app('request')->input('ReturnDate')}}" >
              <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> </div>
          </div>
          <div class="col-md-6 col-lg-2">
            <div class="travellers-class">
              <input type="text" id="flightTravellersClass" class="travellers-class-input form-control" name="flight-travellers-class" value="{{app('request')->input('flight-travellers-class')}}" placeholder="Travellers, Class" readonly required onkeypress="return false;">
              <span class="icon-inside"><i class="fas fa-caret-down"></i></span>
              <div class="travellers-dropdown">
                <div class="row align-items-center">
                  <div class="col-sm-7">
                    <p class="mb-sm-0">Adults <small class="text-muted">(12+ yrs)</small></p>
                  </div>
                  <div class="col-sm-5">
                    <div class="qty input-group">
                       <div class="input-group-prepend">
                        <button type="button" class="btn bg-light-4" id = "adult-flight-travellers-minus" data-toggle="spinner">-</button>
                      </div>
                      <input type="text" data-ride="spinner"  id="adult-flight-travellers" class="qty-spinner form-control" value="{{app('request')->input('noofAdults')}}" readonly name="noofAdults">
                      <div class="input-group-append">
                        <button type="button" class="btn bg-light-4" id = "adult-flight-travellers-plus" data-toggle="spinner">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-2">
                <div class="row align-items-center">
                  <div class="col-sm-7">
                    <p class="mb-sm-0">Children <small class="text-muted">(2-12 yrs)</small></p>
                  </div>
                  <div class="col-sm-5">
                    <div class="qty input-group">
                      <div class="input-group-prepend">
                        <button type="button" class="btn bg-light-4" id="children-flight-travellers-minus" data-toggle="spinner">-</button>
                      </div>
                      <input type="text" data-ride="spinner"  id="children-flight-travellers" class="qty-spinner form-control" value="{{app('request')->input('noofChildren')}}"readonly name="noofChildren">
                      <div class="input-group-append">
                        <button type="button" class="btn bg-light-4" id="children-flight-travellers-plus" data-toggle="spinner">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-2">
                <div class="row align-items-center">
                  <div class="col-sm-7">
                    <p class="mb-sm-0">Infants <small class="text-muted">(Below 2 yrs)</small></p>
                  </div>
                  <div class="col-sm-5">
                    <div class="qty input-group">
                      <div class="input-group-prepend">
                        <button type="button" class="btn bg-light-4" id="infant-flight-travellers-minus"  data-toggle="spinner">-</button>
                      </div>
                      <input type="text" data-ride="spinner" id="infant-flight-travellers"  class="qty-spinner form-control" value="{{app('request')->input('noofInfants')}}" readonly name="noofInfants">
                      <div class="input-group-append">
                        <button type="button" class="btn bg-light-4" id="infant-flight-travellers-plus" data-toggle="spinner">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="mt-2">
                <div class="mb-3">
                  <div class="form-check">
                    <input id="flightClassEconomic" name="flight-class" class="flight-class form-check-input" value="Economy" {{app('request')->input('flight-class') == 'Economy' ? 'checked' :''}} required type="radio" >
                    <label class="form-check-label" for="flightClassEconomic">{{__('lang.economy')}}</label>
                  </div>
                  {{-- <div class="form-check">
                    <input id="flightClassPremiumEconomic" name="flight-class" class="flight-class form-check-input" value="Premium Economy" {{app('request')->input('flight-class') == 'Premium Economy' ? 'checked' :''}} required type="radio">
                    <label class="form-check-label" for="flightClassPremiumEconomic">{{__('lang.premium_economic')}}</label>
                  </div> --}}
                  <div class="form-check">
                    <input id="flightClassBusiness" name="flight-class" class="flight-class form-check-input" value="Business" {{app('request')->input('flight-class') == 'Business' ? 'checked' :''}} required type="radio">
                    <label class="form-check-label" for="flightClassBusiness">{{__('lang.business')}}</label>
                  </div>
                  <div class="form-check">
                    <input id="flightClassFirstClass" name="flight-class" class="flight-class form-check-input" value="First" {{app('request')->input('flight-class') == 'First' ? 'checked' :''}} required type="radio">
                    <label class="form-check-label" for="flightClassFirstClass">{{__('lang.first_class')}}</label>
                  </div>
                </div>
                <div class="d-grid">
                  <button class="btn btn-primary submit-done" type="button">{{__('lang.done')}}</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-2 d-grid">
            <button class="btn btn-primary" type="submit"  id= "searchbutton"> <span></span> {{__('lang.update')}}</button>
          </div>
        </div>
      </form>
      <div class="row"> 
        @if(isset($data['errorresponse']))
        <div>
          <div class="col-md-12 mt-4 mt-md-0">
            <div class="bg-white shadow-md rounded py-4">
              <div class="mx-3 text-center">
                <h2 class="text-6 ">{{$data['errorresponse']}}</h2>
              </div>
            </div>
          </div>
        </div>
        @else
        
        <!-- Side Panel
      ============================================= -->
          <aside class="col-md-3">
            <div class="bg-white shadow-md rounded p-3">
              <h3 class="text-5">{{__('lang.filter')}}</h3>
              <hr class="mx-n3">
              <div class="accordion accordion-flush style-2 mt-n3" id="toggleAlternate">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="stops">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#togglestops" aria-expanded="true" aria-controls="togglestops"> {{__('lang.no_of_stops')}}</button>
                  </h2>
                  <div id="togglestops" class="accordion-collapse collapse show" aria-labelledby="stops">
                    <div class="accordion-body">
                      @foreach($data['stops'] as $stop)
                      <div class="form-check stopscheck">
                        <input type="checkbox"  value="{{clean($stop['name'])}}" class="form-check-input">
                        <label class="form-check-label" for="nonstop">{{__('lang.'.clean($stop['name']))}} ({{$stop['count']}})</label>
                      </div>
                      @endforeach
                      
                    </div>
                  </div>
                </div>
                {{-- <div class="accordion-item">
                  <h2 class="accordion-header" id="departureTime">
                    <button class="accordion-button" type="button" class="collapse" data-bs-toggle="collapse" data-bs-target="#toggleDepartureTime" aria-expanded="true" aria-controls="toggleDepartureTime">
                    Departure Time
                    </button>
                  </h2>
                  <div id="toggleDepartureTime" class="accordion-collapse collapse show" aria-labelledby="departureTime">
                    <div class="accordion-body">
                      <div class="form-check clearfix">
                        <input type="checkbox" id="earlyMorning" name="departureTime" class="form-check-input">
                        <label class="form-check-label" for="earlyMorning">Early Morning</label>
                        <small class="text-muted float-end">12am - 8am</small> </div>
                      <div class="form-check clearfix">
                        <input type="checkbox" id="morning" name="departureTime" class="form-check-input">
                        <label class="form-check-label" for="morning">Morning</label>
                        <small class="text-muted float-end">8am - 12pm</small> </div>
                      <div class="form-check clearfix">
                        <input type="checkbox" id="midDay" name="departureTime" class="form-check-input">
                        <label class="form-check-label" for="midDay">Mid-Day</label>
                        <small class="text-muted float-end">12pm - 4pm</small> </div>
                      <div class="form-check clearfix">
                        <input type="checkbox" id="evening" name="departureTime" class="form-check-input">
                        <label class="form-check-label" for="evening">Evening</label>
                        <small class="text-muted float-end">4pm - 8pm</small> </div>
                      <div class="form-check clearfix">
                        <input type="checkbox" id="night" name="departureTime" class="form-check-input">
                        <label class="form-check-label" for="night">Night</label>
                        <small class="text-muted float-end">8pm - 12am</small> </div>
                    </div>
                  </div>
                </div> --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="price">
                    <button class="accordion-button" type="button" class="collapse" data-bs-toggle="collapse" data-bs-target="#togglePrice" aria-expanded="true" aria-controls="togglePrice">
                      {{__('lang.price')}} 
                    </button>
                  </h2>
                  <div id="togglePrice" class="accordion-collapse collapse show" aria-labelledby="price">
                    <div class="accordion-body">
                      <p>
                        <input id="amount" type="text" readonly class="form-control border-0 bg-transparent p-0">
                      </p>
                      <div id="slider-range"></div>
                      <div input = "hidden" name = "minvalue"  id ="minvalue">
                        <div input = "hidden" name = "maxvalue"  id ="maxvalue">
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="airlines">
                    <button class="accordion-button" type="button" class="collapse" data-bs-toggle="collapse" data-bs-target="#toggleAirlines" aria-expanded="true" aria-controls="toggleAirlines">
                      {{__('lang.airlines')}} 
                    </button>
                  </h2>
                  <div id="toggleAirlines" class="accordion-collapse collapse show" aria-labelledby="airlines">
                    <div class="accordion-body pb-0">
                      @foreach($data['airLines'] as $airLine)
                      <div class="form-check airlinecheck">
                        <input type="checkbox"  value="{{clean($airLine['name'])}}" class="form-check-input " >
                        <label class="form-check-label" for="asianaAir">{{$airLine['name']}}</label>
                      </div>
                      @endforeach
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </aside>
        <!-- Side Panel end -->
        
        <div class="col-md-9 mt-4 mt-md-0">
          <div class="bg-white shadow-md rounded py-4">
            <div class="mx-3 mb-3 text-center">
                <h2 class="text-6 mb-4">{{$data['OriginCityDetails']->city_name}} <small class="mx-2">⇄</small>{{$data['DestationCityDetails']->city_name}}</h2>
            </div>
            <div class="text-1 bg-light-3 border border-end-0 border-start-0 py-2 px-3">
              <div class="row">
                <div class="col col-sm-2 text-center"><span class="d-none d-sm-block">{{__('lang.airlines')}} </span></div>
                <div class="col col-sm-3 text-center">{{__('lang.departure')}} </div>
                <div class="col-sm-2 text-center d-none d-sm-block">{{__('lang.duration')}} </div>
                <div class="col col-sm-2 text-center">{{__('lang.arrival')}} </div>
                <div class="col col-sm-2 text-end">{{__('lang.price')}} </div>
              </div>
            </div>
            <div class="flight-list">
                @forelse($data['result'] as $info)
                <div class="flight-item" data-pricing = "{{$info['markupPrice']['totalPrice']['value']}}" data-airline = "{{clean($info['airline'])}}" data-connection = "{{clean(Connections($info['outboundconnection']))}}" style="    border-bottom: 5px solid #e9e9e9;">
                    <div class="row align-items-center flex-row pt-4 pb-2 px-2">
                        <div class = "col-9">
                            <div class="row">
                                <div class="col col-sm-3 text-center d-lg-flex company-info"> <span class="align-middle"><img class="" alt="" width="40" height="40" src="https://www.gstatic.com/flights/airline_logos/70px/{{$info['outboundItinerary'][0]['AirSegment']['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-1 text-dark">{{$info['outboundItinerary'][0]['AirSegment']['airline']}}</span> <small class="text-muted d-block">
                                  @if($info['outboundItinerary'][0]['AirSegment']['Carrier'] == "G9")
                                  {{$info['outboundItinerary'][0]['AirSegment']['FlightNumber']}}
                                  @else
                                  {{$info['outboundItinerary'][0]['AirSegment']['Carrier']}}-{{$info['outboundItinerary'][0]['AirSegment']['FlightNumber']}}
                                  @endif
                                   @if($info['outboundItinerary'][0]['AirSegment']['Carrier'] == "J9")
                                    <br>{{$info['outboundItinerary'][0]['baggage']['product']}}
                                    @endif
                                </small> </span> </div>

                                <div class="col col-sm-3 text-center time-info">
                                   <span class="text-4">{{$info['outBoundeDepatureTime']}}</span> 
                                   <div>
                                    <small class="text-muted d-sm-block listingAirportName">{{$info['outBoundeDepatureDate']}}</small>
                                    <small class="text-muted d-sm-block ">{{$info['outBoundedOriginAirportDetails']->name}}</small> 
                                  </div>
                                </div>

                                <div class="col-sm-3 text-center d-none d-sm-block time-info"> <span class="text-3">{{$info['outboundtotaltimeTravel']}}</span> <small class="text-muted d-none d-sm-block">{{Connections($info['outboundconnection'])}}</small> </div>

                                <div class="col col-sm-3 text-center time-info"> 
                                  <div>
                                    <span class="text-4">{{$info['outBoundedArrivalTime']}}</span> 
                                    <small class="text-muted d-sm-block listingAirportName">{{$info['outBoundedArrivalDate']}}</small>
                                    <small class="text-muted d-sm-block ">{{$info['outBoundedDestationAirportDetails']->name}}</small> 
                                  </div>
                                </div>

                                <div class="col col-sm-auto col-lg-10 mt-1 text-1 d-none">{{$info['outBoundlayover']}}</div>

                                <div>
                                <hr  style="border: 2px dashed #C0C0C0" color="#FFFFFF" size="6">
                                </div>
        
                                <div class="col col-sm-3 text-center d-lg-flex company-info"> <span class="align-middle"><img class="" alt="" width="40" height="40" src="https://www.gstatic.com/flights/airline_logos/70px/{{$info['inboundItinerary'][0]['AirSegment']['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-1 text-dark">{{$info['inboundItinerary'][0]['AirSegment']['airline']}}</span> 
                                  <small class="text-muted d-block">
                                    @if($info['inboundItinerary'][0]['AirSegment']['Carrier'] == "G9")
                                    {{$info['inboundItinerary'][0]['AirSegment']['FlightNumber']}}
                                    @else
                                    {{$info['inboundItinerary'][0]['AirSegment']['Carrier']}}-{{$info['inboundItinerary'][0]['AirSegment']['FlightNumber']}}
                                    @endif
                                     @if($info['inboundItinerary'][0]['AirSegment']['Carrier'] == "J9")
                                    <br>{{$info['inboundItinerary'][0]['baggage']['product']}}
                                    @endif
                                  </small> </span> </div>
                                 
                                
                                <div class="col col-sm-3 text-center time-info"> 
                                  <span class="text-4">{{$info['inBoundeDepatureTime']}}</span> 
                                  <div>
                                    <small class="text-muted d-sm-block listingAirportName">{{$info['inBoundeDepatureDate']}}</small>
                                    <small class="text-muted d-sm-block ">{{$info['inBoundedOriginAirportDetails']->name}}</small> 
                                  </div>
                                </div>

                                <div class="col-sm-3 text-center d-none d-sm-block time-info"> <span class="text-3">{{$info['inboundtotaltimeTravel']}}</span> <small class="text-muted d-none d-sm-block">{{Connections($info['inboundconnection'])}}</small> </div>

                                <div class="col col-sm-3 text-center time-info"> 
                                  <span class="text-4">{{$info['inBoundedArrivalTime']}}</span> 
                                  <div>
                                    <small class="text-muted d-sm-block listingAirportName">{{$info['inBoundedArrivalDate']}}</small>
                                    <small class="text-muted d-sm-block ">{{$info['inBoundedDestationAirportDetails']->name}}</small> 
                                  </div>
                                </div>
                                <div class="col col-sm-auto col-lg-10 mt-1 text-1 d-none">{{$info['inBoundlayover']}}</div>
                            </div>
                        </div>
                        <div class = "col-3">
                        <div class="row">
                            <div class="col col-sm-6 text-end text-dark text-2 price" style="align-self: center;">
                              @if($info['type'] == 'airarabia' || $info['type'] == 'airjazeera')
                              From <br>{{$info['markupPrice']['totalPrice']['currency_code'] .' '. $info['markupPrice']['totalPrice']['value']}}
                              @else
                              {{$info['markupPrice']['totalPrice']['currency_code'] .' '. $info['markupPrice']['totalPrice']['value']}}
                              @endif
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class=" text-center ms-auto btn-book"> 
                                    <a href="{{route('flight-review',['uuid'=>$uuid,'Key'=>base64_encode($loop->index)])}}" class="btn btn-sm btn-primary gButton"><span class="d-lg-block"><span class="gButtonloader"></span>{{__('lang.book')}} </span></a> 
                                </div>
                                <div class="col col-sm-auto col-lg-12 ms-auto mt-1 text-1 text-center"><a data-bs-toggle="modal" data-bs-target="#flight-{{$loop->iteration}}" href="">{{__('lang.flight_details')}}</a></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- Flight Details Modal Dialog
                    ============================================= -->
                    <div id="flight-{{$loop->iteration}}" class="modal fade" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">{{__('lang.flight_details')}}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <div class="flight-details">
                              <div class="row mb-4">
                                  <div class="col-12 col-sm-9 col-lg-7">
                                  <div class="row align-items-center trip-title mb-3">
                                      <div class="col col-sm-auto text-center text-sm-start">
                                          <h5 class="m-0 trip-place">{{$info['outBoundedOriginAirportDetails']->city_name}}</h5>
                                          <p class="m-0 trip-place">{{$info['outBoundedOriginAirportDetails']->name}}</p>
                                      </div>
                                      <div class="col-auto text-10 text-black-50 text-center trip-arrow">⇄</div>
                                      <div class="col col-sm-auto text-center text-sm-start">
                                          <h5 class="m-0 trip-place">{{$info['outBoundedDestationAirportDetails']->city_name}}</h5>
                                          <p class="m-0 trip-place">{{$info['outBoundedDestationAirportDetails']->name}}</p>
                                      </div>
                                  </div>
                                  <div class="row align-items-center">
                                      <div class="col col-sm-auto"><span class="text-4">  {{date('d M D', strtotime($info['outBoundeDepatureDate']))}} ,{{date('d M D', strtotime($info['outBoundedArrivalDate']))}}</span></div>
                                      <div class="col col-sm-auto"><span class="text-4"><span class="text-4">  {{date('d M D', strtotime($info['inBoundeDepatureDate']))}} ,{{date('d M D', strtotime($info['inBoundedArrivalDate']))}}</span></span></div>
                                      
                                      <div class="col-auto">
                                          @if($info['Refundable'] == "true")
                                          <span class="badge bg-success py-1 px-2 fw-normal text-1">{{__('lang.refundable')}}</span> 
                                          @else
                                          <span class="badge bg-danger py-1 px-2 fw-normal text-1">{{__('lang.non_refundable')}}</span> 
                                          @endif
                                        </div>
                                  </div>
                                  </div>
                                  <div class="col-12 col-sm-3 col-lg-3 text-center text-sm-end mt-3 mt-sm-0" style="margin-top: 45px !important;"> <span class="text-dark text-5">{{$info['markupPrice']['totalPrice']['currency_code'] .' '. $info['markupPrice']['totalPrice']['value']}}</span> 
                                      {{-- <span class="text-1 text-muted d-block">(Per Adult)</span> <span class="text-1 text-danger d-block">2 seat(s) left</span> --}}
                                    </div>
                                    <div class="col-12 col-sm-3 col-lg-2  btn-book d-flex align-items-center" style ="padding-left: 29px;"> 
                                      {{-- <form method="post" action="{{route('flight-review')}}">
                                        @csrf
                                        <input type="hidden" name="resultIndex" value = "{{$loop->index}}">
                                        <button class="btn btn-sm btn-primary" type="submit">
                                          <span class="d-none d-lg-block">Book</span>
                                        </button>
                                      </form> --}}
                                      <a class="btn btn-sm btn-primary gButton" href="{{route('flight-review',['uuid'=>$uuid,'Key'=>base64_encode($loop->index)])}}" >
                                        <span class="d-lg-block"><span class="gButtonloader"></span>{{__('lang.book')}} </span>
                                      </a>
                                      
                                    </div>
                              </div>
                              <ul class="nav nav-tabs" id="myTab{{$loop->iteration}}" role="tablist">
                                  <li class="nav-item"> <a class="nav-link active" id="first-tab{{$loop->iteration}}" data-bs-toggle="tab" href="#first{{$loop->iteration}}" role="tab" aria-controls="first{{$loop->iteration}}" aria-selected="true">{{__('lang.itinerary')}}</a> </li>
                                  <li class="nav-item"> <a class="nav-link" id="second-tab{{$loop->iteration}}" data-bs-toggle="tab" href="#second{{$loop->iteration}}" role="tab" aria-controls="second{{$loop->iteration}}" aria-selected="false">{{__('lang.fare_details')}}</a> </li>
                                  <li class="nav-item"> <a class="nav-link" id="third-tab{{$loop->iteration}}" data-bs-toggle="tab" href="#third{{$loop->iteration}}" role="tab" aria-controls="third{{$loop->iteration}}" aria-selected="false">{{__('lang.baggage_details')}}</a> </li>
                                  <li class="nav-item"> <a class="nav-link" id="fourth-tab{{$loop->iteration}}" data-bs-toggle="tab" href="#fourth{{$loop->iteration}}" role="tab" aria-controls="fourth{{$loop->iteration}}" aria-selected="false">{{__('lang.cancellation_fee')}}</a> </li>
                              </ul>
                              <div class="tab-content my-3" id="myTabContent">
                                  <div class="tab-pane fade show active" id="first{{$loop->iteration}}" role="tabpanel" aria-labelledby="first-tab{{$loop->iteration}}">
                                      {{-- outBoundedItinerary --}}
                                      @foreach($info['outboundItinerary'] as $ob=>$outsegment)
                                      <div class="row flex-row  px-md-4">
                                          <div class="col-12 col-sm-3 text-center d-lg-flex company-info"> <span class="align-middle"><img class="" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$outsegment['AirSegment']['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-1 text-dark">{{$outsegment['AirSegment']['airline']}}</span> 
                                            <small class="text-muted d-block">
                                              @if($outsegment['AirSegment']['Carrier'] == "G9")
                                                {{$outsegment['AirSegment']['FlightNumber']}}
                                              @else
                                                {{$outsegment['AirSegment']['Carrier']}}-{{$outsegment['AirSegment']['FlightNumber']}}
                                              @endif
                                            </small> </span> </div>

                                          <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> 
                                              <span class="text-5 text-dark">{{$outsegment['AirSegment']['cleanDepartureTime']}}</span> 
                                              <small class="text-muted d-none d-sm-block">{{$outsegment['AirSegment']['cleanDepartureDate']}}</small>
                                              <small class="text-muted d-block">{{$outsegment['AirSegment']['OriginAirportDetails']->name}}, {{$outsegment['AirSegment']['OriginAirportDetails']->city_name}} ,{{$outsegment['AirSegment']['OriginAirportDetails']->country_name}}</small> 
                                            </div>

                                            <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-3 text-dark">{{$outsegment['AirSegment']['FlightTravelTime']}}</span> <small class="text-muted d-block">{{__('lang.duration')}} </small> </div>

                                            <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{$outsegment['AirSegment']['cleanArrivalTime']}}</span> 
                                              <small class="text-muted d-none d-sm-block">{{$outsegment['AirSegment']['cleanArrivalDate']}}</small>
                                              <small class="text-muted d-block">{{$outsegment['AirSegment']['DestationAirportDetails']->name}}, {{$outsegment['AirSegment']['DestationAirportDetails']->city_name}} ,{{$outsegment['AirSegment']['DestationAirportDetails']->country_name}}</small>  </div>
                                            @if(isset($info['outboundItinerary'][$ob+1]))
                                            <div class="dF width100 padTB5  marginTB10 alignItemsCenter backgroundLn justifyBetween"><hr width="400" style="border: 2px dashed #C0C0C0" color="#FFFFFF" size="6"><span class="paleGreyBg brdrRd10 padLR15 padTB3 ico11 blueGrey text-center"style="    width: inherit;"><span class="fb">{{$outsegment['LayOverTime']." Layover"}}</span></span><hr width="400" style="border: 2px dashed #C0C0C0" color="#FFFFFF" size="6"></div>
                                            @endif
                                      </div>
                                      @endforeach
                                      {{-- end outBoundedItinerary --}}
                                      <div>
                                          <hr style="border: 2px dashed #C0C0C0" color="#FFFFFF" size="6">
                                          </div>
                                      {{--  inBoundedItinerary --}}
                                      @foreach($info['inboundItinerary'] as $ib=>$insegment)
                                      <div class="row flex-row  px-md-4">
                                          <div class="col-12 col-sm-3 text-center d-lg-flex company-info"> <span class="align-middle"><img class="" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$insegment['AirSegment']['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-1 text-dark">{{$insegment['AirSegment']['airline']}}</span> <small class="text-muted d-block">
                                            @if($insegment['AirSegment']['Carrier'] == "G9")
                                              {{$insegment['AirSegment']['FlightNumber']}}
                                            @else
                                              {{$insegment['AirSegment']['Carrier']}}-{{$insegment['AirSegment']['FlightNumber']}}
                                            @endif
                                          </small> </span> </div>

                                          <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> 
                                              <span class="text-5 text-dark">{{$insegment['AirSegment']['cleanDepartureTime']}}</span> 
                                              <small class="text-muted d-none d-sm-block">{{$insegment['AirSegment']['cleanDepartureDate']}}</small>
                                              
                                              <small class="text-muted d-block">{{$insegment['AirSegment']['OriginAirportDetails']->name}}, {{$insegment['AirSegment']['OriginAirportDetails']->city_name}} ,{{$insegment['AirSegment']['OriginAirportDetails']->country_name}}</small> 
                                            </div>

                                            <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-3 text-dark">{{$insegment['AirSegment']['FlightTravelTime']}}</span> <small class="text-muted d-block">{{__('lang.duration')}} </small> </div>

                                            <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{$insegment['AirSegment']['cleanArrivalTime']}}</span> 

                                              <small class="text-muted d-none d-sm-block">{{$insegment['AirSegment']['cleanArrivalTime']}}</small>
                                              
                                              <small class="text-muted d-block">{{$insegment['AirSegment']['DestationAirportDetails']->name}}, {{$insegment['AirSegment']['DestationAirportDetails']->city_name}} ,{{$insegment['AirSegment']['DestationAirportDetails']->country_name}}</small>  </div>
                                            @if(isset($info['inboundItinerary'][$ib+1]))
                                            <div class="dF width100 padTB5 marginTB10 alignItemsCenter backgroundLn justifyBetween"><hr width="400" style="border: 2px dashed #C0C0C0" color="#FFFFFF" size="6"><span class="paleGreyBg brdrRd10 padLR15 padTB3 ico11 blueGrey text-center"style="    width: inherit;"><span class="fb">{{$insegment['LayOverTime']." Layover"}}</span></span><hr width="400" style="border: 2px dashed #C0C0C0" color="#FFFFFF" size="6"></div>
                                            @endif
                                      </div>
                                      @endforeach
                                      {{-- end inBoundedItinerary --}}


                                  </div>
                                  <div class="tab-pane fade" id="second{{$loop->iteration}}" role="tabpanel" aria-labelledby="second-tab{{$loop->iteration}}">
                                  <div class="table-responsive-md">
                                      <table class="table table-hover table-bordered">
                                          <tbody>
                                              <tr>
                                                <td>{{__('lang.base_fare')}}</td>
                                                <td class="text-end">{{$info['markupPrice']['basefare']['currency_code'] .' '. $info['markupPrice']['basefare']['value']}}</td>
                                              </tr>
                                              <tr>
                                                <td>{{__('lang.fees_surcharge')}}</td>
                                                <td class="text-end">{{$info['markupPrice']['tax']['currency_code'] .' '. $info['markupPrice']['tax']['value']}}</td>
                                              </tr>
                                              <tr>
                                                <td>{{__('lang.total')}}</td>
                                                <td class="text-end">{{$info['markupPrice']['totalPrice']['currency_code'] .' '. $info['markupPrice']['totalPrice']['value']}}</td>
                                              </tr>
                                            </tbody>
                                      </table>
                                  </div>
                                  </div>
                                  <div class="tab-pane fade" id="third{{$loop->iteration}}" role="tabpanel" aria-labelledby="third-tab{{$loop->iteration}}">
                                    <div class="table-responsive-md">
                                      @if($info['type'] == 'airarabia')
                                      <ul>
                                        <li>{{__('lang.include_a_generous_10_kg_hand_baggage')}}</li>
                                      </ul>
                                      @elseif($info['type'] == 'airjazeera')
                                        @foreach($info['outboundItinerary'] as $k=>$segment)
                                          <span class="align-middle"><img class="" alt="" width="40" height="40" src="https://www.gstatic.com/flights/airline_logos/70px/{{$segment['baggage']['airline']}}.png"> </span><span>{{$segment['baggage']['segment']}} ({{$segment['baggage']['airline'].' - '.$segment['baggage']['flightNumber']}})</span>

                                              <table class="table table-hover table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th>&nbsp;</th>
                                                    <td class="text-center">{{__('lang.cabin')}}</td>
                                                    <td class="text-center">{{__('lang.check_in')}}</td>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                 @foreach($segment['baggage']['table'] as $passengerType => $baggage)
                                                  <tr>
                                                      <td>{{ $passengerType }}</td>
                                                      <td class="text-center">
                                                          @if (isset($baggage['carryOn']))
                                                              {{ $baggage['carryOn']['value'] }} {{ $baggage['carryOn']['unit'] }}
                                                          @else
                                                              0 Kilograms
                                                          @endif
                                                      </td>
                                                      <td class="text-center">
                                                          @if (isset($baggage['checkIn']))
                                                              @if ($baggage['checkIn']['type'] == 'weight')
                                                                  {{ $baggage['checkIn']['value'] }} {{ $baggage['checkIn']['unit'] }}
                                                              @endif
                                                          @else
                                                              0 Kilograms
                                                          @endif
                                                      </td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                              </table>
                                        @endforeach

                                        @foreach($info['inboundItinerary'] as $k=>$segment)
                                          <span class="align-middle"><img class="" alt="" width="40" height="40" src="https://www.gstatic.com/flights/airline_logos/70px/{{$segment['baggage']['airline']}}.png"> </span><span>{{$segment['baggage']['segment']}} ({{$segment['baggage']['airline'].' - '.$segment['baggage']['flightNumber']}})</span>

                                              <table class="table table-hover table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th>&nbsp;</th>
                                                    <td class="text-center">{{__('lang.cabin')}}</td>
                                                    <td class="text-center">{{__('lang.check_in')}}</td>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                 @foreach($segment['baggage']['table'] as $passengerType => $baggage)
                                                  <tr>
                                                      <td>{{ $passengerType }}</td>
                                                      <td class="text-center">
                                                          @if (isset($baggage['carryOn']))
                                                              {{ $baggage['carryOn']['value'] }} {{ $baggage['carryOn']['unit'] }}
                                                          @else
                                                              0 Kilograms
                                                          @endif
                                                      </td>
                                                      <td class="text-center">
                                                          @if (isset($baggage['checkIn']))
                                                              @if ($baggage['checkIn']['type'] == 'weight')
                                                                  {{ $baggage['checkIn']['value'] }} {{ $baggage['checkIn']['unit'] }}
                                                              @endif
                                                          @else
                                                              0 Kilograms
                                                          @endif
                                                      </td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                              </table>
                                        @endforeach

                                      @else
                                      @if(!empty($info['baggage']))
                                      @foreach($info['baggage'] as $baggages)
                                      
                                        <span class="align-middle"><img class="" alt="" width="40" height="40" src="https://www.gstatic.com/flights/airline_logos/70px/{{$baggages['airline']}}.png"> </span><span>{{$baggages['segment']}} ({{$baggages['airline'].' - '.$baggages['flightNumber']}})</span>
      
                                        <table class="table table-hover table-bordered">
                                          <thead>
                                            <tr>
                                              <th>&nbsp;</th>
                                              <td class="text-center">{{__('lang.cabin')}}</td>
                                              <td class="text-center">{{__('lang.check_in')}}</td>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            
                                            @foreach($baggages['table'] as $pk=>$pass)
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
      
                                      
                                      @endforeach
                                      @endif
                                      @endif

                                    </div>
                                  </div>
                                  <div class="tab-pane fade" id="fourth{{$loop->iteration}}" role="tabpanel" aria-labelledby="fourth-tab{{$loop->iteration}}">
                                  {{-- <table class="table table-hover table-bordered">
                                      <thead>
                                      <tr>
                                          <th>&nbsp;</th>
                                          <td class="text-center">{{__('lang.cancel_fee_per_passenger')}}</td>
                                          <td class="text-center">{{__('lang.change_fee_per_passenger')}}</td>
                                      </tr>
                                      </thead>
                                      <tbody>
                                        @if(!empty($info['AdultChangePenalty'])  || !empty($info['AdultCancelPenalty']))
                                          <tr>
                                            <td>Adult</td>
                                            <td class="text-center">
                                              @if(!empty($info['AdultCancelPenalty']))
                                                {{$info['AdultCancelPenalty']['value']}} {{($info['AdultCancelPenalty']['type'] == 'percentage') ? '%':''}}
                                              @endif
                                            </td>
                                            <td class="text-center">
                                              @if(!empty($info['AdultChangePenalty']))
                                                {{$info['AdultChangePenalty']['value']}} {{($info['AdultChangePenalty']['type'] == 'percentage') ? '%':''}}
                                              @endif
                                            </td>
                                          </tr>
                                        @endif
                                        @if(!empty($info['childrenChangePenalty']) || !empty($info['childrenCancelPenalty']))
                                          <tr>
                                            <td>Child</td>
                                            <td class="text-center">
                                              @if(!empty($info['childrenCancelPenalty']))
                                                {{$info['childrenCancelPenalty']['value']}} {{($info['childrenCancelPenalty']['type'] == 'percentage') ? '%':''}} 
                                              @endif
                                            </td>
                                            <td class="text-center">
                                              @if(!empty($info['childrenChangePenalty']))
                                                {{$info['childrenChangePenalty']['value']}} {{($info['childrenChangePenalty']['type'] == 'percentage') ? '%':''}}
                                              @endif
                                            </td>
                                          </tr>
                                        @endif
                                        @if(!empty($info['infantChangePenalty']) || !empty($info['infantCancelPenalty']) )
                                          <tr>
                                            <td>Infant</td>
                                              <td class="text-center">
                                                @if(!empty($info['infantCancelPenalty']))
                                                {{$info['infantCancelPenalty']['value']}} {{($info['infantCancelPenalty']['type'] == 'percentage') ? '%':''}} 
                                                @endif
                                              </td>
                                        
                                              <td class="text-center">
                                                @if(!empty($info['infantChangePenalty']))
                                                {{$info['infantChangePenalty']['value']}} {{($info['infantChangePenalty']['type'] == 'percentage') ? '%':''}}
                                                @endif
                                              </td>
                                          </tr>
                                        @endif
                                      </tbody>
                                  </table>--}}
                                  <p class="fw-bold">{{__('lang.terms_conditions')}}</p>
                                  <ul>
                                    <li>{{__('lang.condition_1')}}</li>
                                    <li>{{__('lang.condition_2')}}</li>
                                    <li>{{__('lang.condition_3')}}</li>
                                    <li>{{__('lang.condition_4')}}</li>
                                    <li>{{__('lang.condition_5')}}</li>
                                    <li>{{__('lang.condition_6')}}</li>
                                    <li>{{__('lang.condition_7')}}</li>
                                    <li>{{__('lang.condition_8')}}</li>
                                    <li>{{__('lang.condition_9')}}</li>
                                  </ul>
                                  <div style="padding: 10px 17px;">{{__('lang.cancellation_and_changes')}}</div>
                                  </div>
                              </div>
                              </div>
                          </div>
                          </div>
                      </div>
                    </div>
                    <!-- Flight Details Modal Dialog end --> 
                </div>
                @empty
                <div class="bg-white shadow-md rounded py-4">
                  <div class="mx-3 text-center">
                    <h2 class="text-6 ">No Flights available</h2>
                  </div>
                </div>
                @endforelse
            
            </div>
            
            <!-- Pagination
              ============================================= -->
            {{-- <ul class="pagination justify-content-center mt-4 mb-0">
              <li class="page-item disabled"> <a class="page-link" href="#" tabindex="-1"><i class="fas fa-angle-left"></i></a> </li>
              <li class="page-item active"> <a class="page-link" href="#">1</a> </li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"> <a class="page-link" href="#"><i class="fas fa-angle-right"></i></a> </li>
            </ul> --}}
            <!-- Pagination end --> 
            
          </div>
        </div>
        @endif
      </div>
    </section>
  </div>
  <!-- Content end --> 
  @endsection
  @section('extraScripts')
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script> 
  <script>

    $("#bookingFlight").validate({
      ignore: [],
      rules: {
        // simple rule, converted to {required:true}
        "flight-trip": "required",
        flightFromAirportCode: "required",
        flightToAirportCode: "required",
        DepartDate: "required",
      },
      messages:{
        "flight-trip" : "Please select trip Type",
        "flightFromAirportCode" : "Please Select Value from dropDown",
        "flightToAirportCode" : "Please Select Value from dropDown",
        "DepartDate" : "Please select the Date",
      },
      submitHandler: function(form) { // <- pass 'form' argument in
      $("#searchbutton").prop('disabled',true);
      $("#searchbutton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
          form.submit(); // <- use 'form' argument here.
      }
    });
        
    // Slider Range (jQuery UI)

  var minprice =  Math.floor({{$data['minPrice'] ?? 0}});
  var maxprice =  Math.ceil({{$data['maxPrice'] ?? 0}});

  $( "#slider-range" ).slider({
    range: true,
    min: minprice ,
    max: maxprice,
    values: [ minprice, maxprice ],
    slide: function( event, ui ) {
    $( "#amount" ).val( "KWD " + ui.values[ 0 ] + " - KWD " + ui.values[ 1 ] );
    $( "#minvalue" ).val(ui.values[ 0 ]);
    $( "#maxvalue" ).val(ui.values[ 1 ]);

    var selectedStops = new Array();
    $('.stopscheck input[type=checkbox]:checked').each(function () {
      selectedStops.push(this.value);
    });
    
    var selectedAirlines = new Array();
    $('.airlinecheck input[type=checkbox]:checked').each(function () {
      selectedAirlines.push(this.value);
    });

    minvalue = ui.values[ 0 ];
    maxvalue = ui.values[ 1 ];

    filter(selectedStops,selectedAirlines,minvalue,maxvalue);
    }
  });
  $( "#amount" ).val( "KWD " + $( "#slider-range" ).slider( "values", 0 ) +" - KWD " + $( "#slider-range" ).slider( "values", 1 ) );
  $( "#minvalue" ).val(minprice);
  $( "#maxvalue" ).val(maxprice);

  var airlines = new Array();
  var stops = new Array();
  var selectedStops = new Array();
  var selectedAirlines = new Array();
  var filterMinPrice = minprice;
  var filterMaxPrice = maxprice;

  $('.airlinecheck input[type=checkbox]').each(function () {
      airlines.push(this.value);
  });
  $('.stopscheck input[type=checkbox]').each(function () {
    stops.push(this.value);
  });

  $('#togglestops :checkbox,#toggleAirlines :checkbox').change(function () {

      var selectedStops = new Array();
      $('.stopscheck input[type=checkbox]:checked').each(function () {
        selectedStops.push(this.value);
      });

      var selectedAirlines = new Array();
      $('.airlinecheck input[type=checkbox]:checked').each(function () {
        selectedAirlines.push(this.value);
      });

     var minvalue = parseInt($( "#minvalue" ).val());
     var maxvalue = parseInt($( "#maxvalue" ).val());

      filter(selectedStops,selectedAirlines,minvalue,maxvalue);
  });

  function filter(selectedStops,selectedAirlines,filterMinPrice,filterMaxPrice)
  {
    $(".flight-item").css('display','none');
    $('.flight-item').each(function(){
    if(($(this).data('pricing') > filterMinPrice) && ($(this).data('pricing') < filterMaxPrice) && (selectedStops.length==0 || ($.inArray($(this).data('connection'), selectedStops) > -1)) && (selectedAirlines.length==0 || ($.inArray($(this).data('airline'), selectedAirlines) > -1)))
    {
      $(this).css('display','block');
    }
    });
  }
  
    function switchFlightDir()
    {
      $origintext = $("#flightFrom").val();
      $originhidden = $("#flightFromAirportCode").val();
  
      $destinationtext = $("#flightTo").val();
      $destinationhidden = $("#flightToAirportCode").val();
  
      $("#flightFrom").val($destinationtext);
      $("#flightFromAirportCode").val($destinationhidden);
  
      
      $("#flightTo").val($origintext);
      $("#flightToAirportCode").val($originhidden);
    }
  

    $(document).ready(function(){
      $("#bookingFlight").on("submit", function(){
        $("#searchbutton").prop('disabled',true);
        $("#searchbutton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
      });//submit
    });//document ready

  
    $(function() {
        
        // Autocomplete

        //flightfrom
        var airuplogo = "{{asset('frontEnd/images/image.png')}}";
        var airdownlogo = "{{asset('frontEnd/images/image.png')}}";
        var returndateSartFrom = moment();
        $('#flightFrom').autocomplete({
            minLength: 3,
            //delay: 10,
            source: function( request, response ) {
                $.ajax({
                url: "{{route('autoSuggest')}}",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function( data ) {
                    //response(data);
                    response($.map(data, function (item) {
                        return {
                            label: item.display_name,
                            value: item.display_name,
                            code: item.airport_code,
                            city_name: item.city_name,
                            country_name:item.country_name,
                            airport_name:item.name
                        };
                    }));
                },
                });
            },
            select: function( event, ui ) {
                $("input[name='flightFromAirportCode']").val(ui.item.code);
                $("#flightTo").focus();
            },
            search  : function(){$(this).addClass('preloader');},
            open    : function(){$(this).removeClass('preloader');}
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) 
        {  
          return $( "<li role='presentation' tabindex='0' class='sc-iUKqMP hlZHGM'></li>" )  
              .data( "item.autocomplete", item )  
              .append( '<div class="sc-iAKWXU iyyKqe"><div class="sc-efQSVx iQoDho"><span class="sc-cTAqQK fywikg"><img src="'+airuplogo+'" alt="flight Icon" width="25px"style="margin-top:7px"></span><div class="sc-jObWnj dmPlWU"><p class="sc-dPiLbb kUaZDb"><span class="autoCompleteTitle ">'+item.city_name+', '+item.country_name+'&nbsp;</span> <span class="autoCompleteSubTitle">('+item.code+')</span></p><p class="sc-bBHHxi cTvqKV">'+item.airport_name+'</p></div></div></div>' )  
              .appendTo( ul );  
        };  
        //flightTo
       

        $('#flightTo').autocomplete({
            minLength: 3,
            delay: 10,
            source: function( request, response ) {
                var except = $("input[name='flightFromAirportCode']").val();
                $.ajax({
                url: "{{route('autoSuggest')}}",
                dataType: "json",
                data: {
                    q: request.term,
                    ff:except,
                },
                success: function( data ) {
                    //response(data);
                    response($.map(data, function (item) {
                        console.log(item);
                        return {
                            label: item.display_name,
                            value: item.display_name,
                            code: item.airport_code,
                            city_name: item.city_name,
                            country_name:item.country_name,
                            airport_name:item.name
                        };
                    }));
                },
                });
            },
            select: function( event, ui ) {
                $("input[name='flightToAirportCode']").val(ui.item.code);
                $("#flightDepart").focus();
            },
            
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) 
        {
          return $( "<li role='presentation' tabindex='0' class='sc-iUKqMP hlZHGM'></li>" )  
              .data( "item.autocomplete", item )  
              .append( '<div class="sc-iAKWXU iyyKqe"><div class="sc-efQSVx iQoDho"><span class="sc-cTAqQK fywikg"><img src="'+airuplogo+'" alt="flight Icon" width="25px"style="margin-top:7px"></span><div class="sc-jObWnj dmPlWU"><p class="sc-dPiLbb kUaZDb"><span class="autoCompleteTitle ">'+item.city_name+', '+item.country_name+'&nbsp;</span> <span class="autoCompleteSubTitle">('+item.code+')</span></p><p class="sc-bBHHxi cTvqKV">'+item.airport_name+'</p></div></div></div>' )  
              .appendTo( ul );  
        };
        
        // Depart Date
        var start = moment("{{app('request')->input('DepartDate')}}");

        $('#flightDepart').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            minDate: moment(),
            autoUpdateInput: false,
            locale: {
              format: 'YYYY-MM-DD'
            },
            startDate:start
          
        },function(chosen_date) {
            $('#flightDepart').val(chosen_date.format('YYYY-MM-DD'));
            var flightDepartData = $('#flightDepart').val();
            var  returndateSartFrom = moment(flightDepartData);
            $('#flightReturn').val('');
            $('#flightReturn').daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                minDate: returndateSartFrom,
                autoUpdateInput: false,
                locale: {
                  format: 'YYYY-MM-DD'
                },
            }, function(chosen_date) {
                $('#flightReturn').val(chosen_date.format('YYYY-MM-DD'));
                $("#flightTravellersClass").trigger( "click" );
            });
            if($('input:radio[name="flight-trip"]:checked').val() == 'roundtrip' )
            {
              $("#flightReturn" ).trigger( "click" );
            }
            else{
              $("#flightTravellersClass" ).trigger( "click" );
            }  
        });

        var returnstart = moment("{{app('request')->input('ReturnDate')}}");

        $('#flightReturn').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            minDate: moment(),
            autoUpdateInput: false,
            locale: {
              format: 'YYYY-MM-DD'
            },
            startDate:returnstart
        }, function(chosen_date) {
            $('#flightReturn').val(chosen_date.format('YYYY-MM-DD'));
        });
    });

    $('input:radio[name="flight-trip"]').change(function() {
        if ($(this).val() == 'roundtrip') {
            $('#flightReturn').prop("disabled",false);
            $('#flightReturn').prop("required",true);
        } else {
            $('#flightReturn').val('');
            $('#flightReturn').prop("disabled",true);
            $('#flightReturn').prop("required",false);
        }
    });
    
    $('.gButton').click(function(){
        this.prop('disabled',true);
        this.find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
    });

</script>
<script src='{{ asset('frontEnd/js/flight.js') }}'></script>
  @endsection