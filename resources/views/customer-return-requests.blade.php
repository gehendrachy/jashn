@extends('layouts.app')
@section('title', "Returns")
@push('post-css')

@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Returns
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li>Returns</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-wrapper pt40 pb40">
            <div class="row">
                @include('customer-sidebar')
                <div class="col-sm-9">
                    
                    <div class="dashboard-righs-sidebar">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="reward-point-feature">
                                    <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
                                    <div class="table-wrapper">
                                        <table id="check-out">
                                            <tr>
                                                <th>SN</th>
                                                <th>Return ID</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Reason</th>
                                                <th>Image</th>
                                                <th>Total Price</th>
                                                <th>Requested On</th>
                                            </tr>
                                            @if($return_request_products->count() > 0)
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
                                                        <br>
                                                        <small>
                                                            <a href="{{ route('customer.view-order',['order_no' => base64_encode($return_request_product->ordered_product->order->order_no)]) }}" target="_blank">
                                                                #{{ $return_request_product->ordered_product->order->order_no }}
                                                            </a>
                                                            
                                                        </small>
                                                    </td>
                                                    <td><p>{{ $return_request_product->quantity }}</p></td>
                                                    <td><p>{{ $return_request_reasons[$return_request_product->reason] }}</p></td>
                                                    <td>
                                                        <img src="{{ asset('storage/return-requests/'.$return_request_product->image) }}" alt="no-image" width="30%">
                                                    </td>
                                                    
                                                    <td>Nrs.{{ round($return_request_product->sub_total) }}</td>

                                                    <td><p>{{ date('jS F,Y',strtotime($return_request_product->created_at)) }}</p></td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" colspan="text-center">
                                                        <p>You haven't requested for any Returns.</p>
                                                    </td>
                                                </tr>
                                            @endif

                                        </table>
                                    </div>
                                    <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('post-scripts')
    <script>

        
    </script>
@endpush