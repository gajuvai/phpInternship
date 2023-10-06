@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')


    <div class="card card-default color-palette-box">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-12">
                <h5> @lang('Welcome to the Dashboard')</h5>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.card-body -->
    </div>
@endsection
