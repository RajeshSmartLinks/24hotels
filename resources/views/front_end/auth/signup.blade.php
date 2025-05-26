@extends('front_end.layouts.master')
@section('content')
  
  <!-- Content
  ============================================= -->
  <div id="content">
    <div class="container pt-5 pb-4">
      <div class="row">
        <div class="col-md-9 col-lg-7 col-xl-5 mx-auto">
          <div class="bg-white shadow-md rounded p-3 pt-sm-4 pb-sm-5 px-sm-5">
            <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
              <li class="nav-item"> <a class="nav-link text-5 lh-lg" href="{{route('login')}}">{{__('lang.login')}} </a> </li>
              <li class="nav-item"> <a class="nav-link text-5 lh-lg active">{{__('lang.sign_up')}} </a> </li>
            </ul>
            <p class="text-4 fw-300 text-muted text-center mb-4">{{__('lang.looks_like_youre_new_here')}} </p>
            <form id="signupForm" method="post" action="{{route('user-creation')}}">
                @csrf
              {{-- <div class="mb-3">
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" required placeholder="Your First Name" value="{{ old('first_name') }}" required>
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="mb-3">
                <input type="text" class="form-control" name="last_name" required placeholder="Your Last Name">
              </div> --}}

              <div class="mb-3">
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" required placeholder="{{__('lang.first_name')}}" value="{{ old('first_name') }}" required>
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="mb-3">
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" required placeholder="{{__('lang.last_name')}}" value="{{ old('last_name') }}" required>
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" required placeholder="{{__('lang.email_id')}}" value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="mb-3">
                <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required placeholder="{{__('lang.password')}}" value="{{ old('password') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror    
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" name="password_confirmation" required placeholder="{{__('lang.confirm_password')}}">
              </div>
              <div class="form-check text-3 my-4">
                <input id="agree" name="agree" class="form-check-input" type="checkbox" required>
                <label class="form-check-label text-2" for="agree">{{__('lang.i_agree_to_the')}} <a href="{{route('TermsOfUse')}}">{{__('lang.terms_of_use')}}</a> {{__('lang.and')}} <a href="{{route('PrivacyPolicy')}}"> {{__('lang.privacy_policy')}}</a>.</label>
              </div>
              <div class="d-grid my-4">
                <button class="btn btn-primary" type="submit">{{__('lang.sign_up')}}</button>
              </div>
            </form>
            {{-- <div class="d-flex align-items-center my-3">
              <hr class="flex-grow-1">
              <span class="mx-2 text-2 text-muted">Or Sign Up with Social Profile</span>
              <hr class="flex-grow-1">
            </div>
            <div class="d-flex  flex-column align-items-center mb-3">
              <ul class="social-icons social-icons-colored social-icons-circle">
                <li class="social-icons-facebook"><a href="#" data-bs-toggle="tooltip" title="Sign Up with Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social-icons-twitter"><a href="#" data-bs-toggle="tooltip" title="Sign Up with Twitter"><i class="fab fa-twitter"></i></a></li>
                <li class="social-icons-google"><a href="#" data-bs-toggle="tooltip" title="Sign Up with Google"><i class="fab fa-google"></i></a></li>
                <li class="social-icons-linkedin"><a href="#" data-bs-toggle="tooltip" title="Sign Up with Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
              </ul>
            </div> --}}
            <p class="text-2 text-center mb-0">{{__('lang.already_have_an_account')}} <a class="btn-link" href="{{url('/login')}}">{{__('lang.login')}}</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
  
  <!-- Content end --> 
  @endsection
