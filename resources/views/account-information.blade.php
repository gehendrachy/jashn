@extends('layouts.app')
@section('title', "Acccount Information")
@push('post-css')

@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Acccount Information
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li>Account Information</li>

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
                                    <form action="{{ route('customer.update-account-information') }}" method="POST">
                                        @csrf
                                        <h6>Update Account Information</h6>
                                        <hr>
                                        <div class="row">
                                            <div class="mb-2 col-sm-6">
                                                <label class="control-label" for="input-name">Name</label>
                                                <input type="text" name="name" placeholder="Name" id="input-name" class="form-control" value="{{ old('name') ? old('name') : (isset($customer->name) ? $customer->name : '') }}" required>
                                            </div>
                                            <div class="mb-2 col-sm-6">
                                                <label class="control-label" for="input-num">Phone Number</label>
                                                <input type="text" name="phone" placeholder="+977-123456789" id="input-num" class="form-control" value="{{ $customer->phone }}" required disabled>
                                            </div>
                                            <div class="mb-2 col-sm-6">
                                                <label class="control-label" for="input-email">E-Mail</label>
                                                <input type="email" name="email" placeholder="E-Mail" id="input-email" class="form-control" value="{{ $customer->email }}" required disabled=>
                                            </div>
                                            <div class="mb-2 col-sm-6">
                                                <label for="name">Country</label>
                                                <select name="country_id" id="countrySelect" data-state-id="{{ old('state_id') ? old('state_id') : (isset($customer->state_id) ? $customer->state_id : 0) }}" class="w-100 py-1 form-control" required>
                                                    <option selected disabled>Select Country</option>
                                                    @php
                                                        $tempCountry = old('country_id') ? old('country_id') : (isset($customer->country_id) ? $customer->country_id : '');
                                                    @endphp

                                                    @foreach($countries as $country)
                                                        <option <?=$tempCountry == $country->id ? 'selected' : '' ?> value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-2 col-sm-6">
                                                <label class="control-label" for="input-email">State</label>
                                                <select name="state_id" id="stateSelect" data-district-id="{{ old('district_id') ? old('district_id') : (isset($customer->district_id) ? $customer->district_id : 0) }}" class="w-100 py-1 form-control" required>
                                                    <option selected disabled>Select Country First</option>
                                                </select>
                                            </div>
                                            <div class="mb-2 col-sm-6">
                                                <label class="control-label" for="input-email">District</label>
                                                <select name="district_id" id="districtSelect" data-city-id="{{ old('city_id') ? old('city_id') : (isset($customer->city_id) ? $customer->city_id : 0) }}" class="w-100 py-1 form-control" required>
                                                    <option selected disabled>Select State First</option>
                                                </select>
                                            </div>
                                            <div class="mb-2 col-sm-6">
                                                <label class="control-label" for="input-email">City</label>
                                                <select name="city_id" id="citySelect" class="w-100 py-1 form-control" required>
                                                    <option selected disabled>Select District First</option>
                                                </select>
                                            </div>
                                            {{-- <div class="mb-2 col-sm-6">
                                                <label class="control-label" for="input-email">Address</label>
                                                <input type="text" name="address" placeholder="eg: Baneswor, Kathmandu" id="" class="form-control" value="{{ old('address') ? old('address') : (isset($customer->address) ? $customer->address : '') }}">
                                            </div> --}}
                                        </div>
                                        <br>
                                        <h6>Change Password <small>(Leaving these empty will keep your current password)</small></h6>
                                        <hr>
                                        <div class="row">
                                            <div class="mb-2 col-sm-4">
                                                <label class="control-label" for="password">Old Password</label>
                                                <input type="password" name="old_password" placeholder="Password"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-2 col-sm-4">
                                                <label class="control-label" for="password">New Password</label>
                                                <input type="password" name="password" placeholder="Password"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-2 col-sm-4">
                                                <label class="control-label" for="input-confirm">Re-enter Password
                                                    Confirm</label>
                                                <input type="password" name="password_confirmation" value=""
                                                    placeholder="Password Confirm" class="form-control">
                                            </div>
                                        </div>

                                        <button class="main-button colored">Update Information</button>
                                    </form>
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
        if ($("#countrySelect").val() != null) {
            get_states($("#countrySelect").val(), $("#countrySelect").data('state-id'));

            if ($("#stateSelect").val() != null) {
                get_districts($("#stateSelect").val(), $('#stateSelect').data('district-id'));

                if ($("#districtSelect").val() != null) {
                    get_cities($("#districtSelect").val(), $('#districtSelect').data('city-id'));
                }
            }
        }

        $("#countrySelect").change(function(){
            var country_id = $(this).val();
            var state_id = $(this).data('state-id');
            get_states(country_id, state_id);
        });

        function get_states(country_id, state_id = 0) {
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
                    $('#stateSelect').html(response); 

                    if ($("#stateSelect").val() != null) {
                        get_districts($("#stateSelect").val(), $('#stateSelect').data('district-id'));
                    }else{
                        $("#districtSelect").html('<option selected disabled>Select State First</option>');
                        $("#citySelect").html('<option selected disabled>Select District First</option>');
                    }

                    
                }
            });
        }

        $("#stateSelect").change(function(){
            var state_id = $(this).val();
            var district_id = $(this).data('district-id');
            get_districts(state_id, district_id);
        });

        function get_districts(state_id, district_id = 0) {
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
                    $('#districtSelect').html(response); 
                    if ($("#districtSelect").val() != null) {
                        get_cities($("#districtSelect").val(), $('#districtSelect').data('city-id'));
                    }else{

                        $("#citySelect").html('<option selected disabled>Select District First</option>');
                    }
                }
            });
        }

        $("#districtSelect").change(function(){
            var district_id = $(this).val();
            var city_id = $(this).data('city-id');
            get_cities(district_id, city_id);
        });

        function get_cities(district_id, city_id = 0) {
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
                    $('#citySelect').html(response); 
                }
            });
        }
        
    </script>
@endpush