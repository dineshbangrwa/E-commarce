@extends('admin/layout')
@section('title', 'Create - User')

@section('content')
<style>
    .error {
        color: red;
    }
</style>
<form action="{{route('users.store')}}" method="POST" id="form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">

        <label for="">name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"
            placeholder="Enter name" />
        @error('name')
        <div class="error">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}"
            placeholder="Enter email" />
        @error('email')
        <div class="error">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="defaultSelect">Gender</label>
        <select class="form-select form-control" id="gender" name="gender">
            <option value="">selected gender</option>
            <option value="1">Male</option>
            <option value="2">Female</option>

        </select>
        @error('status')
        <div class="error">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for=""> Uplode:Image</label>
        <input type="file" class="form-control" id="image" value="{{old('image')}}" name="image" />
        @error('image')
        <div class="error">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">phone</label>
        <input type="number" class="form-control" id="phone" name="phone" value="{{old('phone')}}"
            placeholder="Enter phone" />
        @error('phone')
        <div class="error">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">password</label>
        <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}"
            placeholder="Enter password" />
        @error('password')
        <div class="error">{{$message}}</div>
        @enderror
    </div>

     <div class="form-group">
        <label for="">Can you give a Role</label>

     </div>
    @foreach ($roles as $role)
        
        <div class="form-check form-check-inline">
          
            <label class="form-check-label" for="inlineCheckbox3">{{$role->name}}</label>
            <input class="form-check-input" name="roles[]" type="checkbox" id="name" value="{{$role->name}} {{old('roles')}}" >
            {{-- @if ($pre+1) % 9==0  @endif> --}}
            @error('roles')
                <div class="error">{{$message}}</div>
            @enderror
        </div>
        @endforeach

    <div class="card-action">
        <button class="btn btn-success">Submit</button>
        <button class="btn btn-danger">Cancel</button>
    </div>
</form>

@endsection