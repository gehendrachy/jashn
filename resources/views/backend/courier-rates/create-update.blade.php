@extends('backend.layouts.app')
@section('title', 'Courier Rates')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('backend/plugins/parsleyjs/css/parsley.css') }}">
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
                            <h5>Courier Rates</h5>
                            <span>Create, Update, Delete Courier Rates</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.courier-rates.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.courier-rates.index') }}">Courier Rates</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ request()->routeIs('admin.courier-rates.edit') ? 'Update' : 'Create New' }} Courier Rates</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form id="parsley-form" method="POST" action="{{ route('admin.courier-rates.create-update') }}" enctype="multipart/form-data">

                    @csrf
                    @if (request()->routeIs('admin.courier-rates.edit'))
                        @method('PUT')
                    @endif

                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.courier-rates.edit') ? 'Update Couriers Rate' : 'Create New Courier Rate' }}
                            </h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                

                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; Country</label>
                                        </span>

                                        <select id="countrySelect" name="country_id" class="form-control select2" data-state-id="{{ old('state_id') ? old('state_id') : (request()->routeIs('admin.courier-rates.edit') ? $courier_rate->state_id : '0')}}" onchange="get_states(this.value, '{{ old('state_id') }}')" required>
                                            <option disabled value="" selected>---Select Country---</option>
                                            @php 
                                                $country_id = old('country_id') ? old('country_id') : (request()->routeIs('admin.courier-rates.edit') ? $courier_rate->country_id : '');
                                            @endphp
                                            @foreach($parent_country as $pCountry)
                                                <option {{ $country_id == $pCountry->id ? 'selected' : '' }} value="{{ $pCountry->id }}">{{ $pCountry->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                          
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; State</label>
                                        </span>
                                        @php 
                                            // $state = App\Models\State::where('id',$courier_rate->state_id)->first();
                                            $state_id = old('state_id') ? old('state_id') : (request()->routeIs('admin.courier-rates.edit') ? $courier_rate->state_id : '');
                                            $state = App\Models\State::where('id',$state_id)->first();
                                        @endphp


                                        <select name="state_id" id="stateSelect" class="form-control select2" onchange="get_district_courier_rates(this.value)" required>
                                            <option disabled value="" selected>---Select Country First---</option>
                                            @if (request()->routeIs('admin.courier-rates.edit'))
                                                <option {{ $state_id!=NULL ? 'selected' : '' }} value="{{ $state_id }}">{{ $state->name }}</option>
                                            @endif
                                            
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <span class="input-group-prepend">
                             <b> Courier Rates </b>
                            </span>
                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-responsive table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>District</th>
                                                    <th>≤ 0.5kg</th>
                                                    <th>≤ 1kg</th>
                                                    <th>≤ 1.5kg</th>
                                                    <th>≤ 2kg</th>
                                                    <th>≤ 2.5kg</th>
                                                    <th>≤ 3kg</th>
                                                    <th>≤ 3.5kg</th>
                                                    <th>≤ 4kg</th>
                                                    <th>≤ 4.5kg</th>
                                                    <th>≤ 5kg</th>
                                                    <th class="text-center" style="font-size: 10px; padding: 3px;">>5kg <br>(per 500gm)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="courierRates">
                                                <tr>
                                                    <td class="text-center" colspan="13" style="background-color: #c5954c !important; color: white;"><strong >Select State First</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.courier-rates.index') }}" class="btn btn-danger">Cancel</a>
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
    <script src="{{ asset('backend/plugins/parsleyjs/js/parsley.min.js') }}"></script>

    <script>

        $(function() {
            $('#parsley-form').parsley();
            $(".select2").select2();
        });

        if ($("#countrySelect").val() != '') {
            get_states($("#countrySelect").val(), $("#countrySelect").data('state-id'));
        }

        function get_states(id, StId){
            // console.log(name);
            // console.log(id);
            $.ajax({
                 type: 'post',
                 url: "{{route('admin.get_related_states')}}",
                 data: {
                            "_token" : '{{ csrf_token() }}',
                            country_id : id,
                            state_id: StId
                        },
                 complete : function($response){
                    //  console.log($response.responseText);    
                     $("#stateSelect").html($response.responseText);
                     get_district_courier_rates($("#stateSelect").val());
                 }
            });
        }

        function get_district_courier_rates(stateId){
            // console.log(name);
            // console.log(stateId);

            $.ajax({
                type: 'post',
                url: "{{route('admin.get-district-courier-rates')}}",
                data: {
                    "_token" : '{{ csrf_token() }}',
                    state_id : stateId
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                    $("#courierRates").html('');
                },
                complete : function($response, $status){
                    $('#modal-loader').hide();
                    if ($status != "error" && $status != "timeout") {
                        
                        var obj = jQuery.parseJSON($response.responseText);

                        $("#courierRates").html(obj.tableResponse);

                        $(".active-status").change(function(){
                            var key = this.value;

                            if (this.checked) {
                                $('.active-inactive-'+key).attr('disabled',false);
                                $('.req-not-req-'+key).attr('required',true);

                            }else{
                                $('.active-inactive-'+key).attr('disabled',true);
                                $('.req-not-req-'+key).attr('required',false);

                            }
                        });

                        $(".decimal-input").keypress(function(event){
                            return isDecimalNumber(event, this);
                        });

                    }
                },
                error : function ($responseObj){

                    $('#modal-loader').hide();
                    alert("Something went wrong while processing your request.\n\nError => "
                        + $responseObj.responseText);
                    $('#modal-loader').hide();
                }
            });
        }
    </script>

    <script type="text/javascript">
        
        $(".decimal-input").keypress(function(event){
            return isDecimalNumber(event, this);
        });

        function isDecimalNumber(evt, element){ 

            var charCode = (evt.which) ? evt.which : event.keyCode 

            if  ((charCode != 46 || ($(element).val().match(/\./g) || []).length > 0) && (charCode < 48 || charCode > 57))
                return false; 
            return true; 
        }
    </script>

@endpush
