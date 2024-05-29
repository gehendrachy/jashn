@extends('layouts.app')
@section('title', "Billing & Shipping")
@push('post-css')
    <style>
        
        .other-field-wrapper i{
            position: absolute;
            right:8px;
            top:50%;
            transform: translateY(-50%);
            font-size:12px;
            color:red;
            z-index:9;
            opacity: 0.75;
        }
        .other-field-wrapper i:hover{
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Billing & Shipping
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li>Billing & Shipping</li>

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
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="#addNewAddressModal" data-toggle="modal" class="main-button colored mt-4">
                                <i class="mx-2 pt-2 fa fa-plus"></i> Add New Address
                            </a>
                        </div>
                        <div class="col-sm-8 text-sm-right">
                            <a href="#billingShippingAddressModal" data-toggle="modal" class="main-button colored mt-4 default-address-btn" data-type="shipping">
                                <i class="mx-2 pt-2 fa fa-sync"></i> Change Shipping Address
                            </a>
                            <a href="#billingShippingAddressModal" data-toggle="modal" class="main-button colored mt-4 default-address-btn" data-type="billing">
                                <i class="mx-2 pt-2 fa fa-sync"></i> Change Billing Address
                            </a>
                            <!-- <button type="submit" class="main-button colored mt-4">Checkout <i
                                    class="mx-2 ti-arrow-right"></i></button> -->
                        </div>

                    </div>
                    <hr>
                    <div class="dashboard-righs-sidebar">
                        <div class="table-wrapper">
                            <table id="check-out">
                                <tr>
                                    <th><strong>Full Name</strong></th>
                                    <th><strong>Email/Phone</strong></th>
                                    <th><strong>Address</strong></th>
                                    <th>Edit</th>
                                </tr>
                                @foreach($saved_addresses as $key => $address)
                                <tr>
                                    <td>
                                        <p>{{ $address->name }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $address->email }}</p>
                                        <p>{{ $address->phone }} {{ $address->phone2 != '' ? '| '.$address->phone2 : '' }}</p>
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
                                    <td>
                                        <a href="#editAddressModal" 
                                            data-toggle="modal" 
                                            data-id = "{{ $address->id }}" 
                                            class="main-button colored edit-address">
                                            <i class="mx-2 pt-2 pb-2 fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addNewAddressModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add new Address</h3>
                </div>
                 <form action="{{ route('customer.store-new-address') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-name">Name*</label>
                                <input type="text" name="name" placeholder="Name" id="input-name" class="form-control" value="{{ old('name') ? old('name') : (isset($customer->name) ? $customer->name : '') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="pan">Pan </label>
                                <input type="text" name="pan" placeholder="Eg: 88766676" class="form-control" value="{{ old('pan') }}">
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-num">Phone Number(Primary)*</label>
                                <input type="text" name="phone" placeholder="+977-123456789" id="input-num" class="form-control" value="{{ old('phone') ? old('phone') : (isset($customer->phone) ? $customer->phone : '') }}" required >
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-num2">Phone Number 2</label>
                                <input type="text" name="phone2" placeholder="+977-123456789" id="input-num2" class="form-control" value="{{ old('phone2') }}">
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-email">E-Mail*</label>
                                <input type="email" name="email" placeholder="E-Mail" id="input-email" class="form-control" value="{{ old('email') ? old('email') : (isset($customer->email) ? $customer->email : '') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label for="name">Country*</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherCountry" type="text" name="country_name" class="form-control other-country" placeholder="Enter Country Name" value="{{ old('country_name') }}">
                                    <i id="showCountrySelect" class="fa fa-times show-country-select"
                                        data-country-id="{{ old('country_id') ? old('country_id') : (isset($customer->country_id) ? $customer->country_id : 0) }}"
                                        data-state-id="{{ old('state_id') ? old('state_id') : (isset($customer->state_id) ? $customer->state_id : 0) }}" 
                                        data-district-id="{{ old('district_id') ? old('district_id') : (isset($customer->district_id) ? $customer->district_id : 0) }}" 
                                        data-city-id="{{ old('city_id') ? old('city_id') : (isset($customer->city_id) ? $customer->city_id : 0) }}" 
                                        data-country-input-id="countrySelect"
                                        data-state-input-id="stateSelect" 
                                        data-district-input-id="districtSelect" 
                                        data-city-input-id="citySelect"></i>
                                </div>
                                <select name="country_id" 
                                        id="countrySelect" 
                                        data-state-id="{{ old('state_id') ? old('state_id') : (isset($customer->state_id) ? $customer->state_id : 0) }}" 
                                        data-district-id="{{ old('district_id') ? old('district_id') : (isset($customer->district_id) ? $customer->district_id : 0) }}" 
                                        data-city-id="{{ old('city_id') ? old('city_id') : (isset($customer->city_id) ? $customer->city_id : 0) }}" 
                                        data-state-input-id="stateSelect" 
                                        data-district-input-id="districtSelect" 
                                        data-city-input-id="citySelect"
                                        class="w-100 py-1 form-control country-select" required>

                                    <option selected disabled>Select Country</option>
                                    @php
                                        $tempCountry = old('country_id') ? old('country_id') : (isset($customer->country_id) ? $customer->country_id : '');
                                    @endphp

                                    @foreach($countries as $country)
                                        <option <?=$tempCountry == $country->id ? 'selected' : '' ?> value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option value="0">Other</option>
                                </select>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="stateSelect">State*</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherState" type="text" name="state_name" class="form-control other-country" placeholder="Enter State Name" value="{{ old('state_name') }}">
                                </div>
                                <select name="state_id" 
                                        id="stateSelect" 
                                        data-district-id="{{ old('district_id') ? old('district_id') : (isset($customer->district_id) ? $customer->district_id : 0) }}" 
                                        data-city-id="{{ old('city_id') ? old('city_id') : (isset($customer->city_id) ? $customer->city_id : 0) }}" 
                                        data-district-input-id="districtSelect" 
                                        data-city-input-id="citySelect"
                                        class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select Country First</option>
                                </select>
                            </div>
                            
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="districtSelect">District*</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherDistrict" type="text" name="district_name" class="form-control other-country" placeholder="Enter District Here" value="{{ old('district_name') }}">
                                </div>
                                <select name="district_id" 
                                        id="districtSelect" 
                                        data-city-id="{{ old('city_id') ? old('city_id') : (isset($customer->city_id) ? $customer->city_id : 0) }}" 
                                        data-city-input-id="citySelect" 
                                        class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select State First</option>
                                </select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="citySelect">City*</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherCity" type="text" name="city_name" class="form-control other-country" placeholder="Enter City Name" value="{{ old('state_name') }}">
                                </div>
                                <select name="city_id" id="citySelect" class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select District First</option>
                                </select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="pin">Pin Code</label>
                                <input type="text" name="pin_code" value="{{ old('pin_code') }}" placeholder="Eg: +977" class="form-control">
                            </div>
                            
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="password">Street Address 1*</label>
                                <input type="text" name="street_address_1" value="{{ old('street_address_1') }}" placeholder="Eg: 23 burrow street" class="form-control" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="password">Street Address 2</label>
                                <input type="text" name="street_address_2" value="{{ old('street_address_2') }}" placeholder="Eg: 23 burrow street" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="main-button colored">Submit</button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAddressModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h3>Update Address Details</h3>
                </div>

                <form action="{{ route('customer.update-saved-address') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="addressId" value="">
                    
                    <div class="modal-body" id="updateDetails">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="main-button colored">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="billingShippingAddressModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="defaultAddressTitle">Make Default Billing/Shipping Address</h3>
                </div>
                <form action="{{ route('customer.make-default-address') }}" method="POST">
                    @csrf
                    <input type="hidden" name="address_type" value="" id="addressType">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <td><strong>Full Name</strong></td>
                                        <td><strong>Email/Phone</strong></td>
                                        <td><strong>Address</strong></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($saved_addresses as $key => $address)
                                        <tr>
                                            <td>
                                                <p>{{ $address->name }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $address->email }}</p>
                                                <p>{{ $address->phone }} {{ $address->phone2 != '' ? '| '.$address->phone2 : '' }}</p>
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
                                            <td>
                                                <input type="radio" name="address_id" value="{{ $address->id }}" {{ $key == 0 ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('post-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.1/umd/popper.min.js" integrity="sha512-8jeQKzUKh/0pqnK24AfqZYxlQ8JdQjl9gGONwGwKbJiEaAPkD3eoIjz3IuX4IrP+dnxkchGUeWdXLazLHin+UQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js" integrity="sha512-8qmis31OQi6hIRgvkht0s6mCOittjMa9GMqtK9hes5iEQBQE/Ca6yGE5FsW36vyipGoWQswBj/QBm2JR086Rkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        $(".default-address-btn").click(function(){

            var type = $(this).data('type');

            if (type == 'billing') {
                $("#defaultAddressTitle").html('Choose Default Billing Address');
                $("#addressType").val(1);
            }else{
                $("#defaultAddressTitle").html('Choose Default Shipping Address');
                $("#addressType").val(2);
            }

        });

        $(".edit-address").click(function(){
            
            var address_id = $(this).data('id');
            $("#addressId").val(address_id);

            $.ajax({
                url : "{{ URL::route('customer.edit-saved-address') }}",
                type: "POST",
                data: {
                        '_token' : '{{ csrf_token() }}',
                        address_id : address_id
                    },
                beforeSend: function () {

                },
                success: function (response) {
                    
                    $('#updateDetails').html(response); 

                    if ($("#editCountrySelect").val() != null) {

                       if ($("#editCountrySelect").val() != 0) {

                            $(".country-select").show();
                            $(".country-select").attr('required', true);

                            $(".other-field-wrapper").hide();
                            $(".other-country").attr('required', false);
                            $(".other-country").attr('disabled', true);

                            get_states(
                                        $('#editCountrySelect').val(), 
                                        $('#editCountrySelect').data('state-id'), 
                                        $('#editCountrySelect').data('district-id'), 
                                        $('#editCountrySelect').data('city-id'), 
                                        $('#editCountrySelect').data('state-input-id'), 
                                        $('#editCountrySelect').data('district-input-id'), 
                                        $('#editCountrySelect').data('city-input-id')
                                    );

                            if ($("#edtiStateSelect").val() != null) {

                                get_districts(
                                                $('#edtiStateSelect').val(), 
                                                $('#edtiStateSelect').data('district-id'), 
                                                $('#edtiStateSelect').data('city-id'), 
                                                $('#edtiStateSelect').data('district-input-id'), 
                                                $('#edtiStateSelect').data('city-input-id')
                                            );

                                if ($("#editDistrictSelect").val() != null) {
                                    get_cities(
                                                $("#editDistrictSelect").val(), 
                                                $('#editDistrictSelect').data('city-id'), 
                                                $('#editDistrictSelect').data('city-input-id')
                                            );
                                }
                            }

                        }else{

                            $(".country-select").hide();
                            $(".country-select").attr('required', false);

                            $(".other-field-wrapper").show();
                            $(".other-country").attr('required', true);
                            $(".other-country").attr('disabled', false);
                        }
                    }else{

                        $(".country-select").show();
                        $(".country-select").attr('required', true);

                        $(".other-field-wrapper").hide();
                        $(".other-country").attr('required', false);
                        $(".other-country").attr('disabled', true);
                    }

                    $("#editCountrySelect").change(function(){

                        if ($(this).val() != 0) {

                            var country_id = $(this).val();
                            var state_id = $(this).data('state-id');
                            var district_id = $(this).data('district-id');
                            var city_id = $(this).data('city-id');
                            var state_input_id =  $(this).data('state-input-id');
                            var district_input_id =  $(this).data('district-input-id');
                            var city_input_id =  $(this).data('city-input-id');


                            get_states(country_id, state_id, district_id, city_id, state_input_id, district_input_id, city_input_id);

                            $(".country-select").show();
                            $(".country-select").attr('required', true);

                            $(".other-field-wrapper").hide();
                            $(".other-country").attr('required', false);
                            $(".other-country").attr('disabled', true);

                        }else{

                            $(".country-select").hide();
                            $(".country-select").attr('required', false);

                            $(".other-field-wrapper").show();
                            $(".other-country").attr('required', true);
                            $(".other-country").attr('disabled', false);
                        }

                    });

                    $("#editStateSelect").change(function(){

                        var state_id = $(this).val();
                        var district_id = $(this).data('district-id');
                        var city_id = $(this).data('city-id');
                        var district_input_id = $(this).data('district-input-id');
                        var city_input_id = $(this).data('city-input-id');

                        get_districts(state_id, district_id, city_id, district_input_id, city_input_id);

                    });

                    $("#editDistrictSelect").change(function(){
                        var district_id = $(this).val();
                        var city_id = $(this).data('city-id');
                        var city_input_id = $(this).data('city-input-id');
                        get_cities(district_id, city_id, city_input_id);
                    });

                    $(".show-country-select").click(function(){
                        show_country_select(this);
                    });
                }
            });
        });

        if ($("#countrySelect").val() != null) {

            if ($("#countrySelect").val() != 0) {

                $(".country-select").show();
                $(".country-select").attr('required', true);

                $(".other-field-wrapper").hide();
                $(".other-country").attr('required', false);
                $(".other-country").attr('disabled', true);

                get_states(
                            $('#countrySelect').val(), 
                            $('#countrySelect').data('state-id'), 
                            $('#countrySelect').data('district-id'), 
                            $('#countrySelect').data('city-id'), 
                            $('#countrySelect').data('state-input-id'), 
                            $('#countrySelect').data('district-input-id'), 
                            $('#countrySelect').data('city-input-id')
                        );

                if ($("#stateSelect").val() != null) {
                    get_districts(
                                    $('#stateSelect').val(), 
                                    $('#stateSelect').data('district-id'), 
                                    $('#stateSelect').data('city-id'), 
                                    $('#stateSelect').data('district-input-id'), 
                                    $('#stateSelect').data('city-input-id')
                                );

                    if ($("#districtSelect").val() != null) {
                        get_cities(
                                    $("#districtSelect").val(), 
                                    $('#districtSelect').data('city-id'), 
                                    $('#districtSelect').data('city-input-id')
                                );
                    }
                }

            }else{

                $(".country-select").hide();
                $(".country-select").attr('required', false);

                $(".other-field-wrapper").show();
                $(".other-country").attr('required', true);
                $(".other-country").attr('disabled', false);
            }
        }else{

            $(".country-select").show();
            $(".country-select").attr('required', true);

            $(".other-field-wrapper").hide();
            $(".other-country").attr('required', false);
            $(".other-country").attr('disabled', true);

        }

        $("#countrySelect").change(function(){
            if ($(this).val() != 0) {

                var country_id = $(this).val();
                var state_id = $(this).data('state-id');
                var district_id = $(this).data('district-id');
                var city_id = $(this).data('city-id');
                var state_input_id =  $(this).data('state-input-id');
                var district_input_id =  $(this).data('district-input-id');
                var city_input_id =  $(this).data('city-input-id');

                get_states(country_id, state_id, district_id, city_id, state_input_id, district_input_id, city_input_id);

                $(".country-select").show();
                $(".country-select").attr('required', true);

                $(".other-field-wrapper").hide();
                $(".other-country").attr('required', false);
                $(".other-country").attr('disabled', true);

            }else{

                $(".country-select").hide();
                $(".country-select").attr('required', false);

                $(".other-field-wrapper").show();
                $(".other-country").attr('required', true);
                $(".other-country").attr('disabled', false);
            }
        });

        function get_states(country_id, state_id = 0, district_id = 0, city_id = 0, state_input_id, district_input_id, city_input_id) {
            $.ajax({
                url: "{{ route('get-states') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    country_id: country_id,
                    state_id: state_id
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    $('#'+state_input_id).html(response); 

                    if ($("#"+state_input_id).val() != null) {
                        get_districts($("#"+state_input_id).val(), district_id, city_id, district_input_id, city_input_id);
                    }else{
                        $("#"+district_input_id).html('<option selected disabled>Select State First</option>');
                        $("#"+city_input_id).html('<option selected disabled>Select District First</option>');
                    }

                    
                }
            });
        }

        $("#stateSelect").change(function(){
            var state_id = $(this).val();
            var district_id = $(this).data('district-id');
            var city_id = $(this).data('city-id');
            var district_input_id = $(this).data('district-input-id');
            var city_input_id = $(this).data('city-input-id');

            get_districts(state_id, district_id, city_id, district_input_id, city_input_id);
        });

        function get_districts(state_id, district_id = 0, city_id = 0, district_input_id, city_input_id) {
            $.ajax({
                url: "{{ route('get-districts') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    state_id: state_id,
                    district_id: district_id
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    $('#'+district_input_id).html(response); 

                    if ($("#"+district_input_id).val() != null) {
                        get_cities($("#"+district_input_id).val(), city_id, city_input_id);
                    }else{

                        $("#"+city_input_id).html('<option selected disabled>Select District First</option>');
                    }
                }
            });
        }

        $("#districtSelect").change(function(){
            var district_id = $(this).val();
            var city_id = $(this).data('city-id');
            var city_input_id = $(this).data('city-input-id');

            get_cities(district_id, city_id, city_input_id);
        });

        function get_cities(district_id, city_id = 0, city_input_id) {
            $.ajax({
                url: "{{ route('get-cities') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    district_id: district_id,
                    city_id: city_id
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    $('#'+city_input_id).html(response); 
                }
            });
        }

        $(".show-country-select").click(function(){
            show_country_select(this);
        });

        function show_country_select(that){


            var country_id = $(that).data('country-id');
            var state_id = $(that).data('state-id');
            var district_id = $(that).data('district-id');
            var city_id = $(that).data('city-id');
            var country_input_id =  $(that).data('country-input-id');
            var state_input_id =  $(that).data('state-input-id');
            var district_input_id =  $(that).data('district-input-id');
            var city_input_id =  $(that).data('city-input-id');

            get_states(country_id, state_id, district_id, city_id, state_input_id, district_input_id, city_input_id);

            $(".country-select").show();
            $(".country-select").attr('required', true);

            $(".other-field-wrapper").hide();
            $(".other-country").attr('required', false);
            $(".other-country").attr('disabled', true);

            $("#"+country_input_id).val(country_id);
        };
        
    </script>
@endpush