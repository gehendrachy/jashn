@extends('backend.layouts.app')
@section('title', 'Site Settings')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>Site Settings</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.setting') }}">Site Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Update Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="card border border-secondary">
                    <div class="card-header bg-default">
                        <h6>Update Your Site Setting</h6>
                    </div>
                    <div class="card-body">
                        <form id="advanced-form" data-parsley-validate="" novalidate=""
                              action="{{ route('admin.setting.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">

                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-file-image"></i> &nbsp;Logo 
                                                            </span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" name="logo" class="custom-file-input" id="inputGroupFile03">
                                                            <label class="custom-file-label" for="inputGroupFile03">Choose Logo</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                @if(isset($setting->logo))
                                                    <div class="card">
                                                        <div class="card-body d-inline-block">
                                                            <img src="{{ asset('storage/setting/logo/'.$setting->logo) }}"
                                                            data-toggle="tooltip" data-placement="top" title="" alt="Logo"
                                                            class="rounded img-thumbnail" width="80px"
                                                            data-original-title="Logo">
                                                        </div>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-file-image"></i> &nbsp;Favicon 
                                                            </span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" name="favicon" class="custom-file-input" id="inputGroupFile03">
                                                            <label class="custom-file-label" for="inputGroupFile03">Choose Favicon</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                @if(isset($setting->favicon))
                                                    <div class="card">
                                                        <div class="card-body d-inline-block">
                                                            <img src="{{ asset('storage/setting/favicon/'.$setting->favicon) }}"
                                                            data-toggle="tooltip" data-placement="top" title="" alt="Favicon"
                                                            class="rounded img-thumbnail" width="50px"
                                                            data-original-title="Favicon">
                                                        </div>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-info "></i> &nbsp;Site Title</span>
                                        </div>
                                        <input type="text" name="title" value="{{ isset($setting->title) ? $setting->title : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope "></i> &nbsp;Site Email</span>
                                        </div>
                                        <input type="email" name="email" value="{{ isset($setting->email) ? $setting->email : '' }}" class="form-control" aria-label="Default">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone-square "></i> &nbsp; Phone</span>
                                        </div>
                                        <input type="text" name="phone" value="{{ isset($setting->phone) ? $setting->phone : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-mobile"></i> &nbsp; Mobile</span>
                                        </div>
                                        <input type="text" name="mobile" value="{{ isset($setting->mobile) ? $setting->mobile : '' }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-viber"></i> &nbsp; Mobile (Viber)</span>
                                        </div>
                                        <input type="text" name="mobile_viber" value="{{ isset($setting->mobile_viber) ? $setting->mobile_viber : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-whatsapp"></i> &nbsp; Mobile (Whatsapp)</span>
                                        </div>
                                        <input type="text" name="mobile_whatsapp" value="{{ isset($setting->mobile_whatsapp) ? $setting->mobile_whatsapp : '' }}" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-marker "></i> &nbsp; Address</span>
                                        </div>
                                        <input type="address" value="{{ isset($setting->address) ? $setting->address : '' }}" name="address" class="form-control">
                                    </div>
                                </div>

                                <!-- <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-linkedin "></i> &nbsp; Linked In</span>
                                        </div>
                                        <input type="text" value="{{ isset($setting->linked_in) ? $setting->linked_in : '' }}" name="linked_in" class="form-control">
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-facebook-square "></i> &nbsp;Facebook Url</span>
                                        </div>
                                        <input type="text" name="facebookurl" value="{{ isset($setting->facebookurl) ? $setting->facebookurl : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-twitter "></i> &nbsp;Twitter Url</span>
                                        </div>
                                        <input type="text" name="twitterurl" value="{{ isset($setting->twitterurl) ? $setting->twitterurl : '' }}" class="form-control">
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-instagram "></i>&nbsp; Instagram Url</span>
                                        </div>
                                        <input type="text" name="instagramurl" value="{{ isset($setting->instagramurl) ? $setting->instagramurl : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-youtube "></i>&nbsp; Youtube Url</span>
                                        </div>
                                        <input type="text" name="youtubeurl" value="{{ isset($setting->youtubeurl) ? $setting->youtubeurl : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-youtube "></i>&nbsp; How to Order Url</span>
                                        </div>
                                        <input type="text" name="how_to_order_link" value="{{ isset($setting->how_to_order_link) ? $setting->how_to_order_link : '' }}" class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-file-text-o "></i>&nbsp; About Your Site</span>
                                        </div>
                                        <textarea name="aboutus" class="form-control">{{ isset($setting->aboutus) ? $setting->aboutus : '' }}</textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map "></i>&nbsp; Google Map Url</span>
                                        </div>
                                        <textarea name="googlemapurl" class="form-control">{{ isset($setting->googlemapurl) ? $setting->googlemapurl : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Update SEO Attributes of Your Site</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-info "></i> &nbsp; OG Title</span>
                                                            </div>
                                                            <input type="text" name="og_title" value="{{ isset($setting->og_title) ? $setting->og_title : '' }}" class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-info "></i> &nbsp; OG Description</span>
                                                            </div>
                                                            <textarea name="og_description" class="form-control">@if(isset($setting->og_description)){{ $setting->og_description }}@endif</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fa fa-file-image-o"></i> &nbsp;OG Image </span>
                                                                            </div>
                                                                            <div class="custom-file">
                                                                                <input type="file" name="og_image" class="custom-file-input" id="inputGroupFile03">
                                                                                <label class="custom-file-label" for="inputGroupFile03">Choose
                                                                                    OG Image</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                    @if(isset($setting->og_image))
                                                                        <div class="card">
                                                                            <div class="card-body d-inline-block">
                                                                                <img src="{{ asset('storage/setting/og_image/'.$setting->og_image) }}" data-toggle="tooltip" data-placement="top" title="" alt="Favicon"
                                                                                class="rounded img-thumbnail" width="50px"
                                                                                data-original-title="Favicon">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fa fa-info "></i> &nbsp; Meta Title
                                                                </span>
                                                            </div>
                                                            <input type="text" name="meta_title" value="{{ isset($setting->meta_title) ? $setting->meta_title : '' }}" class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-info "></i> &nbsp; Meta Description</span>
                                                            </div>
                                                            <textarea name="meta_description" class="form-control">@if(isset($setting->meta_description)){{ $setting->meta_description }}@endif</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fa fa-info "></i> &nbsp; Meta Keywords
                                                                </span>
                                                            </div>
                                                            <input type="text" name="meta_keywords" value="{{ isset($setting->meta_keywords) ? $setting->meta_keywords : '' }}" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>     
                                </div>

                                <div class="col-12">
                                    <!-- <button type="submit" class="btn btn-outline-danger">Cancel</button> -->
                                    <button style="float: right" type="submit" class="btn btn-outline-success">Update</button>
                                </div>
                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')

@endpush
