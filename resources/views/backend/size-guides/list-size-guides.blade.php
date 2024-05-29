@extends('backend.layouts.app')
@section('title', 'Size Guides  ')
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
                            <h5>Size Guides</h5>
                            <span>Create, Update, Delete Size Guides</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.size-guides.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <a class="btn btn-primary" href="{{ route('admin.size-guides.create') }}"><i class="fa fa-plus"></i> Add New Size Guide</a>
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.size-guides.index') }}">Size Guides</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Size Guides</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.size-guides.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3> Size Guides List</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-responsive">
                                        <table id="size-guides-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Name')}}</th>
                                                    <th>{{ __('Size Group')}}</th>
                                                    <th>{{ __('Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($size_guides))
                                                    @foreach($size_guides as $size_guide)
                                                    <tr>
                                                        <td>
                                                            {{ $size_guide->name }}
                                                            @if($size_guide->display == 1)
                                                            
                                                                <i style="color: green;" class="fa fa-eye"></i>
                                                            
                                                            @else
                                                            
                                                                <i style="color: red;" class="fa fa-eye-slash"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $size_guide->size_group->name }}
                                                        </td>
                                                        <td>
                                                            <span class="content-right">

                                                                {{-- <a href="{{ route('admin.size-guides.edit', base64_encode($size_guide->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a> --}}

                                                                <a href="#viewSizeGuide"
                                                                   data-toggle="modal"
                                                                   data-id="{{ $size_guide->id }}"
                                                                   title="Delete" 
                                                                   class="btn btn-outline-success center-block view-size-guide"><i class="fa fa-eye"></i>
                                                               </a>
                                                                
                                                                @if(!array_key_exists("children", (array)$size_guide))
                                                                <a href="#delete"
                                                                   data-toggle="modal"
                                                                   data-id="{{ $size_guide->id }}"
                                                                   id="delete{{ $size_guide->id }}"
                                                                   title="Delete" 
                                                                   class="btn btn-outline-danger center-block"
                                                                   onclick="delete_size_guide('{{ base64_encode($size_guide->id) }}')"><i class="fa fa-trash  "></i>
                                                               </a>
                                                               @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endif
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

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Size Guide')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete size guide?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                    <a href="" class="btn btn-danger">{{ __('Yes, Delete It')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewSizeGuide" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Size Guide Details')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="sizeGuideTable">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
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
        $('#size-guides-table').DataTable({
            'ordering' : false
        });

        function delete_size_guide(id) {
            var conn = './size-guides/delete/' + id;
            $('#delete a').attr("href", conn);
        }

        $(".view-size-guide").click(function(){
            var size_id = $(this).data('id');

            $.ajax({
                url : "{{ URL::route('admin.size-guides.view-size-guide') }}",
                type : "POST",
                data : {
                    '_token': '{{ csrf_token() }}',
                    id: size_id
                },
                cache : false,
                beforeSend : function (){
                    $("#sizeGuideTable").html('');
                    $('#modal-loader').show();
                },
                complete : function($response, $status){
                    $('#modal-loader').hide();

                    if ($status != "error" && $status != "timeout" && $response.responseText != 'error') {
                        
                        $("#sizeGuideTable").html($response.responseText);

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

        });

    </script>
@endpush
