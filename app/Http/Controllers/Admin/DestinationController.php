<?php

namespace App\Http\Controllers\Admin;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => "Destinations", 'subTitle' => "Destinations", 'listTitle' => "Destinations Listing"];
        $deleteRouteName = "destinations.destroy";

        if (!auth()->user()->can('destination-view')) {
            return view('admin.abort', compact('titles'));
        }

        $destinations = Destination::orderBy('order','desc')->get();
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        return view('admin.destination.index', compact('titles', 'destinations', 'deleteRouteName' ,'noImage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $titles = [
            'title' => "Destinations",
            'subTitle' => "Add Destination",
        ];

        if (!auth()->user()->can('destination-add')) {
            return view('admin.abort', compact('titles'));
        }

        return view('admin.destination.create', compact('titles'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('destination-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'name_en' => 'required',
            'name_ar' => 'required',
            'image' => 'image|required|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'order' => 'required|numeric',
            'description_en' => 'required',
            'description_ar' => 'required',
            'meta_tag_keywords' => 'required',
            'meta_tag_description' => 'required',
            'status' => 'required'
        ]);
        $data = array();
        $originalImage = $request->file('image');

     
        if ($originalImage != NULL) {
            //$newFileName = time() . $originalImage->getClientOriginalName();
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());

            $originalPath = Destination::$imagePath;

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
            }
            $data['image'] = $newFileName;
        }

        $data['slug'] = unique_slug($request->name_en, 'Destination');
        $data['name_en'] = $request->name_en;
        $data['name_ar'] = $request->name_ar;
        $data['order'] = $request->order;
        $data['status'] = $request->status;
        $data['description_en'] = $request->description_en;
        $data['description_ar'] = $request->description_ar;
        $data['meta_tag_keywords'] = $request->meta_tag_keywords;
        $data['meta_tag_description'] = $request->meta_tag_description;

        
        Destination::create($data);
        return redirect()->route('destinations.index')->with('success','created Successfully');
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
        $titles = ['title' => 'Manage Destinations', 'subTitle' => 'edit Destinations'];

        if (!auth()->user()->can('destination-edit')) {
            return view('admin.abort', compact('titles'));
        }

        $editDestination = Destination::find($id);

        return view('admin.destination.edit', compact('titles', 'editDestination'));
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
        if (!auth()->user()->can('destination-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'name_en' => 'required',
            'name_ar' => 'required',
            'order' => 'required|numeric',
            'status' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'meta_tag_keywords' => 'required',
            'meta_tag_description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048',
        ]);
        $Destination = Destination::find($id);
        $originalImage = $request->file('image');

        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
            //$newFileName = time() . $originalImage->getClientOriginalName();

            $originalPath = Destination::$imagePath;

            // Delete the previous image
            deleteImage(Destination::$imagePath, $Destination->image);

                   
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
               
            }
            $Destination->image = $newFileName;
        }

        $Destination->slug = unique_slug($request->name_en, 'Destination' , $Destination->id);

        $Destination->name_en = $request->name_en;
        $Destination->name_ar = $request->name_ar;
        $Destination->status = $request->status;
        $Destination->order = $request->order;
        $Destination->description_en = $request->description_en;
        $Destination->description_ar = $request->description_ar;
        $Destination->meta_tag_keywords = $request->meta_tag_keywords;
        $Destination->meta_tag_description = $request->meta_tag_description;
     
        $Destination->save();

        return redirect()->route('destinations.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('destination-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $Destination = Destination::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            deleteImage(Destination::$imagePath, $Destination->image);
          

            $Destination->delete();

            return redirect()->route('destinations.index')->with('success', 'Deleted Successfully');

        }
    }
}
