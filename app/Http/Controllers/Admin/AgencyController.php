<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Agency;
use App\Models\MarkUp;
use App\Models\Country;
use App\Models\HotelMarkUp;
use App\Models\WalletLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $titles = ['title' => "Agency", 'subTitle' => "Agency", 'listTitle' => "Agency Listing"];
        if (!auth()->user()->can('agency-view')) {
            return view('admin.abort', compact('titles'));
        }
        $deleteRouteName = "agency.destroy";
        $addingFunds = "addAgencyWalletBalance";
        $agencyMarkUpRoute = "agencyUpdateMarkUp";
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        // if (!auth()->user()->can('brand-view')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $agencies = Agency::with('country', 'masterAgent.agencyMasterAgentHotelmarkups')->orderBy('id','desc')->get();
        

        return view('admin.agency.index', compact('titles', 'agencies', 'deleteRouteName' ,'noImage','addingFunds','agencyMarkUpRoute'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
        $titles = [
            'title' => "Agency",
            'subTitle' => "Add Agency",
        ];
        if (!auth()->user()->can('agency-add')) {
            return view('admin.abort', compact('titles'));
        }

        $countries = Country::orderBy('id','desc')->get();

        return view('admin.agency.create', compact('titles','countries'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('agency-add')) {
            return view('admin.abort');
        }
        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort');
        // }

        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'logo' => 'image|required|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'status' => 'required',
            'phone_number' => 'required',
            'country_id' => 'required',

            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'wallet_balance' => 'required',
          
            'hotel_fee_type' => 'required',
            'hotel_fee_value' => 'required',
            'hotel_fee_amount' => 'required|numeric',
 
        ]);
        $data = array();
        $originalImage = $request->file('logo');

 
        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
            $thumbnailPath = Agency::$imageThumbPath;
            $originalPath = Agency::$imagePath;

            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                //$newFileName = time().'.'.$originalImage->getClientOriginalName();
                $destinationPath = env('SVG_IMAGE_UPLOAD_PATH' , public_path()).$originalPath;
                $originalImage->move($destinationPath, $newFileName);
            }
            else{
                // Image Upload Process
                $thumbnailImage = Image::make($originalImage);
                $thumbnailImage->save($originalPath . $newFileName);
                $thumbnailImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($thumbnailPath . $newFileName);
            }

            $data['logo'] = $newFileName;
        }

        $data['country_id'] = $request->country_id;
        $data['phone_number'] = $request->phone_number;
        $data['address'] = $request->address;
        $data['name'] = $request->name;
        $data['status'] = $request->status;
        $data['wallet_balance'] = $request->wallet_balance;
    
        $agencyInfo = Agency::create($data);


        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = "Active";
        $user->is_agent = 1 ;
        $user->is_master_agent = 1 ;
        $user->mobile = $request->mobile;
        $user->agency_id = $agencyInfo->id;
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

        //adding in hotel markups
        $hotelMarkup = new HotelMarkUp;
        $hotelMarkup->user_id = $user->id;
        $hotelMarkup->fee_type = $request->hotel_fee_type; 
        $hotelMarkup->fee_value = $request->hotel_fee_value;
        $hotelMarkup->fee_amount = $request->hotel_fee_amount;
        $hotelMarkup->status = 'Active';
        $hotelMarkup->save();

        return redirect()->route('agency.index')->with('success','created Successfully');
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
        if (!auth()->user()->can('agency-edit')) {
            return view('admin.abort');
        }
        $titles = ['title' => 'Manage Agency', 'subTitle' => 'edit Agency'];

        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $editAgency = Agency::find($id);
        $countries = Country::orderBy('id','desc')->get();

        return view('admin.agency.edit', compact('titles', 'editAgency','countries'));
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
        if (!auth()->user()->can('agency-edit')) {
            return view('admin.abort');
        }
        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort');
        // }

         $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'status' => 'required',
            'phone_number' => 'required',
            'country_id' => 'required'
        ]);
        $agency = Agency::find($id);
        $originalImage = $request->file('logo');

        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
            //$newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = Agency::$imageThumbPath;
            $originalPath = Agency::$imagePath;

            // Delete the previous image
            deleteImage(Agency::$imagePath, $agency->image);
            deleteImage(Agency::$imageThumbPath, $agency->image);

            // Image Upload Process
            $thumbnailImage = Image::make($originalImage);
                   
            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                //$newFileName = time().'.'.$originalImage->getClientOriginalName();
                $destinationPath = env('SVG_IMAGE_UPLOAD_PATH' , public_path()).$originalPath;
                $originalImage->move($destinationPath, $newFileName);
            }
            else{
                // Image Upload Process
                $thumbnailImage = Image::make($originalImage);
                $thumbnailImage->save($originalPath . $newFileName);
                $thumbnailImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($thumbnailPath . $newFileName);
            }
            $agency->logo = $newFileName;
        }

        $agency->name = $request->name;
        $agency->country_id = $request->country_id;
        $agency->phone_number = $request->phone_number;
        $agency->address = $request->address;
        $agency->status = $request->status;
        $agency->save();

        return redirect()->route('agency.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('agency-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $agency = Agency::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            deleteImage(Agency::$imagePath, $agency->image);
            deleteImage(Agency::$imageThumbPath, $agency->image);

            $agency->delete();

            return redirect()->route('agency.index')->with('success', 'Deleted Successfully');

        }
    }

    public function addAgencyWalletBalance($id ,Request $request){

        if (!auth()->user()->can('agency-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'wallet_balance' => 'required',
        ]);
        $agency = Agency::with('masterAgent')->find($id);

        $agency->wallet_balance = $request->wallet_balance_kwd + $agency->wallet_balance;
        $agency->save();

        //add wallet balance to wallet logger
        $walletLogger = new WalletLogger;
        $walletLogger->user_id = $agency->masterAgent->id;
        $walletLogger->amount = $request->wallet_balance_kwd;
        $walletLogger->remaining_amount = $request->wallet_balance_kwd + $agency->masterAgent->wallet_balance;
        $walletLogger->amount_description = !empty($request->description)? $request->description : $request->wallet_balance_kwd." Add Wallet Balance";
        $walletLogger->action = 'added';
        $walletLogger->status = 'Active';
        $walletLogger->date_of_transaction = now();
        $walletLogger->reference_id = $agency->masterAgent->id;
        $walletLogger->reference_type = 'user';
        $walletLogger->wallet_amount_type = $request->wallet_amount_type ?? null;
        $walletLogger->wallet_reference_id = $request->wallet_reference_id ?? null;

        $walletLogger->save();
        $walletLogger->unique_id = 'WL'.str_pad($walletLogger->id, 7, '0', STR_PAD_LEFT);
        $walletLogger->save();

        return redirect()->route('agency.index')->with('success', 'Wallet Balance update Successfully');
    }

    public function updateMarkUp(Request $request, $id){
        if (!auth()->user()->can('markups-edit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'hotel_fee_type'=>'required',
            'hotel_fee_value'=>'required',
            'hotel_fee_amount'=>'required | numeric'
        ]);

        $data = array();

        $HotelMarkUp = HotelMarkUp::find($request->hotel_markup_id);
        // dd($request->input());
        $hotel_fee_type = $request->hotel_fee_type;
        $hotel_fee_value = $request->hotel_fee_value;
        $hotel_fee_amount = $request->hotel_fee_amount;

        $HotelMarkUp->fee_type = $hotel_fee_type;
        $HotelMarkUp->fee_value = $hotel_fee_value;
        $HotelMarkUp->fee_amount = $hotel_fee_amount;
        $HotelMarkUp->save();


        $cachename = "HotelMarkUpPrice".$HotelMarkUp->user_id;
        Cache::forget($cachename);

        //masteragent info
        $masterAgentInfo = User::find($HotelMarkUp->user_id);

        //onchanging master agent markups checging all the sub-agents mark ups
        $subAgents = User::where(['is_agent' => 1 , 'agency_id' => $masterAgentInfo->agency_id])->get();
        
        foreach($subAgents as $subAgent){
            $subAgentMarkups = HotelMarkUp::where(['user_id' => $subAgent->id])->first();
            if($subAgentMarkups){
                $subAgentMarkups->fee_type = $hotel_fee_type;
                $subAgentMarkups->fee_value = $hotel_fee_value;
                $subAgentMarkups->fee_amount = $hotel_fee_amount;
                $subAgentMarkups->save();

                $cachename = "HotelMarkUpPrice".$subAgentMarkups->user_id;
                Cache::forget($cachename);
            }
        }
        return redirect()->route('agency.index')->with('success', 'MarkUp Updated Successfully');
    }
}
