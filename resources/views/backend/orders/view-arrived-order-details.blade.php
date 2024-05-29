@extends('backend.layouts.app')
@section('title', 'Arrived Order - '.$arrived->name)
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
                        <i class="ik ik-shopping-bag bg-blue"></i>
                        <div class="d-inline">
                            <h5>Orders</h5>
                            <span>View Order Orders</span>

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
                            <li class="breadcrumb-item active" aria-current="page">{{ $arrived->name }}</li>
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
                        {{-- <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Orders</h3>
                        </div> --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border border-default card-solid">

                                            <div class="card-header with-border justify-content-between">
                                                
                                                {{-- <h3 class="card-title">Order Details</h3> --}}

                                                
                                                    {{-- <button id="status-all" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                                                        Change Status for all product <span class="caret"></span>
                                                    </button>

                                                    <div class="dropdown-menu" style="">
                                                        @for($i = 0; $i < count($order_status); $i++)
                                                            <a href="javascript:void(0)" class="dropdown-item order-status-btn" data-order-id="{{ $arrived->id }}" data-status="{{ $i }}" href="">{{ $order_status[$i][0] }}</a>

                                                        @endfor
                                                    </div> --}}

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-1">
                                                            <span class="input-group-prepend">
                                                                <label class="input-group-text" style="min-width: 170px;">
                                                                    <i class="ik ik-shopping-bag"></i>&nbsp; Tag Name 
                                                                </label>
                                                            </span>
                                                            <span class="input-group-append">
                                                                <span class="input-group-text" style="min-width: 208px; background-color: #fff;">
                                                                    <strong style="color: #dfa855;">{{ $arrived->name }}</strong>
                                                                </span>
                                                            </span>
                                                        </div>

                                                        <div class="input-group mb-1">
                                                            <span class="input-group-prepend">
                                                                <label class="input-group-text" style="min-width: 170px;">
                                                                    <i class="ik ik-shopping-bag"></i>&nbsp;  Created Date 
                                                                </label>
                                                            </span>
                                                            <span class="input-group-append">
                                                                <span class="input-group-text" style="min-width: 208px; background-color: #fff;">
                                                                    
                                                                    {{ date('jS F Y', strtotime($arrived->created_at)) }}
                                                                </span>
                                                            </span>
                                                        </div>

                                                        <div class="input-group mb-1">
                                                            <span class="input-group-prepend">
                                                                <label class="input-group-text" style="min-width: 170px;">
                                                                    <i class="ik ik-shopping-bag"></i>&nbsp;  Status 
                                                                </label>
                                                            </span>
                                                            <span class="input-group-append">
                                                                <span class="input-group-text" style="min-width: 208px; background-color: #fff;">
                                                                    
                                                                    <strong class="{{ $arrived->status == 2 ? 'text-primary' : 'text-info' }}">{{ $arrived->status == 2 ? 'On Route' : 'Arrived' }}</strong>
                                                                </span>
                                                            </span>
                                                            {{-- <select class="form-control" id="paymentMode">
                                                                <option value="2" {{ $arrived->status == 2 ? 'selected' : '' }}>
                                                                    On Route
                                                                </option>
                                                                <option value="3" {{ $arrived->status == 3 ? 'selected' : '' }}>
                                                                    Arrived
                                                                </option>
                                                            </select> --}}
                                                        </div>

                                                    </div>
                                                </div>
                                                    
                                                
                                                
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table header-border table-hover" id="orderTable">
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th>SN.</th>
                                                                <th>Order No</th>
                                                                <th><strong>Products</strong></th>
                                                                <th><strong>SKU</strong></th>
                                                                <th class="text-center"><strong>Quantity</strong></th>
                                                                <th class="text-center"><strong>Status</strong></th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $key = 0; @endphp
                                                            @foreach($arrived_ordered_products as $order_id => $arrivedProd)
                                                                @php 
                                                                    $key++; 
                                                                    $ordered_product = $arrivedProd->pluck('ordered_product')->first();
                                                                @endphp

                                                                <tr style="{{ in_array($ordered_product->status, [6,7,8]) ? 'background-color: #ffd7d7;' : '' }}">
                                                                    <td>{{ $key }}</td>
                                                                    <td>
                                                                        @php
                                                                            $order = \App\Models\Order::find($order_id);
                                                                        @endphp
                                                                        <strong>
                                                                            <a target="_blank" href="{{ route('admin.orders.show', $order->order_no) }}">#{{ $order->order_no }}</a>
                                                                        </strong>
                                                                    </td>
                                                                    <td>
                                                                        
                                                                        @foreach($arrivedProd as $arrived_ordered_product)
                                                                            {{ $arrived_ordered_product->ordered_product->product->title }}<br>
                                                                        @endforeach

                                                                        @if(in_array($ordered_product->status, [6,7,8]) && $ordered_product->remarks != NULL)
                                                                            <br>
                                                                            <strong style="color: red; font-size: 11px; text-decoration: underline;">
                                                                                {{ $ordered_product->remarks }}
                                                                            </strong>
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        @foreach($arrivedProd as $arrived_ordered_product)
                                                                        {{ $arrived_ordered_product->ordered_product->product_size->sku }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @foreach($arrivedProd as $arrived_ordered_product)
                                                                        {{ $arrived_ordered_product->ordered_product->quantity }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    
                                                                    <td id="arrivedOrderStatus{{ $order_id }}">
                                                                        <small class="badge badge-{{ $order_status[$arrivedProd[0]->status][1] }}">
                                                                            {{ $order_status[$arrivedProd[0]->status][0] }}
                                                                        </small>
                                                                        
                                                                        {{-- @if(isset($arrivedProd[0]) && $arrivedProd[0]->status == 3)
                                                                            <small class="badge badge-success" >
                                                                                Arrived
                                                                            </small>
                                                                            
                                                                        @elseif(isset($arrivedProd[0]) && $arrivedProd[0]->status == 4)
                                                                            <small class="badge badge-dark" >
                                                                                RTS
                                                                            </small>
                                                                        @endif --}}

                                                                    </td>

                                                                    <td>
                                                                        @if(isset($arrivedProd[0]) && $arrivedProd[0]->status == 3)
                                                                        <button id="arrivedOrderBtn{{ $order_id }}" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change Status </button>
                                                                        <div class="dropdown-menu" style="">

                                                                            <a href="javascript:void(0)" class="dropdown-item arrived-status-btn" data-on-route-id="{{ $arrived->id }}" data-on-route-order-id="{{ $order_id }}" data-status="4">RTS</a>

                                                                            <a href="#cancelModal" class="dropdown-item arrived-status-btn" data-toggle="modal" data-on-route-id="{{ $arrived->id }}" data-on-route-order-id="{{ $order_id }}" data-status="6" href="">Canceled</a>

                                                                            <a href="#failedModal" class="dropdown-item arrived-status-btn" data-toggle="modal" data-on-route-id="{{ $arrived->id }}" data-on-route-order-id="{{ $order_id }}" data-status="8">Failed</a>

                                                                        </div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                                @if($arrived->on_route_product_sizes->count() > 0)
                                                                <tr>
                                                                    <th colspan="5" class="text-center">
                                                                        Additional Products
                                                                    </th>
                                                                </tr>

                                                                
                                                                @php $key++; @endphp
                                                                <tr>
                                                                    <td>{{ $key }}</td>
                                                                    <td></td>
                                                                    <td>
                                                                        @foreach($arrived->on_route_product_sizes as $arrived_product_size)
                                                                        {{ $arrived_product_size->product_size->product_color->product->title }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($arrived->on_route_product_sizes as $arrived_product_size)
                                                                        {{ $arrived_product_size->product_size->sku }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @foreach($arrived->on_route_product_sizes as $arrived_product_size)
                                                                        {{ $arrived_product_size->quantity }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                                
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="failedModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Change Status')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.orders.arrived.change-arrived-product-status') }}" method="POST">
                    @csrf
                    <input id="onRouteId_failed" type="hidden" name="on_route_id" value="">
                    <input id="onRouteOrderId_failed" type="hidden" name="order_id" value="">
                    <input id="onRouteStatus_failed" type="hidden" name="status" value="">
                    <div class="modal-body">
                        <p>Are you sure, you want to change status?</p>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Reason</label>
                            </span>
                            <select class="form-control" name="remarks" required>
                                @for($i=1; $i <= count($failed_reasons); $i++)
                                    <option value="{{ $failed_reasons[$i] }}">{{ $failed_reasons[$i] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Change Status')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.orders.arrived.change-arrived-product-status') }}" method="POST">
                    @csrf
                    <input id="onRouteId_canceled" type="hidden" name="on_route_id" value="">
                    <input id="onRouteOrderId_canceled" type="hidden" name="order_id" value="">
                    <input id="onRouteStatus_canceled" type="hidden" name="status" value="">
                    <div class="modal-body">
                        <p>Are you sure, you want to change status?</p>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Reason</label>
                            </span>
                            <select class="form-control" name="remarks" required>
                                @for($i=1; $i <= count($canceled_reasons); $i++)
                                    <option value="{{ $canceled_reasons[$i] }}">{{ $canceled_reasons[$i] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes, Cancel It')}}</button>
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
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        $(".arrived-status-btn").click(function(){

            var status = $(this).data('status');
            var on_route_id = $(this).data('on-route-id');
            var on_route_order_id = $(this).data('on-route-order-id');

            if (status == 8) {

                $("#onRouteStatus_failed").val(status);
                $("#onRouteId_failed").val(on_route_id);
                $("#onRouteOrderId_failed").val(on_route_order_id);
                return;
            }

            if (status == 6) {

                $("#onRouteStatus_canceled").val(status);
                $("#onRouteId_canceled").val(on_route_id);
                $("#onRouteOrderId_canceled").val(on_route_order_id);
                return;
            }

            

            $.ajax({
                url : "{{ URL::route('admin.orders.arrived.change-arrived-product-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        on_route_id: on_route_id,
                        order_id: on_route_order_id,
                        status: status
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {
                        
                        $('#arrivedOrderStatus'+on_route_order_id).load(document.URL + ' #arrivedOrderStatus'+on_route_order_id+'>*');
                        $('#arrivedOrderBtn'+on_route_order_id).hide();

                        showNotification('Order Status Updated!','', 'info', 'top-right');
                    }else {
                        showNotification('Something went wrong!!','' , 'danger', 'top-right');
                        
                        
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
