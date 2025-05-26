@extends('admin.layouts.master')

@section('extrastyle')
    <!-- Drop Zone Styles --> 
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/file-uploaders/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/plugins/file-uploaders/dropzone.css')}}">
@endsection

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <x-admin-breadcrumb :title="$titles['title']"></x-admin-breadcrumb>
            </div>
            <div class="content-body">

                <!-- invoice functionality start -->
                <section class="invoice-print mb-1">
                    <div class="row">
                        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">&nbsp;</fieldset>
                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                            @can('agent-view')
                            <a href="{{route('agents.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-list"></i>&nbsp;Go to List</a>
                            </a>
                            @endcan
                        </div>
                    </div>
                </section>

                <!-- Adding Form -->
                <section id="multiple-column-form" class="input-validation">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        {{-- <x-admin-error-list-show></x-admin-error-list-show> --}}


                                        <form class="form-horizontal" action="{{route('agents.store')}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input type="text" id="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" name="first_name" value="{{old('first_name')}}" autocomplete="off" required>
                                                            @error('first_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name</label>
                                                            <input type="text" id="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" name="last_name" value="{{old('last_name')}}" autocomplete="off"required>
                                                            @error('last_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            
                                                            <input type="email"   class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{old('email')}}">
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                       
                                                            <div class="form-group">
                                                                <label for="mobile">Mobile</label>
                                                    
                                                                <input type="number"   class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile" value="{{old('mobile')}}">
                                                                @error('mobile')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                       
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" value="" autocomplete="off">
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Confirm Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="Confirm Password" class="form-control" placeholder="Confirm Password" name="password_confirmation" value="" autocomplete="off">
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class= "col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="valid_from">Status</label>
                                                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="basicSelect">
                                                                <option value="">--select status --</option>
                                                                <option value="Active" @if (old('status') == "Active") {{ 'selected' }} @endif>Active</option>
                                                                <option value="InActive" @if (old('status') == "InActive") {{ 'selected' }} @endif>InActive</option>
                                                            </select>
                                                            @error('status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                       
                                                        <div class="form-group">
                                                            <label for="wallet_balance">Wallet Amount</label>
                                                
                                                            <input type="number"   class="form-control @error('wallet_balance') is-invalid @enderror" placeholder="Wallet Balance" name="wallet_balance" value="{{old('wallet_balance')}}">
                                                            @error('wallet_balance')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                   
                                                </div>
                                                </div>
                                               
                                                <h3>Flight MarkUps</h3>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">{{__('admin.fee_type')}}</label>
                                                            <select name="fee_type" class="form-control @error('fee_type') is-invalid @enderror">
                                                                <option value=""> select Fee type</option>
                                                                <option value="addition" >{{ucfirst('addition')}}</option>
                                                                <option value="subtraction" >{{ucfirst('subtraction')}}</option>
                                                                
                                                            </select>
                                                            @error('fee_type')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                           
                                                        </div>
                                                    </div>

                                                   

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">{{__('admin.fee_value')}}</label>
                                                            <select name="fee_value" class="form-control @error('fee_value') is-invalid @enderror">
                                                                <option value=""> select Fee Value</option>
                                                                <option value="fixed" >{{ucfirst('fixed')}}</option>
                                                                <option value="percentage" >{{ucfirst('percentage')}}</option>
                                                                
                                                            </select>
                                                            @error('fee_value')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                        <label for="first-name-column">{{__('admin.fee_amount')}}</label>
                                                        <input type="number" id="fee_amount" class="form-control @error('fee_amount') is-invalid @enderror" placeholder="{{__('admin.fee_amount')}}" name="fee_amount"  autocomplete="off" value="">
                                                            @error('fee_amount')
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror 
                                                        </div>
                                                    </div>
                                                </div>

                                                <h3>Hotel MarkUps</h3>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">{{__('admin.fee_type')}}</label>
                                                            <select name="hotel_fee_type" class="form-control @error('hotel_fee_type') is-invalid @enderror">
                                                                <option value=""> select Fee type</option>
                                                                <option value="addition" >{{ucfirst('addition')}}</option>
                                                                <option value="subtraction" >{{ucfirst('subtraction')}}</option>
                                                                
                                                            </select>
                                                            @error('hotel_fee_type')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                           
                                                        </div>
                                                    </div>

                                                   

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">{{__('admin.fee_value')}}</label>
                                                            <select name="hotel_fee_value" class="form-control @error('hotel_fee_value') is-invalid @enderror">
                                                                <option value=""> select Fee Value</option>
                                                                <option value="fixed" >{{ucfirst('fixed')}}</option>
                                                                <option value="percentage" >{{ucfirst('percentage')}}</option>
                                                                
                                                            </select>
                                                            @error('hotel_fee_value')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                        <label for="first-name-column">{{__('admin.fee_amount')}}</label>
                                                        <input type="number" id="hotel_fee_amount" class="form-control @error('fee_amount') is-invalid @enderror" placeholder="{{__('admin.fee_amount')}}" name="hotel_fee_amount"  autocomplete="off" value="">
                                                            @error('hotel_fee_amount')
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror 
                                                        </div>
                                                    </div>
                                                </div>
                                                


                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Save
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Adding Form Ends -->

            </div>
        </div>
    </div>

@endsection



