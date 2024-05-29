@extends('backend.layouts.app')
@section('title', 'Cash On Delivery')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style type="text/css">
        .btn {
            padding: 4px 8px;
        }

        .btn i {
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
                            <h5>Cash on Delivery</h5>
                            <span>Create, Update, Delete Cash on Delivery</span>

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
                                <a href="{{ route('admin.cods.index') }}">Cash on Delivery</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Cash on Delivery</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row ">

            <div class="col-md-12">

                <form method="POST" action="{{ route('admin.cods.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>View Cash On Delivery Availablilty</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">


                                <div class="col-md-12">
                                    <div class="dt-responsive table-responsive">
                                        <table id="info-pages-table" class="table table-striped table-bordered nowrap"
                                            style="margin-left: 0px; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>{{ __('City Name') }}</th>
                                                    <th>{{ __('District Name') }}</th>
                                                    <th>{{ __('State Name') }}</th>
                                                    <th>{{ __('District') }}</th>
                                                    <th>{{ __('Available') }}</th>
                                                    <th>{{ __('Switch') }}</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cities as $key => $city)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $city->name }}</td>
                                                        <td>{{ $city->district->name }}</td>
                                                        <td>{{ $city->district->state->name }}</td>
                                                        <td>{{ $city->district->country->name }}</td>
                                                        <td id="cod-status-{{ $city->id }}">
                                                            {{ $city->cod == 1 ? 'Yes' : 'No' }}
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="cod-switch" data-cod-id="{{ $city->id }}" {{ $city->cod == 1 ? 'checked' : '' }}/>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Courier Rate') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete Courier Rate?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <a href="" class="btn btn-danger">{{ __('Yes, Delete It') }}</a>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')

    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <!-- Jquery Nestable -->
    <script>

        var elem = Array.prototype.slice.call(document.querySelectorAll('.cod-switch'));

        elem.forEach(function(html) {
            
            var switchery = new Switchery(html, {
                color: '#4099ff',
                jackColor: '#fff',
                size: 'small',
                secondaryColor: '#eb525d'
            });

            html.onchange = function(e) {
               var cod_id = $(this).data('cod-id');
               var checked_status = $(this).is(':checked') ? 'Yes' : 'No';

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.cods.change-cod-availability-status') }}",
                    data: {
                        "_token" : '{{ csrf_token() }}',
                        id : cod_id
                    },
                    beforeSend: function(){                
                        $('#modal-loader').show();
                    },
                    complete : function($response){
                        $('#modal-loader').hide();
                        var $status = $response.responseText;

                        if ($status == 'success') {
                            $("#cod-status-"+cod_id).html(checked_status);
                        }else{
                            showNotification('Error!','Something went Wrong!', 'danger', 'top-right');
                        }
                    }
                });
            };
        });

        $('#info-pages-table').DataTable({
            "lengthMenu": [ [25, 50, -1], [25, 50, "All"] ]
        });

        function delete_cod(id) {
            var conn = './cods/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
