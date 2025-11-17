<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {  
        if (Gate::denies('user_index')) {
            abort(403, 'Unauthorized action');
        }

        if ($request->ajax()) {
            $data = User::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addcolumn('image', function ($row) {
                    $image = '<img id="preview" src="' . $row->getFirstMediaUrl('image') . '" alt="Current Image" style="max-width: 110px; margin-top: 10px;">';
                    return $image;
                })
                 ->addcolumn('role', function($row) {
                        $roles = implode(',', $row->roles->pluck('name')->toArray());
                        
                        return $roles;
                    })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('users.edit', $row->id) . '"  class="btn btn-secondary">Edit</a>';
                    $btn .= ' <form action="' . route('users.destroy', $row->id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger">Delete</button>
                    </form>';
                    return $btn;
                })
                ->rawColumns(['action', 'image','role'])
                ->make(true);
        }

        return view('Admin.User.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         if (Gate::denies('user_create')) {
            abort(403, 'Unauthorized action');
        }

     $roles =Role::all();
        return view('Admin.User.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         if (Gate::denies('user_store')) {
            abort(403, 'Unauthorized action');
        }
        // dd($request->all());
        $insert = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'gender' => $request->gender,
            'is_admin'=>1,
        ];
        $user = User::create($insert);
  $user->syncRoles($request->roles);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $user->addMediaFromRequest('image')->toMediaCollection('image');
        }
        return redirect()->route('users.index')->with('success', 'User will be Created Succesfully');
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
         if (Gate::denies('user_edit')) {
            abort(403, 'Unauthorized action');
        }
         $roles =Role::all();
        $user = User::where('id', $id)->first();
        return view('Admin.User.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         if (Gate::denies('user_update')) {
            abort(403, 'Unauthorized action');
        }

        $users = User::findOrFail($id);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($users->hasMedia('image')) {
                $users->clearMediaCollection('image');
            }
            $users->addMediaFromRequest('image')->toMediaCollection('image');
        }
           $users->syncRoles($request->roles);
        return redirect()->route('users.index')->with('success', 'User will be Update Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         if (Gate::denies('user_delete')) {
            abort(403, 'Unauthorized action');
        }
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User will be Delete Succesfully');
    }
}
