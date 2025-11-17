@extends('admin/layout')
@section('title', 'Dashboard - Category')


@section('content')

<div class="card">

    <a href="{{ route('category.create') }}"><button class="btn btn-info" disabled="disabled">ADD Category</button></a>

    <div class="card-header">
        <div class="card-title">Category</div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Parent_category</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Show_in_menu</th>
                        <th scope="col">Url_key</th>
                        <th scope="col">Meta_tag</th>
                        <th scope="col">Meta_title</th>
                        <th scope="col">Meta_description</th>
                        <th scope="col">Short_description</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
            <script type="text/javascript">
                $(function () {
        
    var table = $('.data-table').DataTable({
        // processing: true,
        serverSide: true,
        ajax: "{{ route('category.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'parent_category', name: 'parent_category'},
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},

            {data: 'status', name: 'status'},
            {data: 'show_in_menu', name: 'show_in_menu'},
            {data: 'url_key', name: 'url_key'},
            {data: 'meta_tag', name: 'meta_tag'},
            {data: 'meta_title', name: 'meta_title'},
            {data: 'meta_description', name: 'meta_description'},
            {data: 'short_description', name: 'short_description'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
        
  });
            </script>



        </div>
    </div>
    @endsection