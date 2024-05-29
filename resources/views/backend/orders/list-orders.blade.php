@extends('backend.layouts.app')
@section('title', 'Orders  ')
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

        .table tbody td {
          vertical-align: middle;
        }

        .badge{
            font-size: 60%;
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
                        <i class="ik ik-shopping-bag bg-blue"></i>
                        <div class="d-inline">
                            <h5>Orders</h5>
                            <span>View All Orders List</span>

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
                                <a href="{{ route('admin.orders.index') }}">Orders</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Orders</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.orders.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>
                                <a href="{{ route('admin.orders.add-new-order') }}" class="btn btn-primary">Create New Order</a>
                            </h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-responsive">
                                        <table id="orders-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Order#</th>
                                                    <th>Ordered On</th>
                                                    <th>Customer Name</th>
                                                    <th>Contact #</th>
                                                    <th>City</th>
                                                    <th>Payment Mode</th>
                                                    <th>Total Price</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $key => $order)
                                                <tr>
                                                    <td class="text-left">
                                                        <a href="{{ route('admin.orders.show', $order->order_no) }}">
                                                            <strong>#{{ $order->order_no }}</strong>
                                                        </a>
                                                        
                                                        @php
                                                            $new = $order->ordered_products()->where('status', 0)->count();
                                                        @endphp
                                                        @if($new > 0)
                                                        <small class="badge badge-warning" style="padding: 3px 6px; font-size: 70%;">
                                                            New
                                                        </small>
                                                        @endif
                                                    </td>
                                                    <td><small>{{ date('jS M, Y', strtotime($order->created_at)) }}</small></td>
                                                    <td>{{ $order->customer_name }}</td>
                                                    <td>{{ $order->customer_phone }}</td>

                                                    @php
                                                        $shipping_details = json_decode($order->shipping_details);
                                                        $shipping_city = \App\Models\City::where('id', $shipping_details->shipping_city_id)->first();
                                                        if ($shipping_city) {
                                                            $shipping_city_name = $shipping_city->name;
                                                        }else{
                                                            $shipping_city_name = $shipping_details->shipping_city_name;
                                                        }
                                                    @endphp
                                                    <td>{!! $shipping_city_name !!}</td>
                                                    <td>{{ $payment_method[$order->payment_method] }}</td>
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
                </form>
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Orders')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete Orders?</p>
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
            "autoWidth": false
        });

        $(".order-status-btn").click(function(){
            var status = $(this).data('status');
            var order_id = $(this).data('order-id');

            $.ajax({
                url : "{{ URL::route('admin.orders.change-order-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        id: order_id,
                        status: status
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {
                        
                        
                        $('#orderStatus'+order_id).load(document.URL + ' #orderStatus'+order_id+'>*');
                        if (status == 0) {
                            showNotification('Order Status changed to PENDING!','{{ session('status') }}', 'warning', 'top-right');
                        }else if (status == 1) {
                            showNotification('Order Status changed to NEW!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 2) {
                            showNotification('Order Status changed to ON ROUTE!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 3) {
                            showNotification('Order Status changed to ARRIVED!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 4) {
                            showNotification('Order Status changed to RTS!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 5) {
                            showNotification('Order Status changed to DELIVERED!','{{ session('status') }}', 'success', 'top-right');
                        }else if (status == 6) {
                            showNotification('Order Status changed to CANCELED!','{{ session('status') }}', 'error', 'top-right');
                        }else if (status == 7) {
                            showNotification('Order Status changed to RETURNED!','{{ session('status') }}', 'warning', 'top-right');
                        }
                        

                    }else {

                        toastr['error']('Something went wrong!');
                        

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
