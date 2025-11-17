@extends('admin/layout')
@section('title', 'Dashboard - Role')


@section('content')
<div class="table-responsive">
    <table class="table table-bordered data-table">
    <a href="{{route('role.create')}}" class="btn btn-info">Add</a>
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Permission</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
   
    <script type="text/javascript">

        $(function () {
            
          var table = $('.data-table').DataTable({
      
              // processing: true,
      
              serverSide: true,
      
              ajax: "{{ route('role.index') }}",
      
              columns: [
      
                  {data: 'id', name: 'id'},
                  {data: 'name', name: 'name'},
              {data: 'permissions', name: 'permissions'},
               
                  
      
                  {data: 'action', name: 'action', orderable: false, searchable: false},
      
              ]
      
          });
      
            
      
        });
      
      </script>
  </table>

@endsection

