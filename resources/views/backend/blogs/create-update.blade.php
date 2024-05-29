@extends('backend.layouts.app')
@section('title', 'Blogs')
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
                            <h5>Blogs</h5>
                            <span>Create, Update, Delete Blogs</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.blogs.index') }}">Blogs</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.blogs.edit') ? 'Update' : 'Create New' }} Blogs</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.blogs.edit') ? route('admin.blogs.update',$blog) : route('admin.blogs.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.blogs.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.blogs.edit') ? 'Update Blogs' : 'Create New Blogs' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Blogs Title" required value="{{ old('title') ? old('title') : (request()->routeIs('admin.blogs.edit') ? $blog->title : '') }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                            

                            </div>

                            <div class="row gallery_images_field">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        
                                        <input type="file" name="image" class="file-upload-default" {{ request()->routeIs('admin.blogs.edit') ? '' : '' }}>

                                        <div class="input-group input-group-inverse">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text"> <i class="ik ik-image"></i>&nbsp; Image </label>
                                            </span>
                                            <input type="text" class="form-control form-control-inverse file-upload-info" disabled placeholder="Upload Featured Image">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-inverse" type="button">{{ __('Upload')}}</button>
                                            </span>
                                        </div>
                                    </div>
                                    @if(request()->routeIs('admin.blogs.edit'))
                                    @if($blog->id != 0 && $blog->image != NULL)
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div>
                                                <img width="30%" class="img-thumbnail" src="{{ asset('storage/blogs/thumbs/small_'.$blog->image) }}">

                                                <a class="btn btn-outline-danger btn-sm" data-toggle="modal" href="#removeImage" onclick="remove_blog('{{ base64_encode($blog->id) }}')"><i class="fa fa-times-circle fa-lg"></i> Remove Image</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    @endif
                                    @endif
                                </div>
                                @if(request()->routeIs('admin.blogs.edit'))
                                <div class="col-md-4">
                                    <a class="light-link" href="{{ asset('storage/blogs/'.$blog->image) }}" data-sub-html="{{ $blog->title }} ">

                                        <img style="margin: 10px;" class="img rounded" width="50px" src="{{ asset('storage/blogs/thumbs/small_'.$blog->image) }}">
                                    </a>

                                    
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                <span class="input-group-prepend">
                                    <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Short Content </label>
                                </span>
                                <div class="col-sm-12">
                                    <textarea class="form-control ckeditor" name="short_content">{{ old('short_content') ? old('short_content') : (request()->routeIs('admin.blogs.edit') ? $blog->short_content : '') }}</textarea>
                                    
                                </div>
                            </div>

                            <div class="row">
                              
                                    <label class="input-group-text p-10"><i class="ik ik-type"></i> Long Content </label>
                                
                                <div class="col-sm-12">
                                    <textarea class="form-control ckeditor" name="long_content">{{ old('long_content') ? old('long_content') : (request()->routeIs('admin.blogs.edit') ? $blog->long_content : '') }}</textarea>
                                    
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-4">
                                <div class="border-checkbox-section">
                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                        @php
                                            $display = old('display') ? old('display') : (request()->routeIs('admin.blogs.edit') ? $blog->display : 1);
                                        @endphp
                                        <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                        <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <div class="border-checkbox-section">
                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                        @php
                                            $featured = old('featured') ? old('featured') : (request()->routeIs('admin.blogs.edit') ? $blog->featured : 1);
                                        @endphp
                                        <input class="border-checkbox" type="checkbox" id="featuredCheckbox" name="featured" value="1" {{ $featured == 1 ? 'checked' : '' }}>
                                        <label class="border-checkbox-label" for="featuredCheckbox">{{ __('Featured Status')}}</label>
                                    </div>
                                </div>
                            </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Remove Image?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-white">
                    <p>Are you Sure...!!</p>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Close</button>
                    <a href="" class="btn btn-round btn-primary">Delete</a>
                </div>
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
    <script>
           function remove_blog(id) {
            var conn = '../../blogs/delete-blog/' + id;
            $('#removeImage a').attr("href", conn);
    }
    </script>

@endpush
