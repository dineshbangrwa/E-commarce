@extends('admin/layout')
@section('title', 'Dashboard - Block')


@section('content')

<div class="card">
      
    
    <div class="card-header">
        <div class="card-title">Block</div>
    </div>
    <a href="{{ route('block.create') }}" ><button class="btn btn-black" disabled="disabled">ADD Block</button></a>
    <div class="card-body">

        <table class="table table-striped mt-3 data-table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Identifire</th>
                    <th scope="col">Image</th>
                    <th scope="col">description</th>
                    <th scope="col">Action</th>
                    
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <script type="text/javascript">
            $(function () {
        
    var table = $('.data-table').DataTable({
        // processing: true,
        serverSide: true,
        ajax: "{{ route('block.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'status', name: 'status'},
            {data: 'identifire', name: 'phone'},
            {data: 'image', name: 'image'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
        
  });
        </script>



    </div>
</div>
@endsection