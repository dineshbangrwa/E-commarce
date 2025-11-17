@extends('admin/ayout')
@section('title', 'Edit - Permission')


@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{route('permission.update',$permission->id)}}" method="POST" id="form">
    @csrf
    @method('put')
    <div class="form-group" id="form-fields">
        <label for="">NAME</label>
        <input type="text" class="form-control" id="name" name="name" 
            placeholder="Enter name"  value="{{ $permission->name }}"/>
        @error('name')
        <div class="error">{{$message}}</div>
        @enderror
    </div>

    <div class="card-action">
        <button class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" id="cancel">Cancel</button>
    </div>
</form>

@endsection
