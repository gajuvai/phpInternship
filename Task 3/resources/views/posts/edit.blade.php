@extends('layouts.app')

@section('title', __('Edit post'))

@section('css')
    <style>
        .input-group-append {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

    <div class="card card-default color-palette-box">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Post</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 pt-2">

                        <form method="post" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $post->title }}" />
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <input type="text" class="form-control" id="content" name="content"
                                    value="{{ $post->content }}" />
                            </div>
                            <div class="mb-3">
                                <label for="published_at" class="form-label">Published At</label>
                                <div class="col-5">
                                    <div class="input-group date" id="datepicker">
                                        <!-- Remove duplicate id="date" -->
                                        <input type="text" class="form-control" id="published_at" name="published_at"
                                            value="{{ $post->published_at }}" />
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
                                <label for="image" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" />

                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('post.index') }}" class="btn btn-primary">Cancel</a>
                        </form>
                    </div>
                    <div class="col-6 pt-2">
                        <img height="300" width="300" src="{{asset('uploads/posts/'.$post->image)}}" alt="image" />
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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
