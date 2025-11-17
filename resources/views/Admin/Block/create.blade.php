@extends('admin/layout')
@section('title', 'Create - Block')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('block.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
            placeholder="Enter name">
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="defaultSelect">Status</label>
        <select class="form-select form-control" id="Status" name="status">
            <option value="">selected Status</option>
            <option value="1">Enable</option>
            <option value="2">Disable</option>

        </select>
        @error('status')
        <div class="error">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="identifire">identifire</label>
        <input type="number" class="form-control" name="identifire" id="identifire" value="{{ old('identifire') }}"
            placeholder="Enter identifire">
        @error('identifire')
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
        <textarea class="form-control" name="description" id="description" rows="4"
            placeholder="Enter description">{{ old('description') }}</textarea>
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