<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::query();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('image', function ($row) {
                    return $row->getFirstMediaUrl('image')
                        ? '<img src="'.$row->getFirstMediaUrl('image').'" alt="Image" style="max-width: 70px;">'
                        : 'No Image';
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('category.edit', $row->id);
                    $deleteUrl = route('category.destroy', $row->id);
                    $switch = route('lang.switch.category', $row->id);

                    $btn = '<div class="d-flex gap-2 text-nowrap">
                <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                <a href="'.$switch.'" class="btn btn-sm btn-primary">Switch lan.</a>

                <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                    '.csrf_field().method_field('DELETE').'
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>
            </div>';

                    return $btn;
                })

                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorys = Category::all();

        return view('admin.category.create', compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $parent_category = implode(',', $request->parent_category);

        $insert = [
            'parent_category' => $parent_category,
            'name' => $request->name,
            'status' => $request->status,
            'show_in_menu' => $request->show_in_menu,
            'url_key' => Str::slug($request->name),
            'meta_tag' => $request->meta_tag,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'short_description' => $request->short_description,
            'description' => $request->description,
        ];

        $category = Category::create($insert);
        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('category.index')->with('success', 'Category will be Created Succesfully');
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
        $category = Category::where('id', $id)->first();
        $categorys = Category::all();

        return view('admin.Category.edit', compact('category', 'categorys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $parent_category = implode(',', $request->parent_category);

        $insert = [
            'parent_category' => $parent_category,
            'name' => $request->name,
            'status' => $request->status,
            'show_in_menu' => $request->show_in_menu,
            'url_key' => Str::slug($request->name),
            'meta_tag' => $request->meta_tag,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'short_description' => $request->short_description,
            'description' => $request->description,
        ];

        // Pehle model object le lo
        $category = Category::findOrFail($id);

        // Fir update karo
        $category->update($insert);

        // Image update
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($category->hasMedia('image')) {
                $category->clearMediaCollection('image');
            }
            $category->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('category.index')->with('success', 'Category will be update Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::where('id', $id)->delete();

        return redirect()->route('category.index')->with('success', 'Category will be Delete Succesfully');
    }
}
