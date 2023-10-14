@extends('layouts.app')

@section('title', __('User Management'))

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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Permission List</h1>
                    </div>
                    <div class="card-tools ml-auto">
                        <a href="{{ route('permission.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-3"></i>Add Permission</a>
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
                                    <th>S.N</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key=>$permission)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->description}}</td>
                                        <td>
                                            <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('permission.delete', $permission->id) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
