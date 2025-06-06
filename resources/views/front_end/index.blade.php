@extends('front_end.layouts.master')
@section('content')
<style>
  .error {
      color: red;
   }
    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      background: transparent;
      border: none;
      font-size: 2rem;
      color: white;
      cursor: pointer;
    }

   /* .background-image-container::before {
    background-image: url('{{ asset('frontEnd/images/backGroundImg.jpg') }}'); 
   } */

        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .login-card h4 {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-control::placeholder {
            color: #c4c4c4;
        }

        .btn-login {
            background-color: #003e9f;
            color: white;
        }

        /* .btn-login:hover {
            background-color: #002e7a;
        } */

        .text-link {
            font-size: 0.9rem;
        }

        .form-group .form-control {
            border-radius: 6px;
        }

        .bg-Font{
          font-weight: 500;
          color: black;
        }

</style>


  <!-- Content -->
  <div id="content">
    <div class="bg-secondary pb-4" style = "background-image: url('{{ asset('frontEnd/images/bg-index2.jpg') }}');">
      <div class="background-image-container">
        <div class="container content-img" style="max-width: 1420px;padding-top:60px;"> 
          <!-- Secondary Navigation -->
          <div class="row">
             <div class="col-lg-5 logo-column d-none d-lg-block">
              {{-- <img src="your-logo.png" alt="Logo" class="img-fluid mb-4"> --}}
            </div>
            @if(auth()->user())
            <div class="col-md-12 col-lg-7 pt-5 pb-5">
              <div class="bg-white shadow-md tab-pane  rounded p-4" id="second" role="tabpanel" aria-labelledby="second-tab">
                <h2 class="text-4 mb-3">{{__('lang.book_domestic_and_international_hotels')}} </h2>
                <form id="bookingHotels" method="get" action="{{route('webbedsSearchHotels')}}">
                  <div class="row g-3">
                    
                    <div class="col-md-12 col-lg-4">
                      <div class="position-relative">
                        <input type="text" class="form-control" name = "hotelsCityName" id="hotelsCityName" required placeholder=" {{__('lang.enter_city')}}">
                        <span class="icon-inside"><i class="fas fa-map-marker-alt"></i></span> </div>
                        <input type="hidden" class="form-control" id="hotelsCityCode"  name = "hotelsCityCode" value = "">
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <div class="position-relative">
                        <input id="hotelsCheckIn" type="text" class="form-control" name = "hotelsCheckIn" required placeholder="{{__('lang.check_in')}}">
                        <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <div class="position-relative">
                        <input id="hotelsCheckOut" type="text" class="form-control" name = "hotelsCheckOut" required placeholder="{{__('lang.check_out')}}">
                        <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <div class="travellers-class hotelsTravellersClass-1 ">
                        <input type="text" id="hotelsTravellersClass"  class="travellers-class-input form-control" name="hotels-travellers-class" placeholder="Rooms / People" required onKeyPress="return false;">
                        <span class="icon-inside"><i class="fas fa-caret-down"></i></span>
                        <div class="travellers-dropdown">
                          <div class="row align-items-center">
                            <div class="col-sm-7">
                              <p class="mb-sm-0">{{__('lang.rooms')}} </p>
                            </div>
                            <div class="col-sm-5">
                              <div class="qty input-group">
                                <div class="input-group-prepend">
                                  <button type="button" class="btn bg-light-4 qtyChanger" id = "remove-room">-</button>
                                </div>
                                <input type="text" data-ride="spinner" id="hotels-rooms" class="qty-spinner form-control" value="1" name = "noOfRooms" readonly  >
                                <div class="input-group-append">
                                  <button type="button" class="btn bg-light-4 qtyChanger" id = "add-room">+</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <hr class="mt-2 mb-4">
                          <div id="rooms-container"> 
                            <div>
                              {{__('lang.room')}} 1
                              <div class="row align-items-center">
                                
                                <div class="col-sm-7">
                                  <p class="mb-sm-0">{{__('lang.adults')}}  <small class="text-muted">(18+ yrs)</small></p>
                                </div>
                                <div class="col-sm-5">
                                  <div class="qty input-group">
                                    <div class="input-group-prepend">
                                      <button type="button" class="btn bg-light-4" id = "adult-travellers-minus-1">-</button>
                                    </div>
                                    <input type="text" data-ride="spinner" id="adult-travellers-1" class="qty-spinner form-control" value="1" readonly name = "room1[adult]">
                                    <div class="input-group-append">
                                      <button type="button" class="btn bg-light-4" id = "adult-travellers-plus-1">+</button>
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
                                      <button type="button" class="btn bg-light-4" id = "children-travellers-minus-1">-</button>
                                    </div>
                                    <input type="text" data-ride="spinner" id="children-travellers-1" class="qty-spinner form-control" value="0" name = "room1[children]" readonly>
                                    <div class="input-group-append">
                                      <button type="button" class="btn bg-light-4" id = "children-travellers-plus-1">+</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row mt-3" id="children-age-room-1">
                                
                              </div>
                              <hr class="my-2">
                            </div>
                          </div>
    
                          <div class="d-grid">
                            <button class="btn btn-primary submit-done mt-3" type="button">{{__('lang.done')}}</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <div class="position-relative">
                        <select id="nationality-id" class="form-select" name = "nationality" required placeholder="{{__('lang.select_nationality')}}">
                          <option value="">{{__('lang.select_nationality')}}</option>
                          @foreach($countries as $country)
                          <option value="{{$country->code}}">{{$country->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <div class="position-relative">
                        <select id="residency-id" class="form-select" name = "residency" required placeholder="{{__('lang.select_residency')}}">
                          <option value="">{{__('lang.select_residency')}}</option>
                          @foreach($countries as $country)
                          <option value="{{$country->code}}">{{$country->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    
                      <div class="text-center">
                      <button class="btn btn-primary" type="submit" id ="hotelsearchbutton"><span></span>{{__('lang.search')}}</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            @else
            <div class="col-md-7 col-lg-3 d-none d-lg-block">
                <div class="bg-Font mt-5">
                    <p >Masila Holidays empowers travel agencies to operate more efficiently.</p>
                    <p class="mt-3">As a leading global travel distribution platform, we streamline business processes for both suppliers and buyers like travel agencies and online travel platforms.</p>
                    <div class="logos pt-5">
                        <img src="{{asset("frontEnd/images/iata-trans.png")}}" style="width: 170px;height: 78px;" alt="Image Alternative text" title="IATA">
                        <img src="{{asset("frontEnd/images/civil-aviation.png")}}" style="width: 130px;height: 55px;" alt="Image Alternative text" title="Kuwait-Civil">
                    </div>
                </div>
            </div>
            
            <div class="col-md-5 col-lg-4" >
              
              <form id="loginForm" method="post" action ="{{ route('login') }}">
                @csrf
              <div class="login-card">
                <h4>Login to your account</h4>
                <form>
                    <div class="form-group">
                        <label class = "form-label">Email </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="emailAddress"  placeholder="{{__('lang.email')}}" name ="email" value={{ old('email') }}>
                         @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label class ="form-label">Password</label>
                        <div class="input-group">
                             <input type="password" class="form-control @error('password') is-invalid @enderror" id="loginPassword"  placeholder="{{__('lang.password')}}" name="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="text-right text-link mt-1">
                            <a class="btn-link" href="{{route('user-forget.password.get')}}"> {{__('lang.forgot_password')}}</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login btn-block mt-3">Login →</button>

                    <div class="text-center text-link mt-3">
                        Don’t have an account? <a href="#"><strong>Register with us</strong></a>
                    </div>
                </form>
              </div>
               </form>

            </div>
            @endif
            
          </div>
          
          <!-- Secondary Navigation end --> 
          
          
       
          
        </div>

      </div>
      
    </div>
    
    <!-- Banner -->
    {{-- <div class="bg-white shadow-md pt-5 pb-4">
      <div class="container">
        <div class="owl-carousel owl-theme" data-autoplay="true" data-loop="true" data-nav="true" data-margin="30" data-items-xs="1" data-items-sm="2" data-items-md="2" data-items-lg="3">
          @foreach($offers as $offer)
          <div class="item">
            <a href="{{route('offerDetails',['slug'=>$offer->slug])}}">
            <div class="offerBlkWdgtNew offers">
              <img src="{{asset('uploads/offers/'.$offer->image)}}" alt="Offers">
              <div class="ico13 greyDr padTB10 padLR10 lh1-2 fmed dib offerListIndex" style="display: inline-block;    padding: 10px;    color: black;">{{$offer->name}}</div>
              <br>
              <div class=" offerListIndex" style="display: inline-block;    padding: 0px 10px;    color: black;"><span style="color: green">Valid Upto :</span><span>  {{date('M d,Y', strtotime($offer->valid_upto))}}</span></div>
            </div>
            </a>
          </div>
          @endforeach
         
        </div>
      </div>
    </div> --}}

        <!-- Banner
    ============================================= -->
    {{-- <div class="bg-white shadow-md pt-5 pb-4">
      <div class="container">
        <div class="owl-carousel owl-theme" data-autoplay="true" data-loop="true" data-margin="30" data-items-xs="1" data-items-sm="2" data-items-md="2" data-items-lg="3">
          @foreach($offers as $offer)
          <div class="item"> <a href="{{route('offerDetails',['slug'=>$offer->slug])}}">
            <div class="card border-1 shadow-sm  bg-white " style="border-radius:8px"> <img class="card-img-top rounded" style="height: 180px" src="{{asset('uploads/offers/'.$offer->image)}}" alt="banner">
              <div class="card-body px-2 py-1">
                <p class="card-title fw-500 text-dark mb-1 offerListIndex">{{$offer->name}}</p>
              
                <p class="card-text text-1 text-muted mb-0"><div><span style="color: green">Valid Upto :</span><span>  {{date('M d,Y', strtotime($offer->valid_upto))}}</span></div></p>
              </div>
            </div>
            </a> </div>
            @endforeach
        </div>
        
      </div>
    </div> --}}
    <!-- Banner end -->
    <!-- Banner end -->
    
    <div class="container">
      <section class="section px-3 px-md-5 pb-4">
        <h2 class="text-9 fw-600 text-center">{{__('lang.why_book_hotel_with_masilaholidays')}}</h2>
        <p class="lead mb-5 text-center">{{__('lang.best_b2b_rates_of_agencies')}}</p>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="featured-box text-center">
              <div class="featured-box-icon text-primary"> <i class="fas fa-dollar-sign"></i> </div>
              <h3>{{__('lang.no_booking_charges')}}</h3>
              <p>{{__('lang.no_hidden_charges')}}</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="featured-box text-center">
              <div class="featured-box-icon text-primary"> <i class="fas fa-percentage"></i> </div>
              <h3>{{__('lang.cheapest_price')}}</h3>
              <p>{{__('lang.cheapest_price_desc')}}</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="featured-box text-center">
              <div class="featured-box-icon text-primary"> <i class="far fa-times-circle"></i> </div>
              <h3>{{__('lang.easy_cancellation_refunds')}}</h3>
              <p>{{__('lang.easy_cancellation_refunds_desc')}}</p>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- Banner ============================================= -->
    {{-- <div class="bg-white shadow-md pt-5 pb-4">
      <div class="container">
        <h2  class="fs_xs_14 fs_24"><p  class="fs_xs_14 fw_600 mb-4">{{__('lang.our_packages')}}</p></h2>
        <div class="owl-carousel owl-theme" data-autoplay="true" data-loop="true" data-nav="true" data-margin="30" data-items-xs="1" data-items-sm="2" data-items-md="2" data-items-lg="3">
           @foreach ($packages as $package)
           <div class="item"><a href="{{route('packageDetails',['slug'=>$package->slug])}}"><img style="height:350px !important"class=" rounded" src="{{asset('uploads/packages/'.$package->image)}}" alt="{{$package->name}}" /></a></div>
           @endforeach
          
        
            @if(!empty($facebookPosts) && $facebookPosts !=null)
            @foreach($facebookPosts as $post)
              
              <!-- <div class="item">
                  <a href="#">
                      <img src="{{ $post['image_url'] }}" alt="Post Image" style="height:350px !important" class=" rounded">
                  </a>
              </div> -->
                      
            @endforeach
            @endif
        </div>
      </div>
    </div> --}}
    <!-- Banner end -->

    {{-- <section class="section bg-white shadow-md pt-4 pb-1">
      <div class="container">
        <div class="row">
          <div  class="col-12">
            <h2  class="fs_xs_14 fs_24"><p  class="fs_xs_14 fw_600 mb-4">{{__('lang.popular_destinations')}}</p></h2>
            <div  class="d-flex justify-content-between overflow-auto mr-n3 mr-lg-0 mb-5 mb-lg-0">
              @foreach($destinations as $destination)
              @if($loop->iteration <5)
              <div class="destination col-xl-3 col-sm-12 col-12">
                <a href="{{route('destinationDetails',['slug'=>$destination->slug])}}">
                <img src="{{asset('uploads/destinations/'.$destination->image)}}" alt="{{$destination->name}}" loading="lazy" width="100%" height="285" style="border-radius: 17px;">
                <p class="destinationCity">{{$destination->name}}</p>
                <div class="destinationbutton">
                  <button type="button" class="btn btn-primary rounded-pill  btn-sm destinationbuttonText" >{{__('lang.book_flight')}}</button>
                </div>
              </a>
              </div>
              @endif
              @endforeach
            </div>
          </div>
        </div>
        @if(count($destinations) > 4)
        <div class="row" style="padding-top: 25px;">
          <div  class="col-12">
            <div  class="d-flex justify-content-between overflow-auto mr-n3 mr-lg-0 mb-5 mb-lg-0">
              @foreach($destinations as $destination)
            
              @if($loop->iteration > 4 && $loop->iteration < 9)
              <div class="destination col-xl-3 col-sm-12 col-12" >
                <img src="{{asset('uploads/destinations/'.$destination->image)}}" alt="{{$destination->name}}" loading="lazy" width="100%" height="285" style="border-radius: 17px;">
                <p class="destinationCity">{{$destination->name}}</p>
                <div class="destinationbutton">
                  <button type="button" class="btn btn-primary rounded-pill  btn-sm destinationbuttonText" >{{__('lang.book_flight')}}</button>
                </div>
              </div>
              @endif
              @endforeach
            
            
              
            </div>
          </div>
        </div>
        @endif
      </div>
    </section> --}}

    <!-- Banner============================================= -->
    {{-- <div class="bg-white shadow-md pt-5 pb-4">
      <div class="container">
        <h2  class="fs_xs_14 fs_24"><p  class="fs_xs_14 fw_600 mb-4">{{__('lang.popular_events_and_news')}}</p></h2>
        <div class="owl-carousel owl-theme" data-autoplay="true" data-loop="true" data-nav="true" data-margin="30" data-items-xs="1" data-items-sm="2" data-items-md="2" data-items-lg="4">
          @foreach($popularEventNews as $events)
            <a href="{{route('popularEventsNewsDetails',['slug'=>$events->slug])}}">
              <img src="{{asset('uploads/popular_events_news/'.$events->image)}}" alt="{{$events->name}}" loading="lazy" width="100%" height="180" style="border-radius: 17px;">
              <p class="destinationCity">{{$events->name}}</p>
            </a>
          @endforeach          
        </div>
      </div>
    </div> --}}
    <!-- Banner end -->

    {{-- <div class="section py-4">
      <div class="container">
        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
          <li class="nav-item"> <a class="nav-link active" id="first-tab" data-bs-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">Book Flights</a> </li>
          <li class="nav-item"> <a class="nav-link" id="second-tab" data-bs-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Why 24Flights?</a> </li>
        </ul>
        <div class="tab-content my-3" id="myTabContent">
          <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
            <p>Online Book Domestic and International flights Iisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. Mutat tacimates id sit. Ridens mediocritatem ius an, eu nec magna imperdiet. Mediocrem qualisque in has. Enim utroque perfecto id mei, ad eam tritani labores facilisis, ullum sensibus no cum. Eius eleifend in quo. At mei alia iriure propriae.</p>
            <p>Partiendo voluptatibus ex cum, sed erat fuisset ne, cum ex meis volumus mentitum. Alienum pertinacia maiestatis ne eum, verear persequeris et vim. Mea cu dicit voluptua efficiantur, nullam labitur veritus sit cu. Eum denique omittantur te, in justo epicurei his, eu mei aeque populo. Cu pro facer sententiae, ne brute graece scripta duo. No placerat quaerendum nec, pri alia ceteros adipiscing ut. Quo in nobis nostrum intellegebat. Ius hinc decore erroribus eu, in case prima exerci pri. Id eum prima adipisci. Ius cu minim theophrastus, legendos pertinacia an nam.</p>
          </div>
          <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
            <p>Partiendo voluptatibus ex cum, sed erat fuisset ne, cum ex meis volumus mentitum. Alienum pertinacia maiestatis ne eum, verear persequeris et vim. Mea cu dicit voluptua efficiantur, nullam labitur veritus sit cu. Eum denique omittantur te, in justo epicurei his, eu mei aeque populo. Cu pro facer sententiae, ne brute graece scripta duo. No placerat quaerendum nec, pri alia ceteros adipiscing ut. Quo in nobis nostrum intellegebat. Ius hinc decore erroribus eu, in case prima exerci pri. Id eum prima adipisci. Ius cu minim theophrastus, legendos pertinacia an nam.</p>
            <p>Instant Iisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. Mutat tacimates id sit. Ridens mediocritatem ius an, eu nec magna imperdiet. Mediocrem qualisque in has. Enim utroque perfecto id mei, ad eam tritani labores facilisis, ullum sensibus no cum. Eius eleifend in quo. At mei alia iriure propriae.</p>
          </div>
        </div>
      </div>
    </div> --}}
    {{-- <section class="bg-white shadow-md p-4">
      <div class="container">
        <h3 class="text-6 mb-4 text-center">Our Airlines partner</h3>
        <div class="owl-carousel owl-theme" data-autoplay="true" data-loop="true" data-margin="10" data-items-xs="2" data-items-sm="3" data-items-md="4" data-items-lg="6">
          <div class="item"><a href="#"><img class="img-fluid" src='{{asset("frontEnd/images/brands/flights/airlines-1.png")}}' alt="airlines 1" /></a></div>
          <div class="item"><a href="#"><img class="img-fluid" src='{{asset("frontEnd/images/brands/flights/airlines-2.png")}}' alt="airlines 2" /></a></div>
          <div class="item"><a href="#"><img class="img-fluid" src='{{asset("frontEnd/images/brands/flights/airlines-3.png")}}' alt="airlines 3" /></a></div>
          <div class="item"><a href="#"><img class="img-fluid" src='{{asset("frontEnd/images/brands/flights/airlines-4.png")}}' alt="airlines 4" /></a></div>
          <div class="item"><a href="#"><img class="img-fluid" src='{{asset("frontEnd/images/brands/flights/airlines-5.png")}}' alt="airlines 5" /></a></div>
          <div class="item"><a href="#"><img class="img-fluid" src='{{asset("frontEnd/images/brands/flights/airlines-7.png")}}' alt="airlines 6" /></a></div>
          <div class="item"><a href="#"><img class="img-fluid" src='{{asset("frontEnd/images/brands/flights/airlines-8.png")}}' alt="airlines 7" /></a></div>
          <div class="item"><a href="#"><img class="img-fluid" src='{{asset("frontEnd/images/brands/flights/airlines-12.png")}}' alt="airlines 11" /></a></div>
        </div>
      </div>
    </section> --}}
    <!-- Mobile App -->
    <section class="section pb-0">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 text-center"> <img class="img-fluid" alt="" src='{{asset("frontEnd/images/24-app-banner-2.png")}}' style="height: 362px;" > </div>
          <div class="col-lg-6 text-center text-lg-start">
            <h2 class="text-9 fw-600 my-4">
              {{-- {{__('lang.download_our_24flights')}} --}}
              {{__('lang.24flights_best_mobile_app_for_flight_booking')}}
              <br class="d-none d-lg-inline-block">
              {{-- {{__('lang.mobile_app')}} </h2> --}}
            <p class="lead">{{__('lang.download_description')}}</p>
            <div class="pt-3"> <a class="me-4" href="https://apps.apple.com/kw/app/24-flights/id1466042184"><img alt="" src='{{asset("frontEnd/images/app-store.png")}}'></a><a href="https://play.google.com/store/apps/details?id=com.ni.tfflights"><img alt="" src='{{asset("frontEnd/images/google-play-store.png")}}'></a> </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Mobile App end --> 
  </div>
  <!-- Content end --> 

  @if((!empty($popUp)) && $popUp->pop_up_status == 'active')
    <!-- Modal HTML -->
      <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content" style="background-color: transparent;border-radius: 20px;">
            <div class="modal-body" style=" position: relative;padding: 0;">
              <!-- Close button (cross symbol) -->
              <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close" onclick="closePopup()">
                &times;
              </button>
              <!-- Image inside modal -->
              <img src="{{ asset('uploads/ads/'.$popUp->pop_up_image) }}" class="img-fluid" alt="Popup Image" style="width: 100%;height: auto;display: block;border-radius: 20px;">
            </div>
          </div>
        </div>
      </div>
  @endif

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
  
    // $(document).ready(function(){
    //   $("#bookingFlight").on("submit", function(){
    //     $("#searchbutton").prop('disabled',true);
    //     $("#searchbutton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
    //   });//submit
    // });//document ready

  
    $(function() {
        'use strict';
        // Autocomplete

        //flightfrom
        var airuplogo = "{{asset('frontEnd/images/image.png')}}";
        var airdownlogo = "{{asset('frontEnd/images/image.png')}}";
        var returndateSartFrom = moment();
        // $('#flightFrom').autocomplete({
        //     minLength: 3,
        //     //delay: 50,
        //     source: function( request, response ) {
        //         $.ajax({
        //         url: "{{route('autoSuggest')}}",
        //         dataType: "json",
        //         data: {
        //             q: request.term
        //         },
        //         success: function( data ) {
        //             //response(data);
        //             response($.map(data, function (item) {
        //                 return {
        //                     label: item.display_name,
        //                     value: item.display_name,
        //                     code: item.airport_code,
        //                     city_name: item.city_name,
        //                     country_name:item.country_name,
        //                     airport_name:item.name
        //                 };
        //             }));
        //         },
        //         });
        //     },
        //     select: function( event, ui ) {
        //         $("input[name='flightFromAirportCode']").val(ui.item.code);
        //         $("#flightTo").focus();
        //     },
        //     search  : function(){$(this).addClass('preloader');},
        //     open    : function(){$(this).removeClass('preloader');}
        // }).data( "ui-autocomplete" )._renderItem = function( ul, item ) 
        // {  
        //   return $( "<li dir='ltr' role='presentation' tabindex='0' class='sc-iUKqMP hlZHGM'></li>" )  
        //       .data( "item.autocomplete", item )  
        //       .append( '<div class="sc-iAKWXU iyyKqe"><div class="sc-efQSVx iQoDho"><span class="sc-cTAqQK fywikg"><img src="'+airuplogo+'" alt="flight Icon" width="25px"style="margin-top:7px"></span><div class="sc-jObWnj dmPlWU"><p class="sc-dPiLbb kUaZDb"><span class="autoCompleteTitle ">'+item.city_name+', '+item.country_name+'&nbsp;</span> <span class="autoCompleteSubTitle">('+item.code+')</span></p><p class="sc-bBHHxi cTvqKV">'+item.airport_name+'</p></div></div></div>' )  
        //       .appendTo( ul );  
        // };  
        // //flightTo
       

        // $('#flightTo').autocomplete({
        //     minLength: 3,
        //     delay: 10,
        //     source: function( request, response ) {
        //         var except = $("input[name='flightFromAirportCode']").val();
        //         $.ajax({
        //         url: "{{route('autoSuggest')}}",
        //         dataType: "json",
        //         data: {
        //             q: request.term,
        //             ff:except,
        //         },
        //         success: function( data ) {
        //             //response(data);
        //             response($.map(data, function (item) {
        //                 console.log(item);
        //                 return {
        //                     label: item.display_name,
        //                     value: item.display_name,
        //                     code: item.airport_code,
        //                     city_name: item.city_name,
        //                     country_name:item.country_name,
        //                     airport_name:item.name
        //                 };
        //             }));
        //         },
        //         });
        //     },
        //     select: function( event, ui ) {
        //         $("input[name='flightToAirportCode']").val(ui.item.code);
        //         $("#flightDepart").focus();
        //     },
            
        // }).data( "ui-autocomplete" )._renderItem = function( ul, item ) 
        // {
        //   return $( "<li role='presentation' dir='ltr' tabindex='0' class='sc-iUKqMP hlZHGM'></li>" )  
        //       .data( "item.autocomplete", item )  
        //       .append( '<div class="sc-iAKWXU iyyKqe"><div class="sc-efQSVx iQoDho"><span class="sc-cTAqQK fywikg"><img src="'+airuplogo+'" alt="flight Icon" width="25px"style="margin-top:7px"></span><div class="sc-jObWnj dmPlWU"><p class="sc-dPiLbb kUaZDb"><span class="autoCompleteTitle ">'+item.city_name+', '+item.country_name+'&nbsp;</span> <span class="autoCompleteSubTitle">('+item.code+')</span></p><p class="sc-bBHHxi cTvqKV">'+item.airport_name+'</p></div></div></div>' )  
        //       .appendTo( ul );  
        // };
        
        // Depart Date
        $('#flightDepart').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            // minDate: moment().add(1, 'day'),
            minDate: moment(),
            autoUpdateInput: false,
            locale: {
              format: 'YYYY-MM-DD'
            },
          
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

        $('#flightReturn').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            minDate: moment(),
            autoUpdateInput: false,
        }, function(chosen_date) {
            $('#flightReturn').val(chosen_date.format('YYYY-MM-DD'));
        });

        //hotelserach
       $('#hotelsCityName').autocomplete({
          minLength: 3,
          source: function(request, response) {
              $.ajax({
                  url: "{{route('hotelCityAutoSuggest')}}",
                  dataType: "json",
                  data: {
                      q: request.term
                  },
                  success: function(data) {
                      response($.map(data, function(item) {
                          return {
                              label: item.display_name,
                              value: item.display_name,
                              code: item.code,
                              city_name: item.name,
                              country_name: item.country_name,
                          };
                      }));
                  },
              });
          },
          select: function(event, ui) {
              $("input[name='hotelsCityCode']").val(ui.item.code);
              $("#hotelsCheckIn").focus();
          },
          search: function() { $(this).addClass('preloader'); },
          open: function() { $(this).removeClass('preloader'); }
      });

      // Wait until DOM is ready and autocomplete is initialized
      $(function() {
          var autocomplete = $('#hotelsCityName').data('ui-autocomplete');
          if (autocomplete) {
              autocomplete._renderItem = function(ul, item) {
                  return $("<li dir='ltr' role='presentation' tabindex='0' class='sc-iUKqMP hlZHGM'></li>")
                      .data("item.autocomplete", item)
                      .append(
                          '<div class="sc-iAKWXU iyyKqe">' +
                              '<div class="sc-efQSVx iQoDho">' +
                                  '<div class="sc-jObWnj dmPlWU">' +
                                      '<p class="sc-dPiLbb kUaZDb">' +
                                          '<span class="autoCompleteTitle">' + item.label + '&nbsp;</span>' +
                                      '</p>' +
                                      '<p class="sc-bBHHxi cTvqKV">' + item.country_name + '</p>' +
                                  '</div>' +
                              '</div>' +
                          '</div>'
                      )
                      .appendTo(ul);
              };
          }
      });

        
         // Depart Date
         $('#hotelsCheckIn').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            // minDate: moment().add(1, 'day'),
            minDate: moment(),
            autoUpdateInput: false,
            locale: {
              format: 'YYYY-MM-DD'
            },
          
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
                
                //  $("#nationality-id").show();
                console.log("456");
                $("#hotelsTravellersClass").trigger( "click" );

            });

            $("#hotelsCheckOut" ).trigger( "click" );
        
        });

        $('#hotelsCheckOut').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            minDate: moment(),
            autoUpdateInput: false,
        }, function(chosen_date) {
            $('#hotelsCheckOut').val(chosen_date.format('YYYY-MM-DD'));
        });

        $('#nationality-id').change(function() {
          console.log("sd");
          var selectedOption = $(this).val();
          console.log(selectedOption);
          // $("#hotelsTravellersClass").trigger( "click" );
          $('.travellers-dropdown').slideToggle('fast');
          // do something with selected option
        });
        // $('#nationality-id').change(function() {
            
        //   $("#hotelsTravellersClass").trigger( "click" );
          
        // });

    });

    $('input:radio[name="flight-trip"]').change(function() {
        if ($(this).val() == 'roundtrip') {
            $('#flightReturn').prop("disabled",false);
            $('#flightReturn').prop("required",true);
        } else {
            $('#flightReturn').prop("disabled",true);
            $('#flightReturn').prop("required",false);
        }
    });


    let url = '{{ route("pnr") }}';

    $('#serachpnrfrom').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        type: 'get',
        url: url,
        data: {
          'pnr' : $("#pnr").val()
        },
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $("#serachpnrfromsubmit").prop('disabled',true);
                $("#serachpnrfromsubmit").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
            },
        success: function (response) {
          $("#pnr").val('');
          $("#flight-1").modal('hide');
          $(".ticketdetails").html(response.html);
          $("#flight-2").modal('show');
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
              $("#serachpnrfromsubmit").prop('disabled',false);
              $("#serachpnrfromsubmit").find('span').html( '' );
            },
        error:function(response){
          $('#pnrerror').text(response.responseJSON.message);
          $("#pnrerror").css('display','block');
        }
      });

      });
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
    function printDiv() 
    {
      var divContents = $('.ticketdetails').html();
      var a = window.open('', '', 'height=500, width=500');
      //a.document.write('<html>');
      // a.document.write('<body > <h1>Div contents are <br>');
      a.document.write(divContents);
      //a.document.write('</body></html>');
      //a.document.close();
      a.print();
    }
    $('.hotelguestsdone').on('click', function() {
      $("#nationality-id").focus();
    });
    $(document).ready(function() {
    $('#flight-1').on('show.bs.modal', function (event) {
      // You can add custom logic here if needed
      console.log('Modal is about to be shown');
      console.log($('.modal-backdrop').remove());
      $('.modal-backdrop').html("ss")
    });

    $('#flight-1').on('hide.bs.modal', function (event) {
      // You can add custom logic here if needed
      console.log('Modal is about to be hidden');
      $('.modal-backdrop').remove();
    });
  });


    // Function to close the popup and set a cookie
    function closePopup() {
        setCookie('popupDisplayed', 'true', 1); // Set the cookie for 1 day
        $('#popupModal').modal('hide'); // Close the modal
    }

    // // Function to set a cookie using jQuery
    // function setCookie(cname, cvalue, exdays) {
    //     const d = new Date();
    //     d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    //     const expires = 'expires=' + d.toUTCString();
    //     document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
    // }

    // // Function to get a cookie value using jQuery
    // function getCookie(cname) {
    //     const name = cname + '=';
    //     const decodedCookie = decodeURIComponent(document.cookie);
    //     const ca = decodedCookie.split(';');
    //     for (let i = 0; i < ca.length; i++) {
    //         let c = ca[i].trim();
    //         if (c.indexOf(name) == 0) {
    //             return c.substring(name.length, c.length);
    //         }
    //     }
    //     return '';
    // }

    // // Show popup only if the cookie is not set
    // $(document).ready(function () {
    //     const popupDisplayed = getCookie('popupDisplayed');
    //     if (popupDisplayed != 'true') {
    //         $('#popupModal').modal('show');
    //     }
    //     $('#popupModal').modal('show');
    // });
    // Function to close the popup
    function closePopup() {
          $('#popupModal').modal('hide'); // Close the modal
          sessionStorage.setItem('popupDisplayed', 'true'); // Store a flag in sessionStorage
      }

      // Show popup only if the sessionStorage item is not set (i.e., first visit in this session)
      $(document).ready(function () {
          if (!sessionStorage.getItem('popupDisplayed')) {
              $('#popupModal').modal('show');
          }
      });
</script>
<script src='{{ asset('frontEnd/js/hotel.js') }}'></script>
<script src='{{ asset('frontEnd/js/flight.js') }}'></script>
@endsection
