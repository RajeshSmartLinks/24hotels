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
          <h1 class="d-flex flex-wrap align-items-center mb-1">{{$result['hotelDeatils']['hotel_name']}} <span class="ms-2 text-2" data-bs-toggle="tooltip" title="{{$result['hotelDeatils']['hotel_rating']}} Star Hotel"> 
            @for($rat=1; $rat<=$result['hotelDeatils']['hotel_rating'] ;$rat++)
            <i class="fas fa-star text-warning"></i> 
            @endfor
            
            </span> </h1>
          <p class="opacity-8 mb-0"><i class="fas fa-map-marker-alt"></i> {{$result['hotelDeatils']['address']}}</p>
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
        <div class="col-lg-12">
          <div class="bg-white shadow-md rounded p-3 p-sm-4 confirm-details"> 
            <div class="row">
              <div class="col-lg-8">
                <!-- Hotel Photo Slideshow
                ============================================= -->
                <div class="owl-carousel owl-theme single-slider mb-3" data-animateout="fadeOut" data-animatein="fadeIn" data-autoplay="true" data-loop="true"    data-autoheight="true" data-nav="true" data-items="1">
                  @if(isset($result['hotelDeatils']['images']))
                  <?php $result['hotelDeatils']['images'] = explode("," , $result['hotelDeatils']['images'])?>
                    @foreach($result['hotelDeatils']['images'] as $k=>$image)
                      @if($k<15)
                      <div class="item"><a href="#">
                        <img class="img-fluid lazy-image" data-src="{{$image}}" alt="Hotel photo" onError="this.onerror=null;this.src='{{ asset('frontEnd/images/no-hotel-image.png') }}';" src="{{ asset('frontEnd/images/no-hotel-image.png') }}"/></a>

                       
                      </div>
                      @endif
                    @endforeach
                  @endif
                </div>
                <!-- Hotel Photo Slideshow end --> 
              </div>
              <div class="col-lg-4 mt-4 mt-lg-0" style="height: 550px;">
                <div class="bg-white shadow-md rounded p-3 ">
                  <p class="reviews text-center">  <span class="fw-600">{{__('lang.hotel_rating')}}</span> &nbsp; <span class="reviews-score rounded fw-600 text-white px-2 py-1">{{$result['hotelDeatils']['hotel_rating']}}</span>
                  <span class="text-uppercase fw-700">{{__('lang.checkin')}}</span> :{{$result['hotelDeatils']['check_in'] ?? '---'}} / <span class="text-uppercase fw-700">{{__('lang.checkout')}}</span> : {{$result['hotelDeatils']['check_out']  ?? '---'}}
                  </p>
                  <hr class="mx-n3">
                  @php
                        $fullDescription = strip_tags($result['hotelDeatils']['description']);
                        $shortDescription = Str::limit($fullDescription, 900);
                    @endphp
                  
                  <div id="shortDesc">
                     <h5>Description</h5>
                      {{ $shortDescription }}...
                      <a href="#" data-bs-toggle="modal" data-bs-target="#description-info">Show more</a> 
                  </div>
                </div>
              </div>
            </div>
            <div id="description-info" class="modal fade" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    {!! $result['hotelDeatils']['description'] !!}
                  </div>
                </div>
              </div>
            </div>
            <hr class="mb-4">
           
            <div class="col-lg-12">
              <?php $searchRequest = json_decode($result['searchRequest']->request_json ,true);?>

              <form id="bookingHotels" method="get" action="{{route('GethotelDetails')}}">
                <input type="hidden" class="form-control" id="hotelCode"  name = "hotelCode" value = "{{app('request')->input('hotelCode')}}">
                <div class="row g-3 mb-4">
                  <div class="col-md-12 col-lg-4">
                    <div class="position-relative">
                      <input type="text" class="form-control" name = "hotelsCityName" id="hotelsCityName" required placeholder="{{__('lang.enter_city')}}" value="{{$searchRequest['hotelsCityName']}}" readonly>
                      <span class="icon-inside"><i class="fas fa-map-marker-alt"></i></span> </div>
                      <input type="hidden" class="form-control" id="hotelsCityCode"  name = "hotelsCityCode" value = "{{$searchRequest['hotelsCityCode']}}">
                  </div>
                  <div class="col-md-6 col-lg-2">
                    <div class="position-relative">
                      <input id="hotelsCheckIn" type="text" class="form-control" name = "hotelsCheckIn" required placeholder="{{__('lang.check_in')}}" value="{{$searchRequest['hotelsCheckIn']}}">
                      <span class="icon-inside"><i class="far fa-calendar-alt"></i></span>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-2">
                    <div class="position-relative">
                      <input id="hotelsCheckOut" type="text" class="form-control" name = "hotelsCheckOut" required placeholder="{{__('lang.check_out')}}" value="{{$searchRequest['hotelsCheckOut']}}">
                      <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> 
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-4">
                    <div class="travellers-class hotelsTravellersClass-1 ">
                      <input type="text" id="hotelsTravellersClass"  class="travellers-class-input form-control" name="hotels-travellers-class" placeholder="Rooms / People" required onKeyPress="return false;" value= "{{$searchRequest['hotels-travellers-class']}}">
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
                                  <input type="text" data-ride="spinner" id="adult-travellers-{{$room}}" class="qty-spinner form-control" value="{{$searchRequest['room'.($room)]["adult"]}}" readonly name = "room{{$room}}[adult]">
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
                                  <input type="text" data-ride="spinner" id="children-travellers-{{$room}}" class="qty-spinner form-control" value="{{$searchRequest['room'.($room)]["children"]}}" name = "room{{$room}}[children]" readonly>
                                  <div class="input-group-append">
                                    <button type="button" class="btn bg-light-4" id = "children-travellers-plus-{{$room}}">+</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row mt-3" id="children-age-room-{{$room}}">
                              @if(isset($searchRequest['room'.($room)]["childrenAge"]) && count($searchRequest['room'.($room)]["childrenAge"]) > 0)
                                @foreach ($searchRequest['room'.($room)]["childrenAge"] as $ind => $childInfoIndiviualroom)
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
                  <div class="col-md-6 col-lg-3">
                    <div class="position-relative">
                      <select id="nationality-id" class="form-select" name = "nationality" required placeholder="{{__('lang.select_nationality')}}">
                        <option value="">{{__('lang.select_nationality')}}</option>
                        @foreach($result['countries'] as $country)
                        <option value="{{$country->code}}" {{$searchRequest['nationality'] == $country->code?"selected":""}}>{{$country->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                   <div class="col-md-6 col-lg-3">
                    <div class="position-relative">
                      <select id="residency-id" class="form-select" name = "residency" required placeholder="{{__('lang.select_residency')}}">
                        <option value="">{{__('lang.select_residency')}}</option>
                        @foreach($result['countries'] as $country)
                        <option value="{{$country->code}}" {{$searchRequest['residency'] == $country->code?"selected":""}}>{{$country->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-2 d-grid">
                    <button class="btn btn-primary" type="submit"  id= "searchbutton"> <span></span>{{__('lang.update')}}</button>
                  </div>
                </div>
              </form>
              
              <!-- Secondary Navigation ============================================= -->
              <nav id="navbar-sticky" class="bg-white pb-2 mb-2 smooth-scroll">
                <ul class="nav nav-tabs">
                  <li class="nav-item"> <a class="nav-link" href="#choose-room">{{__('lang.choose_room')}}</a> </li>
                  <li class="nav-item"> <a class="nav-link" href="#amenities">{{__('lang.amenities')}}</a> </li>
                </ul>
              </nav>
              <!-- Secondary Navigation end --> 
              <!-- Choose Room ============================================= -->
              <h2 id="choose-room" class="text-6 mb-4 mt-2">{{__('lang.choose_room')}}</h2>
              @if(!empty($result['availablerooms']))
              
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Room Type</th>
                      <th>Board Basis</th>
                      <th></th>
                      <th>Per Room/Night</th>
                      <th>Tariff</th>
                      <th>Total Price</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($result['availablerooms'] as $r=>$roomDetails)
                        <tr>
                          <th scope="row">{{$loop->iteration}}</th>
                          <td>{{$roomDetails['name']}}</td>
                          <td>{{$roomDetails['boardbasis']}}</td>
                          <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#cancellation-policy{{$r}}">{{__('lang.cancellation_policy')}}</a>
                            <div id="cancellation-policy{{$r}}" class="modal fade" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">{{__('lang.cancellation_policy')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <ul>
                                      @foreach($roomDetails['CancelPolicies'] as $rc=>$rv)
                                        <span style="font-weight: bold">Room {{$rc+1}} &nbsp; <span>Cancellation Policy</span></span>
                                        @foreach($rv as $policy)
                                        <li>
                                          @if(!empty($policy['noShow']))
                                              <strong>No-show Policy:</strong>
                                          @endif

                                          @if(!empty($policy['fromDate']))
                                              From: {{ $policy['fromDate'] }}
                                          @endif

                                          @if(!empty($policy['toDate']))
                                              To: {{ $policy['toDate'] }}
                                          @endif

                                          @if(!empty($policy['charge']))
                                              Charge: {{ $policy['charge'] }}
                                          @endif

                                          @if(!empty($policy['amendRestricted']))
                                              <span class="text-danger">Amendments not allowed</span>
                                          @endif

                                          @if(!empty($policy['cancelRestricted']))
                                              <span class="text-danger">Cancellations not allowed</span>
                                          @endif
                                        </li>
                                        @endforeach
                                      @endforeach
                                      <br>
                                      
                                      <li>{{__('lang.cancellation_policy_1')}}<strong><a href="tel:+965 6704 1515" >+965 6704 1515 </a></strong> (or) <strong><a href="mailto: booking@24flights.com">booking@24Flights.com</a></strong></li>
                                      <li>{{__('lang.cancellation_policy_2')}}</li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>KWD {{number_format($roomDetails['markups']['totalPrice']['value']/($result['searchRequest']->no_of_rooms*$result['searchRequest']->no_of_nights))}}</td>
                          <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#tariffNotes{{$r}}"><i class="fa fa-info-circle"></i></a>
                            <div id="tariffNotes{{$r}}" class="modal fade" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Tariff Notes</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  {{-- <div class="modal-body">
                                    @foreach($roomDetails['tariffNotes'] as $tk=>$tn)
                                      <div style="padding: 10px 0px;">
                                        <span style="font-weight: bold">Room {{$tk+1}} &nbsp; <span>Tariff Notes</span></span>
                                      </div>
                                      <div>
                                        {!! $tn !!}
                                      </div>
                                    @endforeach
                                  </div> --}}
                                  <div class="modal-body">
                                    @foreach($roomDetails['tariffNotes'] as $tk=>$tn)
                                      <div style="padding: 10px 0px;">
                                        <span style="font-weight: bold">Room {{$tk+1}} &nbsp; <span>Tariff Notes</span></span>
                                      </div>
                                      <div>
                                        @php
                                        $tn = preg_replace('/•\s*(.*)/', '<li>$1</li>', nl2br(html_entity_decode($tn)));
                                          $tn = '<ul>' . $tn . '</ul>';
                                        @endphp
                                        {!! $tn !!}
                                      </div>
                                    @endforeach
                                  </div>
                                </div>
                              </div>
                            </div>
                            

                          </td>
                          {{-- <td>{{$result['searchRequest']->no_of_rooms}} {{__('lang.room')}}/ {{$result['searchRequest']->no_of_nights}} {{__('lang.night')}}</td> --}}
                          <td style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">{{$roomDetails['markups']['totalPrice']['currency_code'] }}&nbsp; {{$roomDetails['markups']['totalPrice']['value'] }} 
                            <span><a href="#" data-bs-toggle="modal" data-bs-target="#roomInfo{{$r}}"><i class="fa fa-info-circle"></i></a></span> 
                            <div id="roomInfo{{$r}}" class="modal fade" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Room Info</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <ul>
                                      @foreach($roomDetails['roomPrice'] as $rnum =>$roomPrice)
                                      <li>Room {{$loop->iteration}} : {{$roomPrice['totalPrice']['currency_code']}} &nbsp; {{$roomPrice['totalPrice']['value']}} 
                                        @if(isset($roomDetails['validForOccupancy'][$rnum]))
                                        &nbsp;
                                        <a data-toggle="popover" data-title="{{$roomDetails['validForOccupancy'][$rnum]}}" role="button" data-original-title="{{$roomDetails['validForOccupancy'][$rnum]}}" title="{{$roomDetails['validForOccupancy'][$rnum]}}" ><i class="fa fa-bed"></i></a>
                                        @endif
                                      </li>
                                      @endforeach
                                      {{-- <li>{{__('lang.cancellation_policy_1')}}<strong><a href="tel:+965 6704 1515" >+965 6704 1515 </a></strong> (or) <strong><a href="mailto: booking@24  flights.com">booking@24Flights.com</a></strong></li>
                                      <li>{{__('lang.cancellation_policy_2')}}</li> --}}
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                           
                            @if(!empty($roomDetails['specialPromotion']))
                             <span>  <a href="#" data-bs-toggle="modal" data-bs-target="#specialPromotion{{$r}}"><i class="fa fa-tags"></i></a></span> 
                              <div id="specialPromotion{{$r}}" class="modal fade" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Special Promotion</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <ul>
                                        @foreach($roomDetails['specialPromotion'] as $policy)
                                        <li>
                                          {{$policy}}
                                        </li>
                                        @endforeach
                                      <ul>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            @endif
                           
                             @if( $result['searchRequest']->no_of_rooms == 1 && isset($roomDetails['validForOccupancy'][0]))
                              <a   title="{{$roomDetails['validForOccupancy'][0]}}" ><i class="fa fa-bed"></i></a>
                              @endif
                            <span> <a href="{{route('PreBookingRoom',['hotelCode'=>encrypt($result['hotelDeatils']['hotel_code']) , 'searchId' =>encrypt($result['searchRequest']->id) , 'bookingCode' => encrypt($roomDetails['bookingCode'])])}}" class="btn btn-sm btn-outline-primary shadow-none gButton"><span class="gButtonloader"></span>Book</a> </span>

                            
                          
                          
                          </td>

                        </tr>
                      @endforeach
                   
                  </tbody>
                </table>
              </div>
            @else
            <h5>{{__('lang.no_available_rooms_for_given_criteria')}}</h5>
            @endif
              <!-- Amenities ============================================= -->
              <h2 id="amenities" class="text-6 mb-3 mt-2">{{__('lang.amenities')}}</h2>
              <div class="row">
                  <?php $result['hotelDeatils']['HotelFacilities'] = explode(',' , $result['hotelDeatils']['hotel_facilities']);?>
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
            </div>
          </div>
        </div>
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
<script type="text/javascript" src="{{asset('frontEnd/js/lazy.min.js')}}"></script>
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
    $(function() {
        $('.lazy-image').lazy();
    });
  </script>
<script src='{{ asset('frontEnd/js/hotel.js') }}'></script>
@endsection