<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Coupons', 'subTitle' => 'Coupon', 'listTitle' => 'Coupons List'];
        $deleteRouteName = "coupons.destroy";

        if (!auth()->user()->can('coupon-view')) {
            return view('admin.abort', compact('titles'));
        }
        $coupons = Coupon::all();
        return view('admin.coupon.index', compact('titles', 'deleteRouteName','coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $titles = ['title' => "Manage Coupons", 'subTitle' => "Add Coupon", 'listTitle' => "Coupon Create"];
        if (!auth()->user()->can('coupon-add')) {
            return view('admin.abort', compact('titles'));
        }
        return view('admin.coupon.create',compact('titles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {
        if (!auth()->user()->can('coupon-add')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'coupon_title' => 'required|string',
            'coupon_code' => 'required|string|unique:coupons',
            'coupon_valid_from' => 'required|date',
            'coupon_valid_to' => 'required|date|after_or_equal:coupon_valid_from',
            'coupon_valid_for' => 'required|string'
        ]);

        $data = $request->only([
            'coupon_title',
            'coupon_code',
            'coupon_type',
            'coupon_amount',
            'coupon_valid_from',
            'coupon_valid_to',
            'coupon_valid_for',
            'coupon_valid_on',
            'status',
        ]);

        Coupon::create($data);

        return redirect()->route('coupons.index')->with('success', 'Created Successfully');
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
    public function edit(Coupon $coupon)
    {
        $titles = ['title' => 'Manage Coupons', 'subTitle' => 'Edit Coupon', 'listTitle' => 'Coupons List'];

        if (!auth()->user()->can('coupon-edit')) {
            return view('admin.abort', compact('titles'));
        }

        $coupon = Coupon::find($coupon->id);
        return view('admin.coupon.edit', compact('titles', 'coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        if (!auth()->user()->can('coupon-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'coupon_title' => 'required|string',
            'coupon_code' => 'required|string|unique:coupons,coupon_code,' . $coupon->id,
            'coupon_valid_from' => 'required|date',
            'coupon_valid_to' => 'required|date|after_or_equal:coupon_valid_from',
            'coupon_valid_for' => 'required|string',
        ]);

        $data = $request->only([
            'coupon_title',
            'coupon_code',
            'coupon_type',
            'coupon_amount',
            'coupon_valid_from',
            'coupon_valid_to',
            'coupon_valid_for',
            'coupon_valid_on',
            'status',
        ]);

        $coupon->update($data);

        return redirect()->route('coupons.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */

    public function destroy(Coupon $coupon)
    {
        $title = 'Delete';
        if (!auth()->user()->can('coupon-delete')) {
            return view('admin.abort');
        }
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully');
    }
}
