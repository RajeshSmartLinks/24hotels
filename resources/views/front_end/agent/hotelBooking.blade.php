@extends('front_end.layouts.master')
@section('content')

<!-- Page Header
============================================= -->
<section class="page-header page-header-dark bg-secondary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>{{__('lang.hotel_booking')}}</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{{Url('/')}}">{{__('lang.home')}}</a></li>
          <li class="active">{{__('lang.hotel_booking')}}</li>
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
          <div class="row align-items-center">
            <div class="col-8">
              <h4>Hotel Booking History</h4>
            </div>
            
            <div class="col-4">
              <form>
              <div class="input-group shadow-sm ">
                <input class="form-control shadow-none border-0 pe-0" 
                      type="search"  id="search-input"  placeholder="Search"  value="" name= "searchKey">
                <span class="input-group-text bg-white border-0 p-0">
                  <button class="btn text-muted shadow-none px-3 border-0" type="submit">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
            </form>
            </div>
            
          </div>

      
          
		      <hr class="mx-n4">
         
         
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

      
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead>
                    <tr>
                      <th>Booking On</th>
                      {{-- <th>Description</th> --}}
                      <th>Order ID</th>
                      <th>Hotel</th>
                      <th>Customer</th>
                      <th>Agent</th>
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
                      <td class="align-middle">{{$hoteldetails->hotel_name}}</td>
                      <td class="align-middle"> {{ $hoteldetails->TravelersInfo->first()->first_name ?? '-' }}</td>
                       <td class="align-middle"> {{ $hoteldetails->User->first_name ?? '-' }}</td>
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
                        <td colspan="7">{{__('lang.no_records')}}</td>
                    </tr>
                @endif
                  </tbody>
                </table>
                {{ $hotelbookings->links() }}
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

  // Get URL parameter
  const urlParams = new URLSearchParams(window.location.search);
  const searchKey = urlParams.get('searchKey');

  // Get input element
  const searchInput = document.getElementById('search-input');

  if (searchKey) {
    searchInput.value = searchKey;
  } 


</script>
@endsection