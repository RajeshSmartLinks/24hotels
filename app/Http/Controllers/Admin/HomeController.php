<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FlightBooking;
use App\Models\FlightBookingTravelsInfo;
use App\Models\GuestUser;

class HomeController extends Controller
{
    public function index()
    {
        $title ="Dashboard";
        $titles = [
            'title' => "Dashboard",
            //'subTitle' => "Add offer",
        ];
        if (!auth()->user()->can('dashboard-view')) {
            return view('admin.abort',compact('titles'));
        }
        
        $appCustomers = User::whereUserType("app")->whereBackEndUser(0)->count();
        $webCustomers = User::whereUserType("web")->whereBackEndUser(0)->count();
        $guestCustomers = GuestUser::count();
        $totalCustomers = ($appCustomers + $webCustomers + $guestCustomers);

        $totalBookings = $confirmedBookings =FlightBooking::whereIn('booking_status',['booking_completed','payment_successful'])->count();

        $websales = FlightBooking::whereIn('booking_status',['booking_completed','payment_successful'])->whereIn('user_type',['web','web_guest'])->sum('total_amount');
        $appsales = FlightBooking::whereIn('booking_status',['booking_completed','payment_successful'])->whereIn('user_type',['app','app_guest'])->sum('total_amount');
        $totalSales = ($websales+ $appsales);

        // $bookings = FlightBooking::with('User')->whereIn('booking_status',['booking_completed','payment_successful','payment_failure','payment_exipre','travelport_failure'])->orderBy('id')->get();

        if (!auth()->user()->can('booking-view')) {
            $bookings = [];
        }
        else{
            $bookings = FlightBooking::with('TravelersInfo','Customercountry','searchRequest')->whereDate('created_at', '=', date('Y-m-d'))->orderBy('id','DESC')->get();
        }

       


        $dashboardDetails = array(
            'appCustomers' => $appCustomers,
            'webCustomers' => $webCustomers,
            'guestCustomers' => $guestCustomers,
            'totalCustomers' => $totalCustomers,
            'totalBookings' => $totalBookings,
            'confirmedBookings' => $confirmedBookings,
            'canceled' => 0,
            'websales' => $websales,
            'appsales' => $appsales,
            'totalSales' => $totalSales,
            'bookings' => $bookings
        );



        
        return view('admin.dashboard',compact('title','dashboardDetails'));
    }

    public function CustomerList()
    {
      
        
        $titles = [
            'title' => "Customers List",
            //'subTitle' => "Add offer",
        ];
        if (!auth()->user()->can('customer-view')) {
            return view('admin.abort' , compact('titles'));
        }

        //$Customers = User::whereBackEndUser(0)->orderBy('id', 'desc')->get();
        $Customers = FlightBookingTravelsInfo::with('bookingDetails.Customercountry')->orderBy('id','DESC')->get(); 
       // dd($Customers[0]);

        return view('admin.customer.index',compact('titles','Customers'));

    }

   
}
