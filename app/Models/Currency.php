<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected  $fillable = [

        'name',
        'code',
        'symbol',
        'is_default'
    ];
    public function exchangeRatesFrom()
{
    return $this->hasMany(CurrencyExchangeRate::class, 'from_currency_id');
}

public function exchangeRatesTo()
{
    return $this->hasMany(CurrencyExchangeRate::class, 'to_currency_id');
}
}
