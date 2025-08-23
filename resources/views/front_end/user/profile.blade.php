@extends('front_end.layouts.master')
@section('content')
<!-- Page Header
    ============================================= -->
    <section class="page-header page-header-dark bg-secondary">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h1>{{__('lang.my_profile')}}</h1>
          </div>
          <div class="col-md-4">
            <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
              <li><a href="{{url('/')}}">{{__('lang.home')}} </a></li>
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
          <div class="col-lg-10">
            <div class="bg-white shadow-md rounded p-4"> 
              <!-- Personal Information
            ============================================= -->
              <h4 class="mb-4">Agency Information </h4>
              <hr class="mx-n4 mb-4">

              
              <div class="row">
                <div class="col-lg-8">
                  @if(session()->has('success'))
                      <div class="alert alert-success">
                          {{ session()->get('success') }}
                      </div>
                  @endif
                 
                  <div class="row">
                    
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="form-label" for="agency_name">Agency Name</label>
                        <input type="text" value="{{Auth::user()->agency->name ?? ''}}" class="form-control" data-bv-field="agency_name" id="agency_name" required placeholder="First Name" name="agency_name" readonly >
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea   class="form-control" data-bv-field="address" id="address" readonly placeholder="Address" name="address" readonly rows="4">{{Auth::user()->agency->address ?? ''}}</textarea>
                      </div>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-2">
                      <div class="mb-3">
                        <label class="form-label" for="fullName">Country</label>
                        <select class="form-select "  name= "country_id" id="country" style="min-height: 46% !important" title="select Country" > 
                          <option value="">Select country Code</option>
                          @php
                          $agencyCountryId = Auth::user()->agency->country_id ?? '';
                              
                          @endphp
                          @foreach($countries as $country)
                            <option value = "{{$country->id}}" {{ ($agencyCountryId == $country->id)? 'selected':'' }}>{{$country->phone_code}} ( {{$country->phone_code}} )</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="mb-3">
                        <label class="form-label" for="mobileNumber">Phone Number</label>
                        <input type="text" value="{{Auth::user()->agency->phone_number ?? ''}}" class="form-control" data-bv-field="phone_number" id="phone_number"  placeholder="Phone Number" name="phone_number">
                        
                      </div>
                    </div>
                    <div class="product-img col-4">
                      <img src="{{!empty(Auth::user()->agency->logo) ?  asset('uploads/agency/'.Auth::user()->agency->logo) : $noImage}} " width="100"/>
                    </div>
                  </div>
                   <h4 class="mb-4">Agent Information </h4>
                  <hr class="mx-n4 mb-4">

                  <form id="personalInformation" method="post" action = "{{route('update-user-profile',['id'=>encrypt(Auth::user()->id)])}}" enctype="multipart/form-data">
                    @csrf
                   
                    <div class="row">
                      <div class="col-3">
                        <div class="mb-3">
                          <label class="form-label" for="fullName">Title</label>
                          <select class="form-select @error('title') is-invalid @enderror"  required="" name= "title" style="min-height: 50%;">
                            <option value=""> Select Title</option>
                            <option {{ (Auth::user()->title == "Mr")? 'selected':'' }} >Mr</option>
                            <option {{ (Auth::user()->title == "Ms")? 'selected':'' }}>Ms</option>
                            <option {{ (Auth::user()->title == "Mrs")? 'selected':'' }}>Mrs</option> 
                            <option {{ (Auth::user()->title == "Master")? 'selected':'' }}>Master</option>
                            <option {{ (Auth::user()->title == "Miss")? 'selected':'' }}>Miss</option>
                          </select>
                          @error('title')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-5">
                        <div class="mb-3">
                          <label class="form-label" for="first_name">First Name</label>
                          <input type="text" value="{{Auth::user()->first_name}}" class="form-control @error('first_name') is-invalid @enderror" data-bv-field="first_name" id="first_name" required placeholder="First Name" name="first_name" >
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="last_name">Last Name </label>
                          <input type="text" value="{{Auth::user()->last_name}}" class="form-control @error('last_name') is-invalid @enderror" data-bv-field="last_name" id="last_name" required placeholder="Last Name" name="last_name" >
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="fullName">Country</label>
                          <select class="form-select @error('country_id') is-invalid @enderror"  name= "country_id" id="country" style="min-height: 46% !important" title="select Country" > 
                            <option value="">Select country Code</option>
                            @foreach($countries as $country)
                              <option value = "{{$country->id}}" {{ (Auth::user()->country_id == $country->id)? 'selected':'' }}>{{$country->name}} ( {{$country->phone_code}} )</option>
                            @endforeach
                          </select>
                            {{-- @error('country_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror --}}
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="mb-3">
                          <label class="form-label" for="mobileNumber">Mobile Number</label>
                          <input type="text" value="{{Auth::user()->mobile}}" class="form-control @error('mobile') is-invalid @enderror" data-bv-field="mobile" id="mobile"  placeholder="Mobile Number" name="mobile">
                          {{-- @error('mobile')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror --}}
                        </div>
                      </div>
                    </div>
                    
                    
                    <div class="mb-3">
                      <label class="form-label" for="emailID">Email ID</label>
                      <input type="text" value="{{Auth::user()->email}}" class="form-control @error('email') is-invalid @enderror" data-bv-field="emailid" id="emailID" required placeholder="Email ID" name="email">
                      @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                    </div>
                    <div class ="row">
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="birthDate">Date of Birth</label>
                          <input id="birthDate" value="{{Auth::user()->date_of_birth}}" type="date" class="form-control"  placeholder="Date of Birth" name="date_of_birth">
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="mb-3">
                          <label class="form-label" for="birthDate">Profile Pic</label>
                          <input type="file" class="form-control"  placeholder="Profie Pic" name="profile_pic">
                           @error('profile_pic')
                              <span class="invalid-feedback" role="alert" style="display: block">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                    </div>
                   
                    <button class="btn btn-primary" type="submit" id="updatebutton">
                      <span ></span>
                      Update Now</button>
                  </form>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0 "> 
                  <!-- Privacy Information
              ============================================= -->
                  <div class="bg-light-2 rounded p-4">
                    <h3 class="text-4 mb-2">{{__('lang.we_value_your_privacy')}}</h3>
                    <p class="mb-0">{{__('lang.change_password_info')}}<a href="{{route('PrivacyPolicy')}}"> {{__('lang.privacy_policy')}} </a>.</p>
                    <hr class="mx-n4">
                    <h3 class="text-4 mb-3">{{__('lang.billing_enquiries')}}</h3>
                    <p class="mb-0">{{__('lang.do_not_hesitate_to_reach_our')}}<a href="https://api.whatsapp.com/send?phone=96567041515">{{__('lang.support_team')}}  </a> {{__('lang.if_you_have_any_queries')}}.</p>
                  </div>
                  <!-- Privacy Information end --> 
                </div>
              </div>
              <!-- Personal Information end --> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Content end --> 

@endsection
    @section('extraScripts')
    <script>
    $(document).ready(function(){
      $("#personalInformation").on("submit", function(){
        $("#updatebutton").prop('disabled',true);
        $("#updatebutton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
      });//submit
    });//document ready
    </script>
    @endsection