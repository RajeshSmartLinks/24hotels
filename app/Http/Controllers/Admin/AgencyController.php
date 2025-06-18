<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agency;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $titles = ['title' => "Agency", 'subTitle' => "Agency", 'listTitle' => "Agency Listing"];
        if (!auth()->user()->can('package-view')) {
            return view('admin.abort', compact('titles'));
        }
        $deleteRouteName = "agency.destroy";
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        // if (!auth()->user()->can('brand-view')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $agencies = Agency::with('country')->orderBy('id','desc')->get();

        return view('admin.agency.index', compact('titles', 'agencies', 'deleteRouteName' ,'noImage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
        $titles = [
            'title' => "Agency",
            'subTitle' => "Add Agency",
        ];
        if (!auth()->user()->can('agency-add')) {
            return view('admin.abort', compact('titles'));
        }

        $countries = Country::orderBy('id','desc')->get();

        return view('admin.agency.create', compact('titles','countries'));
        
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
            'name' => 'required',
            'address' => 'required',
            'logo' => 'image|required|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'status' => 'required',
            'phone_number' => 'required',
            'country_id' => 'required'
        ]);
        $data = array();
        $originalImage = $request->file('logo');

 
        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
            $thumbnailPath = Agency::$imageThumbPath;
            $originalPath = Agency::$imagePath;

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

            $data['logo'] = $newFileName;
        }

        $data['country_id'] = $request->country_id;
        $data['phone_number'] = $request->phone_number;
        $data['address'] = $request->address;
        $data['name'] = $request->name;
        $data['status'] = $request->status;
    
        Agency::create($data);
        return redirect()->route('agency.index')->with('success','created Successfully');
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
        if (!auth()->user()->can('agency-edit')) {
            return view('admin.abort');
        }
        $titles = ['title' => 'Manage Agency', 'subTitle' => 'edit Agency'];

        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $editAgency = Agency::find($id);
        $countries = Country::orderBy('id','desc')->get();

        return view('admin.agency.edit', compact('titles', 'editAgency','countries'));
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
            'name' => 'required',
            'address' => 'required',
            'logo' => 'image|required|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'status' => 'required',
            'phone_number' => 'required',
            'country_id' => 'required'
        ]);
        $agency = Agency::find($id);
        $originalImage = $request->file('logo');

        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
            //$newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = Agency::$imageThumbPath;
            $originalPath = Agency::$imagePath;

            // Delete the previous image
            deleteImage(Agency::$imagePath, $agency->image);
            deleteImage(Agency::$imageThumbPath, $agency->image);

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
            $agency->logo = $newFileName;
        }

        $agency->name = $request->name;
        $agency->country_id = $request->country_id;
        $agency->phone_number = $request->phone_number;
        $agency->address = $request->address;
        $agency->status = $request->status;
        $agency->save();

        return redirect()->route('agency.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('agency-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $agency = Agency::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            deleteImage(Agency::$imagePath, $agency->image);
            deleteImage(Agency::$imageThumbPath, $agency->image);

            $agency->delete();

            return redirect()->route('agencys.index')->with('success', 'Deleted Successfully');

        }
    }
}
