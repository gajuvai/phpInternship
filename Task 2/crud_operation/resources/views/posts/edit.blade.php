<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <!-- Include Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .input-group-append {
            cursor: pointer;
        }
    </style>

    <title>Edit Post</title>
</head>
<body>
    <div class="container">
        <div class="col-6 pt-4">
            <h1>Edit a Post</h1>
            <form method="post" action="{{ route('post.update', $post->id) }}">
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
                            <!-- Remove duplicate id="date" -->
                            <input type="text" class="form-control" id="published_at" name="published_at" value="{{ $post->published_at }}" />
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
                    <input type="text" class="form-control" id="author" name="author" value="{{ $post->author }}" />
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('post.index') }}" class="btn btn-primary">Cancel</a>
            </form>
        </div>
    </div>

    <!-- Include Bootstrap, Bootstrap Datepicker, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize the datepicker
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                autoclose: true // Automatically close the datepicker when a date is selected
            });
        });
    </script>
</body>
</html>
