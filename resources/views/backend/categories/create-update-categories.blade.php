@extends('backend.layouts.app')
@section('title', 'Categories  ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
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
                        <i class="ik ik-anchor bg-blue"></i>
                        <div class="d-inline">
                            <h5>Categories</h5>
                            <span>Create, Update, Delete Categories</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.categories.index') }}">Categories</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.categories.edit') ? 'Update' : 'Creat New' }} Category</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.categories.edit') ? route('admin.categories.update',$category) : route('admin.categories.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.categories.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.categories.edit') ? 'Update Category' : 'Create New Category' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Category Title" required value="{{ old('title') ? old('title') : (request()->routeIs('admin.categories.edit') ? $category->title : '') }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; Parent Category</label>
                                        </span>

                                        <select name="parent_id" class="form-control select2">
                                            <option value="0">None</option>
                                            @php
                                                $parentId = old('parent_id') ? old('parent_id') : (request()->routeIs('admin.categories.edit') ? $category->parent_id : '');
                                            @endphp
                                            @foreach($parent_categories as $pCat)
                                                <option {{ $parentId == $pCat->id ? 'selected' : '' }} value="{{ $pCat->id }}">{{ $pCat->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            
                                <div class="col-md-4">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.categories.edit') ? $category->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- <div class="col-md-3">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $featured = old('featured') ? old('featured') : (request()->routeIs('admin.categories.edit') ? $category->featured : 0);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="featuredCheckbox" name="featured" value="1" {{ $featured == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="featuredCheckbox">{{ __('Featured')}}</label>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-6">
                                    <div class="input-group input-group-default">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" name="display" value="1" checked="">
                                            </div>
                                        </div>
                                        <input type="button" class="form-control form-control-bold" value="Display" readonly>

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" name="featured" value="1">
                                            </div>
                                        </div>
                                        <input type="button" class="form-control form-control-bold" value="Featured" readonly>
                                        
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="file" name="image" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                                            </span>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            {{-- <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <textarea cols="form-control" name="content"></textarea>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Cancel</a>
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
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <!--  datatable script-->
    <script>
        (function ($) {

            $(".select2").select2({
                "width" : "100%"
            });

        })(jQuery);
    </script>
@endpush
