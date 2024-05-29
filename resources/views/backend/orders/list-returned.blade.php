@extends('backend.layouts.app')
@section('title', 'Returned Orders ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <style type="text/css">
        .btn {
            padding: 4px 8px !important;
        }

        .btn i {
            margin-right: 0px;
        }

        .btn-sm {
            padding: 3px 6px !important;
            font-size: 11px !important;
            height: 24px !important;
        }

        .badge {
            padding: 4px 6px;
            font-size: 10px;
            font-weight: 500;
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
                            <h5>Returned Orders</h5>
                            <span>Create, Update, Delete Returned Orders</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.orders.index') }}">Returned Orders</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Returned Orders</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">

                <div class="card border border-secondary">
                    {{-- <div class="card-header bg-default">
                        <h3>
                            <a href="{{ route('admin.orders.returned.create') }}" class="btn btn-primary text-right">Create New</a>
                        </h3>
                    </div> --}}
                    <div class="card-body mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dt-responsive">
                                    <table id="orders-table" class="table table-striped table-bordered nowrap"
                                        style="margin-left: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Product#</th>
                                                <th>Created On</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($returned as $key => $row)   
                                                    <tr id="onRouteRow{{ $row->id }}">
                                                        <td class="text-center">
                                                            {{-- <a href="{{ route('admin.orders.show', $row->order_no) }}"> --}}
                                                                <strong>{{ $row->product_title }}</strong>
                                                            {{-- </a> --}}
                                                        </td>

                                                        <td><small>{{ date('jS M, Y H:i:s', strtotime($row->created_at)) }}</small>
                                                        </td>

                                                        <td id="onRouteStatus{{ $row->id }}">

                                                            @if ($row->status == 7)
                                                                <small class="badge badge-secondary">
                                                                    returned
                                                                </small>
                                                            @else
                                                                <small class="badge badge-dark">
                                                                    RTS
                                                                </small>
                                                            @endif

                                                        </td>

                                                        <td class="text-left">
                                                            {{ $row->remarks }}
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

            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete returned Orders') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete returned Orders?</p>
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
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script><!-- Jquery Nestable -->
    <script>
        $('#orders-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        $(".returned-status-btn").click(function() {
            var status = $(this).data('status');
            var on_route_id = $(this).data('on-route-id');

            $.ajax({
                url: "{{ URL::route('admin.orders.arrived.change-arrived-status') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: on_route_id,
                    status: status
                },
                beforeSend: function() {

                },
                success: function(response) {
                    console.log("response " + response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.status == 'success') {


                        $('#onRouteStatus' + on_route_id).load(document.URL + ' #onRouteStatus' +
                            on_route_id + '>*');

                        if (status == 2) {
                            showNotification('On Route Status changed to ON ROUTE!',
                                '{{ session('status') }}', 'info', 'top-right');
                        } else if (status == 3) {
                            showNotification('On Route Status changed to returned!',
                                '{{ session('status') }}', 'info', 'top-right');
                        }

                    } else {

                        showNotification('Something went Wrong', '{{ session('status') }}', 'danger',
                            'top-right');


                    };
                }
            });
        });



        function delete_order(id) {
            var conn = 'orders/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
