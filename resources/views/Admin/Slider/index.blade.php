@extends('admin/layout')

@section('title', 'Dashboard - Slider')

@section('content')

<div class="card">
   
    <a href="{{ route('slider.create') }}" ><button class="btn btn-success" disabled="disabled">ADD Slider</button></a>

    <div class="card-header">
        <div class="card-title">Slider</div>
    </div>
    <div class="card-body">

        <table class="table table-striped mt-3 data-table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    {{-- <th scope="col">url_key</th> --}}
                    <th scope="col">image</th>
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
        ajax: "{{ route('slider.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            // {data: 'url_key', name: 'url_key'},
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