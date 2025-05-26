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
                    <div class="col-sm-12 col-md-3">
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
                    </div>
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
                    <div class="col-sm-12 col-md-3">
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
                    </div>
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
                                            <dt class="col-sm-7 col-4"> {{__('lang.customers')}} :</dt>
                                            <dd class="col-sm-5 col-8"> {{$dashboardDetails['totalCustomers']}} </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-7 col-4">{{__('lang.booking')}} :</dt>
                                            <dd class="col-sm-5 col-8"> {{$dashboardDetails['totalBookings']}} </dd>
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
                @can('booking-view')
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Galileo Id</th>
                                                <th>Customer</th>
                                                <th>Phone No</th>
                                                <th>Total Price</th>
                                                <th>PNR</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(count($dashboardDetails['bookings']) > 0)
                                                @foreach($dashboardDetails['bookings'] as $booking)
                                                <tr>
                                                    <td>{{$loop->iteration}} </td>
                                                    <td>{{$booking->galileo_pnr}} </td>
                                                    <td>{{$booking->TravelersInfo[0]->first_name ?? '' }}&nbsp;{{$booking->TravelersInfo[0]->last_name ?? '' }} </td>
                                                    <td>{{$booking->Customercountry->phone_code ?? ''}} &nbsp;{{$booking->mobile}} </td>
                                                    <td>{{$booking->currency_code}}&nbsp; {{$booking->total_amount}} </td>
                                                    <td>{{$booking->pnr}} </td>
                                                    <td>{{str_replace("_"," ",$booking->booking_status) }}</td>
                                                    <td>{{$booking->created_at->format('d/m/Y')}} </td>
                                                    <td>
                                                        @if(!empty($booking->search_id))
                                                            <a href="javascript:" class="deleteBtn" 
                                                            data-toggle="modal" style= "color: 7367F0;"
                                                            data-target="#deleteModal{{$booking->id}}" id="deleteBtn"><i class="fa fa-info-circle"></i></a>
                                                            <!-- Delete Modal -->
                                                            <div class="modal fade text-left" id="deleteModal{{$booking->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120"
                                                            aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header  white" style="background-color: #7367F0 !important">
                                                                        <h5 class="modal-title" id="myModalLabel120" style="color: white">Booking Info</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="#" method="post" id="deleteForm">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <div class="modal-body">
                                                                            
                                                                            <p>Type : <b>{{$booking->booking_type == "roundtrip" ? "Round Trip" : 'One Way'}}</b></p>
                                                                            <p>From  : <b>{{$booking->searchRequest->flight_from}}</b></p>
                                                                            <p>To : <b>{{$booking->searchRequest->flight_to}}</b></p>
                                                                            <p>Depature Date  : <b>{{$booking->searchRequest->departure_date}}</b></p>
                                                                            @if($booking->booking_type == "roundtrip")
                                                                                <p>Return Date : <b>{{$booking->searchRequest->return_date}}</b></p>
                                                                            @endif
                                                                            <p>Carrier : <b>{{$booking->carrier_name}}</b></p>

                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" style="background-color: #7367F0 !important ;color: white" data-dismiss="modal" aria-label="Close">Close</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if(!empty($booking->flight_ticket_path))
                                                        <a  href = "{{asset($booking->flight_ticket_path)}}" download data-bs-toggle="tooltip" title="Download Ticket"><i class="fa fa-download"></i></a> | 
                                                        @endif
                                                        @if(!empty($booking->invoice_path))
                                                        <a  href = "{{asset($booking->invoice_path)}}" download data-bs-toggle="tooltip" title="Download Invoice"><i class="fa fa-file-pdf-o"></i></a> | 
                                                        @endif
                                                        @can('booking-cancel')
                                                        @if($booking->ticket_status == 1 && ($booking->booking_status == "booking_completed" || $booking->booking_status == "cancellation_initiated") && $booking->is_cancel != 1)
                                                        <a  href = "javascript:"  onclick="cancle({{$booking->id}})" data-id="{{$booking->id}}"data-bs-toggle="tooltip" title="Cancle / Reschedule" data-toggle="modal" data-target="#cancleModel" id="canclebtn"><i class="fa fa-times-circle"></i></a>
                                                        @endif
                                                        @endcan
                                                    </td>
                                                   
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr align="center" class="alert alert-danger">
                                                    <td colspan="9">No Record(s)</td>
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


    </script>
@endsection