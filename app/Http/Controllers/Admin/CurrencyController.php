<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Currency;
use App\Models\CurrencyExchangeRate;


class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Currency::select('*');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('currency.edit', $row->id) . '"  class="btn btn-secondary">edit</a>';
                    $btn .= ' <form action="' . route('currency.destroy', $row->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-primary">Delete</button>
                        </form>';

                    return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }
        return view('Admin.Currency.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Currency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = [
            'name' => $request->name,
            'code' => $request->code,
            'symbol' => $request->symbol,
            'is_default' => $request->is_default,
        ];
        Currency::create($request);
        return redirect()->route('currency.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Currency::where('id',$id)->delete();
        return redirect()->route('currency.index');
    }
}
