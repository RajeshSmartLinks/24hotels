<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PopularEventNews;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class PopularEventsNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $titles = ['title' => "Popular Events News", 'subTitle' => "Popular Events News", 'listTitle' => "Popular Events News Listing"];
        if (!auth()->user()->can('popular-events-news-view')) {
            return view('admin.abort', compact('titles'));
        }
      
        $deleteRouteName = "popular-events-news.destroy";

        $popularEventsNews = PopularEventNews::orderBy('id','desc')->get();

        return view('admin.popular_events_news.index', compact('titles', 'popularEventsNews', 'deleteRouteName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $titles = [
            'title' => "Popular Events News",
            'subTitle' => "Add Popular Events News",
        ];
        if (!auth()->user()->can('popular-events-news-add')) {
            return view('admin.abort',compact('titles'));
        }

        return view('admin.popular_events_news.create', compact('titles'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('popular-events-news-add')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image' => 'image|required|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'status' => 'required',
            'meta_tag_keywords' => 'required',
            'meta_tag_description' => 'required',
            'order' => 'required'
            
        ]);
        $data = array();
        $originalImage = $request->file('image');

        if ($originalImage != NULL) {
            $newFileName = time() . $originalImage->getClientOriginalName();

            $thumbnailPath = PopularEventNews::$imageThumbPath;
            $originalPath = PopularEventNews::$imagePath;

            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                $newFileName = time().$originalImage->getClientOriginalName();
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

        $data['slug'] = unique_slug($request->name_en, 'PopularEventNews');
        $data['name_en'] = $request->name_en;
        $data['name_ar'] = $request->name_ar;
        $data['description_en'] = $request->description_en;
        $data['description_ar'] = $request->description_ar;
        $data['meta_tag_keywords'] = $request->meta_tag_keywords;
        $data['meta_tag_description'] = $request->meta_tag_description;
        $data['order'] = $request->order;
        
        
       

        PopularEventNews::create($data);
        return redirect()->route('popular-events-news.index')->with('success','created Successfully');
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
        $titles = ['title' => 'Manage Popular Events News', 'subTitle' => 'edit popular events news'];

        if (!auth()->user()->can('popular-events-news-edit')) {
            return view('admin.abort', compact('titles'));
        }

        $editPopularEventNews = PopularEventNews::find($id);

        return view('admin.popular_events_news.edit', compact('titles', 'editPopularEventNews'));
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
        if (!auth()->user()->can('popular-events-news-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'status' => 'required',
            'meta_tag_keywords' => 'required',
            'meta_tag_description' => 'required',
            'order' => 'required'
        ]);

        $popularEventnews = PopularEventNews::find($id);
        $originalImage = $request->file('image');

        if ($originalImage != NULL) {
            $newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = PopularEventNews::$imageThumbPath;
            $originalPath = PopularEventNews::$imagePath;

            // Delete the previous image
            deleteImage(PopularEventNews::$imagePath, $popularEventnews->image);
            deleteImage(PopularEventNews::$imageThumbPath, $popularEventnews->image);

            if($originalImage->getClientOriginalExtension() == 'svg')
            {
                $newFileName = time().$originalImage->getClientOriginalName();
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
            $popularEventnews->image = $newFileName;
        }
        $popularEventnews->slug = unique_slug($request->name_en, 'PopularEventNews' , $popularEventnews->id);

        $popularEventnews->name_en = $request->name_en;
        $popularEventnews->name_ar = $request->name_ar;
        $popularEventnews->description_en = $request->description_en;
        $popularEventnews->description_ar = $request->description_ar;
        $popularEventnews->meta_tag_keywords = $request->meta_tag_keywords;
        $popularEventnews->meta_tag_description = $request->meta_tag_description;
        $popularEventnews->order = $request->order;
        
     
        $popularEventnews->save();

        return redirect()->route('popular-events-news.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('popular-events-news-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $popularEventnews = PopularEventNews::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            deleteImage(PopularEventNews::$imagePath, $popularEventnews->image);
            deleteImage(PopularEventNews::$imageThumbPath, $popularEventnews->image);

            $popularEventnews->delete();

            return redirect()->route('popular-events-news.index')->with('success', 'Deleted Successfully');

        }
    }
}
