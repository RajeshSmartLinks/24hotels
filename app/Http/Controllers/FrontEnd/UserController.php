<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Role;
use App\Models\User;
use App\Models\Agency;
use App\Models\Country;
use App\Models\HotelMarkUp;
use App\Models\HotelBooking;
use App\Models\WalletLogger;
use Illuminate\Http\Request;
use App\Models\FlightBooking;
use Illuminate\Support\Carbon;
use App\Models\HotelXmlRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\HotelRoomBookingInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\FrontEnd\Hotel\Xml\BookingController;

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
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));
        //dd(Auth::user()->agency->country_id??'');
        return view('front_end.user.profile',compact('countries','titles','noImage'));
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
        //dd($request->input());
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
        if(!empty($request->file('profile_pic'))){
            $mime = $request->file('profile_pic')->getMimeType();
            if (!in_array($mime, $allowedMimes)) {
                return back()->withErrors(['profile_pic' => 'Unsupported image type.']);
            }
        }

        $update = [
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'title'         => $request->input('title'),
            'country_id'    => $request->input('country_id'),
            'mobile'        => $request->input('mobile'),
            //'date_of_birth' => $request->input('date_of_birth'),
            'email'         => $request->input('email'),
            'alter_mobile_country_id'    => $request->input('alter_mobile_country_id') ?? null,
            'alter_mobile_number'        => $request->input('alter_mobile_number') ?? null,
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
        // dd($user);

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
        'password' =>  Hash::make($request->input('new-password')),'first_login' => 0]);

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

        $userid = [];
        if(Auth::user()->is_master_agent ==1){
            User::where(['agency_id' => Auth::user()->agency_id])->get();
            foreach (User::where(['agency_id' => Auth::user()->agency_id])->get() as $key => $value) {
                $userid[] = $value->id;
            }
        }else{
            $userid[] = Auth::user()->id;
        }

        $walletLogger = DB::table('wallet_loggers')
        ->leftJoin('flight_bookings', function ($join) {
            $join->on('wallet_loggers.reference_id', '=', 'flight_bookings.id')
                 ->where('wallet_loggers.reference_type', '=', 'flight');
        })
        ->leftJoin('hotel_bookings', function ($join) {
            $join->on('wallet_loggers.reference_id', '=', 'hotel_bookings.id')
                 ->where('wallet_loggers.reference_type', '=', 'hotel');
        })->whereIn('wallet_loggers.user_id', $userid)
        //->where("wallet_loggers.user_id" , Auth::user()->id)
        ->orderBy('wallet_loggers.id',"desc")
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
      
        $availableWalletBalance = Auth::user()->agency->wallet_balance ;
        $totalRecharge = WalletLogger::where(['reference_id' => auth()->user()->id,'reference_type' => 'user','action' => 'added'])->sum('amount');
        //we need to add both flight and hotel
        //$totalflight = FlightBooking::where(['user_id' => auth()->user()->id,'booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalHotel = HotelBooking::where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereIn('user_id', $userid)->sum('sub_total');
        $totalUse = ($totalHotel);


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
        if(auth()->user()->is_master_agent == 1){
            $subagentsDeatils = User::where('agency_id', auth()->user()->agency_id)->pluck('id');
            $userIds = $subagentsDeatils->toArray();
        }else{
            $userIds = [auth()->user()->id];
        }

        $activeTab = $request->get('tab', 'flight-tab'); // Default to 'tab1' if no tab is specified

        //wallet
        //dd(Auth::user()->agency);
        $availableWalletBalance = Auth::user()->agency->wallet_balance ?? 0; 
        $totalRecharge = WalletLogger::whereIn('reference_id' , $userIds)->where(['reference_type' => 'user','action' => 'added'])->sum('amount');
        //we need to add both flight and hotel
        $totalflight = FlightBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalHotel = HotelBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalUse = ($totalflight + $totalHotel);


        //today sales
        $todayFlightSalesAmount = FlightBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereDate('created_at', today())->sum('sub_total');
        $todayHotelSalesAmount = HotelBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereDate('created_at', today())->sum('sub_total');
        $todayFlightSalesCount = FlightBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereDate('created_at', today())->count();
        $todayHotelSalesCount = HotelBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereDate('created_at', today())->count();
        $totaltodaySalesAmount = $todayFlightSalesAmount + $todayHotelSalesAmount;
        $totaltodaySalesCount = $todayFlightSalesCount + $todayHotelSalesCount;



        //monthly sales 
        $monthlyFlightSalesAmount = FlightBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('sub_total');
        $monthlyHotelSalesAmount = HotelBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('sub_total');
        $monthlyFlightSalesCount = FlightBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $monthlyHotelSalesCount = HotelBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $totalmonthlySalesAmount = $monthlyFlightSalesAmount + $monthlyHotelSalesAmount;
        $totalmonthlySalesCount = $monthlyFlightSalesCount + $monthlyHotelSalesCount;

        //total sales 
        $totalFlightSalesAmount = FlightBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalHotelSalesAmount = HotelBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->sum('sub_total');
        $totalFlightSalesCount = FlightBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->count();
        $totalHotelSalesCount = HotelBooking::whereIn('user_id' , $userIds)->where(['booking_status' => 'booking_completed','payment_gateway' => 'WALLET'])->count();
        $totalSalesAmount = $totalFlightSalesAmount + $totalHotelSalesAmount;
        $totalSalesCount = $totalFlightSalesCount + $totalHotelSalesCount;

        $userbookings  = FlightBooking::with('fromAirport','toAirport')->whereIn('user_id' , $userIds)->orderBy('id',"desc")->whereDate('created_at', today())->paginate(5, ['*'], 'flight-tab');
        $hotelbookings  = HotelBooking::with('hotelReservation','User')->whereIn('user_id' , $userIds)->orderBy('id',"desc")->whereDate('created_at', today())->paginate(10, ['*'], 'hotel-tab');

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
        foreach ($hotelbookings as $key => $value) {
            if ($value['booking_status'] == 'booking_completed') {
                if($value['supplier'] == 'webbeds'){
                     $bookingXML = HotelXmlRequest::find($value['webbeds_booking_request_id']);
                    $parsedResponse = XmlToArrayWithHTML($bookingXML->response_xml);

                    $dom = new \DOMDocument();
                    libxml_use_internal_errors(true);
                    $dom->loadHTML($parsedResponse['confirmationText_html']);
                    libxml_clear_errors();

                    $xpath = new \DOMXPath($dom);

                    // Get ALL <ul> elements that come after "Cancellation Rules"
                    $ulNodes = $xpath->query("//strong[contains(text(),'Cancellation Rules:')]/following::ul");

                    $rooms = [];
                    $roomIndex = 1;

                    foreach ($ulNodes as $ul) {
                        $rulesNodes = $xpath->query(".//li", $ul);

                        $rules = [];
                        foreach ($rulesNodes as $li) {
                            $cleanText = preg_replace('/\s+/', ' ', trim($li->textContent));
                            $rules[] = $cleanText;
                        }

                        $rooms[] = [
                            'room'  => "Room " . $roomIndex,
                            'rules' => $rules
                        ];

                        $roomIndex++;
                    }

                    // ✅ Attach to the booking model in the collection
                    $hotelbookings[$key]['cancellation_rules'] = $rooms;

                    
                }
                elseif($value['supplier'] == 'dida'){
                    $bookingJson = HotelXmlRequest::find($value['webbeds_booking_request_id']);
                    $bookingInfo = json_decode($bookingJson->json_response , true);

                    $rooms = [];

                    foreach($bookingInfo['Success']['BookingDetails']['Hotel']['RatePlanList'] as $rkey => $rvalue){

                        $rooms[] = convertCancellationRulesForDida($bookingInfo['Success']['BookingDetails']['Hotel']['CancellationPolicyList'] ,$rvalue['Currency'],(int)$value['no_of_rooms'], 'Room '.($rkey+1));
                    }

                    // ✅ Attach to the booking model in the collection
                    $hotelbookings[$key]['cancellation_rules'] = $rooms;
                }
                else{
                    $hotelbookings[$key]['cancellation_rules'] = [];
                }

               
            } else {
                // ensure empty if no rules
                $hotelbookings[$key]['cancellation_rules'] = [];
            }
        }


  

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

    public function agentHotelBooking(Request $request){
        $searchKey = $request->query('searchKey'); 
        $titles = [
            'title' => "Agent hotel Booking",
        ];
        $data = null;
        if(auth()->user()->is_agent != 1){
            return view('front_end.error',compact('titles','data'));
        }
        if(Auth::user()->is_master_agent == 1){
            $subagentsDeatils = User::where('agency_id', Auth::user()->agency_id)->pluck('id');
            $userIds = $subagentsDeatils->toArray();
        }else{
            $userIds = [Auth::user()->id];
        }

       $hotelbookings  = HotelBooking::with('TravelersInfo','Customercountry','User')
        ->whereIn("user_id" , $userIds)
        ->where(function ($query) use ($searchKey) {
            $query->where('hotel_bookings.hotel_name', 'like', '%' . $searchKey . '%')
                ->orWhere('hotel_bookings.booking_ref_id', 'like', '%' . $searchKey . '%')
                ->orWhereHas('User', function ($q) use ($searchKey) {
                    $q->where('first_name', 'like', '%' . $searchKey . '%')
                        ->orWhere('last_name', 'like', '%' . $searchKey . '%');
                })
                ->orWhereHas('TravelersInfo', function ($q) use ($searchKey) {
                    $q->where('first_name', 'like', '%' . $searchKey . '%')
                        ->orWhere('last_name', 'like', '%' . $searchKey . '%');
                });
        })
        ->orderBy('id',"desc")
        ->paginate(15);

        foreach ($hotelbookings as $key => $value) {
            if ($value['booking_status'] == 'booking_completed' ) {
                if($value['supplier'] == 'webbeds'){
                    
                    $bookingXML = HotelXmlRequest::find($value['webbeds_booking_request_id']);
                    $parsedResponse = XmlToArrayWithHTML($bookingXML->response_xml);

                    $dom = new \DOMDocument();
                    libxml_use_internal_errors(true);
                    $dom->loadHTML($parsedResponse['confirmationText_html']);
                    libxml_clear_errors();

                    $xpath = new \DOMXPath($dom);

                    // Get ALL <ul> elements that come after "Cancellation Rules"
                    $ulNodes = $xpath->query("//strong[contains(text(),'Cancellation Rules:')]/following::ul");

                    $rooms = [];
                    $roomIndex = 1;

                    foreach ($ulNodes as $ul) {
                        $rulesNodes = $xpath->query(".//li", $ul);

                        $rules = [];
                        foreach ($rulesNodes as $li) {
                            $cleanText = preg_replace('/\s+/', ' ', trim($li->textContent));
                            $rules[] = $cleanText;
                        }

                        $rooms[] = [
                            'room'  => "Room " . $roomIndex,
                            'rules' => $rules
                        ];

                        $roomIndex++;
                    }

                    // ✅ Attach to the booking model in the collection
                    $hotelbookings[$key]['cancellation_rules'] = $rooms;

                }
                elseif($value['supplier'] == 'dida'){
                    $bookingJson = HotelXmlRequest::find($value['webbeds_booking_request_id']);
                    $bookingInfo = json_decode($bookingJson->json_response , true);

                    $rooms = [];

                    foreach($bookingInfo['Success']['BookingDetails']['Hotel']['RatePlanList'] as $rkey => $rvalue){

                        $rooms[] = convertCancellationRulesForDida($bookingInfo['Success']['BookingDetails']['Hotel']['CancellationPolicyList'] ,$rvalue['Currency'],(int)$value['no_of_rooms'], 'Room '.($rkey+1));
                    }

                    // ✅ Attach to the booking model in the collection
                    $hotelbookings[$key]['cancellation_rules'] = $rooms;
                }
                else{
                    $hotelbookings[$key]['cancellation_rules'] = [];
                }


            } else {
                // ensure empty if no rules
                $hotelbookings[$key]['cancellation_rules'] = [];
            }
        }
        //dd($hotelbookings);

        return view('front_end.agent.hotelBooking',compact('titles' , 'hotelbookings'));
    }

    public function addSubAgent(){
        if(Auth::user()->is_master_agent != 1){
            return view('errors.500');
        }
        $titles = [
            'title' => "Add Sub Agent",
        ];

        $countries = Country::select('id','country_code','name','phone_code')->orderBy('name','ASC')->get();
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        return view('front_end.agent.addSubAgent',compact('titles' , 'countries','noImage'));
    }

    public function storeAgent(Request $request){
        if(Auth::user()->is_master_agent != 1){
            return view('errors.500');
        }
        $titles = [
            'title' => "Add Sub Agent",
        ];
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'mobile' => 'required',
            'title' => 'required|string|max:255',
            'country_id' => 'required',
        ]);

        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = 'Active';
        $user->is_agent = 1 ;
        $user->mobile = $request->mobile;
        $user->agency_id =  Auth::user()->agency_id ;
        $user->save();

        //getting markups from master agent
        $hotelMartkUp = HotelMarkUp::where('user_id', Auth::user()->id)->first();

        //adding in hotel markups
        $hotelMarkup = new HotelMarkUp;
        $hotelMarkup->user_id = $user->id;
        $hotelMarkup->fee_type = $hotelMartkUp->fee_type; 
        $hotelMarkup->fee_value = $hotelMartkUp->fee_value;
        $hotelMarkup->fee_amount = $hotelMartkUp->fee_amount;
        $hotelMarkup->status = 'Active';
        $hotelMarkup->save();

        return redirect()->route('agent-list')->with('success','Agent Added Successfully');
    }

    public function agentList(){
        if(Auth::user()->is_master_agent != 1){
            return view('errors.500');
        }
        $titles = [
            'title' => "Agent List"
        ];

        $agents = User::where('is_agent',1)->where('is_master_agent',0)->where('agency_id',Auth::user()->agency_id)->orderBy('id','DESC')->paginate(15);;
        return view('front_end.agent.agentList',compact('titles','agents'));

    }
     public function hotelBookingcancellation( Request $request)
    {
        $bookingId = $request->input('bookingId');
        $HotelBooking = HotelBooking::find($bookingId);
        $bookingController = new BookingController();
        //fetching booking Ids
        $HotelConfirmationResponse = HotelXmlRequest::find($HotelBooking->webbeds_booking_request_id);
        $failure = false;
        $message = [];
        if($HotelBooking->supplier == 'webbeds'){
            $parsedResponse = XmlToArrayWithHTML($HotelConfirmationResponse->response_xml);
            //we need to send booking code request indiviually 
       
            //node Convertion
            $parsedResponse['bookings']['booking'] = nodeConvertion($parsedResponse['bookings']['booking']);
    

            foreach($parsedResponse['bookings']['booking'] as $key =>$details){
                $Info = [
                    'booking_id' => $HotelBooking->id,
                    'confirmCancellation' => 'no',
                    'bookingCode' => $details['bookingCode'],
                ];
                $cancellationNoResp = $bookingController->CancelBooking($Info);
                $cancellationNoResponseDetails[] = $cancellationNoResp;

                if(isset($cancellationNoResp['cancellationInfo']['hotelResponse']['request']['successful']) && ($cancellationNoResp['cancellationInfo']['hotelResponse']['request']['successful'] == "FALSE")){
                    $failure = true;
                    $message[] = 'Room - '.($key+1).' : '.$cancellationNoResp['cancellationInfo']['hotelResponse']['request']['error']['details'];
                }
            }
            
        }elseif($HotelBooking->supplier == 'dida'){

            //sendinmg  booking code
             $Info = [
                    'dida_booking_id' => $HotelBooking->booking_reference_number,
                    'confirmCancellation' => 'no',
                    'hotel_booking_id' => $HotelBooking->id,
                ];
            $cancellationNoResp = $bookingController->DidaCancelBooking($Info);
            if(isset($cancellationNoResp['response']['Error']['Message'])){
                $failure = true;
                $message[] = $cancellationNoResp['response']['Error']['Message'];
            }
        }
        if($failure){
            return response()->json(['status' => false, 'message' => $message]);
        }

        //now confirming cancellation
        $penalityAmount = 0;
        $partiallyCanceled = false;
        $penalityCurrency = 'KWD';
        $cancellationFailure = false;

        if($HotelBooking->supplier == 'webbeds'){
            foreach($parsedResponse['bookings']['booking'] as $key =>$details){
                //fetching cancellation NO responses
                $cancallationNOresponses = $cancellationNoResponseDetails[$key];
                $cancallationNOresponses['cancellationInfo']['hotelResponse']['services']['service'] = nodeConvertion($cancallationNOresponses['cancellationInfo']['hotelResponse']['services']['service']);
        
                //dd($cancallationNOresponses['cancellationInfo']['hotelResponse'] , $cancallationNOresponses['cancellationInfo']['hotelResponse']['services']['service']);
                $Info = [
                    'booking_id' => $HotelBooking->id,
                    'confirmCancellation' => 'yes',
                    'bookingCode' => $details['bookingCode'],
                    'services' => $cancallationNOresponses['cancellationInfo']['hotelResponse']['services']['service']
                ];
                $cancellationYesResp = $bookingController->CancelBooking($Info);
                $penalityAmountperRoom = 0;
                $status = null;
                
                if(isset($cancellationNoResp['cancellationInfo']['hotelResponse']['successful']) && ($cancellationNoResp['cancellationInfo']['hotelResponse']['successful'] == "TRUE")){
                    //refunding amount back to Agent
                    $cancallationYesresponses['cancellationInfo']['hotelResponse']['services']['service'] = nodeConvertion($cancallationNOresponses['cancellationInfo']['hotelResponse']['services']['service']);
                    foreach($cancallationYesresponses['cancellationInfo']['hotelResponse']['services']['service'] as $service){
                        $penalityAmountperRoom += (float)$service['cancellationPenalty']['charge'];
                    }
                    $status = 'cancelled';
                    $isCancel = 1;
                }else{
                    $partiallyCanceled = true;
                    $status = 'cancellation_failure';
                    $isCancel = 0;
                }
                //updating hotel room booking status
                HotelRoomBookingInfo::where('hotel_booking_id', $HotelBooking->id)->where('room_no', $key+1)->update(['status' => $status , 'is_cancel' => $isCancel ,'penality_amount' => $penalityAmountperRoom]);
                $penalityAmount+= $penalityAmountperRoom;
            }
        }elseif($HotelBooking->supplier == 'dida'){
            $penalityAmount = $cancellationNoResp['response']['Success']['Amount'];
            $penalityCurrency = $cancellationNoResp['response']['Success']['Currency'];
            $Info = [
                'dida_booking_id' => $HotelBooking->booking_reference_number,
                'confirmCancellation' => 'yes',
                'hotel_booking_id' => $HotelBooking->id,
                'confirmation_id' => $cancellationNoResp['response']['Success']['ConfirmID'],
            ];
            $cancellationYesResp = $bookingController->DidaCancelBooking($Info);
            if(isset($cancellationYesResp['response']['Success'])){
                $status = 'cancelled';
                $isCancel = 1;
            }else{
                $status = 'cancellation_failure';
                $isCancel = 0;
            }
            $noOfRooms = $HotelBooking->no_of_rooms;
            $penalityAmountperRoom = $penalityAmount/$noOfRooms;
            for($i = 1 ; $i <= $noOfRooms ; $i++)
            {
                //updating hotel room booking status
                HotelRoomBookingInfo::where('hotel_booking_id', $HotelBooking->id)->where('room_no', $i)->update(['status' => $status , 'is_cancel' => $isCancel ,'penality_amount' => $penalityAmountperRoom]);
            }
            
        }
        $HotelBooking->penality_amount = $penalityAmount;
        $HotelBooking->penality_currency = $penalityCurrency;
        
        if($partiallyCanceled){
            $HotelBooking->cancellation_status = 'partially_cancellation';
            $HotelBooking->save();
        }elseif($status == 'cancellation_failure' && $HotelBooking->supplier == 'dida'){
            $HotelBooking->cancellation_status = 'cancellation_failure';
            $HotelBooking->save();
        }else{
            //successfully cancelled
            $HotelBooking->is_cancel = 1;
            $HotelBooking->cancellation_status = 'cancellation_completed';
            $HotelBooking->save();
        }

        //inititing refund process
        //amount to be refunded 
        $refundableAmount = $HotelBooking->total_amount - $HotelBooking->penality_amount;
        if((int)$refundableAmount == 0){
            $HotelBooking->booking_status = "canceled";
            $HotelBooking->save();
            return response()->json(['status' => true, 'message' => "Hotel booking has been cancelled successfully with penality amount of ".$penalityCurrency." ".$penalityAmount]);

            
        }
      
    
        $HotelBooking->booking_status = "refund_initiated";
        $HotelBooking->save();
    
        if($HotelBooking->type_of_payment == 'wallet'){
            $wallet = auth()->user()->agency->wallet_balance + $refundableAmount;
          
            $agency = Agency::find(auth()->user()->agency_id);
            $agency->wallet_balance = $wallet;
            $agency->save();
     
            $walletDetails = WalletLogger::create([
                'user_id' => auth()->user()->id,
                'reference_id' => $HotelBooking->id,
                'reference_type' => 'hotel',
                'amount' => $refundableAmount,
                'remaining_amount' => $wallet,
                'amount_description' => 'KWD '.$refundableAmount .' refunded for booking id '.$HotelBooking->booking_ref_id,
                'action' => 'added',
                'status' =>'Active',
                'date_of_transaction' => Carbon::now()
            ]);
            $walletDetails->unique_id = 'WL'.str_pad($walletDetails->id, 7, '0', STR_PAD_LEFT);
            $walletDetails->save();
            $HotelBooking->booking_status = "refund_completed";
            $HotelBooking->save();
        }

        return response()->json(['status' => true, 'message' => "Hotel booking has been cancelled successfully with penality amount of ".$penalityCurrency." ".$penalityAmount]);

      
        // if($HotelBooking->booking_status == "booking_completed")
        // {

        //     $HotelBooking->booking_status ="cancellation_initiated";
        //     $HotelBooking->save();
        //     $user = 'Ravi';

        //     Mail::send('front_end.hotel.webbeds.email_templates.cancellation',compact('HotelBooking'), function($message) use($HotelBooking) {
        //          $message->to('ravi@masilagroup.com')
        //                 ->subject('Cancellation of the hotel booking has been requested');
        //     });
        // //     Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) {
        // //         $message->to('amr@masilagroup.com')
        // //        //$message->to([$FlightBooking->email])
        // //        //amr@masilagroup.com,ghunaim@masilagroup.com,acc@masilagroup.com
        // //                ->subject('your request for Cancel / ReSchedule the ticket is intiated');
        // //    });
        // //     Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) {
        // //          $message->to('ghunaim@masilagroup.com')
        // //         //$message->to([$FlightBooking->email])
        // //         //amr@masilagroup.com,ghunaim@masilagroup.com,acc@masilagroup.com
        // //                 ->subject('your request for Cancel / ReSchedule the ticket is intiated');
        // //     });
        // //     Mail::send('front_end.email_templates.cancellation',compact('FlightBooking','user'), function($message) {
        // //         $message->to('acc@masilagroup.com')
        // //        //$message->to([$FlightBooking->email])
        // //        //amr@masilagroup.com,ghunaim@masilagroup.com,acc@masilagroup.com
        // //                ->subject('your request for Cancel / ReSchedule the ticket is intiated');
        // //    });

        //     return redirect()->back()->with('success', 'Cancellation initiated successfully'); 
        // }
        // else{
        //     return redirect()->back()->with('error', 'Something went wrong'); 
        // }
    }
}
