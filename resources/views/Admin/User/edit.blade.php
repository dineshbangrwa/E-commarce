@extends('admin/layout')
@section('title', 'Edit - User')

@section('content')
<style>
    .error{
        color: red;
    } 
</style>
<form action="{{route('users.update',$user->id)}}" method="POST" id="form" enctype="multipart/form-data">
    @csrf 
    @method('put')
    <div class="form-group">
      
        <label for="">name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" placeholder="Enter name" />
        @error('name')
            <div class="error">{{$message}}</div>
        @enderror
    </div>
     <div class="form-group">
        <label for="">email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" placeholder="Enter email" />
        @error('email')
            <div class="error">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="defaultSelect">Gender</label>
        <select class="form-select form-control" id="gender" name="gender" >
          <option value="">selected gender</option>
          <option value="1"{{ $user->gender == '1'? 'selected':'' }}>Male</option>
          <option value="2" {{ $user->gender == '2'? 'selected':'' }}>Female</option>
          
        </select>
        @error('status')
            <div class="error">{{$message}}</div>
        @enderror
      </div>
       <div class="form-group">
        <label for=""> Uplode:Image</label >
        <input type="file" class="form-control" id="image"  value="{{$user->image}}" name="image"/>
        <img id="preview" src="{{ $user->getFirstMediaUrl('image') }}" alt="Current Image" style="max-width: 70px; margin-top: 7px;">
        @error('image')
            <div class="error">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">phone</label>
        <input type="number" class="form-control" id="phone" name="phone" value="{{$user->phone}}" placeholder="Enter phone" />
        @error('phone')
            <div class="error">{{$message}}</div>
        @enderror
    </div>
   
    <div class="form-group">
        <label for="">password</label>
        <input type="password" class="form-control" id="password" name="password" value="{{$user->password}}" placeholder="Enter password" />
        @error('password')
            <div class="error">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Can you give a Role</label>

     </div>
   @php
      $per = $user->roles->pluck('name')->toArray();
  @endphp
      @foreach ($roles as $role)
        
        <div class="form-check form-check-inline">
          
            <label class="form-check-label" for="inlineCheckbox3">{{$role->name}}</label>
            <input class="form-check-input" name="roles[]" type="checkbox" id="name" value="{{$role->name}}" {{in_array($role->name,$per)? 'checked': ''}}>
            {{-- @if ($pre+1) % 9==0  @endif> --}}
        </div>
        @endforeach

 
    <div class="card-action">
        <button class="btn btn-success">update</button>
        <button class="btn btn-danger">Cancel</button>
      </div>
</form>

@endsection