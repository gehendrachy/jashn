@extends('backend.layouts.app')
@section('title', 'Courier Rates Page ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/nestable/nestable.css') }}" />
    <style type="text/css">
        .btn {
            padding: 4px 8px;
        }

        .btn i {
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
                            <h5>Courier Rates</h5>
                            <span>Create, Update, Delete Courier Rates</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.info-pages.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
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
                            <li class="breadcrumb-item active" aria-current="page">List Courier Rates</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.courier-rates.filters') }}" method="GET">
            <div class="row">
                <div class="col-sm-1">
                    <label for="">Filter By:</label>
                </div>
                <div class="col-sm-4">
                    <select name="country_id" class="form-control select2">
                        <option disabled value="" selected>--Select Country--</option>
                        @foreach ($parent_countries as $pCountry)
                            <option value="{{ $pCountry->id }}">{{ $pCountry->name }}</option>
                        @endforeach
                    </select>
                    <br>
                </div>
                <div class="col-sm-4">
    
                    <select name="state_id" class="form-control select2">
                        <option disabled value="" selected>--Select States--</option>
    
                        @foreach ($parent_states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    <br>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                </div>
    
            </div>


        </form>



        <div class="row ">
            
            <div class="col-md-12">

                <form method="POST" action="{{ route('admin.courier-rates.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Courier Rates</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">


                                <div class="col-md-12">
                                    <div class="dt-responsive table-responsive">
                                        <table id="info-pages-table" class="table table-striped table-bordered nowrap"
                                            style="margin-left: 0px; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>SN.</th>
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
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($courier_rates as $key => $courier_rate)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $courier_rate->district->name }}</td>
                                                        {{-- <td>{{ $courier_rate->country->name }}</td>
                                                        <td>{{ $courier_rate->state->name }}</td> --}}
                                                        <td>
                                                            {{ $courier_rate->half_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->one_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->one_half_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->two_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->two_half_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->three_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->three_half_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->four_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->four_half_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->five_kg }}
                                                        </td>
                                                        <td>
                                                            {{ $courier_rate->per_500g }}
                                                        </td>


                                                        <td>
                                                            <span class="content-right">


                                                                <a href="{{ route('admin.courier-rates.edit', base64_encode($courier_rate->id)) }}" class="btn btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>

                                                                <a href="#delete" data-toggle="modal"
                                                                    data-id="{{ $courier_rate->id }}"
                                                                    id="delete{{ $courier_rate->id }}" title="Delete"
                                                                    class="btn btn-outline-danger center-block"
                                                                    onclick="delete_rates('{{ base64_encode($courier_rate->id) }}')"><i
                                                                        class="fa fa-trash  "></i>
                                                                </a>
                                                            </span>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Courier Rate') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete Courier Rate?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <a href="" class="btn btn-danger">{{ __('Yes, Delete It') }}</a>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')

    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script>
    <!-- Jquery Nestable -->
    <script>
        // $('#info-pages-table').DataTable();

        function delete_rates(id) {
            var conn = './courier-rates/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
