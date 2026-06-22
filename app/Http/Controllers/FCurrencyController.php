<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CurrencyExchangeRate;
use Illuminate\Http\Request;

class FCurrencyController extends Controller
{
    public function change(Request $request)
    {
        $selectedCode = $request->currency_code;

        $defaultCurrency = Currency::where('is_default', 1)->first();
        $selectedCurrency = Currency::where('code', $selectedCode)->first();

        if (! $defaultCurrency || ! $selectedCurrency) {
            return back()->with('error', 'Currency not found.');
        }

        if ($defaultCurrency->id == $selectedCurrency->id) {
            session([
                'currency_code' => $selectedCurrency->code,
                'currency_symbol' => $selectedCurrency->symbol,
                'currency_rate' => 1,
            ]);

            return back();
        }

        $directRate = CurrencyExchangeRate::where('from_currency_id', $defaultCurrency->id)
            ->where('to_currency_id', $selectedCurrency->id)
            ->value('rate');

        if ($directRate) {
            session([
                'currency_code' => $selectedCurrency->code,
                'currency_symbol' => $selectedCurrency->symbol,
                'currency_rate' => $directRate,
            ]);

            return back();
        }

        $reverseRate = CurrencyExchangeRate::where('from_currency_id', $selectedCurrency->id)
            ->where('to_currency_id', $defaultCurrency->id)
            ->value('rate');

        if ($reverseRate && $reverseRate != 0) {
            session([
                'currency_code' => $selectedCurrency->code,
                'currency_symbol' => $selectedCurrency->symbol,
                'currency_rate' => 1 / $reverseRate,
            ]);

            return back();
        }

        return back()->with('error', 'Conversion rate not set.');
    }
}
