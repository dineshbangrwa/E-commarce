@extends('admin/layout')
@section('title', 'Dashboard - Coupon')

@section('content')

<div class="table-responsive">
  {{-- @can('user_create') --}}
    <a href="{{route('coupon.create')}}" class="btn btn-info">add</a>
    {{-- @endcan --}}
    <table class="table table-bordered data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>title</th>
          <th>coupen_code</th>
          <th>status</th>
          <th>valid_from</th>
          <th>valid_to</th>
          <th>coupon_discount</th>
       

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
          
          ajax: "{{ route('coupon.index') }}",
  
          columns: [
  
              {data: 'id', name: 'id'},
  
              {data: 'title', name: 'title'},
  
              {data: 'coupon_code', name: 'coupon_code'},
              {data: 'status', name: 'status'},
              {data: 'valid_from', name: 'valid_from'},
              {data: 'valid_to', name: 'valid_to'},
              {data: 'coupon_discount', name: 'coupon_discount'},
              
             

  
              {data: 'action', name: 'action', orderable: false, searchable: false},
  
          ]
  
      });
  
    });
  
  </script>
  
  
@endsection

