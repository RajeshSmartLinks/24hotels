<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $titles = ['title' => "Offers", 'subTitle' => "offers", 'listTitle' => "Offers Listing"];
        if (!auth()->user()->can('offer-view')) {
            return view('admin.abort', compact('titles'));
        }
        $deleteRouteName = "offers.destroy";

        $offers = Offer::orderBy('id','desc')->get();

        return view('admin.offers.index', compact('titles', 'offers', 'deleteRouteName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $titles = [
            'title' => "Offers",
            'subTitle' => "Add offer",
        ];
        if (!auth()->user()->can('offer-add')) {
            return view('admin.abort',compact('titles'));
        }

        return view('admin.offers.create', compact('titles'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('offer-add')) {
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
            'valid_upto' => 'required'
        ]);
        $data = array();
        $originalImage = $request->file('image');

        if ($originalImage != NULL) {
            //$newFileName = time() . $originalImage->getClientOriginalName();
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());

            $thumbnailPath = Offer::$imageThumbPath;
            $originalPath = Offer::$imagePath;

            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                //$newFileName = time().$originalImage->getClientOriginalName();
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

        $data['slug'] = unique_slug($request->name_en, 'Offer');
        $data['name_en'] = $request->name_en;
        $data['name_ar'] = $request->name_ar;
        $data['description_en'] = $request->description_en;
        $data['description_ar'] = $request->description_ar;
        $data['valid_upto'] = $request->valid_upto;
        
       

        Offer::create($data);
        return redirect()->route('offers.index')->with('success','created Successfully');
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
        $titles = ['title' => 'Manage Offers', 'subTitle' => 'edit Offers'];

        if (!auth()->user()->can('offer-edit')) {
            return view('admin.abort', compact('titles'));
        }

        $editOffer = Offer::find($id);

        return view('admin.offers.edit', compact('titles', 'editOffer'));
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
        if (!auth()->user()->can('offer-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'valid_upto' => 'required'
        ]);
        $offer = Offer::find($id);
        $originalImage = $request->file('image');

        if ($originalImage != NULL) {
            $newFileName = imagenameMaker(pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME) ,$originalImage->getClientOriginalExtension());
            //$newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = Offer::$imageThumbPath;
            $originalPath = Offer::$imagePath;

            // Delete the previous image
            deleteImage(Offer::$imagePath, $offer->image);
            deleteImage(Offer::$imageThumbPath, $offer->image);

            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                //$newFileName = time().$originalImage->getClientOriginalName();
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
            $offer->image = $newFileName;
        }
        $offer->slug = unique_slug($request->name_en, 'Offer' , $offer->id);

        $offer->name_en = $request->name_en;
        $offer->name_ar = $request->name_ar;
        $offer->description_en = $request->description_en;
        $offer->description_ar = $request->description_ar;
        $offer->valid_upto = $request->valid_upto;
        
     
        $offer->save();

        return redirect()->route('offers.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('offer-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $offer = Offer::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            deleteImage(Offer::$imagePath, $offer->image);
            deleteImage(Offer::$imageThumbPath, $offer->image);

            $offer->delete();

            return redirect()->route('offers.index')->with('success', 'Deleted Successfully');

        }
    }
}
