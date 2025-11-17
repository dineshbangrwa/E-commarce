@extends('admin/layout')
@section('title', 'Edit - Currency')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('enquiry.update',$enquiry->id) }}" method="POST" enctype="multipart/form-data">
    @csrf 
    @method('put')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $enquiry->name}}" placeholder="Enter name">
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">email</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ $enquiry->email}}" placeholder="Enter email">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

  
    <div class="form-group">
        <label for="phone">phone</label>
        <input type="number" class="form-control" name="phone" id="phone" value="{{ $enquiry->phone}}" placeholder="Enter meta tag">
        @error('phone')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
   

    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control" name="message" id="message" rows="3" placeholder="Enter meta description">{{ $enquiry->message}}</textarea>
        @error('message')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="card-action">
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('enquiry.index') }}" class="btn btn-danger">Cancel</a>
    </div>
</form>
@endsection
