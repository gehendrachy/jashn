@extends('backend.layouts.app')
@section('title', 'Sales Report')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/nestable/nestable.css') }}"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
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
                            <h5>Sales Report</h5>
                            <span>Order Sales Report</span>

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
                                <a href="{{ route('admin.orders.index') }}">Sales Report</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Sales Report</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
    
                <div class="card border border-secondary">
                    <div class="card-header bg-default">
                        <h3> Sales Report</h3>
                    </div>
                    <div class="card-body mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ url()->full() }}" method="get">
                                    
                                    <div class="row">
                                        <div class="col-md-9 text-right">

                                            <div class="input-group">
                                                <input type="text" class="form-control" name="date_filter" id="date_filter"/>

                                                <div class="input-group-append">
                                                    <input type="submit" name="filter_submit" class="btn btn-sm btn-success" value="Filter" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <div class="dt-responsive">
                                    <table id="orders-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Order#</th>
                                                <th>Ordered On</th>
                                                <th>Customer Name</th>
                                                <th>Customer Email</th>
                                                {{-- <th>Status</th> --}}
                                                <th>Total Price</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $key => $order)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.orders.show', $order->order_no) }}">
                                                        <strong>#{{ $order->order_no }}</strong>
                                                    </a>
                                                </td>
                                                <td><small>{{ date('jS M, Y H:i:s', strtotime($order->created_at)) }}</small></td>
                                                <td>{{ $order->customer_name }}</td>
                                                <td>{{ $order->customer_email }}</td>
                                                {{-- <td id="orderStatus{{ $order->id }}">
                                                    <small class="badge badge-{{ $order_status[$order->status][1] }}" >
                                                        {{ $order_status[$order->status][0] }}
                                                    </small>
                                                </td> --}}
                                                <td>Nrs.{{ $order->total_price }}</td>
                                                
                                                {{-- <td class="text-left">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action </button>
                                                    <div class="dropdown-menu" style="">
                                                        @for($i = 0; $i < count($order_status); $i++)
                                                            <a href="javascript:void(0)" class="dropdown-item order-status-btn" data-order-id="{{ $order->id }}" data-status="{{ $i }}" href="">{{ $order_status[$i][0] }}</a>
                                                        {!! $i == 5 ? '<div role="separator" class="dropdown-divider"></div>' : '' !!}
                                                        @endfor
                                                    </div>
                                                </td> --}}
                                            
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Sales Report')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete Sales Report?</p>
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
        $('#orders-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            dom: 'Bfrtip',
            buttons: [ 'csv', 'excel', 'pdf', 'print']
        });

        
    </script>

    {{-- ===========================DATE FILTER =========================================== --}}
    <!-- Include Required Prerequisites -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    

    <script type="text/javascript">
        $(function () {
            let dateInterval = getQueryParameter('date_filter');
            let start = moment().startOf('isoWeek');
            let end = moment().endOf('isoWeek');
            if (dateInterval) {
                dateInterval = dateInterval.split(' - ');
                start = dateInterval[0];
                end = dateInterval[1];
            }
            $('#date_filter').daterangepicker({
                "showDropdowns": true,
                "showWeekNumbers": true,
                "alwaysShowCalendars": true,
                startDate: start,
                endDate: end,
                locale: {
                    format: 'YYYY-MM-DD',
                    firstDay: 1,
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                    'All time': [moment("01-01-2019", "DD-MM-YYYY"), moment().endOf('month')],
                }
            });
        });
        function getQueryParameter(name) {
            const url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>
@endpush
