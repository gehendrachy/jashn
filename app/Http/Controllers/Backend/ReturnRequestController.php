<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestProduct;
use App\Models\DiscountCoupon;
use App\Models\AppliedCoupon;
use App\Services\ModelHelper;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $return_request_products = ReturnRequestProduct::orderBy('created_at','desc')->get();
        $return_status = ReturnRequestProduct::return_status();

        return view('backend.return-requests.list-return-requests', compact('return_request_products','return_status'));
    }

    public function show($return_request_no)
    {
        $return_request = ReturnRequest::where('return_request_no', $return_request_no)->firstOrFail();
        $return_status = ReturnRequest::return_status();

        $billing_details = json_decode($return_request->order->billing_details);
        $shipping_details = json_decode($return_request->order->shipping_details);
        
        return view('backend.return-requests.view-return-request-details', compact('return_request', 'return_status', 'billing_details', 'shipping_details'));
    }

    public function change_return_request_status(Request $request)
    {
        $return_request = ReturnRequest::where('id', $request->id)->first();
        
        $return_request->status = $request->status;
        $statusChanged = $return_request->save();

        if ($statusChanged) {
            
            $data = array('status'=> 'success');
            $return_request_products = $return_request->return_request_products()->update(['status' => $request->status]);

        }else{

            $data = array('status'=> 'error');
        }

        echo json_encode($data);

    }

    public function change_return_request_product_status(Request $request)
    {
        $return_request_product = ReturnRequestProduct::where('id', $request->id)->first();
        if ($return_request_product) {

            $return_request_product->status = $request->status;
            $statusChanged = $return_request_product->save();

            if ($statusChanged) {

                $data = array('status'=> 'success');
            }else{

                $data = array('status'=> 'error');
            }

        }else{
            $data = array('status'=> 'error');
        }

        echo json_encode($data);

    }

}
