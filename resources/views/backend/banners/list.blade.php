@extends('backend.layouts.app')
@section('title', 'Banners  ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/nestable/nestable.css') }}"/>
    <style type="text/css">
        .btn{
            padding: 4px 8px;
        }
        .btn i{
            margin-right: 0px;
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
                            <li class="breadcrumb-item active" aria-current="page">List Banners</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Home Page Banners</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="overlay-wrapper position-relative">
                                        <div  class="banner-overlay"></div>
                                        <img class="img-thumbnail" src="{{ asset('storage/banners/'.$banners[0]->image) }}" alt="{{ $banners[0]->title }}">
                                        <div class="edit-buttons">
                                            <span class="content-right">
                                            

                                                <a href="{{ route('admin.banners.edit', base64_encode($banners[0]->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                {{-- <p>
                                                    <small>Recommended Resolution : <strong>1920px X 510px</strong></small><br>
                                                    <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>
                                                </p> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="overlay-wrapper position-relative">
                                        <div  class="banner-overlay"></div>
                                        <img class="img-thumbnail" src="{{ asset('storage/banners/'.$banners[1]->image) }}" alt="{{ $banners[1]->title }}">
                                        <div class="edit-buttons">
                                            <span class="content-right">
                                            

                                                <a href="{{ route('admin.banners.edit', base64_encode($banners[1]->id)) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                {{-- <p>
                                                    <small>Recommended Resolution : <strong>1920px X 510px</strong></small><br>
                                                    <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>
                                                </p> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="overlay-wrapper position-relative">
                                        <div  class="banner-overlay"></div>
                                        <img class="img-thumbnail" src="{{ asset('storage/banners/'.$banners[2]->image) }}" alt="{{ $banners[2]->title }}">
                                        <div class="edit-buttons">
                                            <span class="content-right">
                                            

                                                <a href="{{ route('admin.banners.edit', base64_encode($banners[2]->id)) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                {{-- <p>
                                                    <small>Recommended Resolution : <strong>655px X 350px</strong></small><br>
                                                    <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>
                                                </p> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="overlay-wrapper position-relative">
                                        <div  class="banner-overlay"></div>
                                        <img class="img-thumbnail" src="{{ asset('storage/banners/'.$banners[3]->image) }}" alt="{{ $banners[3]->title }}">
                                        <div class="edit-buttons">
                                            <span class="content-right">
                                            

                                                <a href="{{ route('admin.banners.edit', base64_encode($banners[3]->id)) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                {{-- <p>
                                                    <small>Recommended Resolution : <strong>655px X 350px</strong></small><br>
                                                    <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>
                                                </p> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="overlay-wrapper position-relative">
                                        <div  class="banner-overlay"></div>
                                        <img class="img-thumbnail" src="{{ asset('storage/banners/'.$banners[4]->image) }}" alt="{{ $banners[4]->title }}">
                                        <div class="edit-buttons">
                                            <span class="content-right">
                                            

                                                <a href="{{ route('admin.banners.edit', base64_encode($banners[4]->id)) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                {{-- <p>
                                                    <small>Recommended Resolution : <strong>325px X 350px</strong></small><br>
                                                    <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>
                                                </p> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="overlay-wrapper position-relative">
                                        <div  class="banner-overlay"></div>
                                        <img class="img-thumbnail" src="{{ asset('storage/banners/'.$banners[5]->image) }}" alt="{{ $banners[5]->title }}">
                                        <div class="edit-buttons">
                                            <span class="content-right">
                                            

                                                <a href="{{ route('admin.banners.edit', base64_encode($banners[5]->id)) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                {{-- <p>
                                                    <small>Recommended Resolution : <strong>325px X 350px</strong></small><br>
                                                    <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>
                                                </p> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="overlay-wrapper position-relative">
                                        <div  class="banner-overlay"></div>
                                        <img class="img-thumbnail" src="{{ asset('storage/banners/'.$banners[6]->image) }}" alt="{{ $banners[6]->title }}">
                                        <div class="edit-buttons">
                                            <span class="content-right">
                                            

                                                <a href="{{ route('admin.banners.edit', base64_encode($banners[6]->id)) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                {{-- <p>
                                                    <small>Recommended Resolution : <strong>325px X 350px</strong></small><br>
                                                    <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>
                                                </p> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="overlay-wrapper position-relative">
                                        <div  class="banner-overlay"></div>
                                        <img class="img-thumbnail" src="{{ asset('storage/banners/'.$banners[7]->image) }}" alt="{{ $banners[7]->title }}">
                                        <div class="edit-buttons">
                                            <span class="content-right">
                                            

                                                <a href="{{ route('admin.banners.edit', base64_encode($banners[7]->id)) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                {{-- <p>
                                                    <small>Recommended Resolution : <strong>325px X 350px</strong></small><br>
                                                    <small>Recommended File : <strong> ≤ 2MB, .jpg, .jpeg, .png</strong></small>
                                                </p> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-responsive">
                                        <table id="banners-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>{{ __('Name')}}</th>
                                                    <th>{{ __('Image')}}</th>
                                                    <th>{{ __('URL')}}</th>
                                                    <th>{{ __('Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($banners as $key => $banner)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        {{ $banner->title }}
                                                       
                                                    </td>
                                                    <td>
                                                        <img width="20%" class="img-thumbnail" src="{{ asset('storage/banners/'.$banner->image) }}" alt="{{ $banner->title }}">
                                                    </td>
                                                    <td>
                                                        {{ $banner->url }}
                                                       
                                                    </td>
                                                    <td>
                                                        <span class="content-right">
                                            

                                                            <a href="{{ route('admin.banners.edit', base64_encode($banner->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                            
                                                            <a href="#delete"
                                                               data-toggle="modal"
                                                               data-id="{{ $banner->id }}"
                                                               id="delete{{ $banner->id }}"
                                                               title="Delete" 
                                                               class="btn btn-outline-danger center-block"
                                                               onclick="delete_banner('{{ base64_encode($banner->id) }}')"><i class="fa fa-trash  "></i>
                                                           </a>
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete banners')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete banners?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                    <a href="" class="btn btn-danger">{{ __('Yes, Delete It')}}</a>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@push('script')

    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script><!-- Jquery Nestable -->
    <script>
        $('#banners-table').DataTable();

        function delete_banner(id) {
            var conn = './banners/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
