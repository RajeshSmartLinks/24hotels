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

                {{-- <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal> --}}

                <!-- List Datatable Starts -->
                <section >
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table">
                                            <table class="table ">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Android Version</th>
                                                    <th>iOS Version</th>
                                                    <th>Updated On</th>
                                                    <th>{{__('admin.actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                               
                                                    <tr>
                                                        <td>01 </td>
                                                        <td>{{($appDetails->android)}} </td>
                                                        <td>{{($appDetails->ios)}} </td>
                                                        <td>{{isset($appDetails->updated_at)?$appDetails->updated_at->format('d/m/Y'): '---'}}</td>
                                                        <td>
                                                            @can('app-edit')
                                                            <a href="{{ route('app.edit', $appDetails->id) }}"><i class="feather icon-edit"></i> {{__('admin.edit')}}</a>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">App Ads</h4>
                                    @can('app-ads-add')
                                    <a href="{{route('app.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light"><i class="feather icon-plus-circle"></i>&nbsp;Add App Ads</a>
                                    @endcan
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Link</th>
                                                    <th>Sort Order</th>
                                                    <th>Status</th>
                                                    <th>{{__('admin.actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($appAds) > 0)
                                                    @foreach($appAds as $ads)
                                                        <tr>
                                                            <td>{{($loop->iteration)}} </td>
                                                            <td class="product-img"><img
                                                                src="{{$ads->image ?  asset('uploads/ads/'.$ads->image) : $noImage}} " width="50"/>
                                                            </td>
                                                            <td>{{($ads->link)}} </td>
                                                            <td>{{($ads->sort_order)}} </td>
                                                            <td>{{$ads->status}} </td>
                                                            <td>
                                                                @can('app-ads-edit')
                                                                <a href="{{ route('appads.edit', $ads->id) }}"><i class="feather icon-edit"></i> {{__('admin.edit')}}</a>
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
