@extends('admin.layouts.master')


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
                            @can('agency-view')
                            <a href="{{route('agency.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-list"></i>&nbsp;Go to List</a>
                            </a>
                            @endcan
                        </div>
                    </div>
                </section>

                <!-- Adding Form -->
                <section id="multiple-column-form" class="input-validation">
                    <div class="row match-height">
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        {{-- <x-admin-error-list-show></x-admin-error-list-show> --}}


                                        <form class="form-horizontal" action="{{route('agency.store')}}" method="post"
                                              enctype="multipart/form-data" >
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="name"> Agency Name</label>
                                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Agency Name" name="name" value="{{old('name')}}" autocomplete="off" required>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Status</label>
                                                        <div class="form-label-group">
                                                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                                            <option value = "" >Select Status</option>
                                                            <option value = "Active" {{old('status') == 'Active' ? 'selected' : ''}}>Active</option>
                                                            <option value = "InActive"{{old('status') == 'InActive' ? 'selected' : ''}} >InActive</option>
                                                        </select>
                                                        @error('status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                  
                                                        </div>
                                                    </div>
                                                    <div class= "col-md-6 col-12">
                                                        
                                                            <label for="first-name-column">Logo</label>
                                                            <div class="form-label-group">
                                                                
                                                                <input type="file" id="logo" class="form-control @error('logo') is-invalid @enderror" placeholder="Agency logo" name="logo" required>
                                                                @error('logo')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                
                                                            </div>
                                                  
                                                    </div>
                                                </div>
                                                <div class="row">
                                                     <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Country</label>
                                                        <div class="form-label-group">
                                                        <select name="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                                            <option value = "" >Select country</option>
                                                            @foreach($countries as $country)
                                                            <option value = "{{$country->id}}" {{old('country_id') == $country->id ? 'selected' : ''}}>{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('country_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="phone">Phone Number</label>
                                                            <input type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="phone Number" name="phone_number" value="{{old('phone_number')}}" autocomplete="off" required>
                                                            @error('phone_number')
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
                                                            <label for="wallet_balance">Wallet Amount</label>
                                                
                                                            <input type="number"   class="form-control @error('wallet_balance') is-invalid @enderror" placeholder="Wallet Balance" name="wallet_balance" value="{{old('wallet_balance')}}" required>
                                                            @error('wallet_balance')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="address">Address</label>
                                                            <textarea class="form-control @error('address') is-invalid @enderror" rows="5" placeholder="Address" name="address" required>{{old('address')}}</textarea>
                                                            @error('address')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>    
                                               
                                                <h4 class="card-title">Agency Master User</h4>
                                                <hr>
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
                                                            
                                                            <input type="email"   class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{old('email')}}" required>
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
                                                    
                                                                <input type="number"   class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile" value="{{old('mobile')}}" required>
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
                                                        <label for="password">Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" autocomplete="new-password" required>
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <label for="password_confirmation">Confirm Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" name="password_confirmation" autocomplete="new-password" required>
                                                            @error('password_confirmation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="row">
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
                                                    
                                                    
                                                </div> --}}

                                                <h3>Hotel MarkUps</h3>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">{{__('admin.fee_type')}}</label>
                                                            <select name="hotel_fee_type" class="form-control @error('hotel_fee_type') is-invalid @enderror" required>
                                                                <option value=""> select Fee type</option>
                                                                <option value="addition" {{old('hotel_fee_type') == 'addition' ? 'selected' : ''}}>{{ucfirst('addition')}}</option>
                                                                <option value="subtraction" {{old('hotel_fee_type') == 'subtraction' ? 'selected' : ''}}>{{ucfirst('subtraction')}}</option>
                                                                
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
                                                            <select name="hotel_fee_value" class="form-control @error('hotel_fee_value') is-invalid @enderror" required>
                                                                <option value=""> select Fee Value</option>
                                                                <option value="fixed"  {{old('hotel_fee_value') == 'fixed' ? 'selected' : ''}}>{{ucfirst('fixed')}}</option>
                                                                <option value="percentage"  {{old('hotel_fee_value') == 'percentage' ? 'selected' : ''}}>{{ucfirst('percentage')}}</option>
                                                                
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
                                                        <input type="number" id="hotel_fee_amount" class="form-control @error('fee_amount') is-invalid @enderror" placeholder="{{__('admin.fee_amount')}}" name="hotel_fee_amount"  autocomplete="off" value="{{old('hotel_fee_amount')}}" required>
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


@section('extrascript')

    <!-- Date Picker Scripts -->
    <script src="{{asset('admin-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>

    <script src="{{asset('admin-assets/js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>

    

    <script>

        $('#valid_upto').pickadate({
            selectMonths: true,
            selectYears: 200,
            min: new Date(1910, 1, 1),
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd',
        });

        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif
    </script>
@endsection
