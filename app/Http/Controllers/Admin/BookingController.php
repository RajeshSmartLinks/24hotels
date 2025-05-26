<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\FlightBooking;
use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function bookingsList()
    {
        if (!auth()->user()->can('booking-view')) {
            return view('admin.abort');
        }
        $titles = [
            'title' => "Booking List",
            //'subTitle' => "Add offer",
        ];
        //$bookings = FlightBooking::with('User')->whereIn('booking_status',['booking_completed','payment_successful','payment_failure','payment_exipre','travelport_failure',''])->orderBy('id')->get();

        $bookings = FlightBooking::with('TravelersInfo','Customercountry','fromAirport','toAirport','AirlinePnr','searchRequest')->orderBy('flight_bookings.id','DESC')->get();

        return view('admin.booking.index',compact('titles','bookings'));

    }

    public function cancleBooking(Request $request)
    {
        if (!auth()->user()->can('booking-cancel')) {
            return view('admin.abort');
        }
        $bookingId = $request->input('booking_id');
        $FlightBooking = FlightBooking::with('User')->find($bookingId);
        if($FlightBooking->ticket_status == 1 && ($FlightBooking->booking_status == "booking_completed" || $FlightBooking->booking_status == "cancellation_initiated"))
        {
            $FlightBooking->booking_status ="canceled";
            $FlightBooking->is_cancel = 1 ;
            $FlightBooking->save();

            $user = ($FlightBooking->User) ? ($FlightBooking->User->first_name." ".$FlightBooking->User->last_name) : 'Customer';

         
             //email sending to user

             Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) use($FlightBooking) {
                $message->to($FlightBooking->email)
                        ->subject('your request for Cancel / ReSchedule the ticket is intiated');
            });
            Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) use($FlightBooking) {
                $message->to('amr@masilagroup.com')
                        ->subject('your request for Cancel / ReSchedule the ticket is intiated');
            });
            Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) use($FlightBooking) {
                $message->to('ghunaim@masilagroup.com')
                        ->subject('your request for Cancel / ReSchedule the ticket is intiated');
            });
            Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) use($FlightBooking) {
                $message->to('acc@masilagroup.com')
                        ->subject('your request for Cancel / ReSchedule the ticket is intiated');
            });
            return redirect()->back()->with('success', 'Canceled successfully'); 
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong'); 
        }
    }

    public function hotelBookingsList()
    {
        if (!auth()->user()->can('hotel-booking-view')) {
            return view('admin.abort');
        }
        $titles = [
            'title' => "Hotel Booking List",
            //'subTitle' => "Add offer",
        ];
        //$bookings = FlightBooking::with('User')->whereIn('booking_status',['booking_completed','payment_successful','payment_failure','payment_exipre','travelport_failure',''])->orderBy('id')->get();

        $bookings = HotelBooking::with('Customercountry','TravelersInfo')->orderBy('hotel_bookings.id','DESC')->get();
        // dd($bookings);

        return view('admin.booking.hotel_index',compact('titles','bookings'));

    }
}
