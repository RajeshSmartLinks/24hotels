<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Role', 'subTitle' => 'Add Role', 'listTitle' => 'Role List'];
        $deleteRouteName = "role.destroy";

        if (!auth()->user()->can('role-view')) {
            return view('admin.abort', compact('titles'));
        }

        $roles = Role::all();

        return view('admin.role.create', compact('titles', 'roles', 'deleteRouteName'));
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
        if (!auth()->user()->can('role-add')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'name' => 'required|string|unique:roles',
        ]);

        $data = array();

        $name = $request->name;

        $data['name'] = Str::ucfirst($name);
        $data['slug'] = Str::of(Str::lower($name))->slug('-');

        Role::create($data);
        return redirect()->route('role.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $titles = ['title' => 'Manage Role', 'subTitle' => 'Edit Role', 'listTitle' => 'Role List'];

        if (!auth()->user()->can('role-edit')) {
            return view('admin.abort', compact('titles'));
        }

        // if (!$role)
        //     return redirect(route('role.index'))->with('error', trans('app.request_url_not_found'));
        // else
        //     $permissions = Permission::all();

        $permissions = Permission::all();    

        return view('admin.role.edit', compact('titles', 'role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if (!auth()->user()->can('role-edit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = array();
        $name = $request->name;
        $inputPermissions = $request->permission;

        $this->detachPermission($role);
        // Attach the permissions
        foreach ($inputPermissions as $inputPermission) {
            $role->permissions()->attach($inputPermission);
        }

        $data['name'] = Str::ucfirst($name);
        $data['slug'] = Str::of(Str::lower($name))->slug('-');

        $role->update($data);

        return redirect()->route('role.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $title = 'Delete';
        if (!auth()->user()->can('role-delete')) {
            return view('admin.abort', compact('title'));
        }
        $this->detachPermission($role);
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Deleted Successfully');
    }

    public function detachPermission($role)
    {
        // Grab all the permissions and detach first
        $allPermissions = Permission::all();
        $role->permissions()->detach($allPermissions);
        return true;
    }
}
