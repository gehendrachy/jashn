<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Occassion;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\SizeGuide;
use App\Models\SizeGroup;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductCare;
use Illuminate\Http\Request;
use App\Services\ModelHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Exports\ProductExport;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        // $products = Product::all();
        // foreach ($products as $product) {
        //     foreach ($product->product_variations as $pVar) {

        //         $product_color = ProductColor::updateOrCreate([
        //                                                             'product_id' => $product->id, 
        //                                                             'color_id' => $pVar->color_id

        //                                                     ]);                

        //         $product_color->product_sizes()->updateOrCreate([
        //                                                             'product_color_id' => $product_color->id,
        //                                                             'size_id' => $pVar->size_id
        //                                                         ],
        //                                                         [
        //                                                             'display' => $pVar->display,
        //                                                             'quantity' => $pVar->quantity,
        //                                                             'price' => $pVar->price == NULL ? 0 : $pVar->price,
        //                                                             'offer_price' => $pVar->offer_price,
        //                                                             'sku' => $pVar->sku,
        //                                                             'preorder' => isset($pVar->preorder) ? $pVar->preorder : 0,
        //                                                             'preorder_stock_limit' => isset($pVar->preorder) ? $pVar->preorder_stock_limit : NULL
        //                                                         ]
        //                                                     );

        //     }
        // }

        // dd("test");

        return view('backend.products.list-products', compact('products'));
    }
    
    public function outOfStockProducts(){
       
        $stock =0;
          $products = Product::whereHas('product_colors', function(Builder $query) use ($stock){

                                            $query->whereHas('product_sizes', function(Builder $query) use ($stock){
                                                $query->where([['preorder_stock_limit', '<=', $stock],['quantity', '<=', $stock]]);
                                            });

                                        })->get();
       
         
         return view('backend.products.list-products', compact('products'));
    }
    
     public function inactiveProducts(){
         $products = Product::where('display',0)->get();
         return view('backend.products.list-products', compact('products'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ModelHelper::getFullListFromDB('categories');
        $occassions = Occassion::all();
        $genders = Product::$genders;
        $fabrics = Fabric::all();
        $size_guides = SizeGuide::where('display', 1)->get();
        $size_groups = SizeGroup::where('display', 1)->get();
        $colors = Color::where('display', 1)->get();
        $product_cares = ProductCare::where('display', 1)->get();
        return view('backend.products.create-update-products', compact('categories', 'fabrics', 'occassions', 'genders', 'size_guides', 'size_groups', 'colors', 'product_cares'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = ModelHelper::createProductSlug('\App\Models\Product', $request->title);

        $insertArray = array(
            "title" => $request->title,
            "slug" => $slug,
            "display" => isset($request->display) ? $request->display : 0,
            // "featured" => isset($request->featured) ? $request->featured : 0,
            // "stock_status" => $request->stock_status,
            "category_id" => $request->category_id,
            // "price" => $request->price,
            // "offer_price" => $request->offer_price,
            "gender" => $request->gender,
            "video_link" => $request->video_link,
            "size_guide_id" => $request->size_guide_id,
            "size_group_id" => $request->size_group_id,
            "weight" => $request->weight,
            "product_cares" => isset($request->product_cares) ? json_encode($request->product_cares) : '[]',
            "warranty" => $request->warranty,
            "highlights" => $request->highlights,
            "description" => $request->description,
            "quantity" => $request->quantity,
            "brand_id" => $request->brand_id,
            "tags" => $request->tags,
            "created_by" => Auth::user()->name
        );
        // dd($insertArray);
        $path = public_path() . '/storage/products/' . $slug;
        $folderPath = 'public/products/' . $slug;

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);

            if (!is_dir($path . "/thumbs")) {
                Storage::makeDirectory($folderPath . '/thumbs', 0777, true, true);
            }

            if (!is_dir($path . "/variations")) {

                Storage::makeDirectory($folderPath . '/variations', 0777, true, true);
                Storage::makeDirectory($folderPath . '/variations/thumbs', 0777, true, true);
            }
        }

        if ($request->hasFile('image')) {
            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            // Storage::putFileAs($folderPath, new File($image), $filename);

            ModelHelper::resize_crop_images(770, 990, $image, $folderPath . "/" . $filename);
            ModelHelper::resize_crop_images(575, 675, $image, $folderPath . "/thumbs/medium_" . $filename);
            ModelHelper::resize_crop_images(385, 450, $image, $folderPath . "/thumbs/small_" . $filename);
            ModelHelper::resize_crop_images(100, 120, $image, $folderPath . "/thumbs/thumb_" . $filename);

            $insertArray['image'] = $filename;
        }

        if ($request->hasFile('other_images')) {
            //Add the new photo
            $otherImages = $request->file('other_images');
            foreach ($otherImages as $key => $other) {

                $filename_o = time() . $key . '_.' . $other->getClientOriginalExtension();
                // Storage::putFileAs($folderPath, new File($other), $filename_o);

                ModelHelper::resize_crop_images(770, 990, $other, $folderPath . "/" . $filename_o);
                ModelHelper::resize_crop_images(575, 675, $other, $folderPath . "/thumbs/medium_" . $filename_o);
                ModelHelper::resize_crop_images(385, 450, $other, $folderPath . "/thumbs/small_" . $filename_o);
                ModelHelper::resize_crop_images(100, 120, $other, $folderPath . "/thumbs/thumb_" . $filename_o);
            }
        }

        $product = Product::create($insertArray);

        if (isset($request->occassions)) {

            $occassions = $request->occassions;


            for ($i = 0; $i < count($occassions); $i++) {

                $product->occassion_products()->updateOrCreate(['product_id' => $product->id, 'occassion_id' => $occassions[$i]]);
            }
        }
        
         if (isset($request->fabric)) {

            $fabrics = $request->fabric;
            $product->fabric_products()->updateOrCreate(['product_id' => $product->id, 'fabric_id' => $fabrics]);
            
        }

        $variations = $request['variation'];

        $variationImages = $request->file('variation');
        foreach ($variations as $key => $pVar) {
            $variationImageName = '';
            if (isset($pVar['image'])) {

                $image = $pVar['image'];
                $filename = time() . '_' . $key . '.' . $image->getClientOriginalExtension();

                ModelHelper::resize_crop_images(770, 990, $image, $folderPath . "/variations/" . $filename);
                ModelHelper::resize_crop_images(575, 675, $image, $folderPath . "/variations/thumbs/medium_" . $filename);
                ModelHelper::resize_crop_images(385, 450, $image, $folderPath . "/variations/thumbs/small_" . $filename);
                ModelHelper::resize_crop_images(100, 120, $image, $folderPath . "/variations/thumbs/thumb_" . $filename);

                $variationImageName = $filename;
            }

            $product_color = ProductColor::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'color_id' => $pVar['color_id']

                ],
                [
                    'image' => $variationImageName
                ]
            );
            foreach ($pVar['size'] as $key => $pVarSize) {
                $product_color->product_sizes()->updateOrCreate(
                    [
                        'product_color_id' => $product_color->id,
                        'size_id' => $pVarSize['size_id'],
                    ],
                    [
                        'display' => $pVarSize['display'],
                        'quantity' => $pVarSize['quantity'],
                        'price' => $pVarSize['price'],
                        'offer_price' => $pVarSize['offer_price'],
                        'sku' => $pVarSize['sku'],
                        'preorder' => isset($pVarSize['preorder']) ? $pVarSize['preorder'] : 0,
                        'preorder_stock_limit' => isset($pVarSize['preorder']) ? $pVarSize['preorder_stock_limit'] : NULL
                    ]
                );
            }
        }
        // dd('success');
        return redirect()->route('admin.products.index')->with('status', 'New Product has been Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('product_variations.color')->where('id', base64_decode($id))->firstOrFail();
        // dd($product->fabrics);
        // $color_ids = $product->product_variations()->groupBy('color_id')->get()->pluck('color_id')->all();
        // $size_ids = $product->product_variations()->groupBy('size_id')->get()->pluck('size_id')->all();
        // dd($size_ids);
        $categories = ModelHelper::getFullListFromDB('categories');
        $occassions = Occassion::all();
        $genders = Product::$genders;
        $fabrics = Fabric::all();
        $size_guides = SizeGuide::where('display', 1)->get();
        $size_groups = SizeGroup::where('display', 1)->get();
        $colors = Color::where('display', 1)->get();
        $product_cares = ProductCare::where('display', 1)->get();
        return view('backend.products.create-update-products', compact('product', 'categories', 'occassions', 'genders', 'size_guides', 'size_groups', 'colors', 'product_cares', 'fabrics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $slug = ModelHelper::createProductSlug('\App\Models\Product', $request->title, $product->id);
        $path = public_path() . '/storage/products/' . $product->slug;

        // dd($updateArray);

        if ($product->slug != $slug) {

            if (file_exists($path)) {
                Storage::move('public/products/' . $product->slug, 'public/products/' . $slug);
            }

            $slug = ModelHelper::createProductSlug('\App\Models\Product', $slug, $product->id);
        }

        $updateArray = array(
            "title" => $request->title,
            "slug" => $slug,
            "display" => isset($request->display) ? $request->display : 0,
            // "featured" => isset($request->featured) ? $request->featured : 0,
            // "stock_status" => $request->stock_status,
            "category_id" => $request->category_id,
            // "price" => $request->price,
            // "offer_price" => $request->offer_price,
            "gender" => $request->gender,
            "video_link" => $request->video_link,
            "size_guide_id" => $request->size_guide_id,
            "size_group_id" => $request->size_group_id,
            "weight" => $request->weight,
            "product_cares" => isset($request->product_cares) ? json_encode($request->product_cares) : '[]',
            "warranty" => $request->warranty,
            "highlights" => $request->highlights,
            "description" => $request->description,
            "quantity" => $request->quantity,
            "brand_id" => $request->brand_id,
            "tags" => $request->tags,
            "updated_by" => Auth::user()->name,
            "updated_at" => date('Y-m-d H:i:s')
        );

        $path = public_path() . '/storage/products/' . $slug;
        $folderPath = 'public/products/' . $slug;

        if (!is_dir($path . "/variations")) {

            Storage::makeDirectory($folderPath . '/variations', 0777, true, true);
            Storage::makeDirectory($folderPath . '/variations/thumbs', 0777, true, true);
        }

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);

            if (!is_dir($path . "/thumbs")) {
                Storage::makeDirectory($folderPath . '/thumbs', 0777, true, true);
            }

            if (!is_dir($path . "/variations")) {

                Storage::makeDirectory($folderPath . '/variations', 0777, true, true);
                Storage::makeDirectory($folderPath . '/variations/thumbs', 0777, true, true);
            }
        }

        if ($request->hasFile('image')) {
            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            // Storage::putFileAs($folderPath, new File($image), $filename);

            ModelHelper::resize_crop_images(770, 990, $image, $folderPath . "/" . $filename);
            ModelHelper::resize_crop_images(575, 675, $image, $folderPath . "/thumbs/medium_" . $filename);
            ModelHelper::resize_crop_images(385, 450, $image, $folderPath . "/thumbs/small_" . $filename);
            ModelHelper::resize_crop_images(100, 120, $image, $folderPath . "/thumbs/thumb_" . $filename);

            $updateArray['image'] = $filename;

            //Delete the old photo
            Storage::delete($folderPath . "/" . $product->image);
            Storage::delete($folderPath . "/thumbs/medium_" . $product->image);
            Storage::delete($folderPath . "/thumbs/small_" . $product->image);
            Storage::delete($folderPath . "/thumbs/thumb_" . $product->image);
        }

        if ($request->hasFile('other_images')) {
            //Add the new photo
            $otherImages = $request->file('other_images');
            foreach ($otherImages as $key => $other) {

                $filename_o = time() . $key . '_.' . $other->getClientOriginalExtension();
                // Storage::putFileAs($folderPath, new File($other), $filename_o);

                ModelHelper::resize_crop_images(770, 990, $other, $folderPath . "/" . $filename_o);
                ModelHelper::resize_crop_images(575, 675, $other, $folderPath . "/thumbs/medium_" . $filename_o);
                ModelHelper::resize_crop_images(385, 450, $other, $folderPath . "/thumbs/small_" . $filename_o);
                ModelHelper::resize_crop_images(100, 120, $other, $folderPath . "/thumbs/thumb_" . $filename_o);
            }
        }

        if ($product->size_group_id != $request->size_group_id) {
            $product->product_variations()->delete();
        }

        $product_updated = $product->update($updateArray);

        if (isset($request->occassions)) {

            $occassions = $request->occassions;


            for ($i = 0; $i < count($occassions); $i++) {

                $product->occassion_products()->updateOrCreate(['product_id' => $product->id, 'occassion_id' => $occassions[$i]]);
                $product->occassion_products()->whereNotIn('occassion_id', $occassions)->delete();
            }
        }
        
        if (isset($request->fabric)) {

            $fabrics = $request->fabric;
            $product->fabric_products()->updateOrCreate(['product_id' => $product->id, 'fabric_id' => $fabrics]);
            $product->fabric_products()->where('fabric_id', '!=', $fabrics)->delete();
            
        }

        $variations = $request['variation'];
        $variationImages = $request->file('variation');

        foreach ($variations as $pVar) {

            $variationArray = [];

            if (isset($pVar['image'])) {

                $image = $pVar['image'];
                $filename = time() . '.' . $image->getClientOriginalExtension();

                ModelHelper::resize_crop_images(770, 990, $image, $folderPath . "/variations/" . $filename);
                ModelHelper::resize_crop_images(575, 675, $image, $folderPath . "/variations/thumbs/medium_" . $filename);
                ModelHelper::resize_crop_images(385, 450, $image, $folderPath . "/variations/thumbs/small_" . $filename);
                ModelHelper::resize_crop_images(100, 120, $image, $folderPath . "/variations/thumbs/thumb_" . $filename);

                $variationArray['image'] = $filename;

                if (isset($pVar['id'])) {

                    $product_color = ProductColor::where('id', $pVar['id'])->first();
                    $oldVarImg = $product_color->image;

                    //Delete the variation old photo
                    Storage::delete($folderPath . "/variations/" . $oldVarImg);
                    Storage::delete($folderPath . "/variations/thumbs/medium_" . $oldVarImg);
                    Storage::delete($folderPath . "/variations/thumbs/small_" . $oldVarImg);
                    Storage::delete($folderPath . "/variations/thumbs/thumb_" . $oldVarImg);
                }
            }


            $product_color = ProductColor::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'color_id' => $pVar['color_id']

                ],
                $variationArray
            );

            foreach ($pVar['size'] as $key => $pVarSize) {

                $product_color->product_sizes()->updateOrCreate(
                    [
                        'product_color_id' => $product_color->id,
                        'size_id' => $pVarSize['size_id']
                    ],
                    [
                        'display' => $pVarSize['display'],
                        'quantity' => $pVarSize['quantity'],
                        'price' => $pVarSize['price'],
                        'offer_price' => $pVarSize['offer_price'],
                        'sku' => $pVarSize['sku'],
                        'preorder' => isset($pVarSize['preorder']) ? $pVarSize['preorder'] : 0,
                        'preorder_stock_limit' => isset($pVarSize['preorder']) ? $pVarSize['preorder_stock_limit'] : NULL
                    ]
                );
            }

            $selectd_size_ids = collect($pVar['size'])->pluck('size_id')->all();

            $product_color->product_sizes()->whereNotIn('size_id', $selectd_size_ids)->delete();
        }
        
        $color_ids = is_array($request->color_ids) ? $request->color_ids : [$request->color_ids];

        $product->product_colors()->whereNotIn('color_id', $color_ids)->delete();
        // dd('success');
        return redirect()->route('admin.products.index')->with('status', 'Product Details has been Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id', base64_decode($id))->firstOrFail();
        // dd($product);
        if ($product) {

            if ($product->delete()) {

                $productFolder = 'public/products/' . $product->slug;
                Storage::deleteDirectory($productFolder);

                return redirect()->back()->with('status', 'Product Deleted Successfully!');
            } else {
                return redirect()->back()->with('status', 'Something Went Wrong!');
            }
        } else {

            return redirect()->back()->with('status', 'Product Not Found!');
        }
    }

    public function deleteVariation($productId, $colorId)
    {
        $product = Product::findOrFail(base64_decode($productId));
        $color = ProductColor::findOrFail(base64_decode($colorId));
        $product_color = DB::table('product_colors')->select('id', 'image')->where('product_id', base64_decode($productId))->where('color_id', base64_decode($colorId))->first();


        //Delete the old photo
        $folderPath = 'public/products/' . $product->slug;

        Storage::delete($folderPath . "/variations/" . $product_color->image);
        Storage::delete($folderPath . "/variations/thumbs/medium_" . $product_color->image);
        Storage::delete($folderPath . "/variations/thumbs/small_" . $product_color->image);
        Storage::delete($folderPath . "/variations/thumbs/thumb_" . $product_color->image);

        DB::table('product_sizes')->where('product_color_id', $product_color->id)->delete();
        DB::table('product_colors')->where('product_id', base64_decode($productId))->where('color_id', base64_decode($colorId))->delete();

        return redirect()->back()->with('status', 'Variation Deleted Successfully');
    }

    public function show_related_sizes(Request $request)
    {
        $color_ids = $request->color_ids;
        $size_group_id = $request->size_group_id;
        $flag = $request->flag;
        // if ($flag == 1) {
        //     $product = Product::find($request->product_id);
        //     // $selected_color_ids = $product->product_variations()->groupBy('color_id')->get()->pluck('color_id')->all();
        // }

        $colors = Color::whereIn('id', $color_ids)->get();

        $size_group = SizeGroup::find($size_group_id);
        $sizes = $size_group->sizes;
        $response = '';

        foreach ($colors as $color_key => $color) {

            $colorModel = ProductColor::where([['product_id', $request->product_id], ['color_id', $color->id]]);

            $colorExists = $colorModel->exists();
            $imageRequired = $colorExists ? '' : 'required';
            if ($colorExists) {

                $product_color = $colorModel->first();
                $product_color_image = asset('storage/products/' . $product_color->product->slug . '/variations/thumbs/thumb_' . $product_color->image);
                $product_slug = $product_color->product->slug;
                $product_color_id = $product_color->id;
            } else {
                $product_color_id = 0;
            }


            $response .= '<div class="card border  mt-3">
                            <div class="card-body ">
                                <h3 class="card-title"><i class="fa fa-eye-dropper"></i> ' . $color->title . '</h3>
                                <hr>
                                <div class="row">
                                    <input type="hidden" name="variation[' . $color_key . '][color_id]" value="' . $color->id . '">';
            if ($colorExists) {
                $response .= '<input type="hidden" name="variation[' . $color_key . '][id]" value="' . $product_color_id . '">';
            }
            $response .= '<div class="col-md-4">
                                        <div class="form-group">
                                            <label><i class="ik ik-image"></i> Variation Image</label>
                                            <input type="file" name="variation[' . $color_key . '][image]" class="file-upload-default" ' . $imageRequired . '>
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control form-control-inverse file-upload-info" disabled placeholder="Upload Variation Image">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-inverse" type="button">Upload</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>';

            if ($colorExists) {
                $response .= '<div class="col-md-4">
                                                        <img src="' . $product_color_image . '" alt="' . $product_slug . '" class="img img-thumbnail">
                                                    </div>';
            }
            $response .= '<div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-responsive">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Display</th>
                                                        <th>Size</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Offer Price</th>
                                                        <th>SKU</th>
                                                        <th>PreOrder</th>
                                                        <th style="font-size: 10px">PreOrder Stock Limit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
            foreach ($sizes as $size_key => $size) {

                $sizeModel = ProductSize::where([['product_color_id', @$product_color_id], ['size_id', $size->id]]);
                $sizeExists = $sizeModel->exists();

                if ($sizeExists) {
                    $product_variation = $sizeModel->first();
                    $display_status = 'checked';
                    $quantity = $product_variation->quantity;
                    $price = $product_variation->price;
                    $offer_price = $product_variation->offer_price;
                    $sku = $product_variation->sku;
                    $preorder_status = $product_variation->preorder == 1 ? 'checked' : '';
                    $preorder_stock_limit = $product_variation->preorder_stock_limit;
                } else {
                    $display_status = '';
                    $quantity = '';
                    $price = '';
                    $offer_price = '';
                    $sku = '';
                    $preorder_status = '';
                    $preorder_stock_limit = '';
                }

                $response .= '<tr class="text-center">
                                                        <th scope="row">
                                                            <input type="checkbox" name="variation[' . $color_key . '][size][' . $size_key . '][display]" data-variation-key="' . $color_key . '-' . $size_key . '" value="1" class="variation-display" ' . $display_status . '>
                                                        </th>
                                                        <td style="min-width: 100px;">
                                                            ' . $size->name . '
                                                            <input type="hidden" name="variation[' . $color_key . '][size][' . $size_key . '][size_id]" class="color-size-variation-' . $color_key . '-' . $size_key . '" value="' . $size->id . '" >
                                                        </td>
                                                        <td>
                                                            <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][quantity]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm req-not-req-' . $color_key . '-' . $size_key . '" value="' . $quantity . '">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][price]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm req-not-req-' . $color_key . '-' . $size_key . '" value="' . $price . '">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][offer_price]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm offer-price" value="' . $offer_price . '">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][sku]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm req-not-req-' . $color_key . '-' . $size_key . '" value="' . $sku . '">
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="variation[' . $color_key . '][size][' . $size_key . '][preorder]" class="color-size-variation-' . $color_key . '-' . $size_key . ' preorder-checkbox" data-limit-class="stock-limit-' . $color_key . '-' . $size_key . '" value="1" ' . $preorder_status . '>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][preorder_stock_limit]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm preorder-stock-limit stock-limit-' . $color_key . '-' . $size_key . '" value="' . $preorder_stock_limit . '">
                                                        </td>
                                                    </tr>';
            }

            $response .= '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }



        return $response;
    }

    public function edit_product_variation_stocks(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $product_variation_sizes = $product->product_sizes;
        $response = '';
        foreach ($product_variation_sizes as $key => $product_size) {
            $preorder_status = $product_size->preorder == 1 ? 'checked' : '';

            $response .= '<tr>
                            <input type="hidden" name="product_size_id[' . $key . ']" value="' . $product_size->id . '">
                            <td class="pt-5 pb-5"><strong>' . $product_size->sku . '</strong></td>
                            <td class="pt-5 pb-5">' . $product_size->size->name . ', ' . $product_size->product_color->color->title . '</td>
                            <td class="pt-5 pb-5" width="15%">
                                <input class="form-control" type="text" name="price[' . $key . ']" value="' . $product_size->price . '">
                            </td>
                            <td class="pt-5 pb-5" width="15%">
                                <input class="form-control" type="number" name="quantity[' . $key . ']" value="' . $product_size->quantity . '">
                            </td>
                            <td class="pt-5 pb-5" width="10%">
                                <input class="preorder-checkbox" data-limit-class="stock-limit-' . $key . '" value="1" type="checkbox" name="preorder[' . $key . ']" ' . $preorder_status . '>
                            </td>
                            <td class="pt-5 pb-5" width="15%">
                                <input class="form-control preorder-stock-limit stock-limit-' . $key . '" type="number" name="preorder_stock_limit[' . $key . ']" value="' . $product_size->preorder_stock_limit . '">
                            </td>
                        </tr>';
        }

        return $response;
    }

    public function update_product_variation_stocks(Request $request)
    {
        // dd($_POST);
        $product = Product::findOrFail($request->product_id);
        $product_size_ids = $request->product_size_id;
        $price = $request->price;
        $quantity = $request->quantity;
        $preorder = $request->preorder;
        $preorder_stock_limit = $request->preorder_stock_limit;

        foreach ($product_size_ids as $key => $size_id) {

            $product_size = $product->product_sizes()->where('product_sizes.id', $size_id)->first();
            // dd($product_size);

            if ($product_size) {

                $sizeUpdateArray = [
                    'price' => $price[$key],
                    'quantity' => $quantity[$key],
                    'preorder' => isset($preorder[$key]) ? $preorder[$key] : 0,
                    'preorder_stock_limit' => isset($preorder[$key]) ? $preorder_stock_limit[$key] : NULL
                ];
            }


            $product->product_sizes()->where('product_sizes.id', $size_id)->update($sizeUpdateArray);
        }

        return redirect()->back()->with('status', 'Product Variations Updated Successfully!');
    }

    public function show_related_sizesssss(Request $request)
    {
        $color_ids = $request->color_ids;
        $size_group_id = $request->size_group_id;
        $flag = $request->flag;
        // if ($flag == 1) {
        //     $product = Product::find($request->product_id);
        //     // $selected_color_ids = $product->product_variations()->groupBy('color_id')->get()->pluck('color_id')->all();
        // }

        $colors = Color::whereIn('id', $color_ids)->get();

        $size_group = SizeGroup::find($size_group_id);
        $sizes = $size_group->sizes;
        $response = '';

        foreach ($colors as $color_key => $color) {

            foreach ($sizes as $key => $size) {

                $varModel = ProductVariation::where([['product_id', $request->product_id], ['color_id', $color->id], ['size_id', $size->id]]);
                $variationExists = $varModel->exists();

                if ($variationExists) {
                    $product_variation = $varModel->first();
                    $display_status = 'checked';
                    $quantity = $product_variation->quantity;
                    $price = $product_variation->price;
                    $offer_price = $product_variation->offer_price;
                    $sku = $product_variation->sku;
                    $preorder_status = $product_variation->preorder == 1 ? 'checked' : '';
                    $preorder_stock_limit = $product_variation->preorder_stock_limit;
                } else {
                    $display_status = '';
                    $quantity = '';
                    $price = '';
                    $offer_price = '';
                    $sku = '';
                    $preorder_status = '';
                    $preorder_stock_limit = '';
                }

                $response .= '<tr class="text-center">
                                <th scope="row">
                                    <input type="checkbox" name="variation[' . $color_key . '-' . $key . '][display]" data-variation-key="' . $color_key . '-' . $key . '" value="1" class="variation-display" ' . $display_status . '>
                                </th>
                                <td style="min-width: 100px;">
                                    <span style="height: 12px; width: 12px; margin: 2px 2px 0 0; display:inline-block; background-color: ' . $color->code . ';"></span> ' . $color->title . ' 
                                    <input type="hidden" name="variation[' . $color_key . '-' . $key . '][color_id]" class="color-size-variation-' . $color_key . '-' . $key . '" value="' . $color->id . '">
                                </td>
                                <td style="min-width: 100px;">
                                    ' . $size->name . '
                                    <input type="hidden" name="variation[' . $color_key . '-' . $key . '][size_id]" class="color-size-variation-' . $color_key . '-' . $key . '" value="' . $size->id . '">
                                </td>
                                <td>
                                    <input type="text" name="variation[' . $color_key . '-' . $key . '][quantity]" class="color-size-variation-' . $color_key . '-' . $key . ' form-control form-control-sm req-not-req-' . $color_key . '-' . $key . '" value="' . $quantity . '">
                                </td>
                                <td>
                                    <input type="text" name="variation[' . $color_key . '-' . $key . '][price]" class="color-size-variation-' . $color_key . '-' . $key . ' form-control form-control-sm" value="' . $price . '">
                                </td>
                                <td>
                                    <input type="text" name="variation[' . $color_key . '-' . $key . '][offer_price]" class="color-size-variation-' . $color_key . '-' . $key . ' form-control form-control-sm offer-price" value="' . $offer_price . '">
                                </td>
                                <td>
                                    <input type="text" name="variation[' . $color_key . '-' . $key . '][sku]" class="color-size-variation-' . $color_key . '-' . $key . ' form-control form-control-sm" value="' . $sku . '">
                                </td>
                                <td>
                                    <input type="checkbox" name="variation[' . $color_key . '-' . $key . '][preorder]" class="color-size-variation-' . $color_key . '-' . $key . ' preorder-checkbox" data-limit-class="stock-limit-' . $color_key . '-' . $key . '" value="1" ' . $preorder_status . '>
                                </td>
                                <td>
                                    <input type="text" name="variation[' . $color_key . '-' . $key . '][preorder_stock_limit]" class="color-size-variation-' . $color_key . '-' . $key . ' form-control form-control-sm preorder-stock-limit stock-limit-' . $color_key . '-' . $key . '" value="' . $preorder_stock_limit . '">
                                </td>
                            </tr>';
            }
        }



        return $response;
    }

    public function delete_gallery_image(Request $request)
    {

        $slug = $request->slug;
        $image = $request->image;

        Storage::delete("public/products/" . $slug . "/" . $image);
        Storage::delete("public/products/" . $slug . "/thumbs/medium_" . $image);
        Storage::delete("public/products/" . $slug . "/thumbs/small_" . $image);
        Storage::delete("public/products/" . $slug . "/thumbs/thumb_" . $image);

        $response = array('message' => "success");
        echo json_encode($response);
    }

    public function addColor($index)
    {
        if (request()->ajax()) {
            $colors = Color::where('display', 1)->get();
            $response = '<div class="col-md-6" id="variation-color-' . $index . '">
                <div class="row">
                    <div class="col-md-10">
                        <div class="input-group input-group-inverse">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="fa fa-eye-dropper"></i>&nbsp; Color</label>
                            </span>
                            <select name="color_ids[]" class="form-control" onchange="setVariation($(this))" div-id="' . $index . '">
                                <option selected disabled value="">-- Select Color --</option>';
            foreach ($colors as $color) {
                $response .= '<option value="' . $color->id . '">' . $color->title . '</option>';
            }
            $response .= '</select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" name="remove_color" id="' . $index . '" class="btn btn-danger btn_remove_variation_color">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>';
            return $response;
        }
    }
    
    public function export() 
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function getVariationDetails(Request $request)
    {
        if ($request->ajax()) {
            $colors = Color::whereIn('id', array($request->color))->get();
            $size_group = SizeGroup::findOrFail($request->size_group_id);
            $sizes = $size_group->sizes;

            $response = '';

            foreach ($colors as $color) {
                $color_key = rand(0, 100);
                $colorModel = ProductColor::where([['product_id', $request->product_id], ['color_id', $color->id]]);

                $colorExists = $colorModel->exists();
                $imageRequired = $colorExists ? '' : 'required';
                if ($colorExists) {
                    $product_color = $colorModel->first();
                    $product_color_image = asset('storage/products/' . $product_color->product->slug . '/variations/thumbs/thumb_' . $product_color->image);
                    $product_slug = $product_color->product->slug;
                    $product_color_id = $product_color->id;
                } else {
                    $product_color_id = 0;
                }


                $response .= '<div class="card border  mt-3" id = "variation-detail-' . $request->selection_div_id . '">
                                <div class="card-body id="color' . $color->id . '" ">
                                    <h3 class="card-title"><i class="fa fa-eye-dropper"></i> ' . $color->title . '</h3>
                                    <hr>
                                    <div class="row">
                                        <input type="hidden" name="variation[' . $color_key . '][color_id]" value="' . $color->id . '">';
                if ($colorExists) {
                    $response .= '<input type="hidden" name="variation[' . $color_key . '][id]" value="' . $product_color_id . '">';
                }
                $response .= '<div class="col-md-4">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" onchange="fileInput($(this))" name="variation[' . $color_key . '][image]" ' . $imageRequired . '>
                                        <label class="custom-file-label" for="customFile">Choose Variation Image</label>
                                    </div>
        
                                </div>';

                if ($colorExists) {
                    $response .= '<div class="col-md-4">
                                                            <img src="' . $product_color_image . '" alt="' . $product_slug . '" class="img img-thumbnail">
                                                        </div>';
                }
                $response .= '<div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-responsive">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Display</th>
                                                            <th>Size</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                            <th>Offer Price</th>
                                                            <th>SKU</th>
                                                            <th>PreOrder</th>
                                                            <th style="font-size: 10px">PreOrder Stock Limit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                foreach ($sizes as $size_key => $size) {

                    $sizeModel = ProductSize::where([['product_color_id', @$product_color_id], ['size_id', $size->id]]);
                    $sizeExists = $sizeModel->exists();

                    if ($sizeExists) {
                        $product_variation = $sizeModel->first();
                        $display_status = 'checked';
                        $quantity = $product_variation->quantity;
                        $price = $product_variation->price;
                        $offer_price = $product_variation->offer_price;
                        $sku = $product_variation->sku;
                        $preorder_status = $product_variation->preorder == 1 ? 'checked' : '';
                        $preorder_stock_limit = $product_variation->preorder_stock_limit;
                    } else {
                        $display_status = '';
                        $quantity = '';
                        $price = '';
                        $offer_price = '';
                        $sku = '';
                        $preorder_status = '';
                        $preorder_stock_limit = '';
                    }

                    $response .= '<tr class="text-center">
                                                            <th scope="row">
                                                                <input type="checkbox" name="variation[' . $color_key . '][size][' . $size_key . '][display]" data-variation-key="' . $color_key . '-' . $size_key . '" value="1" class="variation-display" ' . $display_status . '>
                                                            </th>
                                                            <td style="min-width: 100px;">
                                                                ' . $size->name . '
                                                                <input type="hidden" name="variation[' . $color_key . '][size][' . $size_key . '][size_id]" class="color-size-variation-' . $color_key . '-' . $size_key . '" value="' . $size->id . '" >
                                                            </td>
                                                            <td>
                                                                <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][quantity]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm req-not-req-' . $color_key . '-' . $size_key . '" value="' . $quantity . '">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][price]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm req-not-req-' . $color_key . '-' . $size_key . '" value="' . $price . '">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][offer_price]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm offer-price" value="' . $offer_price . '">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][sku]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm req-not-req-' . $color_key . '-' . $size_key . '" value="' . $sku . '">
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" name="variation[' . $color_key . '][size][' . $size_key . '][preorder]" class="color-size-variation-' . $color_key . '-' . $size_key . ' preorder-checkbox" data-limit-class="stock-limit-' . $color_key . '-' . $size_key . '" value="1" ' . $preorder_status . '>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="variation[' . $color_key . '][size][' . $size_key . '][preorder_stock_limit]" class="color-size-variation-' . $color_key . '-' . $size_key . ' form-control form-control-sm preorder-stock-limit stock-limit-' . $color_key . '-' . $size_key . '" value="' . $preorder_stock_limit . '">
                                                            </td>
                                                        </tr>';
                }

                $response .= '</tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
            }
            return $response;
        }
    }
}
