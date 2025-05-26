<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use App\Models\Package;
use App\Models\SeoSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PopularEventNews;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $titles = ['title' => "SEO", 'subTitle' => "seo", 'listTitle' => "SEO Listing"];
        if (!auth()->user()->can('seo-view')) {
            return view('admin.abort', compact('titles'));
        }
        $deleteRouteName = "seo.destroy";

        // if (!auth()->user()->can('brand-view')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $seodata = SeoSettings::orderBy('id','desc')->get();
    

        return view('admin.seo.index', compact('titles', 'seodata', 'deleteRouteName' ));
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
        $titles = ['title' => 'Manage SEO', 'subTitle' => 'edit SEO'];

        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort', compact('titles'));
        // }

        $editSeodata = SeoSettings::find($id);

        return view('admin.seo.edit', compact('titles', 'editSeodata'));
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
        if (!auth()->user()->can('seo-edit')) {
            return view('admin.abort');
        }
        // if (!auth()->user()->can('supplier-update')) {
        //     return view('admin.abort');
        // }

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'page_name' => 'required',
            'status' => 'required',
            'id' => 'required',
        ]);
        $package = SeoSettings::find($id);




        $package->title = $request->title;
        $package->description = $request->description;
        $package->page_name = $request->page_name;
        $package->status = $request->status;

     
        $package->save();

        return redirect()->route('seo.index')->with('success', 'update Successfully');
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
