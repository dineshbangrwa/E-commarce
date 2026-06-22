<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Coupon::select('*');

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('coupon.edit', $row->id);
                    $deleteUrl = route('coupon.destroy', $row->id);

                    $btn = '<div class="d-flex gap-2 text-nowrap">
                <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                    '.csrf_field().method_field('DELETE').'
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>
            </div>';

                    return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }

        return view('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $insert = [
            'title' => $request->title,
            'coupon_code' => $request->coupon_code,
            'status' => $request->status,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'coupon_discount' => $request->coupon_discount,
        ];
        Coupon::create($insert);

        return redirect()->route('coupon.index')->with('success', 'Coupon Created Succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::where('id', $id)->first();

        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $insert = [
            'title' => $request->title,
            'coupon_code' => $request->coupon_code,
            'status' => $request->status,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'coupon_discount' => $request->coupon_discount,
        ];
        Coupon::where('id', $id)->update($insert);

        return redirect()->route('coupon.index')->with('success', 'Coupon will be Update Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Coupon::where('id', $id)->delete();

        return redirect()->route('coupon.index')->with('success', 'Coupon will be Delete Succesfully');
    }
}
