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
                            @can('destination-view')
                            <a href="{{route('destinations.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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


                                        <form class="form-horizontal" action="{{route('destinations.store')}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="name_en">Name - English</label>
                                                            <input type="text" id="name_en" class="form-control @error('name_en') is-invalid @enderror" placeholder="Name - English" name="name_en" value="{{old('name_en')}}" autocomplete="off" required>
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
                                                            <input type="text" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" placeholder="Name - Arabic" name="name_ar" value="{{old('name_ar')}}" autocomplete="off"required>
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
                                                            <label for="valid_from">Order</label>
                                                            <input type="number" id="order" class="form-control @error('order') is-invalid @enderror" placeholder="Order" name="order" value="{{old('order')}}" autocomplete="off">
                                                            @error('order')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class= "col-md-6 col-12">
                                                       
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
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="meta_tag_keywords">Meta Tag Keywords</label>
                                                            
                                                            <textarea   class="form-control @error('meta_tag_keywords') is-invalid @enderror" rows="5" placeholder="Description Arabic" name="meta_tag_keywords">{{old('meta_tag_keywords')}}</textarea>
                                                            @error('meta_tag_keywords')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                       
                                                            <div class="form-group">
                                                                <label for="meta_tag_description">Meta Tag Description</label>
                                                    
                                                                <textarea   class="form-control @error('meta_tag_description') is-invalid @enderror" rows="5" placeholder="Description Arabic" name="meta_tag_description">{{old('meta_tag_description')}}</textarea>
                                                                @error('meta_tag_description')
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
                                                            <label for="description_en">Description English</label>
                                                            <textarea id="ckeditor_en" class="form-control @error('description_en') is-invalid @enderror" rows="5" placeholder="Description English" name="description_en" required>{{old('description_en')}}</textarea>
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
                                                            <textarea  id="ckeditor_ar" class="form-control @error('description_ar') is-invalid @enderror" rows="5" placeholder="Description Arabic" name="description_ar">{{old('description_ar')}}</textarea>
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



