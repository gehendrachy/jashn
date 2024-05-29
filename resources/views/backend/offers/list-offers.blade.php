@extends('backend.layouts.app')
@section('title', 'Offers  ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/nestable/nestable.css') }}"/>
    <style type="text/css">
        .btn{
            padding: 4px 8px;
        }
        .btn i{
            margin-right: 0px;
        }

        .badge {
          padding: 4px 6px;
          font-size: 10px;
          font-weight: 500;
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
                            <h5>Offers</h5>
                            <span>Create, Update, Delete Offers</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.offers.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.offers.index') }}">Offers</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Offers</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.offers.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Offers</h3>
                        </div>
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <d\iv class="dt-responsive">
                                        <table id="offers-table" class="table table-striped table-bordered nowrap" >
                                            <thead>
                                                <tr>
                                                    <th class="text-center">SN</th>
                                                    <th class="text-center">Offer Name</th>
                                                    <th width="4%" class="text-center">Offer Type</th>
                                                    <th class="text-center">Discount %</th>
                                                    <th class="text-center">Max<br>Discount</th>
                                                    <th class="text-center">Discount<br>On</th>
                                                    <th class="text-center">Time Duration</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                                @foreach($offers as $key => $offer)
                                                <tr>
                                                    <td class="text-center">{{ $key+1 }}.</td>
                                                    <td class="text-center">
                                                        <strong>{{ $offer->name }}</strong><br>
                                                        @if($offer->start_date > date('Y-m-d'))
                                                            <small class="badge badge-info">Coming Soon</small>
                                                        @elseif($offer->expire_date < date('Y-m-d'))
                                                            <small class="badge badge-danger">Expired</small>
                                                        @elseif($offer->start_date <= date('Y-m-d') && $offer->expire_date >= date('Y-m-d'))
                                                            <small class="badge badge-success">On Going</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $offerType = [
                                                                        '1' => 'Buy X Quantity get X Amount Off',
                                                                        '2' => 'Spend X Amount get X Amount Off',
                                                                        '3' => 'Free Shipping Offer'
                                                                    ]
                                                        @endphp
                                                        <small>{{ $offerType[$offer->offer_type] }}</small>
                                                    </td>
                                                    <td>{{ $offer->discount_percentage }}</td>
                                                    <td>{{ $offer->maximum_discount }}</td>

                                                    <td>{{ $discount_on_array[$offer->discount_on]}}</td>
                                                    <td class="text-center">
                                                        <small>
                                                            {{ date('jS M, Y', strtotime($offer->start_date)) }} <br> to <br>

                                                            {{ date('jS M, Y', strtotime($offer->expire_date)) }}
                                                        </small>
                                                    </td>
                                                    
                                                    <td class="text-left">
                                                        {{-- @if($offer->start_date > date('Y-m-d') || $offer->expire_date < date('Y-m-d'))   --}}
                                                            <a href="{{ route('admin.offers.edit', base64_encode($offer->id)) }}" style="text-decoration: underline;" class="text-navy" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                        {{-- @endif --}}
                                                        <br>

                                                        <a href="#delete"
                                                            data-toggle="modal"
                                                            data-id="{{ $offer->id }}"
                                                            id="delete{{ $offer->id }}"
                                                            title="Delete" 
                                                            class="text-danger center-block"
                                                            onclick="delete_offer('{{ base64_encode($offer->id) }}')"><i class="fa fa-trash  "></i> Delete
                                                        </a>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Offers')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete Offers?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                    <a href="" class="btn btn-danger">{{ __('Yes, Delete It')}}</a>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@push('script')

    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script><!-- Jquery Nestable -->
    <script>
        $('#offers-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth" : false
        });

        

        function delete_offer(id) {
            var conn = 'offers/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
