@extends('backend.layouts.app')
@section('title', 'Products  ')
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
                            <h5>Products</h5>
                            <span>Create, Update, Delete Products</span>

                        </div>
                    </div>
                    <br>
                    <a href="" class="btn btn-primary btn-sm"> <i class="ik ik-download"></i> Export </a>
                    {{-- <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.products.index') }}">Products</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
             
                <div class="card border border-secondary">
                    <div class="card-header bg-default">
                        <h3>All Products</h3>
                    </div>
                    <div class="card-body mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dt-responsive">
                                    <table id="products-table" class="table table-striped table-bordered wrap" style="margin-left: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>SN.</th>
                                                <th>{{ __('Product')}}</th>
                                                <th>{{ __('SKU')}}</th>
                                                <th>{{ __('Variation')}}</th>
                                                <th>{{ __('Price')}}</th>
                                                <th>{{ __('Stock')}}</th>
                                                <th>{{ __('Created')}}</th>
                                                <th>{{ __('Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $key => $product)
                                            
                                            @php 
                                                $product_variation_sizes = $product->product_sizes;
                                            @endphp
                                            

                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center" width="20%">
                                                    @foreach($product->product_colors as $product_color)
                                                    <img width="35px" class="img-thumbnail" src="{{ asset('storage/products/'.$product->slug.'/variations/thumbs/thumb_'.$product_color->image) }}" alt="{{ $product->slug }}">
                                                    @endforeach
                                                    <br><br>

                                                    @if($product->display == 1)
                                                        <a target="_blank" href="{{ route('product-details',['slug' => $product->slug]) }}">{{ $product->title }}</a><br>
                                                        <i style="color: green;" class="fa fa-eye"></i>
                                                    
                                                    @else
                                                        {{ $product->title }}<br>
                                                        <i style="color: red;" class="fa fa-eye-slash"></i>
                                                    @endif
                                                    <br>
                                                    <i class="ik ik-anchor"></i> {{ $product->category->title }}
                                                    {{-- <br>
                                                    @foreach($product->occassions as $occassion)
                                                        <small class="mb-0 text-red">{{ $occassion->title }}</small>
                                                    @endforeach --}}
                                                </td>
                                                <td class="text-center">
                                                    @foreach($product_variation_sizes as $variation_key => $product_size)
                                                        <p style="font-size: 12px;">
                                                            <a target="_blank" href="{{ route('product-details', ['slug' => $product->slug, 'c' => $product_size->product_color->color->code]) }}">{{ $product_size->sku }} <i class="fa fa-sm fa-external-link-alt"></i></a>
                                                        </p>
                                                    @endforeach
                                                    
                                                </td>
                                                
                                                <td class="text-center">
                                                    @foreach($product_variation_sizes as $variation_key => $product_size)
                                                        
                                                        <p style="font-size: 12px;">
                                                            {{ $product_size->size->name }}, {{ $product_size->product_color->color->title }}
                                                        </p>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    @foreach($product_variation_sizes as $variation_key => $product_size)
                                                        <p style="font-size: 12px;">
                                                            NRs.{{ $product_size->price }}
                                                        </p>
                                                    @endforeach                                                        
                                                </td>
                                                <td class="text-center">
                                                    @foreach($product_variation_sizes as $variation_key => $product_size)
                                                        <p style="font-size: 12px;">
                                                            {{ $product_size->quantity }}
                                                            @if($product_size->preorder == 1)
                                                                ({{ $product_size->preorder_stock_limit }})
                                                            @endif
                                                        </p>
                                                    @endforeach
                                                </td>
                                                <td class="text-center" width="5%">
                                                    <p style="font-size: 12px;">
                                                        {{ date('jS F, Y', strtotime($product->created_at)) }}<br>
                                                        {{ date('h:i:s A', strtotime($product->created_at)) }}
                                                    </p>
                                                    @if($product->created_at != $product->updated_at && $product->updated_at != NULL)
                                                    <p style="font-size: 12px;">
                                                        Updated At
                                                        <small>{{ date('jS F, Y', strtotime($product->updated_at)) }}<br>
                                                        {{ date('h:i:s A', strtotime($product->updated_at)) }}</small>
                                                    </p>
                                                    @endif

                                                </td>
                                                <td class="text-left">
                                                    <span class="content-right">
                                                        <a class="text-blue edit-product-variation-stocks" style="text-decoration: underline;" href="#editVariations" data-toggle="modal" data-title="{{ $product->title }}" data-product-id="{{ $product->id }}">
                                                            <i class="ik ik-git-branch"></i> Edit Variations
                                                        </a>
                                                        <br><br>

                                                        <a href="{{ route('admin.products.edit', base64_encode($product->id)) }}" class="text-navy" title="Edit">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a> &nbsp; 

                                                        <a href="#delete"
                                                           data-toggle="modal"
                                                           data-id="{{ $product->id }}"
                                                           id="delete{{ $product->id }}"
                                                           title="Delete" 
                                                           class="text-danger center-block"
                                                           onclick="delete_product('{{ base64_encode($product->id) }}')" 
                                                          >
                                                           <i class="fa fa-trash"></i> Delete
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="editVariations">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.products.update-product-variation-stocks') }}" method="POST">
                    @csrf
                    <input type="hidden" id="productId" name="product_id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="product-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-responsive" width="100%">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Variation</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th style="font-size: 10px;">Pre Order</th>
                                        <th style="font-size: 8px;">Pre Order Stock Limit</th>
                                    </tr>
                                </thead>
                                <tbody id="productVariations">
                                    {{-- Dynamic Product Variations --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete Product?</p>
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
        $(".edit-product-variation-stocks").click(function(){
            var product_title = $(this).data('title');
            var product_id = $(this).data('product-id');

            $("#product-title").html(product_title);
            $("#productId").val(product_id);

            $.ajax({
                    url: "{{ URL::route('admin.products.edit-product-variation-stocks') }}",
                    type: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        product_id: product_id
                    },
                    cache:false,
                    beforeSend : function(){
                        // $('#modal-loader').show();
                        $("#productVariations").html('<div class="infinite-load"><img class="text-center center-block" src="{{ asset('frontend/images/ajax-loader.gif') }}" alt="Loading..." /></div>');
                    },
                    complete : function($response, $status){
                        // $('#modal-loader').hide();

                        if ($status != "error" && $status != "timeout" && $response.responseText != 'error') {
                            
                            $("#productVariations").html($response.responseText);

                            $(".preorder-checkbox").each(function(){
                                call_preorder_status_function(this);
                            });

                            $(".preorder-checkbox").change(function(){
                                call_preorder_status_function(this);
                            });

                        }else{

                            alert('Something went Wrong');
                        }
                    },
                    error : function ($responseObj){
                        alert("Something went wrong while processing your request.\n\nError => "
                            + $responseObj.responseText);
                        // $('#modal-loader').hide();
                    }
            });

            function call_preorder_status_function(that) {
                var stock_limit_class = $(that).data('limit-class');

                if (that.checked) {
                    
                    $('.'+stock_limit_class).attr('disabled',false);
                    $('.'+stock_limit_class).attr('required',true); 
                    
                }else{
                    $('.'+stock_limit_class).attr('disabled',true);
                    $('.'+stock_limit_class).attr('required',false);
                }
            }

        });

        $('#products-table').DataTable( {
            "autoWidth" : false
        });

        function delete_product(id) {
            var conn = './products/delete/' + id;
            $('#delete a').attr("href", conn);
        }

    </script>
@endpush
