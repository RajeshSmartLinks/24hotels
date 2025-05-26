@extends('admin.layouts.master')

@section('extracss')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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
                            @can('coupon-view')
                            <a href="{{route('coupons.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-list"></i>&nbsp;Go to List</a>
                            </a>
                            @endcan
                        </div>
                    </div>
                </section>

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
                                        {{-- <x-admin-error-list-show></x-admin-error-list-show> --}}

                                        <form class="form-horizontal" action="{{ route('coupons.store') }}" method="post" enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control @error('coupon_title') is-invalid @enderror" placeholder="Coupon Title *"
                                                                name="coupon_title" required>
                                                            @error('coupon_title')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="coupon-title">Coupon Title *</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control @error('coupon_code') is-invalid @enderror" placeholder="Coupon Code *"
                                                                name="coupon_code" required>
                                                            @error('coupon_code')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="coupon-code">Coupon Code *</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-label-group">
                                                            <select class="form-control @error('coupon_type') is-invalid @enderror" name="coupon_type" required>
                                                                <option value="" disabled selected>Select Coupon Type *</option>
                                                                <option value="percentage">Percentage</option>
                                                                <option value="amount">Amount</option>
                                                            </select>
                                                            @error('coupon_type')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="coupon-type">Coupon Type *</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-label-group">
                                                            <input type="number" step="0.01" class="form-control @error('coupon_amount') is-invalid @enderror" placeholder="Coupon Amount *"
                                                                name="coupon_amount" required>
                                                            @error('coupon_amount')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="coupon-amount">Coupon Amount *</label>
                                                        </div>
                                                    </div>
                                                   <div class="col-md-8 col-12">
                                                        <div class="form-label-group">
                                                            <input type="date" class="form-control @error('coupon_valid_from') is-invalid @enderror" placeholder="Coupon Valid From *"
                                                                   name="coupon_valid_from" required min="{{ now()->format('Y-m-d') }}">
                                                            @error('coupon_valid_from')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="coupon-valid-from">Coupon Valid From *</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-label-group">
                                                            <input type="date" class="form-control @error('coupon_valid_to') is-invalid @enderror" placeholder="Coupon Valid To *"
                                                                   name="coupon_valid_to" required min="{{ now()->format('Y-m-d') }}">
                                                            @error('coupon_valid_to')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="coupon-valid-to">Coupon Valid To *</label>
                                                        </div>
                                                    </div>

                                                  <div class="col-md-8 col-12">
                                                    <div class="form-label-group">
                                                        <select class="form-control @error('coupon_valid_for') is-invalid @enderror" name="coupon_valid_for" required>
                                                            <option value="" disabled selected>Select Coupon Valid For *</option>
                                                            <option value="0">Multiple</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                        </select>
                                                        @error('coupon_valid_for')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-valid-for">Coupon Valid For *</label>
                                                    </div>
                                                </div>

                                                    <div class="col-md-8 col-12">
                                                        <div class="form-label-group">
                                                            <select class="form-control @error('coupon_valid_on') is-invalid @enderror" name="coupon_valid_on" required>
                                                                <option value="" disabled selected>Select Coupon Valid On *</option>
                                                                <option value="1">Hotels</option>
                                                                <option value="2">Flights</option>
                                                                <option value="3">Both</option>
                                                            </select>
                                                            @error('coupon_valid_on')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="coupon-valid-on">Coupon Valid On *</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-label-group">
                                                            <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                                                <option value="" disabled selected>Select Status *</option>
                                                                <option value="0">Inactive</option>
                                                                <option value="1">Active</option>
                                                            </select>
                                                            @error('status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="status">Status *</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8 offset-md-4">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>
                                                    </div>
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
 
        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });
</script>
@endsection
