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
                            @can('coupon-view')
                            <a href="{{route('coupons.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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


                                        <form class="form-horizontal" action="{{ route('coupons.update', $coupon->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <input type="text" class="form-control @error('coupon_title') is-invalid @enderror" placeholder="Coupon Title *"
                                                            name="coupon_title" required value="{{ old('coupon_title', $coupon->coupon_title) }}">
                                                        @error('coupon_title')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-title">Coupon Title *</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <input type="text" class="form-control @error('coupon_code') is-invalid @enderror" placeholder="Coupon Code *"
                                                            name="coupon_code" required value="{{ old('coupon_code', $coupon->coupon_code) }}">
                                                        @error('coupon_code')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-code">Coupon Code *</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <select class="form-control @error('coupon_type') is-invalid @enderror" name="coupon_type" required>
                                                            <option value="" disabled>Select Coupon Type *</option>
                                                            <option value="percentage" {{ old('coupon_type', $coupon->coupon_type) === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                            <option value="amount" {{ old('coupon_type', $coupon->coupon_type) === 'amount' ? 'selected' : '' }}>Amount</option>
                                                        </select>
                                                        @error('coupon_type')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-type">Coupon Type *</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <input type="number" step="0.01" class="form-control @error('coupon_amount') is-invalid @enderror" placeholder="Coupon Amount *"
                                                            name="coupon_amount" required value="{{ old('coupon_amount', $coupon->coupon_amount) }}">
                                                        @error('coupon_amount')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-amount">Coupon Amount *</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <input type="date" class="form-control @error('coupon_valid_from') is-invalid @enderror" placeholder="Coupon Valid From *"
                                                            name="coupon_valid_from" required min="{{ now()->format('Y-m-d') }}" value="{{ old('coupon_valid_from', $coupon->coupon_valid_from) }}">
                                                        @error('coupon_valid_from')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-valid-from">Coupon Valid From *</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <input type="date" class="form-control @error('coupon_valid_to') is-invalid @enderror" placeholder="Coupon Valid To *"
                                                            name="coupon_valid_to" required min="{{ now()->format('Y-m-d') }}" value="{{ old('coupon_valid_to', $coupon->coupon_valid_to) }}">
                                                        @error('coupon_valid_to')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-valid-to">Coupon Valid To *</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <select class="form-control @error('coupon_valid_for') is-invalid @enderror" name="coupon_valid_for" required>
                                                            <option value="" disabled>Select Coupon Valid For *</option>
                                                            <option value="0" {{ old('coupon_valid_for', $coupon->coupon_valid_for) === '0' ? 'selected' : '' }}>Multiple</option>
                                                            <option value="1" {{ old('coupon_valid_for', $coupon->coupon_valid_for) === '1' ? 'selected' : '' }}>1</option>
                                                            <option value="2" {{ old('coupon_valid_for', $coupon->coupon_valid_for) === '2' ? 'selected' : '' }}>2</option>
                                                            <option value="3" {{ old('coupon_valid_for', $coupon->coupon_valid_for) === '3' ? 'selected' : '' }}>3</option>
                                                            <option value="4" {{ old('coupon_valid_for', $coupon->coupon_valid_for) === '4' ? 'selected' : '' }}>4</option>
                                                        </select>
                                                        @error('coupon_valid_for')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-valid-for">Coupon Valid For *</label>
                                                    </div>
                                                </div>

                                               <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <select class="form-control @error('coupon_valid_on') is-invalid @enderror" name="coupon_valid_on" required>
                                                            <option value="" disabled>Select Coupon Valid On *</option>
                                                            <option value="1" {{ old('coupon_valid_on', $coupon->coupon_valid_on) == 1 ? 'selected' : '' }}>Hotels</option>
                                                            <option value="2" {{ old('coupon_valid_on', $coupon->coupon_valid_on) == 2 ? 'selected' : '' }}>Flights</option>
                                                            <option value="3" {{ old('coupon_valid_on', $coupon->coupon_valid_on) == 3 ? 'selected' : '' }}>Both</option>
                                                        </select>
                                                        @error('coupon_valid_on')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <label for="coupon-valid-on">Coupon Valid On *</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-8">
                                                    <div class="form-label-group">
                                                        <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                                            <option value="" disabled>Select Status *</option>
                                                            <option value="0" {{ old('status', $coupon->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                                            <option value="1" {{ old('status', $coupon->status) == 1 ? 'selected' : '' }}>Active</option>
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
