@extends('front_end.layouts.master')
@section('content')

<!-- Page Header
============================================= -->
<section class="page-header page-header-dark bg-secondary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>My Profile</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{{Url('/')}}">Home</a></li>
          <li class="active">My Profile</li>
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
      <div class="col-lg-10">
        <div class="bg-white shadow-md rounded p-4"> 
          <!-- Orders History
          ============================================= -->
          <h4 class="mb-4">Booking History</h4>
		      <hr class="mx-n4">
         
          <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            {{-- <li class="nav-item"> <a class="nav-link active" id="first-tab" data-bs-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">All</a> </li> --}}
            {{-- <li class="nav-item"> <a class="nav-link" id="second-tab" data-bs-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Recharge & Bill Payment</a> </li> --}}
            <li class="nav-item"> <a class="nav-link active" id="third-tab" data-bs-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">Booking</a> </li>
            <li class="nav-item"> <a class="nav-link" id="second-tab" data-bs-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Hotel Booking</a> </li>
          </ul>
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
            {{-- <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Order ID</th>
                      <th class="text-center">Status</th>
                      <th class="text-end">Amount</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="align-middle">06/06/2018</td>
                      <td class="align-middle"><img src="images/brands/operator/vodafone.jpg" class="img-thumbnail d-inline-flex me-1"> <span class="text-1 d-inline-flex">Recharge of Vodafone Mobile 9696969696</span></td>
                      <td class="align-middle">5286977475</td>
                      <td class="align-middle text-center"><i class="fas fa-check-circle text-4 text-success" data-bs-toggle="tooltip" title="Your order is Successful"></i></td>
                      <td class="align-middle text-end">$150</td>
                      <td class="align-middle text-center"><a href="#" data-bs-toggle="tooltip" title="Repeat Order"><i class="fas fa-redo-alt"></i></a></td>
                    </tr>
                    <tr>
                      <td class="align-middle">02/06/2018</td>
                      <td class="align-middle"><img src="images/brands/flights/indigo.png" class="img-thumbnail d-inline-flex me-1"> <span class="text-1 d-inline-flex">Booking of Delhi to Sydney flight</span></td>
                      <td class="align-middle">5136907172</td>
                      <td class="align-middle text-center"><i class="fas fa-check-circle text-4 text-success" data-bs-toggle="tooltip" title="Your order is Successful"></i></td>
                      <td class="align-middle text-end">$980</td>
                      <td class="align-middle text-center"><a href="#" data-bs-toggle="tooltip" title="Repeat Order"><i class="fas fa-redo-alt"></i></a></td>
                    </tr>
                    <tr>
                      <td class="align-middle">31/05/2018</td>
                      <td class="align-middle"><img src="images/brands/operator/vodafone.jpg" class="img-thumbnail d-inline-flex me-1"> <span class="text-1 d-inline-flex">Bill Payment of Vodafone Mobile 9898989898</span></td>
                      <td class="align-middle">1072317951</td>
                      <td class="align-middle text-center"><i class="fas fa-ellipsis-h text-4 text-info" data-bs-toggle="tooltip" title="Your order is in Progress"></i></td>
                      <td class="align-middle text-end">$99</td>
                      <td class="align-middle text-center"></td>
                    </tr>
                    <tr>
                      <td class="align-middle">25/05/2018</td>
                      <td><div class="d-lg-flex align-items-center"> <span class="img-thumbnail d-inline-flex text-8 p-2 me-2"><i class="fas fa-bus"></i></span> <span class="text-1 d-inline-flex">Booking of Mumbai to Surat Bus</span> </div></td>
                      <td class="align-middle">4103520927</td>
                      <td class="align-middle text-center"><i class="fas fa-check-circle text-4 text-success" data-bs-toggle="tooltip" title="Your order is Successful"></i></td>
                      <td class="align-middle text-end">$450</td>
                      <td class="align-middle text-center"><a href="#" data-bs-toggle="tooltip" title="Repeat Order"><i class="fas fa-redo-alt"></i></a></td>
                    </tr>
                    <tr>
                      <td class="align-middle">21/05/2018</td>
                      <td class="align-middle"><img src="images/brands/operator/vodafone.jpg" class="img-thumbnail d-inline-flex me-1"> <span class="text-1 d-inline-flex">Recharge of Vodafone Mobile 9898989898</span></td>
                      <td class="align-middle">3079317986</td>
                      <td class="align-middle text-center"><i class="fas fa-times-circle text-4 text-danger" data-bs-toggle="tooltip" title="Your order is Failed"></i></td>
                      <td class="align-middle text-end">$280</td>
                      <td class="align-middle text-center"><a href="#" data-bs-toggle="tooltip" title="Retry Order"><i class="fas fa-redo-alt "></i></a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="text-center pt-3"><a href="#" class="btn btn-outline-primary shadow-none">View More</a></div>
            </div> --}}
            <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead>
                    <tr>
                      <th>Booking On</th>
                      {{-- <th>Description</th> --}}
                      <th>Order ID</th>
                      <th class="text-center">Status</th>
                      <th class="text-end">Amount</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                   

                    @if(count($hotelbookings) > 0)
                    @foreach($hotelbookings as $hoteldetails)
                    <tr>
                      <td class="align-middle">{{$hoteldetails->created_at->format('d/m/Y')}}</td>
                      {{-- <td class="align-middle"><img src="images/brands/operator/vodafone.jpg" class="img-thumbnail d-inline-flex me-1"> <span class="text-1 d-inline-flex">Recharge of Vodafone Mobile 9696969696</span></td> --}}
                      <td class="align-middle">{{$hoteldetails->booking_ref_id}}</td>
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
                      <td class="align-middle text-end">{{$hoteldetails->currency_code }} {{$hoteldetails->total_amount}}</td>
                      <td class="align-middle text-center">
                        @if(!empty($hoteldetails->hotel_room_booking_path))
                        <a  href = "{{asset($hoteldetails->hotel_room_booking_path)}}" download data-bs-toggle="tooltip" title="Download"><i class="fas fa-download"></i></a>
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
                        <td colspan="6">{{__('lang.no_records')}}</td>
                    </tr>
                @endif
                  </tbody>
                </table>
              </div>
            </div>
            
            <div class="tab-pane fade show active" id="third" role="tabpanel" aria-labelledby="third-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead>
                    <tr>
                      <th>Booking Date</th>
                      <th>Journey</th>
                      {{-- <th>Trip Type</th> --}}
                      <th>Booking ID</th>
                      {{-- <th>From</th>
                      <th>To</th> --}}
                      <th class="text-center">Status</th>
                      <th class="text-center">Amount</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($userbookings) > 0)
                        @foreach($userbookings as $bookingdetails)
                        <tr>
                        <td class="align-middle">{{$bookingdetails->created_at->format('d/m/Y')}}</td>
                        <td  class="align-middle">
                          <a  href = "#" download data-bs-toggle="tooltip" title="{{$bookingdetails->fromAirport->name ?? ''}}">{{$bookingdetails->from}}</a>
                          @if($bookingdetails->booking_type == "roundtrip")
                          <i data-bs-toggle="tooltip" title="Round Trip" class="fas fa-exchange-alt arrowicon"></i> 
                          @else
                          <i data-bs-toggle="tooltip" title="One Way" class="fas fa-arrow-right"></i>
                          @endif
                          <a  href = "#" download data-bs-toggle="tooltip" title="{{$bookingdetails->toAirport->name ?? ''}}">{{$bookingdetails->to}}</a>
                        </td>
                        {{-- <td class="align-middle">{{$bookingdetails->booking_type}}</td> --}}
                        <td class="align-middle">{{$bookingdetails->booking_ref_id}}</td>
                        {{-- <td class="align-middle">{{$bookingdetails->from}}</td>
                        <td class="align-middle">{{$bookingdetails->to}}</td> --}}
                        <td class="align-middle">{{str_replace("_"," ",$bookingdetails->booking_status) }}</td>
                        <td class="align-middle text-end">{{$bookingdetails->currency_code ." ".$bookingdetails->total_amount }}</td>
                        
                        
                        <td class="align-middle text-center">
                            @if(!empty($bookingdetails->flight_ticket_path))
                            <a  href = "{{asset($bookingdetails->flight_ticket_path)}}" download data-bs-toggle="tooltip" title="Download Ticket"><i class="fas fa-download"></i></a>
                            @endif
                            @if(!empty($bookingdetails->invoice_path))
                            <a  href = "{{asset($bookingdetails->invoice_path)}}" download data-bs-toggle="tooltip" title="Download Invoice"><i class="fas fa-file-invoice"></i></a>
                            @endif
                            {{-- @can('booking-cancel') --}}
                            @if($bookingdetails->ticket_status == 1 && $bookingdetails->booking_status == "booking_completed" && $bookingdetails->is_cancel != 1 )
                            <a  href = "#" onclick="togglePopup({{$bookingdetails->id}})" data-bs-toggle="tooltip" title="{{__('lang.cancel_Reschedule')}}"><i class="fas fa-times-circle"></i></a>
                            @endif
                            {{-- @endcan --}}
                            
                        </td>
                        </tr>
                        @endforeach
                    @else
                        <tr align="center" class="alert alert-danger">
                            <td colspan="6">{{__('lang.no_records')}}</td>
                        </tr>
                    @endif
                   
                  </tbody>
                </table>
                {{ $userbookings->links() }}
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
          <h5 class="modal-title">{{__('lang.cancel_Reschedule')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="flight-details ">
            {{-- <div class="col-3"></div> --}}
            <div class="col-12">
              <div class="text-5 fw-500 text-center mb-4">
                <div class="mb-1">{{__('lang.i_want_to_request_you_to')}}</div>
                <div class="mb-1">{{__('lang.cancel_Reschedule')}}</div>
                <div class="mb-1">{{__('lang.my_flight_ticket')}}</div>
              </div>

              <div class="text-2 fw-300 text-center mb-4 text-muted">
                <div class="mb-1">{{__('lang.our_travel_desk_will_call_you_in_few_minitues')}}</div>
                <div class="mb-1">{{__('lang.on_your_request_to_confirm')}}</div>
                <div class="mb-1">({{__('lang.or')}})</div>
                <div class="mb-1">{{__('lang.you_can_contact_for_immediate_response')}}</div>
              </div>
              
              <div class="text-center"> 
                {{-- <a href="#" onclick="cancle()" class="btn btn-primary rounded-pill"><i class="fas fa-shopping-cart d-block d-lg-none"></i> <span class="d-none d-lg-block">Confirm</span></a> --}}
                <form  method="post" action="{{url('cancelBooking')}}" id ="cancellationForm">
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