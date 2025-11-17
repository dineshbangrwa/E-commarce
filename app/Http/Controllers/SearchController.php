<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Category;
use App\Models\SlidLanguage;

class SearchController extends Controller
{

    public function search(Request $request,$lang)
    {
        
      app()->setLocale($lang);
    $langCode = session('language_code', 'en');

        $sliders = Slider::all();
        $sliders->transform(function ($slider) use ($langCode) {
            $translation = SlidLanguage::where('slider_id', $slider->id)->first();
            if ($translation && isset($translation->translated_data[$langCode])) {
                $data = $translation->translated_data[$langCode];
                $slider->title = $data['title'] ?? $slider->title;
                $slider->description = $data['description'] ?? $slider->description;
            }
            return $slider;
        });
        $query = $request->input('query');

        $categoryMatchedIds = Category::where('name', 'LIKE', "%{$query}%")
            ->pluck('id');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhereHas('categories', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->get();
        return view('search', compact('products', 'query', 'sliders'));
    }
}
