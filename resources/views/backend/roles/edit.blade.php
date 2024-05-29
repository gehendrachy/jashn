<?php
/**
 * Created On : PhpStorm
 * Project Name: byabasayi
 * Author Name: Subas Nyaupane
 * Author Email: mail.subasnyaupane@gmail.com
 * Author Url : https://subasnyaupane.github.io/
 * Date: 26/May/2021
 */
?>
@extends('backend.layouts.app')
@section('title', 'Edit Role  ')
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
                            <h5>Edit Role & Permission</h5>
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
                                <a href="{{ route('admin.roles.index') }}">Role & Permission</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <form class="forms-sample" method="post" action="{{ route('admin.roles.update',$role->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Name
                                            </div>
                                        </div>
                                        <input type="text" value="{{ $role->name }}" class="form-control" name="name" placeholder="Role Name">
                                    </div>
                                </div>
                            </div>
                            <div class=" row">
                                <div class="col-md-12">
                                    <ul class="list-group ">
                                        <div class="row">
                                            @foreach($permissions as $key => $value)

                                                @php
                                                    $parts = explode('-', $value->name);
                                                    $parts = implode(' ', $parts);
                                                @endphp

                                                <div class="col-md-3 mb-2">
                                                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center">
                                                        {{ ucwords($parts) }}
                                                        <span class="mb-4">
                                                            <input class="form-check-input permission" @if(in_array($value->id, $rolePermissions)) checked @endif type="checkbox" name="permission[]" value="{{ $value->id }}">
                                                        </span>
                                                    </li>
                                                </div>
                                            @endforeach
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button style="float: right" type="submit" class="btn btn-success mr-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
