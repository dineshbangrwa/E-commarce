@extends('admin/layout')
@section('title', 'Dashboard - Product')

@section('content')
<div class="card">
    <a href="{{ route('product.create') }}">
        <button class="btn btn-info">Add Product</button>
    </a>

    <div class="card-header">
        <div class="card-title">Product</div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Banner_image</th>
                        <th>Is Featured</th>
                        {{-- <th>Stock Status</th> --}}
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Special Price</th>
                        <th>Special Price From</th>
                        <th>Special Price To</th>
                        <th>Short Description</th>
                        <th>Description</th>
                        <th>Related Product</th>
                        {{-- <th>URL Key</th> --}}
                        <th>Meta Tag</th>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            // processing: true,
            serverSide: true,
            ajax: "{{ route('product.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'image', name: 'image'},
                {data: 'banner_image', name: 'banner_image'},
                {data: 'is_featured', name: 'is_featured'},
                // {data: 'stock', name: 'stock'},
                {data: 'weight', name: 'weight'},
                {data: 'price', name: 'price'},
                {data: 'special_price', name: 'special_price'},
                {data: 'special_price_from', name: 'special_price_from'},
                {data: 'special_price_to', name: 'special_price_to'},
                {data: 'short_description', name: 'short_description'},
                {data: 'description', name: 'description'},
                {data: 'related_product', name: 'related_product'},
                // {data: 'url_key', name: 'url_key'},
                {data: 'meta_tag', name: 'meta_tag'},
                {data: 'meta_title', name: 'meta_title'},
                {data: 'meta_description', name: 'meta_description'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endsection