@extends('backend.layouts.app')
@section('title', 'Size Groups  ')
@push('style')
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
                            <h5>Size Groups</h5>
                            <span>Create, Update, Delete Size Groups</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.size-groups.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.size-groups.index') }}">Size Groups</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.size-groups.edit') ? 'Update' : 'Create New' }} Size Group</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.size-groups.edit') ? route('admin.size-groups.update',$size_group) : route('admin.size-groups.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.size-groups.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.size-groups.edit') ? 'Update Size Group' : 'Create New Size Group' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Size Group Title" required value="{{ old('name') ? old('name') : (request()->routeIs('admin.size-groups.edit') ? $size_group->name : '') }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                            
                                <div class="col-md-4">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.size-groups.edit') ? $size_group->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border border-secondary mb-0">
                                <div class="card-header bg-default p-2">
                                    <strong class="mb-0">Enter Sizes</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="sizeNameDivs">
                                        @if(request()->routeIs('admin.size-groups.edit'))
                                            @foreach($size_group->sizes as $key => $size)
                                                <div class="col-md-3 group-size-input" id="group-size-{{ $key }}" data-cumulative-count="{{ $key }}">
                                                    <div class="input-group">
                                                        <input type="hidden" name="size_group[{{ $key }}][id]" value="{{ $size->id }}">
                                                        <input name="size_group[{{ $key }}][name]" type="text" class="form-control" placeholder="eg: S, M, NB, 0-12..." value="{{ $size->name }}" required>
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-outline-danger remove-size-btn" onclick="remove_size_input(this)" data-div-id="group-size-{{ $key }}" data-size-id="{{ $size->id }}">
                                                                <i class="fa fa-trash m-0"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-3 group-size-input" id="group-size-0" data-cumulative-count="0">
                                                <div class="input-group">
                                                    <input name="size_group[0][name]" type="text" class="form-control" placeholder="eg: S, M, NB, 0-12..." required>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-outline-danger remove-size-btn" onclick="remove_size_input(this)" data-div-id="group-size-0">
                                                            <i class="fa fa-trash m-0"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" id="addSizeButton" class="btn btn-info">Add Size</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.size-groups.index') }}" class="btn btn-danger">Cancel</a>
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
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <!--  datatable script-->

    <script>
        $("#addSizeButton").click(function(){
            
            var new_index = $(".group-size-input").last().data('cumulative-count');
            new_index++;
            var response_size_group = '<div class="col-md-3 group-size-input" id="group-size-'+new_index+'" data-cumulative-count="'+new_index+'">'+
                                            '<div class="input-group">'+
                                                '<input name="size_group['+new_index+'][name]" type="text" class="form-control" placeholder="eg: S, M, NB, 0-12..." required>'+
                                                '<span class="input-group-append">'+
                                                    '<button type="button" class="btn btn-outline-danger remove-size-btn" onclick="remove_size_input(this)" data-div-id="group-size-'+new_index+'">'+
                                                        '<i class="fa fa-trash m-0"></i>'+
                                                    '</button>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>';

            $("#sizeNameDivs").append(response_size_group);

            var group_size_input_count = $(".group-size-input").length;
            if (group_size_input_count > 1) {
                $('.remove-size-btn').show();
            }
        });

        var group_size_input_count = $(".group-size-input").length;
        if (group_size_input_count <= 1) {
            $('.remove-size-btn').hide();
        }

        function remove_size_input(that) {

            swal({
                title: "Are you sure?",
                text: "It will remove all data associated with it!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true

            }, function (isConfirm) {

                if (isConfirm) {
                    $('#modal-loader').show();
                    var size_id = $(that).data('size-id');
                    var div_id = $(that).data('div-id');
                    

                    if (size_id) {

                        $.ajax({
                            url : "{{ URL::route('admin.size-groups.delete-size') }}",
                            type : "POST",
                            data : {
                                '_token': '{{ csrf_token() }}',
                                id: size_id
                            },
                            cache : false,
                            beforeSend : function (){

                            },
                            complete : function($response, $status){
                                $('#modal-loader').hide();

                                if ($status != "error" && $status != "timeout" && $response.responseText != 'error') {
                                    
                                    $('#'+div_id).remove();
                                    var group_size_input_count = $(".group-size-input").length;
                                    if (group_size_input_count <= 1) {
                                        $('.remove-size-btn').hide();
                                    }
                                }else{
                                    alert('Something went Wrong');
                                }
                            },
                            error : function ($responseObj){
                                setTimeout(function(){
                                    $('#modal-loader').hide();
                                    alert("Something went wrong while processing your request.\n\nError => "
                                    + $responseObj.responseText);
                                }, 500);
                                

                            }
                        });

                    }else{
                        $('#modal-loader').hide();
                        $('#'+div_id).remove();

                        var group_size_input_count = $(".group-size-input").length;
                        if (group_size_input_count <= 1) {
                            $('.remove-size-btn').hide();
                        }
                    }
                    
                }

            });
            
        }



    </script>
@endpush