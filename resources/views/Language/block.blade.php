@extends('Admin.layout')
@section('title', 'Edit Block - Translation')

@section('content')
    {{-- ✅ CSRF Token ensure karne ke liye --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card shadow-lg p-4">
        <div class="card-header bg-info text-black">
            <h5 style="text-align:center">Edit Block Details (Translation)</h5>
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
                <input type="hidden" id="block_id" value="{{ $block->id }}">

                <div class="form-group mb-3">
                    <label for="name" class="form-label"><strong>Name</strong></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $block->name }}">
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label"><strong>Status</strong></label>
                    <input type="text" class="form-control" id="status" name="status" value="{{ $block->status }}">
                </div>

                <div class="form-group mb-3">
                    <label for="identifire" class="form-label"><strong>Identifier</strong></label>
                    <input type="text" class="form-control" id="identifire" name="identifire"
                        value="{{ $block->identifire }}">
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label"><strong>Description</strong></label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $block->description }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" id="save-btn" class="btn btn-success">💾 Save Translation</button>
                    <a href="{{ route('block.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {


            function loadTranslation(langCode) {
                var blockId = $('#block_id').val();
                $.ajax({
                    url: '/block/translation/' + blockId,
                    type: 'GET',
                    data: {
                        lang: langCode
                    },
                    success: function(response) {
                        $('#name').val(response.name);
                        $('#status').val(response.status);
                        $('#identifire').val(response.identifire);
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
                var blockId = $('#block_id').val();
                var langCode = $('#language').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/block/translation/' + blockId,
                    type: 'POST',
                    data: {
                        language: langCode,
                        name: $('#name').val(),
                        status: $('#status').val(),
                        identifire: $('#identifire').val(),
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
