<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $sliders = Slider::with('media')->get();
    
    $data = $sliders->map(function($slider) {
        return [
            'id' => $slider->id,
            'title' => $slider->title,
            'description' => $slider->description,
            'image_url' => $slider->getFirstMediaUrl('image'),
        ];
    });

    return response()->json(['data' => $data], 200);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $slider = Slider::create($request->all());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $slider->addMediaFromRequest('image')->toMediaCollection('image');
        }
        return response()->json(['status'=>$slider],201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Slider::where('id',$id)->update($request->all());
       return response()->json(['status'=>'success']);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Slider::where('id',$id)->delete();
        return response()->json(['status'=>'success']);
    }
}
