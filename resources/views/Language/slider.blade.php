@extends('Admin.layout')
@section('title', 'Edit Slider - Translation')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card shadow-lg p-4">
        <div class="card-header bg-info text-black">
            <h5 style="text-align:center">Edit Slider Details (Translation)</h5>
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
                <input type="hidden" id="slider_id" value="{{ $slider->id }}">

                <div class="form-group mb-3">
                    <label for="title" class="form-label"><strong>Title</strong></label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $slider->title }}">
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label"><strong>Description</strong></label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $slider->description }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" id="save-btn" class="btn btn-success">💾 Save Translation</button>
                    <a href="{{ route('slider.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {


            function loadTranslation(langCode) {
                var sliderId = $('#slider_id').val();
                $.ajax({
                    url: '/slider/translation/' + sliderId,
                    type: 'GET',
                    data: {
                        lang: langCode
                    },
                    success: function(response) {
                        $('#title').val(response.title);
                        $('#description').val(response.description);
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
                var sliderId = $('#slider_id').val();
                var langCode = $('#language').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/slider/translation/' + sliderId,
                    type: 'POST',
                    data: {
                        language: langCode,
                        title: $('#title').val(),
                        description: $('#description').val()
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
