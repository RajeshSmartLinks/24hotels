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

                <!-- Adding Form -->
                <section id="multiple-column-form" class="bootstrap-select">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                      

                                        <form class="form"
                                              action="{{route('updateHotelMarkupPrice', $editmarkup->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        {{-- <div class="form-label-group"> --}}
                                                            <label for="first-name-column">{{__('admin.fee_type')}}</label>
                                                            <select name="fee_type" class="form-control @error('fee_type') is-invalid @enderror">
                                                                <option value=""> select Fee type</option>
                                                                <option value="addition" {{$editmarkup->fee_type == 'addition' ? 'selected' : ''}}>{{ucfirst('addition')}}</option>
                                                                <option value="subtraction" {{$editmarkup->fee_type == 'subtraction' ? 'selected' : ''}}>{{ucfirst('subtraction')}}</option>
                                                                
                                                            </select>
                                                            @error('fee_type')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                           
                                                        {{-- </div> --}}
                                                    </div>

                                                   

                                                    <div class="col-md-6 col-12">
                                                        {{-- <div class="form-label-group"> --}}
                                                            <label for="first-name-column">{{__('admin.fee_value')}}</label>
                                                            <select name="fee_value" class="form-control @error('fee_value') is-invalid @enderror">
                                                                <option value=""> select Fee Value</option>
                                                                <option value="fixed" {{$editmarkup->fee_value == 'fixed' ? 'selected' : ''}}>{{ucfirst('fixed')}}</option>
                                                                <option value="percentage" {{$editmarkup->fee_value == 'percentage' ? 'selected' : ''}}>{{ucfirst('percentage')}}</option>
                                                                
                                                            </select>
                                                            @error('fee_value')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        {{-- </div> --}}
                                                    </div>
                                                    
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">{{__('admin.fee_amount')}}</label>
                                                        <input type="number" id="fee_amount" class="form-control @error('fee_amount') is-invalid @enderror" placeholder="{{__('admin.fee_amount')}}" name="fee_amount"  autocomplete="off" value="{{$editmarkup->fee_amount}}">
                                                            @error('fee_amount')
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror 
                                                            
                                                    </div>

                                                   

                                                    <div class="col-md-6 col-12">
                                                        {{-- <div class="form-label-group"> --}}
                                                            <label for="first-name-column">{{__('admin.status')}}</label>
                                                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                                                
                                                                <option value="Active" {{$editmarkup->status == 'Active' ? 'selected' : ''}}>{{ucfirst('Active')}}</option>
                                                                <option value="InActive" {{$editmarkup->status == 'InActive' ? 'selected' : ''}}>{{ucfirst('InActive')}}</option>
                                                                
                                                            </select>
                                                            @error('status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        {{-- </div> --}}
                                                    </div>
                                                    
                                                    
                                                </div>

                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('admin.update')}}
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

@section('scripts')
    <script>
        $('.zero-configuration').DataTable(
            {
                "displayLength": 50,
            }
        );

        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif

    </script>
@endsection
