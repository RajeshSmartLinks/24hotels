<?php

namespace App\Http\Controllers\FrontEnd\Hotel;

use App\Models\TboHotel;
use App\Models\WebbedsCity;
use App\Models\WebbedsHotel;
use Illuminate\Http\Request;
use App\Models\TboHotelsCity;
use App\Models\TboHotelsCode;
use Illuminate\Support\Carbon;
use App\Models\TboHotelsCountry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Hotel\Xml\SearchController;

class StaticController extends Controller
{
    public function downloadTBOHoteldDetails(){
     

        $countryListUrl = env('TBO_HOTEL_URL') . "CountryList";
        $countries = $this->TBOApi($countryListUrl, 'get');
        if($countries['Status']['Code'] == 200)
        {
            //country list
            $countryList = $countries['CountryList'];
            foreach($countryList as $country)
            {
                $cityListUrl = env('TBO_HOTEL_URL') . "CityList";
                $postArray = array('CountryCode' => $country['Code']);
                $cities = $this->TBOApi($cityListUrl, 'post' , $postArray);
                if($cities['Status']['Code'] == 200)
                {
                    //cities list
                    $citiesList = $cities['CityList'];
                    foreach($citiesList as $city)
                    {
                        // echo "citiesList";
                        $hotelCodeUrl = env('TBO_HOTEL_URL') . "TBOHotelCodeList";
                        //$hotelCodeUrl url we will not get images 
                        $postArray = [];
                        $postArray = array('CityCode' => $country['Code'] , "IsDetailedResponse" => "false");
                        $hotelsCodes = $this->TBOApi($hotelCodeUrl, 'post' , $postArray);
                        if($hotelsCodes['Status']['Code'] == 200)
                        {
                            echo '<pre>';
                            $hotelsCodesList = $hotelsCodes['Hotels'];
                            print_r($hotelsCodesList);
                            //hotelsCodes list
                            $ChunkedhotelCodes = array_chunk(array_column($hotelsCodesList,'HotelCode'),50);
                            print_r($ChunkedhotelCodes);exit;
                            foreach($ChunkedhotelCodes as $indiviualChunkedCodes)
                            {
                                $hotelCodes = '';
                                $hotelCodes = implode(",",$indiviualChunkedCodes);
                                $hoteldetailsUrl = env('TBO_HOTEL_URL') . "Hoteldetails";
                                //$hoteldetailsUrl will get complte details about hotel
                                $postArray = [];
                                //we can send 50 hotel codes at once
                                $postArray = array( "Hotelcodes" => $hotelCodes,"Language"=> "en","IsDetailedResponse" => "true");
                                $hotels = $this->TBOApi($hoteldetailsUrl, 'post' , $postArray);
                                if($hotels['Status']['Code'] == 200)
                                {
                                    $hotelsList = $cities['HotelDetails'];
                                    foreach($hotelsList as $hotel)
                                    {
                                        if(!empty($hotel))
                                        {
                                            $hotalData = [];
                                            $hotalData = [
                                                'hotel_code' => $hotel['HotelCode'] ?? null,
                                                'hotel_name' => $hotel['HotelCode']?? null,
                                                'hotel_rating' => $hotel['HotelRating'] ?? null,
                                                'address' => $hotel['Address'] ?? null,
                                                'attractions' => $hotel['Attractions'] ?? null,
                                                'country_name' => $hotel['CountryName'] ?? null,
                                                'country_code' => $hotel['CountryCode'] ?? null,
                                                'description' => $hotel['Description'] ?? null,
                                                'fax_number' => $hotel['FaxNumber'] ?? null,
                                                'hotel_facilities' => isset($hotel['HotelFacilities']) ? implode(',',$hotel['HotelFacilities']) : NULL ,
                                                'map' => $hotel['Map'] ?? null,
                                                'phone_number' => $hotel['PhoneNumber'] ?? null,
                                                'pin_code' => $hotel['PinCode'] ?? null,
                                                'hotel_website_url' => $hotel['HotelWebsiteUrl'] ?? null,
                                                'city_name' => $hotel['CityName'] ?? null,
                                                'city_code' => $hotel['CityId'] ?? null,
                                                'images' => isset($hotel['Images']) ? implode(',',$hotel['Images']) : NULL ,
                                                'check_in' => $hotel['CheckInTime'] ?? null,
                                                'check_out' => $hotel['CheckOutTime'] ?? null,
                                            ];
                                            print_r($hotalData);
                                            exit;

                                            // DB::table('tbo_hotels')->where('email', $hotalData['hotel_code'])->updateOrInsert($hotalData);
                                        }
                                       
                                    }

                                }



                            }
                            

                        }
                    }
                    

                }

                // dd($cities);
            }
        }
        // foreach
        // dd( $countryList);
        

    }

    public function  dumpTBOCountrydump()
    {
        $countryListUrl = env('TBO_HOTEL_URL') . "CountryList";
        $countries = $this->TBOApi($countryListUrl, 'get');
        if($countries['Status']['Code'] == 200)
        {
            // dd($countries);
            //country list
            $countryList = $countries['CountryList'];
            $countryData = [];
            foreach($countryList as $country)
            {
                //$cityListUrl = env('TBO_HOTEL_URL') . "CityList";
                // dd($country);
                // $postArray = array('CountryCode' => $country['Code']);
                // $cities = $this->TBOApi($cityListUrl, 'post' , $postArray);
                // if($cities['Status']['Code'] == 200)
                // {
                //     //cities list
                //     $citiesList = $cities['CityList'];
                //     foreach($citiesList as $city)
                //     {
                //         // echo "citiesList";
                //         $hotelCodeUrl = env('TBO_HOTEL_URL') . "TBOHotelCodeList";
                //         //$hotelCodeUrl url we will not get images 
                //         $postArray = [];
                //         $postArray = array('CityCode' => $country['Code'] , "IsDetailedResponse" => "false");
                //         $hotelsCodes = $this->TBOApi($hotelCodeUrl, 'post' , $postArray);
                //         dd($hotelsCodes);
                //         if($hotelsCodes['Status']['Code'] == 200)
                //         {
                //             echo '<pre>';
                //             $hotelsCodesList = $hotelsCodes['Hotels'];
                //             print_r($hotelsCodesList);
                //             //hotelsCodes list
                //             $ChunkedhotelCodes = array_chunk(array_column($hotelsCodesList,'HotelCode'),50);
                //             print_r($ChunkedhotelCodes);exit;
                //             foreach($ChunkedhotelCodes as $indiviualChunkedCodes)
                //             {
                //                 $hotelCodes = '';
                //                 $hotelCodes = implode(",",$indiviualChunkedCodes);
                //                 $hoteldetailsUrl = env('TBO_HOTEL_URL') . "Hoteldetails";
                //                 //$hoteldetailsUrl will get complte details about hotel
                //                 $postArray = [];
                //                 //we can send 50 hotel codes at once
                //                 $postArray = array( "Hotelcodes" => $hotelCodes,"Language"=> "en","IsDetailedResponse" => "true");
                //                 $hotels = $this->TBOApi($hoteldetailsUrl, 'post' , $postArray);
                //                 if($hotels['Status']['Code'] == 200)
                //                 {
                //                     $hotelsList = $cities['HotelDetails'];
                //                     foreach($hotelsList as $hotel)
                //                     {
                //                         if(!empty($hotel))
                //                         {
                //                             $hotalData = [];
                //                             $hotalData = [
                //                                 'hotel_code' => $hotel['HotelCode'] ?? null,
                //                                 'hotel_name' => $hotel['HotelCode']?? null,
                //                                 'hotel_rating' => $hotel['HotelRating'] ?? null,
                //                                 'address' => $hotel['Address'] ?? null,
                //                                 'attractions' => $hotel['Attractions'] ?? null,
                //                                 'country_name' => $hotel['CountryName'] ?? null,
                //                                 'country_code' => $hotel['CountryCode'] ?? null,
                //                                 'description' => $hotel['Description'] ?? null,
                //                                 'fax_number' => $hotel['FaxNumber'] ?? null,
                //                                 'hotel_facilities' => isset($hotel['HotelFacilities']) ? implode(',',$hotel['HotelFacilities']) : NULL ,
                //                                 'map' => $hotel['Map'] ?? null,
                //                                 'phone_number' => $hotel['PhoneNumber'] ?? null,
                //                                 'pin_code' => $hotel['PinCode'] ?? null,
                //                                 'hotel_website_url' => $hotel['HotelWebsiteUrl'] ?? null,
                //                                 'city_name' => $hotel['CityName'] ?? null,
                //                                 'city_code' => $hotel['CityId'] ?? null,
                //                                 'images' => isset($hotel['Images']) ? implode(',',$hotel['Images']) : NULL ,
                //                                 'check_in' => $hotel['CheckInTime'] ?? null,
                //                                 'check_out' => $hotel['CheckOutTime'] ?? null,
                //                             ];
                //                             print_r($hotalData);
                //                             exit;

                //                             // DB::table('tbo_hotels')->where('email', $hotalData['hotel_code'])->updateOrInsert($hotalData);
                //                         }
                                       
                //                     }

                //                 }



                //             }
                            

                //         }
                //     }
                // }
                $countryData  = [
                    'code' => $country['Code'],
                    'name' => $country['Name']
                ];
                $hotelcountry =  DB::table('tbo_hotels_countries')->where('code', $countryData['code'])->first();
                if(empty($hotelcountry))
                {
                    $countryData['created_at'] = now();
                    TboHotelsCountry::insert($countryData);
                }
                else{
                    $countryData['updated_at'] = now();
                    TboHotelsCountry::where('code', $countryData['code'])->update($countryData);
                }
            }
        }

        
    }

    public function  dumpTBOCitydump()
    {
        // echo phpinfo();exit;
        // ini_set('max_execution_time', 1000);
        header('Cache-Control: max-age=0,no-store');
        $countries = TboHotelsCountry::where('is_city_dumped', 0)->limit(10)->get();
         
        foreach($countries as $country)
        {
            $cityListUrl = env('TBO_HOTEL_URL') . "CityList";
            // dd($country);
            $postArray = array('CountryCode' => $country->code);
            $cities = $this->TBOApi($cityListUrl, 'post' , $postArray);
            // dd($cities);
            if($cities['Status']['Code'] == 200)
            {
                //cities list
                $citiesList = $cities['CityList'];
                // dd(count($citiesList));
                foreach($citiesList as $citydetails)
                {
                    $city = [];
                    $cityspliter = explode("," ,$citydetails['Name']);
                    $city = [
                        'country_code' => $country->code,
                        'country_name' => $country->name,
                        'code' => $citydetails['Code'],
                        'name' => $cityspliter[0],
                        'state_name' => isset($cityspliter[1]) ? ltrim($cityspliter[1]) :  NULL,
                    ];
                    // dd($city);
                    $citydata =  DB::table('tbo_hotels_cities')->where('code', $city['code'])->first();
                    if(empty($citydata))
                    {
                        $city['created_at'] = now();
                        TboHotelsCity::insert($city);
                    }
                    else{
                        $city['updated_at'] = now();
                        TboHotelsCity::where('code', $city['code'])->update($city);
                    }   
                }
            }
          
          TboHotelsCountry::where('id', $country->id)->update(array('is_city_dumped' => 1));
          echo '<br>';
          echo $country->name." country cities dumped successfully ";
            
        }
        

        
    }

    public function dumpTBOHotelsCode()
    {
        header( 'Cache-Control: max-age=0,no-store');
        $Url = env('TBO_HOTEL_URL') . "hotelcodelist";
        $hotelCodes = $this->TBOApi($Url, 'get');
       
        $ChunkedhotelCodes = array_chunk($hotelCodes['HotelCodes'],50);
        foreach (array_chunk($ChunkedhotelCodes,500) as $chunk)
        {
            $insert = [];
            foreach ($chunk as $indiviualChunk) {
                $insert[] = ['hotel_codes_set'=>implode(',',$indiviualChunk)];
            }
            DB::table('tbo_hotels_codes')->insert($insert);
        }
        echo "Hotel Codes dumped successfully";
    }

    public function getStaticHotelsdata()
    {
        header( 'Cache-Control: max-age=0,no-store');
        $hoteldetailsUrl = env('TBO_HOTEL_URL') . "Hoteldetails";
        $hotelcodesList = TboHotelsCode::where('hotel_dumped' , 0)->limit(3)->get();

        foreach($hotelcodesList as $hotelcodes)
        {
            $postArray = array( "Hotelcodes" => $hotelcodes->hotel_codes_set,"Language"=> "en","IsDetailedResponse" => "true");
            $hotels = $this->TBOApi($hoteldetailsUrl, 'post' ,$postArray);

            if($hotels['Status']['Code'] == 200)
            {
                $hotelsList = $hotels['HotelDetails'];
                
                foreach($hotelsList as $hotel)
                {
                    $hotalData = [];
                    if(!empty($hotel))
                    {
                     
                        $hotalData = [
                            'hotel_code' => $hotel['HotelCode'] ?? null,
                            'hotel_name' => $hotel['HotelName']?? null,
                            'hotel_rating' => $hotel['HotelRating'] ?? null,
                            'address' => $hotel['Address'] ?? null,
                            // 'attractions' => isset($hotel['Attractions']) ? json_encode($hotel['Attractions']) : NULL ,
                            'country_name' => $hotel['CountryName'] ?? null,
                            'country_code' => $hotel['CountryCode'] ?? null,
                            'description' => $hotel['Description'] ?? null,
                            'fax_number' => $hotel['FaxNumber'] ?? null,
                            'hotel_facilities' => isset($hotel['HotelFacilities']) ? json_encode($hotel['HotelFacilities']) : NULL ,
                            'map' => $hotel['Map'] ?? null,
                            'phone_number' => $hotel['PhoneNumber'] ?? null,
                            'pin_code' => $hotel['PinCode'] ?? null,
                            'hotel_website_url' => $hotel['HotelWebsiteUrl'] ?? null,
                            'city_name' => $hotel['CityName'] ?? null,
                            'city_code' => $hotel['CityId'] ?? null,
                            'images' => isset($hotel['Images']) ? json_encode($hotel['Images']) : NULL ,
                            'check_in' => $hotel['CheckInTime'] ?? null,
                            'check_out' => $hotel['CheckOutTime'] ?? null,
                        ];
                        // dd($hotalData);
                        //                         DB::enableQueryLog();
                        // $user = DB::table('tbo_hotels')->where('hotel_code', $hotalData['hotel_code'])->updateOrInsert($hotalData);
                        // $query = DB::getQueryLog();
                        // dd($query);

                       $hotelcheck =  DB::table('tbo_hotels')->where('hotel_code', $hotalData['hotel_code'])->first();
                       if(empty($hotelcheck))
                       {
                        $hotalData['created_at'] = now();
                            TboHotel::insert($hotalData);
                       }
                       else{
                        $hotalData['updated_at'] = now();
                        TboHotel::where('hotel_code', $hotalData['hotel_code'])->update($hotalData);
                       }
                    //    exit;
                        
                    }

                    
                }

                

            }
            DB::table('tbo_hotels_codes')->where('id', $hotelcodes->id)->update(['hotel_dumped' => 1]);

            echo $hotelcodes->id." th row hotels Codes with details dumped";



        }



        
       
        

    }

    public function WebBedsHoteldata(){

        header( 'Cache-Control: max-age=0,no-store');
        $hotelUrl = env('WEBBEDS_URL') ;
        $cityDetails = WebbedsCity::where(['is_hotel_data_dumped' => 'no' , 'fetch_cycle' => null])->limit(1)->get();
        $searchController = new SearchController();

        if(!empty($cityDetails)){
            
            foreach ($cityDetails as $key => $city) {
                WebbedsCity::where('code', $city->code)->update(['cycle_update_on' => now()]);
                $data['cityCode'] = $city->code;
                $data['from'] = Carbon::today()->format('Y-m-d');
                $data['to'] = Carbon::tomorrow()->format('Y-m-d');
                $HotelsInfo = $searchController->saticDatafetch($data);
                
                if($HotelsInfo['success'])
                {
                    if(isset($HotelsInfo['hotels']['hotel'])){
                        $HotelsInfo['hotels']['hotel'] = nodeConvertion($HotelsInfo['hotels']['hotel']);
                        foreach($HotelsInfo['hotels']['hotel'] as $hotelInfo)
                        {
                            $this->storeHotel($hotelInfo);
                        }
                    }
                    WebbedsCity::where('code', $city->code)->update(['is_hotel_data_dumped' => 'yes' , 'last_dump_on' => now() ,'last_dump_staus' => 'success']);
                    Log::info("dumping successfull for city code ".$city->name);
                    echo "dumping successfull for city code ".$city->name;
                }else{
                    WebbedsCity::where('code', $city->code)->update(['is_hotel_data_dumped' => 'no' , 'last_dump_on' => now() ,'last_dump_staus' => 'failure']);
                    Log::error("dumping failed for city code ".$city->name);
                    echo "dumping failed for city code ".$city->name;
                }
            }
        }
    }

    public function storeHotel($hotelInfo){

        $hotelcheck = WebbedsHotel::where('hotel_code', $hotelInfo['@attributes']['hotelid'])->first();
        if(empty($hotelcheck)){
            $rating = 0;
            if($hotelInfo['rating'] == 560){
                $rating = 2;
            }elseif($hotelInfo['rating'] == 561){
                $rating = 3;                        
            }elseif($hotelInfo['rating'] == 562){
                $rating = 4;                        
            }elseif($hotelInfo['rating'] == 563){
                $rating = 5;                        
            }else{
                $rating = 1;
            }

            $images = [];

            if(isset($hotelInfo['images']['hotelImages']['image'])){     
            $hotelInfo['images']['hotelImages']['image'] = nodeConvertion($hotelInfo['images']['hotelImages']['image']);
                foreach($hotelInfo['images']['hotelImages']['image'] as $image){
                    $images[] = $image['url'];
                }
            }

            $ammenities = [];


            if(isset($hotelInfo['amenitie']['language'])){
                $hotelInfo['amenitie']['language']['amenitieItem'] = nodeConvertion($hotelInfo['amenitie']['language']['amenitieItem']);
                foreach($hotelInfo['amenitie']['language']['amenitieItem'] as $facility){
                    $ammenities[] = $facility['@content'];
                }
            }
            $map = null;
            if(isset($hotelInfo['geoPoint']['lat']) && isset($hotelInfo['geoPoint']['lng']) && $hotelInfo['geoPoint']['lat'] != '' && $hotelInfo['geoPoint']['lng'] != ''){
                $map = $hotelInfo['geoPoint']['lat'].'|'.$hotelInfo['geoPoint']['lng'];
            }
            $phone_number = null;
            if(isset($hotelInfo['hotelPhone']) ){
                if(is_array($hotelInfo['hotelPhone']) ){
                    if(!empty($hotelInfo['hotelPhone'][0])){
                        $phone_number = $hotelInfo['hotelPhone'][0];
                    }
                }else{
                    $phone_number = $hotelInfo['hotelPhone'];
                }
            }

            $hoteldetails = [
                'hotel_code' => $hotelInfo['@attributes']['hotelid'] ?? null,
                'preferred' => $hotelInfo['@attributes']['preferred'] ?? null,
                'exclusive' => $hotelInfo['@attributes']['exclusive'] ?? null,
                'hotel_name' => $hotelInfo['hotelName'] ?? null,
                'hotel_rating' => $rating ?? null,
                'address' => $hotelInfo['address'] ?? null,
                'country_name' => $hotelInfo['countryName'] ?? null,
                'country_code' => $hotelInfo['countryCode'] ?? null,
                'description' => $hotelInfo['description1']['language']['@content'] ??null,
                'map' => $map,
                'phone_number' => $phone_number,
                'pin_code' => $hotelInfo['zipCode']??null,
                'city_name' => $hotelInfo['cityName']??null,
                'city_code' => $hotelInfo['cityCode']??null,
                'images' => implode(',', $images) ?? null,
                'check_in' => $hotelInfo['hotelCheckIn']??null,
                'check_out' => $hotelInfo['hotelCheckOut']??null ,
                'thumbnail' => $hotelInfo['images']['hotelImages']['thumb'] ?? null,
                'hotel_facilities' => implode(',', $ammenities) ?? null,
                'lastUpdated' => $hotelInfo['lastUpdated'] ?? null
            ];
            
            WebbedsHotel::insert($hoteldetails);
        }

        
    }
}
