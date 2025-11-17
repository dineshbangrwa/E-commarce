@extends('admin/layout')
@section('title', 'Dashboard - Page')
@section('content')

<div class="card">

      <a href="{{ route('page.create') }}">
        <button class="btn btn-info">Add Page</button>
    </a>


    <div class="card-header">
        <div class="card-title">Reviews</div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        {{-- <th scope="col">Show_in_menu</th>
                        <th scope="col">Show_in_footer</th> --}}
                        <th scope="col">Description</th>
                        <th scope="col">Meta_tag</th>
                        <th scope="col">Meta_title</th>
                        <th scope="col">Meta_description</th>
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
               
                serverSide: true,
                ajax: "{{ route('page.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
                    {data: 'status', name: 'status'},
                    // {data: 'show_in_menu', name: 'show_in_menu'},
                    // {data: 'show_in_footer', name: 'show_in_footer'},
                    {data: 'description', name: 'description'},
                    {data: 'meta_tag', name: 'meta_tag'},
                    {data: 'meta_title', name: 'meta_title'},
                    {data: 'meta_description', name: 'meta_description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
        </script>

    </div>
</div>

@endsection
