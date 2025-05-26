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
                            @can('offer-view')
                            <a href="{{route('offers.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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


                                        <form class="form-horizontal" action="{{route('offers.update', $editOffer->id)}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="name_en">Name - English</label>
                                                            <input type="text" id="name_en" class="form-control @error('name_en') is-invalid @enderror" placeholder="Name - English" name="name_en" value="{{$editOffer->name_en}}" autocomplete="off" required>
                                                            @error('name_en')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="name_ar">Name - Arabic</label>
                                                            <input type="text" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" placeholder="Name - Arabic" name="name_ar" value="{{$editOffer->name_ar}}" autocomplete="off"required>
                                                            @error('name_ar')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class= "col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="valid_from">Valid Upto</label>
                                                            <input type="text" id="valid_upto" class="form-control @error('valid_upto') is-invalid @enderror" placeholder="Valid Upto" name="valid_upto" value="{{$editOffer->valid_upto}}" autocomplete="off">
                                                            @error('valid_upto')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class= "col-md-6 col-12">
                                                        <div class="col-md-6 col-12">
                                                            <label for="first-name-column">Image</label>
                                                            <div class="form-label-group">
                                                                
                                                                <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="Brand Image" name="image">
                                                                @error('image')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="description_en">Description English</label>
                                                            <textarea id="ckeditor_en" class="form-control @error('description_en') is-invalid @enderror" rows="5" placeholder="Description English" name="description_en" required>{{$editOffer->description_en}}</textarea>
                                                            @error('description_en')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class=" col-12">
                                                        <div class="form-group">
                                                            <label for="description_ar">Description Arabic</label>
                                                            <textarea id="ckeditor_ar" class="form-control @error('description_ar') is-invalid @enderror" rows="5" placeholder="Description Arabic" name="description_ar">{{$editOffer->description_ar}}</textarea>
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
