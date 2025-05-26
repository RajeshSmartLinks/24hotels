@extends('front_end.layouts.master')
@section('content')
  
  <!-- Content
  ============================================= -->
  <div id="content">
    <div class="container pt-5 pb-4">
      <div class="row">
        <div class="col-md-9 col-lg-7 col-xl-5 mx-auto">
          <div class="bg-white shadow-md rounded p-3 pt-sm-4 pb-sm-5 px-sm-5">
            
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <h3 class="text-center mt-3 mb-4">{{__('lang.forgot_your_password')}} </h3>
            <p class="text-center text-3 text-muted">{{__('lang.forgot_your_password_desc')}}.</p>
            <form id="forgotForm" class="form-border" method="post" action="{{route('user-forget.password.post')}}">
                @csrf
              <div class="mb-3">
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="emailAddress" required placeholder="{{__('lang.enter_email_id')}}" name="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="d-grid my-4">
                <button class="btn btn-primary" type="submit">{{__('lang.continue')}}</button>
              </div>
            </form>
            {{-- <p class="text-center mb-0"><a class="btn-link" href="login.html">Return to Log In</a> <span class="text-muted mx-3">|</span> <a class="btn-link" href="otp.html">Request OTP</a></p> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
  
@endsection