<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - Detailed - {{ config('app.name', '24Hotels') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
        }
        body {
            background-color: #f8f9fa;
            color: #333;
            padding: 20px;
            font-size: 13px;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }
        .no-print {
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #2d3436;
            color: #fff;
            padding: 12px 20px;
            border-radius: 6px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-print {
            background-color: #7367f0;
            color: #fff;
        }
        .btn-print:hover {
            background-color: #5e50ee;
        }
        .btn-close {
            background-color: #636e72;
            color: #fff;
        }
        .btn-close:hover {
            background-color: #4b5558;
        }
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 700;
            color: #ea5455;
            margin-bottom: 4px;
        }
        .report-subtitle {
            font-size: 16px;
            color: #555;
            font-weight: 600;
        }
        .meta-card {
            background: #fdfdfd;
            border: 1px solid #ebebeb;
            border-radius: 6px;
            padding: 15px 20px;
            margin-bottom: 25px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .meta-item .label {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            font-weight: 600;
            margin-bottom: 3px;
        }
        .meta-item .value {
            font-size: 14px;
            font-weight: 600;
            color: #222;
        }

        /* Booking Card */
        .booking-card {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-bottom: 25px;
            overflow: hidden;
            background: #fff;
            page-break-inside: avoid;
        }
        .booking-card-header {
            background-color: #f4f5f8;
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .booking-ref {
            font-size: 14px;
            font-weight: 700;
            color: #7367f0;
        }
        .booking-card-body {
            padding: 15px;
        }
        .booking-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        .info-section {
            background: #fafafa;
            border: 1px solid #f0f0f0;
            border-radius: 4px;
            padding: 10px 12px;
        }
        .info-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #7367f0;
            margin-bottom: 8px;
            border-bottom: 1px dashed #ddd;
            padding-bottom: 4px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .info-row .row-label {
            color: #777;
        }
        .info-row .row-val {
            font-weight: 600;
            color: #222;
            text-align: right;
        }

        /* Travelers Table */
        .travelers-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .travelers-table th, .travelers-table td {
            padding: 6px 10px;
            font-size: 11px;
            border: 1px solid #ebebeb;
            text-align: left;
        }
        .travelers-table th {
            background-color: #f1f2f6;
            font-weight: 700;
            text-transform: uppercase;
            color: #555;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: 600;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-success { background: #e8fadf; color: #28c76f; }
        .badge-danger { background: #fde8e8; color: #ea5455; }
        .badge-warning { background: #fff5e5; color: #ff9f43; }
        .badge-info { background: #e5f6fd; color: #00cfe8; }
        .badge-secondary { background: #ededed; color: #555; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .report-summary-box {
            background: #f8f9fa;
            border: 2px solid #ced4da;
            border-radius: 6px;
            padding: 15px 20px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            page-break-inside: avoid;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .container {
                max-width: 100%;
                box-shadow: none;
                padding: 0;
                border-radius: 0;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: portrait;
                margin: 10mm;
            }
            .booking-card {
                page-break-inside: avoid;
                border: 1px solid #ccc;
                margin-bottom: 20px;
            }
            .booking-card-header, .travelers-table th, .info-section {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Non-Printable Header Controls -->
    <div class="no-print">
        <div>
            <strong>Sales Report (Detailed Print)</strong> &mdash; Total: {{ $totalBookings }} Bookings
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-print" onclick="window.print()">
                <i class="fa fa-print"></i> Print Detailed Report
            </button>
            <button class="btn btn-close" onclick="window.close()">
                <i class="fa fa-times"></i> Close
            </button>
        </div>
    </div>

    <!-- Printable Report Header -->
    <div class="report-header">
        <div>
            <div class="brand-title">{{ config('app.name', '24Hotels') }}</div>
            <div class="report-subtitle">Hotel Booking Detailed Sales Report</div>
        </div>
        <div class="text-right">
            <div style="font-size: 11px; color: #888; text-transform: uppercase;">Generated Date</div>
            <div style="font-size: 13px; font-weight: 600;">{{ date('d-m-Y h:i A') }}</div>
        </div>
    </div>

    <!-- Filter Metadata Summary -->
    <div class="meta-card">
        <div class="meta-item">
            <div class="label">Agency Filter</div>
            <div class="value">{{ $selectedAgency ? $selectedAgency->name : 'All Agencies' }}</div>
        </div>
        <div class="meta-item">
            <div class="label">Date Range</div>
            <div class="value">
                {{ $fromDate ? date('d/m/Y', strtotime($fromDate)) : 'All' }} 
                to 
                {{ $toDate ? date('d/m/Y', strtotime($toDate)) : 'All' }}
            </div>
        </div>
        <div class="meta-item">
            <div class="label">Total Bookings</div>
            <div class="value">{{ $totalBookings }} Record(s)</div>
        </div>
        <div class="meta-item">
            <div class="label">Total Revenue</div>
            <div class="value" style="color: #28c76f;">
                @if($salesByCurrency->count() > 1)
                    @foreach($salesByCurrency as $curr => $data)
                        <span>{{ $curr }} {{ number_format($data['total'], 3) }}</span>@if(!$loop->last), @endif
                    @endforeach
                @else
                    {{ $bookings->first()->currency_code ?? 'KWD' }} {{ number_format($totalSales, 3) }}
                @endif
            </div>
        </div>
    </div>

    <!-- Bookings Detailed List -->
    @forelse($bookings as $booking)
        <div class="booking-card">
            <div class="booking-card-header">
                <div>
                    <span class="booking-ref">#{{ $loop->iteration }} | Ref: {{ $booking->booking_ref_id }}</span>
                    @if(!empty($booking->confirmation_number))
                        <span style="margin-left: 10px; font-size: 12px; color: #555;">
                            Confirm No: <strong>{{ $booking->confirmation_number }}</strong>
                        </span>
                    @endif
                </div>
                <div>
                    @php
                        $status = $booking->booking_status;
                        $badgeClass = 'badge-info';
                        if (in_array($status, ['booking_completed', 'payment_successful', 'Confirmed'])) {
                            $badgeClass = 'badge-success';
                        } elseif (in_array($status, ['canceled', 'booking_failure', 'payment_failure'])) {
                            $badgeClass = 'badge-danger';
                        } elseif (in_array($status, ['cancellation_initiated', 'payment_initiated', 'booking_initiated', 'booking_pending'])) {
                            $badgeClass = 'badge-warning';
                        }
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ ucwords(str_replace('_', ' ', $status)) }}</span>
                    @if(!empty($booking->supplier))
                        <span class="badge badge-secondary" style="margin-left: 5px;">Supplier: {{ strtoupper($booking->supplier) }}</span>
                    @endif
                    <span style="font-size: 11px; color: #777; margin-left: 10px;">
                        Booked: {{ $booking->created_at ? $booking->created_at->format('d/m/Y h:i A') : '-' }}
                    </span>
                </div>
            </div>

            <div class="booking-card-body">
                <div class="booking-grid">
                    <!-- Hotel Details -->
                    <div class="info-section">
                        <div class="info-title"><i class="fa fa-hotel"></i> Hotel Information</div>
                        <div class="info-row">
                            <span class="row-label">Hotel Name:</span>
                            <span class="row-val">{{ $booking->hotel_name }}</span>
                        </div>
                        @if(!empty($booking->hotel_code))
                            <div class="info-row">
                                <span class="row-label">Hotel Code:</span>
                                <span class="row-val">{{ $booking->hotel_code }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="row-label">Check In:</span>
                            <span class="row-val">{{ strtotime($booking->check_in) ? date('d/m/Y', strtotime($booking->check_in)) : ($booking->check_in ?: '-') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="row-label">Check Out:</span>
                            <span class="row-val">{{ strtotime($booking->check_out) ? date('d/m/Y', strtotime($booking->check_out)) : ($booking->check_out ?: '-') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="row-label">Rooms / Nights:</span>
                            <span class="row-val">{{ $booking->no_of_rooms ?: '1' }} Room(s) / {{ $booking->no_of_nights ?: '-' }} Night(s)</span>
                        </div>
                    </div>

                    <!-- Agency & Agent -->
                    <div class="info-section">
                        <div class="info-title"><i class="fa fa-briefcase"></i> Agency / Agent</div>
                        <div class="info-row">
                            <span class="row-label">Agency:</span>
                            <span class="row-val">
                                {{ $booking->User->agency->name ?? 'Direct' }}
                                @if(!empty($booking->User->agency->agency_code))
                                    ({{ $booking->User->agency->agency_code }})
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="row-label">Agent:</span>
                            <span class="row-val">
                                @if(!empty($booking->User))
                                    {{ trim(($booking->User->first_name ?? '') . ' ' . ($booking->User->last_name ?? '')) ?: ($booking->User->name ?? '-') }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        @if(!empty($booking->User->email))
                            <div class="info-row">
                                <span class="row-label">Agent Email:</span>
                                <span class="row-val">{{ $booking->User->email }}</span>
                            </div>
                        @endif
                        @if(!empty($booking->type_of_payment))
                            <div class="info-row">
                                <span class="row-label">Payment Method:</span>
                                <span class="row-val">{{ strtoupper(str_replace('_', ' ', $booking->type_of_payment)) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Customer Contact -->
                    <div class="info-section">
                        <div class="info-title"><i class="fa fa-user"></i> Primary Contact</div>
                        <div class="info-row">
                            <span class="row-label">Contact Name:</span>
                            <span class="row-val">
                                {{ $booking->TravelersInfo[0]->first_name ?? '' }} {{ $booking->TravelersInfo[0]->last_name ?? '' }}
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="row-label">Mobile:</span>
                            <span class="row-val">
                                {{ $booking->Customercountry->phone_code ?? '' }} {{ $booking->mobile }}
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="row-label">Email:</span>
                            <span class="row-val">{{ $booking->email ?: '-' }}</span>
                        </div>
                        @if(!empty($booking->Customercountry->name))
                            <div class="info-row">
                                <span class="row-label">Country:</span>
                                <span class="row-val">{{ $booking->Customercountry->name }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="info-section">
                        <div class="info-title"><i class="fa fa-money"></i> Financial Breakdown</div>
                        @if(!is_null($booking->basefare))
                            <div class="info-row">
                                <span class="row-label">Base Fare:</span>
                                <span class="row-val">{{ $booking->currency_code }} {{ number_format($booking->basefare, 3) }}</span>
                            </div>
                        @endif
                        @if(!is_null($booking->tax) && $booking->tax > 0)
                            <div class="info-row">
                                <span class="row-label">Tax:</span>
                                <span class="row-val">{{ $booking->currency_code }} {{ number_format($booking->tax, 3) }}</span>
                            </div>
                        @endif
                        @if(!is_null($booking->service_charges) && $booking->service_charges > 0)
                            <div class="info-row">
                                <span class="row-label">Service Fee:</span>
                                <span class="row-val">{{ $booking->currency_code }} {{ number_format($booking->service_charges, 3) }}</span>
                            </div>
                        @endif
                        <div class="info-row" style="border-top: 1px solid #ddd; padding-top: 5px; margin-top: 5px;">
                            <span class="row-label" style="font-weight: 700; color: #222;">Total Amount:</span>
                            <span class="row-val" style="font-size: 14px; font-weight: 700; color: #28c76f;">
                                {{ $booking->currency_code }} {{ number_format($booking->total_amount, 3) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Travelers / Guests Information Table -->
                @if(!empty($booking->TravelersInfo) && count($booking->TravelersInfo) > 0)
                    <div style="margin-top: 10px;">
                        <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #555;">
                            Travelers / Guests ({{ count($booking->TravelersInfo) }})
                        </span>
                        <table class="travelers-table">
                            <thead>
                            <tr>
                                <th style="width: 30px;">#</th>
                                <th>Title</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Traveler Type</th>
                                <th>Room No</th>
                                <th>Age / Gender</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($booking->TravelersInfo as $tIndex => $traveler)
                                <tr>
                                    <td>{{ $tIndex + 1 }}</td>
                                    <td>{{ $traveler->title ?: '-' }}</td>
                                    <td><strong>{{ $traveler->first_name }}</strong></td>
                                    <td><strong>{{ $traveler->last_name }}</strong></td>
                                    <td>{{ $traveler->traveler_type ?: 'Adult' }}</td>
                                    <td>Room {{ $traveler->room_no ?: '1' }}</td>
                                    <td>
                                        @if(!empty($traveler->age))
                                            Age: {{ $traveler->age }}
                                        @endif
                                        @if(!empty($traveler->gender))
                                            ({{ ucfirst($traveler->gender) }})
                                        @endif
                                        @if(empty($traveler->age) && empty($traveler->gender))
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 40px; color: #888; background: #fff; border: 1px dashed #ccc; border-radius: 6px;">
            No hotel bookings found for the selected criteria.
        </div>
    @endforelse

    <!-- Grand Summary Box -->
    @if(count($bookings) > 0)
        <div class="report-summary-box">
            <div>
                <strong style="font-size: 14px; color: #222;">Total Bookings:</strong>
                <span style="font-size: 16px; font-weight: 700; color: #7367f0; margin-left: 5px;">{{ $totalBookings }}</span>
            </div>
            <div>
                <strong style="font-size: 14px; color: #222;">Grand Total Revenue:</strong>
                <span style="font-size: 16px; font-weight: 700; color: #28c76f; margin-left: 5px;">
                    @if($salesByCurrency->count() > 1)
                        @foreach($salesByCurrency as $curr => $data)
                            <span>{{ $curr }} {{ number_format($data['total'], 3) }}</span>@if(!$loop->last), @endif
                        @endforeach
                    @else
                        {{ $bookings->first()->currency_code ?? 'KWD' }} {{ number_format($totalSales, 3) }}
                    @endif
                </span>
            </div>
        </div>
    @endif
</div>

<script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            window.print();
        }, 500);
    });
</script>

</body>
</html>
