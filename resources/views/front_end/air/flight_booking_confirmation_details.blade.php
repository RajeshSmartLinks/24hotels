
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
.error {
      color: red;
   }
.col-md-5{
  /* width:45% !important */
}
.imagebig{
  width: 45px;
  height: 45px;
}
.imagesmall{
  width: 25px;
  height: 25px;
}
.sizesmall{
  font-size:10px
}
.sizebig{
  /* width: 27% */
  font-size:14px
}
/* .travellers-dropdown .qty .qty-spinner {
    background: none;
    border: none;
    pointer-events: none;
    text-align: center;
    padding: 0.2rem 0.2rem;
} */

  </style>

  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.flights_confirm_details')}} </h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}} </a></li>
            <li><a href="booking-flights.html">{{__('lang.flights')}} </a></li>
            <li class="active">{{__('lang.flights_confirm_details_breadcurm')}} </li>
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
                <a href="{{url('/')}}" class="btn btn-primary shadow-none px-5 m-2">Back to Home</a> 
              </div>
            </div>
          </div>
        </div>
        @else
        
        <div class="col-lg-8">
          <div class="bg-white shadow-md rounded p-3 p-sm-4 confirm-details">
            <div class="row">
              <div class="col-7">
                <h2 class="text-6 ">{{__('lang.confirm_flight_details')}} </h2>
              </div>
              <div class="col-3">
                @if(isset($result['refund']) && ($result['refund'] == "true"))
                <div class="col col-md-auto text-center ms-auto order-sm-0"><span class="badge bg-success fw-normal text-1">Refundable</span></div>
                @else
                <div class="col col-md-auto text-center ms-auto order-sm-0"><span class="badge bg-danger fw-normal text-1">Non Refundable</span></div>
                @endif
               
            
              </div>
              <div class="col-2">
                {{-- <div class="col-6 col-sm col-md-auto text-end order-sm-1"><a class="text-1" data-bs-toggle="modal" data-bs-target="#fare-rules" href="">Fare Rules</a></div> --}}
                @if($result['type'] != 'airarabia')
                <div class="col-6 col-sm col-md-auto text-end order-sm-1"><a class="text-1" id = "Farerules-list" style="cursor: pointer;">Fare Rules</a></div>
                @endif
              </div>
            </div>
            <div id="farerulesModel" class="modal fade" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document" >
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Fare Rules</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="flight-details rulesList">
                      
                    
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Fare Rules (Modal Dialog) ============================================= -->
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
                  <div class="col-6 col-sm col-md-auto text-3 date"> {{date('d M ', strtotime($details['DepartureDate']))}} ,{{date('d M ', strtotime($details['ArrivalDate']))}}</div>
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
            
      
            
            <div class="alert alert-info mt-4"> <span class="badge bg-info">{{__('lang.note')}} </span>{{__('lang.confirm_desc')}}  </div>
            <h2 class="text-6 mb-3 mt-5">{{__('lang.traveller_details')}} - <span class="text-3"><a href="{{url('/login')}}" title="{{__('lang.login')}}">{{__('lang.login')}} </a> {{__('lang.to_book_faster')}} </span></h2>
            <p class="text-info">{{__('lang.message_info')}} </p>
            <p class="fw-600">{{__('lang.contact_details')}}</p>
            <form name ="booking" method="POST" action="{{url('preview')}}" id="bookingForm">
              @csrf
              <div class="row g-3 mb-3">
                <input type ="hidden" name="UUID" value="{{$uuid}}">
                <div class="col-md-4 col-xl-5 col-sm-2">
                  <input class="form-control @error('email') is-invalid @enderror" id="email" name= "email" required placeholder="{{__('lang.enter_email_id')}}" type="text" value="{{old('email', Auth::guard('web')->user()->email ?? '')}}">
                  <div id="emailerror" style="color: red"></div>
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="col-md-3 col-xl-3 col-sm-2">
                  <select class="form-select @error('country_id') is-invalid @enderror" required name= "country_id" id="country" style="min-height: 46% !important" value="{{old('country_id')}}"> 
                    <option value="">{{__('lang.select_country_code')}}</option>
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
                <div class="col-md-4 col-xl-4 col-sm-2">
                  <input class="form-control  @error('mobile') is-invalid @enderror" data-bv-field="number"   name= "mobile" id="mobileNumber" required placeholder="{{__('lang.enter_mobile_number')}}" type="text"  value="{{old('mobile', Auth::guard('web')->user()->mobile ?? '')}}">
                    @error('mobile')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  <div id="Phoneerror" style="color: red"></div>
                </div>
              </div>
            <p class="text-info">{{__('lang.passenger_details_english_only')}} </p>
            @for($i=1; $i <=$UserRequest['noofAdults'] ;$i++)
            <p class="fw-600">{{__('lang.adult')}} {{$i}}</p>
              @if($i == 1 && Auth::guard('web')->check())
              {{-- prefilling log -in user Details --}}
              <div class="row g-3">
                <div class="col-sm-2">
                  <select class="form-select {{$errors->has('adultTitle.'.($i-1)) ? 'is-invalid':''}}" id="adultTitle-{{$i}}" required="" name= "adultTitle[]" style="min-height: 46% !important">
                    <option value="">{{__('lang.title')}}</option>
                    {{old('adultTitle.'.($i-1), Auth::guard('web')->user()->title)}}
                    <option {{ (old('adultTitle.'.($i-1), Auth::guard('web')->user()->title) == "Mr")? 'selected':'' }}>Mr</option>
                    <option {{ (old('adultTitle.'.($i-1), Auth::guard('web')->user()->title) == "Ms")? 'selected':'' }}>Ms</option>
                    <option {{ (old('adultTitle.'.($i-1), Auth::guard('web')->user()->title) == "Mrs")? 'selected':'' }}>Mrs</option>
                  </select>
                  @if($errors->has('adultTitle.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultTitle.'.($i-1)) }}</strong>
                    </span>
                  @endif
                  <div id ="adultTitle-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control {{$errors->has('adultFirstName.'.($i-1)) ? 'is-invalid':''}}" id="adultFirstName-{{$i}}" required placeholder="{{__('lang.enter_first_name')}}" type="text" name = "adultFirstName[]" value="{{old('adultFirstName.'.($i-1), Auth::guard('web')->user()->first_name)}}">
                  @if($errors->has('adultFirstName.'.($i-1)))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('adultFirstName.'.($i-1)) }}</strong>
                      </span>
                  @endif
                  <div id ="adultFirstName-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-3">
                  <input class="form-control {{$errors->has('adultLastName.'.($i-1)) ? 'is-invalid':''}}" data-bv-field="number" id="adultLastName-{{$i}}" required placeholder="{{__('lang.enter_last_name')}}" type="text" name = "adultLastName[]" value="{{old('adultLastName.'.($i-1), Auth::guard('web')->user()->last_name)}}">
                  @if($errors->has('adultLastName.'.($i-1)))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('adultLastName.'.($i-1)) }}</strong>
                      </span>
                  @endif
                  <div id ="adultLastName-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-3">
                  <input  class="form-control {{$errors->has('adultDOB.'.($i-1)) ? 'is-invalid':''}}" id = "adultDOB-{{$i}}" required placeholder="{{__('lang.adult_dob')}}" type="text"    name = "adultDOB[]"  
                  max="{{date_format(date_sub(date_create(),date_interval_create_from_date_string("13 year")), 'Y-m-d')}}" autocomplete="off" onfocus="(this.type='date')"  title ="{{__('lang.select_adult_date_of_birth')}}" value="{{old('adultDOB.'.($i-1), (Auth::guard('web')->user()->date_of_birth ?? ''))}}">
                  @if($errors->has('adultDOB.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultDOB.'.($i-1)) }}</strong>
                    </span>
                  @endif
                  {{-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> --}}
                  <div id ="adultDOB-{{$i}}-error" style="color: red"></div>
                </div>
              </div>
              <div class="row g-3 mt-1">
                <div class="col-sm-4">
                  <input class="form-control {{$errors->has('adultPassportNumber.'.($i-1)) ? 'is-invalid':''}}" id="adultPassportNumber-{{$i}}" required placeholder="{{__('lang.enter_passport_no')}}" type="text" name = "adultPassportNumber[]" value="{{old('adultPassportNumber.'.($i-1))}}">
                  @if($errors->has('adultPassportNumber.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultPassportNumber.'.($i-1)) }}</strong>
                    </span>
                  @endif
  
                  <div id ="adultPassportNumber-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-4">
                  <select class="form-select {{$errors->has('adultPassportIssueCountry.'.($i-1)) ? 'is-invalid':''}}" required name = "adultPassportIssueCountry[]" id="adultPassportIssueCountry-{{$i}}" style="min-height: 46% !important" title="{{__('lang.passport_issue_country')}}" >
                    <option value="">{{__('lang.passport_issue_country')}}</option>
                    @foreach($countries as $country)
                      <option value = "{{$country->id}}" {{ (old('adultPassportIssueCountry.'.($i-1)) == $country->id)? 'selected':'' }}>{{$country->name}}</option>
                    @endforeach
                  </select>
                  @if($errors->has('adultPassportIssueCountry.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultPassportIssueCountry.'.($i-1)) }}</strong>
                    </span>
                  @endif
                  <div id ="adultPassportIssueCountry-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control {{$errors->has('adultPassportExpireDate.'.($i-1)) ? 'is-invalid':''}}"  id="adultPassportExpireDate-{{$i}}" required placeholder="{{__('lang.passport_expire_date')}}" type="text" name = "adultPassportExpireDate[]" onfocus="(this.type='date')" title ="{{__('lang.passport_expire_date')}}"  value="{{old('adultPassportExpireDate.'.($i-1))}}" min="{{date('Y-m-d')}}">
                  {{-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> --}}
                  @if($errors->has('adultPassportExpireDate.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultPassportExpireDate.'.($i-1)) }}</strong>
                    </span>
                  @endif
                  <div id ="adultPassportExpireDate-{{$i}}-error" style="color: red"></div>
                </div>
              </div>
              @else
              <div class="row g-3">
                <div class="col-sm-2">
                  <select class="form-select {{$errors->has('adultTitle.'.($i-1)) ? 'is-invalid':''}}" id="adultTitle-{{$i}}" required="" name= "adultTitle[]" style="min-height: 46% !important">
                    <option value="">{{__('lang.title')}}</option>
                    <option {{ (old('adultTitle.'.($i-1)) == "Mr")? 'selected':'' }}>Mr</option>
                    <option {{ (old('adultTitle.'.($i-1)) == "Ms")? 'selected':'' }}>Ms</option>
                    <option {{ (old('adultTitle.'.($i-1)) == "Mrs")? 'selected':'' }}>Mrs</option>
                  </select>
                  @if($errors->has('adultTitle.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultTitle.'.($i-1)) }}</strong>
                    </span>
                  @endif
                  <div id ="adultTitle-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control {{$errors->has('adultFirstName.'.($i-1)) ? 'is-invalid':''}}" id="adultFirstName-{{$i}}" required placeholder="{{__('lang.enter_first_name')}}" type="text" name = "adultFirstName[]" value="{{old('adultFirstName.'.($i-1))}}">
                  @if($errors->has('adultFirstName.'.($i-1)))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('adultFirstName.'.($i-1)) }}</strong>
                      </span>
                  @endif
                  <div id ="adultFirstName-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-3">
                  <input class="form-control {{$errors->has('adultLastName.'.($i-1)) ? 'is-invalid':''}}" data-bv-field="number" id="adultLastName-{{$i}}" required placeholder="{{__('lang.enter_last_name')}}" type="text" name = "adultLastName[]" value="{{old('adultLastName.'.($i-1))}}">
                  @if($errors->has('adultLastName.'.($i-1)))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('adultLastName.'.($i-1)) }}</strong>
                      </span>
                  @endif
                  <div id ="adultLastName-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-3">
                  <input  class="form-control {{$errors->has('adultDOB.'.($i-1)) ? 'is-invalid':''}}" id = "adultDOB-{{$i}}" required placeholder="{{__('lang.adult_dob')}}" type="text"    name = "adultDOB[]"  
                  max="{{date_format(date_sub(date_create(),date_interval_create_from_date_string("13 year")), 'Y-m-d')}}" autocomplete="off" onfocus="(this.type='date')"  title ="{{__('lang.select_adult_date_of_birth')}}" value="{{old('adultDOB.'.($i-1))}}">
                  @if($errors->has('adultDOB.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultDOB.'.($i-1)) }}</strong>
                    </span>
                  @endif
                  {{-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> --}}
                  <div id ="adultDOB-{{$i}}-error" style="color: red"></div>
                </div>
              </div>
              <div class="row g-3 mt-1">
                <div class="col-sm-4">
                  <input class="form-control {{$errors->has('adultPassportNumber.'.($i-1)) ? 'is-invalid':''}}" id="adultPassportNumber-{{$i}}" required placeholder="{{__('lang.enter_passport_no')}}" type="text" name = "adultPassportNumber[]" value="{{old('adultPassportNumber.'.($i-1))}}">
                  @if($errors->has('adultPassportNumber.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultPassportNumber.'.($i-1)) }}</strong>
                    </span>
                  @endif
  
                  <div id ="adultPassportNumber-{{$i}}-error" style="color: red"></div>
                </div>
                <div class="col-sm-4">
                  <select class="form-select {{$errors->has('adultPassportIssueCountry.'.($i-1)) ? 'is-invalid':''}}" required name = "adultPassportIssueCountry[]" id="adultPassportIssueCountry-{{$i}}" style="min-height: 46% !important" title="{{__('lang.passport_issue_country')}}" >
                    <option value="">{{__('lang.passport_issue_country')}}</option>
                    @foreach($countries as $country)
                      <option value = "{{$country->id}}" {{ (old('adultPassportIssueCountry.'.($i-1)) == $country->id)? 'selected':'' }}>{{$country->name}}</option>
                    @endforeach
                  </select>
                  @if($errors->has('adultPassportIssueCountry.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultPassportIssueCountry.'.($i-1)) }}</strong>
                    </span>
                  @endif
                  <div id ="adultPassportIssueCountry-{{$i}}-error" style="color: red"></div>
                </div>
                
                <div class="col-sm-4">
                  <input class="form-control {{$errors->has('adultPassportExpireDate.'.($i-1)) ? 'is-invalid':''}}"  id="adultPassportExpireDate-{{$i}}" required placeholder="{{__('lang.passport_expire_date')}}" type="text" name = "adultPassportExpireDate[]" onfocus="(this.type='date')" title ="{{__('lang.passport_expire_date')}}"  value="{{old('adultPassportExpireDate.'.($i-1))}}" min="{{date('Y-m-d')}}">
                  {{-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> --}}
                  @if($errors->has('adultPassportExpireDate.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adultPassportExpireDate.'.($i-1)) }}</strong>
                    </span>
                  @endif
                  <div id ="adultPassportExpireDate-{{$i}}-error" style="color: red"></div>
                </div>
              </div>
              @endif
              {{-- @if($result['type'] == 'airarabia')
                <div class="row g-3 mt-1">
                  <div class="accordion " id="AdultaccordionFlushExample{{$i}}">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-headingOne" style="width: 250px;border: 2px solid #d5d3d3; border-radius: 6px;">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#Audltflush-collapseOne{{$i}}" aria-controls="Audltflush-collapseOne{{$i}}"> {{__('lang.add_extra_baggage')}}</button>
                      </h2>
                      <div id="Audltflush-collapseOne{{$i}}" class="accordion-collapse collapse " aria-labelledby="flush-headingOne" data-bs-parent="#AdultaccordionFlushExample{{$i}}" style="">
                        
                        <div class="accordion-body row">
                          <?php
                            $mainclass = $UserRequest['flight-trip'] == 'roundtrip' ? "col-md-5 col-sm-12" : "col-12"; 
                            $imageclass = $UserRequest['flight-trip'] == 'roundtrip' ? "imagesmall" : "imagebig"; 
                            $sizeclass = $UserRequest['flight-trip'] == 'roundtrip' ? "sizesmall" : "sizebig"; 
                          ?>
                          @if(isset($result['DeparatureBaggage']) && count($result['DeparatureBaggage']) > 0)
                          <div class="{{$mainclass}}" style="border: 2px solid #d5d3d3;border-radius: 5px;padding-bottom: 10px;padding-left: 13px;">
                            <label style="padding-top: 10px;">{{__('lang.depature')}}</label><br>
                            <?php //if($UserRequest['flight-trip'] != 'roundtrip') { $width = 85/count($result['DeparatureBaggage']); $inlinestyle="width:$width%";}else{$inlinestyle="";}?>
                            @foreach($result['DeparatureBaggage'] as $k =>$bv)
                            <div class="form-check form-check-inline text-center {{$sizeclass}}" style="{{$inlinestyle}}">
                              <input name="adultdepatureextrabaggage[{{$i-1}}]" class="form-check-input extrabaggage adultdepatureextrabaggage{{$i-1}}"  type="radio" value="{{$bv['baggageCode']}}" style="margin-top: 26px;" {{($bv['baggageCharge']['total_price']['value'] == 0) ? 'checked' : ''}} data-convertedpricingvalue ={{$bv['baggageCharge']['total_price']['value']}} data-standedpricingvalue ={{$bv['baggageCharge']['standed_price']['value']}} >
                              <label class="form-check-label center">{{$bv['baggageCode']}}<span><br>
                                <img src="{{asset('frontEnd/images/travel-bag.png')}}" class="{{$imageclass}}">
                                <br>
                                <span>{{$bv['baggageCharge']['total_price']['currency_code'] ." ".$bv['baggageCharge']['total_price']['value']}}</span>
                              </span></label>
                            </div>
                            @endforeach
                          </div>
                          @else
                            @if($UserRequest['flight-trip'] == 'roundtrip')
                            <div class ="col-md-5">
                              <p> NO Extra Baggage</p>
                            </div>
                            @else
                            <div class ="col-md-10">
                              <p> NO Extra Baggage</p>
                            </div>
                            @endif
                          @endif
                          @if(isset($result['ReturnBaggage']))
                            @if($UserRequest['flight-trip'] == 'roundtrip')
                              <div class= "col-1"></div>
                            @endif
                            @if(count($result['ReturnBaggage']) > 0)
                            <div class="{{$mainclass}}" style="border: 2px solid #d5d3d3;border-radius: 5px;padding-bottom: 10px;padding-left: 13px;">
                              <label style="padding-top: 10px;">{{__('lang.return')}}</label><br>
                              @foreach($result['ReturnBaggage'] as $k =>$bv)
                              <div class="form-check form-check-inline text-center {{$sizeclass}}" >
                                <input name="adultreturnextrabaggage[{{$i-1}}]" class="form-check-input extrabaggage adultreturnextrabaggage{{$i-1}}"  type="radio" value="{{$bv['baggageCode']}}" style="margin-top: 26px;" {{($bv['baggageCharge']['total_price']['value'] == 0) ? 'checked' : ''}} data-convertedpricingvalue ={{$bv['baggageCharge']['total_price']['value']}} data-standedpricingvalue ={{$bv['baggageCharge']['standed_price']['value']}}>
                                <label class="form-check-label center">{{$bv['baggageCode']}}<span><br>
                                  <img src="{{asset('frontEnd/images/travel-bag.png')}}" class="{{$imageclass}}">
                                  <br>
                                  <span>{{$bv['baggageCharge']['total_price']['currency_code'] ." ".$bv['baggageCharge']['total_price']['value']}}</span>
                                </span></label>
                              </div>
                              @endforeach
                            </div>
                            @else
                              <div class ="col-md-5">
                                <p> NO Extra Baggage</p>
                              </div>
                            @endif

                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif --}}
          
            @endfor
            @for($i=1; $i <=$UserRequest['noofChildren'] ;$i++)
            <p class="fw-600">{{__('lang.children')}} {{$i}}</p>
            <div class="row g-3">
              <div class="col-sm-2">
                <select class="form-select {{$errors->has('childrenTitle.'.($i-1)) ? 'is-invalid':''}}" id="childrenTitle-{{$i}}" required name= "childrenTitle[]" style="min-height: 46% !important">
                  <option value="">Title</option>
                  {{-- <option {{ (old('childrenTitle.'.($i-1)) == "Mr")? 'selected':'' }} >Mr</option>
                  <option {{ (old('childrenTitle.'.($i-1)) == "Ms")? 'selected':'' }}>Ms</option>
                  <option {{ (old('childrenTitle.'.($i-1)) == "Mrs")? 'selected':'' }}>Mrs</option> --}}
                  <option {{ (old('childrenTitle.'.($i-1)) == "Master")? 'selected':'' }}>Master</option>
                  <option {{ (old('childrenTitle.'.($i-1)) == "Miss")? 'selected':'' }}>Miss</option>
                </select>
                @if($errors->has('childrenTitle.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('childrenTitle.'.($i-1)) }}</strong>
                  </span>
                @endif
                <div id ="childrenTitle-{{$i}}-error" style="color: red"></div>
              </div>
              <div class="col-sm-4">
                <input class="form-control {{$errors->has('childrenFirstName.'.($i-1)) ? 'is-invalid':''}}" id="childrenFirstName-{{$i}}" required placeholder="{{__('lang.enter_first_name')}}" type="text" name= "childrenFirstName[]" value="{{old('childrenFirstName.'.($i-1))}}">
                @if($errors->has('childrenFirstName.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('childrenFirstName.'.($i-1)) }}</strong>
                    </span>
                @endif
                <div id ="childrenFirstName-{{$i}}-error" style="color: red"></div>
              </div>
              <div class="col-sm-3">
                <input class="form-control {{$errors->has('childrenLastName.'.($i-1)) ? 'is-invalid':''}}" data-bv-field="number" id="childrenLastName-{{$i}}" required placeholder="{{__('lang.enter_last_name')}}" type="text" name= "childrenLastName[]" value="{{old('childrenLastName.'.($i-1))}}">
                @if($errors->has('childrenLastName.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('childrenLastName.'.($i-1)) }}</strong>
                    </span>
                @endif
                <div id ="childrenLastName-{{$i}}-error" style="color: red"></div>
              </div>
              <div class="col-sm-3">
                <input  class="form-control {{$errors->has('childrenDOB.'.($i-1)) ? 'is-invalid':''}}" id = "childrenDOB-{{$i}}" required placeholder="{{__('lang.children_dob')}}" type="text"    name = "childrenDOB[]" min="{{date_format(date_sub(date_create(),date_interval_create_from_date_string("12 year")), 'Y-m-d')}}" max="{{date_format(date_sub(date_create(),date_interval_create_from_date_string("2 year")), 'Y-m-d')}}" autocomplete="off" onfocus="(this.type='date')"  title ="{{__('lang.select_children_date_of_birth')}}" value="{{old('childrenDOB.'.($i-1))}}">
                @if($errors->has('childrenDOB.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('childrenDOB.'.($i-1)) }}</strong>
                  </span>
                @endif
                {{-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> --}}
                <div id ="childrenDOB-{{$i}}-error" style="color: red"></div>
              </div>
            
              
            </div>

            <div class="row g-3 mt-1">
              <div class="col-sm-4">
                <input class="form-control {{$errors->has('childrenPassportNumber.'.($i-1)) ? 'is-invalid':''}}" id="childrenPassportNumber-{{$i}}" required placeholder="{{__('lang.enter_passport_no')}}" type="text" name = "childrenPassportNumber[]" value="{{old('childrenPassportNumber.'.($i-1))}}">
                @if($errors->has('childrenPassportNumber.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('childrenPassportNumber.'.($i-1)) }}</strong>
                    </span>
                @endif
                <div id ="childrenPassportNumber-{{$i}}-error" style="color: red"></div>
              </div>
              <div class="col-sm-4">
                <select class="form-select {{$errors->has('childrenPassportIssueCountry.'.($i-1)) ? 'is-invalid':''}}" required name = "childrenPassportIssueCountry[]" id="childrenPassportIssueCountry-{{$i}}" style="min-height: 46% !important" title="{{__('lang.passport_issue_country')}}">
                  <option value="">{{__('lang.passport_issue_country')}}</option>
                  @foreach($countries as $country)
                  <option value = "{{$country->id}}" {{ (old('childrenPassportIssueCountry.'.($i-1)) == $country->id)? 'selected':'' }}>{{$country->name}}</option>
                  @endforeach
                </select>
                @if($errors->has('childrenPassportIssueCountry.'.($i-1)))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('childrenPassportIssueCountry.'.($i-1)) }}</strong>
                    </span>
                @endif
                <div id ="childrenPassportIssueCountry-{{$i}}-error" style="color: red"></div>
              </div>
              
              <div class="col-sm-4">
                <input class="form-control {{$errors->has('childrenPassportExpireDate.'.($i-1)) ? 'is-invalid':''}}"  id="childrenPassportExpireDate-{{$i}}" required placeholder="{{__('lang.passport_expire_date')}}" type="text" name = "childrenPassportExpireDate[]" onfocus="(this.type='date')" title ="{{__('lang.passport_expire_date')}}" value="{{old('childrenPassportExpireDate.'.($i-1))}}" min="{{date('Y-m-d')}}">
                {{-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> --}}
                @if($errors->has('childrenPassportExpireDate.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('childrenPassportExpireDate.'.($i-1)) }}</strong>
                  </span>
                @endif
                <div id ="childrenPassportExpireDate-{{$i}}-error" style="color: red"></div>
              </div>
            </div>
            {{-- @if($result['type'] == 'airarabia')
              <div class="row g-3 mt-1">
                <div class="accordion" id="ChildaccordionFlushExample{{$i}}">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne" style="width: 250px;border: 2px solid #d5d3d3; border-radius: 6px;">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#childflush-collapseOne{{$i}}" aria-controls="childflush-collapseOne{{$i}}"> {{__('lang.add_extra_baggage')}}</button>
                    </h2>
                    <div id="childflush-collapseOne{{$i}}" class="accordion-collapse collapse " aria-labelledby="flush-headingOne" data-bs-parent="#ChildaccordionFlushExample{{$i}}" style="">
                      
                      <div class="accordion-body row">
                        <?php
                          $mainclass = $UserRequest['flight-trip'] == 'roundtrip' ? "col-md-5 col-sm-12" : "col-12"; 
                          $imageclass = $UserRequest['flight-trip'] == 'roundtrip' ? "imagesmall" : "imagebig"; 
                          $sizeclass = $UserRequest['flight-trip'] == 'roundtrip' ? "sizesmall" : "sizebig"; 
                        ?>
                        @if(isset($result['DeparatureBaggage'])  && count($result['DeparatureBaggage']) > 0)
                        <div class="{{$mainclass}}" style="border: 2px solid #d5d3d3;border-radius: 5px;padding-bottom: 10px;padding-left: 13px;">
                          <?php //if($UserRequest['flight-trip'] != 'roundtrip') { $width = 85/count($result['DeparatureBaggage']); $inlinestyle="width:$width%";}else{$inlinestyle="";}?>
                          <label style="padding-top: 10px;">{{__('lang.depature')}}</label><br>
                          @foreach($result['DeparatureBaggage'] as $k =>$bv)
                          <div class="form-check form-check-inline text-center {{$sizeclass}}" style="{{$inlinestyle}}">
                            <input name="childrendepatureextrabaggage[{{$i-1}}]" class="form-check-input extrabaggage childrendepatureextrabaggage{{$i-1}}"  type="radio" value="{{$bv['baggageCode']}}" style="margin-top: 26px;" {{($bv['baggageCharge']['total_price']['value'] == 0) ? 'checked' : ''}} data-convertedpricingvalue ={{$bv['baggageCharge']['total_price']['value']}} data-standedpricingvalue ={{$bv['baggageCharge']['standed_price']['value']}}>
                            <label class="form-check-label center">{{$bv['baggageCode']}}<span><br>
                              <img src="{{asset('frontEnd/images/travel-bag.png')}}" class="{{$imageclass}}">
                              <br>
                              <span>{{$bv['baggageCharge']['total_price']['currency_code'] ." ".$bv['baggageCharge']['total_price']['value']}}</span>
                            </span></label>
                          </div>
                          @endforeach
                        </div>
                        @else
                          @if($UserRequest['flight-trip'] == 'roundtrip')
                          <div class ="col-md-5">
                            <p> NO Extra Baggage</p>
                          </div>
                          @else
                          <div class ="col-md-10">
                            <p> NO Extra Baggage</p>
                          </div>
                          @endif
                        @endif

                        @if(isset($result['ReturnBaggage']))
                          @if($UserRequest['flight-trip'] == 'roundtrip')
                          <div class= "col-1"></div>
                          @endif
                          @if(count($result['ReturnBaggage']) > 0)
                            <div class="{{$mainclass}}" style="border: 2px solid #d5d3d3;border-radius: 5px;padding-bottom: 10px;padding-left: 13px;">
                              <label style="padding-top: 10px;">{{__('lang.return')}}</label><br>
                              @foreach($result['ReturnBaggage'] as $k =>$bv)
                              <div class="form-check form-check-inline text-center {{$sizeclass}}" >
                                <input name="childrenreturnextrabaggage[{{$i-1}}]" class="form-check-input extrabaggage childrenreturnextrabaggage{{$i-1}}"  type="radio" value="{{$bv['baggageCode']}}" style="margin-top: 26px;" {{($bv['baggageCharge']['total_price']['value'] == 0) ? 'checked' : ''}} data-convertedpricingvalue ={{$bv['baggageCharge']['total_price']['value']}} data-standedpricingvalue ={{$bv['baggageCharge']['standed_price']['value']}}>
                                <label class="form-check-label center">{{$bv['baggageCode']}}<span><br>
                                  <img src="{{asset('frontEnd/images/travel-bag.png')}}" class="{{$imageclass}}">
                                  <br>
                                  <span>{{$bv['baggageCharge']['total_price']['currency_code'] ." ".$bv['baggageCharge']['total_price']['value']}}</span>
                                </span></label>
                              </div>
                              @endforeach
                            </div>
                            @else
                              <div class ="col-md-5">
                                <p> NO Extra Baggage</p>
                              </div>
                            @endif

                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif --}}
            @endfor
            @for($i=1; $i <=$UserRequest['noofInfants'] ;$i++)
            <p class="fw-600">Infant {{$i}}</p>
            <div class="row g-3">
              <div class="col-sm-2">
                <select class="form-select {{$errors->has('infantsTitle.'.($i-1)) ? 'is-invalid':''}}" id="infantsTitle-{{$i}}" required="" name= "infantsTitle[]" style="min-height: 46% !important">
                  <option value="">Title</option>
                  {{-- <option {{ (old('infantsTitle.'.($i-1)) == "Mr")? 'selected':'' }} >Mr</option>
                  <option {{ (old('infantsTitle.'.($i-1)) == "Ms")? 'selected':'' }}>Ms</option>
                  <option {{ (old('infantsTitle.'.($i-1)) == "Mrs")? 'selected':'' }}>Mrs</option> --}}
                  <option {{ (old('infantsTitle.'.($i-1)) == "Master")? 'selected':'' }}>Master</option>
                  <option {{ (old('infantsTitle.'.($i-1)) == "Miss")? 'selected':'' }}>Miss</option>
                </select>
                @if($errors->has('infantsTitle.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('infantsTitle.'.($i-1)) }}</strong>
                  </span>
                @endif
                <div id ="infantsTitle-{{$i}}-error" style="color: red"></div>
              </div>
              <div class="col-sm-4">
                <input class="form-control {{$errors->has('infantsFirstName.'.($i-1)) ? 'is-invalid':''}}" id="infantsFirstName-{{$i}}" required placeholder="{{__('lang.enter_first_name')}}" type="text" name= "infantsFirstName[]" value="{{old('infantsFirstName.'.($i-1))}}">
                @if($errors->has('infantsFirstName.'.($i-1)))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('infantsFirstName.'.($i-1)) }}</strong>
                </span>
              @endif
                <div id ="infantsFirstName-{{$i}}-error" style="color: red"></div>
              </div>
              <div class="col-sm-3">
                <input class="form-control {{$errors->has('infantsLastName.'.($i-1)) ? 'is-invalid':''}}" data-bv-field="number" id="infantsLastName-{{$i}}" required placeholder="{{__('lang.enter_last_name')}}" type="text" name= "infantsLastName[]" value="{{old('infantsLastName.'.($i-1))}}">
                @if($errors->has('infantsLastName.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('infantsLastName.'.($i-1)) }}</strong>
                  </span>
                @endif
                <div id ="infantsLastName-{{$i}}-error" style="color: red"></div>
              </div>
              <div class="col-sm-3">
                <input  class="form-control {{$errors->has('infantsDOB.'.($i-1)) ? 'is-invalid':''}}" required placeholder="{{__('lang.infant_dob')}}" type="text"    name = "infantsDOB[]"  min="{{date_format(date_sub(date_create(),date_interval_create_from_date_string("2 year")), 'Y-m-d')}}" max="{{date_format(date_sub(date_create(),date_interval_create_from_date_string("15 day")), 'Y-m-d')}}" autocomplete="off" onfocus="(this.type='date')"  title ="{{__('lang.select_infant_date_of_birth')}}" value="{{old('infantsDOB.'.($i-1))}}" id = "infantsDOB-{{$i}}">
                {{-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> --}}


                @if($errors->has('infantsDOB.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('infantsDOB.'.($i-1)) }}</strong>
                  </span>
                @endif
                <div id ="infantsDOB-{{$i}}-error" style="color: red"></div>
              </div>
            </div>
            <div class="row g-3 mt-1">
              <div class="col-sm-4">
                <input class="form-control {{$errors->has('infantsPassportNumber.'.($i-1)) ? 'is-invalid':''}}" id="infantsPassportNumber-{{$i}}" required placeholder="{{__('lang.enter_passport_no')}}" type="text" name = "infantsPassportNumber[]" value="{{old('infantsPassportNumber.'.($i-1))}}">
                @if($errors->has('infantsPassportNumber.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('infantsPassportNumber.'.($i-1)) }}</strong>
                  </span>
                @endif
                <div id ="infantsPassportNumber-{{$i}}-error" style="color: red"></div>
              </div>
              <div class="col-sm-4">
                <select class="form-select {{$errors->has('infantsPassportIssueCountry.'.($i-1)) ? 'is-invalid':''}}" required name = "infantsPassportIssueCountry[]" id="infantsPassportIssueCountry-{{$i}}" style="min-height: 46% !important" title="{{__('lang.passport_issue_country')}}">
                  <option value="">{{__('lang.passport_issue_country')}}</option>
                  @foreach($countries as $country)
                  <option value = "{{$country->id}}" {{ (old('infantsPassportIssueCountry.'.($i-1)) == $country->id)? 'selected':'' }}>{{$country->name}}</option>
                  @endforeach
                </select>
                @if($errors->has('infantsPassportIssueCountry.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('infantsPassportIssueCountry.'.($i-1)) }}</strong>
                  </span>
                @endif
                <div id ="infantsPassportIssueCountry-{{$i}}-error" style="color: red"></div>
              </div>
              
              <div class="col-sm-4">
                <input class="form-control {{$errors->has('infantsPassportExpireDate.'.($i-1)) ? 'is-invalid':''}} "  id="infantsPassportExpireDate-{{$i}}" required placeholder="{{__('lang.passport_expire_date')}}" type="text" name = "infantsPassportExpireDate[]" onfocus="(this.type='date')" title ="{{__('lang.passport_expire_date')}}" value="{{old('infantsPassportExpireDate.'.($i-1))}}" min="{{date('Y-m-d')}}">
                {{-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> --}}
                @if($errors->has('infantsPassportExpireDate.'.($i-1)))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('infantsPassportExpireDate.'.($i-1)) }}</strong>
                  </span>
                @endif
                <div id ="infantsPassportExpireDate-{{$i}}-error" style="color: red"></div>
              </div>
            </div>
            @endfor
            @if($result['type'] == 'airarabia')
            <div class="row g-3 mt-1">
              <div class="accordion" id="ChildaccordionFlushExample1">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingOne" style="/* width: 250px; */border: 2px solid #d5d3d3;border-radius: 6px;">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#childflush-collapseOne1" aria-controls="childflush-collapseOne1" aria-expanded="true">Add On</button>
                  </h2>
                  <div id="childflush-collapseOne1" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#ChildaccordionFlushExample1" style="">
                    <div class="row">
                      <div style="padding: 10px 30px;">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          @if(isset($result['DeparatureBaggage']) && !empty($result['DeparatureBaggage']))
                          <li class="nav-item" style="width: 50%;"> <a class="nav-link active" id="mobile-recharge-tab" data-bs-toggle="tab" href="#mobile-recharge" role="tab" aria-controls="mobile-recharge" aria-selected="true">
                            <div class="row">
                              <div class="col-3">
                                <img src="https://www.gstatic.com/flights/airline_logos/70px/{{$result['DeparatureBaggage']['segments'][0]['Carrier']}}.png" alt="baggage_carrier" class="">
                            </div>
                              <div class="col-9">
                                <div style="padding: 5px 0px;">
                                  <?php $dB = count($result['DeparatureBaggage']['segments'])-1;
                                  ?>
                                  {{$result['DeparatureBaggage']['segments'][0]['DepartureAirport']}} - {{$result['DeparatureBaggage']['segments'][$dB]['ArrivalAirport']}}
                              </div>
                                  
                                  <div>
                                    <span id ="depaturetotalbaggage">0</span> of <span id ="depaturemaxbaggage">0</span> baggage selected
                                  </div>
                                  
                              </div>
                            </div></a>
                          </li>
                          @endif
                          @if(isset($result['ReturnBaggage']) && !empty($result['ReturnBaggage']))
                          <li class="nav-item" style="width: 50%;">
                              <a class="nav-link" id="billpayment-tab" data-bs-toggle="tab" href="#billpayment" role="tab" aria-controls="billpayment" aria-selected="false">
                              <div class="row">
                                <div class="col-3">
                                    <img src="https://www.gstatic.com/flights/airline_logos/70px/{{$result['ReturnBaggage']['segments'][0]['Carrier']}}.png" alt="baggage_carrier" class="">
                                </div>
                                <div class="col-9">
                                    <div style="padding: 5px 0px;">
                                        {{$result['ReturnBaggage']['segments'][0]['DepartureAirport']}} - {{$result['ReturnBaggage']['segments'][count($result['ReturnBaggage']['segments'])-1]['ArrivalAirport']}}
                                    </div>
                                    
                                    <div>
                                      <span id ="returntotalbaggage">0</span> of <span id ="returnmaxbaggage">0</span> baggage selected
                                    </div>
                                    
                                </div>
                              </div>
                              </a>
                          </li>
                              
                          @endif
                        </ul>
                        <div class="tab-content my-3" id="myTabContent">
                          @if(isset($result['DeparatureBaggage']) && !empty($result['DeparatureBaggage']))
                          <div class="tab-pane fade active show" id="mobile-recharge" role="tabpanel" aria-labelledby="mobile-recharge-tab">
                            @foreach ($result['DeparatureBaggage']['baggage'] as $DeparatureBaggage)
                            <div class="row">
                              <div class="col-2">
                                  <img src="{{asset('frontEnd/images/travel-bag.png')}}" alt="baggage_carrier" class="imagebig">
                                  
                              </div>
                          
                              <div class="col-5">
                                  <div style="padding: 1px 0px;"><b>{{$DeparatureBaggage['baggageCode']}}</b></div>
                                  <div><small>{{$DeparatureBaggage['baggageDescription']??''}}</small></div>
                              </div>
                              <div class="col-2">
                                <div style=" display: flex; justify-content: center; padding: 13px 0px;">{{$DeparatureBaggage['baggageCharge']['total_price']['currency_code'] ." ".$DeparatureBaggage['baggageCharge']['total_price']['value']}}</div>
                              </div>
                              <?php $iddepatue = 'depature_'.str_replace(' ','_',$DeparatureBaggage['baggageCode']); ?>
                              
                              <div class="col-3">
                                <div class="qty input-group">
                                  <div class="input-group-prepend">
                                    <button type="button" class="btn bg-light-4 qtyChanger"  onclick="baggageaddon('remove','depature',{{$DeparatureBaggage['baggageCharge']['total_price']['value']}} , {{$DeparatureBaggage['baggageCharge']['standed_price']['value']}},'{{$iddepatue}}')">-</button>
                                  </div>
                                  <input type="text" data-ride="spinner" id="{{$iddepatue}}" class="qty-spinner form-control depatureaddon" value="0" name="Depaturebaggage[{{$DeparatureBaggage['baggageCode']}}]" readonly="" style=" background: none;border: none;pointer-events: none;text-align: center;padding: 0.2rem 0.2rem;">
                                  <div class="input-group-append">
                                    <button type="button" class="btn bg-light-4 qtyChanger"  onclick="baggageaddon('add','depature',{{$DeparatureBaggage['baggageCharge']['total_price']['value']}} , {{$DeparatureBaggage['baggageCharge']['standed_price']['value']}},'{{$iddepatue}}')">+</button>
                                  </div>
                                </div>
                              </div>
                              <hr>
                            </div>
                            @endforeach
                          <hr>
                          </div>
                          @endif
                          @if(isset($result['ReturnBaggage']) && !empty($result['ReturnBaggage']))
                          <div class="tab-pane fade" id="billpayment" role="tabpanel" aria-labelledby="billpayment-tab">
                            @foreach ($result['ReturnBaggage']['baggage'] as $ReturnBaggage)
                            <div class="row">
                              <div class="col-2">
                                  <img src="{{asset('frontEnd/images/travel-bag.png')}}" alt="baggage_carrier" class="imagebig">
                                  
                              </div>
                             
                              <div class="col-5">
                                <div style="padding: 1px 0px;"><b>{{$ReturnBaggage['baggageCode']}}</b></div>
                                <div><small>{{$ReturnBaggage['baggageDescription']}}</small></div>
                              </div>
                              
                              <div class="col-2">
                                <div style=" display: flex; justify-content: center; padding: 13px 0px;">{{$ReturnBaggage['baggageCharge']['total_price']['currency_code'] ." ".$ReturnBaggage['baggageCharge']['total_price']['value']}}</div>
                              </div>
                              
                              <div class="col-3">
                                <div class="qty input-group">
                                  {{-- <div class="input-group-prepend">
                                    <button type="button" class="btn bg-light-4 qtyChanger" id="remove-room">-</button>
                                  </div>
                                  <input type="text" data-ride="spinner" id="hotels-rooms" class="qty-spinner form-control" value="1" name="noOfRooms" readonly="" style=" background: none;border: none;pointer-events: none;text-align: center;padding: 0.2rem 0.2rem;">
                                  <div class="input-group-append">
                                    <button type="button" class="btn bg-light-4 qtyChanger" id="add-room">+</button>
                                  </div> --}}
                                  <?php $idreturn = 'return_'.str_replace(' ','_',$ReturnBaggage['baggageCode']); ?>

                                  <div class="input-group-prepend">
                                    <button type="button" class="btn bg-light-4 qtyChanger"  onclick="baggageaddon('remove','return',{{$ReturnBaggage['baggageCharge']['total_price']['value']}} , {{$ReturnBaggage['baggageCharge']['standed_price']['value']}},'{{$idreturn}}')">-</button>
                                  </div>
                                  <input type="text" data-ride="spinner" id="{{$idreturn}}" class="qty-spinner form-control returnaddon" value="0" name="Returnbaggage[{{$ReturnBaggage['baggageCode']}}]" readonly="" style=" background: none;border: none;pointer-events: none;text-align: center;padding: 0.2rem 0.2rem;">
                                  <div class="input-group-append">
                                    <button type="button" class="btn bg-light-4 qtyChanger"  onclick="baggageaddon('add','return',{{$ReturnBaggage['baggageCharge']['total_price']['value']}} , {{$ReturnBaggage['baggageCharge']['standed_price']['value']}},'{{$idreturn}}')">+</button>
                                  </div>
                                </div>
                              </div>
                              <hr>
                            </div>
                            @endforeach
                          </div>
                          @endif
                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
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
                <small class="text-muted">{{__('lang.adult')}}  : {{$UserRequest['noofAdults']}}, {{__('lang.child')}} : {{$UserRequest['noofChildren']}}, {{__('lang.infant')}} : {{$UserRequest['noofInfants']}}</small></li>
              <li class="mb-2">{{__('lang.taxes_fees')}}  <span class="float-end text-4 fw-500 text-dark">{{$result['markupPrice']['tax']['currency_code'].' '.$result['markupPrice']['tax']['value']}}</span></li>
              <li class="mb-2"> {{__('lang.add_on_charges')}}<span class="float-end text-4 fw-500 text-dark">{{$result['markupPrice']['tax']['currency_code']}} &nbsp; <span id ="addoncharages" data-addoncharages = "0">0</span></span></li>
              <li class="mb-2"> {{__('lang.coupon_amount')}}<span class="float-end text-4 fw-500 text-dark">{{$result['markupPrice']['tax']['currency_code']}} &nbsp; <span id ="couponCodeAmount" data-couponCodeAmount = "0">0</span></span></li>
              {{-- <li class="mb-2">Insurance <span class="float-end text-4 fw-500 text-dark">$95</span></li> --}}
            </ul>
            <div class="text-dark bg-light-4 text-3 fw-600 p-3"> {{__('lang.total_amount')}} <span class="float-end text-6">{{$result['markupPrice']['totalPrice']['currency_code']}}&nbsp;<span id ="totalamount" data-initialtotalamount = {{$result['markupPrice']['totalPrice']['value']}}>{{$result['markupPrice']['totalPrice']['value']}}</span></span> </div>
            @if(Auth::guard('web')->check())
            <h3 class="text-4 mb-3 mt-4">Promo Code</h3>
              <div class="input-group mb-3">
                <input class="form-control" placeholder="Promo Code" name="coupon_code" id="couponCode" aria-label="Promo Code" type="text">
                <input name="applyed_coupon_code" id="appliedCouponCode"  type="hidden">
                <button class="btn btn-secondary shadow-none px-3" type="button" id ="applyCoupon">APPLY</button>
              </div>
              <div id="couponResponse"></div>
              <ul class="promo-code">
                @foreach($couponCodes as $promoCode)
                  <li><span class="d-block text-3 fw-600">{{$promoCode->coupon_code}}</span>{{$promoCode->coupon_title}}
                    {{-- <a class="text-1" href="{{url('/Terms-of-use')}}">Terms & Conditions</a> --}}
                  </li>
                @endforeach
              </ul>
            @endif
            <div style="padding: 10px 0px;"> {{__('lang.converted_total_amount')}} {{$result['markupPrice']['standed_price']['currency_code']}}&nbsp;<span id ="standedamount" data-initialstandedamount="{{$result['markupPrice']['standed_price']['value']}}">{{$result['markupPrice']['standed_price']['value']}}</span></div>
            <div class="mb-2">
              <label>{{__('lang.payment_type')}}</label><br>
              <div class="form-check form-check-inline  text-center {{(auth()->check() && auth()->user()->is_agent == 1) ? '' : 'col-3'}}">
                <input  name="type_of_payment" class="form-check-input" checked="" required="" type="radio" value="k_net" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.k_net')}}<span><br><img src="{{asset('frontEnd/images/payment/knet-logo.png')}}"></span></label>
              </div>
              {{-- <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.qatar_cards')}}<span><br><img src="{{asset('frontEnd/images/payment/qatar-cards.png')}}"></span></label>
              </div>              
              <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.benefit_pay')}}<span><br><img src="{{asset('frontEnd/images/payment/benefit-pay.png')}}"></span></label>
              </div> --}}
              
              {{-- <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.google_pay')}}<span><br><img src="{{asset('frontEnd/images/payment/google-pay.png')}}"></span></label>
              </div>
              <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.mada')}}<span><br><img src="{{asset('frontEnd/images/payment/mada.png')}}"></span></label>
              </div>
              <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.meeza')}}<span><br><img src="{{asset('frontEnd/images/payment/meeza.png')}}"></span></label>
              </div>

              <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.naps')}}<span><br><img src="{{asset('frontEnd/images/payment/naps.png')}}"></span></label>
              </div>
              <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.oman_net')}}<span><br><img src="{{asset('frontEnd/images/payment/oman-net.png')}}"></span></label>
              </div>
              
              <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.uae_cards')}}<span><br><img src="{{asset('frontEnd/images/payment/uae-cards.png')}}"></span></label>
              </div>
               --}}
              <div class="form-check form-check-inline text-center ">
                <input name="type_of_payment" class="form-check-input" required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.credit_card')}}<span><br>
                  <img src="{{asset('frontEnd/images/payment/visa.png')}}">
                  <img src="{{asset('frontEnd/images/payment/mastercard.png')}}">
                </span></label>
              </div>
              
              @if (auth()->check() && auth()->user()->is_agent == 1)
                <div class="form-check form-check-inline text-center ">
                  <input name="type_of_payment" class="form-check-input" required="" type="radio" value="wallet" style="margin-top: 26px;">
                  <label class="form-check-label center">{{__('lang.wallet')}}<span><br>
                    <img src="{{asset('frontEnd/images/payment/wallet.png')}}" style="height: 37px;width: 34px;">
                  </span></label>
                </div>
              @endif
              <div class="form-check form-check-inline col-3 text-center ">
                <input  name="type_of_payment" class="form-check-input"  required="" type="radio" value="credit_card" style="margin-top: 26px;">
                <label class="form-check-label center" >{{__('lang.apple_pay')}}<span><br><img src="{{asset('frontEnd/images/payment/apple-pay.png')}}"></span></label>
              </div>
              
            </div>
            <div class="d-grid">
              {{-- validate --}}
              <button class="btn btn-primary" 
              {{-- onclick="validate()"  --}}
              type="submit" id ="paymentButton"><span></span>{{__('lang.proceed_to_payment')}} </button>
            </div>
          </div>
        </aside>
      </form>
        <!-- Side Panel End --> 
      @endif
        
      </div>
    </section>
  </div>
  <!-- Content end --> 
  
@endsection
@section('extraScripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script> 
<script src='{{ asset('frontEnd/vendor/easy-responsive-tabs/easy-responsive-tabs.js') }}'></script>
 
  <script>
        $("#bookingForm").validate({
        rules: {
          // simple rule, converted to {required:true}
          country_id: "required",
          mobile: {
            required: true,
            digits: true
          },
          // compound rule
          email: {
            required: true,
            email: true
          },
          "adultTitle[]": "required",
          "adultFirstName[]" :
          {
            required: true,
            minlength: 3
          },
          "adultLastName[]" :  {
            required: true,
            minlength: 3
          },
          "adultDOB[]" : "required",
          "adultPassportNumber[]" : "required",
          "adultPassportIssueCountry[]" : "required",
          "adultPassportExpireDate[]" : "required",

          "childrenTitle[]": "required",
          "childrenFirstName[]" :
          {
            required: true,
            minlength: 3
          },
          "childrenLastName[]" :  {
            required: true,
            minlength: 3
          },
          "childrenDOB[]" : "required",
          "childrenPassportNumber[]" : "required",
          "childrenPassportIssueCountry[]" : "required",
          "childrenPassportExpireDate[]" : "required",

          "infantsTitle[]": "required",
          "infantsFirstName[]" :
          {
            required: true,
            minlength: 3
          },
          "infantsLastName[]" :  {
            required: true,
            minlength: 3
          },
          "infantsDOB[]" : "required",
          "infantsPassportNumber[]" : "required",
          "infantsPassportIssueCountry[]" : "required",
          "infantsPassportExpireDate[]" : "required"

        },
        messages:{
          email:{
            required:"Please enter E-Mail address",
            email: "Plaese enter Valid Email Id"
          },
          mobile:{
            required:"Please enter Mobile number",
            digits: "Plaese enter Valid mobile number"
          },
          country_id:"Please select Country Name",
          "adultTitle[]" : "Please select Title",
          "adultFirstName[]" :
          {
            required: "Please enter first name",
            minlength: "First name should be greater than three letters"
          },
          "adultLastName[]" : 
          {
            required: "Please enter last name",
            minlength: "Last name should be greater than three letters"
          },
          "adultDOB[]" : "Please select date of birth",
          "adultPassportNumber[]" : "Please enter passport number",
          "adultPassportIssueCountry[]" : "Please select passport issue country",
          "adultPassportExpireDate[]" : "Please select passport expire date",

          "childrenTitle[]" : "Please select Title",
          "childrenFirstName[]" :
          {
            required: "Please enter first name",
            minlength: "First name should be greater than three letters"
          },
          "childrenLastName[]" : 
          {
            required: "Please enter last name",
            minlength: "Last name should be greater than three letters"
          },
          "childrenDOB[]" : "Please select date of birth",
          "childrenPassportNumber[]" : "Please enter passport number",
          "childrenPassportIssueCountry[]" : "Please select passport issue country",
          "childrenPassportExpireDate[]" : "Please select passport expire date",


          "infantsTitle[]" : "Please select Title",
          "infantsFirstName[]" :
          {
            required: "Please enter first name",
            minlength: "First name should be greater than three letters"
          },
          "infantsLastName[]" : 
          {
            required: "Please enter last name",
            minlength: "Last name should be greater than three letters"
          },
          "infantsDOB[]" : "Please select date of birth",
          "infantsPassportNumber[]" : "Please enter passport number",
          "infantsPassportIssueCountry[]" : "Please select passport issue country",
          "infantsPassportExpireDate[]" : "Please select passport expire date",
        },
        submitHandler: function(form) { // <- pass 'form' argument in
        $("#paymentButton").prop('disabled',true);
        $("#paymentButton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
            form.submit(); // <- use 'form' argument here.
        }
      });
   
    function validate()
    {

      var noOfADT = {{$UserRequest['noofAdults']}};
      var noOfCNN = {{$UserRequest['noofChildren']}};
      var noOfINF = {{$UserRequest['noofInfants']}};
      var errorBool = false;

      $email = $('#email').val();
  
      if($email == "")
      {
        $('#emailerror').text("please enter email id");
        errorBool = true;
      }
      else if(!isEmail($email))
      {
        $('#emailerror').text("please enter email valid email id");
        errorBool = true;
      }
      else{
        $('#emailerror').text("");
      }

      

      $country = $('#country').val();
      if($country == "")
      {
        $('#countryerror').text("please select country");
        errorBool = true;
      }
     
      else{
        $('#countryerror').text("");
      }

      $mobile = $('#mobileNumber').val();
      if($mobile == "")
      {
        $('#Phoneerror').text("please enter mobile number");
        errorBool = true;
      }
      // else if($mobile.length < 10)
      // {
      //   $('#Phoneerror').text("please enter  valid Phone number");
      //   errorBool = true;
      // }
      else{
        $('#Phoneerror').text("");
      }
      for (let index = 1; index <= noOfADT; index++) {
        var adultTitle = $('#adultTitle-'+index).val();
        if(adultTitle == "")
        {
          $('#adultTitle-'+index+'-error').text("please select Title");
          errorBool = true;
        }
        else{
          $('#adultTitle-'+index+'-error').text("");
        }

        var adultFirstName = $('#adultFirstName-'+index).val();
        if(adultFirstName == "")
        {
          $('#adultFirstName-'+index+'-error').text("please enter first name");
        }
        else{
          $('#adultFirstName-'+index+'-error').text("");
        }
        var adultLastName = $('#adultLastName-'+index).val();
        if(adultLastName == "")
        {
          $('#adultLastName-'+index+'-error').text("please enter Last Name");
          errorBool = true;
        }
        else if(adultLastName.length < 2)
        {
          $('#adultLastName-'+index+'-error').text("please enter Last Name Charactor more than 2");
          errorBool = true;
        }
        else{
          $('#adultLastName-'+index+'-error').text("");
        }

        var adultDOB = $('#adultDOB-'+index).val();
        if(adultDOB == "")
        {
          $('#adultDOB-'+index+'-error').text("please select Adult DOB");
          errorBool = true;
        }
        else{
          $('#adultDOB-'+index+'-error').text("");
        }


        var adultPassportNumber = $('#adultPassportNumber-'+index).val();
        if(adultPassportNumber == "")
        {
          $('#adultPassportNumber-'+index+'-error').text("please enter Passport number");
          errorBool = true;
        }
        
        else{
          $('#adultPassportNumber-'+index+'-error').text("");
        }

        var adultPassportIssueCountry = $('#adultPassportIssueCountry-'+index).val();
        if(adultPassportIssueCountry == "")
        {
          $('#adultPassportIssueCountry-'+index+'-error').text("please select passport issued country");
          errorBool = true;
        }
        else{
          $('#adultPassportIssueCountry-'+index+'-error').text("");
        }

        var adultPassportExpireDate = $('#adultPassportExpireDate-'+index).val();
        if(adultPassportExpireDate == "")
        {
          $('#adultPassportExpireDate-'+index+'-error').text("please select passport expire date");
          errorBool = true;
        }
        else{
          $('#adultPassportExpireDate-'+index+'-error').text("");
        }



      }

      for (let index = 1; index <= noOfCNN; index++) {
        var childrenTitle = $('#childrenTitle-'+index).val();
        if(childrenTitle == "")
        {
          $('#childrenTitle-'+index+'-error').text("please select Title");
          errorBool = true;
        }
        else{
          $('#childrenTitle-'+index+'-error').text("");
        }
        var childrenFirstName = $('#childrenFirstName-'+index).val();
        if(childrenFirstName == "")
        {
          $('#childrenFirstName-'+index+'-error').text("please {{__('lang.enter_first_name')}}");
          errorBool = true;
        }
        else{
          $('#childrenFirstName-'+index+'-error').text("");
        }
        var childrenLastName = $('#childrenLastName-'+index).val();
        if(childrenLastName == "")
        {
          $('#childrenLastName-'+index+'-error').text("please enter Last Name");
          errorBool = true;
        }
        else if(childrenLastName.length < 2)
        {
          $('#childrenLastName-'+index+'-error').text("please enter Last Name Charactor more than 2");
          errorBool = true;
        }
        else{
          $('#childrenLastName-'+index+'-error').text("");
        }

        var childrenDOB = $('#childrenDOB-'+index).val();
        if(childrenDOB == "")
        {
          $('#childrenDOB-'+index+'-error').text("please select Child DOB");
          errorBool = true;
        }
        else{
          $('#childrenDOB-'+index+'-error').text("");
        }

        var childrenPassportNumber = $('#childrenPassportNumber-'+index).val();
        if(childrenPassportNumber == "")
        {
          $('#childrenPassportNumber-'+index+'-error').text("please enter Passport number");
          errorBool = true;
        }
        
        else{
          $('#childrenPassportNumber-'+index+'-error').text("");
        }

        var childrenPassportIssueCountry = $('#childrenPassportIssueCountry-'+index).val();
        if(childrenPassportIssueCountry == "")
        {
          $('#childrenPassportIssueCountry-'+index+'-error').text("please select passport issued country");
          errorBool = true;
        }
        else{
          $('#childrenPassportIssueCountry-'+index+'-error').text("");
        }

        var childrenPassportExpireDate = $('#childrenPassportExpireDate-'+index).val();
        if(childrenPassportExpireDate == "")
        {
          $('#childrenPassportExpireDate-'+index+'-error').text("please select passport expire date");
          errorBool = true;
        }
        else{
          $('#childrenPassportExpireDate-'+index+'-error').text("");
        }

      }

      for (let index = 1; index <= noOfINF; index++) {
        var infantsTitle = $('#infantsTitle-'+index).val();
        if(infantsTitle == "")
        {
          $('#infantsTitle-'+index+'-error').text("please select Title");
          errorBool = true;
        }
        else{
          $('#infantsTitle-'+index+'-error').text("");
        }
        var infantsFirstName = $('#infantsFirstName-'+index).val();
        if(infantsFirstName == "")
        {
          $('#infantsFirstName-'+index+'-error').text("please {{__('lang.enter_first_name')}}");
          errorBool = true;
        }
        else{
          $('#infantsFirstName-'+index+'-error').text("");
        }
        var infantsLastName = $('#infantsLastName-'+index).val();
        if(infantsLastName == "")
        {
          $('#infantsLastName-'+index+'-error').text("please enter Last Name");
          errorBool = true;
        }
        else if(infantsLastName.length < 2)
        {
          $('#infantsLastName-'+index+'-error').text("please enter Last Name Charactor more than 2");
          errorBool = true;
        }
        else{
          $('#infantsLastName-'+index+'-error').text("");
        }

        var infantsDOB = $('#infantsDOB-'+index).val();
        if(infantsDOB == "")
        {
          $('#infantsDOB-'+index+'-error').text("please select Infant DOB");
          errorBool = true;
        }
        else{
          $('#infantsDOB-'+index+'-error').text("");
        }

        var infantsPassportNumber = $('#infantsPassportNumber-'+index).val();
        if(infantsPassportNumber == "")
        {
          $('#infantsPassportNumber-'+index+'-error').text("please enter Passport number");
          errorBool = true;
        }
        
        else{
          $('#infantsPassportNumber-'+index+'-error').text("");
        }

        var infantsPassportIssueCountry = $('#infantsPassportIssueCountry-'+index).val();
        if(infantsPassportIssueCountry == "")
        {
          $('#infantsPassportIssueCountry-'+index+'-error').text("please select passport issued country");
          errorBool = true;
        }
        else{
          $('#infantsPassportIssueCountry-'+index+'-error').text("");
        }

        var infantsPassportExpireDate = $('#infantsPassportExpireDate-'+index).val();
        if(infantsPassportExpireDate == "")
        {
          $('#infantsPassportExpireDate-'+index+'-error').text("please select passport expire date");
          errorBool = true;
        }
        else{
          $('#infantsPassportExpireDate-'+index+'-error').text("");
        }
      }

      if(errorBool == false)
      {
        $("#paymentButton").prop('disabled',true)
        document.booking.submit(); 

      }


    }

    // var form = document.querySelector('booking');
    // form.addEventListener('change', function() {
    //     alert('Hi!');
    // });

//     $('#bookingForm').change(function() {

//       alert('Hi!');

// });
    function valid(){
      $("#paymentButton").prop('disabled',true)
        document.booking.submit(); 

    }

    // $('#infantsDOB-1').daterangepicker({
    //       singleDatePicker: true,
    //       autoApply: true,
    //       maxDate: moment(),
    //       minDate: moment().subtract(2, 'years'),
    //       autoUpdateInput: false,
    //   }, function(chosen_date) {
    //       $('#infantsDOB-1').val(chosen_date.format('YYYY-MM-DD'));
    //   });
    //   $('#infantsDOB-2').daterangepicker({
    //       singleDatePicker: true,
    //       autoApply: true,
    //       minDate: moment(),
    //       autoUpdateInput: false,
    //   }, function(chosen_date) {
    //       $('#infantsDOB-2').val(chosen_date.format('YYYY-MM-DD'));
    //   });
    //   $('#infantsDOB-3').daterangepicker({
    //       singleDatePicker: true,
    //       autoApply: true,
    //       minDate: moment(),
    //       autoUpdateInput: false,
    //   }, function(chosen_date) {
    //       $('#infantsDOB-3').val(chosen_date.format('YYYY-MM-DD'));
    //   });
    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    // $(document).ready(function(){
    //   $("#bookingForm").on("submit", function(){
    //     $("#paymentButton").prop('disabled',true);
    //     $("#paymentButton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
    //   });//submit
    // });//document ready
    // $('booking').submit(function(){
    //     $(this).find('#paymentButton').prop('disabled', true);
    //     $(this).find('#paymentButton').find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
    // });

    
 
  </script>
  <script>
    var fareRule = "{{route('farerules')}}";
    var uuid  = "{{$uuid ?? ''}}";
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
  $( ".extrabaggage" ).on( "click", function() {
    var noOfADT = {{$UserRequest['noofAdults']}};
    var noOfCNN = {{$UserRequest['noofChildren']}};
    var type = '{{$UserRequest['flight-trip']}}';
    var addoncharages = 0;
    var totalamount = parseFloat($("#totalamount").data('initialtotalamount'));
    var standedamount =parseFloat($("#standedamount").data('initialstandedamount'));
    
    for (let m = 0; m < noOfADT; m++) {
      totalamount += parseFloat($('.adultdepatureextrabaggage'+m+':checked').data('convertedpricingvalue'));
      addoncharages += parseFloat($('.adultdepatureextrabaggage'+m+':checked').data('convertedpricingvalue'));
      standedamount += parseFloat($('.adultdepatureextrabaggage'+m+':checked').data('standedpricingvalue'));
    }
    console.log(totalamount);
    if(type == 'roundtrip')
    {
      for (let n = 0; n < noOfADT; n++) {

        totalamount += parseFloat($('.adultreturnextrabaggage'+n+':checked').data('convertedpricingvalue'));
        addoncharages += parseFloat($('.adultreturnextrabaggage'+n+':checked').data('convertedpricingvalue'));
        standedamount += parseFloat($('.adultreturnextrabaggage'+n+':checked').data('standedpricingvalue'));
      }
    }
    console.log(totalamount);
    

    for (let o = 0; o < noOfCNN; o++) {
      // console.log('childrendepatureextrabaggage'+o);
      // console.log($('.childrendepatureextrabaggage'+o+':checked').data());
      totalamount += parseFloat($('.childrendepatureextrabaggage'+o+':checked').data('convertedpricingvalue'));
      addoncharages += parseFloat($('.childrendepatureextrabaggage'+o+':checked').data('convertedpricingvalue'));
      standedamount += parseFloat($('.childrendepatureextrabaggage'+o+':checked').data('standedpricingvalue'));
    }
    console.log(totalamount);

    if(type == 'roundtrip')
    {
      for (let p = 0; p < noOfCNN; p++) {
        // console.log('childrenreturnextrabaggage'+p);
        // console.log($('.childrenreturnextrabaggage'+p+':checked').data());
        totalamount += parseFloat($('.childrenreturnextrabaggage'+p+':checked').data('convertedpricingvalue'));
        addoncharages += parseFloat($('.childrenreturnextrabaggage'+p+':checked').data('convertedpricingvalue'));
        standedamount += parseFloat($('.childrenreturnextrabaggage'+p+':checked').data('standedpricingvalue'));
      }
    }
    // console.log(totalamount);

   
    

  //   console.log( $(this) );
  //   console.log( $(this).data() );
  // console.log( $(this).data('convertedpricingvalue') );
  // console.log( $(this).data('standedpricingvalue') );

  //   var convertedpricingvalue = $(this).data('convertedpricingvalue');
  //   var standedpricingvalue = $(this).data('standedpricingvalue');
    $("#totalamount").text(totalamount.toFixed(3));
    $("#standedamount").text(standedamount.toFixed(3));
    $("#addoncharages").text(addoncharages.toFixed(3));



  // alert("ss");
});
  var adult = parseInt({{$UserRequest['noofAdults'] ?? 0}});
  var child = parseInt({{$UserRequest['noofChildren'] ?? 0}});
  var maxBaggeage = parseInt(adult+child);
  $("#reurnmaxbaggage").text(maxBaggeage);
  $("#depaturemaxbaggage").text(maxBaggeage);
  function baggageaddon(type,bound,totalprice,standedprice,baggageid)
  {

    var addoncharages = parseFloat($("#addoncharages").data('addoncharages'));
    var totalamount = parseFloat($("#totalamount").data('initialtotalamount'));
    var standedamount =parseFloat($("#standedamount").data('initialstandedamount'));

    var totaldepatureaddon = 0;
    var totalreturnaddon = 0;
    $('.depatureaddon').each(function() {
        totaldepatureaddon = totaldepatureaddon+parseInt($(this).val());
    });
    $('.returnaddon').each(function() {
        totalreturnaddon = totalreturnaddon+parseInt($(this).val());
    });
    value = $("#"+baggageid).val() ;

    if(type == 'add')
    {
      if((totaldepatureaddon < maxBaggeage && bound =="depature") || (totalreturnaddon < maxBaggeage && bound =="return"))
      {
        $("#"+baggageid).attr('value', parseInt(value)+1);
        $("#totalamount").text(parseFloat(parseFloat(totalamount.toFixed(3))+parseFloat(totalprice.toFixed(3))).toFixed(3));
        $("#standedamount").text(parseFloat(parseFloat(standedamount.toFixed(3))+parseFloat(standedprice.toFixed(3))).toFixed(3));
        $("#addoncharages").text(parseFloat(parseFloat(addoncharages.toFixed(3))+parseFloat(totalprice.toFixed(3))).toFixed(3));
        $('#totalamount').data('initialtotalamount', parseFloat(parseFloat(totalamount.toFixed(3))+parseFloat(totalprice.toFixed(3))).toFixed(3));
        $('#standedamount').data('initialstandedamount', parseFloat(parseFloat(standedamount.toFixed(3))+parseFloat(standedprice.toFixed(3))).toFixed(3));
        $('#addoncharages').data('addoncharages', parseFloat(parseFloat(addoncharages.toFixed(3))+parseFloat(totalprice.toFixed(3))).toFixed(3));

        if(bound =="depature"){$("#depaturetotalbaggage").text(parseInt(totaldepatureaddon)+1)}
        if(bound =="return"){$("#returntotalbaggage").text(parseInt(totalreturnaddon)+1)}

      }
      // if(totalreturnaddon < maxBaggeage && bound =="return")
      // {
      //   $("#"+baggageid).attr('value', parseInt(value)+1);
      //   $("#totalamount").text(parseFloat(parseFloat(totalamount.toFixed(3))+parseFloat(totalprice.toFixed(3))).toFixed(3));
      //   $("#standedamount").text(parseFloat(parseFloat(standedamount.toFixed(3))+parseFloat(standedprice.toFixed(3))).toFixed(3));
      //   $("#addoncharages").text(parseFloat(parseFloat(addoncharages.toFixed(3))+parseFloat(totalprice.toFixed(3))).toFixed(3));
      //   $('#totalamount').data('initialtotalamount', parseFloat(parseFloat(totalamount.toFixed(3))+parseFloat(totalprice.toFixed(3))).toFixed(3));
      //   $('#standedamount').data('initialstandedamount', parseFloat(parseFloat(standedamount.toFixed(3))+parseFloat(standedprice.toFixed(3))).toFixed(3));
      //   $('#addoncharages').data('addoncharages', parseFloat(parseFloat(addoncharages.toFixed(3))+parseFloat(totalprice.toFixed(3))).toFixed(3));
      // }
    }else if(type=='remove'){
      if((totaldepatureaddon > 0 && bound =="depature") || (totalreturnaddon > 0 && bound =="return"))
      {
        $("#"+baggageid).attr('value', parseInt(value)-1);
        $("#totalamount").text(parseFloat(parseFloat(totalamount.toFixed(3))-parseFloat(totalprice.toFixed(3))).toFixed(3));
        $("#standedamount").text(parseFloat(parseFloat(standedamount.toFixed(3))-parseFloat(standedprice.toFixed(3))).toFixed(3));
        $("#addoncharages").text(parseFloat(parseFloat(addoncharages.toFixed(3))-parseFloat(totalprice.toFixed(3))).toFixed(3));
        $('#totalamount').data('initialtotalamount', parseFloat(parseFloat(totalamount.toFixed(3))-parseFloat(totalprice.toFixed(3))).toFixed(3));
        $('#standedamount').data('initialstandedamount', parseFloat(parseFloat(standedamount.toFixed(3))-parseFloat(standedprice.toFixed(3))).toFixed(3));
        $('#addoncharages').data('addoncharages', parseFloat(parseFloat(addoncharages.toFixed(3))-parseFloat(totalprice.toFixed(3))).toFixed(3));
        if(bound =="depature"){$("#depaturetotalbaggage").text(parseInt(totaldepatureaddon)-1)}
        if(bound =="return"){$("#returntotalbaggage").text(parseInt(totalreturnaddon)-1)}
      }
    }
    
  }

  let url = '{{ route("web-validateCoupon") }}';

  $(document).ready(function(){
            $("#applyCoupon").click(function(){
              var couponCode ;

              couponCode = $("#couponCode").val();
              console.log(couponCode);
              if(couponCode != '')
              {
                //validating coupon code
                console.log({
                    'totalAmount' : parseFloat($("#totalamount").data('initialtotalamount')),
                    'coupon' : couponCode,
                  })
                $.ajax({
                  type: 'get',
                  url: url,
                  data: {
                    'totalAmount' : parseFloat($("#totalamount").data('initialtotalamount')),
                    'standedamount' : parseFloat($("#standedamount").data('initialstandedamount')),
                    'coupon' : couponCode,
                    'type' : 'flight'
                  },
                  beforeSend: function () { 
                    //need to show loader
                      },
                  success: function (response) {
                    $("#appliedCouponCode").val(couponCode);
                    $html = `<div class="alert alert-success">
                                  <strong>Success!</strong> `+response.success+`.
                                </div>`;
                        $("#couponResponse").html($html);
                        //$('#couponCodeAmount').data('couponcodeamount', response.CouponAmount);
                        $("#couponCodeAmount").text(response.CouponAmount);
                        //$('#totalamount').data('initialtotalamount', response.AfterApplyingCouponTotalAmount);
                        $("#totalamount").text(response.AfterApplyingCouponTotalAmount);
                        //$('#standedamount').data('initialstandedamount', response.AfterApplyingCouponStandedAmount);
                        $("#standedamount").text(response.AfterApplyingCouponStandedAmount);
                        
                  },
                  complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                        // $("#serachpnrfromsubmit").prop('disabled',false);
                        // $("#serachpnrfromsubmit").find('span').html( '' );
                        
                      },
                  error:function(response){
                  response = response.responseJSON ; 
                    $("#appliedCouponCode").val(couponCode);
                    $html = `<div class="alert alert-danger">
                                <strong>Error!</strong> `+response.error+`
                              </div>`;
                    $("#couponResponse").html($html);
                    $("#couponCodeAmount").text(response.CouponAmount);
                    $("#totalamount").text(response.AfterApplyingCouponTotalAmount);
                    $("#standedamount").text(response.AfterApplyingCouponStandedAmount);
                  }
                });


              }
              else{
                $("#appliedCouponCode").val(couponCode);
                //enter coupon code
                $html = `<div class="alert alert-danger">
                          <strong>Error!</strong> Enter Coupon.
                        </div>`;
                $("#couponResponse").html($html);

              }

              
            });
        });
  </script>
@endsection