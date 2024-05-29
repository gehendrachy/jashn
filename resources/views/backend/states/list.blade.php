@extends('backend.layouts.app')
@section('title', 'States  ')
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
                            <h5>States</h5>
                            <span>Create, Update, Delete States</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.info-pages.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.states.index') }}">States</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List States</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.states.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the States</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-responsive">
                                        <table id="info-pages-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>{{ __('State Name')}}</th>
                                                    <th>{{ __('Country')}}</th>
                                                    <th>{{ __('Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($states as $key => $state)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        {{ $state->name }}
                                                       
                                                    </td>
                                                    <td>
                                                        @php
                                                            $country = App\Models\Country::where('id',$state->country_id)->first();
                                                        @endphp
                                                        {{ $country->name }}

                                                    </td>
                                                    <td>
                                                        <span class="content-right">
                                                            

                                                            <a href="{{ route('admin.states.edit', base64_encode($state->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                            
                                                            <a href="#delete"
                                                               data-toggle="modal"
                                                               data-id="{{ $state->id }}"
                                                               id="delete{{ $state->id }}"
                                                               title="Delete" 
                                                               class="btn btn-outline-danger center-block"
                                                               onclick="delete_state('{{ base64_encode($state->id) }}')"><i class="fa fa-trash  "></i>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete State')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete State?</p>
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
        $('#info-pages-table').DataTable();

        function delete_state(id) {
            var conn = './states/delete/' + id;
            $('#delete a').attr("href", conn);
        }

    </script>
@endpush
