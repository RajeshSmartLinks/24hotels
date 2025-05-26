<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function editUser()
    {
        $titles = ['title' => 'Manage User', 'subTitle' => 'Edit user'];
        $loggedAdminId = auth()->user()->id;
  

        if ($loggedAdminId === 1) {
            //$operators = User::with('roles')->BackEndUsers()->get();
            $roles = Role::BackendRoles()->get();
        } else {
            //$operators = User::with('roles')->nonSmartOnly()->BackEndUsers()->get();
            $roles = Role::NonSmart()->BackendRoles()->get();
        }
        
        $user = User::with('roles')->find($loggedAdminId);

        return view('admin.user.edit', compact('titles', 'user', 'roles'));

    }

    public function updateUser(Request $request,$id)
    {
        // if (!auth()->user()->can('operator-update')) {
        //     return view('admin.abort');
        // }

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
            //'username' => empty($request->username) ? $request->mobile : $request->username,
            //'password' => Hash::make($request->password),

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

            $data['profile_pic'] = $newFileName;
        }

        $admin = User::find($request->user_id);

        $this->detachRole($admin);
        $admin->assignRole($request->role_id);
        $admin->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'User Updated Successfully');
    }

    public function changePassword()
    {

        $titles = ['title' => 'Change Password', 'subTitle' => 'Change Password'];
        $loggedAdminId = auth()->user()->id;
        return view('admin.user.chagePassword', compact('titles'));

    }

    public function updatePassword(Request $request)
    {
        if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('password'), $request->get('old_password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);

        $user = User::where("id",Auth::user()->id)->update([
        'password' =>  Hash::make($request->input('password'))]);

        return redirect()->route('admin.dashboard')->with('success', 'Password Updated Successfully');

    }

    public function UserList()
    {
        if (!auth()->user()->can('user-view')) {
            return view('admin.abort');
        }
        $titles = [
            'title' => "Users List",
            //'subTitle' => "Add offer",
        ];

        $users = User::whereBackEndUser(0)->orderBy('id','DESC')->get();

        return view('admin.user.index',compact('titles','users'));
    }
}
