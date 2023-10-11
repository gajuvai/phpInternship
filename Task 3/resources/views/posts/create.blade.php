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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Post</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="col-6 pt-4">

                    <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
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
                        <label class="form-label">Upload Images</label>
                        <div class="mb-3 increment">
                            <div class="row control-group">
                                <div class="col-md-5">
                                    <label for="caption" class="form-label">Caption</label>
                                    <input type="text" class="form-control" id="caption" name="caption[]" />
                                </div>
                                <div class="col-md-5">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image[]" accept="image/*" />
                                </div>
                                <div class="col-md-2">
                                    {{-- <label for="image" class="form-label"></label> --}}
                                    <button class="btn btn-success mt-4" id="addfile" type="button">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 clone"  style="display: none">
                            <div class="row control-group">
                                <div class="col-md-5">
                                    <label for="caption" class="form-label">Caption</label>
                                    <input type="text" class="form-control" id="caption" name="caption[]" />
                                </div>
                                <div class="col-md-5">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image[]" accept="image/*" />
                                </div>
                                <div class="col-md-2">
                                    {{-- <label for="image" class="form-label"></label> --}}
                                    <button class="btn btn-danger mt-4" id="removefile" type="button">-</button>
                                </div>
                            </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
        // Initialize the datepicker
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd', // Set the desired date format
            autoclose: true // Automatically close the datepicker when a date is selected
        });

        $("#addfile").click(function() {
            var html = $(".clone").html();
            $(".increment").after(html);
        });

        $("body").on("click", "#removefile", function() {
            $(this).parents(".control-group").remove();
        });
    });
    </script>
@endsection
