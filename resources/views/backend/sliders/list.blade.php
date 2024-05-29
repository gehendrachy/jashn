@extends('backend.layouts.app')
@section('title', 'Sliders  ')
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
                            <h5>Sliders</h5>
                            <span>Create, Update, Delete Sliders</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.sliders.index') }}">Sliders</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Sliders</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Sliders</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-responsive">
                                        <table id="sliders-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
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
                                                @foreach($sliders as $key => $slider)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        {{ $slider->title }}
                                                       
                                                    </td>
                                                    <td>
                                                        <img width="20%" class="img-thumbnail" src="{{ asset('storage/sliders/'.$slider->image) }}" alt="{{ $slider->title }}">
                                                    </td>
                                                    <td>
                                                        {{ $slider->url }}
                                                       
                                                    </td>
                                                    <td>
                                                        <span class="content-right">
                                            

                                                            <a href="{{ route('admin.sliders.edit', base64_encode($slider->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                            
                                                            <a href="#delete"
                                                               data-toggle="modal"
                                                               data-id="{{ $slider->id }}"
                                                               id="delete{{ $slider->id }}"
                                                               title="Delete" 
                                                               class="btn btn-outline-danger center-block"
                                                               onclick="delete_slider('{{ base64_encode($slider->id) }}')"><i class="fa fa-trash  "></i>
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
   
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Sliders')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete Sliders?</p>
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
        $('#sliders-table').DataTable();

        function delete_slider(id) {
            var conn = '../sliders/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
