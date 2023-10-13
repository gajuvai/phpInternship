@extends('layouts.app')

@section('title', __('Create New User'))

@section('css')

    <style>
        .input-group-append {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-default color-palette-box">
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <h1>Create New User</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid ">
                            <div class="col-12 pt-4">

                                <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="John Dev">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">User Name</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="john89">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="john25@yahoo.com">
                                    </div>
                                    <div class="mb-3 pb-5">
                                        <label for="status" class="form-label">Status</label>
                                            <select name="status" class="custom-select">
                                                <option value="1">Active</option>
                                                <option value="0">In-active</option>
                                            </select>
                                    </div>


                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-primary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
@endsection
