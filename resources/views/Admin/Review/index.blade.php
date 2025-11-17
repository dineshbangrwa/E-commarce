@extends('admin/layout')
@section('title', 'Dashboard - Review')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Reviews</div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product</th>
                        <th>Reviewer</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Approved</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <script type="text/javascript">
            $(function() {
                    var table = $('.data-table').DataTable({
                        // processing: true,
                        serverSide: true,
                        ajax: "{{ route('reviews.index') }}",
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'product_name',
                                name: 'product.name'
                            },
                            {
                                data: 'reviewer',
                                name: 'reviewer'
                            },
                            {
                                data: 'rating',
                                name: 'rating',
                                render: function(data, type, row) {
                                    let stars = '';
                                    for (let i = 1; i <= 5; i++) {
                                        if (i <= data) {
                                            stars += '<span style="color:#ff9900">&#9733;</span>';
                                        } else {
                                            stars += '<span style="color:#ccc">&#9733;</span>';
                                        }
                                    }
                                    return stars;
                                }
                            },
                            {
                                data: 'comment',
                                name: 'comment',
                                render: function(data, type, row) {
                                    return `
                                    <span class="comment-text" data-id="${row.id}">${data}</span>
                                    <textarea class="comment-input d-none form-control" data-id="${row.id}" style="width:100%;">${data}</textarea>
                                `;
                                }
                            },
                            {
                                data: 'approved',
                                name: 'approved'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });

                    $('.data-table').on('click', '.btn-edit', function() {
                        var id = $(this).data('id');
                        $(`.comment-text[data-id="${id}"]`).addClass('d-none');
                        $(`.comment-input[data-id="${id}"]`).removeClass('d-none').focus();
                        $(this).addClass('d-none');
                        $(`.btn-update[data-id="${id}"]`).removeClass('d-none');
                    });


                    $('.data-table').on('click', '.btn-update', function() {
                        var id = $(this).data('id');
                        var comment = $(`.comment-input[data-id="${id}"]`).val();
                        $.ajax({
                            url: `/admin/reviews/${id}`,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                comment: comment
                            },
                            success: function(response) {
                                if (response.success) {
                                    $(`.comment-text[data-id="${id}"]`).text(comment);
                                    $(`.comment-input[data-id="${id}"]`).addClass('d-none');
                                    $(`.comment-text[data-id="${id}"]`).removeClass('d-none');
                                    $(`.btn-update[data-id="${id}"]`).addClass('d-none');
                                    $(`.btn-edit[data-id="${id}"]`).removeClass('d-none');
                                    alert('Comment updated successfully!');
                                } else {
                                    alert('Update failed. Try again.');
                                }
                            },
                            error: function() {
                                alert('Something went wrong.');
                            }
                        });
                    });
                });
        </script>

    </div>
</div>
@endsection