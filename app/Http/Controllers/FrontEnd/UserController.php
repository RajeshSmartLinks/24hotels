<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Models\HotelBooking;
use App\Models\WalletLogger;
use Illuminate\Http\Request;
use App\Models\FlightBooking;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {

        
    }
    public function profile()
    {
        $titles = [
            'title' => "User Profile",
        ];
        $countries = Country::select('id','country_code','name','phone_code')->orderBy('name','ASC')->get();
        return view('front_end.user.profile',compact('countries','titles'));
    }
    // public function updateProfile(Request $request,$id)
    // {
    //     // dd("ee");
    //     $this->validate($request,[
    //         'first_name' => ['required', 'string', 'max:255'],
    //         'last_name' => ['required', 'string', 'max:255'],
    //         'title' => ['required', 'string', 'max:255'],
    //         'email' => 'required|email|unique:users,email,'.decrypt($id),
    //      ]);
    //      $update = [
    //         'first_name' => $request->input('first_name'),
    //         'last_name' => $request->input('last_name'),
    //         'title' => $request->input('title'),
    //         'country_id' => $request->input('country_id'),
    //         'mobile' => $request->input('mobile'),
    //         'date_of_birth' => $request->input('date_of_birth'),
    //         'email' => $request->input('email'),
    //      ];
    //      $originalImage = $request->file('profile_pic');

    //      if ($originalImage != NULL) {
    //          $newFileName = time() . $originalImage->getClientOriginalName();
    //          $thumbnailPath = User::$imageThumbPath;
    //          $originalPath = User::$imagePath;
 
    //          // Image Upload Process
    //          $thumbnailImage = Image::make($originalImage);
 
    //          $thumbnailImage->save($originalPath . $newFileName);
    //          //$thumbnailImage->resize(150, 150);
    //          $thumbnailImage->resize(40, null, function ($constraint) {
    //              $constraint->aspectRatio();
    //              })->save($thumbnailPath . $newFileName);
    //          //$thumbnailImage->save($thumbnailPath . $newFileName);
 
    //          $update['profile_pic'] = $newFileName;
    //      }

        
    //     $user = User::where("id", decrypt($id))->update($update);

    //     $user = User::find(decrypt($id));

    //     $role = Role::where("slug","user")->first();
    //     $this->detachRole($user);
    //     $user->assignRole($role->id);
        
   
    //     return redirect()->route('profile')->with('success','User Profile have been updated successfully');
    // }

    public function updateProfile(Request $request, $id)
    {
        $userId = decrypt($id);
        $user = User::findOrFail($userId);

        $val = $this->validate($request, [
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'title'        => ['required', 'string', 'max:255'],
            'email'        => 'required|email|unique:users,email,' . $userId,
            'profile_pic'  => 'mimes:jpeg,png,jpg,gif|max:2048', // ✅ secure image validation
        ]);
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
            $mime = $request->file('profile_pic')->getMimeType();
            

            if (!in_array($mime, $allowedMimes)) {
                return back()->withErrors(['profile_pic' => 'Unsupported image type.']);
            }
       

        $update = [
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'title'         => $request->input('title'),
            'country_id'    => $request->input('country_id'),
            'mobile'        => $request->input('mobile'),
            'date_of_birth' => $request->input('date_of_birth'),
            'email'         => $request->input('email'),
        ];


        $originalImage = $request->file('profile_pic');

        if ($originalImage !== null) {
            // Secure filename generation
            $ext = $originalImage->getClientOriginalExtension();
            $newFileName = time() . '_' . uniqid() . '.' . $ext;

            $originalPath = User::$imagePath;
            $thumbnailPath = User::$imageThumbPath;

            // Clean image and save
            $image = Image::make($originalImage)->encode($ext); // Strips EXIF

            $image->save($originalPath . $newFileName);

            $image->resize(40, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnailPath . $newFileName);

            //Optional: delete old profile pic if needed
            if ($user->profile_pic && file_exists($originalPath . $user->profile_pic)) {
                unlink($originalPath . $user->profile_pic);
                @unlink($thumbnailPath . $user->profile_pic);
            }

            $update['profile_pic'] = $newFileName;
        }

        // Update user
        $user->update($update);

        // Reset and assign role
        $role = Role::where("slug", "user")->first();
        $this->detachRole($user);
        $user->assignRole($role->id);

        return redirect()->route('profile')->with('success', 'User profile has been updated successfully');
    }

    public function ChangePassword()
    {
        $titles = [
            'title' => "Change Password",
        ];
        
        return view('front_end.auth.change_password',compact('titles'));

    }

    public function UpdatePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where("id",Auth::user()->id)->update([
        'password' =>  Hash::make($request->input('new-password'))]);

        return redirect()->route('profile')->with('success','Password successfully changed!');
      
    }

    public function Bookings(Request $request)
    {
        $titles = [
            'title' => "User bookings",
        ];

        $userbookings  = FlightBooking::with('TravelersInfo','Customercountry')->where("user_id" , Auth::user()->id)->orderBy('id',"desc")->paginate(15);
        $hotelbookings  = HotelBooking::with('TravelersInfo','Customercountry')->where("user_id" , Auth::user()->id)->orderBy('id',"desc")->paginate(15);
        // dd($hotelbookings);
        
        return view('front_end.user.bookings',compact('titles','userbookings','hotelbookings'));

    }

    public function CancleBooking( Request $request)
    {
        $bookingId = $request->input('bookingId');
        $FlightBooking = FlightBooking::with('User')->find($bookingId);
        if($FlightBooking->ticket_status == 1 && $FlightBooking->booking_status == "booking_completed")
        {
            // $FlightBooking->booking_status ="cancellation_initiated";
            $FlightBooking->save();

            $user = $FlightBooking->User->first_name." ".$FlightBooking->User->last_name;

            //email sending to user


            // $emails =  explode(',',env('ADMINMAILS'));
            // //print_r($emails);
            // $emails[] = $FlightBooking->email;
            // dd($emails);

            Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) use($FlightBooking) {
                 $message->to($FlightBooking->email)
                //$message->to([$FlightBooking->email])
                //amr@masilagroup.com,ghunaim@masilagroup.com,acc@masilagroup.com
                        ->subject('your request for Cancel / ReSchedule the ticket is intiated');
            });
            Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) {
                $message->to('amr@masilagroup.com')
               //$message->to([$FlightBooking->email])
               //amr@masilagroup.com,ghunaim@masilagroup.com,acc@masilagroup.com
                       ->subject('your request for Cancel / ReSchedule the ticket is intiated');
           });
            Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) {
                 $message->to('ghunaim@masilagroup.com')
                //$message->to([$FlightBooking->email])
                //amr@masilagroup.com,ghunaim@masilagroup.com,acc@masilagroup.com
                        ->subject('your request for Cancel / ReSchedule the ticket is intiated');
            });
            Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) {
                $message->to('acc@masilagroup.com')
               //$message->to([$FlightBooking->email])
               //amr@masilagroup.com,ghunaim@masilagroup.com,acc@masilagroup.com
                       ->subject('your request for Cancel / ReSchedule the ticket is intiated');
           });

            return redirect()->back()->with('success', 'Cancellation initiated successfully'); 
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong'); 
        }
    }

    public function walletLogs(){
        $titles = [
            'title' => "Wallet logs",
        ];
        $data = null;
        if(auth()->user()->is_agent != 1){
            return view('front_end.error',compact('titles','data'));
        }

        $walletLogger = DB::table('wallet_loggers')
        ->leftJoin('flight_bookings', function ($join) {
            $join->on('wallet_loggers.reference_id', '=', 'flight_bookings.id')
                 ->where('wallet_loggers.reference_type', '=', 'flight');
        })
        ->leftJoin('hotel_bookings', function ($join) {
            $join->on('wallet_loggers.reference_id', '=', 'hotel_bookings.id')
                 ->where('wallet_loggers.reference_type', '=', 'hotel');
        })->where("wallet_loggers.user_id" , Auth::user()->id)->orderBy('wallet_loggers.id',"desc")
        ->select(
            'wallet_loggers.*',
            'flight_bookings.from as booking_from',
            'flight_bookings.to as booking_to',
            'flight_bookings.booking_type as booking_type',
            'flight_bookings.booking_ref_id as flight_booking_id',
            'hotel_bookings.booking_ref_id as hotel_booking_id'
        )
        ->paginate(15); // ✅ Laravel's pagination

        
        //wallet
        $availableWalletBalance = Auth::user()->wallet_balance ; 
        $totalRecharge = WalletLogger::where(['reference_id' => auth()->user()->id,'reference_type' => 'user','action' => 'added'])->sum('amount');
        //we need to add both flight and hotel
        $totalflight = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalHotel = HotelBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalUse = ($totalflight + $totalHotel);


        $info['availableWalletBalance'] = $availableWalletBalance;
        $info['totalRecharge'] = $totalRecharge;
        $info['totalUse'] = $totalUse;

        //$walletLogger = WalletLogger::with('FlightBooking')->where("user_id" , Auth::user()->id)->orderBy('id',"desc")->paginate(15);
        return view('front_end.user.walletLogger',compact('titles','walletLogger','info'));

    }

    public function agentDashboard(Request $request){

        $titles = [
            'title' => "Agent Dashboard",
        ];
        $data = null;
        if(auth()->user()->is_agent != 1){
            return view('front_end.error',compact('titles','data'));
        }

        $activeTab = $request->get('tab', 'flight-tab'); // Default to 'tab1' if no tab is specified

        //wallet
        $availableWalletBalance = Auth::user()->wallet_balance ; 
        $totalRecharge = WalletLogger::where(['reference_id' => auth()->user()->id,'reference_type' => 'user','action' => 'added'])->sum('amount');
        //we need to add both flight and hotel
        $totalflight = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalHotel = HotelBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalUse = ($totalflight + $totalHotel);


        //today sales
        $todayFlightSalesAmount = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereDate('created_at', today())->sum('sub_total');
        $todayHotelSalesAmount = HotelBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereDate('created_at', today())->sum('sub_total');
        $todayFlightSalesCount = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereDate('created_at', today())->count();
        $todayHotelSalesCount = HotelBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereDate('created_at', today())->count();
        $totaltodaySalesAmount = $todayFlightSalesAmount + $todayHotelSalesAmount;
        $totaltodaySalesCount = $todayFlightSalesCount + $todayHotelSalesCount;



        //monthly sales 
        $monthlyFlightSalesAmount = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('sub_total');
        $monthlyHotelSalesAmount = HotelBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('sub_total');
        $monthlyFlightSalesCount = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $monthlyHotelSalesCount = HotelBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $totalmonthlySalesAmount = $monthlyFlightSalesAmount + $monthlyHotelSalesAmount;
        $totalmonthlySalesCount = $monthlyFlightSalesCount + $monthlyHotelSalesCount;

        //total sales 
        $totalFlightSalesAmount = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalHotelSalesAmount = HotelBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalFlightSalesCount = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->count();
        $totalHotelSalesCount = HotelBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->count();
        $totalSalesAmount = $totalFlightSalesAmount + $totalHotelSalesAmount;
        $totalSalesCount = $totalFlightSalesCount + $totalHotelSalesCount;

        $userbookings  = FlightBooking::with('fromAirport','toAirport')->where("user_id" , Auth::user()->id)->orderBy('id',"desc")->whereDate('created_at', today())->paginate(5, ['*'], 'flight-tab');
        $hotelbookings  = HotelBooking::with('hotelReservation')->where("user_id" , Auth::user()->id)->orderBy('id',"desc")->whereDate('created_at', today())->paginate(1, ['*'], 'hotel-tab');

        $info = [
            'totaltodaySalesAmount' => $totaltodaySalesAmount,
            'todayFlightSalesAmount' => $todayFlightSalesAmount,
            'todayHotelSalesAmount' => $todayHotelSalesAmount,
            'todayFlightSalesCount' => $todayFlightSalesCount,
            'todayHotelSalesCount' => $todayHotelSalesCount,
            'totaltodaySalesCount' => $totaltodaySalesCount,

            'monthlyFlightSalesAmount' => $monthlyFlightSalesAmount,
            'monthlyHotelSalesAmount' => $monthlyHotelSalesAmount,
            'totalmonthlySalesAmount' => $totalmonthlySalesAmount,
            'monthlyFlightSalesCount' => $monthlyFlightSalesCount,
            'monthlyHotelSalesCount' => $monthlyHotelSalesCount,
            'totalmonthlySalesCount' => $totalmonthlySalesCount,

            'totalFlightSalesAmount' => $totalFlightSalesAmount,
            'totalHotelSalesAmount' => $totalHotelSalesAmount,
            'totalSalesAmount' => $totalSalesAmount,
            'totalFlightSalesCount' => $totalFlightSalesCount,
            'totalHotelSalesCount' => $totalHotelSalesCount,
            'totalSalesCount' => $totalSalesCount,

            'totalRecharge' => $totalRecharge,
            'totalUse' => $totalUse,
            'availableWalletBalance' => $availableWalletBalance
        ];


  

        return view('front_end.agent.dashboard',compact('titles' , 'info','userbookings','hotelbookings','activeTab'));
    }

    public function agentFlightBooking(){
        $titles = [
            'title' => "Agent Flight Booking",
        ];
        $data = null;
        if(auth()->user()->is_agent != 1){
            return view('front_end.error',compact('titles','data'));
        }

        $userbookings  = FlightBooking::with('TravelersInfo','Customercountry')->where("user_id" , Auth::user()->id)->orderBy('id',"desc")->paginate(15);
      

        return view('front_end.agent.flightBooking',compact('titles' , 'userbookings'));
    }

    public function agentHotelBooking(){
        $titles = [
            'title' => "Agent hotel Booking",
        ];
        $data = null;
        if(auth()->user()->is_agent != 1){
            return view('front_end.error',compact('titles','data'));
        }

        $hotelbookings  = HotelBooking::with('TravelersInfo','Customercountry')->where("user_id" , Auth::user()->id)->orderBy('id',"desc")->paginate(15);
 

        return view('front_end.agent.hotelBooking',compact('titles' , 'hotelbookings'));
    }
}
