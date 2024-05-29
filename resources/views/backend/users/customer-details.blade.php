@extends('backend.layouts.app')
@section('title', 'View User  ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <style>
        .wrapper .page-wrap .main-content .page-header .page-header-title i {
            width: 50px !important;
            height: 50px !important;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user-check bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ $user->name }}</h5>
                            <span>Customer Details</span>
                        </div>
                    </div>
                    {{--                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"> <i--}}
                    {{--                            class="ik ik-plus"></i> Add New </a>--}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.customers.index') }}"><i class="ik ik-user"></i> Customers</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border border-secondary">
                    <div class="card-header bg-default">
                        <h3>Saved Addresses </h3>
                    </div>
                    <div class="card-body mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dt-responsive">
                                    <div class="table-wrapper">
                                        <table class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                
                                                <tr>
                                                    <th><strong>Full Name</strong></th>
                                                    <th><strong>Email/Phone</strong></th>
                                                    <th><strong>Address</strong></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($saved_addresses as $key => $address)
                                                <tr>
                                                    <td>
                                                        <p>{{ $address->name }}</p>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            {{ $address->email }} <br>
                                                            {{ $address->phone }} 
                                                            {{ $address->phone2 != '' ? '| '.$address->phone2 : '' }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            {{ $address->street_address_1 }} {{ $address->street_address_2 }}
                                                            
                                                            {{ isset($address->city) ? $address->city->name : $address->city_name }},<br>
                                                            
                                                            {{ isset($address->district) ? $address->district->name : $address->district_name }},
                                                            
                                                            {{ isset($address->state) ? $address->state->name : $address->state_name }},
                                                            {{ $address->pin_code }}

                                                            {{ isset($address->country) ? $address->country->name : $address->country_name }}
                                                        </p>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card border border-secondary">
                    <div class="card-header bg-default">
                        <h3>Order History </h3>
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
                                                    <a href="{{ route('admin.orders.show', $order->order_no) }}" target="_blank">
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
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border border-secondary">
                    <div class="card-header bg-default">
                        <h3>Subscription </h3>
                    </div>
                    <div class="card-body mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <p><i class="fa {{ $user->get_updates_via_sms == 1 ? 'fa-check-circle text-green' : 'fa-times-circle text-red'}}"></i> Get Updates Via SMS</p>
                                <p><i class="fa {{ $user->get_updates_via_email == 1 ? 'fa-check-circle text-green' : 'fa-times-circle text-red'}}"></i> Get Updates Via Email</p>
                                <p><i class="fa {{ $user->get_updates_on_chrome == 1 ? 'fa-check-circle text-green' : 'fa-times-circle text-red'}}"></i> Get Updates Via Chrome</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')

    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>

    <script>
        $('#orders-table').DataTable( {
            "autoWidth" : false,
            "ordering" : false
        });
    </script>
@endpush