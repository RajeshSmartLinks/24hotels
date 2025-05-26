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
          <h1> {{__('lang.hotels_confirm_details')}}</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}}</a></li>
            <li><a href="{{url('/')}}">{{__('lang.hotels')}}</a></li>
            <li><a href="#">{{__('lang.hotel_detail')}}</a></li>
            <li class="active">{{__('lang.confirm_details')}}</li>
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
            <h2 class="text-6 mb-3 mb-sm-4">{{__('lang.confirm_hotels_details')}}</h2>
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
                          @foreach($result['roomDetails']['Name'] as $d=>$details)
                          <h5 class="text-3">{{$details}}</h5>
                          @endforeach
                      </div>
                      <div class="col-md-2 col-4">
                          <p class="reviews mb-2 mt-2"> <span class="fw-600">{{__('lang.refundable')}}</span>
                              @if($result['roomDetails']['IsRefundable'] == 1)
                              <span class="reviews-score px-2 py-1 rounded fw-600 text-light">{{__('lang.yes')}}</span> 
                              @else
                              <span class="px-2 py-1 rounded fw-600 text-light" style="background: red">{{__('lang.no')}}</span> 
                              @endif
                           </p>
                      </div>
                  </div>
                  <div class="row text-1 mb-3">
                      @foreach(explode("," , $result['roomDetails']['Inclusion']) as $inclusive)
                      <div class="col-6 col-xl-4"><span class="text-success me-1"><i class="fas fa-check"></i></span>{{$inclusive}}</div>
                      @endforeach
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="text-dark text-7 lh-1 fw-500 me-2 me-lg-3">
                      {{$result['roomDetails']['markups']['totalPrice']['currency_code']}} {{$result['roomDetails']['markups']['totalPrice']['value']}}
                    </div>
                    <span class="text-black-50">{{$result['searchRequest']->no_of_rooms}} {{__('lang.room')}}/ {{$result['searchRequest']->no_of_nights}} {{__('lang.night')}}</span> </div>
                  @if(!empty($result['roomDetails']['supplment_charges']))
                  <p class = 'mt-3'>{{__('lang.supplement_charges')}} - {{$result['roomDetails']['supplment_charges']}} {{__('lang.need_to_pay_at_hotel')}}</p>
                  @endif
                  <div class="row text-1 mt-2">
                    @foreach($result['roomDetails']['roomPromotion'] as $prom)
                    <div class="col-6 col-xl-4"><span class="text-success me-1"></span>{!! html_entity_decode($prom) !!}</div>
                    @endforeach
                  </div>
              </div>
            </div>
            @endif
            <hr>
            <h3 class="text-5 mb-4 mt-4">{{__('lang.hotels_rules')}}</h3>
            <div class="row mb-3">
              <div class="col-6 col-xl-4"><span class="text-muted text-3 me-2"><i class="fas fa-sign-in-alt"></i></span>{{__('lang.checkin_time')}} {{$result['hotelDetails']['check_in']}}</div>
              <div class="col-6 col-xl-4"><span class="text-muted text-3 me-2"><i class="fas fa-sign-out-alt"></i></span>{{__('lang.checkout_time')}}  {{$result['hotelDetails']['check_out']}}</div>
            </div>
            @if(!empty($result['roomDetails']))
            <hr>
            <h2 class="text-6 mb-3">{{__('lang.traveller_details')}}
              @if(!Auth::guard('web')->check())
              - <span class="text-3"><a data-bs-toggle="modal" data-bs-target="#login-signup" href="{{url('/login')}}" title="{{__('lang.login_sign_up')}}">{{__('lang.login')}}</a> {{__('lang.to_book_faster')}}</span>
              @endif

            </h2>
            <form name ="booking" method="POST" action="{{route('hotelSavePassenger')}}" id="hotelForm">
              @csrf
              <input type = "hidden" value = "{{encrypt($result['bookingCode'])}}" name ="bookingCode">
              <input type = "hidden" value = "{{encrypt($result['hotelCode'])}}" name ="hotelCode">
              <input type = "hidden" value = "{{encrypt($result['searchId'])}}" name ="searchId">
              <p class="text-info">{{__('lang.message_info')}} </p>
              <p class="fw-600">{{__('lang.contact_details')}}</p>
            <div class="row g-3 mb-3">
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
                  @foreach($result['countries'] as $country)
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
        
            @for( $i= 1 ;$i <= ($result['searchRequest']['no_of_rooms']) ; $i++)

            {{-- @foreach($result['searchRequest']['rooms_request'] as $i => $roomreq) --}}
            <p class="fw-600">Room {{$i}}</p>
              @if(isset($result['searchRequest']['rooms_request'][$i-1]['Adults']) && (int)$result['searchRequest']['rooms_request'][$i-1]['Adults'] > 0)
                @for($j = 1 ; $j <= (int)$result['searchRequest']['rooms_request'][$i-1]['Adults'] ; $j++)
                <p class="fw-600">Adult {{$j}}</p>
                 
                  <div class="row g-3">
                    <div class="col-sm-2">
                     
                      
                      <select class="form-select roomAdultTitle" required="" name= 'room[{{$i-1}}][adult][{{$j-1}}][title]' style="min-height: 46% !important">
                        
                        <option value="">{{__('lang.title')}}</option>
                        {{ old('users.0.name') }}
                        <option value = "Mr">Mr</option>
                        <option value = "Ms">Ms</option>
                        <option value = "Mrs">Mrs</option>
                      </select>
                     
                    </div>
                    <div class="col-sm-5">
                      <input class="form-control roomAdultFirstName" data-bv-field="number" required placeholder="{{__('lang.enter_first_name')}}" type="text"  name = 'room[{{$i-1}}][adult][{{$j-1}}][firstName]' value="">
                     
    
                    </div>
                    <div class="col-sm-5">
                      <input class="form-control roomAdultLastName" data-bv-field="number" required placeholder="{{__('lang.enter_last_name')}}" type="text" name = 'room[{{$i-1}}][adult][{{$j-1}}][lastName]' value="">
                     
                
                    </div>
                  </div>
                  {{-- @endif --}}
                @endfor
              @endif  
          
              @if(isset($result['searchRequest']['rooms_request'][$i-1]['Children']) && (int)$result['searchRequest']['rooms_request'][$i-1]['Children'] > 0)
              {{-- {{dd($result['searchRequest']['rooms_request'][$i-1]['Children'])}} --}}
                @for($k = 1; $k <= (int)$result['searchRequest']['rooms_request'][$i-1]['Children'] ;$k++)
                  <p class="fw-600">Child {{$k}}</p>
                  <div class="row g-3">
                    <div class="col-sm-2">
                      <select class="form-select roomChildTitle"  required="" name= 'room[{{$i-1}}][child][{{$k-1}}][title]' style="min-height: 46% !important">
                        
                        <option value="">{{__('lang.title')}}</option>
                        {{-- <option value="Master">Master</option>
                        <option value="Miss">Miss</option> --}}
                        <option value = "Mr">Mr</option>
                        <option value = "Ms">Ms</option>
                        <option value = "Mrs">Mrs</option>
                        
                      </select>
                    
                      
                      {{-- <div id ="childTitle-{{$i}}-error" style="color: red"></div> --}}
                    </div>
                    <div class="col-sm-5">
                      <input class="form-control roomChildFirstName"  required placeholder="{{__('lang.enter_first_name')}}" type="text" name = 'room[{{$i-1}}][child][{{$k-1}}][firstName]' value="">
                      
                      {{-- <div id ="childFirstName-{{$i}}-error" style="color: red"></div> --}}
                    </div>
                    <div class="col-sm-5">
                      <input class="form-control roomChildLastName" data-bv-field="number"  required placeholder="{{__('lang.enter_last_name')}}" type="text" name = 'room[{{$i-1}}][child][{{$k-1}}][lastName]' value="">
                    
                      {{-- <div id ="adultLastName-{{$i}}-error" style="color: red"></div> --}}
                    </div>
                  </div>

                @endfor
              @endif
           

            @endfor
            {{-- @endforeach --}}
            <div class="alert alert-info mt-4 mb-0">
              <div class="row g-0">
                <div class="col-auto"><span class="text-5 me-2"><i class="fas fa-info-circle"></i></span></div>
                <div class="col">
                  <h5 class="alert-heading">{{__('lang.check_in_instructions')}}</h5>
                  @foreach($result['RateConditions'] as $condition)
                    <p> {!! html_entity_decode($condition) !!} <p>
                  @endforeach
                </div>
              </div>
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
                        <button class="btn btn-primary" > {{__('lang.go_back')}}</button>
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
                    <li class="mb-2 fw-500">{{__('lang.base_price')}} <span class="float-end text-4 fw-500 text-dark">
                      {{$result['roomDetails']['markups']['basefare']['currency_code']}} {{$result['roomDetails']['markups']['basefare']['value']}}
                   
                    </span><br>
                        <span class="text-muted text-1 fw-400">{{__('lang.for')}} {{$result['searchRequest']['no_of_nights']}} {{__('lang.night')}}, {{$result['searchRequest']['no_of_rooms']}} {{__('lang.room')}}, {{$result['searchRequest']['no_of_guests']}} {{__('lang.guests')}}</span></li>
                    {{-- <li class="mb-2 fw-500">Extra Guests Cost <span class="float-end text-4 fw-500 text-dark">$80</span><br>
                        <span class="text-muted text-1 fw-400">For 1 Night, 1 Guest</span></li> --}}
                    <li class="mb-2 fw-500">{{__('lang.taxes_fees')}}<span class="float-end text-4 fw-500 text-dark">
                      {{$result['roomDetails']['markups']['tax']['currency_code']}} {{$result['roomDetails']['markups']['tax']['value']}}
                    </span></li>
                    <li class="mb-2 fw-500"> {{__('lang.coupon_amount')}}<span class="float-end text-4 fw-500 text-dark">{{$result['roomDetails']['markups']['coupon']['currency_code']}} &nbsp; <span id ="couponCodeAmount" data-couponCodeAmount = "0">0</span></span></li>
                    </ul>
                    <div class="text-dark bg-light-4 text-3 fw-600 p-3 mb-3"> {{__('lang.total_amount')}} <span class="float-end text-6">  {{$result['roomDetails']['markups']['totalPrice']['currency_code']}} <span id ="totalamount" data-initialtotalamount = {{$result['roomDetails']['markups']['totalPrice']['value']}}>{{$result['roomDetails']['markups']['totalPrice']['value']}}</span></span> </div>
                    <span id ="standedamount" data-initialstandedamount = {{$result['roomDetails']['markups']['standed_price']['value']}}></span>

                    @if(Auth::guard('web')->check())
                    <h3 class="text-4 mb-3 mt-4">Promo Code</h3>
                      <div class="input-group mb-3">
                        <input class="form-control" placeholder="Promo Code" name="coupon_code" id="couponCode" aria-label="Promo Code" type="text">
                        <input name="applyed_coupon_code" id="appliedCouponCode"  type="hidden">
                        <button class="btn btn-secondary shadow-none px-3" type="button" id ="applyCoupon">APPLY</button>
                      </div>
                      <div id="couponResponse"></div>
                      <ul class="promo-code">
                        @foreach($result['couponCodes'] as $promoCode)
                          <li><span class="d-block text-3 fw-600">{{$promoCode->coupon_code}}</span>{{$promoCode->coupon_title}}
                            {{-- <a class="text-1" href="{{url('/Terms-of-use')}}">Terms & Conditions</a> --}}
                          </li>
                        @endforeach
                      </ul>
                    @endif
                    <div class="mb-2">
                      <label>{{__('lang.payment_type')}}</label><br>
                      <div class="form-check form-check-inline col-3 text-center ">
                        <input  name="type_of_payment" class="form-check-input" checked="" required="" type="radio" value="k_net" style="margin-top: 26px;">
                        <label class="form-check-label center" >{{__('lang.k_net')}}<span><br><img src="{{asset('frontEnd/images/payment/knet-logo.png')}}"></span></label>
                      </div>
                      <div class="form-check form-check-inline text-center col-4">
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
                      <button class="btn btn-primary" type="submit" id ="paymentButton"><span></span>{{__('lang.proceed_to_payment')}} </button>
                    </div>
                    <p class="text-muted d-flex align-items-center justify-content-center mt-3 mb-1">
                      <span class="text-2 me-2">
                        @if($result['roomDetails']['IsRefundable'])
                        {{__('lang.refundable')}}
                        @else
                          <i class="fas fa-ban"></i>{{__('lang.non_refundable')}}
                        @endif
                      </span> 
                      {{-- cancellation Policy --}}
                      {{-- <a href="" class="text-3 ms-2" data-bs-toggle="tooltip" title="Lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. Mutat tacimates id sit."></a> --}}
                      <a href="#" class="text-3 ms-2" data-bs-toggle="modal" data-bs-target="#cancellation-policy">{{__('lang.cancellation_policy')}}<i class="far fa-question-circle"></i></a> 
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
    var x = $("hotelForm").serializeArray();
$.each(x, function(i, field) {
console.log(field.name + " : " + field.value + " ");
});

     $("#hotelForm").validate({
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
          country_id:"Please select Country",
          

          
        },
        submitHandler: function(form) { // <- pass 'form' argument in
        $("#paymentButton").prop('disabled',true);
        $("#paymentButton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
            form.submit(); // <- use 'form' argument here.
        }
      });
      addvalidation();



      // user.filter('input[name$="[name]"]').each(function() {
      //     $(this).rules("add", {
      //         required: true,
      //         messages: {
      //             required: "Name is Mandatory"
      //         }
      //     });
      // });

      // var user = $('input[name^="room"]');

      // user.filter('input[name$="[email]"]').each(function() {
      //     $(this).rules("add", {
      //         email: true,
      //         required: true,
      //         messages: {
      //             email: 'Email must be valid email address',
      //             required : 'Email is Mandatory',
      //         }
      //     });
      // });


    //   for (var i = 0; i < 3; i++) {
    //     $('#hotelForm').validate({
    //         rules: {
    //             'users['+i+'][name]': {
    //                 required: true,
    //                 minlength: 2
    //             },
    //             'users['+i+'][email]': {
    //                 required: true,
    //                 email: true
    //             }
    //         },
    //         messages: {
    //             'users['+i+'][name]': {
    //                 required: 'Name is required',
    //                 minlength: 'Name must be at least 2 characters'
    //             },
    //             'users['+i+'][email]': {
    //                 required: 'Email is required',
    //                 email: 'Email must be a valid email address'
    //             }
    //         }
    //     });
    // }
    jQuery.validator.addMethod("alphanumeric", function(value, element) {
      return this.optional(element) || /^[A-Za-z]+$/i.test(value);
    }, "Letters, numbers, and underscores only please");
    function addvalidation(){
      $(".roomAdultTitle").each((i,e)=>{
        $(e).rules('add',{required:true ,messages: {required: "Please select adult title"}});
      });
      $(".roomAdultFirstName").each((i,e)=>{
        $(e).rules('add',{required:true, minlength: 3,  alphanumeric: true ,messages: {required: "Please enter First name",
              minlength: "First name should be greater than three letter" ,  alphanumeric: "First name should not contain special characters"}});
      });
      $(".roomAdultLastName").each((i,e)=>{
        $(e).rules('add',{required:true, minlength: 3,  alphanumeric: true ,messages: {required: "Please enter Last name",
              minlength: "Last name should be greater than three letter" ,  alphanumeric: "Last name should not contain special characters"}});
      });
      $(".roomChildTitle ").each((i,e)=>{
        $(e).rules('add',{required:true ,messages: {required: "Please select child title"}});
      });
      $(".roomChildFirstName").each((i,e)=>{
        $(e).rules('add',{required:true, minlength: 3,  alphanumeric: true ,messages: {required: "Please enter First name",
              minlength: "First name should be greater than three letter" ,  alphanumeric: "First name should not contain special characters"}});
      });
      $(".roomChildLastName ").each((i,e)=>{
        $(e).rules('add',{required:true, minlength: 3,  alphanumeric: true ,messages: {required: "Please enter Last name",
              minlength: "Last name should be greater than three letter" ,  alphanumeric: "Last name should not contain special characters"}});
      });
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
                    'type' : 'hotel'
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
                        $("#couponCodeAmount").text(response.CouponAmount);
                        $("#totalamount").text(response.AfterApplyingCouponTotalAmount);
                        
                  },
                  complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                        // $("#serachpnrfromsubmit").prop('disabled',false);
                        // $("#serachpnrfromsubmit").find('span').html( '' );
                        
                      },
                  error:function(response){
                    $("#appliedCouponCode").val(couponCode);
                    $html = `<div class="alert alert-danger">
                                  <strong>Error!</strong> `+response.error+`
                                </div>`;
                        $("#couponResponse").html($html);
                        $("#couponCodeAmount").text(response.CouponAmount);
                        $("#totalamount").text(response.AfterApplyingCouponTotalAmount);
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