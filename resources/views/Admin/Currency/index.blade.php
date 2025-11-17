@extends('admin/layout')
@section('title', 'Dashboard - Currency')

@section('content')

<div class="table-responsive">
  {{-- @can('user_create') --}}
    <a href="{{route('currency.create')}}" class="btn btn-info">add</a>
    {{-- @endcan --}}
    <table class="table table-bordered data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Code</th>
          <th>Symbol</th>
          <th>is_default</th>
              

          <th colspan="2">Action</th>
        </tr>
      </thead>
      
    </table>
  </div>
  <script type="text/javascript">

    $(function () {
  
        
  
      var table = $('.data-table').DataTable({
  
          // processing: true,
  
          serverSide: true,
          
          ajax: "{{ route('currency.index') }}",
  
          columns: [
  
              {data: 'id', name: 'id'},
  
              {data: 'name', name: 'name'},
  
              {data: 'code', name: 'code'},
              {data: 'symbol', name: 'symbol'},
              {data: 'is_default', name: 'is_default'},
           
              
              {data: 'action', name: 'action', orderable: false, searchable: false},
  
          ]
  
      });
  
    });
  
  </script>
  
  
@endsection

