<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Offer;
use App\Models\Package;
use App\Models\SeoSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    
    public function PackageDetails($slug)
    {
       
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
        $package = Package::select($name.' as name',$description.' as description','image','created_at','id','slug','whatsapp_number')->where('slug',$slug)->first();

        $offers = Offer::select($name.' as name',$description.' as description','image','created_at','valid_upto','id','slug')->orderBy('created_at',"DESC")->limit(3)->get();

        $packages = Package::select($name.' as name',$description.' as description','image','created_at','id','slug','whatsapp_number')->orderBy('created_at',"DESC")->limit(3)->get();

        if(empty($package) || $package == null)
        {
            $titles = [
                'title' => "Something went wrong",
            ];
            return view('front_end.error',compact('titles'));
        }
        $seoData = SeoSettings::where(['page_type' => 'dynamic' , 'dynamic_page_type' => 'packages','dynamic_page_id'=>$package->id,'status' => 'Active'])->first();
        $titles = [
            'title' => $seoData->title ?? '',
            'description' => $seoData->description ?? '',
            'image' => asset('uploads/packages/'.$package->image),
        ];

        return view('front_end.package.details',compact('titles','package','offers','packages'));

    }
}
