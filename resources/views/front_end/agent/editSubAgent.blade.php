@if (!auth()->user()->can('agent-edit'))
    @include('errors.404')
@else
@extends('front_end.layouts.master')
@section('content')
<!-- Page Header
    ============================================= -->
    <section class="page-header page-header-dark bg-secondary">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h1>Edit Agent</h1>
          </div>
          <div class="col-md-4">
            <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
              <li><a href="{{url('/')}}">{{__('lang.home')}} </a></li>
              <li><a href="{{route('agent-list')}}">Agents List</a></li>
              <li class="active">Edit Agent</li>
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
              <h4 class="mb-4">Edit Agent</h4>
              <hr class="mx-n4 mb-4">

              <div class="row">
                <div class="col-lg-8">
                  @if(session()->has('success'))
                      <div class="alert alert-success">
                          {{ session()->get('success') }}
                      </div>
                  @endif
                  @if(session()->has('error'))
                      <div class="alert alert-danger">
                          {{ session()->get('error') }}
                      </div>
                  @endif

                  <form id="personalInformation" method="post" action="{{route('update-sub-agent', $agent->id)}}" enctype="multipart/form-data">
                    @csrf
                   
                    <div class="row">
                      <div class="col-3">
                        <div class="mb-3">
                          <label class="form-label" for="fullName">Title</label>
                          <select class="form-select @error('title') is-invalid @enderror" required="" name="title" style="min-height: 50%;">
                            <option value=""> Select Title</option>
                            <option value="Mr" {{ (old('title', $agent->title) == "Mr")? 'selected':'' }}>Mr</option>
                            <option value="Ms" {{ (old('title', $agent->title) == "Ms")? 'selected':'' }}>Ms</option>
                            <option value="Mrs" {{ (old('title', $agent->title) == "Mrs")? 'selected':'' }}>Mrs</option> 
                            <option value="Master" {{ (old('title', $agent->title) == "Master")? 'selected':'' }}>Master</option>
                            <option value="Miss" {{ (old('title', $agent->title) == "Miss")? 'selected':'' }}>Miss</option>
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
                          <input type="text" value="{{old('first_name', $agent->first_name)}}" class="form-control @error('first_name') is-invalid @enderror" data-bv-field="first_name" id="first_name" required placeholder="First Name" name="first_name">
                          @error('first_name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="last_name">Last Name </label>
                          <input type="text" value="{{old('last_name', $agent->last_name)}}" class="form-control @error('last_name') is-invalid @enderror" data-bv-field="last_name" id="last_name" required placeholder="Last Name" name="last_name">
                          @error('last_name')
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
                          <select class="form-select @error('country_id') is-invalid @enderror" name="country_id" id="country" style="min-height: 46% !important" title="select Country"> 
                            <option value="">Select country Code</option>
                            @foreach($countries as $country)
                              <option value="{{$country->id}}" {{ (old('country_id', $agent->country_id) == $country->id)? 'selected':'' }}>{{$country->name}} ( {{$country->phone_code}} )</option>
                            @endforeach
                          </select>
                          @error('country_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="mb-3">
                          <label class="form-label" for="mobileNumber">Mobile Number</label>
                          <input type="text" value="{{old('mobile', $agent->mobile)}}" class="form-control @error('mobile') is-invalid @enderror" data-bv-field="mobile" id="mobile" placeholder="Mobile Number" name="mobile">
                          @error('mobile')
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
                          <label class="form-label" for="emailID">Email ID</label>
                          <input type="email" value="{{old('email', $agent->email)}}" class="form-control @error('email') is-invalid @enderror" data-bv-field="emailid" id="emailID" required placeholder="Email ID" name="email">
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="role_id">Role</label>
                          @php
                            $currentRoleId = old('role_id', optional($agent->roles->first())->id);
                          @endphp
                          <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required style="min-height: 46% !important" title="Select Role">
                            <option value="">Select Role</option>
                            @if(isset($roles) && count($roles) > 0)
                              @foreach($roles as $role)
                                <option value="{{$role->id}}" {{ ($currentRoleId == $role->id)? 'selected':'' }}>{{$role->name}}</option>
                              @endforeach
                            @endif
                          </select>
                          @error('role_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="status">Status</label>
                          <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required style="min-height: 46% !important" title="Select Status">
                            <option value="Active" {{ (old('status', $agent->status) == 'Active') ? 'selected' : '' }}>Active</option>
                            <option value="InActive" {{ (old('status', $agent->status) == 'InActive') ? 'selected' : '' }}>InActive</option>
                          </select>
                          @error('status')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="newPassword">Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" data-bv-field="newpassword" id="newPassword" placeholder="New Password" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" data-bv-field="confirmgpassword" id="confirmPassword" placeholder="Confirm Password" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" id="updatebutton">
                      <span></span>
                      Update</button>
                    <a href="{{route('agent-list')}}" class="btn btn-secondary ms-2">Cancel</a>
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
@endif
