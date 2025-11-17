@extends('Admin.layout')
@section('title', 'Edit Product - Translation')


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container">
        <h2>Edit Translation</h2>
        <div id="message" style="display:none;" class="alert"></div>

        <div class="form-group mb-3">
            <label for="language" class="form-label"><strong>Choose Language</strong></label>
            <select id="language" name="language" class="form-select">
                @foreach ($languages as $language)
                    <option value="{{ $language->code }}">{{ $language->language }}</option>
                @endforeach
            </select>
        </div>

        <form id="editTranslationForm">
            @csrf
            <input type="hidden" id="block_id" value="{{ $product->id }}">

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="short_description">Short Description</label>
                <textarea name="short_description" id="short_description" class="form-control">{{ $product->short_description }}</textarea>
            </div>

            <button type="button" id="save-btn" class="btn btn-primary">Update Translation</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            function showMessage(type, text) {
                var $msg = $('#message');
                $msg.removeClass('alert-success alert-danger').hide();
                if (type === 'success') {
                    $msg.addClass('alert-success').text(text).show();
                } else {
                    $msg.addClass('alert-danger').text(text).show();
                }
            }

            function loadTranslation(langCode) {
                var productId = $('#block_id').val();
                $.ajax({
                    url: '/product/translation/' + productId,
                    type: 'GET',
                    data: {
                        lang: langCode
                    },
                    success: function(response) {
                        $('#name').val(response.name || '');
                        $('#description').val(response.description || '');
                        $('#short_description').val(response.short_description || '');
                    },
                    error: function(xhr) {
                        showMessage('error', "⚠️ Error loading translation!");
                    }
                });
            }
            
            $('#language').change(function() {
                loadTranslation($(this).val());
            });

            $('#save-btn').click(function() {
                var productId = $('#block_id').val();
                var langCode = $('#language').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/product/translation/' + productId,
                    type: 'POST',
                    data: {
                        language: langCode,
                        name: $('#name').val(),
                        description: $('#description').val(),
                        short_description: $('#short_description').val()
                    },
                    success: function(response) {
                        showMessage('success', "✅ " + (response.message || "Saved!"));
                    },
                    error: function(xhr) {
                        var msg = "❌ Save failed: ";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            msg += Object.values(xhr.responseJSON.errors).join(' / ');
                        } else {
                            msg += xhr.status + " " + xhr.statusText;
                        }
                        showMessage('error', msg);
                    }
                });
            });

            // Load default language on page load
            loadTranslation($('#language').val());
        });
    </script>
@endsection
