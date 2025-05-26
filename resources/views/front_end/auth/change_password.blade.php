@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.my_profile')}} </h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}}</a></li>
            <li class="active">{{__('lang.my_profile')}}</li>
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
          <div class="bg-white shadow-md rounded p-4"> 
            <!-- Change Password
          ============================================= -->
            <h4 class="mb-4">{{__('lang.change_password')}} </h4>
            <hr class="mx-n4 mb-4">
            <div class="row g-4">
              <div class="col-lg-8">
                @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                <form id="changePassword" method="post" action="{{ route('updatePassword') }}">
                    @csrf
                  <div class="mb-3">
                    <label class="form-label" for="existingPassword">{{__('lang.existing_password')}} </label>
                    <input type="password" class="form-control @error('current-password') is-invalid @enderror" data-bv-field="existingpassword" id="existingPassword" required placeholder="{{__('lang.existing_password')}}" name="current-password" >
                    @error('current-password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="newPassword">{{__('lang.new_password')}}</label>
                    <input type="password" class="form-control @error('new-password') is-invalid @enderror" data-bv-field="newpassword" id="newPassword" required placeholder="{{__('lang.new_password')}}" name="new-password">
                    @error('new-password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="existingPassword">{{__('lang.confirm_password')}}</label>
                    <input type="password" class="form-control @error('new-password_confirmation') is-invalid @enderror" data-bv-field="confirmgpassword" id="confirmPassword" required placeholder="{{__('lang.confirm_password')}}" name ="new-password_confirmation">
                  </div>
                  <button class="btn btn-primary" type="submit">{{__('lang.update_password')}}</button>
                </form>
              </div>
              <div class="col-lg-4"> 
                <!-- Privacy Information
			============================================= -->
                <div class="bg-light-2 rounded p-4">
                  <h3 class="text-4 mb-2">{{__('lang.we_value_your_privacy')}}</h3>
                  <p class="mb-0">{{__('lang.change_password_info')}}<a href="{{route('PrivacyPolicy')}}"> {{__('lang.privacy_policy')}} </a>.</p>
                  <hr class="mx-n4">
                  <h3 class="text-4 mb-3">{{__('lang.billing_enquiries')}}</h3>
                  <p class="mb-0">{{__('lang.do_not_hesitate_to_reach_our')}}<a href="#">{{__('lang.support_team')}}  </a> {{__('lang.if_you_have_any_queries')}}.</p>
                </div>
                <!-- Privacy Information end --> 
              </div>
            </div>
            <!-- Change Password end --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
  
  @endsection