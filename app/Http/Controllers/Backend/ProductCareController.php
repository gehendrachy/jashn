<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
use App\Http\Requests\StoreProductCareRequest;
use App\Http\Requests\UpdateProductCareRequest;

class ProductCareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('permission:product-care-list|product-care-create|product-care-edit|product-care-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:product-care-create', ['only' => ['create','store']]);
        // $this->middleware('permission:product-care-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:product-care-delete', ['only' => ['destroy']]);
        
    }

    public function index()
    {
        
        $product_cares = ProductCare::all();
        return view('backend.product-cares.list-product-cares',compact('product_cares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-cares.create-update-product-cares');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductCareRequest $request)
    {
    	// dd($request);
        $validateData = $request->validate([
            "title" => 'required|max:255',
        ]);
        
        $slug = ModelHelper::createSlug('\App\Models\ProductCare', $request->title);
        
        $insertArray = array("title" => $request->title, 
                             "slug" => $slug,
                             "display" => isset($request->display) ? $request->display : 0,
                             "description" => $request->description,
                             "created_by" => Auth::user()->name
                            );

        $path = public_path() . '/storage/product-cares/';
        $folderPath = 'public/product-cares/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);
        }

        if ($request->hasFile('image')) {

            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $folderPath = "public/product-cares/";

            ModelHelper::resize_crop_images(100, 100, $image, $folderPath . "/" . $filename);

            //Update the database
            $insertArray['image'] = $filename;

        }

        $product_care_created = ProductCare::create($insertArray);

        if ($product_care_created) {

            return redirect()->route('admin.product-cares.index')->with('status','New Product Care has been Added Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCare  $product_care
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCare $product_care)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCare  $product_care
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_care = ProductCare::find(base64_decode($id));
        return view('backend.product-cares.create-update-product-cares',compact('product_care'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCare  $product_care
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductCareRequest $request, ProductCare $product_care)
    {
        $slug = ModelHelper::createSlug('\App\Models\ProductCare', $request->title, $product_care->id);
        // dd($product_care);

        $updateArray = array(
                                "title" => $request->title, 
                                "slug" => $slug,
                                "display" => isset($request->display) ? $request->display : 0,
                                "description" => $request->description,
                                "updated_by" => Auth::user()->name,
                                "updated_at" => date('Y-m-d h:i:s')
                            );

        $path = public_path() . '/storage/product-cares/';
        $folderPath = 'public/product-cares/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);
        }

        if ($request->hasFile('image')) {

            //Add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $folderPath = "public/product-cares/";

            ModelHelper::resize_crop_images(100, 100, $image, $folderPath . "/" . $filename);

            //Update the database
            $updateArray['image'] = $filename;

            $OldFilename = $product_care->image;

            Storage::delete($folderPath ."/".$OldFilename);
        }


        $product_care_updated = $product_care->update($updateArray);

        if ($product_care_updated) {

            return redirect()->route('admin.product-cares.index')->with('status','Product Care Details has been Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCare  $product_care
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $product_care = ProductCare::where('id' , $id)->firstOrFail();

        if ($product_care) {

            $oldImage = $product_care->image;
            

            // exit();
            if ($product_care->delete()) {

                $folderPath = "public/product-cares";

                Storage::delete($folderPath ."/".$oldImage);

            }

            return redirect()->back()->with('status', 'ProductCare Deleted Successfully!');
        }

        return redirect()->back()->with('error', 'Something Went Wrong!');
    }

    public static function set_order(Request $request)
    {
        $has_child = $request['has_child'];
        $model = $request['model'];
        $list_order = $request['list_order'];

        $data = ModelHelper::set_order($list_order, $model, $has_child);
            
        echo json_encode($data);
        exit;
    }
}
