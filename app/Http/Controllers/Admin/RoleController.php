<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if(Gate::denies('role_index')){
        //     abort(403,'unauthorized action');
        // }
        if ($request->ajax()) {

            $data = Role::select('*');

            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('permissions', function ($row) {
                    $pemission = implode(',', $row->permissions->pluck('name')->toArray());

                    return $pemission;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('role.edit', $row->id);
                    $deleteUrl = route('role.destroy', $row->id);

                    $btn = '<div class="d-flex gap-2 text-nowrap">
                <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                    '.csrf_field().method_field('DELETE').'
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this role?\')">Delete</button>
                </form>
            </div>';

                    return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }

        return view('Admin.Role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if(Gate::denies('role_create')){
        //     abort(403,'unauthorized action');
        // }
        $permissions = Permission::all();

        return view('Admin.Role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // if(Gate::denies('role_store')){
        //     abort(403,'unauthorized action');
        // }
        $insert = [
            'name' => $request->name,
        ];

        $role = Role::create($insert);

        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index')->with('success', 'Role will be Created Succesfully');
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
        // if(Gate::denies('role_edit')){
        //     abort(403,'unauthorized action');
        // }
        $permissions = Permission::all();

        $roles = Role::where('id', $id)->first();

        return view('Admin.Role.edit', compact('roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // if(Gate::denies('role_update')){
        //     abort(403,'unauthorized action');
        // }
        $insert = [
            'name' => $request->name,
        ];

        $role = Role::where('id', $id)->update($insert);
        $role = Role::find($id);
        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index')->with('success', 'Role will be Update Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('role_delete')) {
            abort(403, 'unauthorized action');
        }
        Role::where('id', $id)->delete();

        return redirect()->route('role.index')->with('success', 'Role will be Delete Succesfully');
    }
}
