@extends('backend.layouts.app')
@section('title', 'Size Guides  ')
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
    <div class="table-responsive">
        <table class="table table-bordered">
            @php
                $size_guide_units = json_decode($size_guide->units);
                $size_guide_sizes = json_decode($size_guide->sizes);
            @endphp
            <thead>
                <tr>
                    <th>Sizes</th>
                    @foreach($size_guide_units as $unit)
                        <th>{{ $unit->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($size_guide_sizes as $key => $size)
                    <tr>
                        <td>{{ $size->name }}</td>

                        @foreach($size_guide_units as $unit)
                            <td>{{ $unit->value[$key] }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-anchor bg-blue"></i>
                        <div class="d-inline">
                            <h5>Size Guides</h5>
                            <span>Create, Update, Delete Size Guides</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.size-guides.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.size-guides.index') }}">Size Guides</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.size-guides.edit') ? 'Update' : 'Create New' }} Size Guide</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.size-guides.edit') ? route('admin.size-guides.update',$size_guide) : route('admin.size-guides.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.size-guides.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.size-guides.edit') ? 'Update Size Guide' : 'Create New Size Guide' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Size Guide Title" required value="{{ old('name') ? old('name') : (request()->routeIs('admin.size-guides.edit') ? $size_guide->name : '') }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Size Group</label>
                                        </span>
                                        <select id="selectSizeGroup" class="form-control" name="size_group_id" required="">
                                            <option selected disabled>Select Size Group</option>
                                            @foreach($size_groups as $size_group)
                                                @php 
                                                    $tSize_group_id = old('size_group_id') ? old('size_group_id') :  (request()->routeIs('admin.size-guides.edit') ? $size_guide->size_group_id : '');
                                                @endphp
                                                <option {{ $tSize_group_id == $size_group->id ? 'selected' : ''  }} value="{{ $size_group->id }}">{{ $size_group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            
                                <div class="col-md-2">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.size-guides.edit') ? $size_guide->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox"><strong>{{ __('Display Status')}}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border border-secondary mb-0" id="sizeGuideDetails" style="display: none;">
                                <div class="card-header bg-default p-2">
                                    <strong class="mb-0 mr-3">Enter Size Guide Details </strong> 
                                    <button type="button" id="addColumnButton" class="btn btn-outline-info">Add Column</button>  
                                </div>
                                <div class="card-body" id="sizeGuideTable">
                                </div>
                                {{-- <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" id="addColumnButton" class="btn btn-info">Add Column</button>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.size-guides.index') }}" class="btn btn-danger">Cancel</a>
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

        $("#addColumnButton").click(function(){
            var column_count = $(".unit-name-input").length;
            // alert(column_count);
            column_count++;
            $(".unit-row").append('<th class="column-'+column_count+'"><div class="input-group mb-0"><input class="form-control unit-name-input" type="text" name="unit['+column_count+'][name]" required placeholder="Unit Name"><span class="input-group-append"><button onclick="remove_column('+column_count+')" type="button" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash mr-0"></i></button></span></div></th>');

            // $(".unit-row").append('<th><input class="form-control unit-name-input" type="text" name="unit['+column_count+'][name]" required placeholder="Unit Name"></th>');
            $(".value-row").append('<td class="column-'+column_count+'"><input class="form-control" type="text" name="unit['+column_count+'][value][]" required placeholder="Enter Value"></td>');
        });

        $("#selectSizeGroup").change(function(){
            var size_group_id = $(this).val();
            get_sizes(size_group_id);
        });

        var size_group_id = $("#selectSizeGroup").val();
        if(size_group_id != null){
            get_sizes(size_group_id);
        }

        function get_sizes(size_group_id) {
            $.ajax({
                url : "{{ URL::route('admin.size-guides.get-sizes') }}",
                type : "POST",
                data : {
                    '_token' : '{{ csrf_token() }}',
                    id : size_group_id
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();

                },
                complete : function($response, $status){

                    $('#modal-loader').hide();
                    $("#sizeGuideDetails").show();

                    if ($status != "error" && $status != "timeout" && $response.responseText != 'error') {
                        
                        $("#sizeGuideTable").html($response.responseText);
                    }else{

                        alert('Something went Wrong');
                    }
                }
            });
        }

        function remove_column(key) {
            swal({
                title: "Are you sure?",
                text: "It will remove this Question Section with its All Sub Sections!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true

            }, function (isConfirm) {
                if (isConfirm) {
                    $(".column-"+key).remove();
                }
            });
        }
        function remove_size_input(that) {

            swal({
                title: "Are you sure?",
                text: "It will remove this Question Section with its All Sub Sections!",
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
                            url : "{{ URL::route('admin.size-guides.delete-size') }}",
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