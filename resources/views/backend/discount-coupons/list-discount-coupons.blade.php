@extends('backend.layouts.app')
@section('title', 'Discount Coupons  ')
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
                            <h5>Discount Coupons</h5>
                            <span>Create, Update, Delete Discount Coupons</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.discount-coupons.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.discount-coupons.index') }}">Discount Coupons</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Discount Coupons</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.discount-coupons.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Discount Coupons</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <d\iv class="dt-responsive">
                                        <table id="discount-coupons-table" class="table table-striped table-bordered nowrap" >
                                            <thead>
                                                <tr>
                                                    <th class="text-center">SN</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Code</th>
                                                    <th class="text-center">Discount %</th>
                                                    <th class="text-center">Max<br>Discount</th>
                                                    <th class="text-center">Discount<br>On</th>
                                                    {{-- <th class="text-center">Discount Items</th> --}}
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($discount_coupons as $key => $discount_coupon)
                                                <tr>
                                                    <td class="text-center">{{ $key+1 }}</td>
                                                    <td class="text-center">
                                                        <strong>{{ $discount_coupon->name }}</strong>
                                                    </td>
                                                    <td>
                                                        {{ $discount_coupon->code }}&emsp;
                                                        @if($discount_coupon->expire_date < date('Y-m-d'))
                                                            <span class="badge badge-warning">Expired</span>
                                                        @else
                                                            <span class="badge badge-success">Active</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $discount_coupon->discount_percentage }}</td>
                                                    <td>{{ $discount_coupon->maximum_discount }}</td>
                                                    @php
                                                        $discountOnArray = [1 => 'Selected Categories', 2 => 'Selected Products', 3 => 'All Products'];
                                                    @endphp
                                                    <td>{{ $discountOnArray[$discount_coupon->discount_on] }}</td>
                                                    {{-- <td>
                                                        @php
                                                            $discount_coupon_items = json_decode($discount_coupon->discount_items);
                                                            if ($discount_coupon->discount_on == 1) {
                                                                $discount_items = \App\Models\Category::whereIn('id', $discount_coupon_items)->get();
                                                            }else{
                                                                $discount_items = \App\Models\Product::whereIn('id', $discount_coupon_items)->get();
                                                            }
                                                        @endphp
                                                        @foreach($discount_items as $key => $discount_item)
                                                            <small class="">
                                                                {{ $discount_item->title }}
                                                            </small><br>
                                                        @endforeach
                                                    </td> --}}
                                                    
                                                    <td class="text-left">
                                                        <a href="{{ route('admin.discount-coupons.edit', base64_encode($discount_coupon->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>

                                                         <a href="#delete"
                                                            data-toggle="modal"
                                                            data-id="{{ $discount_coupon->id }}"
                                                            id="delete{{ $discount_coupon->id }}"
                                                            title="Delete" 
                                                            class="btn btn-outline-danger center-block"
                                                            onclick="delete_discount_coupon('{{ base64_encode($discount_coupon->id) }}')"><i class="fa fa-trash  "></i>
                                                        </a>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Discount Coupons')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete Discount Coupons?</p>
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
        $('#discount-coupons-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true
        });

        

        function delete_discount_coupon(id) {
            var conn = 'discount-coupons/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
