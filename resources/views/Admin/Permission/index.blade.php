@extends('admin/layout')
@section('title', 'Dashboard - Permission')

@section('content')
<div class="table-responsive">
    <table class="table table-bordered data-table">
    <a href="{{route('permission.create')}}" class="btn btn-info">Add</a>
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
</table>
</div>
</div>
    <script type="text/javascript">

        $(function () {
      
          var table = $('.data-table').DataTable({
      
              // processing: true,
      
              serverSide: true,
      
              ajax: "{{ route('permission.index') }}",
      
              columns: [
      
                  {data: 'id', name: 'id'},
                  {data: 'name', name: 'name'},
               
                  
      
                  {data: 'action', name: 'action', orderable: false, searchable: false},
      
              ]
      
          });
      
            
      
        });
      
      </script>
 

@endsection

