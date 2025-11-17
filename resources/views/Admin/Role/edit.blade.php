@extends('admin/layout')

@section('title', 'Edit - Role')

@section('content')
<style>
    .error {
        color: red;
    }
</style>

<form action="{{route('role.update',$roles->id)}}" method="POST" id="form">
    @csrf
    @method('put')
    <div class="form-group" id="form-fields">
        <label for="">NAME</label>
        <input type="text" class="form-control" id="name" name="name"  value="{{ $roles->name }}"
            placeholder="Enter name" />
        @error('name')
        <div class="error">{{$message}}</div>
        @enderror
    </div>

    <!-- Select All Button -->
    <div class="form-check form-check-inline">
        <button type="button" class="btn btn-info" id="select-all">Select All</button>
    </div>

     @php
        $per =$roles->permissions->pluck('name')->toArray();
    @endphp
    
    @foreach ($permissions as $pre=>$permission)
    <div class="form-check form-check-inline">
        <label class="form-check-label" for="inlineCheckbox3">{{$permission->name}}</label>
        <input class="form-check-input" type="checkbox" name="permissions[]" id="permission{{$pre}}" value="{{$permission->name}}"{{in_array($permission->name , $per)?'checked':''}} >
    </div>
    @endforeach
    

    <div class="card-action">
        <button class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" id="cancel">Cancel</button>
    </div>
</form>

<script>
    document.getElementById('select-all').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        const isChecked = Array.from(checkboxes).some(checkbox => !checkbox.checked);
        checkboxes.forEach(checkbox => checkbox.checked = isChecked);
    });
</script>

@endsection
