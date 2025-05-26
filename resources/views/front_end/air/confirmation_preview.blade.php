
@extends('front_end.layouts.master')
@section('content')  

<style>
  .ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +100 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:50%;
  left:50%;
}
  </style>

  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.flight_preview')}} </h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}} </a></li>
            <li><a href="#">{{__('lang.flights')}} </a></li>
            <li class="">{{__('lang.flights_confirm_details_breadcurm')}} </li>
            <li class="active">{{__('lang.preview')}} </li>
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
          <!-- Jazeera timer -->
          @if(isset($result['airSegments'][0]['airJazeeraData']) && !empty($result['airSegments'][0]['airJazeeraData']))
           <div class="col-lg-8">
            <div id="timer" class="text-center">
              <div class="alert alert-warning">
                <strong>{{__('lang.session_expire')}} </strong><span class="timer-value" id="minutes">00</span> {{__('lang.minutes')}}  <span class="mx-2">:</span> <span class="timer-value" id="seconds">00</span> {{__('lang.seconds')}} . {{__('lang.redirect_to_home')}} 
              </div>
            </div>
          </div>
          @endif
          <!-- END -->
        <div class="col-lg-8">
          <div class="bg-white shadow-md rounded p-3 p-sm-4 confirm-details">
            <div class="row">
              <div class="col-7">
                <h2 class="text-6 ">{{__('lang.confirm_flight_details')}} </h2>
              </div>
              <div class="col-3">
                @if(isset($result['air:AirPricingSolution']['@attributes']['Refundable']) && ($result['air:AirPricingSolution']['@attributes']['Refundable'] == "true"))
                <div class="col col-md-auto text-center ms-auto order-sm-0"><span class="badge bg-success fw-normal text-1">{{__('lang.refundable')}}</span></div>
                @else
                <div class="col col-md-auto text-center ms-auto order-sm-0"><span class="badge bg-danger fw-normal text-1">{{__('lang.non_refundable')}}</span></div>
                @endif
               
            
              </div>
              <div class="col-2">
                {{-- <div class="col-6 col-sm col-md-auto text-end order-sm-1"><a class="text-1" data-bs-toggle="modal" data-bs-target="#fare-rules" href="">Fare Rules</a></div> --}}
                <div class="col-6 col-sm col-md-auto text-end order-sm-1"><a class="text-1" id = "Farerules-list" style="cursor: pointer;">{{__('lang.fare_rules')}}</a></div>
              </div>
            </div>
            <div class="alert alert-info mt-4"> <span class="badge bg-info">{{__('lang.note')}} </span>{{__('lang.preview_descrption')}}  </div>
            <div id="farerulesModel" class="modal fade" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document" >
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">{{__('lang.fare_rules')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="flight-details rulesList">
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <!-- Fare Rules (Modal Dialog)
            ============================================= -->
            {{-- <div id="fare-rules" class="modal fade" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Fare Rules</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul class="nav nav-tabs" id="departureTab" role="tablist">
                      <li class="nav-item"> <a class="nav-link active" id="first-tab" data-bs-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="false">Check In</a> </li>
                      <li class="nav-item"> <a class="nav-link " id="second-tab" data-bs-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">cabin In</a> </li>
                      <li class="nav-item"> <a class="nav-link" id="third-tab" data-bs-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">Cancellation Fee</a> </li>
                    </ul>
                    <div class="tab-content my-3" id="departureContent">
                      <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                        
                        <div class="table-responsive-md">
                          @foreach($result['air:AirPricingSolution']['@attributes']['chekin'] as $checkIn)
                          <span class="align-middle"><img class="" alt="" width="40" height="40" src="https://www.gstatic.com/flights/airline_logos/70px/{{$checkIn['@attributes']['Carrier']}}.png"> </span><span>{{$checkIn['@attributes']['Origin'] ." - ".$checkIn['@attributes']['Destination']}} </span>
                          <table class="table table-hover table-bordered">
                            <thead>
                              <tr>
                                <th>&nbsp;</th>
                                <td class="text-center">Check-In</td>
                                <td class="text-center">Details</td>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($checkIn['table'] as $k=>$table)
                              <tr>
                                <td>{{$k}}</td>
                                <td class="text-center">{{$table['air:TextInfo']['air:Text'][0]}}</td>
                                <td class="text-center"><a href="{{'https://'.$checkIn['air:URLInfo']['air:URL']}}">Details</a></td>
                              </tr>
                              @endforeach
                              
                            </tbody>
                          </table>
                          @endforeach
                        </div>
                        
                      </div>

                      <div class="tab-pane fade show " id="second" role="tabpanel" aria-labelledby="second-tab">
                        <div class="table-responsive-md">
                          @foreach($result['air:AirPricingSolution']['@attributes']['cabin'] as $cabIn)
                          <span class="align-middle"><img class="" alt="" width="40" height="40" src="https://www.gstatic.com/flights/airline_logos/70px/{{$cabIn['@attributes']['Carrier']}}.png"> </span><span>{{$cabIn['@attributes']['Origin'] ." - ".$cabIn['@attributes']['Destination']}} </span>
                          <table class="table table-hover table-bordered">
                            <thead>
                              <tr>
                                <th>&nbsp;</th>
                                <td class="text-center">Cabin</td>
                          
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($cabIn['table'] as $k=>$table)
                              <tr>
                                <td>{{$k}}</td>
                                <td class="text-center">{{$table['air:TextInfo']['air:Text']}}</td>
                  
                              </tr>
                              @endforeach
                            
                            </tbody>
                          </table>
                          @endforeach
                        </div> 
                      </div>

                      <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                        
                        <table class="table table-hover table-bordered">
                          <thead>
                          <tr>
                              <th>&nbsp;</th>
                              <td class="text-center">{{__('lang.cancel_fee_per_passenger')}} </td>
                              <td class="text-center">{{__('lang.change_fee_per_passenger')}} </td>
                          </tr>
                          </thead>
                          <tbody>
                            @if(!empty($result['air:AirPricingSolution']['@attributes']['AdultChangePenalty'])  || !empty($result['air:AirPricingSolution']['@attributes']['AdultCancelPenalty']))
                              <tr>
                                <td>Adult</td>
                                <td class="text-center">
                                  @if(!empty($result['air:AirPricingSolution']['@attributes']['AdultCancelPenalty']))
                                    {{$result['air:AirPricingSolution']['@attributes']['AdultCancelPenalty']['value']}} {{($result['air:AirPricingSolution']['@attributes']['AdultCancelPenalty']['type'] == 'percentage') ? '%':''}}
                                  @endif
                                </td>
                                <td class="text-center">
                                  @if(!empty($result['air:AirPricingSolution']['@attributes']['AdultChangePenalty']))
                                    {{$result['air:AirPricingSolution']['@attributes']['AdultChangePenalty']['value']}} {{($result['air:AirPricingSolution']['@attributes']['AdultChangePenalty']['type'] == 'percentage') ? '%':''}}
                                  @endif
                                </td>
                              </tr>
                            @endif
                            @if(!empty($result['air:AirPricingSolution']['@attributes']['childrenChangePenalty']) || !empty($result['air:AirPricingSolution']['@attributes']['childrenCancelPenalty']))
                              <tr>
                                <td>Child</td>
                                <td class="text-center">
                                  @if(!empty($result['air:AirPricingSolution']['@attributes']['childrenCancelPenalty']))
                                    {{$result['air:AirPricingSolution']['@attributes']['childrenCancelPenalty']['value']}} {{($result['air:AirPricingSolution']['@attributes']['childrenCancelPenalty']['type'] == 'percentage') ? '%':''}} 
                                  @endif
                                </td>
                                <td class="text-center">
                                  @if(!empty($result['air:AirPricingSolution']['@attributes']['childrenChangePenalty']))
                                    {{$result['air:AirPricingSolution']['@attributes']['childrenChangePenalty']['value']}} {{($result['air:AirPricingSolution']['@attributes']['childrenChangePenalty']['type'] == 'percentage') ? '%':''}}
                                  @endif
                                </td>
                              </tr>
                            @endif
                            @if(!empty($result['air:AirPricingSolution']['@attributes']['infantChangePenalty']) || !empty($result['air:AirPricingSolution']['@attributes']['infantCancelPenalty']) )
                              <tr>
                                <td>Infant</td>
                                  <td class="text-center">
                                    @if(!empty($result['air:AirPricingSolution']['@attributes']['infantCancelPenalty']))
                                    {{$result['air:AirPricingSolution']['@attributes']['infantCancelPenalty']['value']}} {{($result['air:AirPricingSolution']['@attributes']['infantCancelPenalty']['type'] == 'percentage') ? '%':''}} 
                                    @endif
                                  </td>
                              
                                  <td class="text-center">
                                    @if(!empty($result['air:AirPricingSolution']['@attributes']['infantChangePenalty']))
                                    {{$result['air:AirPricingSolution']['@attributes']['infantChangePenalty']['value']}} {{($result['air:AirPricingSolution']['@attributes']['infantChangePenalty']['type'] == 'percentage') ? '%':''}}
                                    @endif
                                  </td>
                              </tr>
                            @endif
                          </tbody>
                      </table>

                        <p class="fw-bold">Terms & Conditions</p>
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
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}
            <!-- Fare Rules end --> 
           
            <hr class="mx-n3 mx-sm-n4 mb-4">
            <!-- Departure Flight Detail
              ============================================= -->
              {{-- @foreach($result['air:AirPricingSolution']['AirSegment'] as $details)
              <div class="card  mt-4">
                <div class="card-header">
                  <div class="row align-items-center trip-title">
                    <div class="col-5 col-sm-auto text-center text-sm-start">
                      <h5 class="m-0 trip-place">{{$details['@attributes']['OriginAirportDetails']->city_name}}</h5>
                    </div>
                    <div class="col-2 col-sm-auto text-8 text-black-50 text-center trip-arrow">➝</div>
                    <div class="col-5 col-sm-auto text-center text-sm-start">
                      <h5 class="m-0 trip-place">{{$details['@attributes']['DestationAirportDetails']->city_name}}</h5>
                    </div>
                    <div class="col-12 mt-1 d-block d-md-none"></div>
                    <div class="col-6 col-sm col-md-auto text-3 date"> {{date('d M ', strtotime(DateTimeSpliter($details['@attributes']['DepartureTime'],"date")))}} ,{{date('d M ', strtotime(DateTimeSpliter($details['@attributes']['ArrivalTime'],"date")))}}</div>
                  
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-sm-3 text-center text-md-start d-lg-flex company-info"> <span class="align-middle"><img width="40" height="40" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$details['@attributes']['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-2 text-dark mt-1 mt-lg-0">{{$details['air:CodeshareInfo']['@content']}}</span> <small class="text-muted d-block">{{$details['@attributes']['Carrier']}}-{{$details['@attributes']['FlightNumber']}}</small> </span> </div>
                    <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{DateTimeSpliter($details['@attributes']['DepartureTime'],"time")}}</span> <small class="text-muted d-block">{{$details['@attributes']['OriginAirportDetails']->name}}, {{$details['@attributes']['OriginAirportDetails']->city_name}} ,{{$details['@attributes']['OriginAirportDetails']->country_name}}</small> </div>
                    <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-3 text-dark">{{segmentTime($details['@attributes']['FlightTime'])}}</span> <small class="text-muted d-block">Duration</small> </div>
                    <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{DateTimeSpliter($details['@attributes']['ArrivalTime'],"time")}}</span> <small class="text-muted d-block">{{$details['@attributes']['DestationAirportDetails']->name}}, {{$details['@attributes']['DestationAirportDetails']->city_name}} ,{{$details['@attributes']['DestationAirportDetails']->country_name}}</small> </div>
                  </div>
                
                  
                </div>
              </div>
              @endforeach --}}
            @foreach($result['airSegments'] as $details)
            <div class="card  mt-4">
              <div class="card-header">
                <div class="row align-items-center trip-title">
                  <div class="col-5 col-sm-auto text-center text-sm-start">
                    <h5 class="m-0 trip-place">{{$details['OriginAirportDetails']->city_name}}</h5>
                  </div>
                  <div class="col-2 col-sm-auto text-8 text-black-50 text-center trip-arrow">➝</div>
                  <div class="col-5 col-sm-auto text-center text-sm-start">
                    <h5 class="m-0 trip-place">{{$details['DestationAirportDetails']->city_name}}</h5>
                  </div>
                  <div class="col-12 mt-1 d-block d-md-none"></div>
                  <div class="col-6 col-sm col-md-auto text-3 date">{{date('d M ', strtotime($details['DepartureDate']))}} ,{{date('d M ', strtotime($details['ArrivalDate']))}}</div>
                
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-3 text-center text-md-start d-lg-flex company-info"> <span class="align-middle"><img width="40" height="40" alt="" src="https://www.gstatic.com/flights/airline_logos/70px/{{$details['Carrier']}}.png"> </span> <span class="align-middle ms-lg-2"> <span class="d-block text-2 text-dark mt-1 mt-lg-0">{{$details['AirLine']}}</span> <small class="text-muted d-block">
                    @if($details['Carrier'] == 'G9')
                    {{$details['FlightNumber']}}
                    @else
                    {{$details['Carrier']}}-{{$details['FlightNumber']}}
                    @endif
                  </small> </span> </div>
                  <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{$details['DepartureTime']}}</span> <small class="text-muted d-block">{{$details['OriginAirportDetails']->name}}, {{$details['OriginAirportDetails']->city_name}} ,{{$details['OriginAirportDetails']->country_name}}</small> </div>
                  <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-3 text-dark">{{$details['FlightTime']}}</span> <small class="text-muted d-block">Duration</small> </div>
                  <div class="col-12 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 text-dark">{{$details['ArrivalTime']}}</span> <small class="text-muted d-block">{{$details['DestationAirportDetails']->name}}, {{$details['DestationAirportDetails']->city_name}} ,{{$details['DestationAirportDetails']->country_name}}</small> </div>
                </div>
              </div>
            </div>
            @endforeach
          
            <!-- Departure Flight Detail end --> 
            
      
            
            <div class="alert alert-info mt-4"> <span class="badge bg-info">{{__('lang.note')}} </span>{{__('lang.preview_descrption')}}  </div>
            <h2 class="text-6 mb-3 mt-5">{{__('lang.contact_details')}} </h2>
            <ul class="list-unstyled">
                <li class="mb-2 ">{{__('lang.email')}} <span class="float-end text-4 fw-500 text-dark">{{$bookingDetails->email}}</span></li>
                <li class="mb-2">{{__('lang.mobile')}}  <span class="float-end text-4 fw-500 text-dark">{{$bookingDetails->Customercountry->phone_code}}&nbsp;{{$bookingDetails->mobile}}</span></li>
              </ul>
            {{-- <p class="text-info">{{__('lang.message_info')}} </p> --}}
            <h2 class="text-6 mb-3 mt-1">{{__('lang.traveller_details')}} </h2>
            
              @csrf
              {{-- <div class="row g-3 mb-3">
                <input type ="hidden" name="UUID" value="{{$uuid}}">
                <div class="col-5">
                  <input class="form-control @error('email') is-invalid @enderror" id="email" name= "email" required placeholder="{{__('lang.enter_email_id')}}" type="text" value="{{old('email', Auth::guard('web')->user()->email ?? '')}}">
                  <div id="emailerror" style="color: red"></div>
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="col-3">
                  <select class="form-select @error('country_id') is-invalid @enderror" required name= "country_id" id="country" style="min-height: 46% !important" value="{{old('country_id')}}"> 
                    <option value="">Select country Code</option>
                    @foreach($countries as $country)
                      <option value = "{{$country->id}}" {{ (old('country_id', Auth::guard('web')->user()->country_id ?? '') == $country->id)? 'selected':'' }}>{{$country->name}} ( {{$country->phone_code}} )</option>
                    @endforeach
                  </select>
                    @error('country_id')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  <div id="countryerror" style="color: red"></div>
                </div>
                <div class="col-4">
                  <input class="form-control  @error('mobile') is-invalid @enderror" data-bv-field="number"   name= "mobile" id="mobileNumber" required placeholder="{{__('lang.enter_mobile_number')}}" type="text"  value="{{old('mobile', Auth::guard('web')->user()->mobile ?? '')}}">
                    @error('mobile')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  <div id="Phoneerror" style="color: red"></div>
                </div>
              </div> --}}

            <div class="tab-pane fade show active" id="third" role="tabpanel" aria-labelledby="third-tab">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{__('lang.title')}}</th>
                        <th>{{__('lang.first_name')}}</th>
                        <th>{{__('lang.last_name')}}</th>
                        <th>{{__('lang.dob')}}</th>
                        <th>{{__('lang.passport_number')}}</th>
                        <th>{{__('lang.country')}}</th>
                        <th>{{__('lang.exipry_date')}}</th>
                        {{-- @if($bookingDetails->booking_type == 'roundtrip') --}}
                        @if($bookingDetails->supplier_type == 'airarabia')
                          <th>{{__('lang.depature_extra_baggage')}}</th>
                          @if($bookingDetails->booking_type == 'roundtrip')
                            <th>{{__('lang.return_extra_baggage')}} </th>
                          @endif
                        @endif
                      
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($passengersInfo) > 0)
                          @foreach($passengersInfo as $passengerDetails)
                          <tr>
                          <td class="align-middle">{{$passengerDetails->title}}</td>
                          <td class="align-middle">{{$passengerDetails->first_name}}</td>
                          <td class="align-middle">{{$passengerDetails->last_name}}</td>
                          <td class="align-middle">{{$passengerDetails->date_of_birth->format('d/m/Y')}}</td>
                          <td class="align-middle">{{$passengerDetails->passport_number}}</td>
                          <td class="align-middle">{{$passengerDetails->passportIssuedCountry->name}}</td>
                          <td class="align-middle">{{$passengerDetails->passport_expire_date->format('d/m/Y')}}</td>
                          @if($bookingDetails->supplier_type == 'airarabia')
                            <td class="align-middle">{{$passengerDetails->depature_extra_baggage}}</td>
                            @if($bookingDetails->booking_type == 'roundtrip')
                              <td class="align-middle">{{$passengerDetails->return_extra_baggage}}</td>
                            @endif
                          @endif
                          </tr>
                          @endforeach
                      @else
                          <tr align="center" class="alert alert-danger">
                              <td colspan="7">{{__('lang.no_records')}}</td>
                          </tr>
                      @endif
                     
                    </tbody>
                  </table>
        
                </div>
            </div>
            <div class="col-12">

            <a href="{{route('home')}}" class="btn btn-primary mx-4 col-6"> <i class="fa fa-arrow-left"></i> &nbsp; {{__('lang.back_to_home')}}</button>
            <a  class="btn btn-danger  col-5" href="{{route('home')}}">{{__('lang.cancle')}}  &nbsp; <i class="fa fa-times"></i></a>
            </div>
          </div>
        </div>
        
        <!-- Side Panel (Fare Details)
          ============================================= -->
        <aside class="col-lg-4 mt-4 mt-lg-0">
          <div class="bg-white shadow-md rounded p-3">
            <h3 class="text-5 mb-3">{{__('lang.fare_details')}} </h3>
            <hr class="mx-n3">
            <ul class="list-unstyled">
              <li class="mb-2">{{__('lang.base_fare')}}  <span class="float-end text-4 fw-500 text-dark">{{$result['markupPrice']['basefare']['currency_code'].' '.$result['markupPrice']['basefare']['value']}}</span><br>
                <small class="text-muted">{{__('lang.adult')}}  : {{$passengersInfo->where("traveler_type", 'ADT')->count()}}, {{__('lang.child')}} : {{$passengersInfo->where("traveler_type", 'CNN')->count()}}, {{__('lang.infant')}} : {{$passengersInfo->where("traveler_type", 'INF')->count()}}</small></li>
              <li class="mb-2">{{__('lang.taxes_fees')}}  <span class="float-end text-4 fw-500 text-dark">{{$result['markupPrice']['tax']['currency_code'].' '.$result['markupPrice']['tax']['value']}}</span></li>
              <li class="mb-2">{{__('lang.coupon_amount')}} <span class="float-end text-4 fw-500 text-dark">{{$result['markupPrice']['coupon']['currency_code'].' '.$result['markupPrice']['coupon']['value']}}</span></li>
              <li class="mb-2">{{__('lang.service_fee')}} <a href="#" data-bs-toggle="tooltip" title="{{__('lang.service_fee')}}"><i class="fa fa-info-circle" style="font-size: 12px;" ></i></a>  <span class="float-end text-4 fw-500 text-dark">{{$result['markupPrice']['service_chargers']['currency_code'].' '.$result['markupPrice']['service_chargers']['value']}}</span></li>
            </ul>
            <div class="text-dark bg-light-4 text-3 fw-600 p-3"> {{__('lang.total_amount')}} <span class="float-end text-6">{{$result['markupPrice']['previewDisplay']['currency_code'].' '.$result['markupPrice']['previewDisplay']['value']}}</span> </div>
            
            {{-- <h3 class="text-4 mb-3 mt-4">Promo Code</h3>
            <div class="input-group mb-3">
              <input class="form-control" placeholder="Promo Code" aria-label="Promo Code" type="text">
              <button class="btn btn-secondary shadow-none px-3" type="submit">APPLY</button>
            </div>
            <ul class="promo-code">
              <li><span class="d-block text-3 fw-600">FLTOFFER</span>Up to $500 Off on your booking. Hurry! Limited period offer. <a class="text-1" href="">Terms & Conditions</a></li>
              <li><span class="d-block text-3 fw-600">HOTOFFER</span>Up to $500 Off on your booking. Hurry! Limited period offer. <a class="text-1" href="">Terms & Conditions</a></li>
              <li><span class="d-block text-3 fw-600">SUMMEROFFER</span>Up to $500 Off on your booking. Hurry! Limited period offer. <a class="text-1" href="">Terms & Conditions</a></li>
              <li><span class="d-block text-3 fw-600">BIGOFFER</span>Up to $500 Off on your booking. Hurry! Limited period offer. <a class="text-1" href="">Terms & Conditions</a></li>
              <li><span class="d-block text-3 fw-600">FLTOFFER</span>Up to $500 Off on your booking. Hurry! Limited period offer. <a class="text-1" href="">Terms & Conditions</a></li>
              <li><span class="d-block text-3 fw-600">FLTOFFER</span>Up to $500 Off on your booking. Hurry! Limited period offer. <a class="text-1" href="">Terms & Conditions</a></li>
            </ul> --}}
            <form name ="booking" method="{{ $bookingDetails->type_of_payment == 'wallet' ? 'GET' : 'POST'}}" action="{{ $bookingDetails->type_of_payment == 'wallet' ? route('bookflight',['flightbookingId' => encrypt($bookingDetails->id)]) : url('paymentGateWay')}}" class = "confirmPreviewFrom">
                @csrf

                <div style="padding: 10px 0px;"> {{__('lang.converted_total_amount')}} {{$result['markupPrice']['FatoorahPaymentAmount']['currency_code'].' '.$result['markupPrice']['FatoorahPaymentAmount']['value']}}</div>
                
                <input type="hidden" value = "{{encrypt($bookingDetails->id)}}" name="booking_id">
                {{-- <div class="mb-3">
                  <label>Payment Type</label>
                  <div class="form-check form-check">
                    <input id="male" name="payment_type" class="form-check-input" checked="" required="" type="radio" value= "k_net">
                    <label class="form-check-label" for="male">K Net</label>
                  </div>
                  <div class="form-check form-check">
                    <input id="female" name="payment_type" class="form-check-input" required="" type="radio" value= "credit_card">
                    <label class="form-check-label" for="female">Credit Card</label>
                  </div>
                </div> --}}
                <div class="form-check text-3 my-1">
                  <input id="agree" name="agree" class="form-check-input" type="checkbox" required>
                  <label class="form-check-label text-2" for="agree">{{__('lang.i_agree_to_the')}} <a href="{{route('TermsOfUse')}}">{{__('lang.terms_of_use')}}</a> {{__('lang.and')}} <a href="{{route('PrivacyPolicy')}}"> {{__('lang.privacy_policy')}}</a>.</label>
                </div>
                <div class="d-grid">
                {{-- validate --}}
                @if($bookingDetails->internal_booking == 1)
                <a class="btn btn-primary" href="" data-bs-toggle="modal" data-bs-target="#internal-confirmation" data-bs-dismiss="modal">{{__('lang.pay_now')}}</a>
                @else
                <button class="btn btn-primary paymentButton" onclick="#" type="submit"  ><span></span>{{__('lang.pay_now')}} </button>
                @endif
                </div>
            </form>
          </div>
        </aside>
   
        <!-- Side Panel End --> 
      @endif
        
      </div>
    </section>
  </div>
  <!-- Content end --> 
  <!-- Jazeera session information get -->
  @php
    $expirationTime = session('airjazeera_token.expiration_time');
    $currentTimestamp = time();
    $remainingTime = $expirationTime - $currentTimestamp;
    $remainingMinutes = floor($remainingTime / 60);
    $remainingSeconds = $remainingTime % 60;
  @endphp
  <!-- end -->
  <div id="internal-confirmation" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('lang.confirm_booking')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="flight-details ">

            <div class="col-12">
              <p class="text-4 fw-300 text-muted text-center mb-4">{{__('lang.confirm_booking_popup_statment')}}</p>
              <div class="col-12">
                <a  class="btn btn-danger  mx-3 col-5" data-bs-dismiss="modal" aria-label="Close">{{__('lang.cancle')}}  &nbsp; <i class="fa fa-times"></i>
                </a>
                <form   method="POST" action="{{url('paymentGateWay')}}" class = "confirmPreviewFrom">
                  @csrf
                  <input type="hidden" value = "{{encrypt($bookingDetails->id)}}" name="booking_id">
                  <button class="btn btn-primary mx-3 col-5 paymentButton" type="submit" > <span></span> {{__('lang.book_now')}} <i class="fa fa-arrow-right"></i> </button>
                </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection
@section('extraScripts')

  <script>
    var fareRule = "{{route('farerules')}}";
    var uuid  = "{{$bookingDetails->session_uuid ?? ''}}";
    if(uuid != "")
    {
      $("#Farerules-list").click(function(e){
      e.preventDefault();
      $.ajax({
        type: 'get',
        url: fareRule,
        data: {
          'sessionid' : uuid
        },
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
          // addClass('preloader')
          $(".preloader").show();
            },
        success: function (response) {
          $(".rulesList").html(response.html);
          $("#farerulesModel").modal('show');
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
              $("#serachpnrfromsubmit").prop('disabled',false);
              $("#serachpnrfromsubmit").find('span').html( '' );
              $(".preloader").hide();
            },
        // error:function(response){
        //   $('#pnrerror').text(response.responseJSON.message);
        //   $("#pnrerror").css('display','block');
        // }
      });
    });
  }
  $(document).ready(function(){
    $(".confirmPreviewFrom").on("submit", function(){
      $(".paymentButton").prop('disabled',true);
      $(".paymentButton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
    });//submit
  });//document ready
  </script>

<!-- Jazeera session timer scripts -->
@if(isset($result['airSegments'][0]['airJazeeraData']) && !empty($result['airSegments'][0]['airJazeeraData']))
<script>
    // Get the remaining time from PHP and convert it to milliseconds
    var remainingTime = <?php echo $remainingTime; ?> * 1000;
    // Start the countdown timer
    var countdown = setInterval(function() {
        // Convert the remaining time to minutes and seconds
        var minutes = Math.floor(remainingTime / 60000);
        var seconds = Math.floor((remainingTime % 60000) / 1000);

        // Display the remaining time
        document.getElementById('minutes').innerHTML = minutes;
        document.getElementById('seconds').innerHTML = seconds;

        // Update the remaining time
        remainingTime -= 1000;

        // Check if the remaining time is over
        if (remainingTime < 0) {
            // Redirect to the home page
            window.location.href = '{{ route('home') }}';

            // Clear the countdown interval
            clearInterval(countdown);
        }
    }, 1000);
</script>
@endif

@endsection

