@extends('backend.layouts.app')
@section('title', 'Create Users  ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <style>
        .wrapper .page-wrap .main-content .page-header .page-header-title i {
            width: 50px !important;
            height: 50px !important;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user-check bg-blue"></i>
                        <div class="d-inline">
                            <h5>Create Users</h5>
                            <span>Something here</span>
                        </div>
                    </div>
                    {{--                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"> <i--}}
                    {{--                            class="ik ik-   plus"></i> Add New </a>--}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.users.index') }}">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <form class="forms-sample" method="post" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Name
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="name" placeholder="Full Name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text @error('email') is-invalid @enderror">
                                                    Email Address
                                                </div>
                                            </div>
                                            <input type="text"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email"
                                                   placeholder="Email Address">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend @error('password') is-invalid @enderror">
                                                <div class="input-group-text">
                                                    Password
                                                </div>
                                            </div>
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password"
                                                   placeholder="Password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Confirm Password
                                                </div>
                                            </div>
                                            <input id="password-confirm" type="password" placeholder="Confirm Password"
                                                   class="form-control"
                                                   name="password_confirmation" required autocomplete="new-password">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Choose Role
                                                </div>
                                            </div>
                                            <select class="form-control" name="roles" required>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-danger mr-2">Cancel</a>
                                <button style="float: right" type="submit" value="submit" class="btn btn-success mr-2">
                                    Submit
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

