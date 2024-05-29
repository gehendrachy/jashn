@extends('backend.layouts.app')
@section('title', 'Return Requests  ')
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
                        <i class="ik ik-anchor bg-blue"></i>
                        <div class="d-inline">
                            <h5>Return Requests</h5>
                            <span>Create, Update, Delete Return Requests</span>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.return-requests.index') }}">Return Requests</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Return Requests</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.return-requests.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>View Return Requests</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <d\iv class="dt-responsive">
                                        <table id="return-requests-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Return ID</th>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Reason</th>
                                                    <th>Image</th>
                                                    <th>Total Price</th>
                                                    <th>Requested On</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 @php
                                                    $return_request_reasons = [
                                                        1 => 'Damage',
                                                        2 => 'Different Product',
                                                        3 => 'Size not Fit',
                                                        4 => 'Spl Request'
                                                    ];
                                                @endphp
                                                @foreach($return_request_products as $key => $return_request_product)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td><p>#{{ $return_request_product->return_request_no }}</p></td>
                                                    <td>
                                                        <p>{{ $return_request_product->ordered_product->product_title }}</p>
                                                        
                                                        <small>
                                                            <a href="{{ route('customer.view-order',['order_no' => base64_encode($return_request_product->ordered_product->order->order_no)]) }}" target="_blank">
                                                                #{{ $return_request_product->ordered_product->order->order_no }}
                                                            </a>
                                                            
                                                        </small>
                                                    </td>
                                                    <td><p>{{ $return_request_product->quantity }}</p></td>
                                                    <td><p>{{ $return_request_reasons[$return_request_product->reason] }}</p></td>
                                                    <td>
                                                        <img src="{{ asset('storage/return-requests/'.$return_request_product->image) }}" alt="no-image" width="70px">
                                                    </td>
                                                    
                                                    <td>Nrs.{{ round($return_request_product->sub_total) }}</td>

                                                    <td><p>{{ date('jS F,Y',strtotime($return_request_product->created_at)) }}</p></td>
                                                    
                                                    <td class="return-request-product-status text-center" id="returnRequestProductStatus{{ $return_request_product->id }}" width="10%">
                                                        <small class="badge badge-{{ $return_status[$return_request_product->status][1] }}" >
                                                            {{ $return_status[$return_request_product->status][0] }}
                                                        </small>
                                                    </td>

                                                    <td class="text-left">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action </button>
                                                        <div class="dropdown-menu" style="">
                                                            @for($i = 0; $i < count($return_status); $i++)
                                                                <a href="javascript:void(0)" class="dropdown-item return-request-product-status-btn" data-return-request-product-id="{{ $return_request_product->id }}" data-status="{{ $i }}">{{ $return_status[$i][0] }}</a>
                                                            @endfor
                                                        </div>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Return Requests')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete Return Requests?</p>
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
        $('#return-requests-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false
        });

        $(".return-request-product-status-btn").click(function(){
            var status = $(this).data('status');
            var return_request_product_id = $(this).data('return-request-product-id');

            $.ajax({
                url : "{{ URL::route('admin.return-requests.change-return-request-product-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        id: return_request_product_id,
                        status: status
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {
                        
                        $('#returnRequestProductStatus'+return_request_product_id).load(document.URL + ' #returnRequestProductStatus'+return_request_product_id+'>*');

                        showNotification('Status Updated!','', 'info', 'top-right');
                    }else {
                        showNotification('Something went wrong!!','' , 'danger', 'top-right');
                        
                        
                    };
                }
            });
        });

        // $(".return-request-status-btn").click(function(){
        //     var status = $(this).data('status');
        //     var return_request_id = $(this).data('return-request-id');

        //     $.ajax({
        //         url : "{{ URL::route('admin.return-requests.change-return-request-status') }}",
        //         type : "POST",
        //         data :{ '_token': '{{ csrf_token() }}',
        //                 id: return_request_id,
        //                 status: status
        //             },
        //         beforeSend: function(){                

        //         },
        //         success : function(response)
        //         {
        //             console.log("response "+ response);
        //             var obj = jQuery.parseJSON( response);

        //             if (obj.status == 'success') {
                        
                        
        //                 $('#returnRequestStatus'+return_request_id).load(document.URL + ' #returnRequestStatus'+return_request_id+'>*');
        //                 if (status == 0) {
        //                     showNotification('Return Request Status changed to PENDING!','{{ session('status') }}', 'warning', 'top-right');
        //                 }else if (status == 1) {
        //                     showNotification('Return Request Status changed to NEW!','{{ session('status') }}', 'info', 'top-right');
        //                 }else if (status == 2) {
        //                     showNotification('Return Request Status changed to ON ROUTE!','{{ session('status') }}', 'info', 'top-right');
        //                 }else if (status == 3) {
        //                     showNotification('Return Request Status changed to ARRIVED!','{{ session('status') }}', 'info', 'top-right');
        //                 }else if (status == 4) {
        //                     showNotification('Return Request Status changed to RTS!','{{ session('status') }}', 'info', 'top-right');
        //                 }else if (status == 5) {
        //                     showNotification('Return Request Status changed to DELIVERED!','{{ session('status') }}', 'success', 'top-right');
        //                 }else if (status == 6) {
        //                     showNotification('Return Request Status changed to CANCELED!','{{ session('status') }}', 'error', 'top-right');
        //                 }else if (status == 7) {
        //                     showNotification('Return Request Status changed to RETURNED!','{{ session('status') }}', 'warning', 'top-right');
        //                 }
                        

        //             }else {

        //                 toastr['error']('Something went wrong!');
                        

        //             };
        //         }
        //     });
        // });

    </script>
@endpush
