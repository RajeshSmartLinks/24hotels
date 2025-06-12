@extends('front_end.layouts.master')
@section('content')
<style>
  .error {
      color: red;
   }
  </style>
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.hotels_preveiw_details')}}</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="index.html">{{__('lang.home')}}</a></li>
            <li><a href="booking-hotels.html">{{__('lang.hotels')}}</a></li>
            <li><a href="booking-hotels-details.html">{{__('lang.hotel_detail')}}</a></li>
            <li class="active">{{__('lang.preview_details')}}</li>
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
        <div class="col-lg-8">
          <div class="bg-white shadow-md rounded p-3 p-sm-4 confirm-details">
            <h2 class="text-6 mb-3 mb-sm-4">{{__('lang.preview_hotels_details')}}</h2>
            <hr class="mx-n3 mx-sm-n4 mb-4">
            <div class="row">
              <div class="col-12 col-md-3 mb-3 mb-md-0"> <img class="img-fluid rounded align-top" src="{{$result['hotelDetails']['image']}}" alt="hotels" onError="this.onerror=null;this.src='{{ asset('frontEnd/images/no-hotel-image.png') }}';"style="height:107px;" title="Standard Room" alt="Standard Room"> </div>
              <div class="col-12 col-md-7">
                <h4 class="text-5">{{$result['hotelDetails']['hotel_name']}}</h4>
                <p class="text-muted mb-1"><i class="fas fa-map-marker-alt"></i> &nbsp;{{$result['hotelDetails']['address']}}</p>
            
              </div>
            
              <div class="col-12 col-md-2 ">
                <div class="reviews" style="text-align: center;"> <span class="fw-600">{{__('lang.rating')}}</span><br><span class="reviews-score px-2 py-1 rounded fw-600 d-inline-block text-light">{{$result['hotelDetails']['hotel_rating'] . ' / 5'}} </span> </div>
               
                <div class="list-inline-item"><span class="me-1 text-black-50"><i class="fas fa-user"></i></span> {{$result['searchRequest']['no_of_guests']}} {{__('lang.guests')}}</div>
                
              </div>
            </div>
            <hr>
            @if(!empty($result['roomDetails']))
            <div class="row g-4">
              <div class="col-12">
                  <div class="row">
                      <div class="col-md-10 col-8 mt-2">
                          {{-- @foreach($result['roomDetails']['Name'] as $d=>$details)
                          <h5 class="text-3">{{$details}}</h5>
                          @endforeach --}}
                          <h5 class="text-3">{{$result['roomDetails']['Name']}}</h5>
                      </div>
                      {{-- <div class="col-md-2 col-4">
                          <p class="reviews mb-2 mt-2"> <span class="fw-600">{{__('lang.refundable')}}</span>
                              @if($result['roomDetails']['IsRefundable'] == 1)
                              <span class="reviews-score px-2 py-1 rounded fw-600 text-light">{{__('lang.yes')}}</span> 
                              @else
                              <span class="px-2 py-1 rounded fw-600 text-light" style="background: red">{{__('lang.no')}}</span> 
                              @endif
                           </p>
                      </div> --}}
                  </div>
                  {{-- <div class="row text-1 mb-3">
                      @foreach(explode("," , $result['roomDetails']['Inclusion']) as $inclusive)
                      <div class="col-6 col-xl-4"><span class="text-success me-1"><i class="fas fa-check"></i></span>{{$inclusive}}</div>
                      @endforeach
                  </div> --}}
                  <div class="d-flex align-items-center">
                    <div class="text-dark text-7 lh-1 fw-500 me-2 me-lg-3">{{$result['roomDetails']['markups']['previewDisplay']['currency_code'].' '.$result['roomDetails']['markups']['previewDisplay']['value']}}</div>
                    <span class="text-black-50">{{$result['searchRequest']->no_of_rooms}} {{__('lang.room')}}/ {{$result['searchRequest']->no_of_nights}} {{__('lang.night')}}</span> </div>
                    {{-- @if(!empty($result['roomDetails']['supplment_charges']))
                    <p class = 'mt-3'>{{__('lang.supplement_charges')}} - {{$result['roomDetails']['supplment_charges']}} {{__('lang.need_to_pay_at_hotel')}}</p>
                    @endif --}}
                    {{-- <div class="row text-1 mt-2">
                      @foreach($result['roomDetails']['roomPromotion'] as $prom)
                      <div class="col-6 col-xl-4"><span class="text-success me-1"></span>{!! html_entity_decode($prom) !!}</div>
                      @endforeach
                    </div> --}}
              </div>
            </div>
            @endif
            <hr>
            <h3 class="text-5 mb-4 mt-4">{{__('lang.hotels_rules')}} </h3>
            <div class="row mb-3">
              <div class="col-6 col-xl-4"><span class="text-muted text-3 me-2"><i class="fas fa-sign-in-alt"></i></span>{{__('lang.checkin_time')}} {{$result['hotelDetails']['check_in']}}</div>
              <div class="col-6 col-xl-4"><span class="text-muted text-3 me-2"><i class="fas fa-sign-out-alt"></i></span>{{__('lang.checkout_time')}}  {{$result['hotelDetails']['check_out']}}</div>
            </div>
            @if(!empty($result['roomDetails']))
            <div class="alert alert-info mt-4"> <span class="badge bg-info">{{__('lang.note')}} </span>{{__('lang.preview_descrption')}}  </div>
            <h2 class="text-6 mb-3 mt-5">{{__('lang.contact_details')}} </h2>
            <ul class="list-unstyled">
                <li class="mb-2 ">{{__('lang.email')}} <span class="float-end text-4 fw-500 text-dark">{{$result['bookingDetails']->email}}</span></li>
                <li class="mb-2">{{__('lang.mobile')}}  <span class="float-end text-4 fw-500 text-dark">{{$result['bookingDetails']->Customercountry->phone_code}}&nbsp;{{$result['bookingDetails']->mobile}}</span></li>
              </ul>
     
            <h2 class="text-6 mb-3 mt-1">{{__('lang.traveller_details')}} </h2>
            <div class="tab-pane fade show active" id="third" role="tabpanel" aria-labelledby="third-tab">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{__('lang.title')}}</th>
                        <th>{{__('lang.first_name')}}</th>
                        <th>{{__('lang.last_name')}}</th>
                        <th>{{__('lang.room')}}</th>
                        
                       
                      
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($result['passengersInfo']) > 0)
                          @foreach($result['passengersInfo'] as $passengerDetails)
                          <tr>
                          <td class="align-middle">{{$passengerDetails->title}}</td>
                          <td class="align-middle">{{$passengerDetails->first_name}}</td>
                          <td class="align-middle">{{$passengerDetails->last_name}}</td>
                          <td class="align-middle">{{$passengerDetails->room_no}}</td>                        
                          </tr>
                          @endforeach
                      @else
                          <tr align="center" class="alert alert-danger">
                              <td colspan="4">{{__('lang.no_records')}}</td>
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
             
            @else
            <div>
                <div class="alert alert-info mt-4 mb-0">
                    <div class="row g-0">
                      <div class="col-auto"><span class="text-5 me-2"><i class="fas fa-info-circle"></i></span></div>
                      <div class="col">
                        <h5 class="alert-heading">
                          {{__('lang.session_expired')}}
                        <a href = "{{url('/')}}">
                        <button class="btn btn-primary" >  {{__('lang.go_back')}}</button>
                        </a>
                        </h4>

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
            @if(!empty($result['roomDetails']))
                <div class="bg-white shadow-md rounded p-3">
                    <h3 class="text-5 mb-3">{{__('lang.invoice_details')}}</h3>
                    <hr class="mx-n3">
                    <ul class="list-unstyled">
                    <li class="mb-2 fw-500">{{__('lang.base_price')}} <span class="float-end text-4 fw-500 text-dark">{{$result['roomDetails']['markups']['basefare']['currency_code'].' '.$result['roomDetails']['markups']['basefare']['value']}}</span><br>
                        <span class="text-muted text-1 fw-400">{{__('lang.for')}} {{$result['searchRequest']['no_of_nights']}} {{__('lang.night')}}, {{$result['searchRequest']['no_of_rooms']}} {{__('lang.rooms')}}, {{$result['searchRequest']['no_of_guests']}} {{__('lang.guests')}}</span></li>
                    {{-- <li class="mb-2 fw-500">Extra Guests Cost <span class="float-end text-4 fw-500 text-dark">$80</span><br>
                        <span class="text-muted text-1 fw-400">For 1 Night, 1 Guest</span></li> --}}
                    <li class="mb-2 fw-500">{{__('lang.taxes_fees')}} <span class="float-end text-4 fw-500 text-dark">{{$result['roomDetails']['markups']['tax']['currency_code'].' '.$result['roomDetails']['markups']['tax']['value']}}</span></li>
                    <li class="mb-2">{{__('lang.coupon_amount')}}   <span class="float-end text-4 fw-500 text-dark">{{$result['roomDetails']['markups']['coupon']['currency_code'].' '.$result['roomDetails']['markups']['coupon']['value']}}</span></li>
                    <li class="mb-2">{{__('lang.service_fee')}} <a href="#" data-bs-toggle="tooltip" title="{{__('lang.service_fee')}}"><i class="fa fa-info-circle" style="font-size: 12px;" ></i></a>  <span class="float-end text-4 fw-500 text-dark">{{$result['roomDetails']['markups']['service_chargers']['currency_code'].' '.$result['roomDetails']['markups']['service_chargers']['value']}}</span></li>
                    </ul>
                    <div class="text-dark bg-light-4 text-3 fw-600 p-3 mb-3"> {{__('lang.total_amount')}} <span class="float-end text-6">{{$result['roomDetails']['markups']['previewDisplay']['currency_code'].' '.$result['roomDetails']['markups']['previewDisplay']['value']}}</span> </div>
           
                    <form name ="booking" method="POST" action="{{route('agentHotelpaymentGateWay')}}" id = "confirmPreviewFrom">
                        @csrf
        
                        <div style="padding: 10px 0px;"> {{__('lang.converted_total_amount')}} {{$result['roomDetails']['markups']['FatoorahPaymentAmount']['currency_code'].' '.$result['roomDetails']['markups']['FatoorahPaymentAmount']['value']}}</div>
                        
                        <input type="hidden" value = "{{encrypt($result['bookingDetails']->id)}}" name="booking_id">
                        <div class="form-check text-3 my-1">
                          <input id="agree" name="agree" class="form-check-input" type="checkbox" required>
                          <label class="form-check-label text-2" for="agree">{{__('lang.i_agree_to_the')}} <a href="{{route('TermsOfUse')}}">{{__('lang.terms_of_use')}}</a> {{__('lang.and')}} <a href="{{route('PrivacyPolicy')}}"> {{__('lang.privacy_policy')}}</a>.</label>
                        </div>
                        <div class="d-grid">
                        {{-- validate --}}
                        <button class="btn btn-primary" onclick="#" type="submit" id ="paymentButton"><span></span>{{__('lang.pay_now')}} </button>
                        </div>
                    </form>
                    <p class="text-muted d-flex align-items-center justify-content-center mt-3 mb-1">
                      {{-- <span class="text-2 me-2">
                        @if($result['roomDetails']['IsRefundable'])
                        {{__('lang.refundable')}}
                        @else
                          <i class="fas fa-ban"></i>{{__('lang.non_refundable')}}
                        @endif
                      </span> --}}
                      <a href="#" class="text-3 ms-2" data-bs-toggle="modal" data-bs-target="#cancellation-policy">{{__('lang.cancellation_policy')}} <i class="far fa-question-circle"></i></a> 
                      <div id="cancellation-policy" class="modal fade" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">{{__('lang.cancellation_policy')}}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <ul>
                                @foreach($result['roomDetails']['CancelPolicies'] as $policy)
                                <li>{{$policy}}</li>
                                @endforeach
                                <li>{{__('lang.cancellation_policy_1')}} <strong><a href="tel:+965 6704 1515" >+965 6704 1515 </a></strong> (or) <strong><a href="mailto: booking@24flights.com">booking@24Flights.com</a></strong></li>
                                <li>{{__('lang.cancellation_policy_2')}}</li>
                                {{-- <li>goCash used in the booking will be non refundable</li>
                                <li>Any Add-on charges are Non-Refundable.</li>
                                <li>You can not change the Check-in or Check-out date.</li> --}}
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </p>
                </div>
            @endif
        </aside>
        <!-- Side Panel End --> 
      </form>
        
      </div>
    </section>
  </div>
  <!-- Content end --> 
  
  @endsection
  @section('extraScripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script> 
  <script>
    $(document).ready(function(){
    $("#confirmPreviewFrom").on("submit", function(){
      $("#paymentButton").prop('disabled',true);
      $("#paymentButton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
    });//submit
  });//document ready

  </script>
  @endsection