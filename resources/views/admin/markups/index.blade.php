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
                    {{-- <div class="row">
                        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">&nbsp;</fieldset>
                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                            <a href="{{route('currency.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-plus-circle"></i>&nbsp;{{__('admin.add_currency')}} </a>
                            </a>
                        </div>
                    </div> --}}
                </section>

                <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>

                <!-- List Datatable Starts -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Flights MarkUps</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>{{__('admin.fee_type')}}</th>
                                                    <th>{{__('admin.fee_value')}}</th>
                                                    <th>{{__('admin.fee_amount')}}</th>
                                                    <th>{{__('admin.actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($markups) > 0)
                                                    @foreach($markups as $markup)
                                                        <tr>
                                                            <td>{{ucfirst($markup->fee_type)}} </td>
                                                            <td>{{ucfirst($markup->fee_value)}} </td>
                                                            <td>{{$markup->fee_amount}} </td>
                                                            <td>
                                                                @can('markups-edit')
                                                                <a href="{{ route('markups.edit', $markup->id) }}"><i class="feather icon-edit"></i> {{__('admin.edit')}}</a>
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="4">{{__('admin.no_records')}}</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Flights Additional Fee (Service Chargers)</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Currency Code</th>
                                                    <th>Value</th>
                                                    <th>credit card percentage</th>
                                                    <th>Wallet</th>
                                                    <th>Status</th>
                                                    <th>{{__('admin.actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($additionalPrices) > 0)
                                                    @foreach($additionalPrices as $additionalPrice)
                                                        <tr>
                                                            <td>{{($additionalPrice->currency_code)}} </td>
                                                            <td>{{($additionalPrice->additional_price)}} </td>
                                                            <td>{{($additionalPrice->credit_card_percentage)}} </td>
                                                            <td>{{($additionalPrice->wallet_price)}} </td>
                                                            <td>{{$markup->status}} </td>
                                                            <td>
                                                                @can('service-chargers-edit')
                                                                <a href="{{ route('additionalPriceedit', $markup->id) }}"><i class="feather icon-edit"></i> {{__('admin.edit')}}</a>
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="6">{{__('admin.no_records')}}</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div> --}}

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Hotel MarkUps</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Agency Name</th>
                                                    <th>{{__('admin.fee_type')}}</th>
                                                    <th>{{__('admin.fee_value')}}</th>
                                                    <th>{{__('admin.fee_amount')}}</th>
                                                    <th>{{__('admin.actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($hotelmarkups) > 0)
                                                    @foreach($hotelmarkups as $hotelmarkup)
                                                        <tr>
                                                            <td>{{ucfirst($hotelmarkup->AgencyName)}} </td>
                                                            <td>{{ucfirst($hotelmarkup->fee_type)}} </td>
                                                            <td>{{ucfirst($hotelmarkup->fee_value)}} </td>
                                                            <td>{{$hotelmarkup->fee_amount}} </td>
                                                            <td>
                                                                @can('hotel-markups-edit')
                                                                <a href="{{ route('hotelMarkupedit', $hotelmarkup->id) }}"><i class="feather icon-edit"></i> {{__('admin.edit')}}</a>
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="4">{{__('admin.no_records')}}</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Hotel Additional Fee (Service Chargers)</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Currency Code</th>
                                                    <th>Value</th>
                                                    <th>credit card percentage</th>
                                                    <th>Wallet</th>
                                                    <th>Status</th>
                                                    <th>{{__('admin.actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($hoteladditionalPrices) > 0)
                                                    @foreach($hoteladditionalPrices as $hoteladditionalPrice)
                                                        <tr>
                                                            <td>{{($hoteladditionalPrice->currency_code)}} </td>
                                                            <td>{{($hoteladditionalPrice->additional_price)}} </td>
                                                            <td>{{($hoteladditionalPrice->credit_card_percentage)}} </td>
                                                            <td>{{$hoteladditionalPrice->wallet_price}} </td>
                                                            <td>{{$hoteladditionalPrice->status}} </td>
                                                            <td>
                                                                @can('hotel-service-chargers-edit')
                                                                <a href="{{ route('hoteladditionalPriceedit', $hoteladditionalPrice->id) }}"><i class="feather icon-edit"></i> {{__('admin.edit')}}</a>
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="5">{{__('admin.no_records')}}</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </section>
                <!-- List Datatable Ends -->

            </div>
        </div>
    </div>

@endsection


@section('extrascript')
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

        // Functionality section

        $('.deleteBtn').on("click", function () {
            let id = $(this).data('id');
            $("#delete_id").val(id);
        });


    </script>
@endsection
