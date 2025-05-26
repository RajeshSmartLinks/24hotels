<?php

namespace App\Http\Controllers\FrontEnd\Hotel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TboHotel;
use App\Models\TboHotelsCity;
use App\Models\TboHotelsCode;
use App\Models\TboHotelsCountry;

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
                dd($country);
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
                        dd($hotelsCodes);
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
}
