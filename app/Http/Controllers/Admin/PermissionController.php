<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if(Gate::denies('permission_index')){
        //     abort(403,'unauthorized action');
        // }
        if ($request->ajax()) {

            $data = Permission::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="'.route('permission.edit', $row->id).'"  class="btn btn-primary">edit</a>';
                    $btn .= ' <form action="'.route('permission.destroy', $row->id).'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-secondary">Delete</button>
                        </form>';

                    return $btn;

                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('Admin.Permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if(Gate::denies('permission_create')){
        //     abort(403,'unauthorized action');
        // }
        return view('Admin.Permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // if(Gate::denies('permission_store')){
        //     abort(403,'unauthorized action');
        // }

        if ($request->name) {
            foreach ($request->name as $key => $names) {

                Permission::create([
                    'name' => $request->name[$key],
                ]);
            }
        }

        return redirect()->route('permission.index')->with('success', 'Permission will be Created Succesfully');

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
        // if(Gate::denies('permission_edit')){
        //     abort(403,'unauthorized action');
        // }
        $permission = Permission::where('id', $id)->first();

        return view('Admin.Permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // if(Gate::denies('permission_update')){
        //     abort(403,'unauthorized action');
        // }
        $update = [
            'name' => $request->name,
        ];

        Permission::where('id', $id)->update($update);

        return redirect()->route('permission.index')->with('success', 'Permission  Updated Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // if(Gate::denies('permission_delete')){
        //     abort(403,'unauthorized action');
        // }
        Permission::where('id', $id)->delete();

        return redirect()->route('permission.index')->with('success', 'Permission will be Deleted Succesfully');
    }
}
