@extends('front_end.layouts.master')
@section('content')

<!-- Page Header
============================================= -->
<section class="page-header page-header-dark bg-secondary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>Wallet History</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{{Url('/')}}">Home</a></li>
          <li class="active">Wallet History</li>
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
          <div class="col-12">
              <div class="bg-white shadow-sm rounded pt-3 pb-0 px-4">
                <div class="row g-0">
                  <div class="col text-center text-sm-start">
                    <div class="">
                      <h5 class="text-3 text-body pb-2">{{__('lang.wallet')}}</h5>
                      <div class="card-text">
                          <dl class="row">
                              <dt class="col-sm-2 col-2" style = "font-size: small">{{__('lang.total_recharge')}} :</dt>
                              <dd class="col-sm-2 col-2"> {{$info['totalRecharge']}} </dd>
                              <dt class="col-sm-2 col-2" style = "font-size: small">{{__('lang.total_use')}} :</dt>
                              <dd class="col-sm-2 col-2"> {{$info['totalUse']}} </dd>
                              <dt class="col-sm-2 col-2" style = "font-size: small">{{__('lang.balance_avai')}} :</dt>
                              <dd class="col-sm-2 col-2"> {{$info['availableWalletBalance']}} </dd>
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
          <div class="row"> <div class="col-8"><h4 class="mb-9">Wallet Logger</h4></div>  <div class="col-4"><h5 class=""> Amount : KWD {{auth()->user()->wallet_balance}}</h5></div></div>
		  <hr class="mx-n4">
         
          
          <div class="tab-content my-3" id="myTabContent">

              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead>
                    <tr>
                        <th>UniqueId</th>
                        <th>DOT</th>
                        <th>Amount</th>
                        <th>Journey</th>
                        <th>BookingId</th>
                        <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($walletLogger) > 0)
                        @foreach($walletLogger as $log)
                        <tr>
                        <td class="align-middle">{{$log->unique_id}}</td>
                        <td class="align-middle">{{ \Carbon\Carbon::parse($log->date_of_transaction)->format('d M Y, h:i A') }}</td>
                        @if($log->action == 'added')
                            <td class="align-middle" style="color:green">
                                {{"+ ".$log->amount}}
                            </td>
                        @else
                            <td class="align-middle" style="color:red">
                                {{"- ".$log->amount}}
                            </td>
                        @endif
                        {{-- @if($log->flight_booking_id !='')
                        <td  class="align-middle">
                          <a  href = "#" download data-bs-toggle="tooltip" title="{{$log->FlightBooking->from ?? ''}}">{{$log->FlightBooking->from ?? ''}}</a>
                          @if($log->FlightBooking->booking_type == "roundtrip")
                          <i data-bs-toggle="tooltip" title="Round Trip" class="fas fa-exchange-alt arrowicon"></i> 
                          @else
                          <i data-bs-toggle="tooltip" title="One Way" class="fas fa-arrow-right"></i>
                          @endif
                          <a  href = "#" download data-bs-toggle="tooltip" title="{{$log->FlightBooking->to ?? ''}}">{{$log->FlightBooking->to}}</a>
                        </td>
                        <td class="align-middle">{{$log->FlightBooking->booking_ref_id}}</td>
                        @else
                        <td class="align-middle">---</td>
                        <td class="align-middle">---</td>
                        @endif --}}
                        @if($log->reference_type == 'flight')
                        <td  class="align-middle">
                          <a  href = "#" download data-bs-toggle="tooltip" title="{{$log->booking_from ?? ''}}">{{$log->booking_from ?? ''}}</a>
                          @if($log->booking_type == "roundtrip")
                          <i data-bs-toggle="tooltip" title="Round Trip" class="fas fa-exchange-alt arrowicon"></i> 
                          @else
                          <i data-bs-toggle="tooltip" title="One Way" class="fas fa-arrow-right"></i>
                          @endif
                          <a  href = "#" download data-bs-toggle="tooltip" title="{{$log->booking_to ?? ''}}">{{$log->booking_to}}</a>
                        </td>
                        <td class="align-middle">{{$log->flight_booking_id}}</td>
                        @elseif($log->reference_type == 'hotel')
                        <td class="align-middle text-center">
                        <i class="fas fa-ellipsis-h text-4 text-info" data-bs-toggle="tooltip" title="" ></i></td>
                        <td class="align-middle">{{$log->hotel_booking_id}}</td>
                        @else
                        <td class="align-middle text-center"><i class="fas fa-ellipsis-h text-4 text-info" data-bs-toggle="tooltip" title="" ></i></td></td>
                        <td class="align-middle text-center"><i class="fas fa-ellipsis-h text-4 text-info" data-bs-toggle="tooltip" title="" ></i></td></td>
                        @endif
                       
               
                       
                        <td class="align-middle text-justify">{{$log->amount_description }}</td>
                        
                        
                        
                        </tr>
                        @endforeach
                    @else
                        <tr align="center" class="alert alert-danger">
                            <td colspan="6">{{__('lang.no_records')}}</td>
                        </tr>
                    @endif
                   
                  </tbody>
                </table>
                {{ $walletLogger->links() }}
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