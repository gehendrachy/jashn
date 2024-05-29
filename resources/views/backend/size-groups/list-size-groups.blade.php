@extends('backend.layouts.app')
@section('title', 'Size Groups  ')
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
                            <li class="breadcrumb-item active" aria-current="page">List Size Groups</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.size-groups.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Size Groups</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-responsive">
                                        <table id="size-groups-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Name')}}</th>
                                                    <th>{{ __('Sizes')}}</th>
                                                    <th>{{ __('Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($size_groups as $size_group)
                                                <tr>
                                                    <td>
                                                        {{ $size_group->name }}
                                                        @if($size_group->display == 1)
                                                        
                                                            <i style="color: green;" class="fa fa-eye"></i>
                                                        
                                                        @else
                                                        
                                                            <i style="color: red;" class="fa fa-eye-slash"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @foreach($size_group->sizes as $size)
                                                            <span class="badge badge-pill badge-secondary mb-1">{{ $size->name }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <span class="content-right">

                                                            <a href="{{ route('admin.size-groups.edit', base64_encode($size_group->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                            
                                                            @if(!array_key_exists("children", (array)$size_group))
                                                            <a href="#delete"
                                                               data-toggle="modal"
                                                               data-id="{{ $size_group->id }}"
                                                               id="delete{{ $size_group->id }}"
                                                               title="Delete" 
                                                               class="btn btn-outline-danger center-block"
                                                               onclick="delete_size_group('{{ base64_encode($size_group->id) }}')"><i class="fa fa-trash  "></i>
                                                           </a>
                                                           @endif
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

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Size Group')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete size group?</p>
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
        $('#size-groups-table').DataTable();

        function delete_size_group(id) {
            var conn = './size-groups/delete/' + id;
            $('#delete a').attr("href", conn);
        }

    </script>
@endpush
