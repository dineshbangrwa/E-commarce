<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Models\language;
use App\Models\Slider;
use App\Models\SlidLanguage;
use Illuminate\Http\Request;

class LanSliderController extends Controller
{
    public function index($id)
    {
        $slider = Slider::findOrFail($id);
        $languages = language::all();

        return view('Language.slider', compact('slider', 'languages'));
    }

    public function storeTranslation(Request $request, $sliderId)
    {
        // dd($request->all());
        $request->validate([
            'language' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',

        ]);

        $translation = SlidLanguage::firstOrNew(['slider_id' => $sliderId]);
        $translatedData = $translation->translated_data ?? [];
        $translatedData[$request->language] = [
            'title' => $request->title,
            'description' => $request->description,

        ];

        $translation->slider_id = $sliderId;
        $translation->translated_data = $translatedData;
        $translation->save();

        return response()->json(['message' => 'Translation saved successfully']);
    }

    public function getTranslation($sliderId)
    {
        $langCode = request('lang');
        $product = Slider::findOrFail($sliderId);
        $translation = SlidLanguage::where('slider_id', $sliderId)->first();

        if ($translation && isset($translation->translated_data[$langCode])) {
            $data = $translation->translated_data[$langCode];

            return response()->json([
                'title' => $data['title'] ?? $product->title,
                'description' => $data['description'] ?? $product->description,
            ]);
        }

        return response()->json([
            'title' => $product->title,
            'description' => $product->description,

        ]);
    }

    public function change(Request $request)
    {
        $request->validate([
            'lang' => 'required|string|exists:languages,code',
        ]);
        $lang = $request->lang;
        session(['language_code' => $lang]);

        return redirect()->route('lang.index', ['lang' => $lang]);
    }
}
