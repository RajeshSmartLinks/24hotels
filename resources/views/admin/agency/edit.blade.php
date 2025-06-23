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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        {{-- <x-admin-error-list-show></x-admin-error-list-show> --}}


                                        <form class="form-horizontal" action="{{route('agency.update', $editAgency->id)}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="name">Agency Name</label>
                                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Agency Name" name="name" value="{{old('name', $editAgency->name)}}" autocomplete="off" required>
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
                                                            <option value="Active" {{old('status', $editAgency->status) == 'Active' ? 'selected' : ''}}>{{ucfirst('Active')}}</option>
                                                            <option value="InActive" {{old('status', $editAgency->status) == 'InActive' ? 'selected' : ''}}>{{ucfirst('InActive')}}</option>
                                                            
                                                        </select>
                                                        @error('status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                  
                                                        </div>
                                                    </div>
                                                    
                                                    <div class= "col-md-6 col-12">
                                                        <div class="col-md-6 col-12">
                                                            <label for="first-name-column">Logo</label>
                                                            <div class="form-label-group">
                                                                
                                                                <input type="file" id="logo" class="form-control @error('logo') is-invalid @enderror" placeholder="Brand logo" name="logo">
                                                                @error('logo')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                
                                                            </div>
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
                                                            <option value = "{{$country->id}}" {{$country->id == old('country_id', $editAgency->country_id) ? 'selected' : ''}}>{{$country->name}}</option>
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
                                                            <input type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="phone Number" name="phone_number" value="{{old('phone_number', $editAgency->phone_number)}}" autocomplete="off"required>
                                                            @error('phone_number')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="address">Address</label>
                                                            <textarea class="form-control @error('address') is-invalid @enderror" rows="5" placeholder="Address" name="address" required>{{old('address', $editAgency->address)}}</textarea>
                                                            @error('address')
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
    <script>

        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif

      
    </script>
@endsection
