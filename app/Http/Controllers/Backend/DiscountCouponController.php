<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\DiscountCoupon;
use Validator;
use Illuminate\Validation\Rule;

class DiscountCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount_coupons = DiscountCoupon::all();
        return view('backend.discount-coupons.list-discount-coupons', compact('discount_coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.discount-coupons.create-update-discount-coupons');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:discount_coupons',
            'code' => 'required|string|max:255|unique:discount_coupons',
            'discount_type' => 'required|numeric|max:2',
            'coupon_usage' => 'required_if:discount_type,2',
            'discount_percentage' => 'required',
            "start_date" => 'required|date|after_or_equal:today',
            // "start_time" => 'required',
            "expire_date" => 'required|date|after_or_equal:start_date',
            // "expire_time" => 'required',
            'discount_on' => 'required',
            'discount_items.*' => 'sometimes'
        ],[
        	'name.unique' => 'Please use different Name.',
        	'code.unique' => 'Coupon Code is already used. Please Enter different one.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // dd($_POST);

        $createArray = [
                        'name' => $request->name,
                        'code' => $request->code,
                        'discount_type' => $request->discount_type,
                        'coupon_usage' => $request->discount_type == 1 ? 1 : $request->coupon_usage,
                        'minimum_quantity' => $request->minimum_quantity,
                        'minimum_spend' => $request->minimum_spend != '' ? $request->minimum_spend : 0,
                        'maximum_discount' => $request->maximum_discount,
                        'discount_percentage' => $request->discount_percentage,
                        'start_date' => $request->start_date,
                        // 'start_time' => $request->start_time,
                        'expire_date' => $request->expire_date,
                        // 'expire_time' => $request->expire_time,
                        'discount_on' => $request->discount_on
                    ];

        $discount_coupon_created = DiscountCoupon::create($createArray);

        if ($discount_coupon_created) {

        	if ($request->discount_on == 1) {

        		$discount_items = $request->discount_items;

        		for ($i=0; $i < count($discount_items); $i++) { 
        			
        			$discount_coupon_created->category_coupons()->updateOrCreate(['category_id' => $discount_items[$i]]);
        		}

        	}elseif ($request->discount_on == 2) {

        		$discount_items = $request->discount_items;

        		for ($i=0; $i < count($discount_items); $i++) { 
        			
        			$discount_coupon_created->product_coupons()->updateOrCreate(['product_id' => $discount_items[$i]]);
        		}

        	}
        	// dd('success');
            return redirect()->route('admin.discount-coupons.index')->with('status','Disccount Coupon Created Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
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
        $discount_coupon = DiscountCoupon::find(base64_decode($id));
        return view('backend.discount-coupons.create-update-discount-coupons',compact('discount_coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscountCoupon $discount_coupon)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191|'. Rule::unique('discount_coupons')->ignore($discount_coupon->id),
            'code' => 'required|string|max:191|'. Rule::unique('discount_coupons')->ignore($discount_coupon->id),
            'discount_type' => 'required|numeric|max:2',
            'coupon_usage' => 'required_if:discount_type,2',
            'discount_percentage' => 'required',
            "start_date" => 'required|date',
            // "start_time" => 'required',
            "expire_date" => 'required|date|after_or_equal:start_date',
            // "expire_time" => 'required',
            'discount_on' => 'required',
            'discount_items.*' => 'sometimes'
        ],[
        	'name.unique' => 'Please use different Name.',
        	'code.unique' => 'Coupon Code is already used. Please Enter different one.'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // dd($_POST);

        $updateArray = [
                        'name' => $request->name,
                        'code' => $request->code,
                        'discount_type' => $request->discount_type,
                        'coupon_usage' => $request->discount_type == 1 ? 1 : $request->coupon_usage,
                        'minimum_quantity' => $request->minimum_quantity,
                        'minimum_spend' => $request->minimum_spend != '' ? $request->minimum_spend : 0,
                        'maximum_discount' => $request->maximum_discount,
                        'discount_percentage' => $request->discount_percentage,
                        'start_date' => $request->start_date,
                        // 'start_time' => $request->start_time,
                        'expire_date' => $request->expire_date,
                        // 'expire_time' => $request->expire_time,
                        'discount_on' => $request->discount_on
                    ];

        // dd($updateArray);

        $discount_coupon_updated = $discount_coupon->update($updateArray);
        if ($discount_coupon_updated) {

        	if ($request->discount_on == 1) {

        		$discount_items = $request->discount_items;

        		for ($i=0; $i < count($discount_items); $i++) { 
        			
        			$discount_coupon->category_coupons()->updateOrCreate(['category_id' => $discount_items[$i]]);
        		}

        		$discount_coupon->category_coupons()->whereNotIn('category_id', $discount_items)->delete();

        	}elseif ($request->discount_on == 2) {

        		$discount_items = $request->discount_items;

        		for ($i=0; $i < count($discount_items); $i++) { 
        			
        			$discount_coupon->product_coupons()->updateOrCreate(['product_id' => $discount_items[$i]]);
        		}

        		$discount_coupon->product_coupons()->whereNotIn('product_id', $discount_items)->delete();

        	}else{
        		$discount_coupon->category_coupons()->delete();
        		$discount_coupon->product_coupons()->delete();
        	}

            return redirect()->route('admin.discount-coupons.index')->with('status','Disccount Coupon Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);

        $discount_coupon = DiscountCoupon::where('id' , $id)->firstOrFail();

        if ($discount_coupon) {
            if ($discount_coupon->delete()) {
                return redirect()->back()->with('status', 'Disccount Coupon Deleted Successfully!');
            }
        }

        return redirect()->back()->with('error', 'Something Went Wrong!');

    }

    public function get_discount_on_items(Request $request)
    {
        $type = $request->type;
        $items = '';
        $discount_items = [];

        if ($type == 1) {
        	
        	if ($request->discount_coupon_id != 0) {
        		$discount_coupon = DiscountCoupon::find(base64_decode($request->discount_coupon_id));
        		$discount_items = $discount_coupon->category_coupons()->pluck('category_id')->all();
        	}

            $categories = Category::where([['display',1],['child',0]])->get();
            
            foreach ($categories as $key => $category) {

                $selected_status = in_array($category->id, $discount_items) ? 'selected' : '';
                $items .= '<option '.$selected_status.' value="'.$category->id.'">'.$category->title.'</option>';

            }            

        }elseif($type == 2){

        	if ($request->discount_coupon_id != 0) {

        		$discount_coupon = DiscountCoupon::find(base64_decode($request->discount_coupon_id));
        		$discount_items = $discount_coupon->product_coupons()->pluck('product_id')->all();

        	}

            $products = Product::where('display',1)->get();

            foreach ($products as $key => $product) {
                
                $selected_status = in_array($product->id, $discount_items) ? 'selected' : '';
                $items .= '<option '.$selected_status.' value="'.$product->id.'">'.$product->title.'</option>';

            }

        }else{

        	$items .= '<option>All Products</option>';
        }

        $response = array('items' => $items);
        echo json_encode($response);
    }
}
