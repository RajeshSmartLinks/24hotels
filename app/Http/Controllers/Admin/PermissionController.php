<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Permission', 'subTitle' => 'Add Permission', 'listTitle' => 'Permission List'];
        $deleteRouteName = "permission.destroy";

        $permissions = Permission::all();

        return view('admin.permission.create', compact('titles', 'permissions', 'deleteRouteName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|string|unique:roles',
        ]);

        $data = array();

        $name = $request->name;

        $data['name'] = Str::ucfirst($name);
        $data['slug'] = Str::of(Str::lower($name))->slug('-');

        Permission::create($data);
        return redirect()->route('permission.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $titles = ['title' => 'Manage Permission', 'subTitle' => 'Edit Permission', 'listTitle' => 'Permission List'];

        if (!$permission)
            return redirect(route('permission.index'))->with('error', trans('app.request_url_not_found'));

        return view('admin.permission.edit', compact('titles', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = array();
        $name = $request->name;

        $data['name'] = Str::ucfirst($name);
        $data['slug'] = Str::of(Str::lower($name))->slug('-');

        $permission->update($data);
        return redirect()->route('permission.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('role.index')->with('success', 'Deleted Successfully');
    }
}
