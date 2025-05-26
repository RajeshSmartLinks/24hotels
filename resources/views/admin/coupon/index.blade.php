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
                <!-- List Datatable Starts -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['listTitle']}}</h4>
                                    @can('coupon-add')
                                    <a href="{{route('coupons.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light"><i class="feather icon-plus-circle"></i>&nbsp;Add Coupon</a>
                                    @endcan
                                </div>
                               
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Code</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>From</th>
                                                    <td>To</td>
                                                    <td>ValidFor</td>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($coupons) > 0)
                                                        @foreach($coupons as $coupon)
                                                            <tr>
                                                                <td>{{ $coupon->coupon_title }}</td>
                                                                <td>{{ $coupon->coupon_code }}</td>
                                                                <td>{{ $coupon->coupon_type }}</td>
                                                                <td>{{ $coupon->coupon_amount }}</td>
                                                                <td>{{ $coupon->coupon_valid_from }}</td>
                                                                <td>{{ $coupon->coupon_valid_to }}</td>
                                                                <td>{{ $coupon->coupon_valid_for !=="0" ? $coupon->coupon_valid_for : 'Multiple' }}</td>


                                                                <td>
                                                                    @can('coupon-edit')
                                                                        <a href="{{ route('coupons.edit', $coupon->id) }}"><i class="feather icon-edit"></i> Edit</a> |
                                                                    @endcan

                                                                    @can('coupon-delete')
                                                                        <a href="javascript:" class="text-danger deleteBtn" onclick="destroy({{ $coupon->id }})"
                                                                            data-id="{{ $coupon->id }}" data-toggle="modal" data-target="#deleteModal"
                                                                            id="deleteBtn"><i class="feather icon-trash"></i> Delete</a>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr align="center" class="alert alert-danger">
                                                            <td colspan="8">No Record(s)</td>
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
        toastr.success('{{session('success')}}', 'success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'error');
        @endif

        // Functionality section
        function destroy(delId) {
            let url = '{{ route("coupons.destroy", ":id") }}';
            url = url.replace(':id', delId);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(delId);
        }
    </script>
@endsection