@extends('backend.layouts.app')
@section('title', 'On Route Order - '.$on_route->name)
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
                            <li class="breadcrumb-item active" aria-current="page">{{ $on_route->name }}</li>
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
                                                            <a href="javascript:void(0)" class="dropdown-item order-status-btn" data-order-id="{{ $on_route->id }}" data-status="{{ $i }}" href="">{{ $order_status[$i][0] }}</a>

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
                                                                    <strong style="color: #dfa855;">{{ $on_route->name }}</strong>
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
                                                                    
                                                                    {{ date('jS F Y', strtotime($on_route->created_at)) }}
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
                                                                    
                                                                    <strong class="{{ $on_route->status == 2 ? 'text-primary' : 'text-info' }}">{{ $on_route->status == 2 ? 'On Route' : 'Arrived' }}</strong>
                                                                </span>
                                                            </span>
                                                            {{-- <select class="form-control" id="paymentMode">
                                                                <option value="2" {{ $on_route->status == 2 ? 'selected' : '' }}>
                                                                    On Route
                                                                </option>
                                                                <option value="3" {{ $on_route->status == 3 ? 'selected' : '' }}>
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
                                                                {{-- <th class="text-center"><strong>Status</strong></th> --}}
                                                                {{-- <th>Action</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $key = 0; @endphp
                                                            @foreach($db_on_route_ordered_products as $order_id => $onRoProd)
                                                                @php $key++; @endphp
                                                                <tr>
                                                                    <td>{{ $key }}</td>
                                                                    <td>
                                                                        @php
                                                                            $order = \App\Models\Order::find($order_id);
                                                                        @endphp
                                                                        <strong>#{{ $order->order_no }}</strong>
                                                                    </td>
                                                                    <td>
                                                                        @foreach($onRoProd as $on_route_ordered_product)
                                                                        {{ $on_route_ordered_product->ordered_product->product->title }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($onRoProd as $on_route_ordered_product)
                                                                        {{ $on_route_ordered_product->ordered_product->product_size->sku }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @foreach($onRoProd as $on_route_ordered_product)
                                                                        {{ $on_route_ordered_product->ordered_product->quantity }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            @endforeach
                                                                @if($on_route->on_route_product_sizes->count() > 0)
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
                                                                        @foreach($on_route->on_route_product_sizes as $on_route_product_size)
                                                                        {{ $on_route_product_size->product_size->product_color->product->title }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($on_route->on_route_product_sizes as $on_route_product_size)
                                                                        {{ $on_route_product_size->product_size->sku }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @foreach($on_route->on_route_product_sizes as $on_route_product_size)
                                                                        {{ $on_route_product_size->quantity }}<br>
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

        $(".ordered-product-status-btn").click(function(){
            var status = $(this).data('status');
            var ordered_product_id = $(this).data('ordered-product-id');

            $.ajax({
                url : "{{ URL::route('admin.orders.change-ordered-product-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        id: ordered_product_id,
                        status: status
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {
                        
                        $('#orderedProductStatus'+ordered_product_id).load(document.URL + ' #orderedProductStatus'+ordered_product_id+'>*');

                        showNotification('Status Updated!','', 'info', 'top-right');
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
