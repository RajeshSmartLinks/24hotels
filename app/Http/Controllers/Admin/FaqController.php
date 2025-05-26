<?php

namespace App\Http\Controllers\admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $titles = ['title' => "FAQ", 'subTitle' => "faq", 'listTitle' => "FAQ Listing"];
        $deleteRouteName = "faq.destroy";

        if (!auth()->user()->can('faq-view')) {
            return view('admin.abort', compact('titles'));
        }

        $faqs = Faq::orderBy('order','desc')->get();

        return view('admin.faq.index', compact('titles', 'faqs', 'deleteRouteName'));
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        
        $titles = ['title' => " FAQ", 'subTitle' => "faq", 'listTitle' => "FAQ Create"];
        if (!auth()->user()->can('faq-add')) {
            return view('admin.abort', compact('titles'));
        }
        return view('admin.faq.create',compact('titles'));
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if (!auth()->user()->can('faq-add')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'answer_en' => 'required',
            'answer_ar' => 'required',
            'order' => 'required',
            'status' => 'required',
            'question_en' => 'required',
            'question_ar' => 'required',
        ]);
        $Faq = new Faq;
        $Faq->question_en = $request->question_en;
        $Faq->question_ar = $request->question_ar;
        $Faq->answer_en = $request->answer_en;
        $Faq->answer_ar = $request->answer_ar;
        $Faq->order = $request->order;
        $Faq->status = $request->status;
        $Faq->save();
        return redirect()->route('faq.index')
        ->with('success','Faq has been created successfully.');
    }
    /**
    * Display the specified resource.
    *
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function show(Faq $company)
    {
        //return view('faq.show',compact('company'));
    } 
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $titles = ['title' => 'Manage FAQ', 'subTitle' => 'edit FAQ'];

        if (!auth()->user()->can('faq-edit')) {
            return view('admin.abort', compact('titles'));
        }
        $editFaq = FAQ::find($id);

        return view('admin.faq.edit', compact('titles', 'editFaq'));
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('faq-ediit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'answer_en' => 'required',
            'answer_ar' => 'required',
            'order' => 'required',
            'status' => 'required',
            'question_en' => 'required',
            'question_ar' => 'required',
        ]);
        $Faq = Faq::find($id);
        $Faq->question_en = $request->question_en;
        $Faq->question_ar = $request->question_ar;
        $Faq->answer_en = $request->answer_en;
        $Faq->answer_ar = $request->answer_ar;
        $Faq->order = $request->order;
        $Faq->status = $request->status;
        $Faq->save();
        return redirect()->route('faq.index')
        ->with('success','Faq Has Been updated successfully');
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function destroy(Faq $company)
    {
        if (!auth()->user()->can('faq-delete')) {
            return view('admin.abort');
        }
        $company->delete();
        return redirect()->route('companies.index')
        ->with('success','Company has been deleted successfully');
    }
}
