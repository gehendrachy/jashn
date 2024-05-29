@extends('backend.layouts.app')
@section('title', 'Product Cares  ')
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
                            <li class="breadcrumb-item active" aria-current="page">List Product Cares</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.product-cares.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Product Cares</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-responsive">
                                        <table id="product-cares-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>{{ __('Name')}}</th>
                                                    <th>{{ __('Image')}}</th>
                                                    <th>{{ __('Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product_cares as $key => $product_care)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        {{ $product_care->title }}
                                                        @if($product_care->display == 1)
                                                        
                                                            <i style="color: green;" class="fa fa-eye"></i>
                                                        
                                                        @else
                                                        
                                                            <i style="color: red;" class="fa fa-eye-slash"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($product_care->image != '')
                                                        <img width="20%" class="img-thumbnail" src="{{ asset('storage/product-cares/thumbs/thumb_'.$product_care->image) }}" alt="{{ $product_care->slug }}">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="content-right">
                                                            <a class="btn btn-outline-success" href="#viewDetails" id="view-{{ $product_care->id }}" data-toggle="modal" data-title="{{ $product_care->title }}" data-display-status="{{ $product_care->display }}" data-image="{{ asset('storage/product-cares/thumbs/thumb_'.$product_care->image) }}" data-description="{{ addslashes($product_care->description) }}" onclick="view_details('{{ $product_care->id }}')"><i class="fa fa-eye"></i></a>

                                                            <a href="{{ route('admin.product-cares.edit', base64_encode($product_care->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                            
                                                            <a href="#delete"
                                                               data-toggle="modal"
                                                               data-id="{{ $product_care->id }}"
                                                               id="delete{{ $product_care->id }}"
                                                               title="Delete" 
                                                               class="btn btn-outline-danger center-block"
                                                               onclick="delete_product_care('{{ base64_encode($product_care->id) }}')"><i class="fa fa-trash  "></i>
                                                           </a>
                                                        </span>
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
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewDetails" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">Product Care Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="offset-md-3 col-md-6">
                            <img id="viewImage" src="">
                        </div>
                        <div class="col-md-12 text-center">
                            <p>Title : <strong id="viewTitle"></strong></p>
                            <p>Display Status : <strong id="viewDisplayStatus"></strong></p>
                            <p>Content : <span id="viewDescription"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Product Care')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete Product Care?</p>
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
        $('#product-cares-table').DataTable();

        function delete_product_care(id) {
            var conn = './product-cares/delete/' + id;
            $('#delete a').attr("href", conn);
        }

        function view_details(id) {
            var title = $("#view-"+id).data('title');
            var image = $("#view-"+id).data('image');
            var display_status = $("#view-"+id).data('display-status');
            var description = $("#view-"+id).data('description');

            $("#viewTitle").html(title);
            $("#viewImage").attr('src', image);
            if (display_status ==1) {

                $("#viewDisplayStatus").html('Displayed');
            }else{
                $("#viewDisplayStatus").html('Not Displayed');
            }

            $("#viewDescription").html(description);
        }

    </script>
@endpush
