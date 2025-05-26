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
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                    @can('push-notification-add')
                                    <a href="{{route('notifications.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light"><i class="feather icon-plus-circle"></i>&nbsp;Add Notification</a>
                                    @endcan
                                </div>
                               
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title (En)</th>
                                                    <th>Title (Ar)</th>
                                                    <th>Description (En)</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($notifications) > 0)
                                                    @foreach($notifications as $notifications)
                                                        <tr>
                                                            <td>{{$loop->iteration}} </td>
                                                            <td>{{$notifications->title_en}} </td>
                                                            <td>{{$notifications->title_ar}} </td>
                                                            <td title="{{$notifications->description_en}}"> {!! Str::limit($notifications->description_en, 20, ' ...') !!} </td>
                                                            <td>
                                                                @can('push-notification-edit')
                                                                    <a href="{{ route('notifications.edit', $notifications->id) }}"><i
                                                                            class="feather icon-edit"></i> Edit</a> |
                                                                @endcan
                                                                @can('send-push-notification')
                                                                    <a href="{{ route('sendNotification', $notifications->id) }}"><i
                                                                            class="feather icon-send"></i> Send </a> |
                                                                @endcan

                                                                @can('push-notification-delete')
                                                                    <a href="javascript:" class="text-danger deleteBtn"
                                                                       onclick="destroy({{$notifications->id}})"
                                                                       data-id="{{$notifications->id}}"
                                                                       data-toggle="modal"
                                                                       data-target="#deleteModal" id="deleteBtn"><i
                                                                            class="feather icon-trash"></i> Delete</a>
                                                                @endcan
                                                            </td>

                                                            
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="4">No Record(s)</td>
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
            let url = '{{ route("notifications.destroy", ":id") }}';
            url = url.replace(':id', delId);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(delId);
        }
    </script>
@endsection