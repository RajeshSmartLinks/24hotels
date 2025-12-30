@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>@if($result['hotelbookingdetails']->booking_status == "booking_completed")
              Booking Completed
              @elseif($result['hotelbookingdetails']->booking_status == "booking_partially_completed")
              Booking Partially Completed
              @elseif($result['hotelbookingdetails']->booking_status == "booking_pending")
              Booking Pending
              @endif
          </h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">Home</a></li>
            <li class="{{url('/')}}">Hotel Booking</li>
            <li class="#">@if($result['hotelbookingdetails']->booking_status == "booking_completed")
              Booking Completed
              @elseif($result['hotelbookingdetails']->booking_status == "booking_partially_completed")
              Booking Partially Completed
              @elseif($result['hotelbookingdetails']->booking_status == "booking_pending")
              Booking Pending
              @endif</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Page Header end --> 
  
  <!-- Content
  ============================================= -->
  <div id="content"> 
    <!-- 404
    ============================================= -->
    <section class="section">
      <div class="container" >
        @if(!empty($result['confirmationHtml']))
            @if($result['hotelbookingdetails']->booking_status == "booking_completed" || $result['hotelbookingdetails']->booking_status == "booking_partially_completed")
                <div id = "printArea">{!! $result['confirmationHtml'] !!}</div>
            @elseif($result['hotelbookingdetails']->booking_status == "booking_pending")   
                <h2 class="text-8 fw-600 mb-3">Hotel Booking is in progress</h2>
            @endif 
        @else
            <h2 class="text-8 fw-600 mb-3">Error in Hotel Booking</h2>
        @endif
      
        <div class="text-center">
          <a href="{{url('/')}}" class="btn btn-primary shadow-none px-5 m-2">{{__('lang.home')}}</a> 
          <a href="{{url('/')}}" class="btn btn-outline-dark shadow-none px-5 m-2">{{__('lang.back')}}</a>
          @if($result['hotelbookingdetails']->booking_status == "booking_completed" || $result['hotelbookingdetails']->booking_status == "booking_partially_completed")
            <a class="btn btn-primary shadow-none px-5 m-2" onclick="printDiv('printArea')">Print</a>
            <a href = "{{asset($result['hotelbookingdetails']->hotel_room_booking_path)}}" download   class="btn btn-outline-dark shadow-none px-5 m-2" data-bs-toggle="tooltip" title="Download">Download</a>

            {{-- <a  href = "{{asset($hoteldetails->hotel_room_booking_path)}}" download data-bs-toggle="tooltip" title="Download"><i class="fas fa-download"></i></a> --}}
          @endif
         </div>
        </div>
      
    </section>
    <!-- 404 end --> 
    
  </div>
  <!-- Content end --> 

@endsection

@section('extraScripts')
  <script>
    function printDiv(divId) {
    var originalContent = document.body.innerHTML;
    var printContent = document.getElementById(divId).innerHTML;

    document.body.innerHTML = printContent;

    window.print();

    document.body.innerHTML = originalContent;
}
  </script>
@endsection