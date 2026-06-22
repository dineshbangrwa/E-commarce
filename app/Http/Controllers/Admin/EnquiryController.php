<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Enquiry::query();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('enquiry.edit', $row->id).'"  class="btn btn-secondary">Edit</a>';
                    $btn .= ' <form action="'.route('enquiry.destroy', $row->id).'" method="POST" style="display:inline;">
                    '.csrf_field().method_field('DELETE').'
                    <button type="submit" class="btn btn-danger">Delete</button>
                    </form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.Enquiry.index')->with('success', 'Enquiry added successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Enquiry.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $insert = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];
        Enquiry::create($insert);

        return redirect()->route('enquiry.index')->with('success', 'Enquiry added successfully');

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
        $enquiry = Enquiry::where('id', $id)->first();

        return view('admin.enquiry.edit', compact('enquiry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];
        Enquiry::where('id', $id)->update($update);

        return redirect()->route('enquiry.index')->with('success', 'Enquiry update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Enquiry::where('id', $id)->delete();

        return redirect()->route('enquiry.index')->with('success', 'Enquiry Delete successfully');
    }
}
