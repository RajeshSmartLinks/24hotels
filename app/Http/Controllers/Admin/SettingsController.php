<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppAds;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $titles = ['title' => "Settings", 'subTitle' => "settings", 'listTitle' => "Settings Listing"];
        if (!auth()->user()->can('settings-view')) {
            return view('admin.abort', compact('titles'));
        }
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));
  
        $settings = Setting::get();
    

        return view('admin.setting.index', compact('titles' , 'settings' ,'noImage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
        $titles = [
            'title' => "SEO",
            'subTitle' => "Add SEO",
        ];
        if (!auth()->user()->can('seo-add')) {
            return view('admin.abort', compact('titles'));
        }

        // if (!auth()->user()->can('supplier-add')) {
        //     return view('admin.abort', compact('titles'));
        // }
        $packages = Package::orderBy('id','desc')->get();
        $offers = Offer::orderBy('id','desc')->get();
        $popularEvents = PopularEventNews::orderBy('id','desc')->get();
        
        return view('admin.seo.create', compact('titles', 'packages' , 'offers' ,'popularEvents'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('package-add')) {
            return view('admin.abort');
        }
        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort');
        // }


        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'page_type' => 'required',
            'static_page_name' => 'required_if:page_type,static',
            'dynamic_page_type' => 'required_if:page_type,dynamic',
            'offers_dynamic_page_id' => 'required_if:dynamic_page_type,offers',
            'packages_dynamic_page_id' => 'required_if:dynamic_page_type,packages',
            'status' => 'required',
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['page_type'] = $request->page_type;
        if($request->page_type == 'static'){
            $data['static_page_name'] = $request->static_page_name; 
        }else{
            $data['dynamic_page_type'] = $request->dynamic_page_type;
            if($request->dynamic_page_type == 'offers'){
                $data['dynamic_page_id'] = $request->offers_dynamic_page_id;
            }else{
                $data['dynamic_page_id'] = $request->packages_dynamic_page_id;
            }
        }
        $data['status'] = $request->status;

        SeoSettings::create($data);
        return redirect()->route('seo.index')->with('success','created Successfully');
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
        if (!auth()->user()->can('seo-edit')) {
            return view('admin.abort');
        }
        $titles = ['title' => 'Manage Settings', 'subTitle' => 'Edit settings'];

        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $setting = Setting::find($id);

        return view('admin.setting.edit', compact('titles', 'setting'));
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
        if (!auth()->user()->can('settings-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'site_name' => 'required',
            'pop_up_image' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'pop_up_title' => 'required',
        ]);
        $setting = Setting::find($id);
        $originalImage = $request->file('pop_up_image');

        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
    

            $originalPath = AppAds::$imagePath;

            // Delete the previous image
            deleteImage(AppAds::$imagePath, $setting->image);

                   
            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                $settingsImagePopupPath = env('SVG_IMAGE_UPLOAD_PATH' , public_path()).$originalPath;
                $originalImage->move($settingsImagePopupPath, $newFileName);
            }
            else{
                // Image Upload Process
                $thumbnailImage = Image::make($originalImage);
                $thumbnailImage->save($originalPath . $newFileName);
               
            }
            $setting->pop_up_image = $newFileName;
        }

 

        $setting->site_name = $request->site_name;
        $setting->pop_up_title = $request->pop_up_title;
     
        $setting->save();

        return redirect()->route('setting.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('seo-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $seo = SeoSettings::find($deleteId);

        if ($deleteId) {

            $seo->delete();

            return redirect()->route('seo.index')->with('success', 'Deleted Successfully');

        }
    }
}
