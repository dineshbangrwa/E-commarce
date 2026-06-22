<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Models\language;
use App\Models\Page;
use App\Models\PageLanguage;
use Illuminate\Http\Request;

class LanPageController extends Controller
{
    public function index($id)
    {
        $page = Page::findOrFail($id);
        $languages = language::all();

        return view('Language.page', compact('page', 'languages'));
    }

    public function storeTranslation(Request $request, $pageId)
    {
        $request->validate([
            'language' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
        ]);

        $translation = PageLanguage::firstOrNew(['page_id' => $pageId]);
        $translatedData = $translation->translated_data ?? [];
        $translatedData[$request->language] = [
            'name' => $request->name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ];
        $translation->page_id = $pageId;
        $translation->translated_data = $translatedData;
        $translation->save();

        return response()->json(['message' => 'Translation saved successfully']);
    }

    public function getTranslation($pageId)
    {
        $langCode = request('lang');
        $product = Page::findOrFail($pageId);
        $translation = PageLanguage::where('page_id', $pageId)->first();

        if ($translation && isset($translation->translated_data[$langCode])) {
            $data = $translation->translated_data[$langCode];

            return response()->json([
                'name' => $data['name'] ?? $product->name,
                'description' => $data['description'] ?? $product->description,
                'meta_title' => $data['meta_title'] ?? $product->meta_title,
                'meta_description' => $data['meta_description'] ?? $product->meta_description,
            ]);
        }

        return response()->json([
            'name' => $product->name,
            'description' => $product->description,
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
        ]);
    }
}
