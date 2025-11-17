<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slider::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addcolumn('image', function ($row) {
                    $image = '<img id="preview" src="' . $row->getFirstMediaUrl('image') . '" alt="Current Image" style="max-width: 110px; margin-top: 10px;">';
                    return $image;
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('slider.edit', $row->id);
                    $switch = route('lang.switch.slider', $row->id);
                    $deleteUrl = route('slider.destroy', $row->id);

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
        return view('Admin.Slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $insert = [

            'title' => $request->title,
            'url_key' => Str::slug($request->title),
            'order' => $request->order,
            'description' => $request->description,

        ];
        $slider = Slider::create($insert);

        if ($request->hasfile('image') && $request->file('image')) {
            $slider->addMediaFromRequest('image')->toMediaCollection('image');
        }
        return redirect()->route('slider.index')->with('success', 'Slider will be Created Succesfully');
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
        $slider = Slider::where('id', $id)->first();
        return view('Admin.Slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $slider = Slider::findOrFail($id);

        $insert = [

            'title' => $request->title,
            'url_key' => Str::slug($request->title),
            'order' => $request->order,
            'description' => $request->description,

        ];
        $slider->update($insert);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($slider->hasMedia('image')) {
                $slider->clearMediaCollection('image');
            }
            $slider->addMediaFromRequest('image')->toMediaCollection('image');
        }
        return redirect()->route('slider.index')->with('success', 'Role will be updated Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        return redirect()->route('slider.index')->with('success', 'Role will be Delete Succesfully');
    }
}
