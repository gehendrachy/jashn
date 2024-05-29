@extends('backend.layouts.app')
@section('title', 'Product Cares')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <h5>Product Cares</h5>
                            <span>Create, Update, Delete Product Cares</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.product-cares.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.product-cares.index') }}">Product Cares</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.product-cares.edit') ? 'Update' : 'Creat New' }} Product Care</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.product-cares.edit') ? route('admin.product-cares.update',$product_care) : route('admin.product-cares.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.product-cares.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.product-cares.edit') ? 'Update Product Care' : 'Create New Product Care' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Product Care Title" required value="{{ old('title') ? old('title') : (request()->routeIs('admin.product-cares.edit') ? $product_care->title : '') }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                            
                                <div class="col-md-4">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.product-cares.edit') ? $product_care->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row gallery_images_field">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        
                                        <input type="file" name="image" class="file-upload-default" >

                                        <div class="input-group input-group-inverse mb-0">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text"> <i class="ik ik-image"></i>&nbsp; Image </label>
                                            </span>
                                            <input type="text" class="form-control form-control-inverse file-upload-info" disabled placeholder="Upload Featured Image">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-inverse" type="button">{{ __('Upload')}}</button>
                                            </span>
                                        </div>
                                        <small>Recommended Image Resolution : <strong><i>100px X 100px</i></strong></small>
                                    </div>
                                    
                                </div>
                                @if(request()->routeIs('admin.product-cares.edit') && $product_care->image != '')
                                <div class="col-md-4">
                                    <a class="light-link" href="{{ asset('storage/product-cares/'.$product_care->image) }}" data-sub-html="{{ $product_care->title }} ">

                                        <img style="margin: 10px;" class="img rounded" width="50px" src="{{ asset('storage/product-cares/thumbs/thumb_'.$product_care->image) }}" alt="{{ $product_care->title }}">
                                    </a>

                                    
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    
                                    <textarea class="form-control form-control-inverse" name="description">{{ old('description') ? old('description') : (request()->routeIs('admin.product-cares.edit') ? $product_care->description : '') }}</textarea>
                                    
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.product-cares.index') }}" class="btn btn-danger">Cancel</a>
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
    <script>
        $(".gallery_images_field").lightGallery({
                selector: '.light-link'
            }); 
    </script>

@endpush
