<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\CurrencyExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CurrencyExchangeRateController extends Controller
{
    /**
     * Display a listing of the exchange rates.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CurrencyExchangeRate::with(['fromCurrency', 'toCurrency'])->select('*');

            return DataTables::of($data)
                ->addIndexColumn()

                // Show currency code (or name+code)
                ->addColumn('from_currency', function ($row) {
                    return $row->fromCurrency ? $row->fromCurrency->code : '-';
                })
                ->addColumn('to_currency', function ($row) {
                    return $row->toCurrency ? $row->toCurrency->code : '-';
                })

                ->addColumn('rate', function ($row) {
                    return $row->rate;
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('exchange_rates.edit', $row->id).'" class="btn btn-secondary">Edit</a>';
                    $btn .= ' <form action="'.route('exchange_rates.destroy', $row->id).'" method="POST" style="display:inline;">
                    '.csrf_field().method_field('DELETE').'
                    <button type="submit" class="btn btn-primary">Delete</button>
                </form>';

                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.ExchangeRate.index');
    }

    /**
     * Show the form for creating a new exchange rate.
     */
    public function create()
    {
        $defaultCurrency = Currency::where('is_default', 1)->first();

        if (! $defaultCurrency) {
            return redirect()->back()->with('error', '⚠️ Please set a default currency first.');
        }

        $currencies = Currency::where('id', '!=', $defaultCurrency->id)->get();

        return view('Admin.ExchangeRate.create', compact('currencies', 'defaultCurrency'));
    }

    /**
     * Store a newly created exchange rate.
     */
    public function store(Request $request)
    {
        $request->validate([
            'from_currency_id' => 'required|exists:currencies,id',
            'to_currency_id' => [
                'required',
                'different:from_currency_id',
                'exists:currencies,id',
                Rule::unique('currency_exchange_rates')->where(function ($query) use ($request) {
                    return $query->where('from_currency_id', $request->from_currency_id)
                        ->where('to_currency_id', $request->to_currency_id);
                }),
            ],
            'rate' => 'required|numeric|min:0.00001',
        ], [
            'to_currency_id.unique' => 'This exchange rate already exists.',
            'to_currency_id.different' => 'From and To currencies must be different.',
        ]);

        CurrencyExchangeRate::create([
            'from_currency_id' => $request->from_currency_id,
            'to_currency_id' => $request->to_currency_id,
            'rate' => $request->rate,
        ]);

        // ✅ Reverse Rate (auto create if not exists)
        $reverseExists = CurrencyExchangeRate::where('from_currency_id', $request->to_currency_id)
            ->where('to_currency_id', $request->from_currency_id)
            ->exists();

        if (! $reverseExists) {
            CurrencyExchangeRate::create([
                'from_currency_id' => $request->to_currency_id,
                'to_currency_id' => $request->from_currency_id,
                'rate' => 1 / $request->rate,
            ]);
        }

        return redirect()->route('exchange_rates.index')->with('success', 'Exchange rate and reverse rate saved successfully.');
    }

    /**
     * Show the form for editing the specified exchange rate.
     */
    public function edit(string $id)
    {
        $rate = CurrencyExchangeRate::findOrFail($id);
        $defaultCurrency = Currency::where('is_default', 1)->first();
        $currencies = Currency::where('id', '!=', $defaultCurrency->id)->get();

        return view('Admin.ExchangeRate.edit', compact('rate', 'defaultCurrency', 'currencies'));
    }

    /**
     * Update the specified exchange rate.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'rate' => 'required|numeric|min:0.00001',
        ]);

        $rate = CurrencyExchangeRate::findOrFail($id);

        // ✅ Update original rate
        $rate->rate = $request->rate;
        $rate->save();

        // ✅ Update reverse rate if it exists
        $reverseRate = CurrencyExchangeRate::where('from_currency_id', $rate->to_currency_id)
            ->where('to_currency_id', $rate->from_currency_id)
            ->first();

        if ($reverseRate) {
            $reverseRate->rate = 1 / $request->rate;
            $reverseRate->save();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified exchange rate.
     */
    public function destroy(string $id)
    {
        CurrencyExchangeRate::where('id', $id)->delete();

        return redirect()->route('exchange_rates.index')->with('success', 'Exchange rate deleted successfully.');
    }
}
