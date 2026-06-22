<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Page::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addcolumn('image', function ($row) {
                    $image = '<img id="preview" src="'.$row->getFirstMediaUrl('image').'" alt="Current Image" style="max-width: 110px; margin-top: 10px;">';

                    return $image;
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('page.edit', $row->id);
                    $switch = route('lang.switch.page', $row->id);
                    $deleteUrl = route('page.destroy', $row->id);

                    $btn = '<div class="d-flex gap-2 text-nowrap">
                <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                <a href="'.$switch.'" class="btn btn-sm btn-primary">Switch lan.</a>
                <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                    '.csrf_field().method_field('DELETE').'
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this page?\')">Delete</button>
                </form>
            </div>';

                    return $btn;
                })

                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.Page.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $insert = [
            'name' => $request->name,
            'status' => $request->status,
            'show_in_menu' => $request->show_in_menu,
            'show_in_footer' => $request->show_in_footer,
            'description' => $request->description,
            'url_key' => Str::slug($request->name),
            'meta_tag' => $request->meta_tag,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ];
        $page = Page::create($insert);
        if ($request->hasfile('image') && $request->file('image')) {
            $page->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('page.index')->with('success', 'Page will be Created Succesfully');
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
        $page = Page::where('id', $id)->first();

        return view('admin.Page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = Page::findOrFail($id);

        $insert = [
            'name' => $request->name,
            'status' => $request->status,
            'show_in_menu' => $request->show_in_menu,
            'show_in_footer' => $request->show_in_footer,
            'description' => $request->description,
            'url_key' => Str::slug($request->name),
            'meta_tag' => $request->meta_tag,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ];
        $page->update($insert);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($page->hasMedia('image')) {
                $page->clearMediaCollection('image');
            }
            $page->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('page.index')->with('success', 'Page will be Update Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('page.index')->with('success', 'Page will be Delete Succesfully');
    }
}
