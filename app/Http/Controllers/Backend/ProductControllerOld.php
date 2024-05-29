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

class ProductControllerOld extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('backend.products.list-products',compact('products'));
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
        $size_guides = SizeGuide::where('display',1)->get();
        $size_groups = SizeGroup::where('display',1)->get();
        $colors = Color::where('display',1)->get();
        $product_cares = ProductCare::where('display',1)->get();
        return view('backend.products.create-update-products',compact('categories','occassions','genders', 'size_guides', 'size_groups','colors', 'product_cares'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $slug = ModelHelper::createSlug('\App\Models\Product', $request->title);

        $insertArray = array(
                             "title" => $request->title, 
                             "slug" => $slug,
                             "display" => isset($request->display) ? $request->display : 0,
                             "featured" => isset($request->featured) ? $request->featured : 0,
                             "stock_status" => $request->stock_status,
                             "category_id" => $request->category_id,
                             "price" => $request->price,
                             "offer_price" => $request->offer_price,
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
        $path = public_path().'/storage/products/'.$slug;
        $folderPath = 'public/products/'.$slug;

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath,0777,true,true);

            if (!is_dir($path."/thumbs")) {
                Storage::makeDirectory($folderPath.'/thumbs',0777,true,true);
            }

        }

        if ($request->hasFile('image')) {
                    //Add the new photo
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            // Storage::putFileAs($folderPath, new File($image), $filename);

            ModelHelper::resize_crop_images(770, 990, $image, $folderPath."/".$filename);
            ModelHelper::resize_crop_images(575, 675, $image, $folderPath."/thumbs/medium_".$filename);
            ModelHelper::resize_crop_images(385, 450, $image, $folderPath."/thumbs/small_".$filename);
            ModelHelper::resize_crop_images(100, 120, $image, $folderPath."/thumbs/thumb_".$filename);

            $insertArray['image'] = $filename;

        }

        if ($request->hasFile('other_images')) {
                    //Add the new photo
            $otherImages = $request->file('other_images');
            foreach ($otherImages as $key => $other) {

                $filename_o = time().$key.'_.'.$other->getClientOriginalExtension();
                // Storage::putFileAs($folderPath, new File($other), $filename_o);

                ModelHelper::resize_crop_images(770, 990, $other, $folderPath."/".$filename_o);
                ModelHelper::resize_crop_images(575, 675, $other, $folderPath."/thumbs/medium_".$filename_o);
                ModelHelper::resize_crop_images(385, 450, $other, $folderPath."/thumbs/small_".$filename_o);
                ModelHelper::resize_crop_images(100, 120, $other, $folderPath."/thumbs/thumb_".$filename_o);
            }

        }

        $product = Product::create($insertArray);

        if (isset($request->occassions)) {

            $occassions = $request->occassions;


            for ($i=0; $i < count($occassions); $i++) { 
                
                $product->occassion_products()->updateOrCreate(['product_id' => $product->id, 'occassion_id' => $occassions[$i]]);
            }
        }

        $variations = $request['variation'];
        foreach ($variations as $pVar) {
            $product->product_variations()->updateOrCreate([
                                                                'product_id' => $product->id, 
                                                                'color_id' => $pVar['color_id'],
                                                                'size_id' => $pVar['size_id'] 
                                                                
                                                           ],
                                                           [
                                                                'display' => isset($pVar['display']) ? $pVar['display'] : 0,
                                                                'quantity' => $pVar['quantity'],
                                                                'price' => $pVar['price'],
                                                                'offer_price' => $pVar['offer_price'],
                                                                'sku' => $pVar['sku'],
                                                                'preorder' => isset($pVar['preorder']) ? $pVar['preorder'] : 0,
                                                                'preorder_stock_limit' => isset($pVar['preorder']) ? $pVar['preorder_stock_limit'] : NULL
                                                           ]
                                                        );
        }
        // dd('success');
        return redirect()->route('admin.products.index')->with('status','New Product has been Added Successfully!');

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
        $product = Product::with('product_variations.color')->where('id',base64_decode($id))->firstOrFail();
        $color_ids = $product->product_variations()->groupBy('color_id')->get()->pluck('color_id')->all();
        $size_ids = $product->product_variations()->groupBy('size_id')->get()->pluck('size_id')->all();
        // dd($size_ids);
        $categories = ModelHelper::getFullListFromDB('categories');
        $occassions = Occassion::all();
        $genders = Product::$genders;
        $size_guides = SizeGuide::where('display',1)->get();
        $size_groups = SizeGroup::where('display',1)->get();
        $colors = Color::where('display',1)->get();
        $product_cares = ProductCare::where('display',1)->get();
        return view('backend.products.create-update-products',compact('product' ,'categories','occassions','genders', 'size_guides', 'size_groups','colors', 'product_cares'));
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
        // dd($request);
        $slug = ModelHelper::createSlug('\App\Models\Product', $request->title, $product->id);

        // dd($updateArray);
        $path = public_path().'/storage/products/'.$slug;
        $folderPath = 'public/products/'.$slug;

        if ($product->slug != $slug) {

            if (file_exists($path)) {
                Storage::move('public/products/'. $product->slug , 'public/products/'.$slug);
            }
            
            $slug = ModelHelper::createSlug('\App\Models\Product', $request->title, $product->id);
        }

        $updateArray = array(
                             "title" => $request->title, 
                             "slug" => $slug,
                             "display" => isset($request->display) ? $request->display : 0,
                             "featured" => isset($request->featured) ? $request->featured : 0,
                             "stock_status" => $request->stock_status,
                             "category_id" => $request->category_id,
                             "price" => $request->price,
                             "offer_price" => $request->offer_price,
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
        // dd($updateArray);
        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath,0777,true,true);

            if (!is_dir($path."/thumbs")) {
                Storage::makeDirectory($folderPath.'/thumbs',0777,true,true);
            }

        }

        if ($request->hasFile('image')) {
            //Add the new photo
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            // Storage::putFileAs($folderPath, new File($image), $filename);

            ModelHelper::resize_crop_images(770, 990, $image, $folderPath."/".$filename);
            ModelHelper::resize_crop_images(575, 675, $image, $folderPath."/thumbs/medium_".$filename);
            ModelHelper::resize_crop_images(385, 450, $image, $folderPath."/thumbs/small_".$filename);
            ModelHelper::resize_crop_images(100, 120, $image, $folderPath."/thumbs/thumb_".$filename);

            $updateArray['image'] = $filename;

            //Delete the old photo
            Storage::delete($folderPath ."/".$product->image);
            Storage::delete($folderPath ."/thumbs/medium_".$product->image);
            Storage::delete($folderPath ."/thumbs/small_".$product->image);
            Storage::delete($folderPath ."/thumbs/thumb_".$product->image);

        }

        if ($request->hasFile('other_images')) {
            //Add the new photo
            $otherImages = $request->file('other_images');
            foreach ($otherImages as $key => $other) {

                $filename_o = time().$key.'_.'.$other->getClientOriginalExtension();
                // Storage::putFileAs($folderPath, new File($other), $filename_o);

                ModelHelper::resize_crop_images(770, 990, $other, $folderPath."/".$filename_o);
                ModelHelper::resize_crop_images(575, 675, $other, $folderPath."/thumbs/medium_".$filename_o);
                ModelHelper::resize_crop_images(385, 450, $other, $folderPath."/thumbs/small_".$filename_o);
                ModelHelper::resize_crop_images(100, 120, $other, $folderPath."/thumbs/thumb_".$filename_o);
            }

        }

        if ($product->size_group_id != $request->size_group_id) {
            $product->product_variations()->delete();
        }

        $product_updated = $product->update($updateArray);

        if (isset($request->occassions)) {

            $occassions = $request->occassions;


            for ($i=0; $i < count($occassions); $i++) { 
                
                $product->occassion_products()->updateOrCreate(['product_id' => $product->id, 'occassion_id' => $occassions[$i]]);
                $product->occassion_products()->whereNotIn('occassion_id', $occassions)->delete();
            }
        }

        $variations = $request['variation'];
        
        foreach ($variations as $pVar) {
            $product->product_variations()->updateOrCreate([
                                                                'product_id' => $product->id, 
                                                                'color_id' => $pVar['color_id'],
                                                                'size_id' => $pVar['size_id'] 
                                                                
                                                           ],
                                                           [
                                                                'display' => isset($pVar['display']) ? $pVar['display'] : 0,
                                                                'quantity' => $pVar['quantity'],
                                                                'price' => $pVar['price'],
                                                                'offer_price' => $pVar['offer_price'],
                                                                'sku' => $pVar['sku'],
                                                                'preorder' => isset($pVar['preorder']) ? $pVar['preorder'] : 0,
                                                                'preorder_stock_limit' => isset($pVar['preorder']) ? $pVar['preorder_stock_limit'] : NULL
                                                           ]
                                                        );
        }

        $product->product_variations()->whereNotIn('color_id', $request->color_ids)->delete();
        // dd('success');
        return redirect()->route('admin.products.index')->with('status','Product Details has been Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $colors = Color::whereIn('id',$color_ids)->get();
        
        $size_group = SizeGroup::find($size_group_id);
        $sizes = $size_group->sizes;
        $response = '';

        foreach ($colors as $color_key => $color) {

            foreach ($sizes as $key => $size) {
                
                $varModel = ProductVariation::where([['product_id',$request->product_id],['color_id', $color->id],['size_id',$size->id]]);
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
                }else{
                    $display_status = '';
                    $quantity = '';
                    $price = '';
                    $offer_price = '';
                    $sku = '';
                    $preorder_status = '';
                    $preorder_stock_limit = '';
                }

                $response.='<tr class="text-center">
                                <th scope="row">
                                    <input type="checkbox" name="variation['.$color_key.'-'.$key.'][display]" data-variation-key="'.$color_key.'-'.$key.'" value="1" class="variation-display" '.$display_status.'>
                                </th>
                                <td style="min-width: 100px;">
                                    <span style="height: 12px; width: 12px; margin: 2px 2px 0 0; display:inline-block; background-color: '.$color->code.';"></span> '.$color->title.' 
                                    <input type="hidden" name="variation['.$color_key.'-'.$key.'][color_id]" class="color-size-variation-'.$color_key.'-'.$key.'" value="'.$color->id.'">
                                </td>
                                <td style="min-width: 100px;">
                                    '.$size->name.'
                                    <input type="hidden" name="variation['.$color_key.'-'.$key.'][size_id]" class="color-size-variation-'.$color_key.'-'.$key.'" value="'.$size->id.'">
                                </td>
                                <td>
                                    <input type="text" name="variation['.$color_key.'-'.$key.'][quantity]" class="color-size-variation-'.$color_key.'-'.$key.' form-control form-control-sm req-not-req-'.$color_key.'-'.$key.'" value="'.$quantity.'">
                                </td>
                                <td>
                                    <input type="text" name="variation['.$color_key.'-'.$key.'][price]" class="color-size-variation-'.$color_key.'-'.$key.' form-control form-control-sm" value="'.$price.'">
                                </td>
                                <td>
                                    <input type="text" name="variation['.$color_key.'-'.$key.'][offer_price]" class="color-size-variation-'.$color_key.'-'.$key.' form-control form-control-sm offer-price" value="'.$offer_price.'">
                                </td>
                                <td>
                                    <input type="text" name="variation['.$color_key.'-'.$key.'][sku]" class="color-size-variation-'.$color_key.'-'.$key.' form-control form-control-sm" value="'.$sku.'">
                                </td>
                                <td>
                                    <input type="checkbox" name="variation['.$color_key.'-'.$key.'][preorder]" class="color-size-variation-'.$color_key.'-'.$key.' preorder-checkbox" data-limit-class="stock-limit-'.$color_key.'-'.$key.'" value="1" '.$preorder_status.'>
                                </td>
                                <td>
                                    <input type="text" name="variation['.$color_key.'-'.$key.'][preorder_stock_limit]" class="color-size-variation-'.$color_key.'-'.$key.' form-control form-control-sm preorder-stock-limit stock-limit-'.$color_key.'-'.$key.'" value="'.$preorder_stock_limit.'">
                                </td>
                            </tr>';
            }
        }
        
        

        return $response;
    }

    public function delete_gallery_image(Request $request){

        $slug = $request->slug;
        $image = $request->image;

        Storage::delete("public/products/".$slug."/".$image);
        Storage::delete("public/products/".$slug."/thumbs/medium_".$image);
        Storage::delete("public/products/".$slug."/thumbs/small_".$image);
        Storage::delete("public/products/".$slug."/thumbs/thumb_".$image);

        $response = array('message' => "success");
        echo json_encode($response);
    }
}
