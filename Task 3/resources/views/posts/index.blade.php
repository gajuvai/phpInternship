@extends('layouts.app')

@section('title', __('Post Management'))

@section('css')
    <!-- Add DataTables CSS here -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="{{ asset('assets/plugins/jquery/jquery.js') }}"></script>
    <script>
        // Automatically close the success alert after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
    <style>
        .close {
            font-size: 1rem;
        }
    </style>
@endsection

@section('content')

    <div class="card card-default color-palette-box">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Post List</h1>
                    </div>
                    <div class="card-tools ml-auto">
                        <a href="{{ route('post.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-3"></i>Add Post</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="col-12">
                    @if (session('msg') != '')
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <strong>Success!</strong> {{ session('msg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div>
                        <table border="1" id="myTable" style="border-collapse: collapse">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Author</th>
                                    <th>Published At</th>
                                    <th data-orderable="false">Image</th>
                                    <th data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->content }}</td>
                                        <td>{{ $post->author }}</td>
                                        <td>{{ Carbon\Carbon::parse($post->published_at)->format('j F Y') }}</td>
                                        <td>
                                            @foreach ($post->postHasImages as $image)
                                                @if($image->image)
                                                    <img height="70" width="70" src="{{ asset('uploads/posts/'.$image->image) }}" alt="image" />
                                                @else
                                                    N/A
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('scripts')
    <!-- Add DataTables JavaScript here -->

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
