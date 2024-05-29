@extends('backend.layouts.app')
@section('title', 'Cash On Delivery')
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
                            <h5>Cash On Delivery</h5>
                            <span>Create, Update, Delete Cash On Delivery</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.cods.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cods.index') }}">Cash On Delivery</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ request()->routeIs('admin.cods.edit') ? 'Update' : 'Create New' }} Cash On Delivery</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST"
                    action="{{ request()->routeIs('admin.cods.edit') ? route('admin.cods.update', $cod) : route('admin.cods.store') }}"
                    enctype="multipart/form-data">

                    @csrf

                    @if (request()->routeIs('admin.cods.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.cods.edit') ? 'Update Cash on Delivery' : 'Cash on Delivery' }}
                            </h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; State Name</label>
                                        </span>

                                        <select name="state_id" class="form-control select2" onchange="filterDistrict(this.value, '{{ request()->routeIs('admin.cods.edit') ? $cod->district_id : '0'}}')">
                                            <option selected disabled>--Select State--</option>
                                            @php 
                                                $country_id = old('state_id') ? old('state_id') : (request()->routeIs('admin.cods.edit') ? $cod->state_id : '');
                                            @endphp
                                            @foreach($parent_state as $pState)
                                                <option {{ $country_id == $pState->id ? 'selected' : '' }} value="{{ $pState->id }}">{{ $pState->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.cods.edit') ? $cod->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                

                                <div class="col-sm-4">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; District Name</label>
                                        </span>

                                        <select name="district_id" id="districtSelect" onchange="filterCity(this.value, '{{ request()->routeIs('admin.cods.edit') ? $cod->city_id : '0'}}')" class="form-control select2">
                                           
                                            @php 
                                                $district_id = old('district_id') ? old('district_id') : (request()->routeIs('admin.cods.edit') ? $cod->district_id : '');
                                                $district = App\Models\District::where('id',$district_id)->first();
                                            @endphp
                                            <option disabled value="" selected>--Select State First--</option>
                                            @if (request()->routeIs('admin.cods.edit'))
                                                <option {{ $district_id!=NULL ? 'selected' : '' }} value="{{ $district_id }}">{{ $district->name }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                          
                                <div class="col-sm-4">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; City Name</label>
                                        </span>
                                        @php 
                                        // $city = App\Models\City::where('id',$courier_rate->city_id)->first();
                                            $city_id = old('city_id') ? old('city_id') : (request()->routeIs('admin.cods.edit') ? $cod->city_id : '');
                                            $city = App\Models\City::where('id',$city_id)->first();
                                        @endphp


                                    <select name="city_id" id="citySelect" class="form-control select2">
                                        <option disabled value="" selected>---Select District First---</option>
                                        @if (request()->routeIs('admin.cods.edit'))
                                        <option {{ $city_id!=NULL ? 'selected' : '' }} value="{{ $city_id }}">{{ $city->name }}</option>
                                        @endif
                                    </select>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; COD Status</label>
                                        </span>
                                        <select name="status" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.cods.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        function filterDistrict(id,did){
            // console.log(name);
            // console.log(id);
            $.ajax({
                 type: 'post',
                 url: "{{route('admin.get_related_district')}}",
                 data: {"_token" : '{{ csrf_token() }}',
                        state_id : id,
                        district_id: did
                        },
                 complete : function($response){
                    //  console.log($response.responseText);    
                
                     $("#districtSelect").html($response.responseText);
                 }
            });
        }

        function filterCity(id,cid){
            // console.log(name);
            console.log(id);
            $.ajax({
                 type: 'post',
                 url: "{{route('admin.get_related_city')}}",
                 data: {"_token" : '{{ csrf_token() }}',
                        district_id : id,
                        city_id: cid
                        },
                 complete : function($response){
                    //  console.log($response.responseText);    
                     $("#citySelect").html($response.responseText);
                   
                 }
            });
        }
    </script>

@endsection
@push('script')
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.16.1/ckeditor.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery-all.min.js"></script>

    <script>
        $('.select2').select2();
    </script>
@endpush
