<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    // public function change(Request $request)
    // {
    //     $request->validate([
    //         'lang' => 'required|string|exists:languages,code',
    //     ]);
    //     $lang = $request->lang;
    //     session(['language_code' => $lang]);

    //     return redirect()->route('lang.index', ['lang' => $lang]);
    // }
    public function change(Request $request)
    {
        $request->validate([
            'lang' => 'required|string|exists:languages,code',
        ]);

        $lang = $request->lang;
        session(['language_code' => $lang]);

        // पुराने URL को मिलेगा ताकि redirect उसी पेज पर हो
        $previousUrl = url()->previous();

        // URL से old locale remove करके new locale add करना होगा

        // Parse URL path
        $parsedUrl = parse_url($previousUrl, PHP_URL_PATH);

        // वर्तमान URL path से पहले से मौजूद language code हटाएं (e.g. /en/ या /hi/)
        $segments = explode('/', ltrim($parsedUrl, '/'));

        if (in_array($segments[0], ['en', 'hi', 'es', 'fr'])) {
            // पुरानी भाषा को हटा दें
            array_shift($segments);
        }

        // नए language code के साथ URL बनाएं
        $newUrl = url('/'.$lang.'/'.implode('/', $segments));

        return redirect($newUrl);
    }
}
