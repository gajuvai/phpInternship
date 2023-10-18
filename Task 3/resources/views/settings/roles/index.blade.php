<!-- resources/views/role/index.blade.php -->
@extends('layouts.app')

@section('title', __('Role Management'))

@section('css')
    <!-- Add DataTables CSS here -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="{{ asset('assets/plugins/jquery/jquery.js') }}"></script>
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
                        <h1>Role List</h1>
                    </div>
                    <div class="card-tools ml-auto">
                        <a href="{{ route('role.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-3"></i>Add Role</a>
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
                        <table id="myTable" class="table">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @if ($role->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">In-active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#permissionModel{{ $role->id }}">
                                                <i class="fa fa-list"></i>
                                            </a>
                                            <a href="{{ route('role.edit', $role->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('role.delete', $role->id) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($roles as $role)
    <!-- Modal for Assigning Permissions -->
    <div class="modal fade" id="permissionModel{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="permissionModelLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Permissions for {{ $role->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('role.storePermissions', $role) }}">
                        @csrf
                        @foreach ($permissions as $permission)
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text mr-3">
                                        <input type="checkbox" aria-label="Checkbox for following text input"
                                            name="permissions[]" value="{{ $permission->name }}"
                                            {{ in_array($permission->name, $rolePermissions[$role->id]->toArray()) ? 'checked' : '' }}>
                                    </div>
                                </div>
                                {{ $permission->name }}
                            </div>
                        @endforeach
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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
