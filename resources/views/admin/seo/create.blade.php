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
                            @can('seo-view')
                            <a href="{{route('seo.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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


                                        <form class="form-horizontal" action="{{route('seo.store')}}" method="post"
                                              enctype="multipart/form-data" >
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="first-name-column">Page Type</label>
                                                        <div class="form-label-group">
                                                        <select name="page_type" class="form-control @error('page_type') is-invalid @enderror" id = "page_type" required>
                                                            <option value = "" >Select Page Type</option>
                                                            <option value = "static" {{old('page_type') == 'static' ? 'selected' : ''}}>Static</option>
                                                            <option value = "dynamic"{{old('page_type') == 'dynamic' ? 'selected' : ''}} >Dynamic</option>
                                                        </select>
                                                        @error('page_type')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        </div>
                                                    </div>
                                                </div>
 
                                                <div id = "static" class ="row"style= "display: none">
                                                    <div class="col-12">
                                                        <label for="first-name-column">Static Page</label>
                                                        <div class="form-label-group">
                                                        <select name="static_page_name" class="form-control @error('static_page_name') is-invalid @enderror" >
                                                            <option value = "" >Select Page Type</option>
                                                            <option value = "home" {{old('static_page_name') == 'home' ? 'selected' : ''}}>Home</option>
                                                            <option value = "contactUs"{{old('static_page_name') == 'contactUs' ? 'selected' : ''}} >Contact Us</option>
                                                            <option value = "aboutUs" {{old('static_page_name') == 'aboutUs' ? 'selected' : ''}}>About Us</option>
                                                            <option value = "faq" {{old('static_page_name') == 'faq' ? 'selected' : ''}} >FAQ</option>
                                                            <option value = "termsOfUse" {{old('static_page_name') == 'termsOfUse' ? 'selected' : ''}}>Terms of Use</option>
                                                            <option value = "signUp" {{old('static_page_name') == 'signUp' ? 'selected' : ''}}>Sign Up</option>
                                                            <option value = "offersListing" {{old('static_page_name') == 'offersListing' ? 'selected' : ''}}>Offers Listing</option>
                                                            <option value = "privacyPolicy" {{old('static_page_name') == 'privacyPolicy' ? 'selected' : ''}} >Privacy-Policy</option>
                                                            <option value = "flightsListing" {{old('static_page_name') == 'flightsListing' ? 'selected' : ''}} >Flights Listing</option>
                                                            <option value = "flightsDetails" {{old('static_page_name') == 'flightsDetails' ? 'selected' : ''}} >Flights Details</option>
                                                            {{-- <option value = "flightsPreview"{{old('static_page_name') == 'flightsPreview' ? 'selected' : ''}} >Flights Preview</option> --}}
                                                            <option value = "hostelListing" {{old('static_page_name') == 'hostelListing' ? 'selected' : ''}} >Hotel Listing</option>
                                                            <option value = "hotelDetails" {{old('static_page_name') == 'hotelDetails' ? 'selected' : ''}} >Hotel Details</option>
                                                        </select>
                                                        @error('static_page_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                                <div id = "dynamic" class ="row" style= "display: none">
                                                    <div class="col-12">
                                                        <label for="first-name-column">Dynamic Page Type</label>
                                                        <div class="form-label-group">
                                                        <select name="dynamic_page_type" class="form-control @error('dynamic_page_type') is-invalid @enderror" id="dynamic_page_type">
                                                            <option value = "" >Select Page Type</option>
                                                            <option value = "offers" {{old('dynamic_page_type') == 'offers' ? 'selected' : ''}}>Offers</option>
                                                            <option value = "packages" {{old('dynamic_page_type') == 'packages' ? 'selected' : ''}} >Packages</option>
                                                            <option value = "popularEvents" {{old('dynamic_page_type') == 'popularEvents' ? 'selected' : ''}} >Popular Events</option>
                                                            
                                                        </select>
                                                        @error('dynamic_page_type')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        </div>
                                                    </div>
                                                    <div id ="offers" style="display: none">
                                                        <div class="col-12">
                                                            <label for="first-name-column">Offer Name</label>
                                                            <div class="form-label-group">
                                                            <select name="offers_dynamic_page_id" class="form-control @error('dynamic_page_id') is-invalid @enderror" id ="offers_dynamic_page_id">
                                                                <option value = "" >Select Offer</option>
                                                                @foreach($offers as $offer)
                                                                <option value = "{{$offer->id}}" {{old('dynamic_page_id') == $offer->id ? 'selected' : ''}} >{{$offer->name_en}}</option>
                                                                @endforeach
                                                                
                                                            </select>
                                                            @error('dynamic_page_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id ="packages" style="display: none">
                                                        <div class="col-12">
                                                            <label for="first-name-column">Package Name</label>
                                                            <div class="form-label-group">
                                                            <select name="packages_dynamic_page_id" class="form-control @error('dynamic_page_id') is-invalid @enderror" id ="packages_dynamic_page_id">
                                                                <option value = "" >Select Package</option>
                                                                @foreach($packages as $package)
                                                                <option value = "{{$package->id}}" {{old('dynamic_page_id') == $package->id ? 'selected' : ''}} >{{$package->name_en}}</option>
                                                                @endforeach
                                                                
                                                            </select>
                                                            @error('dynamic_page_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div id ="popularEvents" style="display: none">
                                                        <div class="col-12">
                                                            <label for="first-name-column">Package Name</label>
                                                            <div class="form-label-group">
                                                            <select name="popularEvents_dynamic_page_id" class="form-control @error('dynamic_page_id') is-invalid @enderror" id ="popularEvents_dynamic_page_id">
                                                                <option value = "" >Select Package</option>
                                                                @foreach($popularEvents as $popular_event)
                                                                <option value = "{{$popular_event->id}}" {{old('dynamic_page_id') == $popular_event->id ? 'selected' : ''}} >{{$popular_event->name_en}}</option>
                                                                @endforeach
                                                                
                                                            </select>
                                                            @error('dynamic_page_id')
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
                                                        <label for="first-name-column">Status</label>
                                                        <div class="form-label-group">
                                                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                                            <option value = "" >Select Status</option>
                                                            <option value = "Active" {{old('status') == 'Active' ? 'selected' : ''}}>Active</option>
                                                            <option value = "InActive"{{old('status') == 'Active' ? 'selected' : ''}} >InActive</option>
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
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="title" name="title" value="{{old('title')}}" autocomplete="off" required>
                                                            @error('title')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea  class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Description English" name="description" required>{{old('description')}}</textarea>
                                                            @error('description')
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
        $(document).ready(function() {
            $('#page_type').change(function() {
                pageType = $(this).val();
                if(pageType == "static"){
                    $("#static").css('display', 'block');
                    $("#dynamic").css('display', 'none');
                    $("#static_page_name").attr('required', 'required');
                    $('#dynamic_page_type').removeAttr('required');
                }else if(pageType == "dynamic"){
                    $("#static").css('display', 'none');
                    $("#dynamic").css('display', 'block');
                    $("#dynamic_page_type").attr('required', 'required');
                    $('#static_page_name').removeAttr('required');
                }
            });
            $('#dynamic_page_type').change(function() {
                dynamicPageType = $(this).val();
                if(dynamicPageType == "offers"){
                    $("#offers").css('display', 'block');
                    $("#packages").css('display', 'none');
                    $("#popularEvents").css('display', 'none');
                    $("#offers_dynamic_page_id").attr('required', 'required');
                    $('#packages_dynamic_page_id').removeAttr('required');
                    $('#popularEvents_dynamic_page_id').removeAttr('required');
                }else if(dynamicPageType == "packages"){
                    $("#offers").css('display', 'none');
                    $("#packages").css('display', 'block');
                    $("#popularEvents").css('display', 'none');
                    $("#packages_dynamic_page_id").attr('required', 'required');
                    $('#offers_dynamic_page_id').removeAttr('required');
                    $('#popularEvents_dynamic_page_id').removeAttr('required');
                }else if(dynamicPageType == "popularEvents"){
                    $("#offers").css('display', 'none');
                    $("#packages").css('display', 'none');
                    $("#popularEvents").css('display', 'block');
                    $("#popularEvents_dynamic_page_id").attr('required', 'required');
                    $('#offers_dynamic_page_id').removeAttr('required');
                    $('#packages_dynamic_page_id').removeAttr('required');
                }
            });
        });
    </script>
@endsection
