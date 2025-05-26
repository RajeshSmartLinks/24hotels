<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class OperatorController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Operator', 'subTitle' => 'Add Operator', 'listTitle' => 'Operator List'];

        if (!auth()->user()->can('operator-view')) {
            return view('admin.abort', compact('titles'));
        }

        $deleteRouteName = "operator.destroy";

        $loggedAdminId = auth()->user()->id;

        if ($loggedAdminId === 1) {
            $operators = User::with('roles')->BackEndUsers()->OrderBy('id','DESC')->get();
            $roles = Role::BackendRoles()->get();
        } else {
            $operators = User::with('roles')->nonSmartOnly()->BackEndUsers()->OrderBy('id','DESC')->get();
            $roles = Role::NonSmart()->BackendRoles()->get();
        }

        return view('admin.operator.create', compact('titles', 'operators', 'roles', 'deleteRouteName'));
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
        if (!auth()->user()->can('operator-add')) {
            return view('admin.abort');
        }

        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            //'mobile' => 'required',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|integer',
            'password' => 'required|min:8|confirmed'
        ];
        $this->validate($request, $rules);

        $data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            // 'mobile' => $request->mobile,
            //'username' => empty($request->username) ? $request->mobile : $request->username,
            'password' => Hash::make($request->password),
            'back_end_user' => 1
        );

        // if (!empty($request->email)) {
        //     $data['email'] = $request->email;
        // }
        if (!empty($request->mobile)) {
            $data['mobile'] = $request->mobile;
        }
        
        $admin = User::create($data);
        $admin->assignRole($request->role_id);
        return redirect()->route('operator.index')->with('success', 'Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Manage Operator', 'subTitle' => 'Edit Operator'];

        if (!auth()->user()->can('operator-edit')) {
            return view('admin.abort', compact('titles'));
        }

        $loggedAdminId = auth()->user()->id;
        // if ($loggedAdminId <> 1 && $id === 1) {
        //     return route('admin.operator.index');
        // }

        // if ($loggedAdminId === 1) {
        //     $roles = Role::all();
        // } else {
        //     $roles = Role::nonSmart()->get();
        // }

        if ($loggedAdminId === 1) {
            $operators = User::with('roles')->BackEndUsers()->get();
            $roles = Role::BackendRoles()->get();
        } else {
            $operators = User::with('roles')->nonSmartOnly()->BackEndUsers()->get();
            $roles = Role::NonSmart()->BackendRoles()->get();
        }
        
        $operator = User::with('roles')->find($id);

        return view('admin.operator.edit', compact('titles', 'operator', 'roles'));
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
        if (!auth()->user()->can('operator-edit')) {
            return view('admin.abort');
        }

        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' =>  'required|email|unique:users,email,'.$id,
            'mobile' => 'required',
            'role_id' => 'required|integer'
        ];


        $this->validate($request, $rules);


        $data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,

        );

        $originalImage = $request->file('profile_pic');

        if ($originalImage != NULL) {
            $newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = User::$imageThumbPath;
            $originalPath = User::$imagePath;

            // Image Upload Process
            $thumbnailImage = Image::make($originalImage);

            $thumbnailImage->save($originalPath . $newFileName);
            //$thumbnailImage->resize(150, 150);
            $thumbnailImage->resize(40, null, function ($constraint) {
                $constraint->aspectRatio();
                })->save($thumbnailPath . $newFileName);
            //$thumbnailImage->save($thumbnailPath . $newFileName);

            $update['profile_pic'] = $newFileName;
        }

        $admin = User::find($request->operator_id);

        $this->detachRole($admin);
        $admin->assignRole($request->role_id);
        $admin->update($data);
        return redirect()->route('operator.index')->with('success', 'Updated Successfully');
    }

    public function detachRole($admin)
    {
        // Grab all the Roles and detach first
        $allRoles = Role::all();
        $admin->roles()->detach($allRoles);
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('operator-delete')) {
            return view('admin.abort');
        }
        $admin = User::find($id);

        $this->detachRole($admin);
       
        $admin->delete();
        return redirect()->route('operator.index')->with('success', 'operator deleted Successfully');
    }


}
