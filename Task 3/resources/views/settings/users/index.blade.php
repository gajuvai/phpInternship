@extends('layouts.app')

@section('title', __('User Management'))

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
                        <h1>User List</h1>
                    </div>
                    <div class="card-tools ml-auto">
                        <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-3"></i>Add
                            User</a>
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
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                                        <td>
                                            @if ($user->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">In-active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary" data-toggle="modal"
                                                data-target="#roleModel{{ $user->id }}">
                                                <i class="fa fa-user-tag"></i>
                                            </a>
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
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

    @foreach ($users as $user)
        <!-- Modal for Assigning Roles -->
        <div class="modal fade" id="roleModel{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="roleModelLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Role to {{ $user->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user.storeRoles', $user) }}">
                            @csrf
                            @foreach ($roles as $role)
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text mr-3">
                                            <input type="checkbox" aria-label="Checkbox for following text input"
                                                name="roles[]" value="{{ $role->name }}"
                                                {{ in_array($role->name, $userRoles[$user->id]->toArray()) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    {{ $role->name }}
                                </div>
                            @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
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
