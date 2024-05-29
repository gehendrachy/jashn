@extends('layouts.app')
@section('title', ' Return Request - #'.$return_request->return_request_no)
@push('post-css')

@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Return Request - #{{ $return_request->return_request_no }}
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li><a href="{{ route('customer.return-requests') }}">Return Requests /</a></li>
                            <li>Return Request - #{{ $return_request->return_request_no }}</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="cart mb-5">
        <div class="container">
            <h6>
                <a href="{{ route('customer.return-requests') }}"><small><i class="ti-arrow-left"></i></small> Go Back To Return Request History</a>
            </h6>
            <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
            <div class="table-wrapper">
                <table id="check-out">
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>MRP</th>
                        <th>Total</th>
                        {{-- <th>Estimated Delivery Date</th> --}}
                        <th>Status</th>
                    </tr>
                    @php
                        $totalPrice = 0;
                    @endphp
                    @foreach($return_request->return_request_products as $key => $return_request_product)
                        @php
                        
                        $product = \App\Models\Product::where("id", $return_request_product->product_id)->first();

                        $totalPrice += $return_request_product->sub_total;

                        @endphp
                        <tr style="{{ !isset($product) ? 'background-color: #ead7ce;'  : '' }}">
                            <td>
                                <div class="list">
                                    @if(isset($product))
                                        <div>   
                                            <a target="_blank" href="{{ route('product-details', ['slug' => $product->slug]) }}" >

                                                <img src="{{ asset('storage/products/'.$product->slug.'/thumbs/thumb_'.$product->image) }}" class="img-thumbnail" alt="{{ $product->slug }}" width="50">

                                            </a>
                                        </div>

                                    @else
                                    <div>
                                        <img src="https://place-hold.it/100x100/eeeef5?text=Image%20Unavailable&fontsize=8&italic&bold" width="50">
                                    </div>
                                    @endif

                                    <div class="detail">
                                        <p>
                                            <a target="_blank" href="{{ route('product-details', ['slug' => $product->slug]) }}" >
                                                {{ $product->title }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="mx-auto">
                                    <p>{{ $return_request_product->ordered_product->color_name }}</p>
                                    <p>{{ $return_request_product->ordered_product->size_name }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="mx-auto">
                                    <p>{{ $return_request_product->quantity }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="mrp">
                                    <p>Nrs.{{ $return_request_product->sub_total/$return_request_product->quantity }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="total-price">
                                    <p>Nrs.{{ $return_request_product->sub_total }}</p>
                                </div>
                            </td>
                            {{-- <td>
                                <div class="delivery">
                                    <p>2-5 Days</p>
                                </div>
                            </td> --}}
                            <td>
                                <div class="retur-request-date">
                                    <p class="label bg-{{ $return_status[$return_request_product->status][1] }}">{{ $return_status[$return_request_product->status][0] }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-right" colspan="4">
                            <strong>Grand Total</strong>
                        </td>
                        <td>
                            <strong>Nrs.{{ $totalPrice }}</strong>
                        </td>
                    </tr>
                </table>
            </div>
            <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>

        </div>
    </section>
@endsection
@push('post-scripts')
    <script>

        
    </script>
@endpush