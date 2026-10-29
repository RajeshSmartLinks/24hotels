@extends('admin.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row mb-2">
                <div class="col-12 d-flex align-items-center flex-wrap">
                    <div class="px-2 py-1 bg-white rounded shadow-sm mr-2 mb-1 mb-md-0" style="border: 1px solid #f0f0f0;">
                        <h3 class="mb-0 font-weight-bold" style="color: #ea5455; letter-spacing: 0.5px;">Sales reports</h3>
                    </div>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sales Report</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- Filter Section Starts -->
                <section id="sales-report-filter">
                    <div class="card shadow-sm border-0 mb-2">
                        <div class="card-header bg-white pb-0">
                            <h4 class="card-title font-weight-bold text-dark">Filter</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.salesReport') }}" id="filterForm">
                                    <div class="row">
                                        <div class="col-md-4 col-12 mb-1">
                                            <label class="font-weight-bold" for="agency_id">Agency</label>
                                            <select name="agency_id" id="agency_id" class="form-control select2">
                                                <option value="all" {{ (empty(request('agency_id')) || request('agency_id') == 'all') ? 'selected' : '' }}>All</option>
                                                @foreach($agencies as $agency)
                                                    <option value="{{ $agency->id }}" {{ request('agency_id') == $agency->id ? 'selected' : '' }}>
                                                        {{ $agency->name }} {{ !empty($agency->agency_code) ? '('.$agency->agency_code.')' : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-12 mb-1">
                                            <label class="font-weight-bold" for="from_date">From Date</label>
                                            <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" value="{{ request('from_date') }}">
                                        </div>
                                        <div class="col-md-4 col-12 mb-1">
                                            <label class="font-weight-bold" for="to_date">To Date</label>
                                            <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" value="{{ request('to_date') }}">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success waves-effect waves-light mr-1 px-3 shadow-sm" style="background-color: #28c76f; border-color: #28c76f; font-weight: 500; min-width: 105px;">
                                                <i class="feather icon-search mr-50"></i> Search
                                            </button>
                                            <a href="{{ route('admin.salesReport') }}" class="btn btn-danger waves-effect waves-light px-3 shadow-sm" style="background-color: #ea5455; border-color: #ea5455; font-weight: 500; min-width: 105px;">
                                                <i class="feather icon-rotate-ccw mr-50"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Filter Section Ends -->

                <!-- List Datatable Starts -->
                <section id="sales-report-list">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap pb-1">
                            <div>
                                <h4 class="card-title font-weight-bold text-dark mb-0">Sales Report</h4>
                                @if(!empty(request('agency_id')) && request('agency_id') != 'all')
                                    <span class="badge badge-light-primary mt-50">
                                        <i class="feather icon-briefcase mr-25"></i> Agency: {{ $selectedAgency->name ?? 'Selected Agency' }}
                                    </span>
                                @endif
                                @if(!empty(request('from_date')) || !empty(request('to_date')))
                                    <span class="badge badge-light-info mt-50 ml-50">
                                        <i class="feather icon-calendar mr-25"></i> 
                                        {{ request('from_date') ? date('d/m/Y', strtotime(request('from_date'))) : 'Start' }} - 
                                        {{ request('to_date') ? date('d/m/Y', strtotime(request('to_date'))) : 'Present' }}
                                    </span>
                                @endif
                            </div>
                            <!-- <div class="d-flex align-items-center mt-1 mt-sm-0">
                                <a href="{{ route('admin.salesReport.print', request()->all()) }}" target="_blank" class="btn text-white mr-1 shadow-sm waves-effect waves-light" style="background-color: #ff9f43; border-color: #ff9f43; font-weight: 500; padding: 8px 18px; border-radius: 6px;">
                                    <i class="feather icon-printer mr-50"></i> Print
                                </a>
                                <a href="{{ route('admin.salesReport.detailedPrint', request()->all()) }}" target="_blank" class="btn text-white shadow-sm waves-effect waves-light" style="background-color: #7367f0; border-color: #7367f0; font-weight: 500; padding: 8px 18px; border-radius: 6px;">
                                    <i class="feather icon-printer mr-50"></i> Detailed Print
                                </a>
                            </div> -->
                        </div>

                        <!-- Summary Cards -->
                        <div class="px-2 pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-12 mb-1 mb-md-0">
                                    <div class="border rounded p-1 d-flex align-items-center justify-content-between bg-light">
                                        <div>
                                            <span class="text-muted small d-block font-weight-bold">Total Bookings</span>
                                            <span class="h4 font-weight-bold mb-0 text-dark">{{ $totalBookings }}</span>
                                        </div>
                                        <div class="avatar bg-rgba-primary p-50 m-0">
                                            <div class="avatar-content text-primary">
                                                <i class="feather icon-check-circle font-medium-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="border rounded p-1 d-flex align-items-center justify-content-between bg-light">
                                        <div>
                                            <span class="text-muted small d-block font-weight-bold">Total Sales Amount</span>
                                            <span class="h4 font-weight-bold mb-0 text-success">
                                                @if($salesByCurrency->count() > 1)
                                                    @foreach($salesByCurrency as $curr => $data)
                                                        <span class="d-block font-small-3">{{ $curr }} {{ number_format($data['total'], 3) }}</span>
                                                    @endforeach
                                                @else
                                                    {{ $bookings->first()->currency_code ?? 'KWD' }} {{ number_format($totalSales, 3) }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content text-success">
                                                <i class="feather icon-dollar-sign font-medium-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="card-body card-dashboard pt-0">
                                <div class="table-responsive">
                                    <table class="table zero-configuration nowrap scroll-horizontal-vertical">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reference Id</th>
                                            <th>Hotel Name</th>
                                            <th>Agency</th>
                                            <th>Customer</th>
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
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <span class="font-weight-bold text-primary">{{ $booking->booking_ref_id }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold">{{ $booking->hotel_name }}</span>
                                                        @if(!empty($booking->check_in) || !empty($booking->check_out))
                                                            <br>
                                                            <small class="text-muted">
                                                                @if(!empty($booking->check_in))
                                                                    <strong>Check In:</strong> {{ strtotime($booking->check_in) ? date('d/m/Y', strtotime($booking->check_in)) : $booking->check_in }}
                                                                @endif
                                                                @if(!empty($booking->check_in) && !empty($booking->check_out))
                                                                    &nbsp;|&nbsp;
                                                                @endif
                                                                @if(!empty($booking->check_out))
                                                                    <strong>Check Out:</strong> {{ strtotime($booking->check_out) ? date('d/m/Y', strtotime($booking->check_out)) : $booking->check_out }}
                                                                @endif
                                                            </small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($booking->User) && !empty($booking->User->agency))
                                                            <span class="font-weight-bold text-dark">{{ $booking->User->agency->name }}</span>
                                                            @php
                                                                $agentName = trim(($booking->User->first_name ?? '') . ' ' . ($booking->User->last_name ?? ''));
                                                                if (empty($agentName)) {
                                                                    $agentName = $booking->User->name ?? '';
                                                                }
                                                            @endphp
                                                            @if(!empty($agentName))
                                                                <br>
                                                                <small class="text-muted"><strong>Agent:</strong> {{ $agentName }}</small>
                                                            @endif
                                                        @elseif(!empty($booking->User))
                                                            @php
                                                                $agentName = trim(($booking->User->first_name ?? '') . ' ' . ($booking->User->last_name ?? ''));
                                                                if (empty($agentName)) {
                                                                    $agentName = $booking->User->name ?? '';
                                                                }
                                                            @endphp
                                                            @if(!empty($agentName))
                                                                <small class="text-muted"><strong>Agent:</strong> {{ $agentName }}</small>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $booking->TravelersInfo[0]->first_name ?? '' }}&nbsp;{{ $booking->TravelersInfo[0]->last_name ?? '' }}
                                                        @if(!empty($booking->mobile))
                                                            <br>
                                                            <small class="text-muted">{{ $booking->Customercountry->phone_code ?? '' }}{{ $booking->mobile }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold text-dark">{{ $booking->currency_code }}&nbsp;{{ number_format($booking->total_amount, 3) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-light-secondary font-weight-bold">{{ $booking->confirmation_number ?: '-' }}</span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $status = $booking->booking_status;
                                                            $badgeClass = 'badge-light-primary';
                                                            if (in_array($status, ['booking_completed', 'payment_successful', 'Confirmed'])) {
                                                                $badgeClass = 'badge-light-success';
                                                            } elseif (in_array($status, ['canceled', 'booking_failure', 'payment_failure'])) {
                                                                $badgeClass = 'badge-light-danger';
                                                            } elseif (in_array($status, ['cancellation_initiated', 'payment_initiated', 'booking_initiated', 'booking_pending'])) {
                                                                $badgeClass = 'badge-light-warning';
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">
                                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $booking->created_at ? $booking->created_at->format('d/m/Y') : '-' }}</td>
                                                    <td>
                                                        @if(!empty($booking->hotel_room_booking_path))
                                                            <a href="{{ asset($booking->hotel_room_booking_path) }}" download data-bs-toggle="tooltip" title="Download Voucher" class="mr-1 text-primary">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        @endif
                                                        @if(!empty($booking->invoice_path))
                                                            <a href="{{ asset($booking->invoice_path) }}" download data-bs-toggle="tooltip" title="Download Invoice" class="text-info">
                                                                <i class="fa fa-file-text-o"></i>
                                                            </a>
                                                        @endif
                                                        @if(empty($booking->hotel_room_booking_path) && empty($booking->invoice_path))
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr align="center" class="alert alert-danger">
                                                <td colspan="10">No Record(s) found for the selected criteria</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
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
        @if(session('success'))
        toastr.success('{{session('success')}}', 'success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'error');
        @endif
    </script>
@endsection
