@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <div class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.contact_us')}} </h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}}</a></li>
            <li class="active">{{__('lang.contact_us')}} </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Secondary Navigation end --> 
  
  <!-- Content
  ============================================= -->
  <div id="content">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-6">
          <div class="bg-white shadow-md rounded h-100 p-3">
            <iframe class="h-100 w-100" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13905.925219568184!2d47.9869646!3d29.3854731!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf742a772e297ba34!2sAl-Masila%20Group%20Int%60l%20Tourism%20%26%20Travel!5e0!3m2!1sen!2skw!4v1659432600350!5m2!1sen!2skw" allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-md-6">
          <div class="bg-white shadow-md rounded p-4">
            <h2 class="text-6 mb-4">{{__('lang.get_in_touch')}} </h2>
            <hr class="mx-n4 mb-4">
            <p class="text-3">{{__('lang.for_customer_support_and_query_get_in_touch_with_us')}}  <a href="#">{{__('lang.help')}}</a></p>
            <div class="featured-box style-1">
              <div class="featured-box-icon text-primary"> <i class="fas fa-map-marker-alt"></i></div>
              <h3>{{__('lang.head_office')}} </h3>
              <p>{{__('lang.head_office_address')}}<br>
                    <a href="tel:+965-22923004">+965-22923004</a><br>
                    <a href = "mailto: booking@24flights.com">booking@24flights.com</a>
                    
              </p>
             
            </div>
            {{-- <div class="featured-box style-1">
                <div class="featured-box-icon text-primary"> <i class="fas fa-map-marker-alt"></i></div>
                <h3>{{__('lang.egypt_branch')}}  </h3>
                <p>{{__('lang.egypt_branch_office_address')}} <br>
                    <a href="tel:+201227731026">+201227731026</a><br>
                    <a href = "mailto: booking@24flights.com">booking@24flights.com</a>
                </p>
              </div> --}}
              <div class="featured-box style-1">
                <div class="featured-box-icon text-primary"> <i class="fas fa-map-marker-alt"></i></div>
                <h3>{{__('lang.dubai_branch')}}  </h3>
                <p>{{__('lang.dubai_branch_office_address')}} <br>
                    <a href="tel:+971 504300107">+971 50 430 0107</a><br>
                    <a href = "mailto: booking@24flights.com">booking@24flights.com</a>
                </p>
              </div>
            <div class="featured-box style-1">
              <div class="featured-box-icon text-primary"> <i class="fas fa-phone"></i> </div>
              <h3>{{__('lang.telephone')}}  </h3>
              <p>	
                <a href="tel:+965 22270051">+965 22270051/2/3/4/6/7</a></p>
            </div>
            <div class="featured-box style-1">
              <div class="featured-box-icon text-primary"> <i class="fas fa-envelope"></i> </div>
              <h3>{{__('lang.business_inquiries')}} </h3>
              <p><a href = "mailto: info@24flights.com">info@24flights.com</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
  
  @endsection
