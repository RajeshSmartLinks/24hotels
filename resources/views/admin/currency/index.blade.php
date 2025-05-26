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
                            @can('currency-view')
                            <a href="{{route('currency.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-plus-circle"></i>&nbsp;{{__('admin.add_currency')}} </a>
                            </a>
                            @endcan
                        </div>
                    </div>
                </section>

                <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>

                <!-- List Datatable Starts -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>{{__('admin.currency_code_english')}}</th>
                                                    <th>{{__('admin.currency_code_arabic')}}</th>
                                                    <th>{{__('admin.conversion_rate')}}</th>
                                                    <th>{{__('admin.actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($currencies) > 0)
                                                    @foreach($currencies as $currency)
                                                        <tr>
                                                            <td>{{$currency->currency_code_en}} </td>
                                                            <td>{{$currency->currency_code_ar}} </td>
                                                            <td>{{$currency->conversion_rate}} </td>
                                                          
                                                            <td>
                                                                @can('currency-edit')
                                                                <a href="{{ route('currency.edit', $currency->id) }}"><i class="feather icon-edit"></i> {{__('admin.edit')}}</a> |
                                                                @endcan
                                                                @can('currency-delete')
                                                                <a href="javascript:" class="text-danger deleteBtn" data-id="{{$currency->id}}" data-toggle="modal" data-target="#deleteModal" id="deleteBtn"><i class="feather icon-trash"></i> {{__('admin.delete')}}</a>
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
                        </div>
                    </div>
                </section>
                <!-- List Datatable Ends -->

            </div>
        </div>
    </div>
    <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>

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
