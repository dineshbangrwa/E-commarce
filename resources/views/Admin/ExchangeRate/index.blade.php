@extends('admin/layout')
@section('title', 'Dashboard - Rate')

@section('content')

<div class="table-responsive">
    {{-- @can('user_create') --}}
    <a href="{{route('exchange_rates.create')}}" class="btn btn-info">add</a>
    {{-- @endcan --}}
    <table class="table table-bordered data-table id=" rate-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>From_currency_id</th>
                <th>To_currency_id</th>
                <th>Rate</th>

                <th colspan="2">Action</th>
            </tr>
        </thead>

    </table>
</div>
<script type="text/javascript">
    $(function () {
    var table = $('.data-table').DataTable({
        serverSide: true,
        ajax: "{{ route('exchange_rates.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'from_currency', name: 'from_currency'},
            {data: 'to_currency', name: 'to_currency'},
            {
                data: 'rate',
                name: 'rate',
                render: function(data, type, row) {
                    return `
                        <span class="rate-label" data-id="${row.id}">${data}</span>
                        <input type="text" class="form-control rate-input d-none" data-id="${row.id}" value="${data}" style="width:80px;" />
                    `;
                }
            },
            {
    data: null,
    name: 'action',
    orderable: false,
    searchable: false,
    render: function(data, type, row) {
        return `
            <button class="btn btn-sm btn-info btn-edit" data-id="${row.id}">Edit</button>
            <button class="btn btn-sm btn-success btn-update d-none" data-id="${row.id}">Update</button>

            <form method="POST" action="/admin/exchange_rates/${row.id}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this rate?');">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        `;
    }
}
        ]
    });

    // 👉 Edit button clicked
    $('.data-table').on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        $(`.rate-label[data-id="${id}"]`).addClass('d-none');
        $(`.rate-input[data-id="${id}"]`).removeClass('d-none');

        $(this).addClass('d-none'); // hide Edit
        $(`.btn-update[data-id="${id}"]`).removeClass('d-none'); // show Update
    });

    // 👉 Update button clicked
    $('.data-table').on('click', '.btn-update', function () {
        var id = $(this).data('id');
        var rate = $(`.rate-input[data-id="${id}"]`).val();

        $.ajax({
            url: `/admin/exchange_rates/${id}`,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                rate: rate
            },
            success: function (res) {
                if (res.success) {
                    // update UI
                    $(`.rate-label[data-id="${id}"]`).text(rate).removeClass('d-none');
                    $(`.rate-input[data-id="${id}"]`).addClass('d-none');
                    $(`.btn-update[data-id="${id}"]`).addClass('d-none');
                    $(`.btn-edit[data-id="${id}"]`).removeClass('d-none');
                } else {
                    alert('Update failed.');
                }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });
});

  
</script>


@endsection