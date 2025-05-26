<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppAds;
use App\Models\AppVersion;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AppController extends Controller
{
    public function index()
    {
        $titles = [
            'title' => 'App Settings',
            'subTitle' => 'App Settings List',
        ];
        if (!auth()->user()->can('app-view')) {
            return view('admin.abort',compact('titles'));
        }
        

        $appDetails = AppVersion::find(1);

        $appAds = AppAds::orderBy('id','desc')->get();

        return view('admin.app.index', compact('titles', 'appDetails' , 'appAds'));
    }

    public function edit($id)
    {
        $titles = [
            'title' => 'App Versions',
            'subTitle' => 'App vesions Edit',
        ];
        if (!auth()->user()->can('app-edit')) {
            return view('admin.abort',compact('titles'));
        }
        $appDetails = AppVersion::find(1);

        return view('admin.app.edit', compact('titles', 'appDetails'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('app-edit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'android'=>'required',
            'ios'=>'required'
        ]);

        $data = array();

        $appVersion = AppVersion::find($id);

        $appVersion->android = $request->android;
        $appVersion->ios = $request->ios;
        $appVersion->save();

        return redirect()->route('app.index')->with('success', 'Updated Successfully');
    }

    public function create()
    {
        $titles = [
            'title' => 'Create Ads',
            'subTitle' => 'Create Ads',
        ];
        if (!auth()->user()->can('app-ads-add')) {
            return view('admin.abort',compact('titles'));
        }

        return view('admin.app.ads.create', compact('titles'));

    }

    public function storeAds(Request $request)
    {
        if (!auth()->user()->can('app-ads-add')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'image' => 'image|required|mimes:jpeg,png,jpg',
            'sort_order' => 'required|numeric',
            'status' => 'required'
        ]);
        $data = array();
        $originalImage = $request->file('image');

        if ($originalImage != NULL) {
            $newFileName = time() . $originalImage->getClientOriginalName();
            $originalPath = AppAds::$imagePath;

            // Image Upload Process
            $thumbnailImage = Image::make($originalImage);

            $thumbnailImage->save($originalPath . $newFileName);
            
            $data['image'] = $newFileName;
        }

        $data['link'] = $request->link;
        $data['sort_order'] = $request->sort_order;
        $data['status'] = $request->status;
        
        AppAds::create($data);
        return redirect()->route('app.index')->with('success','created Successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAds($id)
    {
        $titles = ['title' => 'Manage App Ads', 'subTitle' => 'edit Ads'];

        if (!auth()->user()->can('app-ads-edit')) {
            return view('admin.abort', compact('titles'));
        }

        $editAds = AppAds::find($id);

        return view('admin.app.ads.edit', compact('titles', 'editAds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAds(Request $request, $id)
    {
        if (!auth()->user()->can('app-ads-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'sort_order' => 'required|numeric',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);
        $appAd = AppAds::find($id);
        $originalImage = $request->file('image');

        if ($originalImage != NULL) {
            $newFileName = time() . $originalImage->getClientOriginalName();
        
            $originalPath = AppAds::$imagePath;

            // Delete the previous image
            deleteImage(AppAds::$imagePath, $appAd->image);
          

            // Image Upload Process
            $thumbnailImage = Image::make($originalImage);

            $thumbnailImage->save($originalPath . $newFileName);
            

            $appAd->image = $newFileName;
        }

        $appAd->link = $request->link;
        $appAd->status = $request->status;
        $appAd->sort_order = $request->sort_order;
     
        $appAd->save();

        return redirect()->route('app.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('app-ads-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $AppAd = AppAds::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            deleteImage(AppAds::$imagePath, $AppAd->image);
          

            $AppAd->delete();

            return redirect()->route('app.index')->with('success', 'Deleted Successfully');

        }
    }
   
    
}
