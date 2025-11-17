@extends('admin/layout')

@section('title', 'Create - Permission')
@section('content')
<style>
    .error {
        color: red;
    }
</style>
<button class="add btn btn-outline-success m-2" id="add" >ADD</button>

<form action="{{route('permission.store')}}" method="POST" id="form">
    @csrf
    <div class="form-group" id="form-fields">
        <label for="">NAME</label>
        <input type="text" class="form-control" id="name" name="name[]" 
            placeholder="Enter name" />
        @error('name')
        <div class="error">{{$message}}</div>
        @enderror
    </div>

    <div class="card-action">
        <button class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" id="cancel">Cancel</button>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 

<script>
    $(document).ready(function(){
        $('.add').click(function(){
            $('#form-fields').append(
                `<div class="form-group">
                    <label for="">NAME</label>
                    <input type="text" class="form-control" name="name[]" placeholder="Enter name" />
                    <button type="button" class="remove btn btn-square btn-outline-info m-2">X</button>
                </div>`
            );
        });

        $('#form-fields').on('click', '.remove', function(){
            $(this).closest('.form-group').remove();
        });
    });
</script>
@endsection
