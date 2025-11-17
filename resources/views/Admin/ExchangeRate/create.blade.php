@extends('admin/layout')
@section('title', 'Create - Rate')

@section('content')
<style>
    .error {
        color: red;
    }
</style>
<!-- 
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif -->

<form action="{{ route('exchange_rates.store') }}" method="POST">
    @csrf 

    <!-- Hidden input for from_currency_id -->
    <input type="hidden" name="from_currency_id" value="{{ $defaultCurrency->id }}">

    <!-- Disabled select showing default currency -->
    <div class="form-group">
        <label for="">From Currency</label>
        <select class="form-control" disabled>
            <option>{{ $defaultCurrency->name }} ({{ $defaultCurrency->code }})</option>
        </select>
    </div>

    <!-- To Currency -->
    <div class="form-group">
        <label for="">To Currency</label>
        <select name="to_currency_id" class="form-control">
            <option value="">Select Currency</option>
            @foreach($currencies as $currency)
                <option value="{{ $currency->id }}" {{ old('to_currency_id') == $currency->id ? 'selected' : '' }}>
                    {{ $currency->name }} ({{ $currency->code }})
                </option>
            @endforeach
        </select>
        @error('to_currency_id')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <!-- Exchange Rate -->
    <div class="form-group">
        <label for="">Exchange Rate</label>
        <input type="text" name="rate" value="{{ old('rate') }}" class="form-control" placeholder="Enter exchange rate (e.g. 83.20)" />
        @error('rate')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="card-action">
        <button class="btn btn-success">Submit</button>
        <a href="{{ route('exchange_rates.index') }}" class="btn btn-danger">Cancel</a>
    </div>
</form>
@endsection
