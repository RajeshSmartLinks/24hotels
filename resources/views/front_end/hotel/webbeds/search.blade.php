@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.hotels_list_page')}}</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}}</a></li>
            <li><a href="{{url('/')}}">{{__('lang.hotels')}}</a></li>
            <li class="active">{{__('lang.hotels_list_page_breadcrum')}}</li>
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
      <form id="bookingHotels" method="get" action="{{route('SearchHotels')}}">
        <div class="row g-3 mb-4">
          <div class="col-md-12 col-lg-2">
            <div class="position-relative">
              <input type="text" class="form-control" name = "hotelsCityName" id="hotelsCityName" required placeholder="{{__('lang.enter_city')}}" value="{{app('request')->input('hotelsCityName')}}">
              <span class="icon-inside"><i class="fas fa-map-marker-alt"></i></span> </div>
              <input type="hidden" class="form-control" id="hotelsCityCode"  name = "hotelsCityCode" value = "{{app('request')->input('hotelsCityCode')}}">
          </div>
          <div class="col-md-6 col-lg-2">
            <div class="position-relative">
              <input id="hotelsCheckIn" type="text" class="form-control" name = "hotelsCheckIn" required placeholder="{{__('lang.check_in')}}" value="{{app('request')->input('hotelsCheckIn')}}">
              <span class="icon-inside"><i class="far fa-calendar-alt"></i></span>
            </div>
          </div>
          <div class="col-md-6 col-lg-2">
            <div class="position-relative">
              <input id="hotelsCheckOut" type="text" class="form-control" name = "hotelsCheckOut" required placeholder="{{__('lang.check_out')}}" value="{{app('request')->input('hotelsCheckOut')}}">
              <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> 
             </div>
          </div>
          <div class="col-md-6 col-lg-2">
            <div class="travellers-class hotelsTravellersClass-1 ">
              <input type="text" id="hotelsTravellersClass"  class="travellers-class-input form-control" name="hotels-travellers-class" placeholder="Rooms / People" required onKeyPress="return false;" value= "{{app('request')->input('hotels-travellers-class')}}">
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
                      <input type="text" data-ride="spinner" id="hotels-rooms" class="qty-spinner form-control" value="{{app('request')->input('noOfRooms')}}" name = "noOfRooms" readonly  >
                      <div class="input-group-append">
                        <button type="button" class="btn bg-light-4 qtyChanger" id = "add-room">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="mt-2 mb-4">
                <div id="rooms-container"> 
                  @for ( $room = 1 ; $room <= app('request')->input('noOfRooms') ; $room++)

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
                          <input type="text" data-ride="spinner" id="adult-travellers-{{$room}}" class="qty-spinner form-control" value="{{app('request')->input('room'.($room))["adult"]}}" readonly name = "room{{$room}}[adult]">
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
                          <input type="text" data-ride="spinner" id="children-travellers-{{$room}}" class="qty-spinner form-control" value="{{app('request')->input('room'.($room))["children"]}}" name = "room{{$room}}[children]" readonly>
                          <div class="input-group-append">
                            <button type="button" class="btn bg-light-4" id = "children-travellers-plus-{{$room}}">+</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3" id="children-age-room-{{$room}}">
                      @if(isset(app('request')->input('room'.($room))["childrenAge"]) && count(app('request')->input('room'.($room))["childrenAge"]) > 0)
                        @foreach (app('request')->input('room'.($room))["childrenAge"] as $ind => $childInfoIndiviualroom)
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
          <div class="col-md-6 col-lg-2">
            <div class="position-relative">
              <select id="nationality-id" class="form-select" name = "nationality" required placeholder="{{__('lang.select_nationality')}}">
                <option value="">{{__('lang.select_nationality')}}</option>
                @foreach($result['countries'] as $country)
                <option value="{{$country->code}}" {{app('request')->input('nationality') == $country->code?"selected":""}}>{{$country->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6 col-lg-2 d-grid">
            <button class="btn btn-primary" type="submit"  id= "searchbutton"> <span></span>{{__('lang.update')}}</button>
          </div>
        </div>
      </form>
      <div class="row"> 
        
        <!-- Side Panel
        ============================================= -->
        <aside class="col-lg-3">
          <div class="bg-white shadow-md rounded p-3">
            <h3 class="text-5">Filter</h3>
            <hr class="mx-n3">
            <div class="accordion accordion-flush style-2 mt-n3" id="toggleAlternate">
              <div class="accordion-item">
                <h2 class="accordion-header" id="hotelName">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#togglehotelName" aria-expanded="true" aria-controls="togglehotelName">{{__('lang.hotel_name')}}</button>
                </h2>
                <div id="togglehotelName" class="accordion-collapse collapse show" aria-labelledby="hotelName">
                  <div class="accordion-body">
                    <div class="position-relative">
                      <input type="text" class="form-control form-control-sm" id="SearchHotel" placeholder="{{__('lang.search_by_hotel_name')}}">
                      <span class="icon-inside"><i class="fas fa-search"></i></span> </div>
                  </div>
                </div>
              </div>
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
                <h2 class="accordion-header" id="propertyTypes">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#toggleRefund" aria-expanded="true" aria-controls="toggleRefund">{{__('lang.refund')}} </button>
                </h2>
                {{-- <div id="toggleRefund" class="accordion-collapse collapse show" aria-labelledby="propertyTypes">
                  <div class="accordion-body">
                    <div class="form-check refundscheck">
                      <input type="checkbox" id="hotel" name="propertyTypes" class="form-check-input" value="refundable">
                      <label class="form-check-label d-block" for="hotel">{{__('lang.refundable')}} <small class="text-muted float-end">{{$result['filter']['refundableCount']}}</small></label>
                    </div>
                    <div class="form-check refundscheck">
                      <input type="checkbox" id="resort" name="propertyTypes" class="form-check-input" value="non-refundable">
                      <label class="form-check-label d-block" for="resort">{{__('lang.non_refundable')}} <small class="text-muted float-end">{{$result['filter']['nonrefundableCount']}}</small></label>
                    </div>
                    
                  </div>
                </div> --}}
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="starCategory">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#togglestarCategory" aria-expanded="true" aria-controls="togglestarCategory">{{__('lang.stars')}}</button>
                </h2>
                <div id="togglestarCategory" class="accordion-collapse collapse show" aria-labelledby="starCategory">
                  <div class="accordion-body">
                    <div class="form-check ratingscheck">
                      <input type="checkbox" id="5Star" name="starCategory" class="form-check-input" value="five">
                      <label class="form-check-label d-block" for="5Star">5 {{__('lang.star')}} <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i> <small class="text-muted float-end">{{ $result['filter']['rating']['five_star'] ?? 0}}</small></label>
                    </div>
                    <div class="form-check ratingscheck">
                      <input type="checkbox" id="4Star" name="starCategory" class="form-check-input" value="four">
                      <label class="form-check-label d-block" for="4Star">4 {{__('lang.star')}} <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><small class="text-muted float-end">{{ $result['filter']['rating']['four_star'] ?? 0}}</small></label>
                    </div>
                    <div class="form-check ratingscheck">
                      <input type="checkbox" id="3Star" name="starCategory" class="form-check-input" value="three">
                      <label class="form-check-label d-block" for="3Star">3 {{__('lang.star')}} <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i> <small class="text-muted float-end">{{ $result['filter']['rating']['three_star'] ?? 0}}</small></label>
                    </div>
                    <div class="form-check ratingscheck">
                      <input type="checkbox" id="2Star" name="starCategory" class="form-check-input" value="two">
                      <label class="form-check-label d-block" for="2Star">2 {{__('lang.star')}} <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i> <small class="text-muted float-end">{{ $result['filter']['rating']['two_star'] ?? 0}}</small></label>
                    </div>
                    <div class="form-check ratingscheck">
                      <input type="checkbox" id="1Star" name="starCategory" class="form-check-input" value="one">
                      <label class="form-check-label d-block" for="1Star">1 {{__('lang.star')}} <i class="fas fa-star text-warning"></i> <small class="text-muted float-end">{{ $result['filter']['rating']['one_star'] ?? 0}}</small></label>
                    </div>
                  </div>
                </div>
              </div>
              {{-- <div class="accordion-item">
                <h2 class="accordion-header" id="userReview">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#toggleuserReview" aria-expanded="true" aria-controls="toggleuserReview">User Review</button>
                </h2>
                <div id="toggleuserReview" class="accordion-collapse collapse show" aria-labelledby="userReview">
                  <div class="accordion-body">
                    <div class="form-check ">
                      <input type="checkbox" id="excellent" name="userReview" class="form-check-input">
                      <label class="form-check-label d-block" for="excellent">Excellent <small class="text-muted float-end">499</small></label>
                    </div>
                    <div class="form-check ">
                      <input type="checkbox" id="good" name="userReview" class="form-check-input">
                      <label class="form-check-label d-block" for="good">Good <small class="text-muted float-end">310</small></label>
                    </div>
                    <div class="form-check ">
                      <input type="checkbox" id="fair" name="userReview" class="form-check-input">
                      <label class="form-check-label d-block" for="fair">Fair <small class="text-muted float-end">225</small></label>
                    </div>
                    <div class="form-check ">
                      <input type="checkbox" id="poor" name="userReview" class="form-check-input">
                      <label class="form-check-label d-block" for="poor">Poor <small class="text-muted float-end">110</small></label>
                    </div>
                    <div class="form-check ">
                      <input type="checkbox" id="bad" name="userReview" class="form-check-input">
                      <label class="form-check-label d-block" for="bad">Bad <small class="text-muted float-end">44</small></label>
                    </div>
                  </div>
                </div>
              </div> --}}
            </div>
          </div>
        </aside>
        <!-- Side Panel end -->
        
        <div class="col-lg-9 mt-4 mt-lg-0"> 
          <!-- Sort Filters
          ============================================= -->
          <div class="border-bottom mb-3 pb-3">
            <div class="row align-items-center">
              <div class="col-6 col-md-8"> <span class="me-3"><span class="text-4">{{$result['cityName']}}:</span> <span class="fw-600">{{count($result['hotelList'])}} Hotels</span> found</span> <span class="text-warning text-nowrap">  {{__('lang.prices_inclusive_of_taxes')}}</span></div>
              <div class="col-6 col-md-4">
                <div class="row g-0 ms-auto">
                  <label class="col col-form-label-sm text-end me-2 mb-0" for="input-sort">{{__('lang.sort_by')}} :</label>
                  <select id="input-sort" class="form-select form-select-sm col" name="input-sort" onchange="getsort(this);">
                    <option value="LH">{{__('lang.price_low_to_high')}}</option>
                    <option value="HL">{{__('lang.price_high_to_low')}}</option>
                    {{-- <option value="">User Rating - High to Low</option> --}}
                  </select>
                </div>
              </div>
            </div>
          </div>
          <!-- Sort Filters end --> 
          
          <!-- List Item
          ============================================= -->
          <div class="hotels-list">
            @foreach($result['hotelList'] as $hotelDetails)

            <?php
            $ratingval = '';
            switch ($hotelDetails['hotelRating']) {
              case '1':
                $ratingval = 'one';
                break;
              case '2':
                $ratingval = 'two';
                break;
              case '3':
                $ratingval = 'three';
                break;
              case '4':
                $ratingval = 'four';
                break;
              case '5':
                $ratingval = 'five';
                break;
            }
            ?>

            <div class="hotels-item bg-white shadow-md rounded p-3" data-pricing = "{{$hotelDetails['markups']['totalPrice']['value']}}" 
            {{-- data-refund = "{{$hotelDetails['isRefundable'] == '1' ? 'refundable':'non-refundable'}}" --}}
             data-rating = "{{$ratingval}}" data-hotelname ="{{$hotelDetails['hotelName']}}">
              <div class="row">
                <div class="col-md-4"> <a href="#">
                  {{-- <img class="img-fluid rounded align-top" style="height:187px;width: 250px;" src="{{$hotelDetails['image']}}" alt="hotels" onError="this.onerror=null;this.src='{{ asset('frontEnd/images/no-hotel-image.png') }}';"> --}}
                  <img class="img-fluid rounded align-top lazy-image" style="height:187px;width: 250px;" data-src="{{$hotelDetails['image']}}" alt="{{$hotelDetails['hotelName']}}" src="{{ asset('frontEnd/images/no-hotel-image.png') }}">
                </a> </div>
                <div class="col-md-8 ps-3 ps-md-0 mt-3 mt-md-0">
                  <div class="row g-0">
                    <div class="col-sm-9">
                      <h4><a href="#" class="text-dark text-5">{{$hotelDetails['hotelName']}}</a></h4>
                      <p class="mb-2" style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;overflow: hidden;text-overflow: ellipsis;"> <span class="me-2">
                        @for($i= 1;$i<=$hotelDetails['hotelRating'];$i++)
                            <i class="fas fa-star text-warning"></i>
                        @endfor
                        </span> <span class="text-black-50"><i class="fas fa-map-marker-alt"></i> &nbsp;{{$hotelDetails['address']}} 
                    
                        @if ($hotelDetails['pin_code'])
                              {{"(" .$hotelDetails['pin_code'].")"}}
                        @endif
                    </span> </p>
                        <div class="row">
                            <div class="col-5">
                                <span class="text-black-50">{{__('lang.check_in')}} : </span><span class="fw-600">{{$hotelDetails['checkIn']}}</span></div>
                              <div class="col-5">
                                <span class="text-black-50">{{__('lang.check_out')}} : </span><span class="fw-600">{{$hotelDetails['checkOut']}}</span>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-3 text-end d-flex d-sm-block align-items-center">
                      <div class="text-dark text-4 fw-500 mb-0 mb-sm-2 me-2 me-sm-0 order-0">{{$hotelDetails['markups']['totalPrice']['currency_code']}} </div>
                      <div class="text-dark text-4 fw-500 mb-0 mb-sm-2 me-2 me-sm-0 order-0">{{$hotelDetails['markups']['totalPrice']['value']}}</div>
                      <div class="text-black-50 mb-0 mb-sm-2 order-3 d-none d-sm-block">{{$result['searchRequest']['no_of_rooms']}} {{__('lang.room')}} / {{$result['searchRequest']['no_of_nights']}} {{__('lang.night')}}</div>
                      <a href="{{route('GethotelDetails',['hotelCode'=>encrypt($hotelDetails['hotelCode']) , 'searchId' =>encrypt($result['searchId'])])}}" class="btn btn-sm btn-primary order-4 ms-auto gButton"><span class="gButtonloader"></span>{{__('lang.book_now')}}</a> </div>
                  </div>
                  <div class="row">
                    {{-- <div class="col-4">
                      <p class="reviews mb-2 mt-2"> <span class="fw-600">{{__('lang.refundable')}}</span>
                        @if($hotelDetails['isRefundable'] == 1)
                        <span class="reviews-score px-2 py-1 rounded fw-600 text-light">{{__('lang.yes')}}</span> 
                        @else
                        <span class="px-2 py-1 rounded fw-600 text-light" style="background: red">{{__('lang.no')}}</span> 
                        @endif
                     </p>
                    </div> --}}
                     <div class="col-6">
                      <p class="reviews mb-2 mt-2"> 
                        <span class="fw-600">{{__('lang.phone_number')}}</span>
                        <span class=" px-2 py-1 fw-600 "> : {{$hotelDetails['phone_number']}}</span> 
                     </p>
                    </div>
                    <div class="col-6">
                          <p class="reviews mb-2 mt-2"> 
                      
                         @if($hotelDetails['exclusive'] == 'yes')
                   
                            <span class="reviews-score px-2 py-1 rounded fw-600" style="background:#8fdc55">{{__('lang.exclusive')}}</span> 
                        
                        @endif
                          @if($hotelDetails['preferred'] == 'yes')
                       
                            <span class="px-2 py-1 rounded fw-600 text-light" style="background: #aa92fc">{{__('lang.preferred')}}</span> 
                        @endif

                    
                     </p>
                        {{-- @if($hotelDetails['exclusive'] == 'yes')
                        <p class="reviews mb-2 mt-2">
                            <span class="reviews-score px-2 py-1 rounded fw-600" style="background:#8fdc55">{{__('lang.exclusive')}}</span> 
                        </p>
                        @endif
                        @if($hotelDetails['preferred'] == 'yes')
                        <p class="reviews mb-2 mt-2">
                            <span class="px-2 py-1 rounded fw-600 text-light" style="background: #aa92fc">{{__('lang.preferred')}}</span> 
                        </p>
                        @endif --}}
                    </div>

                    
                    {{-- <div class="col-7">
                      <div class="row text-1 mt-2">
                        @foreach($hotelDetails['roomPromotion'] as $promotion)
                        <div class="col-6 col-xl-6" style="display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        text-overflow: ellipsis;"><span class="text-success me-1"></span>{!! html_entity_decode($promotion) !!}</div>
                        @endforeach
                      </div>
                    </div> --}}
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <!-- List Item end --> 
          
          <!-- Pagination
            ============================================= -->
          {{-- <ul class="pagination justify-content-center mt-4 mb-0">
            <li class="page-item disabled"> <a class="page-link" href="#" tabindex="-1"><i class="fas fa-angle-left"></i></a> </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active"> <a class="page-link" href="#">2</a> </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"> <a class="page-link" href="#"><i class="fas fa-angle-right"></i></a> </li>
          </ul> --}}
          <!-- Paginations end --> 
          
        </div>
      </div>
    </section>
  </div>
  <!-- Content end --> 

  @endsection
  @section('extraScripts')
  <script type="text/javascript" src="{{asset('frontEnd/js/lazy.min.js')}}"></script>
  <script>
    $(function() {

      // Autocomplete
      // $('#hotelsFrom').autocomplete({
      //     minLength: 3,
      //     delay: 100,
      //     source: function (request, response) {
      //       $.getJSON(
      //        'http://gd.geobytes.com/AutoCompleteCity?callback=?&q='+request.term,
      //         function (data) {
      //            response(data);
      //       }
      //   );
      //   },
      // });
      //hotelserach
      $('#hotelsCityName').autocomplete({
            minLength: 3,
            //delay: 50,
            source: function( request, response ) {
                $.ajax({
                url: "{{route('hotelautoSuggest')}}",
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
                            code: item.code,
                            city_name: item.name,
                            country_name:item.country_name,
                       
                        };
                    }));
                },
                });
            },
            select: function( event, ui ) {
                $("input[name='hotelsCityCode']").val(ui.item.code);
                $("#hotelsCheckIn").focus();
            },
            search  : function(){$(this).addClass('preloader');},
            open    : function(){$(this).removeClass('preloader');}
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) 
        {  
          return $( "<li dir='ltr' role='presentation' tabindex='0' class='sc-iUKqMP hlZHGM'></li>" )  
              .data( "item.autocomplete", item )  
              .append( '<div class="sc-iAKWXU iyyKqe"><div class="sc-efQSVx iQoDho"><div class="sc-jObWnj dmPlWU"><p class="sc-dPiLbb kUaZDb"><span class="autoCompleteTitle ">'+item.label+'&nbsp;</span></p><p class="sc-bBHHxi cTvqKV">'+item.country_name+'</p></div></div></div>' )  
              .appendTo( ul );  
        }; 
        
         // Depart Date
         var start = moment("{{app('request')->input('hotelsCheckIn')}}");
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

      


      $('.hotelguestsdone').on('click', function() {
        $("#nationality-id").focus();
      });
      
  });


    // Slider Range (jQuery UI)

    var minprice =  Math.floor({{$result['filter']['minPrice'] ?? 0}});
    var maxprice =  Math.ceil({{$result['filter']['maxPrice'] ?? 0}});
    var currencyCode =  "{{config('app.currency')}}";


    $( "#slider-range" ).slider({
      range: true,
      min: minprice ,
      max: maxprice,
      values: [ minprice, maxprice ],
      slide: function( event, ui ) {
      $( "#amount" ).val( currencyCode+" " + ui.values[ 0 ] + " - "+currencyCode+" " + ui.values[ 1 ] );
      $( "#minvalue" ).val(ui.values[ 0 ]);
      $( "#maxvalue" ).val(ui.values[ 1 ]);

      var selectedRefunds = new Array();
      $('.refundscheck input[type=checkbox]:checked').each(function () {
        selectedRefunds.push(this.value);
      });
      
      var selectedRating = new Array();
      $('.ratingscheck input[type=checkbox]:checked').each(function () {
        selectedRating.push(this.value);
      });

      minvalue = ui.values[ 0 ];
      maxvalue = ui.values[ 1 ];
      var searchhotel = ($("#SearchHotel" ).val());

      filter(selectedRefunds,selectedRating,minvalue,maxvalue,searchhotel);
      }
    });
    $( "#amount" ).val( currencyCode+" " + $( "#slider-range" ).slider( "values", 0 ) +" - " +currencyCode+" "+ $( "#slider-range" ).slider( "values", 1 ) );
    $( "#minvalue" ).val(minprice);
    $( "#maxvalue" ).val(maxprice);

    var refunds = new Array();
    var ratings = new Array();
    var filterMinPrice = minprice;
    var filterMaxPrice = maxprice;

    $('.refundscheck input[type=checkbox]').each(function () {
        refunds.push(this.value);
    });
    $('.ratingscheck input[type=checkbox]').each(function () {
      ratings.push(this.value);
    });

    $('#toggleRefund :checkbox,#togglestarCategory :checkbox,#SearchHotel').change(function () {

        var selectedRefunds = new Array();
        $('.refundscheck input[type=checkbox]:checked').each(function () {
          selectedRefunds.push(this.value);
        });

        var selectedRating = new Array();
        $('.ratingscheck input[type=checkbox]:checked').each(function () {
          selectedRating.push(this.value);
        });

      var minvalue = parseInt($( "#minvalue" ).val());
      var maxvalue = parseInt($( "#maxvalue" ).val());
      var searchhotel = $("#SearchHotel" ).val();

      filter(selectedRefunds,selectedRating,minvalue,maxvalue,searchhotel);
    });

    $("#SearchHotel").on("input", function(e) {
      var selectedRefunds = new Array();
        $('.refundscheck input[type=checkbox]:checked').each(function () {
          selectedRefunds.push(this.value);
        });

        var selectedRating = new Array();
        $('.ratingscheck input[type=checkbox]:checked').each(function () {
          selectedRating.push(this.value);
        });

      var minvalue = parseInt($( "#minvalue" ).val());
      var maxvalue = parseInt($( "#maxvalue" ).val());
      var searchhotel = $("#SearchHotel" ).val();

      filter(selectedRefunds,selectedRating,minvalue,maxvalue,searchhotel);
    });

    function filter(selectedRefunds,selectedRating,filterMinPrice,filterMaxPrice,filterSearchHotel)
    {
      console.log("selectedRefunds" , selectedRefunds);
      console.log("selectedRating" , selectedRating);
      console.log("filterMinPrice" , filterMinPrice);
      console.log("filterMaxPrice" , filterMaxPrice);
      console.log("filterSearchHotel" , filterSearchHotel);



      $(".hotels-item").css('display','none');
      $('.hotels-item').each(function(){
        console.log("data" , $(this).data());
        console.log("ghf" , $.inArray($(this).data('refund'), selectedRefunds) );
        var pattern = new RegExp(filterSearchHotel, "gi");
        console.log("paterren" , pattern);
      console.log("jdhjh" , $(this).data('hotelname').match(pattern));
      if(($(this).data('pricing') > filterMinPrice) && ($(this).data('pricing') < filterMaxPrice) && (selectedRefunds.length==0 || ($.inArray($(this).data('refund'), selectedRefunds) > -1)) && (selectedRating.length==0 || ($.inArray($(this).data('rating'), selectedRating) > -1)) && (filterSearchHotel.length == 0 || ($(this).data('hotelname').match(pattern))))
      {
        $(this).css('display','block');
      }
      });
    }
    $(document).ready(function(){
      $("#bookingHotels").on("submit", function(){
        $("#searchbutton").prop('disabled',true);
        $("#searchbutton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
      });//submit
    });//document ready

    function getsort(sel)
    {

      var sort = sel.value;
      var $wrapper = $('.hotels-list');
      if(sort == "LH"){
        $wrapper.find('.hotels-item').sort(function (a, b) {
        return +a.dataset.pricing - +b.dataset.pricing;
        }) .appendTo( $wrapper );
 
      }
      else{
        $wrapper.find('.hotels-item').sort(function (a, b) {
        return +b.dataset.pricing - +a.dataset.pricing;
        }) .appendTo( $wrapper );

      }
     
    }

    $(function() {
        $('.lazy-image').lazy();
    });



    </script> 
    <script src='{{ asset('frontEnd/js/hotel.js') }}'></script>
  @endsection