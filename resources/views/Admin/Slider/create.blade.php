@extends('admin/layout')
@section('title', 'Create - Slider')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
    @csrf 

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" placeholder="Enter title">
        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="image">Upload Image</label>
        <input type="file" class="form-control" name="image" id="image">
        @error('image')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" rows="4" placeholder="Enter description">{{ old('description') }}</textarea>
        @error('description')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="card-action">
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('slider.index') }}" class="btn btn-danger">Cancel</a>
    </div>
</form>
@endsection
