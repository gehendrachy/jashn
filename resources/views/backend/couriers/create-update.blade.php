@extends('backend.layouts.app')
@section('title', 'Couriers')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        <i class="ik ik-anchor bg-blue"></i>
                        <div class="d-inline">
                            <h5>Couriers</h5>
                            <span>Create, Update, Delete Courier</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.Couriers.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.couriers.index') }}">Couriers</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ request()->routeIs('admin.couriers.edit') ? 'Update' : 'Create New' }} Courier</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST"
                    action="{{ request()->routeIs('admin.couriers.edit') ? route('admin.couriers.update', $courier) : route('admin.couriers.store') }}"
                    enctype="multipart/form-data">

                    @csrf

                    @if (request()->routeIs('admin.couriers.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.couriers.edit') ? 'Update Couriers' : 'Create New Couriers' }}
                            </h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Courier
                                                Name</label>
                                        </span>
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter Courier Name" required
                                            value="{{ old('name') ? old('name') : (request()->routeIs('admin.couriers.edit') ? $courier->name : '') }}">
                                        @error('name')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Phone </label>
                                        </span>
                                       
                                            <input type="text" class="form-control"
                                                name="phone" value="{{ old('phone') ? old('phone') : (request()->routeIs('admin.couriers.edit') ? $courier->phone : '') }}">

                                       
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Email </label>
                                        </span>
                                       
                                            <input type="text" class="form-control"
                                                name="email" value="{{ old('email') ? old('email') : (request()->routeIs('admin.couriers.edit') ? $courier->email : '') }}">

                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp;Address </label>
                                        </span>
                                       
                                            <input type="text" class="form-control"
                                                name="address" value="{{ old('address') ? old('address') : (request()->routeIs('admin.couriers.edit') ? $courier->address : '') }}">

                                       
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.couriers.edit') ? $courier->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.couriers.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.16.1/ckeditor.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery-all.min.js"></script>

@endpush
