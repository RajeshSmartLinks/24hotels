@extends('admin.layouts.master')

@section('extrastyle')
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/pages/app-user.css')}}">
   
    <!-- END: Page CSS-->
@endsection


@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <x-admin-breadcrumb :title="$titles['title']"></x-admin-breadcrumb>
            </div>
            <div class="content-body">
                <!-- page users view start -->
                <section class="page-users-view">
                    <div class="row">
                        <!-- account start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Agent</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="users-view-image">
                                            <img src={{!empty($agent->profile_pic) ? asset('uploads/users/'.$agent->profile_pic) : $noImage }} class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                        </div>
                                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                            <table>
                                                <tr>
                                                    <td class="font-weight-bold">Name</td>
                                                    <td>{{$agent->first_name }} {{$agent->last_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">Email</td>
                                                    <td>{{$agent->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">Wallet</td>
                                                    <td>KWD {{$agent->wallet_balance}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-5">
                                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                                <tr>
                                                    <td class="font-weight-bold">Status</td>
                                                    <td>{{$agent->status}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="font-weight-bold">Phone</td>
                                                    <td>{{$agent->mobile}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-12">
                                            <a href="{{route('agents.edit', $agent->id)}}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> Edit</a>
                                            <button href="{{route('agents.destroy', $agent->id)}}" class="btn btn-danger mr-1"><i class="feather icon-trash-2"></i> Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- page users view end -->

           
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Wallet Logger</div>
                                </div>

                                
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>UniqueId</th>
                                                        <th>DOT</th>
                                                        <th>Amount</th>
                                                        <th>Journey</th>
                                                        <th>Status</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
            
                                                    @if(count($walletLogger) > 0)
                                                        @foreach($walletLogger as $log)
                                                            <tr>
                                                                <td>{{$log->unique_id}}</td>
                                                                <td>{{ \Carbon\Carbon::parse($log->date_of_transaction)->format('d M Y, h:i A') }}</td>
                                                                @if($log->action == 'added')
                                                                    <td style="color:green">
                                                                        {{"+ ".$log->amount}}
                                                                    </td>
                                                                @else
                                                                    <td  style="color:red">
                                                                        {{"- ".$log->amount}}
                                                                    </td>
                                                                @endif
            
                                                                @if($log->flight_booking_id !='')
                                                                <td  class="align-middle">
                                                                    <a  href = "#" download data-bs-toggle="tooltip" title="{{$log->FlightBooking->from ?? ''}}">{{$log->FlightBooking->from}}</a>
                                                                    @if($log->FlightBooking->booking_type == "roundtrip")
                                                                    <i class="fa fa-exchange" title="RoundTrip" ></i> 
                                                                    
                                                                    @else
                                                                    <i data-bs-toggle="tooltip" title="One Way" class="fa fa-arrow-right"></i>
                                                                    @endif
                                                                    <a  href = "#" download data-bs-toggle="tooltip" title="{{$log->FlightBooking->to ?? ''}}">{{$log->FlightBooking->to}}</a>
                                                                </td>
                                                                <td>{{$log->FlightBooking->booking_status}}</td>
                                                                @else
                                                                <td>---</td>
                                                                <td>---</td>
                                                                @endif
                                                                <td>{{$log->amount_description}}</td>
                                                                
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
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Flight Booking List</div>
                                </div>
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
    
                                                @if(count($bookings) > 0)
                                                    @foreach($bookings as $booking)
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
                </section>
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Hotel Booking List</div>
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
    
                                                @if(count($hotelBookings) > 0)
                                                    @foreach($hotelBookings as $booking)
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


            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection