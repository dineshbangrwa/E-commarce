<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\language;
use App\Models\translation;
use App\Models\Block;

class BlockTranslationController extends Controller
{
    public function index($id)
    {
        $block = Block::findOrFail($id);
        $languages = Language::all();

        return view('Language.block', compact('block', 'languages'));
    }
    public function storeTranslation(Request $request, $blockId)
    {
        // dd($request->all());
        $request->validate([
            'language' => 'required|string',
            'name' => 'required|string',
            'status' => 'required|string',
            'identifire' => 'required|string',
            'description' => 'required|string',
        ]);

        $translation = Translation::firstOrNew(['block_id' => $blockId]);

        $translatedData = $translation->translated_data ?? [];
        $translatedData[$request->language] = [
            'name' => $request->name,
            'status' => $request->status,
            'identifire' => $request->identifire,
            'description' => $request->description,
        ];

        $translation->block_id = $blockId;
        $translation->translated_data = $translatedData;
        $translation->save();

        return response()->json(['message' => 'Translation saved successfully']);
    }

    public function getTranslation($blockId)
    {
        $langCode = request('lang');
        $block = Block::findOrFail($blockId);
        $translation = Translation::where('block_id', $blockId)->first();

        if ($translation && isset($translation->translated_data[$langCode])) {
            $data = $translation->translated_data[$langCode];
            return response()->json([
                'name' => $data['name'] ?? $block->name,
                'status' => $data['status'] ?? $block->status,
                'identifire' => $data['identifire'] ?? $block->identifire,
                'description' => $data['description'] ?? $block->description,
            ]);
        }

        return response()->json([
            'name' => $block->name,
            'status' => $block->status,
            'identifire' => $block->identifire,
            'description' => $block->description,
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
