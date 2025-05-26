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
                                              action="{{route('currency.update', $editcurrency->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="currency_code_en" class="form-control @error('currency_code_en') is-invalid @enderror" placeholder="{{__('admin.currency_code_english')}}" name="currency_code_en" value="{{$editcurrency->currency_code_en}}" autocomplete="off" >
                                                                @error('currency_code_en')
                                                                    <span class="invalid-feedback" role="alert">
                                                                       <strong>{{ $message }}</strong>
                                                                   </span>
                                                                @enderror       
                                                            <label for="first-name-column">{{__('admin.currency_code_english')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="currency_code_ar" class="form-control @error('currency_code_arabic') is-invalid @enderror" placeholder="{{__('admin.currency_code_arabic')}}" name="currency_code_ar" value="{{$editcurrency->currency_code_ar}}" >
                                                            @error('currency_code_ar')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="first-name-column">{{__('admin.currency_code_arabic')}}</label>
                                                        </div>
                                                    </div>

                                                   

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="conversion_rate" class="form-control @error('conversion_rate') is-invalid @enderror" placeholder="{{__('admin.conversion_rate')}}" name="conversion_rate" value="{{$editcurrency->conversion_rate}}" autocomplete="off">
                                                            @error('conversion_rate')
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror 
                                                            <label for="first-name-column">{{__('admin.conversion_rate')}}</label>
                                                        </div>
                                                    </div>
                                                    
                                                   

                                                    <div class="col-md-4 col-12"></div>
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
