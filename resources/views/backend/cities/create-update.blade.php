@extends('backend.layouts.app')
@section('title', 'Cities')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        <i class="ik ik-anchor bg-blue"></i>
                        <div class="d-inline">
                            <h5>Cities</h5>
                            <span>Create, Update, Delete City</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.cities.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cities.index') }}">Cities</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ request()->routeIs('admin.cities.edit') ? 'Update' : 'Create New' }} City</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST"
                    action="{{ request()->routeIs('admin.cities.edit') ? route('admin.cities.update', $city) : route('admin.cities.store') }}"
                    enctype="multipart/form-data">

                    @csrf

                    @if (request()->routeIs('admin.cities.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.cities.edit') ? 'Update cities' : 'Create New Cities' }}
                            </h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; Country</label>
                                        </span>

                                        <select name="country_id" class="form-control select2" id="countrySelect" data-state-id="{{ old('state_id') ? old('state_id') : (request()->routeIs('admin.cities.edit') ? $city->district->state_id : '') }}">
                                            
                                            @php 
                                                $country_id = old('country_id') ? old('country_id') : (request()->routeIs('admin.cities.edit') ? $city->district->country_id : '');
                                            @endphp
                                            <option selected disabled>Select Country</option>
                                            @foreach($parent_countries as $pCountry)
                                                <option {{ $country_id == $pCountry->id ? 'selected' : '' }} value="{{ $pCountry->id }}">{{ $pCountry->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; State</label>
                                        </span>

                                        <select name="state_id" id="stateSelect" data-district-id="{{ old('district_id') ? old('district_id') : (request()->routeIs('admin.cities.edit') ? $city->district_id : 0) }}" class="form-control select2" required>

                                            <option disabled value="" selected>---Select Country First---</option>
                                            
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; District Name</label>
                                        </span>

                                        <select name="district_id" class="form-control select2" id="districtSelect">
                                            <option> -- Select State First -- </option>
                                            {{-- @php
                                             
                                                $district_id = old('district_id') ? old('district_id') : (request()->routeIs('admin.cities.edit') ? $city->district_id : '');
                                            @endphp
                                            @foreach($parent_district as $pDistrict)
                                                <option {{ $district_id == $pDistrict->id ? 'selected' : '' }} value="{{ $pDistrict->id }}">{{ $pDistrict->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                  
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; City
                                                Name</label>
                                        </span>
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter City Name" required
                                            value="{{ old('name') ? old('name') : (request()->routeIs('admin.cities.edit') ? $city->name : '') }}">
                                        @error('name')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="col-sm-4">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; City
                                                Pin Code</label>
                                        </span>
                                        <input name="pin_code" type="text"
                                            class="form-control @error('pin_code') is-invalid @enderror"
                                            placeholder="Enter Pin Code"
                                            value="{{ old('pin_code') ? old('pin_code') : (request()->routeIs('admin.cities.edit') ? $city->pin_code : '') }}">
                                        @error('pin_code')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.cities.edit') ? $city->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.cities.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.16.1/ckeditor.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery-all.min.js"></script>
    <script>
        // $('.select2').select2();

        if ($("#countrySelect").val() != null) {
            get_states($("#countrySelect").val(), $("#countrySelect").data('state-id'));
        }

        $("#countrySelect").change(function(){
            var id = $(this).val();
            var state_id = $(this).data('state-id');

            get_states(id, state_id);
        });

        function get_states(id, StId){
            
            $.ajax({
                 type: 'post',
                 url: "{{route('get-states')}}",
                 data: {
                            "_token" : '{{ csrf_token() }}',
                            country_id : id,
                            state_id: StId
                        },
                 complete : function($response){
                     // console.log($response.responseText);    
                     $("#stateSelect").html($response.responseText);

                     if ($("#stateSelect").val() != null) {
                        
                        get_districts($("#stateSelect").val(), $("#stateSelect").data('district-id'));
                     }
                 }
            });
        }

        $("#stateSelect").change(function(){
            var id = $(this).val();
            var district_id = $(this).data('district-id');

            get_districts(id, district_id);
        });

        function get_districts(id, district_id){
            
            $.ajax({
                 type: 'post',
                 url: "{{route('get-districts')}}",
                 data: {
                            "_token" : '{{ csrf_token() }}',
                            state_id : id,
                            district_id: district_id
                        },
                 complete : function($response){
                    //  console.log($response.responseText);    
                     $("#districtSelect").html($response.responseText);
                 }
            });
        }        


    </script>
@endpush
