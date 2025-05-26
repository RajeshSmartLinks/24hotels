<?php

namespace App\Http\Controllers\Api\Flights;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseApiController;

class PackageController extends BaseApiController
{
    public function index()
    {   
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $offers = Package::select($name.' as name',$description.' as description','created_at','id','slug',$this->ApiImage("/uploads/packages/"))->whereStatus('Active')->get();

        return response()->json([
            'status' => true,
            'message' => self::SUCCESS_MSG,
            "data" => $offers
        ], 200);
    }
}
