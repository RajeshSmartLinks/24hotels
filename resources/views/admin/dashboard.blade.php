@extends('admin.layouts.master')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                <div class="row match-height ">
                    <!-- Description lists horizontal -->
                    {{-- <div class="col-sm-12 col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('lang.total_customer')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="card-text">
                                        <dl class="row">
                                            <dt class="col-sm-7 col-7"> {{__('lang.app')}} :</dt>
                                            <dd class="col-sm-5 col-5"> {{$dashboardDetails['appCustomers']}} </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-7 col-7"> {{__('lang.web')}} :</dt>
                                            <dd class="col-sm-5 col-5"> {{$dashboardDetails['webCustomers']}} </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-7 col-7"> {{__('lang.guest')}} :</dt>
                                            <dd class="col-sm-5 col-5"> {{$dashboardDetails['guestCustomers']}} </dd>
                                        </dl>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!--/ Description lists horizontal-->
                    <!-- Description lists horizontal -->
                    <div class="col-sm-12 col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> {{__('lang.total_bookings')}}  </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="card-text">
                                        <dl class="row">
                                            <dt class="col-sm-7 col-7">{{__('lang.total')}} :</dt>
                                            <dd class="col-sm-5 col-5">{{$dashboardDetails['totalBookings']}}</dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-7 col-7">{{__('lang.confirmed')}} :</dt>
                                            <dd class="col-sm-5 col-5"> {{$dashboardDetails['confirmedBookings']}}</dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-7 col-7">{{__('lang.canceled')}} :</dt>
                                            <dd class="col-sm-5 col-5"> 0 </dd>
                                        </dl>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Description lists horizontal-->
                    <!-- Description lists horizontal -->
                    {{-- <div class="col-sm-12 col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('lang.total_sales')}} </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="card-text">
                                        <dl class="row">
                                            <dt class="col-sm-5 col-5">{{__('lang.total')}} :</dt>
                                            <dd class="col-sm-7 col-7"> {{$dashboardDetails['totalSales']}} </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-5 col-5">{{__('lang.web')}} :</dt>
                                            <dd class="col-sm-7 col-7"> {{$dashboardDetails['websales']}} </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-5 col-5">{{__('lang.app')}} :</dt>
                                            <dd class="col-sm-7 col-7"> {{$dashboardDetails['appsales']}} </dd>
                                        </dl>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!--/ Description lists horizontal-->
                    <!-- Description lists horizontal -->
                    <div class="col-sm-12 col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> {{__('lang.total_statistics')}} </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="card-text">
                                        <dl class="row">
                                            <dt class="col-sm-7 col-4">Agencies :</dt>
                                            <dd class="col-sm-5 col-8"> {{$dashboardDetails['agencies']}} </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-7 col-4">Agents :</dt>
                                            <dd class="col-sm-5 col-8"> {{$dashboardDetails['agents']}} </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-7 col-4">{{__('lang.sales')}} :</dt>
                                            <dd class="col-sm-5 col-8"> {{$dashboardDetails['totalSales']}} </dd>
                                        </dl>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Description lists horizontal-->


                   
                </div>
                @can('hotel-booking-cancellation')
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> Hotel Bookings Cancellation Requests  </h4>
                            </div>
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
    
                                                @if(count($dashboardDetails['hotelCancellationRequests']) > 0)
                                                    @foreach($dashboardDetails['hotelCancellationRequests'] as $booking)
                                                        <tr>
                                                            
                                                            <td>{{$loop->iteration}} </td>
                                                            <td>{{$booking->booking_ref_id}} </td>
                                                            <td>{{$booking->hotel_name}} </td>


                                                            <td>{{$booking->TravelersInfo[0]->first_name ?? '' }}&nbsp;{{$booking->TravelersInfo[0]->last_name ?? '' }} </td>
                                                            <td>{{$booking->Customercountry->phone_code ?? ''}}{{$booking->mobile}} </td>
                                                          
                                                            <td>{{$booking->currency_code}}&nbsp; {{$booking->total_amount}} </td>
                                                            <td>{{$booking->confirmations->pluck('booking_reference_no')->implode(', ')}} </td>
                                                            
                                                            <td>{{str_replace("_"," ",$booking->booking_status) }}</td>
                                                            <td>{{$booking->created_at->format('d/m/Y')}} </td>
                                                            <td>
                                                                @if(!empty($booking->hotel_room_booking_path))
                                                                <a  href = "{{asset($booking->hotel_room_booking_path)}}" download data-bs-toggle="tooltip" title="Download Ticket"><i class="fa fa-download"></i></a> | 
                                                                @endif
                                                                
                                                                @can('hotel-booking-cancellation')
                                                                @if($booking->booking_status == "cancellation_initiated")
                                                                <a  href = "javascript:"  onclick="cancle({{$booking->id}})" data-id="{{$booking->id}}"data-bs-toggle="tooltip" title="Cancle Booking" data-toggle="modal" data-target="#cancleModel" id="canclebtn"><i class="fa fa-times-circle"></i></a>
                                                                @endif
                                                                @endcan
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
                @endcan
                @can('booking-view')
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
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
    
                                                @if(count($dashboardDetails['hotelBookings']) > 0)
                                                    @foreach($dashboardDetails['hotelBookings'] as $booking)
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
                @endcan
               
            </section>
            <!-- Dashboard Analytics end -->

        </div>
    </div>
</div>
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
            <form  method="post" id="cancleForm" action="{{route('admin.hotel.cancleBooking')}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="booking_id" value="">
                    
                    <label for="first-name-column"> Is Cancellation Done ?</label>
                    <br>
                    <div class="form-label-group" style="padding: 10px 0px;">
                        <select name="cancel_status" class="form-control " id="basicSelect" required>
                            <option value="">--select --</option>
                            <option value="canceled">Yes</option>
                            <option value="cancellation_failure">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('extrascript')
    <script>


        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif

        // Functionality section
        function cancle(id) {
            $("#booking_id").val(id);
        }


    </script>
@endsection