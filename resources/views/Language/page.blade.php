@extends('Admin.layout')
@section('title', 'Edit Page - Translation')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card shadow-lg p-4">
        <div class="card-header bg-info text-black">
            <h5 style="text-align:center">Edit Page Details (Translation)</h5>
        </div>

        <div class="card-body">
            <div class="form-group mb-3">
                <label for="language" class="form-label"><strong>Choose Language</strong></label>
                <select id="language" name="language" class="form-select">
                    @foreach ($languages as $language)
                        <option value="{{ $language->code }}">{{ $language->language }}</option>
                    @endforeach
                </select>
            </div>
            <form id="block-form">
                @csrf
                <input type="hidden" id="page_id" value="{{ $page->id }}">

                <div class="form-group mb-3">
                    <label for="name" class="form-label"><strong>Name</strong></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $page->name }}">
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label"><strong>Description</strong></label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $page->description }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="meta_title" class="form-label"><strong>Meta Title</strong></label>
                    <textarea class="form-control" id="meta_title" name="meta_title" rows="4">{{ $page->meta_title }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="meta_description" class="form-label"><strong>Meta Description</strong></label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="4">{{ $page->meta_description }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" id="save-btn" class="btn btn-success">💾 Save Translation</button>
                    <a href="{{ route('page.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            function loadTranslation(langCode) {
                var pageId = $('#page_id').val();
                $.ajax({
                    url: '/page/translation/' + pageId,
                    type: 'GET',
                    data: {
                        lang: langCode
                    },
                    success: function(response) {
                        $('#name').val(response.name);
                        $('#description').val(response.description);
                        $('#meta_title').val(response.meta_title);
                        $('#meta_description').val(response.meta_description);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("⚠️ Error loading translation!");
                    }
                });
            }

            $('#language').change(function() {
                loadTranslation($(this).val());
            });

            $('#save-btn').click(function() {
                var pageId = $('#page_id').val();
                var langCode = $('#language').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            
                $.ajax({
                    url: '/page/translation/' + pageId,
                    type: 'POST',
                    data: {
                        language: langCode,
                        name: $('#name').val(),
                        description: $('#description').val(),
                        meta_title: $('#meta_title').val(),
                        meta_description: $('#meta_description').val()
                    },
                    success: function(response) {
                        alert("✅ " + response.message);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("❌ Save failed: " + xhr.status + " " + xhr.statusText);
                    }
                });
            });

            loadTranslation($('#language').val());

        });
    </script>
@endsection
