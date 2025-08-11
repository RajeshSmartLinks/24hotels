@extends('front_end.layouts.master')
@section('content')
<style>
    /* .owl-carousel .owl-stage {
      display: flex;
    } */

   .owl-carousel .owl-item img {
 /* min-height: 350px;
 max-height: 350px; */
 height:550px;
   object-fit:cover;
   object-position:50% 50%;
    }
    </style>
  
  <!-- Page Header
   ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1 class="d-flex flex-wrap align-items-center mb-1">{{$result['hotelDeatils']['HotelName']}} <span class="ms-2 text-2" data-bs-toggle="tooltip" title="{{$result['hotelDeatils']['HotelRating']}} Star Hotel"> 
            @for($rat=1; $rat<=$result['hotelDeatils']['HotelRating'] ;$rat++)
            <i class="fas fa-star text-warning"></i> 
            @endfor
            
            </span> </h1>
          <p class="opacity-8 mb-0"><i class="fas fa-map-marker-alt"></i> {{$result['hotelDeatils']['Address']}}</p>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}}</a></li>
            <li><a href="{{url('/')}}">{{__('lang.hotels')}}</a></li>
            <li class="active">{{__('lang.hotel_detail')}}</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Page Header end --> 
  
  <!-- Content
  ============================================= -->
  <div id="content">
    <div class="container">
      <div class="row"> 
        @if(!empty($result['hotelDeatils']))
        <!-- Middle Panel
        ============================================= -->
        <div class="col-lg-8">
          <div class="bg-white shadow-md rounded p-3 p-sm-4 confirm-details"> 
            
            <!-- Hotel Photo Slideshow
        	============================================= -->
            <div class="owl-carousel owl-theme single-slider mb-3" data-animateout="fadeOut" data-animatein="fadeIn" data-autoplay="true" data-loop="true" data-autoheight="true" data-nav="true" data-items="1">
              @if(isset($result['hotelDeatils']['Images']))
                @foreach($result['hotelDeatils']['Images'] as $k=>$image)
                  @if($k<15)
                  {{-- <div class="item"><a href="#"><img class="img-fluid" src="{{$image}}" height ="450px" alt="Hotel photo" onError="this.onerror=null;this.src='{{ asset('frontEnd/images/no-hotel-image.png') }}';"/></a></div> --}}
                  <div class="item"><a href="#"><img class="img-fluid" src="{{$image}}" alt="Hotel photo" onError="this.onerror=null;this.src='{{ asset('frontEnd/images/no-hotel-image.png') }}';"/></a></div>
                  @endif
                @endforeach
              @endif
            </div>
            <!-- Hotel Photo Slideshow end --> 
            
            <!-- Secondary Navigation ============================================= -->
            <nav id="navbar-sticky" class="bg-white pb-2 mb-2 smooth-scroll">
              <ul class="nav nav-tabs">
                <li class="nav-item"> <a class="nav-link active text-nowrap" href="#decription">{{__('lang.description')}}</a> </li>
                <li class="nav-item"> <a class="nav-link" href="#timings">{{__('lang.hotel_timings')}}</a> </li>
                <li class="nav-item"> <a class="nav-link" href="#choose-room">{{__('lang.choose_room')}}</a> </li>
                <li class="nav-item"> <a class="nav-link" href="#amenities">{{__('lang.amenities')}}</a> </li>

                
                {{-- <li class="nav-item"> <a class="nav-link" href="#reviews">Reviews</a> </li>
                <li class="nav-item"> <a class="nav-link" href="#hotel-policy">Hotel Policy</a> </li> --}}
              </ul>
            </nav>
            <!-- Secondary Navigation end --> 
            
            <!-- Known For ============================================= -->
            <div id="description">
                {!! $result['hotelDeatils']['Description'] !!}
            </div>
            
            <hr>
            {{-- <div class="featured-box style-1">
              <div class="featured-box-icon text-muted"> <i class="far fa-comments"></i></div>
              <h3 class="fw-400 text-4 mb-1">Staff Speaks</h3>
              <p>English, Hindi, Spanish, Arabic, Russian</p>
            </div> --}}
            <!-- Known For end -->
            
            
            <h3 class="text-5 mb-4 mt-4" id = "timings">{{__('lang.hotel_timings')}}</h3>
            <div class="row mb-3">
              {{-- <div class="col-6 col-xl-4"><span class="text-muted text-3 me-2"><i class="fas fa-paw"></i></span>Pets are not allowed</div> --}}
              <div class="col-6 col-xl-6"><span class="text-muted text-3 me-2"><i class="fas fa-sign-in-alt"></i></span><span class= "text-uppercase fw-700">{{__('lang.checkin')}} : </span>{{$result['hotelDeatils']['CheckInTime'] ?? '---'}}</div>
              <div class="col-6 col-xl-6"><span class="text-muted text-3 me-2"><i class="fas fa-sign-out-alt"></i></span><span class= "text-uppercase fw-700">{{__('lang.checkout')}} : </span> {{$result['hotelDeatils']['CheckOutTime'] ?? '---'}}</div>
            </div>
            <hr class="mb-4">
            
            <!-- Choose Room ============================================= -->
            <h2 id="choose-room" class="text-6 mb-4 mt-2">{{__('lang.choose_room')}}</h2>
            @if(!empty($result['availablerooms']))
            @foreach($result['availablerooms'] as $r=>$roomDetails)
                <div class="row g-4">
                    {{-- <div class="col-12 col-md-5"> <img class="img-fluid rounded align-top" src="images/brands/hotels/hotel-room-1.jpg" title="Standard Room" alt="Standard Room"> </div> --}}
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-10 col-8 mt-2">
                                @foreach($roomDetails['Name'] as $d=>$details)
                                <h5 class="text-3">{{$details}}</h5>
                                @endforeach
                            </div>
                            <div class="col-md-2 col-4">
                                <p class="reviews mb-2 mt-2"> <span class="fw-600">{{__('lang.refundable')}}</span>
                                    @if($roomDetails['IsRefundable'] == 1)
                                    <span class="reviews-score px-2 py-1 rounded fw-600 text-light">{{__('lang.yes')}}</span> 
                                    @else
                                    <span class="px-2 py-1 rounded fw-600 text-light" style="background: red">{{__('lang.no')}}</span> 
                                    @endif
                                 </p>
                            </div>
                        </div>
                      
                    
                    {{-- <ul class="list-inline mb-2">
                        <li class="list-inline-item"><span class="me-1 text-black-50"><i class="fas fa-bed"></i></span> King Size Bed</li>
                        <li class="list-inline-item"><span class="me-1 text-black-50"><i class="fas fa-arrows-alt"></i></span> 3.66x3.66 sq.mtr</li>
                    </ul> --}}
                    <div class="row text-1 mb-3">
                      @if(isset($roomDetails['Inclusion']) && !empty($roomDetails['Inclusion']))
                        @foreach(explode("," , $roomDetails['Inclusion']) as $inclusive)
                        <div class="col-6 col-xl-4"><span class="text-success me-1"><i class="fas fa-check"></i></span>{{$inclusive}}</div>
                        @endforeach
                      @endif   
                      
                        
                        {{-- <div class="col-6 col-xl-4"><span class="text-success me-1"><i class="fas fa-check"></i></span>Television</div>
                        <div class="col-6 col-xl-4"><span class="text-success me-1"><i class="fas fa-check"></i></span>Hair Dryer</div>
                        <div class="col-6 col-xl-4"><span class="text-success me-1"><i class="fas fa-check"></i></span>Shower</div>
                        <div class="col-6 col-xl-4"><span class="text-success me-1"><i class="fas fa-check"></i></span>Tea Maker</div> --}}
                    </div>
                    @if(!empty($roomDetails['supplment_charges']))
                    <p>{{__('lang.supplement_charges')}} - {{$roomDetails['supplment_charges']}} {{__('lang.need_to_pay_at_hotel')}}</p>
                    @endif
                    
                    {{-- <div class="d-flex align-items-center">
                        <div class="text-dark text-7 lh-1 fw-500 me-2 me-lg-3">USD {{$roomDetails['TotalFare']}}</div>
                        <span class="text-black-50">{{$result['searchRequest']->no_of_rooms}} Room/ {{$result['searchRequest']->no_of_nights}} Night</span> </div>
                    <div class="d-flex align-items-center mt-3"> 
  
                      <a href="{{route('PreBooking',['hotelCode'=>encrypt($result['hotelDeatils']['HotelCode']) , 'searchId' =>encrypt($result['searchRequest']->id) , 'bookingCode' => encrypt($roomDetails['BookingCode'])])}}" class="btn btn-sm btn-outline-primary shadow-none ms-auto gButton"><span class="gButtonloader"></span>Book</a> 
                    </div> --}}
                    <div class="row">
                      <div class="d-flex align-items-center col-md-10 col-8 ">
                        <div class="text-dark text-4 lh-1 fw-500 me-2 me-lg-3"> {{$roomDetails['markups']['totalPrice']['currency_code'] }} 
                          &nbsp; {{$roomDetails['markups']['totalPrice']['value'] }}</div>
                          <span class="text-black-50 me-2 me-lg-3">{{$result['searchRequest']->no_of_rooms}} {{__('lang.room')}}/ {{$result['searchRequest']->no_of_nights}} {{__('lang.night')}}</span>
                          <a href="#" data-bs-toggle="modal" data-bs-target="#cancellation-policy{{$r}}">{{__('lang.cancellation_policy')}}</a> 
                        </div>
                        <div class="d-flex align-items-center col-md-2 col-4"> 
                          
                          <a href="{{route('PreBooking',['hotelCode'=>encrypt($result['hotelDeatils']['HotelCode']) , 'searchId' =>encrypt($result['searchRequest']->id) , 'bookingCode' => encrypt($roomDetails['BookingCode'])])}}" class="btn btn-sm btn-outline-primary shadow-none gButton"><span class="gButtonloader"></span>Book</a>
                        </div>
                      </div>
                    
                    </div>
                    <div class="row text-1 mt-2">
                      @foreach($roomDetails['roomPromotion'] as $prom)
                      <div class="col-6 col-xl-4"><span class="text-success me-1"></span>{!! html_entity_decode($prom) !!}</div>
                      @endforeach
                    </div>
                </div>
                <hr class="my-4">
                <div id="cancellation-policy{{$r}}" class="modal fade" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">{{__('lang.cancellation_policy')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <ul>
                          @foreach($roomDetails['CancelPolicies'] as $policy)
                          <li>{{$policy}}</li>
                          @endforeach
                          <li>{{__('lang.cancellation_policy_1')}}<strong><a href="tel:+965 6704 1515" >+965 6704 1515 </a></strong> (or) <strong><a href="mailto: booking@24flights.com">booking@24Flights.com</a></strong></li>
                          <li>{{__('lang.cancellation_policy_2')}}</li>
                          {{-- <li>goCash used in the booking will be non refundable</li>
                          <li>Any Add-on charges are Non-Refundable.</li>
                          <li>You can not change the Check-in or Check-out date.</li> --}}
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach
           @else
           <h5>{{__('lang.no_available_rooms_for_given_criteria')}}</h5>
           @endif
            
            <!-- Cancellation Policy Modal -->
        
            <!-- Cancellation Policy Modal end --> 
            <!-- Choose Room end -->
            
            {{-- <hr class="my-4"> --}}
            
            <!-- Amenities ============================================= -->
            <h2 id="amenities" class="text-6 mb-3 mt-2">{{__('lang.amenities')}}</h2>
            {{-- <p class="hotels-amenities-detail text-5"> <span class="border rounded" data-bs-toggle="tooltip" title="Internet/Wi-Fi"><i class="fas fa-wifi"></i></span> <span class="border rounded" data-bs-toggle="tooltip" title="Restaurant"><i class="fas fa-utensils"></i></span> <span class="border rounded" data-bs-toggle="tooltip" title="Bar"><i class="fas fa-glass-martini"></i></span> <span class="border rounded" data-bs-toggle="tooltip" title="Swimming Pool"><i class="fas fa-swimmer"></i></span> <span class="border rounded" data-bs-toggle="tooltip" title="Business Facilities"><i class="fas fa-chalkboard-teacher"></i></span> <span class="border rounded" data-bs-toggle="tooltip" title="Spa"><i class="fas fa-spa"></i></span> <span class="border rounded" data-bs-toggle="tooltip" title="Gym"><i class="fas fa-dumbbell"></i></span> </p> --}}
            <div class="row">
              <div class="col-12 col-sm-6">
                <ul class="simple-ul">
                  @foreach($result['hotelDeatils']['HotelFacilities'] as $lak => $lav)
                  @if($lak % 2 == 0)
                  <li>{{$lav}}</li>
                  @endif
                  @endforeach
                </ul>
              </div>
              <div class="col-12 col-sm-6">
                  <ul class="simple-ul">
                    @foreach($result['hotelDeatils']['HotelFacilities'] as $rak => $rav)
                    @if($rak % 2 != 0)
                    <li>{{$rav}}</li>
                    @endif
                    @endforeach
                  </ul>
                </div>
            </div>
            <!-- Amenities end -->
            
            <hr class="my-4">
            
            <!-- Reviews ============================================= -->
            {{-- <h2 id="reviews" class="text-6 mb-3 mt-2">Reviews</h2>
            <div class="row">
              <div class="col-sm-4 col-md-3">
                <div id="review-summary" class="bg-primary text-white rounded px-2 py-4 mb-4 mb-sm-0 text-center">
                  <div class="text-10 fw-600 lh-1 d-block">4.5</div>
                  <div class="fw-500 text-3 my-1">Excellent</div>
                  <small class="d-block">Based on 245 reviews</small> </div>
              </div>
              <div class="col-sm-8 col-md-9">
                <div class="row">
                  <div class="col-8 col-sm-9 col-lg-10">
                    <div class="progress mb-3">
                      <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-4 col-sm-3 col-lg-2"><small class="fw-600 align-text-top lh-1">Excellent</small></div>
                </div>
                <!-- /row -->
                <div class="row">
                  <div class="col-lg-10 col-9">
                    <div class="progress mb-3">
                      <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-lg-2 col-3"><small class="fw-600 align-text-top lh-1">Good</small></div>
                </div>
                <!-- /row -->
                <div class="row">
                  <div class="col-lg-10 col-9">
                    <div class="progress mb-3">
                      <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-lg-2 col-3"><small class="fw-600 align-text-top lh-1">Fair</small></div>
                </div>
                <!-- /row -->
                <div class="row">
                  <div class="col-lg-10 col-9">
                    <div class="progress mb-3">
                      <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-lg-2 col-3"><small class="fw-600 align-text-top lh-1">Poor</small></div>
                </div>
                <!-- /row -->
                <div class="row">
                  <div class="col-lg-10 col-9">
                    <div class="progress mb-3">
                      <div class="progress-bar" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-lg-2 col-3"><small class="fw-600 align-text-top lh-1">Bad</small></div>
                </div>
                <!-- /row --> 
              </div>
            </div>
            <hr class="mb-4">
            <div class="row">
              <div class="col-12 col-sm-3 text-center">
                <div class="review-tumb bg-dark-5 text-light rounded-circle d-inline-block mb-2 text-center text-8">R</div>
                <p class="mb-0 lh-1">Ruby Clinton</p>
                <small><em>Jan 25, 2019</em></small> </div>
              <div class="col-12 col-sm-9 text-center text-sm-start"> <span class="text-2"> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-muted opacity-4"></i> </span>
                <p class="fw-600 mb-1">Excellent hotel with great location</p>
                <p>We stayed in this hotel for one night and were happy that we booked this hotel. Location is excellent and hotel has a lovely ambience . Rooms are very spacious with a decent decor. Overall experience was good.</p>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-3 text-center">
                <div class="review-tumb text-light rounded-circle d-inline-block mb-2 text-center text-8"> <img class="rounded-circle" alt="" src="images/brands/hotels/tumb.jpg"> </div>
                <p class="mb-0 lh-1">James Maxwell</p>
                <small><em>Dec 19, 2018</em></small> </div>
              <div class="col-12 col-sm-9 text-center text-sm-start"> <span class="text-2"> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> </span>
                <p class="fw-600 mb-1">Safe for Family & Good service</p>
                <p>It was a nice experience the hotel was neat and clean. Good location nice staffs. food items specially Curry needs to be more tastier. this is my third stay in this hotel. great experience, Safe for Family.</p>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-3 text-center">
                <div class="review-tumb bg-dark-5 text-light rounded-circle d-inline-block mb-2 text-center text-8">N</div>
                <p class="mb-0 lh-1">Neil Patel</p>
                <small><em>Nov 03, 2018</em></small> </div>
              <div class="col-12 col-sm-9 text-center text-sm-start"> <span class="text-2"> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-warning"></i> <i class="fas fa-star text-muted opacity-4"></i> <i class="fas fa-star text-muted opacity-4"></i> </span>
                <p class="fw-600 mb-1">Staff is very helpful but rooms are bit small</p>
                <p>Staff is very helpful and courteous but rooms are bit small, smelly and you have to share your stay with cockroaches.</p>
                <hr>
              </div>
            </div>
            <div class="text-center"> <a href="#" class="btn btn-sm btn-outline-dark shadow-none">view more reviews</a> </div>
            <h5 class="mb-3 mt-2">Write a review</h5>
            <form>
              <div class="mb-3">
                <label class="form-label" for="yourName">Your Name</label>
                <input type="email" class="form-control" id="yourName" required aria-describedby="yourName" placeholder="Enter your name">
              </div>
              <div class="mb-3">
                <label class="form-label" for="yourReview">Your Review</label>
                <textarea class="form-control" rows="5" id="yourReview" required placeholder="Enter Your Review"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Rating</label>
                <div>
                  <div class="form-check form-check-inline">
                    <input id="bad" name="reviewRating" class="form-check-input" checked="" required type="radio">
                    <label class="form-check-label" for="bad">Bad</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input id="poor" name="reviewRating" class="form-check-input" checked="" required type="radio">
                    <label class="form-check-label" for="poor">Poor</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input id="fair" name="reviewRating" class="form-check-input" checked="" required type="radio">
                    <label class="form-check-label" for="fair">Fair</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input id="good" name="reviewRating" class="form-check-input" checked="" required type="radio">
                    <label class="form-check-label" for="good">Good</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input id="excellent" name="reviewRating" class="form-check-input" checked="" required type="radio">
                    <label class="form-check-label" for="excellent">Excellent</label>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form> --}}
            <!-- Reviews end -->
            {{--   <hr class="my-4"> --}}
            
            <!-- Hotel Policy ============================================= -->
            {{-- <h2 id="hotel-policy" class="text-6 mb-3 mt-2">Hotel Policy</h2>
            <p>The standard check-in time is 12:00 PM and the standard check-out time is 11:00 AM. Early check-in or late check-out is strictly subjected to availability and may be chargeable by the hotel. Any early check-in or late check-out request must be directed and reconfirmed with hotel directly, Accommodation, 24 hours House Keeping, Hot and Cold water available, Internet, Telephone.</p>
            <p>Hotel Policy: Most hotels do not allow unmarried/unrelated couples to check-in. This is at the full discretion of the hotel management. No refund would be applicable in case the hotel denies check-in under such circumstances., Most hotels do not allow same city/local ID Proofs for check-in. Kindly check with your hotel about the same before checking in. This is at full discretion of the hotel management. No refund would be applicable in case the hotel denies check-in under such circumstances.</p> --}}
            <!-- Hotel Policy end --> 
            
          </div>
        </div>
        <!-- Middle Panel End--> 
        
        <!-- Side Panel
        ============================================= -->
        <aside class="col-lg-4 mt-4 mt-lg-0">
          <div class="bg-white shadow-md rounded p-3 ">
            <p class="reviews text-center">  <span class="fw-600">{{__('lang.hotel_rating')}}</span> &nbsp; <span class="reviews-score rounded fw-600 text-white px-2 py-1">{{$result['hotelDeatils']['HotelRating']}}</span>  </p>
            <hr class="mx-n3">
            <form id="bookingHotels" method="post" action ="{{route('updatedHotelsearch')}}">
              @csrf
              <div class="row g-3">
                <?php $searchRequest = json_decode($result['searchRequest']->request_json ,true);?>
                <div class="col-lg-6">
                  <div class="position-relative">
                    <input id="hotelsCheckIn" type="text" class="form-control" name = "hotelsCheckIn" required placeholder="{{__('lang.check_in')}}" value="{{$result['searchRequest']->check_in}}">
                    <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> </div>
                </div>

                <input type="hidden" name = "hotelsCityName"  value="{{$searchRequest['hotelsCityName']}}">
                <input type="hidden"  name = "hotelsCityCode" value = "{{$searchRequest['hotelsCityCode']}}">
                <input type="hidden"  name = "hotelsCode" value = "{{$result['hotelCode']}}">
                <input type="hidden"  name = "nationality" value = "{{$searchRequest['nationality']}}">
                

                <div class="col-lg-6">
                  <div class="position-relative">
                    <input id="hotelsCheckOut" type="text" class="form-control" name = "hotelsCheckOut" required placeholder="{{__('lang.check_out')}}" value="{{$result['searchRequest']->check_out}}">
                    <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> </div>
                </div>
                <div class="col-12">
                  <div class="travellers-class hotelsTravellersClass-1 ">
                    <input type="text" id="hotelsTravellersClass"  class="travellers-class-input form-control" name="hotels-travellers-class" placeholder="Rooms / People" required onKeyPress="return false;" value= "{{$result['searchRequest']->hotel_traveller_info}}">
 
                    <span class="icon-inside"><i class="fas fa-caret-down"></i></span>
                    <div class="travellers-dropdown">
                      <div class="row align-items-center">
                        <div class="col-sm-7">
                          <p class="mb-sm-0">{{__('lang.rooms')}}</p>
                        </div>
                        <div class="col-sm-5">
                          <div class="qty input-group">
                            <div class="input-group-prepend">
                              <button type="button" class="btn bg-light-4 qtyChanger" id = "remove-room">-</button>
                            </div>
                            <input type="text" data-ride="spinner" id="hotels-rooms" class="qty-spinner form-control" value="{{$searchRequest['noOfRooms']}}" name = "noOfRooms" readonly  >
                            <div class="input-group-append">
                              <button type="button" class="btn bg-light-4 qtyChanger" id = "add-room">+</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="mt-2 mb-4">
                      <div id="rooms-container"> 
                        @for ( $room = 1 ; $room <= $searchRequest['noOfRooms'] ; $room++)
      
                        <div>
                          {{__('lang.room')}} {{$room}}
                          <div class="row align-items-center">
                            
                            <div class="col-sm-7">
                              <p class="mb-sm-0">{{__('lang.adults')}} <small class="text-muted">(18+ yrs)</small></p>
                            </div>
                            <div class="col-sm-5">
                              <div class="qty input-group">
                                <div class="input-group-prepend">
                                  <button type="button" class="btn bg-light-4" id = "adult-travellers-minus-{{$room}}">-</button>
                                </div>
                                <input type="text" data-ride="spinner" id="adult-travellers-{{$room}}" class="qty-spinner form-control" value="{{$searchRequest['room'.$room]["adult"]}}" readonly name = "room{{$room}}[adult]">
                                <div class="input-group-append"> 
                                  <button type="button" class="btn bg-light-4" id = "adult-travellers-plus-{{$room}}">+</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="row align-items-center mt-2">
                            <div class="col-sm-7">
                              <p class="mb-sm-0">{{__('lang.children')}} <small class="text-muted">(1-18 yrs)</small></p>
                            </div>
                            <div class="col-sm-5">
                              <div class="qty input-group">
                                <div class="input-group-prepend">
                                  <button type="button" class="btn bg-light-4" id = "children-travellers-minus-{{$room}}">-</button>
                                </div>
                                <input type="text" data-ride="spinner" id="children-travellers-{{$room}}" class="qty-spinner form-control" value="{{$searchRequest['room'.$room]["children"]}}" name = "room{{$room}}[children]" readonly>
                                <div class="input-group-append">
                                  <button type="button" class="btn bg-light-4" id = "children-travellers-plus-{{$room}}">+</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row mt-3" id="children-age-room-{{$room}}">
                            @if(isset($searchRequest['room'.$room]["childrenAge"]) && count($searchRequest['room'.$room]["childrenAge"]) > 0) 
                              @foreach ($searchRequest['room'.$room]["childrenAge"] as $ind => $childInfoIndiviualroom)
                                <div class="form-group col-6 ">{{__('lang.child')}} {{$ind + 1}} <small class="text-muted">{{__('lang.age')}}</small>
                                  <select id="train-class" name="room{{$room}}[childrenAge][]" class="form-select mt-1 mb-2" style="min-height: 50%" required>
                                    <option value="">Select </option>
                                    <option value="1" {{$childInfoIndiviualroom == "1" ? 'selected' : ''}}>1</option>
                                    <option value="2" {{$childInfoIndiviualroom == "2" ? 'selected' : ''}}>2</option>
                                    <option value="3" {{$childInfoIndiviualroom == "3" ? 'selected' : ''}}>3</option>
                                    <option value="4" {{$childInfoIndiviualroom == "4" ? 'selected' : ''}}>4</option>
                                    <option value="5" {{$childInfoIndiviualroom == "5" ? 'selected' : ''}}>5</option>
                                    <option value="6" {{$childInfoIndiviualroom == "6" ? 'selected' : ''}}>6</option>
                                    <option value="7" {{$childInfoIndiviualroom == "7" ? 'selected' : ''}}>7</option>
                                    <option value="8" {{$childInfoIndiviualroom == "8" ? 'selected' : ''}}>8</option>
                                    <option value="9" {{$childInfoIndiviualroom == "9" ? 'selected' : ''}}>9</option>
                                    <option value="10" {{$childInfoIndiviualroom == "10" ? 'selected' : ''}}>10</option>
                                    <option value="11" {{$childInfoIndiviualroom == "11" ? 'selected' : ''}}>11</option>
                                    <option value="12" {{$childInfoIndiviualroom == "12" ? 'selected' : ''}}>12</option>
                                    <option value="13" {{$childInfoIndiviualroom == "12" ? 'selected' : ''}}>13</option>
                                    <option value="14" {{$childInfoIndiviualroom == "13" ? 'selected' : ''}}>14</option>
                                    <option value="15" {{$childInfoIndiviualroom == "14" ? 'selected' : ''}}>15</option>
                                    <option value="16" {{$childInfoIndiviualroom == "15" ? 'selected' : ''}}>16</option>
                                    <option value="17" {{$childInfoIndiviualroom == "16" ? 'selected' : ''}}>17</option>
                                    <option value="18" {{$childInfoIndiviualroom == "17" ? 'selected' : ''}}>18</option>
                                  </select>
                                </div>
                              @endforeach
                           
                                
                            @endisset
                            
                            
                          </div>
                          <hr class="my-2">
                        </div>
                            
                        @endfor
                       
                      </div>
      
                      <div class="d-grid">
                        <button class="btn btn-primary submit-done mt-3 hotelguestsdone" type="button">{{__('lang.done')}}</button>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- <div class="col-12">
                  <select class="form-select" id="operator" required="">
                    <option value="">Room Type</option>
                    <option>Standard Room</option>
                    <option>Deluxe Room</option>
                    <option>Premium Room</option>
                  </select>
                </div> --}}
              </div>
              <div class="d-grid my-4">
                <button class="btn btn-primary" type="submit"  id= "searchbutton"> <span></span>update</button>
              </div>
              <div class="d-flex align-items-center my-4">
                <div class="text-dark text-4 lh-1 fw-500 me-2 me-lg-3">{{$result['availablerooms'][0]['markups']['totalPrice']['currency_code'] }}&nbsp;{{$result['availablerooms'][0]['markups']['totalPrice']['value'] }}</div>
                  {{-- USD {{$result['availablerooms'][0]['TotalFare']}} --}}
                {{-- <div class="d-block text-4 text-black-50 me-2 me-lg-3"><del class="d-block">$250</del></div>
                <div class="text-success text-3">16% Off!</div> --}}
                <div class="text-black-50 ms-auto">{{$result['searchRequest']->no_of_rooms}} {{__('lang.room')}}/ {{$result['searchRequest']->no_of_nights}} {{__('lang.night')}}</div>
              </div>
             
            </form>
            <p class="text-center mt-3 mb-1"><span class="text-uppercase fw-700">{{__('lang.checkin')}}</span> :{{$result['hotelDeatils']['CheckInTime'] ?? '---'}} / <span class="text-uppercase fw-700">{{__('lang.checkout')}}</span> : {{$result['hotelDeatils']['CheckOutTime'] ?? '---'}}</p>
            {{-- <p class="text-danger text-center mb-0"><i class="far fa-clock"></i> Last Booked - 18 hours ago</p> --}}
          </div>
        </aside>
        <!-- Side Panel End --> 
        @else
        <div class="col-12">
            <h3>{{__('lang.no_hotel_found')}}</h3>
            <div>
        @endif
      </div>
    </div>
  </div>
  <!-- Content end --> 
  
@endsection
@section('extraScripts')
<script>
   var start = moment("{{$result['searchRequest']->check_in}}");
    $('#hotelsCheckIn').daterangepicker({
        singleDatePicker: true,
        autoApply: true,
        minDate: moment(),
        autoUpdateInput: false,
        locale: {
          format: 'YYYY-MM-DD'
        },
        startDate:start
      
    },function(chosen_date) {
        $('#hotelsCheckIn').val(chosen_date.format('YYYY-MM-DD'));
        var hotelsCheckInData = $('#hotelsCheckIn').val();
        var  returndateSartFrom = moment(hotelsCheckInData);
        $('#hotelsCheckOut').val('');
        $('#hotelsCheckOut').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            minDate: returndateSartFrom,
            autoUpdateInput: false,
            locale: {
              format: 'YYYY-MM-DD'
            },
        }, function(chosen_date) {
            $('#hotelsCheckOut').val(chosen_date.format('YYYY-MM-DD'));
            $("#hotelsTravellersClass").trigger( "click" );

        });

        $("#hotelsCheckOut" ).trigger( "click" );
    
    });
    var hotelsCheckInData1 = $('#hotelsCheckIn').val();
    var  returndateSartFrom1 = moment(hotelsCheckInData1);

    $('#hotelsCheckOut').daterangepicker({
        singleDatePicker: true,
        autoApply: true,

        minDate: returndateSartFrom1,
        autoUpdateInput: false,
        locale: {
              format: 'YYYY-MM-DD'
            },
    }, function(chosen_date) {
      console.log(chosen_date);
        $('#hotelsCheckOut').val(chosen_date.format('YYYY-MM-DD'));
    });
    $(document).ready(function(){
    $("#bookingHotels").on("submit", function(){
      $("#searchbutton").prop('disabled',true);
      $("#searchbutton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
    });//submit
  });//document ready
  </script>
<script src='{{ asset('frontEnd/js/hotel.js') }}?ver={{ config('app.version') }}'></script>
@endsection