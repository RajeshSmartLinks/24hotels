@extends('front_end.layouts.master')
@section('content')
  <!-- Content -->
  <div id="content">
    <div class="container pt-5 pb-4">
      <div class="row">
        <div class="col-md-9 col-lg-7 col-xl-5 mx-auto">
          <div class="bg-white shadow-md rounded p-3 pt-sm-4 pb-sm-5 px-sm-5">
            <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
              <li class="nav-item"> <a class="nav-link text-5 lh-lg active">{{__('lang.login')}}</a> </li>
              <li class="nav-item"> <a class="nav-link text-5 lh-lg" href="{{route('user-signup')}}">{{__('lang.sign_up')}}</a> </li>
            </ul>
            <p class="text-4 fw-300 text-muted text-center mb-4">{{__('lang.we_are_glad_to_see_you_again')}}</p>
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <form id="loginForm" method="post" action ="{{ route('login') }}">
                @csrf
              <div class="mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="emailAddress"  placeholder="{{__('lang.email_id')}}" name ="email" value={{ old('email') }}>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="loginPassword"  placeholder="{{__('lang.password')}}" name="password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="row my-4">
                <div class="col">
                  <div class="form-check text-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                  </div>

                  
                </div>
                <div class="col text-2 text-end"><a class="btn-link" href="{{route('user-forget.password.get')}}"> {{__('lang.forgot_password')}}</a></div>
              </div>
              <div class="d-grid my-4">
                <button class="btn btn-primary" type="submit"> {{__('lang.login')}}</button>
              </div>
            </form>
            {{-- <div class="d-flex align-items-center my-3">
              <hr class="flex-grow-1">
              <span class="mx-2 text-2 text-muted">Or Login with Social Profile</span>
              <hr class="flex-grow-1">
            </div> --}}
            {{-- <div class="d-flex  flex-column align-items-center mb-3">
              <ul class="social-icons social-icons-colored social-icons-circle">
                <li class="social-icons-facebook"><a href="#" data-bs-toggle="tooltip" title="Log In with Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social-icons-twitter"><a href="#" data-bs-toggle="tooltip" title="Log In with Twitter"><i class="fab fa-twitter"></i></a></li>
                <li class="social-icons-google"><a href="#" data-bs-toggle="tooltip" title="Log In with Google"><i class="fab fa-google"></i></a></li>
                <li class="social-icons-linkedin"><a href="#" data-bs-toggle="tooltip" title="Log In with Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
              </ul>
            </div> --}}
            <p class="text-2 text-center mb-0">{{__('lang.new_to_24flights')}} <a class="btn-link" href="{{route('user-signup')}}"> {{__('lang.sign_up')}}</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 

@endsection