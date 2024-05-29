@extends('backend.layouts.app')
@section('title', 'Users  ')
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
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>Users</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"> <i
                            class="ik ik-plus"></i> Add New </a>
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
                            <li class="breadcrumb-item active" aria-current="page">List Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="card table-card ">
                    <div class="card-block">
                        <div class="table-responsive p-3">
                            <table id="myAdvancedTable" class="table table-hover table-bordered mb-0 ">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->getRoleNames())
                                                @foreach($user->getRoleNames() as $v)
                                                    <button class="badge badge-success" type="button">{{ $v }}</button>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ date('d M Y',strtotime($user->created_at)) }}</td>
                                        <td>
                                            <div class="list-actions">
                                                <a href="{{ route('admin.users.show',$user) }}"
                                                   class="btn btn-icon btn-primary">
                                                    <i class="ik ik-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit',$user) }}"
                                                   class="btn btn-icon btn-info">
                                                    <i class="ik ik-edit-2"></i></a>
                                                <a href="#" class="btn btn-icon btn-danger">
                                                    <i class="ik ik-trash-2"></i>
                                                </a>
                                            </div>
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
    </div>
@endsection
@push('script')
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <!--  datatable script-->
    <script>
        (function ($) {
            'use strict';
            $(document).ready(function () {
                var dTable = $('#myAdvancedTable').DataTable({

                    order: [],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    responsive: false,
                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers"
                });

            });

        })(jQuery);
    </script>
@endpush
