@extends('admin/layout')

@section('title', 'Dashboard - User')

@section('content')

<div class="card">
    <a href="{{ route('users.create') }}" ><button class="btn btn-primary" disabled="disabled">ADD User</button></a>

    <div class="card-header">
        <div class="card-title">User</div>
    </div>
    <div class="card-body">

        <table class="table table-striped mt-3 data-table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Image</th>
                    <th scope="col">Phone</th>
                    <th scope="col">IS_Admin</th>
                    <th scope="col">role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
        
    var table = $('.data-table').DataTable({
        // processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'image', name: 'image'},
            {data: 'phone', name: 'phone'},
            {data: 'is_admin', name: 'is_admin'},
               {data: 'role', name: 'role'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
        
  });
        </script>



    </div>
</div>
@endsection