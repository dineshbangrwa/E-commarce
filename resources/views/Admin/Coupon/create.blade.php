@extends('admin/layout')
@section('title', 'Create - Coupon')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('coupon.store') }}" method="POST" id="form">
    @csrf 

    <div class="form-group">
        <label for="">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter title" />
        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Coupon Code</label>
        <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Enter coupon code" />
        @error('coupon_code')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Status</label>
        <select class="form-control" id="status" name="status">
            <option  >slected </option>
            <option value="1">Active</option>
            <option value="2">Inactive</option>
        </select>
        @error('status')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Valid From</label>
        <input type="date" class="form-control" id="valid_from" name="valid_from" value="{{ old('valid_from') }}" />
        @error('valid_from')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Valid To</label>
        <input type="date" class="form-control" id="valid_to" name="valid_to" value="{{ old('valid_to') }}" />
        @error('valid_to')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Discount Amount</label>
        <input type="number" class="form-control" id="coupon_discount" name="coupon_discount" value="{{ old('coupon_discount') }}" placeholder="Enter discount amount" />
        @error('coupon_discount')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="card-action">
        <button class="btn btn-success">Submit</button>
        <button class="btn btn-danger">Cancel</button>
    </div>

</form>
@endsection

