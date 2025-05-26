<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FlightBooking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseApiController;


class UserController extends BaseApiController
{

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email,'.(auth()->user()->id),
        ]);
   
        
        // if ($validator->fails()) {
        //     $errorMessages = $validator->messages()->all();
        //     return response()->json([
        //         'status' => false,
        //         "message" => $errorMessages[0],

        //     ], 200);
        // }
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
        $id = auth()->user()->id;
        $update = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'title' => $request->input('title'),
            'country_id' => $request->input('country_id')??null,
            'mobile' => $request->input('mobile')??null,
            'date_of_birth' => $request->input('date_of_birth')??null,
            'email' => $request->input('email'),
         ];
        $originalImage = $request->file('profile_pic');
        if ($originalImage != NULL) {
            $newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = User::$imageThumbPath;
            $originalPath = User::$imagePath;

            // Image Upload Process
            $thumbnailImage = Image::make($originalImage);

            $thumbnailImage->save($originalPath . $newFileName);
            //$thumbnailImage->resize(150, 150);
            $thumbnailImage->resize(40, null, function ($constraint) {
                $constraint->aspectRatio();
                })->save($thumbnailPath . $newFileName);
            //$thumbnailImage->save($thumbnailPath . $newFileName);

            $update['profile_pic'] = $newFileName;
        }
        $user = User::where("id", ($id))->update($update);

        $user = User::select('id','email','mobile','country_id','title','date_of_birth','first_name','last_name',$this->ApiImage("/uploads/users/","profile_pic"))->find(($id));
        // $offers = Destination::select($name.' as name','created_at','id','slug',$this->ApiImage("/uploads/destinations/"))->where('status','Active')->orderBy('order','DESC')->get();

        $response = ['user' => $user, "status" =>true ,"message" => "user Profile Updated successfully"];
        return response($response, 200);
        
    }

    public function UpdatePassword(Request $request)
    {
        // dd(auth()->user());
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => ['required', 'string', 'min:8', 'confirmed','regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/' ],
        ],[
            'new_password.regex' => 'password must contain at least one lowercase letter,at least one uppercase letter ,at least one digit,at least one special charactor',
        ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         "message" => $validator->errors(),
        //     ], 200);
        // }
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }
        

        if (!(Hash::check($request->get('current_password'), auth()->user()->password))) {
            $response = ["status" =>false ,"message" => "Your current password does not matches with the password." ];
            return response($response, 200);
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            // Current password and new password same

            $response = ["status" =>false ,"message" => "New Password cannot be same as your current password." ];
            return response($response, 200);
        }

        $user = User::where("id",auth()->user()->id)->update([
        'password' =>  Hash::make($request->input('new_password'))]);

        $response = ["status" =>true ,"message" => "Password updated successfully"];
        return response($response, 200);
      
    }

    public function deleteAccount()
    {
         $id = auth()->user()->id;

        $user = User::find($id);

        $role = Role::where("slug","user")->first();
        $this->detachRole($user);

        $data = User::where("id", ($id))->update(['is_deleted' =>1 ,'deleted_at' => now() ,'status' => 'InActive']);
        if($data)
        {
            $response = ["status" =>true ,"message" => "Account Deleted Successfully"];
        }
        else{
            $response = ["status" =>false ,"message" => "something went wrong"];
        }
        
        return response($response, 200);
    }

    public function bookings(Request $request)
    {

        // $userbookings  = FlightBooking::with('fromAirport','toAirport')->where("user_id" , auth()->user()->id)->orderBy('id',"desc")->get();
        $userbookings  = FlightBooking::select('*',$this->ApiImage("" , "flight_ticket_path"),$this->ApiImage("" , "invoice_path"))->with('fromAirport','toAirport')->where("user_id" , auth()->user()->id)->orderBy('id',"desc")->get();

        $response = ["status" =>true ,"message" => "User booking details" ,'data' => $userbookings ];

        return response($response, 200);

    }

    public function cancelBooking( Request $request)
    {
        $bookingId = $request->input('id');
        $FlightBooking = FlightBooking::with('User')->find($bookingId);
        if($FlightBooking->ticket_status == 1 && $FlightBooking->booking_status == "booking_completed")
        {
            // $FlightBooking->booking_status ="cancellation_initiated";
            $FlightBooking->save();

            $user = $FlightBooking->User->first_name." ".$FlightBooking->User->last_name;

            //email sending to user


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

           $response = ["status" =>true ,"message" => "Cancellation initiated successfully"];
        }
        else{

            $response = ["status" =>false ,"message" => "Something went wrong"];
        }
        return response($response, 200);
    }
}
