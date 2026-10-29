<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agency;
use App\Models\HotelBooking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesReportController extends Controller
{
    /**
     * Display the Sales Report listing with filters.
     */
    public function index(Request $request)
    {
        if (auth()->check() && !auth()->user()->can('hotel-booking-view') && !auth()->user()->can('dashboard-view')) {
            return view('admin.abort');
        }

        $titles = [
            'title' => 'Sales reports',
            'listTitle' => 'Sales Report',
        ];

        $agencyId = $request->input('agency_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = HotelBooking::with(['Customercountry', 'TravelersInfo', 'User.agency']);

        // Filter by Agency
        if (!empty($agencyId) && $agencyId !== 'all') {
            $query->whereHas('User', function ($q) use ($agencyId) {
                $q->where('agency_id', $agencyId);
            });
        }

        // Filter by From Date
        if (!empty($fromDate)) {
            $query->whereDate('created_at', '>=', $fromDate);
        }

        // Filter by To Date
        if (!empty($toDate)) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        $bookings = $query->orderBy('id', 'DESC')->get();
        $agencies = Agency::orderBy('name', 'ASC')->get();

        $selectedAgency = (!empty($agencyId) && $agencyId !== 'all') ? Agency::find($agencyId) : null;
        $totalBookings = $bookings->count();
        $totalSales = $bookings->sum('total_amount');

        // Sales grouped by currency if multiple currencies exist
        $salesByCurrency = $bookings->groupBy(function ($item) {
            return $item->currency_code ?: 'KWD';
        })->map(function ($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('total_amount'),
            ];
        });

        return view('admin.sales_report.index', compact(
            'titles',
            'bookings',
            'agencies',
            'agencyId',
            'fromDate',
            'toDate',
            'selectedAgency',
            'totalBookings',
            'totalSales',
            'salesByCurrency'
        ));
    }

    /**
     * Display printable summary sales report.
     */
    public function printReport(Request $request)
    {
        if (auth()->check() && !auth()->user()->can('hotel-booking-view') && !auth()->user()->can('dashboard-view')) {
            return view('admin.abort');
        }

        $agencyId = $request->input('agency_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = HotelBooking::with(['Customercountry', 'TravelersInfo', 'User.agency']);

        if (!empty($agencyId) && $agencyId !== 'all') {
            $query->whereHas('User', function ($q) use ($agencyId) {
                $q->where('agency_id', $agencyId);
            });
        }

        if (!empty($fromDate)) {
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if (!empty($toDate)) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        $bookings = $query->orderBy('id', 'DESC')->get();
        $selectedAgency = (!empty($agencyId) && $agencyId !== 'all') ? Agency::find($agencyId) : null;
        $totalBookings = $bookings->count();
        $totalSales = $bookings->sum('total_amount');

        $salesByCurrency = $bookings->groupBy(function ($item) {
            return $item->currency_code ?: 'KWD';
        })->map(function ($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('total_amount'),
            ];
        });

        return view('admin.sales_report.print', compact(
            'bookings',
            'agencyId',
            'fromDate',
            'toDate',
            'selectedAgency',
            'totalBookings',
            'totalSales',
            'salesByCurrency'
        ));
    }

    /**
     * Display detailed printable sales report.
     */
    public function detailedPrint(Request $request)
    {
        if (auth()->check() && !auth()->user()->can('hotel-booking-view') && !auth()->user()->can('dashboard-view')) {
            return view('admin.abort');
        }

        $agencyId = $request->input('agency_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = HotelBooking::with(['Customercountry', 'TravelersInfo', 'User.agency', 'hotelReservation']);

        if (!empty($agencyId) && $agencyId !== 'all') {
            $query->whereHas('User', function ($q) use ($agencyId) {
                $q->where('agency_id', $agencyId);
            });
        }

        if (!empty($fromDate)) {
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if (!empty($toDate)) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        $bookings = $query->orderBy('id', 'DESC')->get();
        $selectedAgency = (!empty($agencyId) && $agencyId !== 'all') ? Agency::find($agencyId) : null;
        $totalBookings = $bookings->count();
        $totalSales = $bookings->sum('total_amount');

        $salesByCurrency = $bookings->groupBy(function ($item) {
            return $item->currency_code ?: 'KWD';
        })->map(function ($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('total_amount'),
            ];
        });

        return view('admin.sales_report.detailed_print', compact(
            'bookings',
            'agencyId',
            'fromDate',
            'toDate',
            'selectedAgency',
            'totalBookings',
            'totalSales',
            'salesByCurrency'
        ));
    }
}
