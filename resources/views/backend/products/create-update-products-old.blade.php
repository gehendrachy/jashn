@extends('backend.layouts.app')
@section('title', 'Products')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .wrapper .page-wrap .main-content .page-header .page-header-title i {
            width: 50px !important;
            height: 50px !important;
        }
    </style>
@endpush
@section('content')

    <?php
        function displayCategories($list, $selectedCategory, $arrow_count = 0){
            foreach ($list as $item){

                // $parent = DB::table('categories')->where('id', $item->parent_id)->first();
                // $arrowText = $item->parent_id != 0 ? $parent->title : '';
                $arrowText = '';
                for ($i=0; $i < $arrow_count; $i++) { 
                    $arrowText .= '--';
                }
                $item->title = $arrowText.' '.$item->title;

                //if ($item->parent_id != 0) {
                    //$parent = DB::table('categories')->where('id',$item->parent_id)->first();
                    // $item->title = $parent->title.' → '.$item->title;
                //}
                ?>
                <option 
                    <?=$item->child == 1 ? 'disabled' : 'style="color:#eb525d;"' ?> 
                    @php 
                        if ($selectedCategory != 0 && $item->id == $selectedCategory) {
                            echo "selected";
                        }
                    @endphp 
                    value="{{$item->id}}">
                        {{ $item->title}}
                </option>
                <?php 
                if (property_exists($item, "children")){
                    $arrow_count++;
                    displayCategories( $item->children, $selectedCategory, $arrow_count);
                    $arrow_count--;
                }
            }
        }

    ?>
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
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.products.edit') ? 'Update' : 'Creat New' }} Product</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.products.edit') ? route('admin.products.update',$product) : route('admin.products.store') }}" enctype="multipart/form-data">
                    
                    @csrf
                    @if(request()->routeIs('admin.products.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.products.edit') ? 'Update Product' : 'Create New Product' }}</h3>
                        </div>
                        <div class="card-body ">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Title</label>
                                        </span>
                                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Product Title" required value="{{ old('title') ? old('title') : (request()->routeIs('admin.products.edit') ? $product->title : '') }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                            
                                <div class="col-md-6">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $display = old('display') ? old('display') : (request()->routeIs('admin.products.edit') ? $product->display : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="displayCheckbox" name="display" value="1" {{ $display == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="displayCheckbox">{{ __('Display Status')}}</label>
                                        </div>

                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $featured = old('featured') ? old('featured') : (request()->routeIs('admin.products.edit') ? $product->featured : 0);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="featuredCheckbox" name="featured" value="1" {{ $featured == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="featuredCheckbox">{{ __('Featured Status')}}</label>
                                        </div>
                                    
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            @php
                                                $stock_status = old('stock_status') ? old('stock_status') : (request()->routeIs('admin.products.edit') ? $product->stock_status : 1);
                                            @endphp
                                            <input class="border-checkbox" type="checkbox" id="stockStatusCheckbox" name="stock_status" value="1" {{ $stock_status == 1 ? 'checked' : '' }}>
                                            <label class="border-checkbox-label" for="stockStatusCheckbox">{{ __('Stock Status')}}</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-anchor"></i>&nbsp; Category</label>
                                        </span>
                                        

                                        <select name="category_id" class="form-control form-control-inverse select2" required>
                                            <option selected disabled>Choose Product Category</option>
                                            @php
                                                $selectedCategory = old('category_id') ? old('category_id') : (request()->routeIs('admin.products.edit') ? $product->category_id : '');
                                            @endphp
                                            
                                            {{ displayCategories($categories, $selectedCategory) }}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="fa fa-male"></i><i class="fa fa-female"></i>&nbsp; Gender</label>
                                        </span>
                                        

                                        <select name="gender" class="form-control form-control-inverse" required>
                                            @php
                                                $selectedGender = old('gender') ? old('gender') : (request()->routeIs('admin.products.edit') ? $product->gender : '');
                                            @endphp
                                            @for($i=1; $i<=count($genders); $i++)
                                                <option {{ $genders[$i] == $selectedGender ? 'selected' : '' }} value="{{ $genders[$i] }}">{{ $genders[$i] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-dollar"></i>&nbsp; Price</label>
                                        </span>
                                        <input name="price" type="text" class="form-control @error('price') is-invalid @enderror" placeholder="Products Price" value="{{ old('price') ? old('price') : (request()->routeIs('admin.products.edit') ? $product->price : '') }}" required>
                                        @error('price')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-dollar"></i>&nbsp; Offer Price</label>
                                        </span>
                                        <input name="offer_price" type="text" class="form-control @error('offer_price') is-invalid @enderror" placeholder="Products Offer Price" value="{{ old('offer_price') ? old('offer_price') : (request()->routeIs('admin.products.edit') ? $product->offer_price : '') }}">
                                        @error('offer_price')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-youtube"></i>&nbsp; Video Link</label>
                                        </span>
                                        <input name="video_link" type="text" class="form-control @error('video_link') is-invalid @enderror" placeholder="Youtube Video Link (Optional)" value="{{ old('video_link') ? old('video_link') : (request()->routeIs('admin.products.edit') ? $product->video_link : '') }}">
                                        @error('video_link')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-bar-chart-2"></i>&nbsp; Size Guide</label>
                                        </span>
                                        

                                        <select name="size_guide_id" class="form-control form-control-inverse">
                                            <option value="">None</option>
                                            @php
                                                $selectedSizeGuide = old('size_guide_id') ? old('size_guide_id') : (request()->routeIs('admin.products.edit') ? $product->size_guide_id : '');
                                            @endphp
                                            @foreach($size_guides as $size_guide)
                                                <option {{ $size_guide->id == $selectedSizeGuide ? 'selected' : '' }} value="{{ $size_guide->id }}">{{ $size_guide->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-info"></i>&nbsp; Weight (in Kg)</label>
                                        </span>
                                        <input name="weight" type="text" class="form-control @error('weight') is-invalid @enderror" placeholder="Product's Weight (Optional)" value="{{ old('weight') ? old('weight') : (request()->routeIs('admin.products.edit') ? $product->weight : '') }}" required>
                                        @error('weight')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-info"></i>&nbsp; Warranty Available</label>
                                        </span>
                                        @php
                                            $selectedWarranty = old('warranty') ? old('warranty') : (request()->routeIs('admin.products.edit') ? $product->warranty : '');
                                        @endphp

                                        <select name="warranty" class="form-control form-control-inverse">
                                            <option {{ $selectedWarranty == 0 ? 'selected' : '' }} value="0">No</option>
                                            <option {{ $selectedWarranty == 1 ? 'selected' : '' }} value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group input-group-inverse">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-sun"></i>&nbsp; Product Cares</label>
                                        </span>
                                        

                                        <select name="product_cares[]" data-placeholder="Select Product Cares" class="form-control form-control-inverse select2" multiple>
                                            {{-- <option selected disabled>Choose Product Cares</option> --}}
                                            @php
                                                if (request()->routeIs('admin.products.edit')) {
                                                    $db_product_cares = json_decode($product->product_cares);
                                                }else{
                                                    $db_product_cares = [];
                                                }
                                            @endphp
                                            @foreach($product_cares as $product_care)
                                                <option {{ in_array($product_care->id, $db_product_cares) ? 'selected' : '' }} value="{{ $product_care->id }}">{{ $product_care->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="card border shadow-this-item mt-3 gallery_images_field">
                                <div class="card-body ">
                                    <h3 class="card-title"><i class="ik ik-calendar"></i> Occassions</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="border-checkbox-section">
                                                @php
                                                    $product_occassions = request()->routeIs('admin.products.edit') ? $product->occassion_products()->pluck('occassion_id')->all() : []; 
                                                @endphp
                                                @foreach($occassions as $key => $occassion)
                                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                                        <input {{ in_array($occassion->id, $product_occassions) ? 'checked' : '' }} class="border-checkbox" type="checkbox" id="occassion{{$key}}" name="occassions[]" value="{{ $occassion->id }}">
                                                        <label class="border-checkbox-label" for="occassion{{$key}}">{{ $occassion->title }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>

                            <div class="card border shadow-this-item mt-3 gallery_images_field">
                                <div class="card-body ">
                                    <h3 class="card-title">Media</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h6><i class="ik ik-image"></i> Featured Image</h6>
                                                <input type="file" name="image" class="file-upload-default" {{ request()->routeIs('admin.products.edit') ? '' : 'required' }}>
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control form-control-inverse file-upload-info" disabled placeholder="Upload Featured Image">
                                                    <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-inverse" type="button">{{ __('Upload')}}</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @if(request()->routeIs('admin.products.edit'))
                                        <div class="col-md-4">
                                            <a class="light-link" href="
                                            {{ asset('storage/products/'.$product->slug.'/'.$product->image) }}" data-sub-html="{{ $product->title }} ">

                                                <img style="margin: 10px;" class="img rounded" width="50px" src="{{ asset('storage/products/'.$product->slug.'/thumbs/thumb_'.$product->image) }}">
                                            </a>

                                            
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h6><i class="ik ik-image"></i> Gallery Images</h6>
                                                <input type="file" name="other_images[]" class="file-upload-default" multiple>
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control form-control-inverse file-upload-info" disabled placeholder="Upload Gallery Images">
                                                    <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-inverse" type="button">{{ __('Upload')}}</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @if(request()->routeIs('admin.products.edit'))
                                        @php
                                            $images = Storage::files('public/products/'.$product->slug.'/');
                                        @endphp
                                        <div class="col-md-6 ">
                                            <div class="input-group">
                                            @for ($i = 0; $i < count($images); $i++)
                                                @if(strpos($images[$i], $product->image) != true)
                                                <span id="gallery_image_{{$i}}">
                                                <a href="#delete_image" data-toggle="modal"
                                                   data-photo=""
                                                   onclick="delete_image('{{ $product->slug }}', '{{ basename($images[$i]) }}', 'gallery_image_{{$i}}')"
                                                   id="" title="Delete Image">
                                                    <i style="position: absolute; color: #fff;border-radius: 50%; opacity: 1; color: red;" class="fa fa-times"></i>
                                                </a>
                                                <a class="light-link" href="
                                                {{ asset('storage/products/'.$product->slug.'/'.basename($images[$i])) }}" data-sub-html="{{ $product->title }} ">

                                                    <img style="margin: 10px;" class="img rounded" width="50px" class="img-thumbnail" src="{{ asset('storage/').str_replace('public/products/'.$product->slug.'/','/products/'.$product->slug.'/thumbs/thumb_',$images[$i])}}" alt="no-image">
                                                </a>
                                                </span>
                                                @endif
                                            @endfor
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer p-3">
                                    <small class="float-right"><i>Recommended Image Resolution </i>: <strong>770px X 900px</strong></small>
                                </div>
                            </div>

                            {{-- <div class="row gallery_images_field">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        
                                        <input type="file" name="image" class="file-upload-default" {{ request()->routeIs('admin.products.edit') ? '' : 'required' }}>

                                        <div class="input-group input-group-inverse">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text"> <i class="ik ik-image"></i>&nbsp; Image </label>
                                            </span>
                                            <input type="text" class="form-control form-control-inverse file-upload-info" disabled placeholder="Upload Featured Image">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-inverse" type="button">{{ __('Upload')}}</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if(request()->routeIs('admin.products.edit'))
                                <div class="col-md-4">
                                    <a class="light-link" href="{{ asset('storage/products/'.$product->image) }}" data-sub-html="{{ $product->title }} ">

                                        <img style="margin: 10px;" class="img rounded" width="50px" src="{{ asset('storage/products/thumbs/thumb_'.$product->image) }}">
                                    </a>

                                    
                                </div>
                                @endif
                            </div> --}}

                             <div class="card border shadow-this-item mt-3">
                                <div class="card-body ">
                                    <h3 class="card-title"><i class="ik ik-git-branch"></i>Variations</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="input-group input-group-inverse">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text"><i class="fa fa-eye-dropper"></i>&nbsp; Color</label>
                                                </span>


                                                <select name="color_ids[]" class="form-control form-control-inverse select2" id="colorSelect" required multiple="multiple">
                                                    {{-- <option selected disabled>Select Color</option> --}}
                                                    @php
                                                        $selected_color_ids = request()->routeIs('admin.products.edit') ? $product->product_variations()->groupBy('color_id')->get()->pluck('color_id')->all() : [];
                                                    @endphp
                                                    @foreach($colors as $color)
                                                        <option {{ in_array($color->id, $selected_color_ids) ? 'selected' : '' }} value="{{ $color->id }}">{{ $color->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="input-group input-group-inverse">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text"><i class="ik ik-bar-chart-2"></i>&nbsp; Size Group</label>
                                                </span>


                                                <select name="size_group_id" class="form-control form-control-inverse" id="sizeGroupSelect" required>
                                                    <option selected disabled>Select Size Group</option>
                                                    @php
                                                    $selectedSizeGroup = old('size_group_id') ? old('size_group_id') : (request()->routeIs('admin.products.edit') ? $product->size_group_id : '');
                                                    @endphp

                                                    @foreach($size_groups as $size_group)
                                                        <option {{ $size_group->id == $selectedSizeGroup ? 'selected' : '' }} value="{{ $size_group->id }}">{{ $size_group->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <style type="text/css">
                                        td{
                                            padding: 0.2rem !important;
                                        }
                                    </style>

                                    <div class="row" id="variationDetails" style="display: none;">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-responsive">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Display</th>
                                                            <th>Color</th>
                                                            <th>Size</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                            <th>Offer Price</th>
                                                            <th>SKU</th>
                                                            <th>PreOrder</th>
                                                            <th style="font-size: 10px">PreOrder Stock Limit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="variationTable">
                                                        <!-- Dynamic Content  -->

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Product Highlights</label>
                                    <textarea class="form-control ckeditor" name="highlights">{{ old('highlights') ? old('highlights') : (request()->routeIs('admin.products.edit') ? $product->highlights : '') }}</textarea>
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Product Description</label>
                                    <textarea class="form-control ckeditor" name="description">{{ old('description') ? old('description') : (request()->routeIs('admin.products.edit') ? $product->description : '') }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="delete_image">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Gallery Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you Sure...!!</p>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Close</button>
                    <button id="confirmDeleteGalleryImage" data-slug="" data-gallery-image="" data-gallery-image-id="" class="btn btn-round btn-danger">Delete</button>
                </div>
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
        $('.select2').select2();

        $(document).ready(function(){
            show_related_sizes();

        });

        $("#colorSelect, #sizeGroupSelect").change(function(){
            show_related_sizes();
        });

        function show_related_sizes() {
            var color_ids = $('#colorSelect').val();
            var size_group_id = $("#sizeGroupSelect").val();
            
            if (color_ids.length == 0 || size_group_id == null) {
                // alert('haha');
                $('#variationDetails').hide();
                return;
            }

            $.ajax({
                    url: "{{ URL::route('admin.products.show-related-sizes') }}",
                    type: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        color_ids: color_ids,
                        size_group_id: size_group_id,
                        flag: {{ request()->routeIs('admin.products.edit') ? 1 : 0 }},
                        product_id: {{ request()->routeIs('admin.products.edit') ? $product->id : 0 }}
                    },
                    cache:false,
                    beforeSend : function(){
                        $('#modal-loader').show();
                    },
                    complete : function($response, $status){
                        $('#modal-loader').hide();
                        $("#variationDetails").show();

                        if ($status != "error" && $status != "timeout" && $response.responseText != 'error') {
                            
                            $("#variationTable").html($response.responseText);

                            $(".variation-display").each(function(){
                                call_product_variation_function(this);
                            });

                            $(".variation-display").change(function(){

                                call_product_variation_function(this);
                            });

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
                        $('#modal-loader').hide();
                    }
            });
        }

        $(".gallery_images_field").lightGallery({
            selector: '.light-link'
        }); 

        function call_product_variation_function(that) {

            var key = $(that).data('variation-key');
            // console.log(key);
            if (that.checked) {

                $('.color-size-variation-'+key).not('.preorder-stock-limit').attr('disabled',false);
                $('.req-not-req-'+key).attr('required',true); 
                
            }else{
                $('.color-size-variation-'+key).attr('disabled',true);
                $('.req-not-req-'+key).attr('required',false);
            }
        }

        function call_preorder_status_function(that) {
            var stock_limit_class = $(that).data('limit-class');

            if (that.checked) {
                console.log(stock_limit_class);
                $('.'+stock_limit_class).attr('disabled',false);
                $('.'+stock_limit_class).attr('required',true); 
                
            }else{
                $('.'+stock_limit_class).attr('disabled',true);
                $('.'+stock_limit_class).attr('required',false);
            }
        }

        // <---------- Delete Image Modal ---------->
        function delete_image(slug, image, galleryImageId) {

            $("#confirmDeleteGalleryImage").attr('data-slug', slug);
            $("#confirmDeleteGalleryImage").attr('data-image', image);
            $("#confirmDeleteGalleryImage").attr('data-gallery-image-id', galleryImageId);
        }

        // <---------- Delete Product Gallery Image ---------->
        jQuery("#confirmDeleteGalleryImage").click(function(){

            $("#delete_image").modal('hide');

            var slug = $(this).attr('data-slug');
            var image = $(this).attr('data-image');
            var gallery_image_id = String($(this).attr('data-gallery-image-id'));

            $.ajax({
                url : "{{ URL::route('admin.products.delete-gallery-image') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        slug: slug,
                        image: image
                    },
                cache : false,
                beforeSend : function (){
                    $('#modal-loader').show();
                },
                complete : function($response, $status){

                    if ($status != "error" && $status != "timeout") {
                        
                        var obj = jQuery.parseJSON($response.responseText);

                        if (obj.message == 'success') {
                            $("#"+gallery_image_id).remove();
                        }else{
                            toastr['error']('Something went wrong!','Error');
                        }
                        $('#modal-loader').hide();
                        // $("#pageUrl").html($response.responseText);
                        
                    }
                },
                error : function ($responseObj){
                    alert("Something went wrong while processing your request.\n\nError => "
                        + $responseObj.responseText);
                    $('#modal-loader').hide();
                }
            }); 
        });
    </script>

@endpush
