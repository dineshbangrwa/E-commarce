@extends('admin/layout')
@section('title', 'Edit - Coupon')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('coupon.update',$coupon->id) }}" method="POST" id="form">
    @csrf 
@method('put')
    <div class="form-group">
        <label for="">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{$coupon->title}}" placeholder="Enter title" />
        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Coupon Code</label>
        <input type="text" class="form-control" id="coupon_code" name="coupon_code"  value="{{$coupon->coupon_code}}" placeholder="Enter coupon code" />
        @error('coupon_code')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Status</label>
        <select class="form-control" id="status" name="status">
            <option value="selected" >slected </option>
            <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>Inactive</option>
        </select>

        @error('status')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Valid From</label>
        <input type="date" class="form-control" id="valid_from" name="valid_from" value="{{ $coupon->valid_from }}" />
        @error('valid_from')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Valid To</label>
        <input type="date" class="form-control" id="valid_to" name="valid_to" value="{{ $coupon->valid_to }}" />
        @error('valid_to')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Discount Amount</label>
        <input type="number" class="form-control" id="coupon_discount" name="coupon_discount" value="{{ $coupon->coupon_discount }}" placeholder="Enter discount amount" />
        @error('coupon_discount')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="card-action">
        <button class="btn btn-success">Update✅</button>
        <button class="btn btn-danger">Cancel</button>
    </div>

</form>
@endsection

