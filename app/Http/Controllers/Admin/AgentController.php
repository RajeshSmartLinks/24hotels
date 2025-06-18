<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Agency;
use App\Models\MarkUp;
use App\Models\HotelMarkUp;
use App\Models\HotelBooking;
use App\Models\WalletLogger;
use Illuminate\Http\Request;
use App\Models\FlightBooking;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => "Agent", 'subTitle' => "Agent", 'listTitle' => "Agent Listing"];
        $deleteRouteName = "agents.destroy";
        $addingFunds = "addWalletBalance";
        $agentMarkUpRoute = "agentsUpdateMarkUp";

        if (!auth()->user()->can('agent-view')) {
            return view('admin.abort', compact('titles'));
        }


        $agents = User::with('agentMarkup','agentHotelMarkup')->where('is_agent', 1)->get();
        // dd(route($agentMarkUpRoute, ":id"));
        // dd($agents);
        $noImage = asset(Config::get('constants.NO_USER_IMG'));
       

        return view('admin.agent.index', compact('titles', 'agents', 'deleteRouteName','noImage','addingFunds','agentMarkUpRoute' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $titles = [
            'title' => "Agents",
            'subTitle' => "Add agent",
        ];

        if (!auth()->user()->can('agent-add')) {
            return view('admin.abort', compact('titles'));
        }
        $agencies = Agency::where('status', 'Active')->get();

        return view('admin.agent.create', compact('titles' , 'agencies'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('agent-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'status' => 'required',
            'wallet_balance' => 'required',
            'fee_type' => 'required',
            'fee_value' => 'required',
            'fee_amount' => 'required|numeric',
            'hotel_fee_type' => 'required',
            'hotel_fee_value' => 'required',
            'hotel_fee_amount' => 'required|numeric',
            'agency_id' => 'required',
        ]);
        $data = array();

        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->is_agent = 1 ;
        $user->wallet_balance = $request->wallet_balance;
        $user->mobile = $request->mobile;
        $user->agency_id = $request->agency_id;
        $user->save();

        //adding in adding wallet balance in wallet logger
        if( $request->wallet_balance > 0){
            $walletLogger = new WalletLogger;
            $walletLogger->user_id = $user->id;
            $walletLogger->amount = $request->wallet_balance;
            $walletLogger->remaining_amount = $request->wallet_balance ;
            $walletLogger->amount_description = $request->wallet_balance." Add Wallet Balance";
            $walletLogger->action = 'added';
            $walletLogger->status = 'Active';
            $walletLogger->reference_id = $user->id;
            $walletLogger->reference_type = 'user';
            $walletLogger->date_of_transaction = now();
            $walletLogger->save();
            $walletLogger->unique_id = 'WL'.str_pad($walletLogger->id, 7, '0', STR_PAD_LEFT);
            $walletLogger->save();
        }

        //adding in flight markups
        $markup = new MarkUp;
        $markup->user_id = $user->id;
        $markup->fee_type = $request->fee_type; 
        $markup->fee_value = $request->fee_value;
        $markup->fee_amount = $request->fee_amount;
        $markup->status = 'Active';
        $markup->save();

        //adding in hotel markups
        $hotelMarkup = new HotelMarkUp;
        $hotelMarkup->user_id = $user->id;
        $hotelMarkup->fee_type = $request->hotel_fee_type; 
        $hotelMarkup->fee_value = $request->hotel_fee_value;
        $hotelMarkup->fee_amount = $request->hotel_fee_amount;
        $hotelMarkup->status = 'Active';
        $hotelMarkup->save();
 
        //mail sending to user

     
        
      
        return redirect()->route('agents.index')->with('success','Agent created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Manage Agents', 'subTitle' => 'Edit Agents' ,'subTitleTwo' => 'Update Password' , 'subTitleThree' => 'Add Wallet Balance' , 'listTitle' => 'Agent Listing' ,'subTitleFour' => 'MarkUps' ];

        if (!auth()->user()->can('agent-edit')) {
            return view('admin.abort', compact('titles'));
        }

        $editagent = User::find($id);

        $editmarkup = MarkUp::where('user_id', $id)->first();
        $agencies = Agency::where('status', 'Active')->get();

        return view('admin.agent.edit', compact('titles', 'editagent' ,'editmarkup','agencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('destination-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' =>  'required|email|unique:users,email,'.$id,
            'status' => 'required',
            'agency_id' => 'required'
        ]);
        $user = User::find($id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->mobile = $request->mobile;
        $user->agency_id = $request->agency_id;
        $user->save();

        return redirect()->route('agents.index')->with('success', 'Agent update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('destination-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $Destination = Destination::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            deleteImage(Destination::$imagePath, $Destination->image);
          

            $Destination->delete();

            return redirect()->route('destinations.index')->with('success', 'Deleted Successfully');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword($id ,Request $request)
    {
        if (!auth()->user()->can('agent-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'password' => 'required|min:8|confirmed',
        ]);
        $user = User::find($id);

        $user->password = Hash::make($request->password);
        $user->save();  

        return redirect()->route('agents.index')->with('success', 'Password update Successfully');
    }

    public function addWalletBalance($id ,Request $request){

        if (!auth()->user()->can('agent-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'wallet_balance' => 'required',
        ]);
        $user = User::find($id);

        $user->wallet_balance = $request->wallet_balance + $user->wallet_balance;
        $user->save();

        //add wallet balance to wallet logger
        $walletLogger = new WalletLogger;
        $walletLogger->user_id = $user->id;
        $walletLogger->amount = $request->wallet_balance;
        $walletLogger->remaining_amount = $request->wallet_balance + $user->wallet_balance;
        $walletLogger->amount_description = !empty($request->description)? $request->description : $request->wallet_balance." Add Wallet Balance";
        $walletLogger->action = 'added';
        $walletLogger->status = 'Active';
        $walletLogger->date_of_transaction = now();
        $walletLogger->reference_id = $user->id;
        $walletLogger->reference_type = 'user';
        $walletLogger->wallet_amount_type = $request->wallet_amount_type ?? null;
        $walletLogger->wallet_reference_id = $request->wallet_reference_id ?? null;

        $walletLogger->save();
        $walletLogger->unique_id = 'WL'.str_pad($walletLogger->id, 7, '0', STR_PAD_LEFT);
        $walletLogger->save();

        return redirect()->route('agents.index')->with('success', 'Wallet Balance update Successfully');
    }

    public function view($id){

        if (!auth()->user()->can('agent-view')) {
            return view('admin.abort');
        }
        $titles = ['title' => 'Manage Agents', 'subTitle' => 'View Agents' ];
        $agent = User::find($id);
        $walletLogger = WalletLogger::with('FlightBooking')->where('user_id', $agent->id)->get();
     
        $bookings = FlightBooking::with('TravelersInfo','Customercountry','fromAirport','toAirport','AirlinePnr')->orderBy('flight_bookings.id','DESC')->where('user_id' ,$id)->get();
        $hotelBookings = HotelBooking::with('Customercountry','TravelersInfo')->orderBy('hotel_bookings.id','DESC')->where('user_id' ,$id)->get();
        $noImage = asset(Config::get('constants.NO_USER_IMG'));
        return view('admin.agent.view', compact('agent', 'walletLogger', 'bookings' , 'titles' , 'noImage' ,'hotelBookings'));
    }

    public function updateMarkUp(Request $request, $id){
        if (!auth()->user()->can('markups-edit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'fee_type'=>'required',
            'fee_value'=>'required',
            'fee_amount'=>'required | numeric'
        ]);

        $data = array();

        $MarkUp = MarkUp::find($id);

        $MarkUp->fee_type = $request->fee_type;
        $MarkUp->fee_value = $request->fee_value;
        $MarkUp->fee_amount = $request->fee_amount;
        // $MarkUp->status = $request->status;
        $MarkUp->save();

        $HotelMarkUp = HotelMarkUp::find($request->hotel_markup_id);

        $HotelMarkUp->fee_type = $request->fee_type;
        $HotelMarkUp->fee_value = $request->fee_value;
        $HotelMarkUp->fee_amount = $request->fee_amount;
        // $HotelMarkUp->status = $request->status;
        $HotelMarkUp->save();

        $cachename = "MarkUpPrice".$MarkUp->user_id;
        Cache::forget($cachename);

        $cachename = "MarkUpPrice".$HotelMarkUp->user_id;
        Cache::forget($cachename);

        return redirect()->route('agents.index')->with('success', 'MarkUp Updated Successfully');
    }
}
