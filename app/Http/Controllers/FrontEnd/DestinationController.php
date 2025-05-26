<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Offer;
use App\Models\Package;
use App\Models\Destination;
use App\Http\Controllers\Controller;

class DestinationController extends Controller
{
    public function DestinationDetails($slug)
    {

       
        $name = 'name_' . app()->getLocale();
        $description = 'description_' . app()->getLocale();
      
        $destination = Destination::select($name.' as name',$description.' as description','image','created_at','id','slug','meta_tag_keywords' , 'meta_tag_description')->where('slug',$slug)->first();

        $offers = Offer::select($name.' as name',$description.' as description','image','created_at','valid_upto','id','slug')->orderBy('created_at',"DESC")->get();

        $packages = Package::select($name.' as name',$description.' as description','image','created_at','id','slug')->orderBy('created_at',"DESC")->limit(3)->get();


        if(empty($destination) || $destination == null)
        {
            $titles = [
                'title' => "Something went wrong",
            ];
            return view('front_end.error',compact('titles'));
        }
        $titles = [
            'title' => "Destinations",
            'keywords' => $destination->meta_tag_keywords,
            'description' => $destination->meta_tag_description,
        ];

        return view('front_end.destination.details',compact('titles','destination','offers','packages'));

    }
}
