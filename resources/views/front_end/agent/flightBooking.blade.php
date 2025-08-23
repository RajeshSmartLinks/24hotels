@extends('front_end.layouts.master')
@section('content')

<!-- Page Header
============================================= -->
<section class="page-header page-header-dark bg-secondary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>{{__('lang.flight_booking')}}</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{{Url('/')}}">{{__('lang.home')}}</li>
          </ul></a></li>
          <li class="active">{{__('lang.flight_booking')}}</li>
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
          <h4 class="mb-4">{{__('lang.flight_booking_history')}}</h4>
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