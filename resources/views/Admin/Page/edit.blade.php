@extends('admin/layout')
@section('title', 'Edit - Page')
@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{ route('page.update',$page->id) }}" method="POST" enctype="multipart/form-data">
    @csrf 
@method('put')
 
<div class="two-columns">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{$page->name }}" placeholder="Enter name">
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="image">Upload Image</label>
        <input type="file" class="form-control-file" name="image" id="image">
        <img id="preview" src="{{ $page->getFirstMediaUrl('image') }}" loading="lazy" alt="Current Image" style="max-width: 70px; margin-top: 7px;">

        @error('image')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" name="status" id="status">
            <option  value=""  >selected Status</option>
            <option value="1" {{$page->status == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{$page->status == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="show_in_menu">Show in Menu</label>
        <select class="form-control" name="show_in_menu" id="show_in_menu">
            <option  value="" >Slected Show_in_menu</option>
            <option value="1" {{$page->show_in_menu == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0" {{$page->show_in_menu == 0 ? 'selected' : '' }}>No</option>
        </select>
        @error('show_in_menu')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="show_in_footer">Show in Footer</label>
        <select class="form-control" name="show_in_footer" id="show_in_footer">
            <option  value="" >Slected Show_in_footer</option>

            <option value="1" {{$page->show_in_footer == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0" {{$page->show_in_footer == 0 ? 'selected' : '' }}>No</option>
        </select>
        @error('show_in_footer')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" name="description" id="description" value="{{$page->description }}" placeholder="Enter meta tag">
        @error('description')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="meta_tag">Meta Tag</label>
        <input type="text" class="form-control" name="meta_tag" id="meta_tag" value="{{$page->meta_tag }}" placeholder="Enter meta tag">
        @error('meta_tag')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="meta_title">Meta Title</label>
        <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{$page->meta_title }}" placeholder="Enter meta title">
        @error('meta_title')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="meta_description">Meta Description</label>
        <textarea class="form-control" name="meta_description" id="meta_description" rows="3" placeholder="Enter meta description">{{$page->meta_description }}</textarea>
        @error('meta_description')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
</div>
    <div class="card-action">
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="" class="btn btn-danger">Cancel</a>
    </div>
    
</form>
@endsection
