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
                                                    <th>Galileo Id</th>
                                                    <th>Ref Id</th>
                                                    <th>Journey</th>
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
                                                            <td>{{$booking->booking_ref_id}} </td>

                                                            <td  class="align-middle">
                                                                <a  href = "#" download data-bs-toggle="tooltip" title="{{$booking->fromAirport->name ?? ''}}">{{$booking->from}}</a>
                                                                @if($booking->booking_type == "roundtrip")
                                                                <i class="fa fa-exchange" title="RoundTrip" ></i> 
                                                               
                                                                @else
                                                                <i data-bs-toggle="tooltip" title="One Way" class="fa fa-arrow-right"></i>
                                                                @endif
                                                                <a  href = "#" download data-bs-toggle="tooltip" title="{{$booking->toAirport->name ?? ''}}">{{$booking->to}}</a>
                                                              </td>

                                                            <td>{{$booking->TravelersInfo[0]->first_name ?? '' }}&nbsp;{{$booking->TravelersInfo[0]->last_name ?? '' }} </td>
                                                            <td>{{$booking->Customercountry->phone_code ?? ''}}{{$booking->mobile}} </td>
                                                            {{-- <td>
                                                                <table class="table-sm  table-hover">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{$booking->TravelersInfo[0]->first_name ?? '' }}&nbsp;{{$booking->TravelersInfo[0]->last_name ?? '' }}
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{$booking->Customercountry->phone_code ?? ''}}{{$booking->mobile}}</td>
                                                                        </tr>
                                                                    
                                                                    </tbody>
                                                                </table>
                                                            </td> --}}
                                                            <td>{{$booking->currency_code}}&nbsp; {{$booking->total_amount}} </td>
                                                            <td>
                                                                <?php $pnrs = [];?>
                                                                @foreach($booking->AirlinePnr as $pnr)
                                                                <?php  $pnrs[] = $pnr->airline_pnr ;?>
                                                            @endforeach
                                                            {{implode(",",$pnrs)}}
                                                        </td>
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