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
                                                    <th>Sr.No</th>
                                                    <th>Name</th>
                                                    <th>Phone No</th>
                                                    <th>email</th>
                                                    <th>Type</th>
                                                    <th>Created at</th>
                                                </tr>
                                                </thead>
                                                <tbody>
    
                                                @if(count($users) > 0)
                                                    @foreach($users as $user)
                                                        <tr>
                                                            
                                                            <th>{{$loop->iteration}}</th>
                                                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                            {{-- <td> </td> --}}
                                                            <td>{{$user->usercountry->phone_code ?? ''}}{{$user->mobile ?? ''}} </td>
                                                            <td>{{$user->email ?? ''}} </td>
                                                            <td>{{str_replace("_"," ",$user->user_type ?? '')}} </td>
                                                            <td>{{$user->created_at->format('d/m/Y')}} </td>
                                                           
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
    {{-- <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal> --}}
    <div class="modal fade text-left" id="cancleModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h5 class="modal-title" id="myModalLabel120">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  method="post" id="cancleForm" action="{{route('admin.cancleBooking')}}">
                @csrf
                <div class="modal-body">
                    Are you sure to Cancle the Booking
                    <input type="hidden" name="booking_id" id="booking_id" value=""/>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


@section('extrascript')
    <script>
        $('.zero-configuration').DataTable(
            {
                "displayLength": 10,
            }
        );

        @if(session('success'))
        toastr.success('{{session('success')}}', 'success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'error');
        @endif

        // Functionality section
        function cancle(id) {
            $("#booking_id").val(id);
        }
    </script>
@endsection