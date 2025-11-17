@extends('admin/layout')
@section('title', 'Dashbaord - Index')

@section('content')

<div class="card">

    <a href="{{ route('enquiry.create') }}"><button class="btn btn-info" disabled="disabled">ADD Enquiry</button></a>

    <div class="card-header">
        <div class="card-title">Enquiry</div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">phone</th>
                        <th scope="col">message</th>
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
        ajax: "{{ route('enquiry.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'message', name: 'message'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
        
  });
            </script>



        </div>
    </div>
    @endsection