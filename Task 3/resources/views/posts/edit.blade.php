@extends('layouts.app')

@section('title', __('Edit Post'))

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
                            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" />
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <input type="text" class="form-control" id="content" name="content" value="{{ $post->content }}" />
                        </div>
                        <div class="mb-3">
                            <label for="published_at" class="form-label">Published At</label>
                            <div class="col-5">
                                <div class="input-group date" id="datepicker">
                                    <input type="text" class="form-control" id="published_at" name="published_at" value="{{ $post->published_at }}" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <label class="form-label">Upload Images</label>
                        <div class="mb-3 increment">
                            @if($post->postHasImages->count() > 0)
                                @foreach ($post->postHasImages as $index => $image)
                                    <div class="row control-group">
                                        <div class="col-md-4">
                                            <label for="caption" class="form-label">Caption</label>
                                            <input type="text" id="caption" class="form-control" name="caption[]" value="{{ $image->caption }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" id="image" class="form-control" name="image[]" accept="image/*" />
                                            <input type="hidden" name="oldImage[]" value="{{$image->image}}"  />
                                        </div>
                                        <div class="col-md-2">
                                            <img height="70" width="70" src="{{ asset('uploads/posts/'.$image->image) }}" alt="image" />
                                        </div>
                                        <div class="col-md-2">
                                            @if ($index == 0)
                                                <button class="btn btn-success mt-4" id="addfile" type="button">+</button>
                                            @else
                                                <button class="btn btn-danger mt-4" id="removefile" type="button">-</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row control-group">
                                    <div class="col-md-4">
                                        <label for="caption" class="form-label">Caption</label>
                                        <input type="text" id="caption" class="form-control" name="caption[]" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" id="image" class="form-control" name="image[]" accept="image/*" />
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success mt-4" id="addfile" type="button">+</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3 clone" style="display: none">
                            <div class="row control-group">
                                <div class="col-md-4">
                                    <label for="caption" class="form-label">Caption</label>
                                    <input type="text" id="caption" class="form-control" name="caption[]" />
                                </div>
                                <div class="col-md-4">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" id="image" class="form-control" name="image[]" accept="image/*" />
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger mt-4" id="removefile" type="button">-</button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('post.index') }}" class="btn btn-primary">Cancel</a>
                    </form>
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
