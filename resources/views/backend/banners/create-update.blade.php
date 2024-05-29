@extends('backend.layouts.app')
@section('title', 'Banners')
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
                        <i class="ik ik-image bg-blue"></i>
                        <div class="d-inline">
                            <h5>Banners</h5>
                            <span>Create, Update, Delete Banners</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>

                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.banners.index') }}">Banners</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.banners.edit') ? 'Update' : 'Create New' }} Banners</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.banners.edit') ? route('admin.banners.update',$banner) : route('admin.banners.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.banners.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.banners.edit') ? 'Update banners' : 'Create New Banners' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse mb-0">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Banners Title" required value="{{ old('title') ? old('title') : (request()->routeIs('admin.banners.edit') ? $banner->title : '') }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse mb-0">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; URL</label>
                                        </span>
                                        <input name="url" type="text" class="form-control @error('url') is-invalid @enderror" placeholder="Enter URL" required value="{{ old('url') ? old('url') : (request()->routeIs('admin.banners.edit') ? $banner->url : '') }}">
                                        @error('url')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <small>Add Full Link, eg : <strong>https://jashn.com/about-us</strong></small>
                                </div>

                            </div>

                            <div class="row gallery_images_field">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        
                                        <input type="file" name="image" class="file-upload-default" {{ request()->routeIs('admin.banners.edit') ? '' : '' }}>

                                        <div class="input-group input-group-inverse">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text"> <i class="ik ik-image"></i>&nbsp; Image </label>
                                            </span>
                                            <input type="text" class="form-control form-control-inverse file-upload-info" disabled placeholder="Upload Banner Image">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-inverse" type="button">{{ __('Upload')}}</button>
                                            </span>
                                        </div>
                                        <strong>Recommended Image</strong><br>
                                        @php
                                            switch ($banner->id) {
                                                case '1':

                                                    $resolution = '1920px X 510px';
                                                    break;

                                                case '2':

                                                    $resolution = '1920px X 510px';
                                                    break;
                                                
                                                case '3': 
                                                case '4':

                                                    $resolution = '655px X 350px';
                                                    break;

                                                case '5' : 
                                                case '6' : 
                                                case '7' : 
                                                case '8' :

                                                    $resolution = '325px X 350px';
                                                    break;

                                                default:

                                                    $resolution = '325px X 350px';
                                                    break;
                                            }

                                        @endphp
                                        <small>Recommended Resolution : <strong>{{ $resolution }}</strong></small><br>
                                        <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>

                                    </div>
                                    {{-- @if(request()->routeIs('admin.banners.edit'))
                                        @if($banner->id != 0 && $banner->image != NULL)
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div>
                                                        <img width="30%" class="img-thumbnail" src="{{ asset('storage/banners/'.$banner->image) }}">

                                                        <a class="btn btn-outline-danger btn-sm" data-toggle="modal" href="#removeSlider" onclick="remove_banner('{{ base64_encode($banner->id) }}')"><i class="fa fa-times-circle fa-lg"></i> Remove Image</a>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        @endif
                                    @endif --}}
                                </div>
                                @if(request()->routeIs('admin.banners.edit'))
                                <div class="col-md-6">
                                    <a class="light-link" href="{{ asset('storage/banners/'.$banner->image) }}" data-sub-html="{{ $banner->title }} ">

                                        <img style="margin: 10px;" class="img rounded" width="75%" src="{{ asset('storage/banners/'.$banner->image) }}">
                                    </a>
                                    
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.banners.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
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
           function remove_banner(id) {
            var conn = '../../banners/delete-banner/' + id;
            $('#removeBanner a').attr("href", conn);
    }
    </script>

@endpush
