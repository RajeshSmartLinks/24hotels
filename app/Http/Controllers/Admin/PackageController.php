<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class PackageController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $titles = ['title' => "Packages", 'subTitle' => "packages", 'listTitle' => "Packages Listing"];
        if (!auth()->user()->can('package-view')) {
            return view('admin.abort', compact('titles'));
        }
        $deleteRouteName = "packages.destroy";

        // if (!auth()->user()->can('brand-view')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $packages = Package::orderBy('id','desc')->get();

        return view('admin.packages.index', compact('titles', 'packages', 'deleteRouteName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
        $titles = [
            'title' => "Package",
            'subTitle' => "Add Package",
        ];
        if (!auth()->user()->can('package-add')) {
            return view('admin.abort', compact('titles'));
        }

        // if (!auth()->user()->can('supplier-add')) {
        //     return view('admin.abort', compact('titles'));
        // }

        return view('admin.packages.create', compact('titles'));
        
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
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image' => 'image|required|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'status' => 'required'
            
        ]);
        $data = array();
        $originalImage = $request->file('image');

        // if ($originalImage != NULL) {
        //     $newFileName = time() . $originalImage->getClientOriginalName();
        //     $thumbnailPath = Package::$imageThumbPath;
        //     $originalPath = Package::$imagePath;

        //     // Image Upload Process
        //     $thumbnailImage = Image::make($originalImage);

        //     $thumbnailImage->save($originalPath . $newFileName);
        //     //$thumbnailImage->resize(150, 150);
        //     $thumbnailImage->resize(150, null, function ($constraint) {
        //         $constraint->aspectRatio();
        //         })->save($thumbnailPath . $newFileName);
        //     //$thumbnailImage->save($thumbnailPath . $newFileName);

        //     $data['image'] = $newFileName;
        // }
        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
            //$newFileName = time() . $originalImage->getClientOriginalName();

            $thumbnailPath = Package::$imageThumbPath;
            $originalPath = Package::$imagePath;

            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                //$newFileName = time().'.'.$originalImage->getClientOriginalName();
                $destinationPath = env('SVG_IMAGE_UPLOAD_PATH' , public_path()).$originalPath;
                $originalImage->move($destinationPath, $newFileName);
            }
            else{
                // Image Upload Process
                $thumbnailImage = Image::make($originalImage);
                $thumbnailImage->save($originalPath . $newFileName);
                $thumbnailImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($thumbnailPath . $newFileName);
            }

            $data['image'] = $newFileName;
        }

        $data['slug'] = unique_slug($request->name_en, 'Package');
        $data['name_en'] = $request->name_en;
        $data['name_ar'] = $request->name_ar;
        $data['description_en'] = $request->description_en;
        $data['description_ar'] = $request->description_ar;
        $data['status'] = $request->status;
        $data['whatsapp_number'] = $request->whatsapp_number;

        Package::create($data);
        return redirect()->route('packages.index')->with('success','created Successfully');
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
        if (!auth()->user()->can('package-edit')) {
            return view('admin.abort');
        }
        $titles = ['title' => 'Manage Packages', 'subTitle' => 'edit Package'];

        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $editPackage = Package::find($id);

        return view('admin.packages.edit', compact('titles', 'editPackage'));
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
        if (!auth()->user()->can('package-edit')) {
            return view('admin.abort');
        }
        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort');
        // }

        $this->validate($request, [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'status' => 'required'
        ]);
        $package = Package::find($id);
        $originalImage = $request->file('image');

        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
            //$newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = Package::$imageThumbPath;
            $originalPath = Package::$imagePath;

            // Delete the previous image
            deleteImage(Package::$imagePath, $package->image);
            deleteImage(Package::$imageThumbPath, $package->image);

            // Image Upload Process
            $thumbnailImage = Image::make($originalImage);
                   
            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                //$newFileName = time().'.'.$originalImage->getClientOriginalName();
                $destinationPath = env('SVG_IMAGE_UPLOAD_PATH' , public_path()).$originalPath;
                $originalImage->move($destinationPath, $newFileName);
            }
            else{
                // Image Upload Process
                $thumbnailImage = Image::make($originalImage);
                $thumbnailImage->save($originalPath . $newFileName);
                $thumbnailImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($thumbnailPath . $newFileName);
            }
            $package->image = $newFileName;
        }
        $package->slug = unique_slug($request->name_en, 'Package' , $package->id);

        $package->name_en = $request->name_en;
        $package->name_ar = $request->name_ar;
        $package->description_en = $request->description_en;
        $package->description_ar = $request->description_ar;
        $package->status = $request->status;
        $package->whatsapp_number = $request->whatsapp_number;

     
        $package->save();

        return redirect()->route('packages.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('package-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $package = Package::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            deleteImage(Package::$imagePath, $package->image);
            deleteImage(Package::$imageThumbPath, $package->image);

            $package->delete();

            return redirect()->route('packages.index')->with('success', 'Deleted Successfully');

        }
    }
}
