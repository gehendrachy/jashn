@extends('backend.layouts.app')
@section('title', 'Contents  ')
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
<?php
    function displayList($list)
    {

        ?>
        <ol class="dd-list">
            <?php foreach ($list as $item): ?>
            <li class="dd-item dd3-item" data-id="{{ $item->id }} ">
                <div class="dd-handle dd3-handle"></div>
                <div class="dd3-content">
                    <b>{{ $item->title }}</b>&nbsp;|&nbsp; 
                    <small>
                        <i>
                            @if($item->display == 1)
                            
                                <i style="color: green;" class="fa fa-eye"></i>
                            
                            @else
                            
                                <i style="color: red;" class="fa fa-eye-slash"></i>
                            @endif

                        </i>
                    </small>
                    <span class="content-right">
                        <!-- <a href="#viewModal"
                           class="btn btn-outline-success"
                           data-toggle="modal"
                           data-id="{{ $item->id }} "
                           id="view{{ $item->id }}"
                           data-content = '{{ addslashes($item->content) }}'
                           onclick="view('{{ $item->id }}','{{ addslashes($item->title) }}','{{ $item->slug }}','{{ $item->display }}','{{ $item->image }}')"
                           title="View"><i class="fa fa-eye"></i>
                        </a> -->

                        <a href="{{ route('admin.contents.edit', base64_encode($item->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                        @if(!array_key_exists("children", (array)$item) && false)
                        <a href="#delete"
                           data-toggle="modal"
                           data-id="{{ $item->id }}"
                           id="delete{{ $item->id }}"
                           title="Delete" 
                           class="btn btn-outline-danger center-block"
                           onclick="delete_contents('{{ base64_encode($item->id) }}')"><i class="fa fa-trash  "></i>
                       </a>
                       @endif
                    </span>
                </div>

                <?php if (array_key_exists("children", (array)$item)): ?>
                    <?php displayList($item->children); ?>
                <?php endif; ?>
            </li>
            <?php
            endforeach; ?>
        </ol>
        <?php
    }
?>
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
                            <li class="breadcrumb-item active" aria-current="page">List Contents</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.contents.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Contents</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="dd nestable-with-handle" id="nestable">
                                <?php isset($contents) ? displayList($contents) : '' ?>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Content')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete contents?</p>
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
        function delete_contents(id) {
            var conn = './contents/delete/' + id;
            $('#delete a').attr("href", conn);
        }

        // (function($) {

        //     updateOutput = function (e) {
        //         var list = e.length ? e : $(e.target), output = list.data('output');

        //         $.ajax({
        //             method: "POST",
        //             url: "{{route('admin.contents.order')}}",
        //             data: {
        //                 '_token': $('input[name=_token]').val(),
        //                 list_order: list.nestable('serialize'),
        //                 table: "contents",
        //                 has_child : 1,
        //                 model : "\\App\\Models\\Content"
        //             },
        //             success: function (response) {
        //                 // console.log("success");
        //                 // console.log("response " + response);
        //                 var obj = jQuery.parseJSON(response);
        //                 if (obj.status == 'success') {
        //                     showNotification('','Contents sorted Successfully', 'info', 'top-right'); 

        //                 };

        //             }
        //         }).fail(function (jqXHR, textStatus, errorThrown) {
        //             showNotification('Error!','Something Went Wrong!', 'danger', 'top-right');
        //         });
        //     };


        // })(jQuery);

        // $('#nestable').nestable({
        //     group: 1,
        //     maxDepth: 2
        // }).on('change', updateOutput);

    </script>
@endpush
