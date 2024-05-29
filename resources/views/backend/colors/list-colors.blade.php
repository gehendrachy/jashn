@extends('backend.layouts.app')
@section('title', 'Colors  ')
@push('style')
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
                            <h5>Colors</h5>
                            <span>Create, Update, Delete Colors</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.colors.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.colors.index') }}">Colors</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Colors</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.colors.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Available Colors</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                @foreach($colors as $color)

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="widget" style="border: 1px gray solid; margin-bottom: 2px;">
                                        <div class="widget-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="state">
                                                    <h6>
                                                        
                                                        <i style="color: {{ $color->code }};" class="fa fa-eye-dropper"></i>
                                                        
                                                        {{ $color->title }}
                                                        <small>
                                                            <i>
                                                                @if($color->display == 1)
                                                                
                                                                    <i style="color: green;" class="fa fa-eye"></i>
                                                                
                                                                @else
                                                                
                                                                    <i style="color: red;" class="fa fa-eye-slash"></i>
                                                                @endif

                                                            </i>
                                                        </small>
                                                        <span class="align-right">
                                                            <a href="{{ route('admin.colors.edit', base64_encode($color->id)) }}" class="btn btn-outline-secondary" title="Edit"><i class="fa fa-edit"></i></a>
                                                             
                                                            <a href="#delete"
                                                                data-toggle="modal"
                                                                data-id="{{ $color->id }}"
                                                                id="delete{{ $color->id }}"
                                                                title="Delete" 
                                                                class="btn btn-outline-secondary center-block"
                                                                onclick="delete_color('{{ base64_encode($color->id) }}')"><i class="fa fa-trash  "></i>
                                                            </a>
                                                        </span>
                                                        
                                                    </h6>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </div>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Color')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete color?</p>
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
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script><!-- Jquery Nestable -->
    <script>
        function delete_color(id) {
            var conn = './colors/delete/' + id;
            $('#delete a').attr("href", conn);
        }

        (function($) {

            updateOutput = function (e) {
                var list = e.length ? e : $(e.target), output = list.data('output');

                $.ajax({
                    method: "POST",
                    url: "{{route('admin.colors.order')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        list_order: list.nestable('serialize'),
                        table: "colors",
                        has_child : 1,
                        model : "\\App\\Models\\Color"
                    },
                    success: function (response) {
                        // console.log("success");
                        // console.log("response " + response);
                        var obj = jQuery.parseJSON(response);
                        if (obj.status == 'success') {
                            showNotification('','Colors sorted Successfully', 'info', 'top-right'); 

                        };

                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    showNotification('Error!','Something Went Wrong!', 'danger', 'top-right');
                });
            };


        })(jQuery);

        $('#nestable').nestable({
            group: 1,
            maxDepth: 4
        }).on('change', updateOutput);

    </script>
@endpush
