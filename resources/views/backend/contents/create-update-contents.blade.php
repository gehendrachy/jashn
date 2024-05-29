@extends('backend.layouts.app')
@section('title', 'Contents  ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/multiselect/css/multi-select.css') }}">
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
                            <h5>Contents</h5>
                            <span>Create, Update, Delete Contents</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.contents.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.contents.index') }}">Contents</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.contents.edit') ? 'Update' : 'Create New' }} Content</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.contents.edit') ? route('admin.contents.update',$content) : route('admin.contents.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.contents.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.contents.edit') ? 'Update '.$content->title.' Content' : 'Create New Content' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                
                                <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="title" type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" placeholder="Enter Content Title" required value="{{ old('title') ? old('title') : (request()->routeIs('admin.contents.edit') ? $content->title : '') }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                

                                {{-- <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; Parent Content</label>
                                        </span>

                                        <select name="parent_id" class="form-control select2">
                                            <option value="0">None</option>
                                            @php
                                                $parentId = old('parent_id') ? old('parent_id') : (request()->routeIs('admin.contents.edit') ? $content->parent_id : '');
                                            @endphp
                                            @foreach($parent_contents as $pCat)
                                                <option {{ $parentId == $pCat->id ? 'selected' : '' }} value="{{ $pCat->id }}">{{ $pCat->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                            
                                {{-- <div class="col-md-4">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.contents.edit') ? $content->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                        </div>
                                    </div>
                                </div> --}}
                                @if(!request()->routeIs('admin.contents.edit') && $content->id != 1)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="file" name="image" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control form-control-sm file-upload-info" disabled placeholder="Upload Image">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(request()->routeIs('admin.contents.edit') && $content->image != NULL)
                                <div class="col-md-6">
                                    <img width="20%" src="{{ asset('storage/contents/thumbs/small_'.$content->image) }}">
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="input-group-text"><i class="ik ik-list"></i>&nbsp; Content</label>
                                    <textarea class="form-control ckeditor" name="content">{{ old('content') ? old('content') : (request()->routeIs('admin.contents.edit') ? $content->content : '') }}</textarea>
                                </div>
                            </div>

                            <br>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.contents.index') }}" class="btn btn-danger">Cancel</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.16.1/ckeditor.js" crossorigin="anonymous"></script>
    <script>
       

    </script>

@endpush
