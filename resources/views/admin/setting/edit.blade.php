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
                            @can('destination-view')
                            <a href="{{route('setting.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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


                                        <form class="form-horizontal" action="{{route('setting.update', $setting->id)}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="site_name">Site Name</label>
                                                            <input type="text" id="site_name" class="form-control @error('site_name') is-invalid @enderror" placeholder="Name - English" name="site_name" value="{{old('site_name', $setting->site_name)}}" autocomplete="off" required>
                                                            @error('site_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="pop_up">PopUp Title</label>
                                                            <input type="text" id="pop_up_title" class="form-control @error('pop_up_title') is-invalid @enderror" placeholder="PopUp Title" name="pop_up_title" value="{{old('pop_up_title', $setting->pop_up_title)}}" autocomplete="off"required>
                                                            @error('pop_up_title')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                              
                                                    <div class= "col-md-6 col-12">
                                                      
                                                        <label for="first-name-column">PopUpImage</label>
                                                        <div class="form-label-group">
                                                            
                                                            <input type="file" id="pop_up_image" class="form-control @error('pop_up_image') is-invalid @enderror" placeholder="Popup Image" name="pop_up_image">
                                                            @error('pop_up_image')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                     
                                                    </div>
                                                    <div class= "col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="valid_from">Popup Status</label>
                                                            <select name="pop_up_status" class="form-control @error('pop_up_status') is-invalid @enderror" id="basicSelect">
                                                                <option value="">--select pop_up_status --</option>
                                                                <option value="active" {{(old('pop_up_status', $setting->pop_up_status) == "active")?"selected":""}}>Active</option>
                                                                <option value="inactive" {{(old('pop_up_status', $setting->pop_up_status) == "inactive")?"selected":""}}>InActive</option>
                                                            </select>
                                                            @error('pop_up_status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                               
                                                <div>&nbsp;</div>
                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Update
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