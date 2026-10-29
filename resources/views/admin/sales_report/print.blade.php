<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - Summary - {{ config('app.name', '24Hotels') }}</title>
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
            background-color: #ff9f43;
            color: #fff;
        }
        .btn-print:hover {
            background-color: #e08731;
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
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
            font-size: 12px;
        }
        th {
            background-color: #f1f2f6;
            color: #2f3542;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        tbody tr:nth-child(even) {
            background-color: #fafbfc;
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
        .total-row {
            background-color: #f8f9fa !important;
            font-weight: 700;
            border-top: 2px solid #ced4da;
            border-bottom: 2px solid #ced4da;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

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
                size: landscape;
                margin: 12mm;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            th {
                background-color: #f1f2f6 !important;
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
            <strong>Sales Report (Summary)</strong> &mdash; Generated: {{ date('d M Y, h:i A') }}
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-print" onclick="window.print()">
                <i class="fa fa-print"></i> Print Report
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
            <div class="report-subtitle">Hotel Booking Sales Report (Summary)</div>
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
            <div class="label">Total Amount</div>
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

    <!-- Report Table -->
    <div class="table-wrapper">
        <table>
            <thead>
            <tr>
                <th style="width: 40px;">#</th>
                <th>Ref ID</th>
                <th>Hotel Name</th>
                <th>Dates</th>
                <th>Agency / Agent</th>
                <th>Customer</th>
                <th>Confirmation #</th>
                <th>Status</th>
                <th class="text-right">Total Price</th>
                <th>Booked On</th>
            </tr>
            </thead>
            <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600; color: #7367f0;">{{ $booking->booking_ref_id }}</td>
                    <td>
                        <strong>{{ $booking->hotel_name }}</strong>
                    </td>
                    <td>
                        @if(!empty($booking->check_in) || !empty($booking->check_out))
                            <span style="font-size: 11px; color: #555;">
                                In: {{ strtotime($booking->check_in) ? date('d/m/Y', strtotime($booking->check_in)) : $booking->check_in }}
                                <br>
                                Out: {{ strtotime($booking->check_out) ? date('d/m/Y', strtotime($booking->check_out)) : $booking->check_out }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if(!empty($booking->User) && !empty($booking->User->agency))
                            <strong>{{ $booking->User->agency->name }}</strong>
                            @php
                                $agentName = trim(($booking->User->first_name ?? '') . ' ' . ($booking->User->last_name ?? ''));
                                if (empty($agentName)) { $agentName = $booking->User->name ?? ''; }
                            @endphp
                            @if(!empty($agentName))
                                <br><small style="color: #666;">Agent: {{ $agentName }}</small>
                            @endif
                        @elseif(!empty($booking->User))
                            <small>{{ trim(($booking->User->first_name ?? '') . ' ' . ($booking->User->last_name ?? '')) ?: $booking->User->name }}</small>
                        @else
                            <span style="color: #aaa;">-</span>
                        @endif
                    </td>
                    <td>
                        {{ $booking->TravelersInfo[0]->first_name ?? '' }} {{ $booking->TravelersInfo[0]->last_name ?? '' }}
                        @if(!empty($booking->mobile))
                            <br><small style="color: #666;">{{ $booking->Customercountry->phone_code ?? '' }}{{ $booking->mobile }}</small>
                        @endif
                    </td>
                    <td>{{ $booking->confirmation_number ?: '-' }}</td>
                    <td>
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
                        <span class="badge {{ $badgeClass }}">
                            {{ ucwords(str_replace('_', ' ', $status)) }}
                        </span>
                    </td>
                    <td class="text-right" style="font-weight: 700;">
                        {{ $booking->currency_code }} {{ number_format($booking->total_amount, 3) }}
                    </td>
                    <td>{{ $booking->created_at ? $booking->created_at->format('d/m/Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="padding: 30px; color: #888;">
                        No bookings found for the selected criteria.
                    </td>
                </tr>
            @endforelse

            @if(count($bookings) > 0)
                <tr class="total-row">
                    <td colspan="8" class="text-right" style="font-size: 13px;">
                        TOTAL ({{ $totalBookings }} Bookings):
                    </td>
                    <td class="text-right" style="font-size: 13px; color: #28c76f;">
                        @if($salesByCurrency->count() > 1)
                            @foreach($salesByCurrency as $curr => $data)
                                <div>{{ $curr }} {{ number_format($data['total'], 3) }}</div>
                            @endforeach
                        @else
                            {{ $bookings->first()->currency_code ?? 'KWD' }} {{ number_format($totalSales, 3) }}
                        @endif
                    </td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
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
