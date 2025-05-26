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
                                {{-- <div class="card-header">
                                    <h4 class="card-title">{{$titles['listTitle']}}</h4>
                                    <a href="{{route('offers.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light"><i class="feather icon-plus-circle"></i>&nbsp;Add Offer</a>
                                </div> --}}
                               
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th> Name</th>
                                                    {{-- <th>Last Name</th> --}}
                                                    <th>Mobile</th>
                                                    <th>email</th>
                                                    <th>Type</th>
                                                    <th>Created At</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($Customers) > 0)
                                                    @foreach($Customers as $Customer)
                                                        <tr>
                                                            <th>{{$loop->iteration}}</th>
                                                            <td>{{$Customer->first_name}} {{$Customer->last_name}}</td>
                                                            {{-- <td> </td> --}}
                                                            <td>{{$Customer->bookingDetails->Customercountry->phone_code ?? ''}}{{$Customer->bookingDetails->mobile ?? ''}} </td>
                                                            <td>{{$Customer->bookingDetails->email ?? ''}} </td>
                                                            <td>{{str_replace("_"," ",$Customer->bookingDetails->user_type ?? '')}} </td>
                                                            <td>{{$Customer->created_at->format('d/m/Y')}} </td>
                                                           
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="6">No Record(s)</td>
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
    {{-- <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal> --}}

@endsection


{{-- @section('extrascript')
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
            let url = '{{ route("offers.destroy", ":id") }}';
            url = url.replace(':id', delId);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(delId);
        }
    </script>
@endsection --}}