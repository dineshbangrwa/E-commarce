<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Block::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addcolumn('image', function ($row) {
                    $image = '<img id="preview" src="' . $row->getFirstMediaUrl('image') . '" alt="Current Image" style="max-width: 110px; margin-top: 10px;">';
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('block.edit', $row->id);
                    $switch = route('lang.switch.block', $row->id);
                    $deleteUrl = route('block.destroy', $row->id);

                    $btn = '<div class="d-flex gap-2 text-nowrap">
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                <a href="' . $switch . '" class="btn btn-sm btn-primary">Switch lan.</a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>
            </div>';
                    return $btn;
                })

                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('Admin.Block.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Block.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $insert = [
            'name' => $request->name,
            'status' => $request->status,
            'identifire' => $request->identifire,
            'description' => $request->description,
        ];
        $block = Block::create($insert);


        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $block->addMediaFromRequest('image')->toMediaCollection('image');
        }
        return redirect()->route('block.index')->with('success', 'Block is Created Succesfully');;
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
        $block = Block::where('id', $id)->first();
        return view('Admin.Block.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $block = Block::findOrFail($id);

        $insert = [
            'name' => $request->name,
            'status' => $request->status,
            'identifire' => $request->identifire,
            'description' => $request->description,
        ];

        $block->update($insert);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($block->hasMedia('image')) {
                $block->clearMediaCollection('image');
            }
            $block->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('block.index')->with('success', 'Block will be update Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $block = Block::findOrFail($id);
        $block->delete();
        return redirect()->route('block.index')->with('success', 'Block will be Delete Succesfully');;
    }
}
