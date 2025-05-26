<?php

namespace App\Http\Controllers\Admin;

use App\Models\Popup;
use App\Models\AppAds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PopUpController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $titles = ['title' => "PopUp", 'subTitle' => "PopUp", 'listTitle' => "PopUp Listing"];
        if (!auth()->user()->can('popup-view')) {
            return view('admin.abort', compact('titles'));
        }
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));
  
        $popups = Popup::get();
    

        return view('admin.popup.index', compact('titles' , 'popups' ,'noImage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
        $titles = ['title' => 'Manage Popup', 'subTitle' => 'Edit Popup'];

        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $popup = popup::find($id);

        return view('admin.popup.edit', compact('titles', 'popup'));
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
        if (!auth()->user()->can('popup-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'pop_up_image' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'pop_up_status' => 'required',
        ]);
        $popup = popup::find($id);
        $originalImage = $request->file('pop_up_image');

        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
    

            $originalPath = AppAds::$imagePath;

            // Delete the previous image
            deleteImage(AppAds::$imagePath, $popup->image);

                   
            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                $popupsImagePopupPath = env('SVG_IMAGE_UPLOAD_PATH' , public_path()).$originalPath;
                $originalImage->move($popupsImagePopupPath, $newFileName);
            }
            else{
                // Image Upload Process
                $thumbnailImage = Image::make($originalImage);
                $thumbnailImage->save($originalPath . $newFileName);
               
            }
            $popup->pop_up_image = $newFileName;
        }
        $popup->pop_up_status = $request->pop_up_status;
     
        $popup->save();

        return redirect()->route('popup.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        
    }
}
