<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CatLanguage;
use App\Models\Language;
use Illuminate\Http\Request;

class LanCatController extends Controller
{
    // Show the category translation form
    public function index($id)
    {
        $category = Category::findOrFail($id);
        $languages = Language::all();

        return view('Language.category', compact('category', 'languages'));
    }

    // Store or update translation for a category
    public function storeTranslation(Request $request, $categoryId)
    {
        $request->validate([
            'language' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'short_description' => 'required|string',
            'meta_description' => 'required|string',
        ]);

        $translation = CatLanguage::firstOrNew(['category_id' => $categoryId]);
        $translatedData = $translation->translated_data ?? [];

        $translatedData[$request->language] = [
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'meta_description' => $request->meta_description,
        ];

        $translation->category_id = $categoryId;
        $translation->translated_data = $translatedData;
        $translation->save();

        return response()->json(['message' => 'Translation saved successfully']);
    }

    public function getTranslation($categoryId)
    {
        $langCode = request('lang');
        $category = Category::findOrFail($categoryId);
        $translation = CatLanguage::where('category_id', $categoryId)->first();

        if ($translation && isset($translation->translated_data[$langCode])) {
            $data = $translation->translated_data[$langCode];
            return response()->json([
                'name' => $data['name'] ?? $category->name,
                'description' => $data['description'] ?? $category->description,
                'short_description' => $data['short_description'] ?? $category->short_description,
                'meta_description' => $data['meta_description'] ?? $category->meta_description,
            ]);
        }

        return response()->json([
            'name' => $category->name,
            'description' => $category->description,
            'short_description' => $category->short_description,
            'meta_description' => $category->meta_description,
        ]);
    }
}
