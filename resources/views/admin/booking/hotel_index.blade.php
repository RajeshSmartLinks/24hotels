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
                <section id="horizontal-vertical">
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
                                            <table class="table zero-configuration nowrap scroll-horizontal-vertical">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Refrence Id</th>
                                                    <th>Hotel Name</th>
                                                    {{-- <th>Hotel City</th> --}}
                                                    <th>Customer</th>
                                                    <th>Phone No</th>
                                                    <th>Total Price</th>
                                                    <th>Confirmation Number</th>
                                                    <th>Status</th>
                                                    <th>Created at</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
    
                                                @if(count($bookings) > 0)
                                                    @foreach($bookings as $booking)
                                                        <tr>
                                                            
                                                            <td>{{$loop->iteration}} </td>
                                                            <td>{{$booking->booking_ref_id}} </td>
                                                            <td>{{$booking->hotel_name}} </td>


                                                            <td>{{$booking->TravelersInfo[0]->first_name ?? '' }}&nbsp;{{$booking->TravelersInfo[0]->last_name ?? '' }} </td>
                                                            <td>{{$booking->Customercountry->phone_code ?? ''}}{{$booking->mobile}} </td>
                                                          
                                                            <td>{{$booking->currency_code}}&nbsp; {{$booking->total_amount}} </td>
                                                            <td>{{$booking->confirmation_number}} </td>
                                                            
                                                            <td>{{str_replace("_"," ",$booking->booking_status) }}</td>
                                                            <td>{{$booking->created_at->format('d/m/Y')}} </td>
                                                            <td>
                                                                @if(!empty($booking->hotel_room_booking_path))
                                                                <a  href = "{{asset($booking->hotel_room_booking_path)}}" download data-bs-toggle="tooltip" title="Download Ticket"><i class="fa fa-download"></i></a> | 
                                                                @endif
                                                                
                                                                {{-- @can('booking-cancel')
                                                                @if($booking->ticket_status == 1 && ($booking->booking_status == "booking_completed" || $booking->booking_status == "cancellation_initiated") && $booking->is_cancel != 1)
                                                                <a  href = "javascript:"  onclick="cancle({{$booking->id}})" data-id="{{$booking->id}}"data-bs-toggle="tooltip" title="Cancle / Reschedule" data-toggle="modal" data-target="#cancleModel" id="canclebtn"><i class="fa fa-times-circle"></i></a>
                                                                @endif
                                                                @endcan --}}
                                                            </td>
                                                           
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="10">No Record(s)</td>
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
        // $('.zero-configuration').DataTable(
        //     {
        //         "displayLength": 50,
        //     }
        // );

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