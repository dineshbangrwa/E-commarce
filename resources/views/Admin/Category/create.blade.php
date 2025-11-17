@extends('admin/layout')
@section('title', 'Create - Category')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
   <div class="form-group">
        <label for="parent_category">Parent Category</label>
        <select class="form-select form-control" id="parent_category" name="parent_category[]" >
            <option value="0" >Select category </option>
            @foreach($categorys as $category)
                <option value="{{ $category->id }}"
                    {{ in_array($category->id, old('parent_category', explode(',', $product->parent_category ?? ''))) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        @error('parent_category')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
            placeholder="Enter name">
        @error('name')
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
        <label for="status">status</label>
        <select class="form-control" name="status" id="status">
            <option value="">selected status</option>
            <option value="1" {{ old('status')==1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status')==0 ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="show_in_menu">Show in Menu</label>
        <select class="form-control" name="show_in_menu" id="show_in_menu">
            <option value="">Slected Show_in_menu</option>
            <option value="1" {{ old('show_in_menu')==1 ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('show_in_menu')==0 ? 'selected' : '' }}>No</option>
        </select>
        @error('show_in_menu')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="meta_tag">Meta Tag</label>
        <input type="text" class="form-control" name="meta_tag" id="meta_tag" value="{{ old('meta_tag') }}"
            placeholder="Enter meta tag">
        @error('meta_tag')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="meta_title">Meta Title</label>
        <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
            placeholder="Enter meta title">
        @error('meta_title')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="meta_description">Meta Description</label>
        <textarea class="form-control" name="meta_description" id="meta_description" rows="3"
            placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
        @error('meta_description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="short_description">Short Description</label>
        <textarea class="form-control" name="short_description" id="short_description" rows="3"
            placeholder="Enter meta description">{{ old('short_description') }}</textarea>
        @error('short_description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
 <div class="form-group">
        <label for="description"> Description</label>
        <textarea class="form-control" name="description" id="description" rows="3"
            placeholder="Enter meta description">{{ old('description') }}</textarea>
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