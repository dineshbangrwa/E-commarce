@extends('admin/layout')
@section('title', 'Create - Currency')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('currency.store') }}" method="POST" id="form">
    @csrf 

    <div class="form-group">
        <label for="">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name" />
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
 
    <div class="form-group">
        <label for=""> Code</label>
        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" placeholder="Enter code" />
        @error('code')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    
    <div class="form-group">
        <label for="">Symbol</label>
        <input type="text" class="form-control" id="symbol" name="symbol" value="{{ old('symbol') }}" />
        @error('symbol')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

       <div class="form-group">
        <label for="">is_Default</label>
        <select class="form-control" id="is_default" name="is_default">
            <option  >slected </option>
            <option value="1">Yse</option>
            <option value="0">No</option>
        </select>
        @error('status')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
   

    <div class="card-action">
        <button class="btn btn-success">Submit</button>
        <button class="btn btn-danger">Cancel</button>
    </div>

</form>
@endsection

