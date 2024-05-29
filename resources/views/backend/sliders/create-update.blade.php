@extends('backend.layouts.app')
@section('title', 'Sliders')
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
                            <h5>Sliders</h5>
                            <span>Create, Update, Delete Sliders</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.sliders.index') }}">Sliders</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.sliders.edit') ? 'Update' : 'Create New' }} Sliders</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.sliders.edit') ? route('admin.sliders.update',$slider) : route('admin.sliders.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.sliders.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.sliders.edit') ? 'Update Sliders' : 'Create New Sliders' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Sliders Title" required value="{{ old('title') ? old('title') : (request()->routeIs('admin.sliders.edit') ? $slider->title : '') }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="input-group input-group-inverse mb-0">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Link</label>
                                        </span>
                                        <input name="url" type="text" class="form-control @error('url') is-invalid @enderror" placeholder="Enter Slider URL" required value="{{ old('url') ? old('url') : (request()->routeIs('admin.sliders.edit') ? $slider->url : '') }}">
                                        @error('url')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <small>Add Full Link, eg : <strong>https://jashn.com/about-us</strong></small>
                                </div>

                                <div class="col-md-2">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.sliders.edit') ? $slider->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox"
                                                name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label"
                                                for="displayCheckbox">{{ __('Display Status') }}</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row gallery_images_field">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        
                                        <input type="file" name="image" class="file-upload-default" {{ request()->routeIs('admin.sliders.edit') ? '' : '' }}>

                                        <div class="input-group input-group-inverse">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text"> <i class="ik ik-image"></i>&nbsp; Image </label>
                                            </span>
                                            <input type="text" class="form-control form-control-inverse file-upload-info" disabled placeholder="Upload Slider Image">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-inverse" type="button">{{ __('Upload')}}</button>
                                            </span>
                                        </div>

                                        <strong>Recommended Image</strong><br>
                                        <small>Recommended Resolution : <strong>1920px X 800px</strong></small><br>
                                    </div>
                                </div>
                                @if(request()->routeIs('admin.sliders.edit'))
                                <div class="col-md-5">
                                    <a class="light-link" href="{{ asset('storage/sliders/'.$slider->image) }}" data-sub-html="{{ $slider->title }} ">

                                        <img style="margin: 10px;" class="img rounded" width="50%" src="{{ asset('storage/sliders/'.$slider->image) }}">
                                    </a>

                                    
                                </div>
                                @endif
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeSlider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
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
           function remove_image(id) {
            var conn = '../../sliders/delete-slider/' + id;
            $('#removeSlider a').attr("href", conn);
    }
    </script>

@endpush
