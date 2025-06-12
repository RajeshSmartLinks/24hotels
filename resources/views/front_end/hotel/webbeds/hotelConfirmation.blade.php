@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>Pending</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">Home</a></li>
            <li class="{{url('/')}}">Hotel Booking</li>
            <li class="#">Pending</li>
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
      <div class="container text-center">
        @if(!empty($result['confirmationHtml']))
            @if($result['hotelbookingdetails']->booking_status == "booking_completed")
                <div>{!! $result['confirmationHtml'] !!}</div>
            @elseif($result['hotelbookingdetails']->booking_status == "booking_pending")   
                <h2 class="text-8 fw-600 mb-3">Hotel Booking is in progress</h2>
            @endif 
        @else
            <h2 class="text-8 fw-600 mb-3">Error in Hotel Booking</h2>
        @endif
       
        {{-- <h2 class="text-8 fw-600 mb-3">{{__('lang.hotel_booking_is_in_progress')}}</h2>
        <h3 class="text-6 fw-600 mb-3">{{__('lang.you_will_get_confirmation_mail_in_5_min')}}</h3>
        <p class="text-3 text-muted">{{__('lang.Dont_be_panic')}}</p> --}}

        <a href="{{url('/')}}" class="btn btn-primary shadow-none px-5 m-2">{{__('lang.home')}}</a> <a href="{{url('/')}}" class="btn btn-outline-dark shadow-none px-5 m-2">{{__('lang.back')}}</a> </div>
    </section>
    <!-- 404 end --> 
    
  </div>
  <!-- Content end --> 

@endsection