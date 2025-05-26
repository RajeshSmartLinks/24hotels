@extends('admin.layouts.master')

@section('extrastyle')
    <!-- Date Picker Style -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/pickers/pickadate/pickadate.css')}}">

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
                            @can('app-view')
                            <a href="{{route('app.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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


                                        <form class="form-horizontal" action="{{route('appads.store')}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">
                                          
                                                <div class="row">
                                                   
                                                    <div class= "col-md-6 col-12">
                                                       
                                                        <label for="first-name-column">Image</label>
                                                        <div class="form-label-group">
                                                            
                                                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="Ads Image" name="image">
                                                            @error('image')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                      
                                                    </div>
                                                    <div class= "col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="valid_from">Link</label>
                                                            <input type="text" id="link" class="form-control @error('link') is-invalid @enderror" placeholder="Order" name="link" value="" autocomplete="off">
                                                            {{-- @error('link')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class= "col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="valid_from">Status</label>
                                                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="basicSelect">
                                                                <option value="">--select status --</option>
                                                                <option value="Active">Active</option>
                                                                <option value="InActive">InActive</option>
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
                                                            <label for="sort_order">Sort Order</label>
                                                            <input type="number" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" placeholder="Sort Order" name="sort_order" value="{{old('sort_order')}}" autocomplete="off" required>
                                                            @error('sort_order')
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



