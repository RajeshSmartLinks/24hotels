@extends('front_end.layouts.master')
@section('content')

<!-- Page Header
============================================= -->
<section class="page-header page-header-dark bg-secondary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>{{__('lang.dashboard')}}</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{{Url('/')}}">Home</a></li>
          <li class="active">{{__('lang.dashboard')}}</li>
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
        @include('front_end.user.user_menu')
      <div class="col-lg-9">
        <div class="row g-4 pb-4">
            <div class="col-lg-3">
                <div class="bg-white shadow-sm rounded pt-3 pb-0 px-4">
                  <div class="row g-0">
                    <div class="col text-center text-sm-start">
                        <div class="">
                            <h5 class="text-3 text-body pb-2">{{__('lang.today_sale')}} </h5>
                            <div class="card-text">
                                <dl class="row">
                                    <dt class="col-sm-6 col-6" style = "font-size: small">{{__('lang.total_sale')}} :</dt>
                                    <dd class="col-sm-6 col-6"> ({{$info['totaltodaySalesCount']}}/{{$info['totaltodaySalesAmount']}}) </dd>
                                </dl>
                                {{-- <dl class="row">
                                    <dt class="col-sm-6 col-6" style = "font-size: small"> {{__('lang.flights')}}  :</dt>
                                    <dd class="col-sm-6 col-6"> ({{$info['todayFlightSalesCount']}}/{{$info['todayFlightSalesAmount']}}) </dd>
                                </dl> --}}
                                <dl class="row">
                                    <dt class="col-sm-6 col-6" style = "font-size: small"> {{__('lang.hotels')}} :</dt>
                                    <dd class="col-sm-6 col-6"> ({{$info['todayHotelSalesCount']}}/{{$info['todayHotelSalesAmount']}}) </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="bg-white shadow-sm rounded pt-3 pb-0 px-4">
                  <div class="row g-0">
                    <div class="col text-center text-sm-start">
                        <div class="">
                            <h5 class="text-3 text-body pb-2">{{__('lang.monthly_sale')}}</h5>
                            <div class="card-text">
                                <dl class="row">
                                    <dt class="col-sm-6 col-6" style = "font-size: small"> {{__('lang.total_sale')}} :</dt>
                                    <dd class="col-sm-6 col-6"> ({{$info['totalmonthlySalesCount']}}/{{$info['totalmonthlySalesAmount']}}) </dd>
                                </dl>
                                {{-- <dl class="row">
                                    <dt class="col-sm-6 col-6" style = "font-size: small"> {{__('lang.flights')}} :</dt>
                                    <dd class="col-sm-6 col-6"> ({{$info['monthlyFlightSalesCount']}}/{{$info['monthlyFlightSalesAmount']}}) </dd>
                                </dl> --}}
                                <dl class="row">
                                    <dt class="col-sm-6 col-6" style = "font-size: small"> {{__('lang.hotels')}} :</dt>
                                    <dd class="col-sm-6 col-6"> ({{$info['monthlyHotelSalesCount']}}/{{$info['monthlyHotelSalesAmount']}}) </dd>
                                </dl>
                            </div>
                          </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="bg-white shadow-sm rounded pt-3 pb-0 px-4">
                  <div class="row g-0">
                    <div class="col text-center text-sm-start">
                      <div class="">
                        <h5 class="text-3 text-body pb-2">{{__('lang.total_sale')}}</h5>
                        <div class="card-text">
                            <dl class="row">
                                <dt class="col-sm-6 col-6" style = "font-size: small"> {{__('lang.total_sale')}} :</dt>
                                <dd class="col-sm-6 col-6"> ({{$info['totalSalesCount']}}/{{$info['totalSalesAmount']}}) </dd>
                            </dl>
                            {{-- <dl class="row">
                                <dt class="col-sm-6 col-6" style = "font-size: small"> {{__('lang.flights')}} :</dt>
                                <dd class="col-sm-6 col-6"> ({{$info['totalFlightSalesCount']}}/{{$info['totalFlightSalesAmount']}}) </dd>
                            </dl> --}}
                            <dl class="row">
                                <dt class="col-sm-6 col-6" style = "font-size: small"> {{__('lang.hotels')}} :</dt>
                                <dd class="col-sm-6 col-6"> ({{$info['totalHotelSalesCount']}}/{{$info['totalHotelSalesAmount']}}) </dd>
                            </dl>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="bg-white shadow-sm rounded pt-3 pb-0 px-4">
                  <div class="row g-0">
                    <div class="col text-center text-sm-start">
                      <div class="">
                        <h5 class="text-3 text-body pb-2">{{__('lang.wallet')}}</h5>
                        <div class="card-text">
                            <dl class="row">
                                <dt class="col-sm-8 col-8" style = "font-size: small">{{__('lang.total_recharge')}} :</dt>
                                <dd class="col-sm-4 col-4"> {{$info['totalRecharge']}} </dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-8 col-8" style = "font-size: small">{{__('lang.total_use')}} :</dt>
                                <dd class="col-sm-4 col-4"> {{$info['totalUse']}} </dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-8 col-8" style = "font-size: small">{{__('lang.balance_avai')}} :</dt>
                                <dd class="col-sm-4 col-4"> {{$info['availableWalletBalance']}} </dd>
                            </dl>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        <div class="bg-white shadow-md rounded p-4"> 
          <!-- Orders History
          ============================================= -->
          <div class="row"> <div class="col-8"><h4 class="mb-9">{{__('lang.today_bookings')}} ( {{ now()->format('d M Y') }})</h4></div>  <div class="col-4"><h5 class=""> {{__('lang.amount')}} : KWD {{auth()->user()->wallet_balance}}</h5></div></div>
		  <hr class="mx-n4">
            {{-- <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item"> 
                    <a class="nav-link {{ $activeTab == 'flight-tab' ? 'active' : '' }} " id="flight-tab"  href="{{ route('agent-dashboard', ['tab' => 'flight-tab']) }}" role="tab" aria-controls="first" aria-selected="false">{{__('lang.flights')}} </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link {{ $activeTab == 'hotel-tab' ? 'active' : '' }}" id="hotel-tab"  href="{{ route('agent-dashboard', ['tab' => 'hotel-tab']) }}" role="tab" aria-controls="second" aria-selected="false">{{__('lang.hotels')}} </a> 
                </li>
            </ul> --}}
            <div class="tab-content my-3" id="myTabContent">
              @if (Session::has('success'))
              <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
              </div>
              @endif
              @if (Session::has('error'))
              <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
              </div>
              @endif
              
              
              {{-- <div class="tab-pane fade {{ $activeTab == 'flight-tab' ? 'show active' : '' }}" id="first"  aria-labelledby="flight-tab">
                <div class="table-responsive-md">
                  <table class="table table-hover border">
                    <thead>
                      <tr>
                        <th>SrNo</th>
                        <th>Flight</th>
                        <th class="text-center">Customer</th>
                        <th class="text-end">Contact No</th>
                        <th class="text-center">Email</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($userbookings) > 0)
                          @foreach($userbookings as $bookingdetails)
                          <tr>
                            <td class="align-middle">{{$loop->iteration}}</td>
                            <td class="align-middle"><img src="https://www.gstatic.com/flights/airline_logos/70px/{{$bookingdetails->carrier}}.png" class="img-thumbnail d-inline-flex me-1"></td>
                            <td class="align-middle">{{$bookingdetails->TravelersInfo[0]->first_name ?? '' }}&nbsp;{{$bookingdetails->TravelersInfo[0]->last_name ?? '' }} </td>
                            <td class="align-middle">{{$bookingdetails->Customercountry->phone_code ?? ''}} &nbsp;{{$bookingdetails->mobile}} </td>
                            <td class="align-middle">{{$bookingdetails->email }} </td>
                            <td class="align-middle">{{$bookingdetails->currency_code ." ".$bookingdetails->total_amount }}</td>
                            <td class="align-middle">{{str_replace("_"," ",$bookingdetails->booking_status) }}</td>
                            <td class="align-middle text-end">
                                @if(!empty($bookingdetails->flight_ticket_path))
                                <a  href = "{{asset($bookingdetails->flight_ticket_path)}}" download data-bs-toggle="tooltip" title="Download Ticket"><i class="fas fa-download"></i></a>
                                @endif
                                @if(!empty($bookingdetails->invoice_path))
                                <a  href = "{{asset($bookingdetails->invoice_path)}}" download data-bs-toggle="tooltip" title="Download Invoice"><i class="fas fa-file-invoice"></i></a>
                                @endif
                               
                                @if($bookingdetails->ticket_status == 1 && $bookingdetails->booking_status == "booking_completed" && $bookingdetails->is_cancel != 1 )
                                <a  href = "#" onclick="togglePopup({{$bookingdetails->id}})" data-bs-toggle="tooltip" title="{{__('lang.cancel_Reschedule')}}"><i class="fas fa-times-circle"></i></a>
                                @endif
                             
                                
                            </td>
                            </tr>
                          @endforeach
                      @else
                          <tr align="center" class="alert alert-danger">
                              <td colspan="8">{{__('lang.no_records')}}</td>
                          </tr>
                      @endif
                     
                    </tbody>
                  </table>
                  {{ $userbookings->appends(['tab' => 'flight-tab'])->links() }}
                 
                </div>
              </div> --}}

              <div class="tab-pane fade show active" id="second"  aria-labelledby="hotel-tab">
                <div class="table-responsive-md">
                  <table class="table table-hover border">
                    <thead>
                      <tr>
                        <th>SrNo</th>
                        <th>Hotel</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Contact No</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
  
                     
  
                      @if(count($hotelbookings) > 0)
                      @foreach($hotelbookings as $hoteldetails)
                      <tr>
                        <td class="align-middle">{{$loop->iteration}}</td>
                        <td class="align-middle">{{$hoteldetails->hotel_name}}</td>
                        <td class="align-middle">{{$hoteldetails->TravelersInfo[0]->first_name ?? '' }}&nbsp;{{$hoteldetails->TravelersInfo[0]->last_name ?? '' }} </td>
                        <td class="align-middle">{{$hoteldetails->Customercountry->phone_code ?? ''}} &nbsp;{{$hoteldetails->mobile}} </td>
                        <td class="align-middle">{{$hoteldetails->email }} </td>
                        <td class="align-middle">{{$hoteldetails->currency_code ." ".$hoteldetails->total_amount }}</td>
                
                    
                        <td class="align-middle text-center">
                          @if(isset($hoteldetails->hotelReservation->reservation_status) && $hoteldetails->hotelReservation->reservation_status  == 'Confirmed')
                          <i class="fas fa-check-circle text-4 text-success" data-bs-toggle="tooltip" title="Your Hotel Reservation is Successful"></i>
                          @elseif(isset($hoteldetails->hotelReservation->reservation_status) && $hoteldetails->hotelReservation->reservation_status == 'Pending')
                          <i class="fas fa-ellipsis-h text-4 text-info" data-bs-toggle="tooltip" title="" data-bs-original-title="Your Hotel Reservation is in Progress" aria-label="Your order is in Progress"></i>
                          @elseif(isset($hoteldetails->hotelReservation->reservation_status) &&  $hoteldetails->hotelReservation->reservation_status == 'Failure')
                          <i class="fas fa-times-circle text-4 text-danger" data-bs-toggle="tooltip" title="" data-bs-original-title="Your order is Failed" aria-label="Your order is Failed"></i>
                          @else
                          {{str_replace("_"," ",$hoteldetails->booking_status) }}
                          @endif
  
                        </td>
           
                        <td class="align-middle text-center">
                          @if(!empty($hoteldetails->hotel_room_booking_path))
                          <a  href = "{{asset($hoteldetails->hotel_room_booking_path)}}" download data-bs-toggle="tooltip" title="Download"><i class="fas fa-download"></i></a>
                          @endif
                           @if(!empty($hoteldetails->booking_status == 'booking_completed'))
                          {{-- <a   class="fas fa-times-circle text-4 text-danger" data-bs-toggle="tooltip" title="Cancle / change Booking"  onclick="confirmCancel()" href="javascript:void(0);" ></a> --}}
                          <a  href = "#" onclick="togglePopup({{$hoteldetails->id}})" data-bs-toggle="tooltip" title="Cancle / change Booking"><i class="fas fa-times-circle"></i></a>
                          
                          @endif
                          {{-- @if(!empty($hoteldetails->invoice_path))
                          <a  href = "{{asset($hoteldetails->invoice_path)}}" download data-bs-toggle="tooltip" title="Download Invoice"><i class="fas fa-file-invoice"></i></a>
                          @endif --}}
                          {{-- @can('booking-cancel') --}}
                          {{-- @if($hoteldetails->ticket_status == 1 && $hoteldetails->booking_status == "booking_completed" && $hoteldetails->is_cancel != 1 )
                          <a  href = "#" onclick="togglePopup({{$hoteldetails->id}})" data-bs-toggle="tooltip" title="{{__('lang.cancel_Reschedule')}}"><i class="fas fa-times-circle"></i></a>
                          @endif --}}
                          {{-- @endcan --}}
                          
                      </td>
                      </tr>
                      @endforeach
                  @else
                      <tr align="center" class="alert alert-danger">
                          <td colspan="8">{{__('lang.no_records')}}</td>
                      </tr>
                  @endif
                    </tbody>
                  </table>
                  {{ $hotelbookings->appends(['tab' => 'hotel-tab'])->links() }}
                </div>
              </div>

            </div>
          
          <!-- Orders History end --> 
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 

  <div id="canclemodel" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="    width: 33%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cancle / change Booking</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="flight-details ">
            {{-- <div class="col-3"></div> --}}
            <div class="col-12">
              <div class="text-5 fw-500 text-center mb-4">
                <div class="mb-1">{{__('lang.i_want_to_request_you_to')}}</div>
                <div class="mb-1">Cancle / change Booking</div>
                <div class="mb-1">My Hotel Booking</div>
              </div>

              <div class="text-2 fw-300 text-center mb-4 text-muted">
                <div class="mb-1">{{__('lang.our_travel_desk_will_call_you_in_few_minitues')}}</div>
                <div class="mb-1">{{__('lang.on_your_request_to_confirm')}}</div>
                <div class="mb-1">({{__('lang.or')}})</div>
                <div class="mb-1">{{__('lang.you_can_contact_for_immediate_response')}}</div>
              </div>
              
              <div class="text-center"> 
                {{-- <a href="#" onclick="cancle()" class="btn btn-primary rounded-pill"><i class="fas fa-shopping-cart d-block d-lg-none"></i> <span class="d-none d-lg-block">Confirm</span></a> --}}
                <form  method="post" action="{{url('hotelBookingcancellation')}}" id ="cancellationForm">
                  @csrf
                  <input type="hidden" id="bookingId" name="bookingId">
                  <div class="d-grid my-4">
                    <button class="btn btn-primary cancellationConfirmationButton" type="submit"><span></span>{{__('lang.confirm')}}</button>
                  </div>
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
$(document).ready(function(){
  $("#cancellationForm").on("submit", function(){
    $(".cancellationConfirmationButton").prop('disabled',true);
    $(".cancellationConfirmationButton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
  });//submit
});//document ready

function togglePopup($bookingId)
{
  $("#bookingId").val($bookingId);
  $("#canclemodel").modal('show');
}
function cancle()
{
  $bookingId = $("#bookingId").val();
} 

</script>
@endsection