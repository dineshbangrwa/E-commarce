<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\Language;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('lang');
        
        if(!$locale) {
            $locale = config('app.locale');
        }
        
        App::setLocale($locale);

        setlocale(LC_ALL, $locale.'.UTF-8');

        return $next($request);
    }
}
