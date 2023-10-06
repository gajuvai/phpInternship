@extends('layouts.app')

@section('title', __('Create Post'))

@section('css')

    <style>
        .input-group-append {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                Create a Post
            </h3>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="col-6 pt-4">

                    <form method="post" action="{{ route('post.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <input type="text" class="form-control" id="content" name="content">
                        </div>
                        <div class="mb-3">
                            <label for="published_at" class="form-label">Published At</label>
                            <div class="col-5">
                                <div class="input-group date" id="datepicker">
                                    <!-- Remove duplicate id="date" -->
                                    <input type="text" class="form-control" id="published_at" name="published_at" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <!-- Font Awesome Calendar Icon -->
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="author" name="author">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('post.index') }}" class="btn btn-primary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            // Initialize the datepicker
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                autoclose: true // Automatically close the datepicker when a date is selected
            });
        });
    </script>
@endsection
