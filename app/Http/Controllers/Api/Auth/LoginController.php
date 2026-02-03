<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseApiController;

class LoginController extends BaseApiController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         "message" => $validator->errors(),
        //         // "errors" => $validator->errors(),
        //     ], 200);
        // }
        if ($validator->fails()) {
            $errorMessages = $validator->messages()->all();
            return response()->json([
                'status' => false,
                "message" => $errorMessages[0]
            ], 200);
        }

        $user = User::where('email', $request->email)->where('status' , 'Active')->where('back_end_user' , '0')->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $user = User::select('id','email','mobile','country_id','title','date_of_birth','first_name','last_name',$this->ApiImage("/uploads/users/","profile_pic" ),'agency_id')->find($user->id);
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $agency = null;
                if(!empty($user->agency_id)){
                    $agency = Agency::find($user->agency_id);
                }
                $user->agency()->first();
                $response = ["agency" => $agency,'user' => $user,'token' => $token,"status"=>true ];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch" , "status"=>false];
                return response($response, 200);
            }
        } else {
            $response = ["message" =>'User does not exist',"status"=>false];
            return response($response, 200);
        }

        // return response(['user' => auth()->user(), 'token' => $token]);

    }
}
