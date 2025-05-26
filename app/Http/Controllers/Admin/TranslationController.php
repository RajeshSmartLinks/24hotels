<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = [
            'title' => aztran('manage_translation'),
            'subTitle' => aztran('list_translation'),
        ];
        $deleteRouteName = 'translation.destroy';

        $translations = Translation::get();

        return view('admin.translation.index', compact('titles', 'translations', 'deleteRouteName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titles = [
            'title' => aztran('manage_translation'),
            'subTitle' => aztran('list_translation'),
        ];

        return view('admin.translation.create', compact('titles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'message_key' => 'required',
            'message_en' => 'required',
            'message_ar' => 'required',
        ]);

        $data = array();

        $data['message_key'] = $request->message_key;
        $data['message_en'] = $request->message_en;
        $data['message_ar'] = $request->message_ar;

        Translation::updateOrCreate($data);
        return redirect()->route('translation.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => aztran('manage_translation'), 'subTitle' => aztran('edit_translation')];
        $editTranslation = Translation::find($id);

        return view('admin.translation.edit', compact('titles', 'editTranslation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'message_en' => 'required',
            'message_ar' => 'required',
        ]);

        $data = array();

        $translation = Translation::find($id);

        $translation->message_en = $request->message_en;
        $translation->message_ar = $request->message_ar;
        $translation->save();
        return redirect()->route('translation.index')->with('success', 'Updated Successfully');
    }

    public function ajaxUpdate(Request $request)
    {
        $out = [];
        $successMsg = aztran('failed');

        $id = $request->id;
        $message = $request->message;

        $this->validate($request, [
            'id' => 'required',
            'message' => 'required',
        ]);

        $translation = Translation::find($id);
        if ($translation) {
            $translation->message_ar = $message;
            $translation->update();
            $successMsg = aztran('update_success');
        }
        $out['status'] = 200;
        $out['message'] = $successMsg;
        return $out;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

