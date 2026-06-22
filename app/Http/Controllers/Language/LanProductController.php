<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProLanguage;
use Illuminate\Http\Request;

class LanProductController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $languages = Language::all();

        return view('Language.product', compact('product', 'languages'));
    }

    public function storeTranslation(Request $request, $productId)
    {
        // dd($request->all());
        $request->validate([
            'language' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'short_description' => 'required|string',
        ]);

        $translation = ProLanguage::firstOrNew(['product_id' => $productId]);
        $translatedData = $translation->translated_data ?? [];
        $translatedData[$request->language] = [
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
        ];
        $translation->product_id = $productId;
        $translation->translated_data = $translatedData;
        $translation->save();

        return response()->json(['message' => 'Translation saved successfully']);
    }

    public function getTranslation($productId)
    {
        $langCode = request('lang');
        $product = Product::findOrFail($productId);
        $translation = ProLanguage::where('product_id', $productId)->first();

        if ($translation && isset($translation->translated_data[$langCode])) {
            $data = $translation->translated_data[$langCode];

            return response()->json([
                'name' => $data['name'] ?? $product->name,
                'description' => $data['description'] ?? $product->description,
                'short_description' => $data['short_description'] ?? $product->short_description,
            ]);
        }

        return response()->json([
            'name' => $product->name,
            'description' => $product->description,
            'short_description' => $product->short_description,
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
