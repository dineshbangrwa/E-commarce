@extends('admin/layout')
@section('title', 'Create - Enquiry')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('enquiry.store') }}" method="POST" enctype="multipart/form-data">
    @csrf 
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Enter name">
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">email</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

  
    <div class="form-group">
        <label for="phone">phone</label>
        <input type="number" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Enter meta tag">
        @error('phone')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
   

    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control" name="message" id="message" rows="3" placeholder="Enter meta description">{{ old('message') }}</textarea>
        @error('message')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="card-action">
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('slider.index') }}" class="btn btn-danger">Cancel</a>
    </div>
</form>
@endsection
