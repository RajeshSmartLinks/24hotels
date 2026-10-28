<?php

namespace App\Http\Controllers\FrontEnd\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Hotel\Xml\SearchController;
use App\Models\DidaCity;
use App\Models\DidaHotel;
use App\Models\DidaHotelList;
use App\Models\HotelCity;
use App\Models\GtsCity;
use App\Models\TboHotel;
use App\Models\TboHotelsCity;
use App\Models\TboHotelsCode;
use App\Models\TboHotelsCountry;
use App\Models\WebbedsCity;
use App\Models\WebbedsCountry;
use App\Models\WebbedsHotel;
use App\Models\GtsHotel;
use App\Models\GtsHotelList;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Provincia;
use App\Models\RestelCity;
use App\Models\GtsCityHotel;
use App\Models\TdsCity;
use App\Models\TdsZone;
use App\Models\TdsHotelList;
use App\Models\TdsHotel;
Use App\Models\Role;
Use App\Models\User;
Use App\Models\Agent;

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

    public function DidaStoreCity()
    {
        header('Cache-Control: max-age=0,no-store');
        

        // Fetch countries that need city data
        $countries = WebbedsCountry::where('dida_city_dumped', 0)->where('alpha_code', '!=', null)->limit(15)->get();

        foreach ($countries as $country) {
            // Fetch city list from Dida API
            $cityList = $this->DadiApiStaticData([
                'query'       => ['countryCode' => $country->alpha_code], // dynamic country
                'end_point'   => 'region/destinations',
                'method'      => 'GET'
            ]);
          

            if ($cityList['status'] && isset($cityList['response']['data'])) {
                if (count($cityList['response']['data']) != 0) {
                    $cities = $cityList['response']['data'];

                    // Split into smaller chunks to prevent memory overload
                    $cityChunks = array_chunk($cities, 100);
                    //dd($cityChunks);
                

                    foreach ($cityChunks as $chunk) {
                        $insertData = [];

                        foreach ($chunk as $cityInfo) {
                            // echo "ddd";
                            $insertData[] = [
                                'dida_code'     => $cityInfo['code'] ?? null,
                                'name'          => $cityInfo['name'] ?? null,
                                'long_name'     => $cityInfo['longName'] ?? null,
                                'country_code'  => $country->alpha_code ?? null,
                                'country_name'  => $country->name ?? null,
                                'is_dida'        => 1,
                                'created_at'    => now(),
                                'updated_at'    => now(),
                            ];
                        }
                        //dd($insertData);

                        // ✅ Bulk insert all 100 cities in one go
                        if (!empty($insertData)) {
                            HotelCity::insert($insertData);
                        }
                    }
                    echo "Inserted cities for country: {$country->name}\n";
                    
                    
                }else{
                    echo "No cities found for country: {$country->name}\n";

                }
                
                // ✅ Mark this country as processed
                $country->update(['dida_city_dumped' => 1]);

              
            } else {
                echo "No data found or error for country: {$country->name}\n";
            }
            echo "<br>";
        }

        echo "✅ All cities inserted successfully.\n";
    }

    public function DidaStoreHotelList()
    {
        header('Cache-Control: max-age=0,no-store');
        

        // Fetch countries that need city data
        $countries = WebbedsCountry::where('dida_hotel_dumped', 0)->where('alpha_code', '!=', null)->limit(15)->get();
        //$countries = WebbedsCountry::where('dida_hotel_dumped', 0)->where('id', 104)->where('alpha_code', '!=', null)->limit(15)->get();
        //where('dida_city_dumped', 0)->

        foreach ($countries as $country) {
            // Fetch city list from Dida API
            $hotelList = $this->DadiApiStaticData([
                'query'       => ['countryCode' => $country->alpha_code], // dynamic country
                'end_point'   => 'hotel/list',
                'method'      => 'GET'
            ]);

            if ($hotelList['status'] && isset($hotelList['response']['data'])) {
                if (count($hotelList['response']['data']) != 0) {
                    $cities = $hotelList['response']['data'];

                    // Split into smaller chunks to prevent memory overload
                    $cityChunks = array_chunk($cities, 200);
                    foreach ($cityChunks as $chunk) {
                        $insertData = [];

                        foreach ($chunk as $hotelId) {
                            $insertData[] = [
                                'hotel_id'          => $hotelId,
                                'country_alpha_code'  => $country->alpha_code,
                                'created_at'    => now()
                            ];
                        }
                        //dd($insertData);

                        // ✅ Bulk insert all 100 cities in one go
                        if (!empty($insertData)) {
                            DidaHotelList::insert($insertData);
                        }
                    }
                    echo "Hotel ID Inserted for country: {$country->name}\n";
                }else{
                    echo "No Hotel ID found for country: {$country->name}\n";
                }
                
                // ✅ Mark this country as processed
                $country->update(['dida_hotel_dumped' => 1 , 'hotel_list_dumped_on' => now()]);
              
            } else {
                echo "No data found or error for country: {$country->name}\n";
            }
            echo "<br>";
        }

        echo "✅ All Hotel ID  inserted successfully.\n";
    }

    public function DidaStoreHotelDetails()
    {
        header('Cache-Control: max-age=0,no-store');

        // Fetch hotels needing detail dump
        $hotelList = 
        //DidaHotelList::where('is_hotel_details_dumped', 0)
        //DidaHotelList::where('hotel_id', 2788658)
        DidaHotelList::where('is_hotel_details_dumped', 0)
            ->where("country_alpha_code" ,"AE")
            ->whereNotNull('hotel_id')
            ->limit(100)
            ->get();
        
        
            
    

        if ($hotelList->isEmpty()) {
            return response()->json(['message' => 'No pending hotel details to process.']);
        }

        $hotelList->chunk(50)->each(function ($chunk, $chunkIndex) {
            $hotelIds = $chunk->pluck('hotel_id')->toArray();
  
            
            

            $payload = [
                'language' => 'en-US',
                'hotelIds' => $hotelIds,
            ];

            //try {
                // 🔹 Call API
                $apiResponse = $this->DadiApiStaticData([
                    'end_point' => 'hotel/details',
                    'method'    => 'POST',
                    'params'    => $payload,
                ]);
                //dd($apiResponse);

                if (!$apiResponse['status']) {
                    \Log::warning("Chunk {$chunkIndex} failed: " . $apiResponse['message']);
                    return;
                }
                //dd($apiResponse['response']);

                $hotels = $apiResponse['response']['data'] ?? [];

                foreach ($hotels as $hotel) {
                  

                    $imagesCsv = null;
                    $thumbnail = null;
                    $hotelImages = null;
                    if(isset($hotel['images']) && !empty($hotel['images'])){
                        $hotelImages = array_column(
                            array_filter($hotel['images'], function ($img) use (&$thumbnail) {
                                if (($img['isDefault'] ?? false) === true) {
                                    $thumbnail = $img['url'];
                                    return false;
                                }
                                return true;
                            }),
                            'url'
                        ) ?: null;
                    }
                    

                    if($thumbnail == null && !empty($hotelImages)){
                        $thumbnail = $hotelImages[0];
                    }
                    if(!empty($hotelImages)){
                        $imagesCsv = implode(',', $hotelImages);
                    }
                    
                    if(empty($imagesCsv) && (!empty($thumbnail)) ){
                        $imagesCsv = $thumbnail;
                    }
                    
                //    dd([
                //             'language'          => $hotel['language'] ?? 'en-US',
                //             'name'              => $hotel['name'] ?? null,
                //             'country_code'      => $hotel['location']['country']['code'] ?? null,
                //             'country_name'      => $hotel['location']['country']['name'] ?? null,
                //             'destination_code'  => $hotel['location']['destination']['code'] ?? null,
                //             'destination_name'  => $hotel['location']['destination']['name'] ?? null,
                //             'longitude'         => $hotel['location']['coordinate']['longitude'] ?? null,
                //             'latitude'          => $hotel['location']['coordinate']['latitude'] ?? null,
                //             'state_code'        => $hotel['location']['stateCode'] ?? null,
                //             'address'           => $hotel['location']['address'] ?? null,
                //             'telephone'         => $hotel['telephone'] ?? null,
                //             'star_rating'       => $hotel['starRating'] ?? null,
                //             'zip_code'          => $hotel['zipCode'] ?? null,
                //             'images'            => $imagesCsv ?? null,
                //             'thumbnail'         => $thumbnail ?? null
                //         ]);
                   
                    //dd($hotel ,$thumbnail ,$imagesCsv);
                    // 🔹 Flatten JSON and save to DB
                    $hotelInfo = DidaHotel::updateOrCreate(
                        ['hotel_id' => $hotel['id']],
                        [
                            'language'          => $hotel['language'] ?? 'en-US',
                            'name'              => $hotel['name'] ?? null,
                            'country_code'      => $hotel['location']['country']['code'] ?? null,
                            'country_name'      => $hotel['location']['country']['name'] ?? null,
                            'destination_code'  => $hotel['location']['destination']['code'] ?? null,
                            'destination_name'  => $hotel['location']['destination']['name'] ?? null,
                            'longitude'         => $hotel['location']['coordinate']['longitude'] ?? null,
                            'latitude'          => $hotel['location']['coordinate']['latitude'] ?? null,
                            'state_code'        => $hotel['location']['stateCode'] ?? null,
                            'address'           => $hotel['location']['address'] ?? null,
                            'telephone'         => $hotel['telephone'] ?? null,
                            'star_rating'       => $hotel['starRating'] ?? null,
                            'zip_code'          => $hotel['zipCode'] ?? null,
                            'images'            => $imagesCsv ?? null,
                            'thumbnail'         => $thumbnail ?? null
                        ]
                    );
                   
                }

                // 🔹 Mark hotels as dumped
                DidaHotelList::whereIn('hotel_id', $hotelIds)
                    ->update(['is_hotel_details_dumped' => 1]);

            // } catch (\Exception $e) {
            //     \Log::error("Chunk {$chunkIndex} processing failed", [
            //         'error' => $e->getMessage(),
            //         'hotel_ids' => $hotelIds,
            //     ]);
            // }

            // Optional: prevent rate limiting
            // sleep(1);
        });

        return response()->json(['message' => 'Hotel details imported successfully.']);
    }


    // public function addingDidaCodes(){
    //     header('Cache-Control: max-age=0,no-store');
    //     $didaCityList = DidaCity::where("is_moved", 0)->limit(100)->get();
    //     dd($didaCityList);

    //     foreach($didaCityList as $city){

    //         $webbedsCity = WebbedsCity::where(['name' => $city->name , 'country_name' => $city->country])->get();
          
    //         if(count($webbedsCity) > 0){
    //             // if(count($webbedsCity) == 1){
    //             //     WebbedsCity::where('id', $webbedsCity->id)->update(['dida_code' => $city->code , 'is_dida' => 1 , 'updated_at' => now(),'long_name' => $city->longName]);
    //             // }else{
    //             //     foreach($webbedsCity as $webbedCityData){
    //             //         if($webbedCityData->code != null){
    //             //             DidaCity::where('id', $city->id)->update(['webbeds_city_code' => $webbedCityData->code]);
    //             //             echo "Webbeds city code added for city: {$city->name}\n";
    //             //         }
    //             //     }
    //             // }
    //             if(count($webbedsCity) == 1){
    //                 WebbedsCity::where('id', $webbedsCity->first()->id)->update(['dida_code' => $city->code , 'is_dida' => 1 , 'updated_at' => now(),'long_name' => $city->longName]);
    //             }else{

    //             }
                
    //         }else{

    //             // adding new
    //             $newWebbedsCity = [
    //                 'name'          => $city->name,
    //                 'country_name'  => $city->country,
    //                 'country_code'  => $city->countryCode,
    //                 'dida_code'     => $city->code, // code will be null for now, can be updated later
    //                 'long_name'     => $city->longName,
    //                 'country_code'  => $city->countryCode,
    //                 'is_dida'       => 1,
    //                 'created_at'    => now(),
    //                 'updated_at'    => now()
    //             ];
    //             WebbedsCity::create($newWebbedsCity);
    //         }

    //         $didaCityList->update(['is_moved' => 1]);

           
    //     }

    //     echo "✅ All DIDA codes added successfully.\n";
    // }

    public function GtsStoreHotelIds(Request $request)
    {
        set_time_limit(0);
        header('Cache-Control: max-age=0,no-store');

        $lastSyncDate = '1970-01-01';
        $idType =  'New';
        $nextKey = null;
        $maxPages = 50;


        $pageCount = 0;
        $totalInserted = 0;

        do {
            $queryParams = [
                'lastSyncDate' => $lastSyncDate,
                'idType'       => $idType,
            ];

            if ($nextKey) {
                $queryParams['nextKey'] = $nextKey;
            }else{
                $getLastHotelId = GtsHotelList::orderBy('id', 'desc')->first();
                if($getLastHotelId){
                    $queryParams['nextKey'] = $getLastHotelId->hotel_id;
                }
             
            }

            $response = $this->GTSStaticApi([
                'end_point' => 'hotelcontent/ids',
                'method'    => 'GET',
                'query'     => $queryParams
            ]);

            if (!$response['status']) {
                echo "❌ Failed to fetch page " . ($pageCount + 1) . ": " . $response['message'] . "<br>";
                break;
            }

            $data = $response['response'];
            $ids = $data['ids'] ?? [];
            $nextKey = $data['nextKey'] ?? null;

            if (empty($ids)) {
                echo "ℹ️ No IDs returned in page " . ($pageCount + 1) . ". Ending loop.<br>";
                break;
            }

            $insertData = [];
            foreach ($ids as $hotelId) {
                $insertData[] = [
                    'hotel_id'                => $hotelId,
                    'is_hotel_details_dumped' => 0,
                    'created_at'              => now(),
                    'updated_at'              => now()
                ];
            }

            $chunks = array_chunk($insertData, 200);
            foreach ($chunks as $chunk) {
                DB::table('gts_hotel_lists')->insertOrIgnore($chunk);
            }

            $insertedInThisPage = count($ids);
            $totalInserted += $insertedInThisPage;
            $pageCount++;

            echo "✅ Page {$pageCount} processed. Fetched {$insertedInThisPage} IDs. NextKey: " . ($nextKey ?? 'NULL') . "<br>";
            if (ob_get_level() > 0) {
                ob_flush();
            }
            flush();

            if ($maxPages && $pageCount >= $maxPages) {
                echo "🛑 Reached maximum page limit of {$maxPages}. Remaining nextKey: {$nextKey}<br>";
                break;
            }

        } while ($nextKey !== null);

        return response()->json([
            'status'            => 'success',
            'pages_processed'   => $pageCount,
            'total_ids_fetched' => $totalInserted,
            'nextKey'           => $nextKey
        ]);
    }

    // public function GtsStoreHotelDetails(Request $request)
    // {
    //     set_time_limit(0);
    //     header('Cache-Control: max-age=0,no-store');

    //     $limit = $request->input('limit') ?? 100;

    //     // Fetch hotel IDs needing detail dump
    //     $hotelList = GtsHotelList::where('is_hotel_details_dumped', 0)
    //         ->whereNotNull('hotel_id')
    //         ->limit($limit)
    //         ->get();
  
    //     if ($hotelList->isEmpty()) {
    //         return response()->json(['status' => 'success', 'message' => 'No pending hotel details to process.']);
    //     }

    //     $processedCount = 0;

    //     $hotelList->chunk(50)->each(function ($chunk, $chunkIndex) use (&$processedCount) {
    //         $hotelIds = $chunk->pluck('hotel_id')->toArray();

    //         $payload = [
    //             'hotelIds' => $hotelIds,
    //         ];
           
          

    //         $apiResponse = $this->GTSStaticApi([
    //             'end_point' => 'hotelcontent',
    //             'method'    => 'GET',
    //             'query'    => $payload,
    //         ]);
           

    //         if (!$apiResponse['status']) {
    //             \Log::warning("GTS Chunk {$chunkIndex} failed: " . $apiResponse['message']);
    //             echo "❌ Chunk " . ($chunkIndex + 1) . " failed: " . $apiResponse['message'] . "<br>";
    //             return;
    //         }

    //         $hotels = $apiResponse['response']['hotels'] ?? [];

    //         foreach ($hotels as $hotel) {
                
    //             if (empty($hotel['id'])) {
    //                 continue;
    //             }
                

    //             $addrParts = [];
    //             $addrObj = $hotel['contact']['address'] ?? [];
    //             if (!empty($addrObj['line1'])) {
    //                 $addrParts[] = $addrObj['line1'];
    //             }
    //             if (!empty($addrObj['city']['name'])) {
    //                 $addrParts[] = $addrObj['city']['name'];
    //             }
    //             if (!empty($addrObj['state']['name'])) {
    //                 $addrParts[] = $addrObj['state']['name'];
    //             }
    //             if (!empty($addrObj['postalCode'])) {
    //                 $addrParts[] = $addrObj['postalCode'];
    //             }
    //             if (!empty($addrObj['country']['name'])) {
    //                 $addrParts[] = $addrObj['country']['name'];
    //             }
    //             $address = implode(', ', $addrParts);
    //             $roomsInfo = null;
    //             if(!empty($hotel['rooms'])){
    //                 $rooms = $hotel['rooms'];
    //                 $roomArray = array_map(function ($room) {
    //                     $beds = collect($room['beds'])->map(function ($bed) {
    //                         return $bed['count'] . ' ' . $bed['type'];
    //                     })->implode(', ');
    //                     return [
    //                         'id'   => $room['id'],
    //                         'type' => $room['type'],
    //                         'bed'  => $beds,
    //                     ];
    //                 }, $rooms);
    //                 // Store in database
    //                 $roomsInfo = json_encode($roomArray);
    //             }
               
                

    //             GtsHotel::updateOrCreate(
    //                 ['hotel_id' => $hotel['id']],
    //                 [
    //                     'country_code' => $hotel['contact']['address']['country']['code'] ?? null,
    //                     'country_name' => $hotel['contact']['address']['country']['name'] ?? null,
    //                     'longitude'    => $hotel['geoCode']['long'] ?? null,
    //                     'latitude'     => $hotel['geoCode']['lat'] ?? null,
    //                     'name'         => $hotel['name'] ?? null,
    //                     'star_rating'  => $hotel['starRating'] ?? null,
    //                     'address'      => $address,
    //                     'telephone'    => $hotel['contact']['phone'] ?? null,
    //                     'zipcode'      => $hotel['contact']['address']['postalCode'] ?? null,
    //                     'thumbnail'    => $hotel['heroImage'] ?? null,
    //                     'checkin'      => $hotel['checkinInfo']['beginTime'] ?? null,
    //                     'checkout'     => $hotel['checkoutInfo']['time'] ?? null,
    //                     'rooms'        => $roomsInfo
    //                 ]
    //             );

    //             $processedCount++;
    //         }

    //         // Mark this chunk's hotel IDs as dumped
    //         GtsHotelList::whereIn('hotel_id', $hotelIds)
    //             ->update(['is_hotel_details_dumped' => 1]);

    //         echo "✅ Chunk " . ($chunkIndex + 1) . " processed. Saved details for " . count($hotels) . " hotels.<br>";
    //         if (ob_get_level() > 0) {
    //             ob_flush();
    //         }
    //         flush();
    //     });

    //     return response()->json([
    //         'status'          => 'success',
    //         'processed_count' => $processedCount,
    //     ]);
    // }
    // public function GtsStoreHotelDetails(Request $request)
    // {
    //     set_time_limit(0);
    //     header('Cache-Control: max-age=0,no-store');

    //     $limit = 500;

    //     // Fetch hotel IDs needing detail dump
    //     $hotelList = GtsCityHotel::where('is_hotel_details_dumped', 0)
    //         ->whereNotNull('hotel_id')
    //         ->limit($limit)
    //         ->get();
  
    //     if ($hotelList->isEmpty()) {
    //         return response()->json(['status' => 'success', 'message' => 'No pending hotel details to process.']);
    //     }

    //     $processedCount = 0;

    //     $hotelList->chunk(50)->each(function ($chunk, $chunkIndex) use (&$processedCount) {
    //         $hotelIds = $chunk->pluck('hotel_id')->toArray();

    //         $payload = [
    //             'hotelIds' => $hotelIds,
    //         ];
            
           
          

    //         $apiResponse = $this->GTSStaticApi([
    //             'end_point' => 'hotelcontent',
    //             'method'    => 'GET',
    //             'query'    => $payload,
    //         ]);
          

    //         if (!$apiResponse['status']) {
    //             \Log::warning("GTS Chunk {$chunkIndex} failed: " . $apiResponse['message']);
    //             echo "❌ Chunk " . ($chunkIndex + 1) . " failed: " . $apiResponse['message'] . "<br>";
    //             return;
    //         }

    //         $hotels = $apiResponse['response']['hotels'] ?? [];

    //         foreach ($hotels as $hotel) {
                
    //             if (empty($hotel['id'])) {
    //                 continue;
    //             }
                

    //             $addrParts = [];
    //             $addrObj = $hotel['contact']['address'] ?? [];
    //             if (!empty($addrObj['line1'])) {
    //                 $addrParts[] = $addrObj['line1'];
    //             }
    //             if (!empty($addrObj['city']['name'])) {
    //                 $addrParts[] = $addrObj['city']['name'];
    //             }
    //             if (!empty($addrObj['state']['name'])) {
    //                 $addrParts[] = $addrObj['state']['name'];
    //             }
    //             if (!empty($addrObj['postalCode'])) {
    //                 $addrParts[] = $addrObj['postalCode'];
    //             }
    //             if (!empty($addrObj['country']['name'])) {
    //                 $addrParts[] = $addrObj['country']['name'];
    //             }
    //             $address = implode(', ', $addrParts);
    //             $roomsInfo = null;
    //             // if(!empty($hotel['rooms'])){
    //             //     $rooms = $hotel['rooms'];
    //             //     $roomArray = array_map(function ($room) {
    //             //         $beds = collect($room['beds'])->map(function ($bed) {
    //             //             return $bed['count'] . ' ' . $bed['type'];
    //             //         })->implode(', ');
    //             //         return [
    //             //             'id'   => $room['id'],
    //             //             'type' => $room['type'],
    //             //             'bed'  => $beds,
    //             //         ];
    //             //     }, $rooms);
    //             //     // Store in database
    //             //     $roomsInfo = json_encode($roomArray);
    //             // }
               
                

    //             $cityHotel = $chunk->where('hotel_id', $hotel['id'])->first();

    //             GtsHotel::updateOrCreate(
    //                 ['hotel_id' => $hotel['id']],
    //                 [
    //                     'city_code'    => $cityHotel ? $cityHotel->city_code : null,
    //                     'country_code' => $hotel['contact']['address']['country']['code'] ?? null,
    //                     'country_name' => $hotel['contact']['address']['country']['name'] ?? null,
    //                     'longitude'    => $hotel['geoCode']['long'] ?? null,
    //                     'latitude'     => $hotel['geoCode']['lat'] ?? null,
    //                     'name'         => $hotel['name'] ?? null,
    //                     'star_rating'  => $hotel['starRating'] ?? null,
    //                     'address'      => $address,
    //                     'telephone'    => $hotel['contact']['phone'] ?? null,
    //                     'zipcode'      => $hotel['contact']['address']['postalCode'] ?? null,
    //                     'thumbnail'    => $hotel['heroImage'] ?? null,
    //                     'checkin'      => $hotel['checkinInfo']['beginTime'] ?? null,
    //                     'checkout'     => $hotel['checkoutInfo']['time'] ?? null,
    //                     // 'rooms'        => $roomsInfo
    //                 ]
    //             );

    //             $processedCount++;
    //         }

    //         // Mark this chunk's hotel IDs as dumped
    //         GtsCityHotel::whereIn('hotel_id', $hotelIds)
    //             ->update(['is_hotel_details_dumped' => 1]);

    //         echo "✅ Chunk " . ($chunkIndex + 1) . " processed. Saved details for " . count($hotels) . " hotels.<br>";
    //         if (ob_get_level() > 0) {
    //             ob_flush();
    //         }
    //         flush();
    //     });

    //     return response()->json([
    //         'status'          => 'success',
    //         'processed_count' => $processedCount,
    //     ]);
    // }
    public function GtsStoreHotelDetails(Request $request)
    {
        set_time_limit(0);
        header('Cache-Control: max-age=0,no-store');

        $limit     = 600;
        $chunkSize = 50;

        //    $hotelList = GtsCityHotel::query()
        //                 // ->select(['hotel_id', 'city_code'])
        //                 ->select(['hotel_id'])
        //                 ->where('is_hotel_details_dumped', 0)
        //                 ->whereNotNull('hotel_id')
        //                 ->groupBy('hotel_id')
        //                 ->orderBy('id','ASC')
        //                 ->limit($limit)
        //                 ->get();
        $hotelList = GtsCityHotel::query()
        ->select([
            'hotel_id',
            DB::raw('MIN(id) AS first_id')
        ])
        ->where('is_hotel_details_dumped', 0)
        ->whereNotNull('hotel_id')
        ->groupBy('hotel_id')
        ->orderBy('first_id', 'asc')
        ->limit($limit)
        ->get();
        // dd($hotelList);
            
           

        if ($hotelList->isEmpty()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'No pending hotel details to process.',
            ]);
        }


        $processedCount = 0;

        foreach ($hotelList->chunk($chunkSize) as $chunkIndex => $chunk) {
          

            $hotelIds = $chunk
                ->pluck('hotel_id')
                ->filter()
                ->unique()
                ->values()
                ->toArray();
             // dd($hotelIds,$chunk
              //  ->pluck('hotel_id'));
            if (empty($hotelIds)) {
                continue;
            }

            /*
            * Create hotel_id => city_code map.
            *
            * This avoids:
            * $chunk->where('hotel_id', $hotel['id'])->first()
            *
            * inside the hotel loop.
            */
            // $cityCodeMap = $chunk
            //     ->pluck('city_code', 'hotel_id')
            //     ->toArray();
           
            $apiResponse = $this->GTSStaticApi([
                'end_point' => 'hotelcontent',
                'method'    => 'GET',
                'query'     => [
                    'hotelIds' => $hotelIds,
                ],
            ]);
            //dd($hotelIds ,$apiResponse);

            if (!$apiResponse['status']) {

                \Log::warning(
                    "GTS Chunk {$chunkIndex} failed: " .
                    $apiResponse['message']
                );

                continue;
            }

            $hotels = $apiResponse['response']['hotels'] ?? [];

            if (empty($hotels)) {
                continue;
            }

            $now     = now();
            $upserts = [];
            $returnedHotelIds = [];

            foreach ($hotels as $hotel) {

                $hotelId = $hotel['id'] ?? null;

                if (empty($hotelId)) {
                    continue;
                }

                $returnedHotelIds[] = $hotelId;

                $address = collect([
                    $hotel['contact']['address']['line1'] ?? null,
                    $hotel['contact']['address']['city']['name'] ?? null,
                    $hotel['contact']['address']['state']['name'] ?? null,
                    $hotel['contact']['address']['postalCode'] ?? null,
                    $hotel['contact']['address']['country']['name'] ?? null,
                ])
                    ->filter(fn ($value) => !empty($value))
                    ->implode(', ');

                $upserts[] = [
                    'hotel_id'     => $hotelId,
                    // 'city_code'    => $cityCodeMap[$hotelId] ?? null,
                    'city_code'    =>  null,

                    'country_code' => $hotel['contact']['address']['country']['code'] ?? null,
                    'country_name' => $hotel['contact']['address']['country']['name'] ?? null,

                    'longitude'    => $hotel['geoCode']['long'] ?? null,
                    'latitude'     => $hotel['geoCode']['lat'] ?? null,

                    'name'         => $hotel['name'] ?? null,
                    'star_rating'  => $hotel['starRating'] ?? null,

                    'address'      => $address,

                    'telephone'    => $hotel['contact']['phone'] ?? null,
                    'zipcode'      => $hotel['contact']['address']['postalCode'] ?? null,

                    'thumbnail'    => $hotel['heroImage'] ?? null,

                    'checkin'      => $hotel['checkinInfo']['beginTime'] ?? null,
                    'checkout'     => $hotel['checkoutInfo']['time'] ?? null,

                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }

            /*
            * One bulk query instead of updateOrCreate()
            * for every hotel.
            */
            if (!empty($upserts)) {

                $upsetResult = GtsHotel::upsert(
                    $upserts,
                    ['hotel_id'],
                    [
                        //'city_code',
                        'country_code',
                        'country_name',
                        'longitude',
                        'latitude',
                        'name',
                        'star_rating',
                        'address',
                        'telephone',
                        'zipcode',
                        'thumbnail',
                        'checkin',
                        'checkout',
                        'updated_at',
                    ]
                );

                $processedCount += count($upserts);
            }

            /*
            * Mark successfully received hotels as dumped.
            *
            * This is safer than marking every requested ID as dumped.
            */
            if (!empty($hotelIds)) {

                GtsCityHotel::whereIn('hotel_id', $hotelIds)
                    ->update([
                        'is_hotel_details_dumped' => 1,
                    ]);
            }
            echo "✅ Chunk " . ($chunkIndex + 1) .
                " processed. Saved details for " .
                count($upserts) .
                " hotels.<br>";
            //dd($upsetResult,$upserts);

            

            if (ob_get_level() > 0) {
                ob_flush();
            }

            flush();
        }

        return response()->json([
            'status'          => 'success',
            'processed_count' => $processedCount,
        ]);
    }
    public function getRestelCity(){
        header( 'Cache-Control: max-age=0,no-store');
        $hotelUrl = env('RESTEL_URL') ;

        $provincia = Provincia::where(['status' => 'active', 'is_dumped' => '1'])->limit(20)->get();
        //$provincia = Provincia::where(['status' => 'active', 'id' => '1'])->limit(10)->get();
        foreach($provincia as $prov){
            //xml preparation 
            $xml = '<peticion>
                        <tipo>18</tipo>
                        <nombre>Servicio de poblaciones</nombre>
                        <agencia>Agencia prueba</agencia>
                        <parametros>
                            <codest>'.$prov->codigoProvincia.'</codest> 
                        </parametros>
                    </peticion>';
            $data['xml'] = $xml;
            $cityInfo = $this->RestelApiXmlRequestWithoutLog($data);
           
            $CountryInfo = WebbedsCountry::where('restel_code', $prov->codigoPais)->first();
            dd( $CountryInfo,$prov->codigoPais);
           
            
            if($cityInfo['success']){
                //dd($cityInfo['city']);
                foreach($cityInfo['city'] as $city){
                   //$cityInfo = WebbedsCity::where(['name'=> strtolower($city['poblidinom1']) , 'country_code' => $CountryInfo->code])->first();
                    //    if($cityInfo){
                    //         //already exist
                    //         $cityInfo->restel_city_code = $city['codpob'];
                    //         $cityInfo->restel_country_code = $CountryInfo->restel_code;
                    //         $cityInfo->restel_provincia_code = $city['deppob'];
                    //         $cityInfo->save();
                    //    }else{
                    //         //need to add new city
                    //         $newCity = new WebbedsCity();
                    //         $newCity->name = $city['poblidinom1'];
                    //         $newCity->country_name = $CountryInfo->name;
                    //         $newCity->country_code = $CountryInfo->code;
                    //         $newCity->restel_city_code = $city['codpob'];
                    //         $newCity->restel_country_code = $CountryInfo->restel_code;
                    //         $newCity->restel_provincia_code = $city['deppob'];
                    //         $newCity->save();
                    //    } 
                    $newCity = new RestelCity();
                    $newCity->name = $city['poblidinom1'];
                    $newCity->country_name = $CountryInfo->name;
                    $newCity->country_code = $CountryInfo->code;
                    $newCity->restel_city_code = $city['codpob'];
                    $newCity->restel_country_code = $CountryInfo->restel_code;
                    $newCity->restel_provincia_code = $city['deppob'];
                    $newCity->save();
                }
                $prov->is_dumped = '2';
            }else{
                $prov->is_dumped = '3';
            }
           
            $prov->save();
            Log::info("provincia " . $prov->id . "(" . $prov->nombreProvincia . ") processed successfully");
            echo "provincia " . $prov->id . "(" . $prov->nombreProvincia . ") processed successfully";
            echo "<br>";
        }
    }

    public function syncGtsCountries()
    {
        ini_set('max_execution_time', 0);
        $jsonFilePath = public_path('gtsCountries.json');
        
        if (!file_exists($jsonFilePath)) {
            return response()->json(['status' => false, 'message' => 'gtsCountries.json file not found.']);
        }

        $json = file_get_contents($jsonFilePath);
        $data = json_decode($json, true);

        $added = 0;
        $updated = 0;

        if (isset($data['countries']) && is_array($data['countries'])) {
            foreach ($data['countries'] as $countryData) {
                $gtsCode = $countryData['id'] ?? null;
                $isoCode = $countryData['country'] ?? null;
                $name = $countryData['name'] ?? null;
                
                if (!$isoCode) continue;

                $country = WebbedsCountry::where('alpha_code', $isoCode)->first();
                if ($country) {
                    $country->gts_code = $gtsCode;
                    $country->save();
                    $updated++;
                } else {
                    $newCountry = new WebbedsCountry();
                    $newCountry->alpha_code = $isoCode;
                    $newCountry->name = $name;
                    $newCountry->gts_code = $gtsCode;
                    $newCountry->save();
                    $added++;
                }
            }
            return response()->json([
                'status' => true, 
                'message' => "GTS Countries synced successfully. Added: $added, Updated: $updated"
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid JSON data format.']);
    }

    public function dumpGtsCities()
    {
  
        ini_set('max_execution_time', 0);
        
        $country = WebbedsCountry::where(function($q) {
            $q->where('gts_city_dumped', 0)->orWhereNull('gts_city_dumped');
        })->whereNotNull('gts_code')->first();

        if (!$country) {
            return response()->json(['message' => 'All countries are completely dumped', 'status' => true]);
        }
        
        $countryCode = $country->alpha_code;
        $nextResultsKey = $country->next_results_key;
        
        $query = ['country' => $countryCode];
        if ($nextResultsKey) {
            $query['nextKey'] = $nextResultsKey;
        }
    

        $request = [
            'end_point' => 'hotelcontent/cities',
            'method' => 'GET',
            'query' => $query
        ];

        $apiResponse = $this->GtsApiJsonRequestWithoutLog($request);
        

       
        
        if ($apiResponse['status'] && isset($apiResponse['response'])) {
            $data = $apiResponse['response'];
            $inserted = 0;
            
            if (isset($data['cities']) && is_array($data['cities'])) {
                $citiesToUpsert = [];
                $now = now();
                foreach ($data['cities'] as $cityData) {
                    $citiesToUpsert[] = [
                        'gts_city_id' => $cityData['id'],
                        'name' => $cityData['name'] ?? null,
                        'full_name' => $cityData['fullName'] ?? null,
                        'country_code' => $cityData['country'] ?? null,
                        'country_name' => $country->name,
                    ];
                }
                
                if (!empty($citiesToUpsert)) {
                    // Ensure uniqueness in the batch to prevent SQL errors
                    $uniqueCities = collect($citiesToUpsert)->unique('gts_city_id')->toArray();
                    
                    \App\Models\GtsCity::upsert(
                        $uniqueCities,
                        ['gts_city_id'], // unique columns
                        ['name', 'full_name', 'country_code', 'country_name'] // columns to update
                    );
                    
                    $inserted = count($uniqueCities);
                }
            }
            
            if (isset($data['moreResults']) && $data['moreResults'] == true) {
                $country->next_results_key = $data['nextResultsKey'] ?? null;
                $country->save();
                
                // Add a script to auto-refresh the page to continue dumping
                echo "<script>setTimeout(function() { window.location.reload(); }, 1000);</script>";
                return "Dumped partially for {$country->name}. Inserted/Updated: {$inserted}. Next key: " . $country->next_results_key . ". Reloading...";
            } else {
                $country->gts_city_dumped = 1;
                $country->next_results_key = null;
                $country->save();
                
                // Add a script to auto-refresh the page to continue dumping the next country
                echo "<script>setTimeout(function() { window.location.reload(); }, 1000);</script>";
                return "Country {$country->name} dumped completely. Inserted/Updated: {$inserted}. Moving to next country...";
            }
        }
        
        return response()->json(['message' => "Failed to fetch from API: " . ($apiResponse['message'] ?? 'Unknown Error'), 'status' => false]);
    }

    // public function dumpGtsCityHotels()
    // {
    //     ini_set('max_execution_time', 0);
        
    //     $cities = \App\Models\GtsCity::where('is_hotel_dumped', 0)->limit(100)->get();
    //     //474456
    //     //$cities = \App\Models\GtsCity::where('gts_city_id', 474456)->limit(100)->get();
        

    //     if ($cities->isEmpty()) {
    //         return response()->json(['message' => 'All city hotels are completely dumped', 'status' => true]);
    //     }

    //     foreach ($cities as $city) {
    //         $request = [
    //             'end_point' => 'hotelcontent/' . $city->gts_city_id . '/ids',
    //             'method' => 'GET'
    //         ];

    //         $apiResponse = $this->GtsApiJsonRequestWithoutLog($request);
    //         //dd($apiResponse);
    //         if($apiResponse['status']){
    //             if (isset($apiResponse['response'])) {
    //                 $data = $apiResponse['response'];
                    
    //                 if (isset($data['ids']) && is_array($data['ids'])) {
    //                     $hotelsToInsert = [];
    //                     foreach ($data['ids'] as $hotelId) {
    //                         $hotelsToInsert[] = [
    //                             'city_name' => $city->name,
    //                             'city_code' => $city->gts_city_id,
    //                             'country_name' => $city->country_name,
    //                             'country_code' => $city->country_code,
    //                             'hotel_id' => $hotelId,
    //                             'is_hotel_details_dumped' => 0,
    //                             'created_at' => now(),
    //                             'updated_at' => now(),
    //                         ];
    //                     }
                        
    //                     if (!empty($hotelsToInsert)) {
    //                         $chunks = array_chunk($hotelsToInsert, 500);
    //                         foreach ($chunks as $chunk) {
    //                             \DB::table('gts_city_hotels')->insert($chunk);
    //                         }
    //                     }
    //                 }
    //                 // $city->is_hotel_dumped = 1;
    //                 // $city->save();
    //             } else {
    //                 \Log::error("Failed to dump hotels for city {$city->name}: " . ($apiResponse['message'] ?? 'Unknown Error'));
    //             }
    //         }
    //         $city->is_hotel_dumped = 1;
    //         $city->save();
    //     }
        
    //     //echo "<script>setTimeout(function() { window.location.reload(); }, 1000);</script>";
    //     return "Dumped hotels for 50 cities. Reloading...";
    // }
    public function dumpGtsCityHotels()
    {
        ini_set('max_execution_time', 0);

        $limit = 100;
        $insertChunkSize = 500;
        echo "<pre>";

        $cities = \App\Models\GtsCity::query()
            ->select([
                'id',
                'gts_city_id',
                'name',
                'country_name',
                'country_code',
            ])
            ->where('is_hotel_dumped', 0)
            ->limit($limit)
            ->orderBy('id' ,'ASC')
            ->get();
        
        if ($cities->isEmpty()) {
            return response()->json([
                'message' => 'All city hotels are completely dumped',
                'status'  => true,
            ]);
        }

        $processedCities = 0;
        $failedCities = 0;
        $totalHotels = 0;

        foreach ($cities as $city) {

            $apiResponse = $this->GtsApiJsonRequestWithoutLog([
                'end_point' => 'hotelcontent/' . $city->gts_city_id . '/ids',
                'method'    => 'GET',
            ]);
           

            /*
            * API failed.
            *
            * Keep is_hotel_dumped = 0 so the city
            * can be retried in the next execution.
            */
            if (!$apiResponse['status']) {

                $failedCities++;

                \Log::error(
                    "Failed to dump hotels for city {$city->name} " .
                    "({$city->gts_city_id}): " .
                    ($apiResponse['message'] ?? 'Unknown Error')
                );

                continue;
            }

            /*
            * API succeeded.
            */
            $data = $apiResponse['response'] ?? [];

            /*
            * GTS may return:
            *
            * ids => []
            * ids => null
            * ids not present
            *
            * All of these mean there are no hotels
            * for this city.
            */
            $hotelIds = $data['ids'] ?? [];

            if (!is_array($hotelIds) || empty($hotelIds)) {

                \App\Models\GtsCity::whereKey($city->id)
                    ->update([
                        'is_hotel_dumped' => 1,
                        'updated_at'      => now(),
                    ]);

                $processedCities++;

                \Log::info(
                    "No hotels found for city {$city->name} " .
                    "({$city->gts_city_id})"
                );

                continue;
            }

            /*
            * Remove empty/null IDs.
            *
            * No array_unique() because you confirmed
            * that duplicate hotel IDs will not exist.
            */
            $hotelIds = array_values(
                array_filter($hotelIds)
            );

            /*
            * If there are no valid IDs after filtering,
            * consider the city successfully processed.
            */
            if (empty($hotelIds)) {

                \App\Models\GtsCity::whereKey($city->id)
                    ->update([
                        'is_hotel_dumped' => 1,
                        'updated_at'      => now(),
                    ]);

                $processedCities++;

                continue;
            }

            /*
            * Generate timestamp once for the whole city.
            */
            $now = now();

            /*
            * Insert hotels in batches of 500.
            */
            foreach (array_chunk($hotelIds, $insertChunkSize) as $hotelIdChunk) {

                $hotelsToInsert = [];

                foreach ($hotelIdChunk as $hotelId) {

                    $hotelsToInsert[] = [
                        'city_name'               => $city->name,
                        'city_code'               => $city->gts_city_id,
                        'country_name'            => $city->country_name,
                        'country_code'            => $city->country_code,
                        'hotel_id'                => $hotelId,
                        'is_hotel_details_dumped' => 0,
                        'created_at'              => $now,
                        'updated_at'              => $now,
                    ];
                }

                /*
                * Normal bulk insert.
                *
                * No insertOrIgnore() because duplicates
                * are not expected.
                */
                \DB::table('gts_city_hotels')
                    ->insert($hotelsToInsert);

                $totalHotels += count($hotelIdChunk);
            }
            

            /*
            * Mark city as dumped only after all hotel
            * records have been inserted successfully.
            */
            \App\Models\GtsCity::whereKey($city->id)
                ->update([
                    'is_hotel_dumped' => 1,
                    'updated_at'      => $now,
                ]);

            $processedCities++;

            echo "✅ {$city->name} - {$city->id}- " .
                count($hotelIds) .
                " hotels dumped.<br>";

            if (ob_get_level() > 0) {
                ob_flush();
            }

            flush();
        }

        return response()->json([
            'status'           => true,
            'message'          => "Processed {$processedCities} cities.",
            'processed_cities' => $processedCities,
            'failed_cities'    => $failedCities,
            'total_hotels'     => $totalHotels,
        ]);
    }

    public function mergeGtsCities()
    {
        ini_set('max_execution_time', 0);
        
        $hotelCities = HotelCity::where('is_city_checked', 0)->limit(4000)->get();
        
        $countryCodes = $hotelCities->pluck('country_code')->filter()->unique()->toArray();
        $names = $hotelCities->map(function ($hc) {
            return strtolower(str_replace(' (and vicinity)', '', $hc->name));
        })->filter()->unique()->toArray();
        
        $allGtsCities = \App\Models\GtsCity::where('is_migrated', 0)
            ->whereIn('country_code', $countryCodes)
            ->whereIn(\DB::raw('LOWER(name)'), $names)
            ->get();
            
        $gtsCitiesGrouped = [];
        foreach ($allGtsCities as $gc) {
            $key = $gc->country_code . '_' . strtolower($gc->name);
            if (!isset($gtsCitiesGrouped[$key])) {
                $gtsCitiesGrouped[$key] = collect();
            }
            $gtsCitiesGrouped[$key]->push($gc);
        }

        \DB::beginTransaction();
        try {
            foreach ($hotelCities as $hotelCity) {
            
                $name = strtolower(str_replace(' (and vicinity)', '', $hotelCity->name));
                $longName = strtolower(str_replace(' (and vicinity)', '', $hotelCity->long_name));
                
                $key = $hotelCity->country_code . '_' . $name;
                $matches = $gtsCitiesGrouped[$key] ?? collect();
                
                $match = null;
                if ($matches->count() == 1) {
                    $match = $matches->first();
                } elseif ($matches->count() > 1 && !empty($longName)) {
                    $match = $matches->first(function ($city) use ($longName) {
                        return strtolower($city->full_name) == $longName;
                    });
                }
         
                
                if ($match) {
                    $hotelCity->gts_code = $match->gts_city_id;
                    $hotelCity->is_gts = 1;
                    $match->is_migrated = 1;
                    $match->save();
                    
                    // Remove matched city so it's not reused
                    $gtsCitiesGrouped[$key] = $gtsCitiesGrouped[$key]->reject(function ($c) use ($match) {
                        return $c->gts_city_id === $match->gts_city_id;
                    });
                }
                
                $hotelCity->is_city_checked = 1;
                $hotelCity->save();
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        
        return response()->json(['message' => 'GTS cities merged and updated successfully', 'status' => true]);
    }

    public function moveUnmigratedGtsCities()
    {
        ini_set('max_execution_time', 0);

        $unmigratedCities = \DB::table('gts_cities')
            ->where('is_migrated', 0)
            ->orderBy('id')
            ->limit(10)
            ->get();

        if ($unmigratedCities->isEmpty()) {
            return response()->json(['message' => 'No unmigrated cities found.', 'status' => true]);
        }

        $chunks = $unmigratedCities->chunk(1000);

        \DB::transaction(function () use ($chunks) {
            foreach ($chunks as $chunk) {
                $insertData = [];
                $migratedIds = [];

                foreach ($chunk as $city) {
                    $insertData[] = [
                        'name'         => $city->name,
                        'long_name'    => $city->full_name,
                        'country_code' => $city->country_code,
                        'country_name' => $city->country_name,
                        'created_at'   => $city->created_at,
                        'updated_at'   => $city->updated_at,
                        'is_gts'       => 1,
                        'gts_code'     => $city->gts_city_id,
                    ];
                    $migratedIds[] = $city->id;
                }

                \DB::table('hotel_cities')->insert($insertData);
                \DB::table('gts_cities')->whereIn('id', $migratedIds)->update(['is_migrated' => 1]);
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Moved ' . count($unmigratedCities) . ' unmigrated GTS cities successfully.'
        ]);
    }

    public function dumpTdsCities()
    {
        // $searchController = new SearchController();
        // $apiResponse = $searchController->tdsCityDatafetch();
        
        // if (!$apiResponse['success']) {
        //     echo "API Request failed: " . ($apiResponse['message'] ?? '');
        //     return;
        // }
        $filePath = public_path('tdscities.xml');
        if (!file_exists($filePath)) {
            echo "File tdscities.xml not found in public folder.";
            return;
        }

        $reader = new \XMLReader();
        if (!$reader->open($filePath)) {
            echo "Failed to open XML file.";
            return;
        }

        $insertData = [];
        $count = 0;

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->localName === 'City') {
                $cityXml = $reader->readOuterXml();
                // Remove namespace prefix if present to simplify simplexml parsing
                $cityXml = str_replace(['jp:', 'xmlns:jp="http://www.juniper.es/webservice/2007/"'], '', $cityXml);
                
                $node = simplexml_load_string($cityXml);
                if ($node !== false) {
                    $cityId = (string) $node['Id'];
                    $jpdCode = (string) $node['JPDCode'];
                    $name = (string) $node->Name;

                    $countryId = isset($node->Country) ? (string) $node->Country['Id'] : null;
                    $countryJpdCode = isset($node->Country) ? (string) $node->Country['JPDCode'] : null;
                    $countryName = isset($node->Country) ? (string) $node->Country->Name : null;

                    $regionId = isset($node->Region) ? (string) $node->Region['Id'] : null;
                    $regionJpdCode = isset($node->Region) ? (string) $node->Region['JPDCode'] : null;
                    $regionName = isset($node->Region) ? (string) $node->Region->Name : null;

                    $insertData[] = [
                        'city_id' => $cityId ?: null,
                        'jpd_code' => $jpdCode ?: null,
                        'name' => $name ?: null,
                        'country_id' => $countryId ?: null,
                        'country_jpd_code' => $countryJpdCode ?: null,
                        'country_name' => $countryName ?: null,
                        'region_id' => $regionId ?: null,
                        'region_jpd_code' => $regionJpdCode ?: null,
                        'region_name' => $regionName ?: null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    if (count($insertData) >= 200) {
                        \App\Models\TdsCity::insert($insertData);
                        $insertData = [];
                    }
                    $count++;
                }
                
                $reader->next(); 
            }
        }
        
        if (!empty($insertData)) {
            \App\Models\TdsCity::insert($insertData);
        }
        
        $reader->close();

        echo "TDS Cities dumped successfully. Total cities: {$count}";
    }

    
        // public function dumpTdsCities()
        // {
        //     $filePath = public_path('tdscities.xml');

        //     if (!file_exists($filePath)) {
        //         echo "File tdscities.xml not found in public folder.";
        //         return;
        //     }

        //     $reader = new \XMLReader();

        //     if (!$reader->open($filePath)) {
        //         echo "Failed to open XML file.";
        //         return;
        //     }

        //     $insertData = [];
        //     $count = 0;
        //     $insertedOrUpdated = 0;
        //     $batchSize = 200;

        //     try {
        //         while ($reader->read()) {
        //             if (
        //                 $reader->nodeType !== \XMLReader::ELEMENT ||
        //                 $reader->localName !== 'City'
        //             ) {
        //                 continue;
        //             }

        //             $cityXml = $reader->readOuterXml();

        //             if (empty($cityXml)) {
        //                 continue;
        //             }

        //             // Remove Juniper namespace prefixes for SimpleXML parsing.
        //             $cityXml = str_replace(
        //                 ['jp:', 'xmlns:jp="http://www.juniper.es/webservice/2007/"'],
        //                 '',
        //                 $cityXml
        //             );

        //             $node = simplexml_load_string($cityXml);

        //             if ($node === false) {
        //                 continue;
        //             }

        //             $cityId = trim((string) $node['Id']);

        //             // city_id is the unique identifier used for upsert.
        //             if ($cityId === '') {
        //                 continue;
        //             }

        //             $jpdCode = trim((string) $node['JPDCode']);
        //             $name = trim((string) $node->Name);

        //             $countryId = isset($node->Country)
        //                 ? trim((string) $node->Country['Id'])
        //                 : null;

        //             $countryJpdCode = isset($node->Country)
        //                 ? trim((string) $node->Country['JPDCode'])
        //                 : null;

        //             $countryName = isset($node->Country->Name)
        //                 ? trim((string) $node->Country->Name)
        //                 : null;

        //             $regionId = isset($node->Region)
        //                 ? trim((string) $node->Region['Id'])
        //                 : null;

        //             $regionJpdCode = isset($node->Region)
        //                 ? trim((string) $node->Region['JPDCode'])
        //                 : null;

        //             $regionName = isset($node->Region->Name)
        //                 ? trim((string) $node->Region->Name)
        //                 : null;

        //             $insertData[] = [
        //                 'city_id' => $cityId,
        //                 'jpd_code' => $jpdCode !== '' ? $jpdCode : null,
        //                 'name' => $name !== '' ? $name : null,
        //                 'country_id' => $countryId !== '' ? $countryId : null,
        //                 'country_jpd_code' => $countryJpdCode !== ''
        //                     ? $countryJpdCode
        //                     : null,
        //                 'country_name' => $countryName !== ''
        //                     ? $countryName
        //                     : null,
        //                 'region_id' => $regionId !== '' ? $regionId : null,
        //                 'region_jpd_code' => $regionJpdCode !== ''
        //                     ? $regionJpdCode
        //                     : null,
        //                 'region_name' => $regionName !== ''
        //                     ? $regionName
        //                     : null,
        //                 'created_at' => now(),
        //                 'updated_at' => now(),
        //             ];

        //             $count++;

        //             if (count($insertData) >= $batchSize) {
        //                 \App\Models\TdsCity::upsert(
        //                     $insertData,
        //                     ['city_id'],
        //                     [
        //                         'jpd_code',
        //                         'name',
        //                         'country_id',
        //                         'country_jpd_code',
        //                         'country_name',
        //                         'region_id',
        //                         'region_jpd_code',
        //                         'region_name',
        //                         'updated_at',
        //                     ]
        //                 );

        //                 $insertedOrUpdated += count($insertData);
        //                 $insertData = [];
        //             }
        //         }

        //         // Process the remaining records.
        //         if (!empty($insertData)) {
        //             \App\Models\TdsCity::upsert(
        //                 $insertData,
        //                 ['city_id'],
        //                 [
        //                     'jpd_code',
        //                     'name',
        //                     'country_id',
        //                     'country_jpd_code',
        //                     'country_name',
        //                     'region_id',
        //                     'region_jpd_code',
        //                     'region_name',
        //                     'updated_at',
        //                 ]
        //             );

        //             $insertedOrUpdated += count($insertData);
        //         }
        //     } finally {
        //         $reader->close();
        //     }

        //     echo "TDS Cities dump completed successfully. "
        //         . "XML city records processed: {$count}. "
        //         . "Records submitted for insert/update: {$insertedOrUpdated}.";
        // }


    public function dumpTdsZones()
    {
        $filePath = public_path('zone.xml');
        if (!file_exists($filePath)) {
            echo "File zone.xml not found in public folder.";
            return;
        }

        $reader = new \XMLReader();
        if (!$reader->open($filePath)) {
            echo "Failed to open XML file.";
            return;
        }

        $insertData = [];
        $count = 0;

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->localName === 'Zone') {
                $zoneXml = $reader->readOuterXml();
                // Remove namespace prefix if present to simplify simplexml parsing
                $zoneXml = str_replace(['jp:', 'xmlns:jp="http://www.juniper.es/webservice/2007/"'], '', $zoneXml);
                
                $node = simplexml_load_string($zoneXml);
                if ($node !== false) {
                    $insertData[] = [
                        'jpd_code' => isset($node['JPDCode']) ? (string) $node['JPDCode'] : null,
                        'parent_jpd_code' => isset($node['ParentJPDCode']) ? (string) $node['ParentJPDCode'] : null,
                        'area_type' => isset($node['AreaType']) ? (string) $node['AreaType'] : null,
                        'searchable' => isset($node['Searchable']) ? (string) $node['Searchable'] : null,
                        'code' => isset($node['Code']) ? (string) $node['Code'] : null,
                        'parent_code' => isset($node['ParentCode']) ? (string) $node['ParentCode'] : null,
                        'name' => isset($node->Name) ? (string) $node->Name : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    if (count($insertData) >= 500) {
                        \App\Models\TdsZone::insert($insertData);
                        $insertData = [];
                    }
                    $count++;
                }
                
                $reader->next(); 
            }
        }
        
        if (!empty($insertData)) {
            \App\Models\TdsZone::insert($insertData);
        }
        
        $reader->close();

        echo "TDS Zones dumped successfully. Total zones: {$count}";
    }

    public function dumpTdsHotelsList(Request $request)
    {
        header('Cache-Control: max-age=0,no-store');
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        $source = $request->input('source', 'api'); // 'api' or 'file'
        $recordsPerPage = (int) $request->input('records_per_page', 500);
        $maxPages = (int) $request->input('max_pages', 0); // 0 = unlimited / until no NextToken
        $resume = $request->boolean('resume', false);

        $outputDir = public_path('tdsHotelList');
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        // If dumping from existing local XML file
        if ($source === 'file') {
            $filePath = public_path('tdsHotelList.xml');
            if (!file_exists($filePath)) {
                return response()->json([
                    'status' => false,
                    'message' => 'File tdsHotelList.xml not found in public folder.'
                ]);
            }
            $xmlContent = file_get_contents($filePath);
            $parsedCount = $this->parseAndSaveTdsHotelsXml($xmlContent);
            return response()->json([
                'status' => true,
                'message' => "Dumped {$parsedCount} hotels from local tdsHotelList.xml file."
            ]);
        }

        $searchController = new SearchController();
        $currentToken = $request->input('next_token');
        
        if (empty($currentToken) ) {
            $latestRecord = TdsHotelList::whereNotNull('next_token')->latest('id')->first();
            if ($latestRecord) {
                $currentToken = $latestRecord->next_token;
            }
        }
        
        

        $page = 1;
        $totalHotelsSaved = 0;
        $hasMore = true;

        echo "<pre>";
        echo "Starting TDS Hotel List dump...\n";

        while ($hasMore) {
            echo "Fetching page {$page} (NextToken: " . ($currentToken ?: 'Initial Request') . ")...\n";

            $apiResponse = $searchController->tdsHotelListDatafetch($currentToken, $recordsPerPage);

            if (!$apiResponse['success']) {
                $errMsg = $apiResponse['message'] ?? 'Unknown error';
                echo "API call failed at page {$page}: {$errMsg}\n";
                Log::error("TDS HotelList dump failed: {$errMsg}", ['next_token' => $currentToken, 'page' => $page]);
                break;
            }

            $rawXml = $apiResponse['raw_xml'] ?? null;

            if ($rawXml) {
                // Save response to public/tdsHotelList.xml and archive in public/tdsHotelList/response_page_X.xml
                file_put_contents(public_path('tdsHotelList.xml'), $rawXml);
                file_put_contents($outputDir . DIRECTORY_SEPARATOR . "response_page_{$page}.xml", $rawXml);
            }

            $result = $this->processTdsHotelPortfolioXml($rawXml, $apiResponse['response'] ?? []);
            $hotelsCount = $result['count'];
            $nextToken = $result['next_token'];

            $totalHotelsSaved += $hotelsCount;
            echo "Page {$page} processed: {$hotelsCount} hotels saved. NextToken: " . ($nextToken ?: 'None') . "\n";

            if (empty($nextToken) || $nextToken === $currentToken || $hotelsCount === 0) {
                $hasMore = false;
                echo "No further pages / NextToken found. Dump complete!\n";
                break;
            }

            $currentToken = $nextToken;
            $page++;

            if ($maxPages > 0 && $page > $maxPages) {
                echo "Reached max requested pages limit ({$maxPages}). Stopping for this batch.\n";
                break;
            }

            // Short pause between requests
            usleep(200000);
        }

        echo "Total hotels saved/updated: {$totalHotelsSaved}\n";
        echo "</pre>";
    }

    /**
     * Process and parse XML or array response and save into tds_hotel_lists table
     */
    private function processTdsHotelPortfolioXml($rawXml, $responseArray = [])
    {
        $insertData = [];
        $nextToken = null;
        $count = 0;

        if (!empty($rawXml)) {
            // Clean XML namespaces for SimpleXML parsing
            $cleanXml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$3', $rawXml);
            $cleanXml = str_replace([
                'xmlns="http://www.juniper.es/webservice/2007/"',
                'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"',
                'xmlns:xsd="http://www.w3.org/2001/XMLSchema"'
            ], '', $cleanXml);

            $xmlObj = @simplexml_load_string($cleanXml);
            if ($xmlObj !== false) {
                $portfolioNode = null;
                if (isset($xmlObj->Body->HotelPortfolioResponse->HotelPortfolioRS->HotelPortfolio)) {
                    $portfolioNode = $xmlObj->Body->HotelPortfolioResponse->HotelPortfolioRS->HotelPortfolio;
                } elseif (isset($xmlObj->HotelPortfolioResponse->HotelPortfolioRS->HotelPortfolio)) {
                    $portfolioNode = $xmlObj->HotelPortfolioResponse->HotelPortfolioRS->HotelPortfolio;
                } elseif (isset($xmlObj->HotelPortfolio)) {
                    $portfolioNode = $xmlObj->HotelPortfolio;
                }

                if ($portfolioNode) {
                    $nextToken = isset($portfolioNode['NextToken']) ? (string) $portfolioNode['NextToken'] : null;

                    if (isset($portfolioNode->Hotel)) {
                        foreach ($portfolioNode->Hotel as $hotel) {
                            $jpCode = isset($hotel['JPCode']) ? (string) $hotel['JPCode'] : null;
                            $name = isset($hotel->Name) ? (string) $hotel->Name : null;
                            $cityId = isset($hotel->City['Id']) ? (string) $hotel->City['Id'] : (isset($hotel->City['id']) ? (string) $hotel->City['id'] : null);
                            $cityJpdCode = isset($hotel->City['JPDCode']) ? (string) $hotel->City['JPDCode'] : (isset($hotel->City['jpdCode']) ? (string) $hotel->City['jpdCode'] : null);

                            if ($jpCode) {
                                $insertData[] = [
                                    'hotel_jp_code' => $jpCode,
                                    'tds_city_id' => $cityId,
                                    'tds_city_jpd_code' => $cityJpdCode,
                                    'hotel_name' => $name,
                                    'is_hotel_details_dumped' => 0,
                                    'next_token' => $nextToken,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                                $count++;
                            }
                        }
                    }
                }
            }
        }

        if (!empty($insertData)) {
            foreach (array_chunk($insertData, 500) as $chunk) {
                TdsHotelList::upsert(
                    $chunk,
                    ['hotel_jp_code'],
                    ['tds_city_id', 'tds_city_jpd_code', 'hotel_name', 'next_token', 'updated_at']
                );
            }
        }

        return [
            'count' => $count,
            'next_token' => $nextToken,
        ];
    }

    /**
     * Parse local XML file and save to database
     */
    private function parseAndSaveTdsHotelsXml($xmlContent)
    {
        $result = $this->processTdsHotelPortfolioXml($xmlContent);
        return $result['count'];
    }

    public function Tester(){
        echo "ff";
    }

    public function dumpTdsHotelsDetails(Request $request)
    {
        header('Cache-Control: max-age=0,no-store');
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        $limit = (int) $request->input('limit', 400); // 500 records per call
        $chunkSize = (int) $request->input('chunk_size', 25); // 25 per set

        $searchController = new SearchController();
        $totalHotelsSaved = 0;
        $totalNotFound = 0;

        echo "<pre>";
        echo "Starting TDS Hotel Details dump (fetching {$limit} records, sending {$chunkSize} per set)...\n\n";

        // Fetch pending hotel codes from tds_hotel_lists where is_hotel_details_dumped = 0
        $hotelCodes = TdsHotelList::where('is_hotel_details_dumped', 3)
            ->whereNotNull('hotel_jp_code')
            ->orderBy('id', 'asc')
            ->limit($limit)
            ->pluck('hotel_jp_code')
            ->toArray();

        if (empty($hotelCodes)) {
            echo "All hotel details are completely dumped! No pending hotels remaining.\n";
            echo "</pre>";
            return;
        }

        $totalFetched = count($hotelCodes);
        echo "Fetched {$totalFetched} pending hotel codes from database.\n";

        // Split into chunks of 25
        $chunks = array_chunk($hotelCodes, $chunkSize);
        unset($hotelCodes);

        $totalChunks = count($chunks);

        foreach ($chunks as $index => $chunk) {
            $subBatchNum = $index + 1;
            $chunkCount = count($chunk);
            $requestedListStr = implode(', ', $chunk);

            echo "Processing set {$subBatchNum}/{$totalChunks} ({$chunkCount} hotels: [{$requestedListStr}])... \n";

            $apiResponse = $searchController->tdsHotelDetailDatafetch($chunk);

            if (!$apiResponse['success']) {
                $errMsg = $apiResponse['message'] ?? 'Unknown error';
                echo "--> FAILED: {$errMsg} for requested hotels: [{$requestedListStr}]\n\n";
                Log::error("TDS HotelDetails chunk failed: {$errMsg}", ['hotel_codes' => $chunk]);
                unset($apiResponse);
                continue;
            }

            $rawXml = $apiResponse['raw_xml'] ?? null;
            unset($apiResponse);

            if ($rawXml) {
                $result = $this->processTdsHotelDetailsXml($rawXml);
                unset($rawXml);

                $savedCount = $result['count'];
                $processedCodes = !empty($result['processed_codes']) ? $result['processed_codes'] : [];
                $warningCodes = !empty($result['warning_codes']) ? $result['warning_codes'] : [];

                // Any requested code not in processedCodes is marked as not found (2)
                $notFoundCodes = array_values(array_unique(array_merge(
                    $warningCodes,
                    array_diff($chunk, $processedCodes)
                )));

                // Update is_hotel_details_dumped = 1 for successfully saved hotels
                if (!empty($processedCodes)) {
                    TdsHotelList::whereIn('hotel_jp_code', $processedCodes)->update(['is_hotel_details_dumped' => 1]);
                }

                // Update is_hotel_details_dumped = 4  for not found / warning hotels
                if (!empty($notFoundCodes)) {
                    TdsHotelList::whereIn('hotel_jp_code', $notFoundCodes)->update(['is_hotel_details_dumped' => 4]);
                    $totalNotFound += count($notFoundCodes);
                }

                $savedListStr = !empty($processedCodes) ? implode(', ', $processedCodes) : 'None';
                $notFoundListStr = !empty($notFoundCodes) ? implode(', ', $notFoundCodes) : 'None';

                $totalHotelsSaved += $savedCount;
                echo "--> SUCCESS: {$savedCount} hotels saved: [{$savedListStr}].\n";
                if (!empty($notFoundCodes)) {
                    echo "--> NOT FOUND: " . count($notFoundCodes) . " hotels marked as 2: [{$notFoundListStr}].\n";
                }
                echo "(Total saved so far: {$totalHotelsSaved})\n\n";
                //dd($rawXml);

                unset($result, $processedCodes, $notFoundCodes, $warningCodes);
            } else {
                echo "--> FAILED: Empty XML response for requested hotels: [{$requestedListStr}]\n\n";
            }

            gc_collect_cycles();
            usleep(100000); // 100ms pause
        }

        unset($chunks);
        gc_collect_cycles();

        echo "\n============================================\n";
        echo "Finished call!\n";
        echo "Total hotel details saved/updated: {$totalHotelsSaved}\n";
        echo "Total not-found hotels marked as 2: {$totalNotFound}\n";
        echo "============================================\n";
        echo "</pre>";
    }

    /**
     * Process and parse HotelContent XML using streaming XMLReader and save into tds_hotels table
     */
    private function processTdsHotelDetailsXml($rawXml)
    {
        $insertData = [];
        $processedCodes = [];
        $warningCodes = [];
        $count = 0;

        if (empty($rawXml)) {
            return ['count' => 0, 'processed_codes' => [], 'warning_codes' => []];
        }

        $reader = new \XMLReader();
        $reader->XML($rawXml, 'UTF-8', LIBXML_NONET | LIBXML_COMPACT);

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->localName === 'Warning') {
                $warningXml = $reader->readOuterXml();
                $warningNode = @simplexml_load_string($warningXml);
                if ($warningNode !== false && isset($warningNode['Text'])) {
                    $text = (string) $warningNode['Text'];
                    if (preg_match('/Hotel\s+([^\s]+)\s+not found/i', $text, $matches)) {
                        $warningCodes[] = $matches[1];
                    }
                }
                $reader->next();
                continue;
            }

            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->localName === 'HotelContent') {
                $hotelXml = $reader->readOuterXml();
                // Clean namespace prefixes
                $hotelXml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$3', $hotelXml);
                $hotelXml = str_replace([
                    'xmlns="http://www.juniper.es/webservice/2007/"',
                    'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"',
                    'xmlns:xsd="http://www.w3.org/2001/XMLSchema"'
                ], '', $hotelXml);

                $hotelContent = @simplexml_load_string($hotelXml);
                if ($hotelContent !== false) {
                    $hotelCode = isset($hotelContent['Code']) ? (string) $hotelContent['Code'] : null;
                    $hotelJpCode = isset($hotelContent['JPCode']) ? (string) $hotelContent['JPCode'] : $hotelCode;
                    $name = isset($hotelContent->HotelName) ? (string) $hotelContent->HotelName : null;

                    // Star rating
                    $starRating = null;
                    if (isset($hotelContent->HotelCategory)) {
                        $starRating = (string) $hotelContent->HotelCategory;
                        if (empty($starRating) && isset($hotelContent->HotelCategory['Type'])) {
                            $starRating = (string) $hotelContent->HotelCategory['Type'];
                        }
                    }

                    // Address details
                    $address = null;
                    $postalCode = null;
                    $latitude = null;
                    $longitude = null;
                    if (isset($hotelContent->Address)) {
                        $address = isset($hotelContent->Address->Address) ? (string) $hotelContent->Address->Address : null;
                        $postalCode = isset($hotelContent->Address->PostalCode) ? (string) $hotelContent->Address->PostalCode : null;
                        $latitude = isset($hotelContent->Address->Latitude) ? (string) $hotelContent->Address->Latitude : null;
                        $longitude = isset($hotelContent->Address->Longitude) ? (string) $hotelContent->Address->Longitude : null;
                    }

                    // CheckIn / CheckOut times
                    $checkIn = null;
                    $checkOut = null;
                    if (isset($hotelContent->TimeInformation->CheckTime)) {
                        $checkIn = isset($hotelContent->TimeInformation->CheckTime['CheckIn']) ? (string) $hotelContent->TimeInformation->CheckTime['CheckIn'] : null;
                        $checkOut = isset($hotelContent->TimeInformation->CheckTime['CheckOut']) ? (string) $hotelContent->TimeInformation->CheckTime['CheckOut'] : null;
                    }

                      // Telephone
                    $telephone = null;
                    if (isset($hotelContent->ContactInfo->PhoneNumbers->PhoneNumber)) {
                        $telephone = (string) $hotelContent->ContactInfo->PhoneNumbers->PhoneNumber;
                    }
                    

                    // First Thumbnail Image
                    $thumbnail = null;
                    if (isset($hotelContent->Images->Image)) {
                        foreach ($hotelContent->Images->Image as $img) {
                            if (isset($img['Type']) && strtoupper((string) $img['Type']) === 'THB' && isset($img->FileName)) {
                                $thumbnail = (string) $img->FileName;
                                break;
                            }
                        }
                        if (empty($thumbnail) && isset($hotelContent->Images->Image[0]->FileName)) {
                            $thumbnail = (string) $hotelContent->Images->Image[0]->FileName;
                        }
                    }

                    // Hierarchy: city_jpd_code, region_jpd_code, country_jpd_code
                    $cityJpdCode = null;
                    $regionJpdCode = null;
                    $countryJpdCode = null;

                    if (isset($hotelContent->Zone->Hierarchy->Zone)) {
                        $hierarchyZones = [];
                        foreach ($hotelContent->Zone->Hierarchy->Zone as $hZone) {
                            $hierarchyZones[] = (string) $hZone['JPDCode'];
                        }

                        $countZones = count($hierarchyZones);
                        if ($countZones >= 3) {
                            $cityJpdCode = $hierarchyZones[0];
                            $regionJpdCode = $hierarchyZones[1];
                            $countryJpdCode = $hierarchyZones[$countZones - 1];
                        } elseif ($countZones === 2) {
                            $cityJpdCode = $hierarchyZones[0];
                            $countryJpdCode = $hierarchyZones[1];
                        } elseif ($countZones === 1) {
                            $countryJpdCode = $hierarchyZones[0];
                        }
                    }

                    if (empty($cityJpdCode) && isset($hotelContent->Zone['ParentJPDCode'])) {
                        $cityJpdCode = (string) $hotelContent->Zone['ParentJPDCode'];
                    }
                    if (empty($cityJpdCode) && isset($hotelContent->Zone['JPDCode'])) {
                        $cityJpdCode = (string) $hotelContent->Zone['JPDCode'];
                    }

                    if ($hotelJpCode) {
                        $insertData[] = [
                            'hotel_code' => $hotelCode,
                            'hotel_jp_code' => $hotelJpCode,
                            'name' => $name,
                            'star_rating' => $starRating,
                            'address' => $address,
                            'latitude' => $latitude ? (float) $latitude : null,
                            'longitude' => $longitude ? (float) $longitude : null,
                            'postal_code' => $postalCode,
                            'check_in' => $checkIn,
                            'check_out' => $checkOut,
                            'telephone' => $telephone,
                            'thumbnail' => $thumbnail,
                            'city_jpd_code' => $cityJpdCode,
                            'region_jpd_code' => $regionJpdCode,
                            'country_jpd_code' => $countryJpdCode,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $processedCodes[] = $hotelJpCode;
                        $count++;
                    }
                }
                unset($hotelContent, $hotelXml);
                $reader->next();
            }
        }
        $reader->close();
        unset($reader);

        if (!empty($insertData)) {
            foreach (array_chunk($insertData, 100) as $chunk) {
                TdsHotel::upsert(
                    $chunk,
                    ['hotel_jp_code'],
                    [
                        'hotel_code',
                        'name',
                        'star_rating',
                        'address',
                        'latitude',
                        'longitude',
                        'postal_code',
                        'check_in',
                        'check_out',
                        'telephone',
                        'thumbnail',
                        'city_jpd_code',
                        'region_jpd_code',
                        'country_jpd_code',
                        'updated_at'
                    ]
                );
            }
        }

        unset($insertData);

        return [
            'count' => $count,
            'processed_codes' => $processedCodes,
            'warning_codes' => $warningCodes,
        ];
    }

    /**
     * Parse local hotel details XML file and save to database
     */
    private function parseAndSaveTdsHotelDetailsXml($xmlContent)
    {
        $result = $this->processTdsHotelDetailsXml($xmlContent);
        if (!empty($result['processed_codes'])) {
            TdsHotelList::whereIn('hotel_jp_code', $result['processed_codes'])->update(['is_hotel_details_dumped' => 1]);
        }
        return $result['count'];
    }


    public function UpdatingAgentRoles(){

        $MasterAgent = 9;
        $TravelAgent = 7;

        $users = User::whereNotNull('agency_id')->get();
        //dd($users);
        foreach ($users as $key => $user) {
            
                if($user->is_master_agent == 1){
                    $user->assignRole($MasterAgent);
                }else{
                    $user->assignRole($TravelAgent);
                }
        }
    }

    public function updatinghotelCitysWithGts(Request $request = null)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        if ($request === null) {
            $request = request();
        }

        $batchSize = 2000;
        $maxLimit = $request->has('limit') ? (int) $request->input('limit') : null;
        $sourceStatus = $request->has('status') ? (int) $request->input('status') : 0;

        $totalGtsProcessed = 0;
        $totalHotelUpdated = 0;
        $totalHotelAdded = 0;
        $totalMigrated = 0;       // status 2
        $totalUnconnected = 0;    // status 3
        $totalNotFound = 0;
        $totalMultipleUnresolved = 0;
        $totalMultipleResolved = 0;
        $totalMultipleAddedAsNew = 0;
        $totalSingleMatched = 0;

        while (true) {
            $currentLimit = $maxLimit ? min($batchSize, $maxLimit - $totalGtsProcessed) : $batchSize;
            if ($currentLimit <= 0) {
                break;
            }

            // Fetch GTS cities (default is_migrated = 0)
            $gtsCities = GtsCity::where('is_migrated', $sourceStatus)
                ->orderBy('id', 'ASC')
                ->limit($currentLimit)
                ->get();

            if ($gtsCities->isEmpty()) {
                break;
            }

            $pickedIds = $gtsCities->pluck('id')->toArray();

            // Status 1: Mark picked GTS cities as "in processing"
            \DB::table('gts_cities')->whereIn('id', $pickedIds)->update([
                'is_migrated' => 1,
                'updated_at'  => now(),
            ]);

            // Extract unique city names
            $names = $gtsCities->pluck('name')->map(function ($name) {
                return trim($name);
            })->filter()->unique()->values()->toArray();

            // Fetch hotel cities matching these names
            $hotelCities = [];
            foreach (array_chunk($names, 1000) as $chunkNames) {
                $found = HotelCity::whereIn('name', $chunkNames)->get();
                foreach ($found as $hc) {
                    $hotelCities[] = $hc;
                }
            }

            // Group hotel cities by lowercase trimmed name
            $groupedHotelCities = [];
            foreach ($hotelCities as $hc) {
                $n = strtolower(trim($hc->name));
                $groupedHotelCities[$n][] = $hc;
            }

            $hotelUpdates = [];
            $newHotelCities = [];
            $addedNewKeys = [];
            $migratedGtsIds = [];
            $unconnectedGtsIds = [];

            foreach ($gtsCities as $gtsCity) {
                $gtsName = strtolower(trim($gtsCity->name));
                $candidates = $groupedHotelCities[$gtsName] ?? [];

                $matchedHc = null;

                if (empty($candidates)) {
                    // Not found in hotel cities -> status 3 (picked and not connected)
                    $totalNotFound++;
                    $unconnectedGtsIds[] = $gtsCity->id;
                } elseif (count($candidates) === 1) {
                    // Exactly one match by name
                    $matchedHc = $candidates[0];
                    $totalSingleMatched++;
                } else {
                    // Multiple matches found by name -> check with country
                    $gcCountryCode = strtoupper(trim($gtsCity->country_code ?? ''));
                    $gcCountryName = strtolower(trim($gtsCity->country_name ?? ''));

                    $countryMatches = [];
                    foreach ($candidates as $candidate) {
                        $hcCountryCode = strtoupper(trim($candidate->country_code ?? ''));
                        $hcCountryName = strtolower(trim($candidate->country_name ?? ''));
                        $hcLongName    = strtolower(trim($candidate->long_name ?? ''));

                        $isCountryMatch = false;

                        if (!empty($gcCountryCode) && !empty($hcCountryCode) && $gcCountryCode === $hcCountryCode) {
                            $isCountryMatch = true;
                        } elseif (!empty($gcCountryName) && !empty($hcCountryName) && $gcCountryName === $hcCountryName) {
                            $isCountryMatch = true;
                        } elseif (!empty($gcCountryName) && !empty($hcLongName) && strpos($hcLongName, $gcCountryName) !== false) {
                            $isCountryMatch = true;
                        }

                        if ($isCountryMatch) {
                            $countryMatches[] = $candidate;
                        }
                    }

                    if (count($countryMatches) === 1) {
                        // Exactly one matched after country check
                        $matchedHc = $countryMatches[0];
                        $totalMultipleResolved++;
                    } elseif (empty($countryMatches)) {
                        // Country does not exist among candidates -> add as a new record in hotel_cities
                        $addedKey = $gtsName . '_' . $gcCountryCode;
                        if (!isset($addedNewKeys[$addedKey])) {
                            $newHotelCities[] = [
                                'name'         => $gtsCity->name,
                                'long_name'    => $gtsCity->full_name,
                                'country_code' => $gtsCity->country_code,
                                'country_name' => $gtsCity->country_name,
                                'is_gts'       => 1,
                                'gts_code'     => $gtsCity->gts_city_id,
                                'created_at'   => now(),
                                'updated_at'   => now(),
                            ];
                            $addedNewKeys[$addedKey] = true;
                            $migratedGtsIds[] = $gtsCity->id;
                            $totalMultipleAddedAsNew++;
                        } else {
                            $totalMultipleUnresolved++;
                            $unconnectedGtsIds[] = $gtsCity->id;
                        }
                    } else {
                        // Multiple matches still found after country check -> status 3 (not connected)
                        $totalMultipleUnresolved++;
                        $unconnectedGtsIds[] = $gtsCity->id;
                    }
                }

                if ($matchedHc) {
                    // Successfully connected to hotel_city -> status 2 (migrated)
                    if (!isset($hotelUpdates[$matchedHc->id])) {
                        $hotelUpdates[$matchedHc->id] = $gtsCity->gts_city_id;
                    }
                    $migratedGtsIds[] = $gtsCity->id;
                }
            }

            // Perform batch database updates inside transaction
            \DB::beginTransaction();
            try {
                // Insert newly added hotel_cities records
                if (!empty($newHotelCities)) {
                    \DB::table('hotel_cities')->insert($newHotelCities);
                    $totalHotelAdded += count($newHotelCities);
                }

                // Update existing hotel_cities with gts_code and is_gts = 1
                foreach ($hotelUpdates as $hcId => $gtsCityId) {
                    \DB::table('hotel_cities')->where('id', $hcId)->update([
                        'gts_code'   => $gtsCityId,
                        'is_gts'     => 1,
                        'updated_at' => now(),
                    ]);
                    $totalHotelUpdated++;
                }

                // Status 2: Successfully migrated / connected
                if (!empty($migratedGtsIds)) {
                    \DB::table('gts_cities')->whereIn('id', $migratedGtsIds)->update([
                        'is_migrated' => 2,
                        'updated_at'  => now(),
                    ]);
                    $totalMigrated += count($migratedGtsIds);
                }

                // Status 3: Picked but not connected to any hotel city
                if (!empty($unconnectedGtsIds)) {
                    \DB::table('gts_cities')->whereIn('id', $unconnectedGtsIds)->update([
                        'is_migrated' => 3,
                        'updated_at'  => now(),
                    ]);
                    $totalUnconnected += count($unconnectedGtsIds);
                }

                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }

            $totalGtsProcessed += count($pickedIds);
        }

        $pendingCount     = GtsCity::where('is_migrated', 0)->count();
        $processingCount  = GtsCity::where('is_migrated', 1)->count();
        $migratedCount    = GtsCity::where('is_migrated', 2)->count();
        $unconnectedCount = GtsCity::where('is_migrated', 3)->count();

        return response()->json([
            'status' => true,
            'message' => 'GTS cities processed and hotel cities updated successfully.',
            'batch_gts_processed' => $totalGtsProcessed,
            'migrated_connected_status_2' => $totalMigrated,
            'unconnected_status_3' => $totalUnconnected,
            'total_hotel_cities_updated' => $totalHotelUpdated,
            'total_hotel_cities_added' => $totalHotelAdded,
            'single_matched_by_name' => $totalSingleMatched,
            'multiple_resolved_by_country' => $totalMultipleResolved,
            'multiple_added_as_new_in_hotel_cities' => $totalMultipleAddedAsNew,
            'multiple_unresolved_by_country' => $totalMultipleUnresolved,
            'not_found_in_hotel_cities' => $totalNotFound,
            'summary' => [
                'pending_status_0'    => $pendingCount,
                'processing_status_1' => $processingCount,
                'migrated_status_2'   => $migratedCount,
                'unconnected_status_3'=> $unconnectedCount,
            ],
        ]);
    }
}