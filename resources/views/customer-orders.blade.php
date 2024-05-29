@extends('layouts.app')
@section('title', "Order History")
@push('post-css')

@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Order History
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li>Order History</li>

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
                            @if($orders->count() > 0)
                                <div class="col-sm-12">
                                    <div class="reward-point-feature">
                                        <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
                                        <div class="table-wrapper">
                                            <table id="check-out">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Order Number</th>
                                                    <th><small>Ordered Date</small></th>
                                                    <th>Total Price</th>
                                                    <th><small>Payment Method</small></th>
                                                    <th>Actions</th>
                                                </tr>
                                                @foreach($orders as $key => $order)
                                                <tr>
                                                    <td>
                                                        {{ $key+1 }}
                                                    </td>
                                                    <td>
                                                        <p>#{{ $order->order_no }}</p>
                                                    </td>
                                                    <td>
                                                        <small>{{ date('jS F,Y',strtotime($order->created_at)) }}</small>
                                                    </td>
                                                    {{-- <td>
                                                        <p>2021-05-27</p>
                                                    </td> --}}
                                                    <td>

                                                        Nrs.{{ $order->total_price }}
                                                    </td>
                                                    <td>
                                                        <small>{{ $payment_method[$order->payment_method] }}</small>
                                                        @if($order->payment_status != 1)
                                                            <br>
                                                            <small style="font-size: 10px; color: red;">[ Pending ]</small>
                                                        @else
                                                            <br>
                                                            <small style="font-size: 10px; color: green;">[ Paid ]</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <a href="{{ route('customer.view-order',['order_no' => base64_encode($order->order_no)]) }}">View Details</a>
                                                        </p>
                                                        
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </table>
                                        </div>
                                        <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
                                    </div>
                                    {{ $orders->links() }}
                                </div>
                            @else
                                <div class="col-md-12">
                                    <p class="alert alert-danger text-center">
                                        You haven't ordered any items yet.
                                    </p>
                                </div>
                            @endif
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