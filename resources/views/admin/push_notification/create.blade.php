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
                            @can('push-notification-view')
                            <a href="{{route('notifications.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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


                                        <form class="form-horizontal" action="{{route('notifications.store')}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="title">Title (en)</label>
                                                            <input type="text" id="title_en" class="form-control @error('title_en') is-invalid @enderror" placeholder="Title (English)" name="title_en" value="{{old('title_en')}}" autocomplete="off" required>
                                                            @error('title_en')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="title">Title (Ar)</label>
                                                            <input type="text" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" placeholder="Title (Arabic)" name="title_ar" value="{{old('title_ar')}}" autocomplete="off" required>
                                                            @error('title_ar')
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
                                                            <label for="body">Description</label>
                                                            <textarea  class="form-control @error('description_en') is-invalid @enderror" rows="5" placeholder="Description (English)" name="description_en" required>{{old('description_en')}}</textarea>
                                                            @error('description_en')
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
                                                            <label for="body">Description</label>
                                                            <textarea  class="form-control @error('description_ar') is-invalid @enderror" rows="5" placeholder="Description (Arabic)" name="description_ar" required>{{old('description_ar')}}</textarea>
                                                            @error('description_ar')
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
